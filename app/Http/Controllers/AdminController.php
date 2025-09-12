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
            'videos.*.estado' => 'required_with:videos|boolean'
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
                        'url' => $youtubeUrl, // Ahora guarda la URL de YouTube
                        'duracion' => null,
                        'orden' => $videoData['orden'] ?? ($videosCreados + 1),
                        'estado' => $videoData['estado'] ?? false,
                        'fecha_creacion' => now()
                    ]);
                    
                    $videosCreados++;
                }
            }

            DB::commit();
            
            return redirect()->back()
                   ->with('success', "Curso creado exitosamente con {$videosCreados} videos de YouTube");

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