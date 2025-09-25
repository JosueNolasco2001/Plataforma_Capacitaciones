<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ExamenController extends Controller
{
    /**
     * Mostrar el examen para tomar
     */
    public function tomarExamen($id)
    {
        $usuarioId = Auth::id();
        
        // Verificar que el examen existe
        $examen = DB::selectOne("
            SELECT e.*, c.titulo as curso_titulo 
            FROM examenes e
            JOIN cursos c ON e.curso_id = c.id
            WHERE e.id = ? AND e.estado = 1
        ", [$id]);
        
        if (!$examen) {
            return redirect()->back()->with('error', 'Examen no encontrado');
        }
        
        // Verificar que el usuario está inscrito en el curso
        $inscripcion = DB::selectOne("
            SELECT * FROM inscripciones 
            WHERE usuario_id = ? AND curso_id = ?
        ", [$usuarioId, $examen->curso_id]);
        
        if (!$inscripcion) {
            return redirect()->back()->with('error', 'No estás inscrito en este curso');
        }
        
        // Verificar que completó todos los videos del curso
        $progresoCurso = DB::selectOne("
            SELECT 
                COUNT(DISTINCT v.id) as total_videos,
                COUNT(DISTINCT CASE WHEN p.completado = 1 THEN v.id END) as videos_completados
            FROM videos v
            LEFT JOIN progreso p ON v.id = p.video_id AND p.usuario_id = ?
            WHERE v.curso_id = ?
        ", [$usuarioId, $examen->curso_id]);
        
        if ($progresoCurso->videos_completados < $progresoCurso->total_videos) {
            return redirect()->back()->with('error', 'Debes completar todos los videos antes de tomar el examen');
        }
        
        // Verificar si tiene intentos disponibles
        $intentosRealizados = DB::select("
            SELECT * FROM resultados_examenes 
            WHERE usuario_id = ? AND examen_id = ? 
            ORDER BY intento DESC
        ", [$usuarioId, $id]);
        
        $numeroIntentos = count($intentosRealizados);
        
        // Verificar si ya alcanzó el máximo de intentos
        if ($numeroIntentos >= $examen->intentos_permitidos) {
            // Verificar si todos los intentos están completados
            $todosCompletados = true;
            foreach ($intentosRealizados as $intento) {
                if (!$intento->completado) {
                    $todosCompletados = false;
                    break;
                }
            }
            
            if ($todosCompletados) {
                return redirect()->route('examenes.resultado', $id)
                    ->with('error', 'Has alcanzado el número máximo de intentos permitidos');
            }
        }
        
        // Verificar si tiene un examen pendiente (sin completar)
        $examenPendiente = null;
        if ($numeroIntentos > 0) {
            $ultimoIntento = $intentosRealizados[0];
            if (!$ultimoIntento->completado) {
                return redirect()->route('examenes.continuar', $id);
            }
        }
        
        // Crear un nuevo intento
        $nuevoIntento = $numeroIntentos + 1;
        
        DB::insert("
            INSERT INTO resultados_examenes 
            (usuario_id, examen_id, calificacion, intento, completado, tiempo_inicio, created_at, updated_at)
            VALUES (?, ?, 0, ?, 0, NOW(), NOW(), NOW())
        ", [$usuarioId, $id, $nuevoIntento]);
        
        $resultadoId = DB::getPdo()->lastInsertId();
        
        // Obtener las preguntas del examen (solo verdadero/falso)
        $preguntas = DB::select("
            SELECT * FROM preguntas 
            WHERE examen_id = ? AND tipo = 'verdadero_falso'
            ORDER BY orden ASC, id ASC
        ", [$id]);
        
        if (count($preguntas) == 0) {
            return redirect()->back()->with('error', 'Este examen no tiene preguntas disponibles');
        }
        
        return view('examenes.tomar', compact('examen', 'preguntas', 'resultadoId', 'nuevoIntento'));
    }
    
    /**
     * Continuar un examen pendiente
     */
    public function continuarExamen($id)
    {
        $usuarioId = Auth::id();
        
        // Obtener el examen
        $examen = DB::selectOne("
            SELECT e.*, c.titulo as curso_titulo 
            FROM examenes e
            JOIN cursos c ON e.curso_id = c.id
            WHERE e.id = ?
        ", [$id]);
        
        if (!$examen) {
            return redirect()->back()->with('error', 'Examen no encontrado');
        }
        
        // Obtener el último intento no completado
        $resultadoPendiente = DB::selectOne("
            SELECT * FROM resultados_examenes 
            WHERE usuario_id = ? AND examen_id = ? AND completado = 0
            ORDER BY intento DESC
            LIMIT 1
        ", [$usuarioId, $id]);
        
        if (!$resultadoPendiente) {
            return redirect()->route('examenes.tomar', $id);
        }
        
        // Obtener las preguntas
        $preguntas = DB::select("
            SELECT p.* 
            FROM preguntas p
            WHERE p.examen_id = ? AND p.tipo = 'verdadero_falso'
            ORDER BY p.orden ASC, p.id ASC
        ", [$id]);
        
        // Obtener las respuestas ya guardadas (si las hay)
        $respuestasGuardadas = DB::select("
            SELECT * FROM respuestas_usuario
            WHERE resultado_examen_id = ?
        ", [$resultadoPendiente->id]);
        
        // Crear un array indexado por pregunta_id para fácil acceso
        $respuestas = [];
        foreach ($respuestasGuardadas as $respuesta) {
            $respuestas[$respuesta->pregunta_id] = $respuesta->respuesta_texto;
        }
        
        return view('examenes.tomar', [
            'examen' => $examen,
            'preguntas' => $preguntas,
            'resultadoId' => $resultadoPendiente->id,
            'nuevoIntento' => $resultadoPendiente->intento,
            'respuestasGuardadas' => $respuestas,
            'esContinuacion' => true
        ]);
    }
    
    /**
     * Guardar las respuestas del examen
     */
    public function guardarExamen(Request $request, $id)
    {
        $usuarioId = Auth::id();
        
        // Validar que existe el resultado del examen
        $resultado = DB::selectOne("
            SELECT * FROM resultados_examenes 
            WHERE id = ? AND usuario_id = ? AND completado = 0
        ", [$request->resultado_id, $usuarioId]);
        
        if (!$resultado) {
            return redirect()->back()->with('error', 'No se pudo guardar el examen');
        }
        
        // Obtener todas las preguntas del examen
        $preguntas = DB::select("
            SELECT * FROM preguntas 
            WHERE examen_id = ? AND tipo = 'verdadero_falso'
        ", [$id]);
        
        $respuestas = $request->input('respuestas', []);
        $puntosObtenidos = 0;
        $puntosTotales = 0;
        
        DB::beginTransaction();
        
        try {
            // Primero, eliminar respuestas anteriores si existen
            DB::delete("
                DELETE FROM respuestas_usuario 
                WHERE resultado_examen_id = ?
            ", [$resultado->id]);
            
            // Guardar cada respuesta
            foreach ($preguntas as $pregunta) {
                $puntosTotales += $pregunta->puntos;
                
                // Obtener la respuesta correcta de la tabla opciones_respuesta
                $respuestaCorrecta = DB::selectOne("
                    SELECT * FROM opciones_respuesta 
                    WHERE pregunta_id = ? AND es_correcta = 1
                    LIMIT 1
                ", [$pregunta->id]);
                
                $respuestaUsuario = isset($respuestas[$pregunta->id]) ? $respuestas[$pregunta->id] : null;
                
                if ($respuestaUsuario !== null) {
                    // Para verdadero/falso, comparamos la respuesta del usuario con la opción correcta
                    $esCorrecta = false;
                    if ($respuestaCorrecta) {
                        // La opción correcta debería tener "Verdadero" o "Falso" en el campo 'opcion'
                        $valorCorrecto = strtolower($respuestaCorrecta->opcion) === 'verdadero' ? 'verdadero' : 'falso';
                        $esCorrecta = ($respuestaUsuario === $valorCorrecto) ? 1 : 0;
                        
                        if ($esCorrecta) {
                            $puntosObtenidos += $pregunta->puntos;
                        }
                    }
                    
                    // Guardar la respuesta del usuario
                    DB::insert("
                        INSERT INTO respuestas_usuario 
                        (resultado_examen_id, pregunta_id, respuesta_texto, es_correcta)
                        VALUES (?, ?, ?, ?)
                    ", [$resultado->id, $pregunta->id, $respuestaUsuario, $esCorrecta]);
                }
            }
            
            // Calcular la calificación (porcentaje)
            $calificacion = $puntosTotales > 0 ? round(($puntosObtenidos / $puntosTotales) * 100, 2) : 0;
            
            // Actualizar el resultado del examen
            DB::update("
                UPDATE resultados_examenes 
                SET calificacion = ?, 
                    completado = 1, 
                    tiempo_fin = NOW(),
                    updated_at = NOW()
                WHERE id = ?
            ", [$calificacion, $resultado->id]);
            
            DB::commit();
            
            // Redirigir a la página de resultados
            return redirect()->route('examenes.resultado', $id)
                ->with('success', 'Examen completado exitosamente');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Ocurrió un error al guardar el examen: ' . $e->getMessage());
        }
    }
    
    /**
     * Ver el resultado del examen
     */
    public function verResultado($id)
    {
        $usuarioId = Auth::id();
        
        // Obtener información del examen
        $examen = DB::selectOne("
            SELECT e.*, c.titulo as curso_titulo 
            FROM examenes e
            JOIN cursos c ON e.curso_id = c.id
            WHERE e.id = ?
        ", [$id]);
        
        if (!$examen) {
            return redirect()->back()->with('error', 'Examen no encontrado');
        }
        
        // Obtener todos los intentos del usuario
        $intentos = DB::select("
            SELECT * FROM resultados_examenes 
            WHERE usuario_id = ? AND examen_id = ?
            ORDER BY intento DESC
        ", [$usuarioId, $id]);
        
        if (count($intentos) == 0) {
            return redirect()->route('examenes.tomar', $id)
                ->with('info', 'No has realizado este examen aún');
        }
        
        // Obtener el mejor intento
        $mejorIntento = DB::selectOne("
            SELECT * FROM resultados_examenes 
            WHERE usuario_id = ? AND examen_id = ? AND completado = 1
            ORDER BY calificacion DESC
            LIMIT 1
        ", [$usuarioId, $id]);
        
        // Obtener detalles del último intento completado
        $ultimoIntento = null;
        foreach ($intentos as $intento) {
            if ($intento->completado) {
                $ultimoIntento = $intento;
                break;
            }
        }
        
        if ($ultimoIntento) {
            // Obtener las preguntas y respuestas del último intento
            $preguntasConRespuestas = DB::select("
                SELECT 
                    p.*,
                    ru.respuesta_texto,
                    ru.es_correcta,
                    opr.opcion as respuesta_correcta
                FROM preguntas p
                LEFT JOIN respuestas_usuario ru ON p.id = ru.pregunta_id 
                    AND ru.resultado_examen_id = ?
                LEFT JOIN opciones_respuesta opr ON p.id = opr.pregunta_id 
                    AND opr.es_correcta = 1
                WHERE p.examen_id = ?
                ORDER BY p.orden ASC, p.id ASC
            ", [$ultimoIntento->id, $id]);
        } else {
            $preguntasConRespuestas = [];
        }
        
        // Verificar si puede tomar otro intento
        $puedeReintentar = count($intentos) < $examen->intentos_permitidos;
        $tieneIntentoPendiente = false;
        
        foreach ($intentos as $intento) {
            if (!$intento->completado) {
                $tieneIntentoPendiente = true;
                break;
            }
        }
        
        return view('examenes.resultado', compact(
            'examen',
            'intentos',
            'mejorIntento',
            'ultimoIntento',
            'preguntasConRespuestas',
            'puedeReintentar',
            'tieneIntentoPendiente'
        ));
    }
}