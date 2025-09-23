<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Muestra el formulario para agregar nuevo curso
     */
    public function agregarVideo()
    {
        return view('admin.agregar-video');
    }

    /**
     * Almacena un nuevo curso con sus videos
     */
public function storeCourse(Request $request)
{
    $validated = $request->validate([
        'titulo' => 'required|string|max:255',
        'descripcion' => 'required|string',
        'urlImg' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'estado' => 'required|boolean',
        'videos' => 'required|array',
        'videos.*.titulo' => 'required_with:videos|string|max:255',
        'videos.*.url_youtube' => [
            'required_with:videos',
            'url',
            function ($attribute, $value, $fail) {
                if (!$this->validateYouTubeUrl($value)) {
                    $fail('La URL debe ser una URL válida de YouTube.');
                }
            },
        ],
        'videos.*.orden' => 'required|integer|min:1',
        'videos.*.estado' => 'required_with:videos|boolean',
        // Validaciones para exámenes (opcionales)
        'examenes' => 'sometimes|array',
        'examenes.*.titulo' => 'required_with:examenes|string|max:255',
        'examenes.*.descripcion' => 'nullable|string',
        'examenes.*.duracion_minutos' => 'required_with:examenes|integer|min:5|max:180',
        'examenes.*.intentos_permitidos' => 'required_with:examenes|integer|min:1|max:10',
        'examenes.*.porcentaje_aprobacion' => 'required_with:examenes|integer|min:50|max:100',
        'examenes.*.estado' => 'required_with:examenes|boolean',
        'examenes.*.orden' => 'sometimes|integer|min:0',
        'examenes.*.preguntas' => 'sometimes|array',
        'examenes.*.preguntas.*.pregunta' => 'required_with:examenes.*.preguntas|string',
        'examenes.*.preguntas.*.tipo' => 'required_with:examenes.*.preguntas|in:multiple,verdadero_falso,texto',
        'examenes.*.preguntas.*.puntos' => 'sometimes|integer|min:1|max:10',
        'examenes.*.preguntas.*.orden' => 'sometimes|integer|min:0',
        'examenes.*.preguntas.*.opciones' => 'sometimes|array',
        'examenes.*.preguntas.*.opciones.*.opcion' => 'required_with:examenes.*.preguntas.*.opciones|string'
    ]);

    try {
        DB::beginTransaction();

        // Configuración de rutas para imágenes
        $disco = 'public';
        $rutaImagenes = 'images/courses/';

        // Procesar imagen del curso
        $nombreImagen = null;
        if ($request->hasFile('urlImg')) {
            $nombreImagen = Str::slug($request->titulo).'_'.time().'.'.$request->file('urlImg')->extension();
            Storage::disk($disco)->putFileAs($rutaImagenes, $request->file('urlImg'), $nombreImagen);
        }

        // Crear el curso
        $cursoId = DB::table('cursos')->insertGetId([
            'titulo' => $validated['titulo'],
            'descripcion' => $validated['descripcion'],
            'urlImg' => $nombreImagen,
            'instructor_id' => Auth::id(),
            'estado' => $validated['estado'],
            'fecha_creacion' => now(),
            'fecha_actualizacion' => now()
        ]);

        // Procesar videos con URLs de YouTube
        $videosCreados = 0;
        if (!empty($validated['videos'])) {
            foreach ($validated['videos'] as $videoData) {
                // Validar y limpiar URL de YouTube
                $youtubeUrl = $this->validateYouTubeUrl($videoData['url_youtube']);
                
                if (!$youtubeUrl) {
                    throw new \Exception("URL de YouTube inválida: " . $videoData['url_youtube']);
                }

                DB::table('videos')->insert([
                    'curso_id' => $cursoId,
                    'titulo' => $videoData['titulo'],
                    'url' => $youtubeUrl,
                    'duracion' => null,
                    'orden' => $videoData['orden'] ?? ($videosCreados + 1),
                    'estado' => $videoData['estado'] ?? false,
                    'fecha_creacion' => now()
                ]);
                
                $videosCreados++;
            }
        }

        // PROCESAR EXÁMENES (NUEVO)
        $examenesCreados = 0;
        $preguntasCreadas = 0;
        
        if (!empty($validated['examenes'])) {
            foreach ($validated['examenes'] as $examenData) {
                // Crear examen
                $examenId = DB::table('examenes')->insertGetId([
                    'curso_id' => $cursoId,
                    'titulo' => $examenData['titulo'],
                    'descripcion' => $examenData['descripcion'] ?? null,
                    'duracion_minutos' => $examenData['duracion_minutos'],
                    'intentos_permitidos' => $examenData['intentos_permitidos'],
                    'porcentaje_aprobacion' => $examenData['porcentaje_aprobacion'],
                    'estado' => $examenData['estado'],
                    'orden' => $examenData['orden'] ?? $examenesCreados,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                
                $examenesCreados++;

                // Procesar preguntas del examen
                if (!empty($examenData['preguntas'])) {
                    foreach ($examenData['preguntas'] as $preguntaData) {
                        $preguntaId = DB::table('preguntas')->insertGetId([
                            'examen_id' => $examenId,
                            'pregunta' => $preguntaData['pregunta'],
                            'tipo' => $preguntaData['tipo'],
                            'puntos' => $preguntaData['puntos'] ?? 1,
                            'orden' => $preguntaData['orden'] ?? 0
                        ]);
                        
                        $preguntasCreadas++;

                        // Procesar opciones para preguntas de tipo multiple o verdadero/falso
                        if (in_array($preguntaData['tipo'], ['multiple', 'verdadero_falso']) && !empty($preguntaData['opciones'])) {
                            foreach ($preguntaData['opciones'] as $index => $opcionData) {
                                // Determinar si es la opción correcta
                                $esCorrecta = 0;
                                if (isset($preguntaData['opciones_correctas'])) {
                                    $esCorrecta = ($preguntaData['opciones_correctas'] == $index) ? 1 : 0;
                                }
                                
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

        DB::commit();
        
        $mensaje = "Curso creado exitosamente con {$videosCreados} videos";
        if ($examenesCreados > 0) {
            $mensaje .= " y {$examenesCreados} exámenes con {$preguntasCreadas} preguntas";
        }
        
        return redirect()->back()->with('success', $mensaje);

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()
               ->withInput()
               ->with('error', 'Error al crear curso: '.$e->getMessage());
    }
}

    /**
     * Valida y extrae ID de video de YouTube
     */
    private function validateYouTubeUrl($url)
    {
        // Patrones para diferentes formatos de URL de YouTube
        $patterns = [
            '/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([^&\n?#]+)/',
            '/youtube\.com\/watch\?.*v=([^&\n?#]+)/'
        ];
        
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                $videoId = $matches[1];
                // Retornar URL limpia en formato estándar
                return "https://www.youtube.com/watch?v=" . $videoId;
            }
        }
        
        return false; // URL no válida
    }

    /**
     * Extrae el ID del video de YouTube para usar en el player
     */
    public function getYouTubeVideoId($url)
    {
        $patterns = [
            '/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([^&\n?#]+)/',
            '/youtube\.com\/watch\?.*v=([^&\n?#]+)/',
            '/youtube\.com\/watch\?.*[&?]v=([^&\n?#]+)/' // Para URLs con parámetros adicionales
        ];
        
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }
        
        return null;
    }
}