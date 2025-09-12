<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ExamenController extends Controller
{
    /**
     * Verificar si puede tomar el examen
     */
    public function verificarAcceso($cursoId)
    {
        $usuarioId = Auth::id();
        
        // Verificar que esté inscrito al curso
        $inscrito = DB::selectOne("
            SELECT * FROM inscripciones 
            WHERE usuario_id = ? AND curso_id = ?
        ", [$usuarioId, $cursoId]);
        
        if (!$inscrito) {
            return false;
        }
        
        // Verificar que haya completado el 100% del curso
        $progreso = $this->calcularProgresoCurso($usuarioId, $cursoId);
        
        return $progreso >= 100;
    }
    
    /**
     * Calcular progreso del curso
     */
    private function calcularProgresoCurso($usuarioId, $cursoId)
    {
        $videos = DB::select("
            SELECT v.id, COALESCE(p.completado, 0) as completado
            FROM videos v
            LEFT JOIN progreso p ON v.id = p.video_id AND p.usuario_id = ?
            WHERE v.curso_id = ?
        ", [$usuarioId, $cursoId]);
        
        $totalVideos = count($videos);
        $videosCompletados = 0;
        
        foreach ($videos as $video) {
            if ($video->completado == 1) {
                $videosCompletados++;
            }
        }
        
        return $totalVideos > 0 ? round(($videosCompletados / $totalVideos) * 100) : 0;
    }
    
    /**
     * Mostrar página del examen
     */
    public function iniciar($cursoId)
    {
        $usuarioId = Auth::id();
        
        if (!$this->verificarAcceso($cursoId)) {
            return redirect()->back()->with('error', 'Debes completar todo el curso antes de tomar el examen');
        }
        
        // Obtener el examen del curso
        $examen = DB::selectOne("
            SELECT * FROM examenes 
            WHERE curso_id = ? AND estado = 1
        ", [$cursoId]);
        
        if (!$examen) {
            return redirect()->back()->with('error', 'No hay examen disponible para este curso');
        }
        
        // Verificar intentos previos
        $intentosRealizados = DB::select("
            SELECT * FROM intentos_examen 
            WHERE usuario_id = ? AND examen_id = ?
            ORDER BY intento_numero DESC
        ", [$usuarioId, $examen->id]);
        
        $configuracion = json_decode($examen->configuracion, true);
        $intentosPermitidos = $configuracion['intentos_permitidos'] ?? 3;
        
        // Verificar si ya está aprobado
        $yaAprobado = false;
        foreach ($intentosRealizados as $intento) {
            if ($intento->aprobado == 1) {
                $yaAprobado = true;
                break;
            }
        }
        
        if ($yaAprobado) {
            return redirect()->back()->with('success', 'Ya has aprobado este examen');
        }
        
        if (count($intentosRealizados) >= $intentosPermitidos) {
            return redirect()->back()->with('error', 'Has agotado todos los intentos para este examen');
        }
        
        // Obtener curso info
        $curso = DB::selectOne("SELECT * FROM cursos WHERE id = ?", [$cursoId]);
        
        return view('examenes.iniciar', compact('examen', 'curso', 'intentosRealizados', 'intentosPermitidos'));
    }
    
    /**
     * Procesar inicio del examen
     */
    public function comenzar(Request $request, $cursoId)
    {
        $usuarioId = Auth::id();
        
        if (!$this->verificarAcceso($cursoId)) {
            return response()->json(['success' => false, 'message' => 'Acceso denegado']);
        }
        
        $examen = DB::selectOne("
            SELECT * FROM examenes 
            WHERE curso_id = ? AND estado = 1
        ", [$cursoId]);
        
        if (!$examen) {
            return response()->json(['success' => false, 'message' => 'Examen no encontrado']);
        }
        
        // Crear nuevo intento
        $intentosRealizados = DB::select("
            SELECT COUNT(*) as total FROM intentos_examen 
            WHERE usuario_id = ? AND examen_id = ?
        ", [$usuarioId, $examen->id])[0]->total;
        
        $intentoId = DB::table('intentos_examen')->insertGetId([
            'usuario_id' => $usuarioId,
            'examen_id' => $examen->id,
            'respuestas' => json_encode([]),
            'fecha_inicio' => Carbon::now(),
            'intento_numero' => $intentosRealizados + 1,
            'estado' => 'iniciado',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        
        return response()->json(['success' => true, 'intento_id' => $intentoId]);
    }
    
    /**
     * Mostrar el examen en curso
     */
    public function mostrar($cursoId, $intentoId)
    {
        $usuarioId = Auth::id();
        
        $intento = DB::selectOne("
            SELECT * FROM intentos_examen 
            WHERE id = ? AND usuario_id = ? AND estado = 'iniciado'
        ", [$intentoId, $usuarioId]);
        
        if (!$intento) {
            return redirect()->route('examen.iniciar', $cursoId)->with('error', 'Intento no válido');
        }
        
        $examen = DB::selectOne("SELECT * FROM examenes WHERE id = ?", [$intento->examen_id]);
        $curso = DB::selectOne("SELECT * FROM cursos WHERE id = ?", [$cursoId]);
        
        $preguntas = json_decode($examen->preguntas, true);
        $configuracion = json_decode($examen->configuracion, true);
        
        return view('examenes.mostrar', compact('examen', 'curso', 'intento', 'preguntas', 'configuracion'));
    }
    
    /**
     * Procesar respuestas del examen
     */
    public function enviar(Request $request, $cursoId, $intentoId)
    {
        $usuarioId = Auth::id();
        
        $intento = DB::selectOne("
            SELECT * FROM intentos_examen 
            WHERE id = ? AND usuario_id = ? AND estado = 'iniciado'
        ", [$intentoId, $usuarioId]);
        
        if (!$intento) {
            return response()->json(['success' => false, 'message' => 'Intento no válido']);
        }
        
        $examen = DB::selectOne("SELECT * FROM examenes WHERE id = ?", [$intento->examen_id]);
        $preguntas = json_decode($examen->preguntas, true);
        $configuracion = json_decode($examen->configuracion, true);
        
        $respuestas = $request->input('respuestas', []);
        $puntajeTotal = 0;
        $puntajeObtenido = 0;
        
        // Calcular puntaje
        foreach ($preguntas as $pregunta) {
            $puntajeTotal += $pregunta['puntaje'];
            
            if (isset($respuestas[$pregunta['id']])) {
                $respuestaUsuario = $respuestas[$pregunta['id']];
                $respuestaCorrecta = $pregunta['respuesta_correcta'];
                
                if ($pregunta['tipo'] === 'verdadero_falso') {
                    if (($respuestaUsuario === 'true' && $respuestaCorrecta === true) || 
                        ($respuestaUsuario === 'false' && $respuestaCorrecta === false)) {
                        $puntajeObtenido += $pregunta['puntaje'];
                    }
                } elseif ($pregunta['tipo'] === 'multiple_choice') {
                    if ((int)$respuestaUsuario === (int)$respuestaCorrecta) {
                        $puntajeObtenido += $pregunta['puntaje'];
                    }
                }
            }
        }
        
        $porcentaje = $puntajeTotal > 0 ? round(($puntajeObtenido / $puntajeTotal) * 100, 2) : 0;
        $puntajeMinimo = $configuracion['puntaje_minimo_aprobacion'] ?? 70;
        $aprobado = $porcentaje >= $puntajeMinimo;
        
        // Actualizar intento
        DB::table('intentos_examen')
            ->where('id', $intentoId)
            ->update([
                'respuestas' => json_encode($respuestas),
                'puntaje_obtenido' => $porcentaje,
                'aprobado' => $aprobado,
                'tiempo_empleado' => Carbon::now()->diffInSeconds($intento->fecha_inicio),
                'fecha_finalizacion' => Carbon::now(),
                'estado' => 'completado',
                'updated_at' => Carbon::now()
            ]);
        
        return response()->json([
            'success' => true,
            'aprobado' => $aprobado,
            'puntaje' => $porcentaje,
            'puntaje_minimo' => $puntajeMinimo
        ]);
    }
    
    /**
     * Mostrar resultados del examen
     */
    public function resultado($cursoId, $intentoId)
    {
        $usuarioId = Auth::id();
        
        $intento = DB::selectOne("
            SELECT * FROM intentos_examen 
            WHERE id = ? AND usuario_id = ?
        ", [$intentoId, $usuarioId]);
        
        if (!$intento) {
            return redirect()->route('cursos.mostrar', $cursoId);
        }
        
        $examen = DB::selectOne("SELECT * FROM examenes WHERE id = ?", [$intento->examen_id]);
        $curso = DB::selectOne("SELECT * FROM cursos WHERE id = ?", [$cursoId]);
        
        return view('examenes.resultado', compact('intento', 'examen', 'curso'));
    }
}