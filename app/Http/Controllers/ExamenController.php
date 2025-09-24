<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{
    public function storeCourse(Request $request)
    {
        DB::beginTransaction();
        
        try {
            // Validación básica
            $request->validate([
                'titulo' => 'required|string|max:255',
                'descripcion' => 'required|string',
                'urlImg' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'estado' => 'required|in:0,1'
            ]);
            
            // Guardar imagen
            $imagePath = $request->file('urlImg')->store('course_images', 'public');
            
            // Crear curso
            $cursoId = DB::table('cursos')->insertGetId([
                'titulo' => $request->titulo,
                'descripcion' => $request->descripcion,
                'urlImg' => $imagePath,
                'instructor_id' => Auth::id(),
                'estado' => $request->estado,
                'fecha_creacion' => now(),
                'fecha_actualizacion' => now()
            ]);
            
            // Guardar videos
            if ($request->has('videos')) {
                foreach ($request->videos as $videoData) {
                    DB::table('videos')->insert([
                        'curso_id' => $cursoId,
                        'titulo' => $videoData['titulo'],
                        'url' => $videoData['url_youtube'],
                        'orden' => $videoData['orden'] ?? 1,
                        'estado' => $videoData['estado'] ?? 0,
                        'fecha_creacion' => now()
                    ]);
                }
            }
            
            // Guardar exámenes con preguntas verdadero/falso
            if ($request->has('examenes')) {
                foreach ($request->examenes as $examenData) {
                    $examenId = DB::table('examenes')->insertGetId([
                        'curso_id' => $cursoId,
                        'titulo' => $examenData['titulo'],
                        'descripcion' => $examenData['descripcion'] ?? null,
                        'duracion_minutos' => $examenData['duracion_minutos'] ?? 30,
                        'intentos_permitidos' => $examenData['intentos_permitidos'] ?? 1,
                        'porcentaje_aprobacion' => $examenData['porcentaje_aprobacion'] ?? 70,
                        'estado' => $examenData['estado'] ?? 1,
                        'orden' => $examenData['orden'] ?? 1,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                    
                  // Guardar preguntas verdadero/falso
if (isset($examenData['preguntas'])) {
    foreach ($examenData['preguntas'] as $preguntaData) {
        $preguntaId = DB::table('preguntas')->insertGetId([
            'examen_id' => $examenId,
            'pregunta' => $preguntaData['pregunta'],
            'tipo' => 'verdadero_falso', // Siempre verdadero/falso
            'puntos' => $preguntaData['puntos'] ?? 1,
            'orden' => 0
        ]);
        
        // Guardar opciones de respuesta (Verdadero y Falso)
    // Guardar preguntas verdadero/falso
if (isset($examenData['preguntas'])) {
    foreach ($examenData['preguntas'] as $preguntaData) {
        $preguntaId = DB::table('preguntas')->insertGetId([
            'examen_id' => $examenId,
            'pregunta' => $preguntaData['pregunta'],
            'tipo' => 'verdadero_falso', // Siempre verdadero/falso
            'puntos' => $preguntaData['puntos'] ?? 1,
            'orden' => 0
        ]);
        
// Guardar preguntas verdadero/falso
if (isset($examenData['preguntas'])) {
    foreach ($examenData['preguntas'] as $preguntaIndex => $preguntaData) {
        // DEBUG: Ver toda la estructura de la pregunta
        Log::info("=== PREGUNTA {$preguntaIndex} ===");
        Log::info("Estructura completa:", $preguntaData);
        Log::info("Opción correcta raw:", $preguntaData['opcion_correcta'] ?? 'NO EXISTE');
        Log::info("Tipo de opcion_correcta:", gettype($preguntaData['opcion_correcta'] ?? null));
        
        $preguntaId = DB::table('preguntas')->insertGetId([
            'examen_id' => $examenId,
            'pregunta' => $preguntaData['pregunta'],
            'tipo' => 'verdadero_falso',
            'puntos' => $preguntaData['puntos'] ?? 1,
            'orden' => 0
        ]);
        
        // Guardar opciones de respuesta (Verdadero y Falso)
        if (isset($preguntaData['opciones'])) {
            Log::info("Opciones encontradas:", $preguntaData['opciones']);
            
            foreach ($preguntaData['opciones'] as $index => $opcionData) {
                Log::info("--- Opción {$index} ---");
                Log::info("Datos de opción:", $opcionData);
                Log::info("Texto opción:", $opcionData['opcion']);
                
                $esCorrecta = 0;
                
                // Determinar si esta opción es la correcta
                if (isset($preguntaData['opcion_correcta'])) {
                    $opcionCorrectaValue = $preguntaData['opcion_correcta'];
                    $valorOpcionActual = ($index == 0) ? 'verdadero' : 'falso';
                    
                    Log::info("Comparando:");
                    Log::info("- Valor opción actual: '{$valorOpcionActual}'");
                    Log::info("- Opción correcta del form: '{$opcionCorrectaValue}'");
                    Log::info("- Son iguales (===): " . ($valorOpcionActual === $opcionCorrectaValue ? 'SÍ' : 'NO'));
                    Log::info("- Son iguales (==): " . ($valorOpcionActual == $opcionCorrectaValue ? 'SÍ' : 'NO'));
                    
                    $esCorrecta = ($valorOpcionActual === $opcionCorrectaValue) ? 1 : 0;
                }
                
                Log::info("Es correcta final: {$esCorrecta}");
                
                DB::table('opciones_respuesta')->insert([
                    'pregunta_id' => $preguntaId,
                    'opcion' => $opcionData['opcion'],
                    'es_correcta' => $esCorrecta,
                    'orden' => $index
                ]);
            }
        }
    }
}
    }
}
    }
}
                }
            }
            
            DB::commit();
            
            return redirect()->back()->with('success', 'Curso creado exitosamente');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al crear el curso: ' . $e->getMessage());
        }
    }
}