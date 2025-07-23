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
            'descripcion' => 'nullable|string',
            'urlImg' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'estado' => 'required|boolean',
            'videos' => 'nullable|array',
            'videos.*.titulo' => 'required_with:videos|string|max:255',
            'videos.*.archivo' => 'required_with:videos|file|mimes:mp4,avi,mov,wmv,flv|max:102400',
            'videos.*.orden' => 'nullable|integer|min:1',
            'videos.*.estado' => 'required_with:videos|boolean'
        ]);

        try {
            DB::beginTransaction();

            // Configuración de rutas explícitas
            $disco = 'public'; // Usa el disco 'public' configurado en filesystems.php
            $rutaImagenes = 'images/courses/';
            $rutaVideos = 'videos/';

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

            // Procesar videos
            $videosCreados = 0;
            if (!empty($validated['videos'])) {
                foreach ($validated['videos'] as $videoData) {
                    $nombreVideo = Str::slug($videoData['titulo']).'_'.time().'.'.$videoData['archivo']->extension();
                    
                    // Almacenamiento explícito en la ubicación correcta
                    Storage::disk($disco)->putFileAs($rutaVideos, $videoData['archivo'], $nombreVideo);

                    DB::table('videos')->insert([
                        'curso_id' => $cursoId,
                        'titulo' => $videoData['titulo'],
                        'url' => $nombreVideo,
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
                   ->with('success', "Curso creado con {$videosCreados} videos");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                   ->withInput()
                   ->with('error', 'Error: '.$e->getMessage());
        }
    }
}