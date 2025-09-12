<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class VideoController extends Controller
{
    public function show($filename)
    {
        $path = storage_path('app/private/videos/' . $filename);
    
        if (!file_exists($path)) {
            abort(404);
        }
    
        $size = filesize($path);
        $file = fopen($path, "rb");
    
        $start = 0;
        $end = $size - 1;
    
        if (isset($_SERVER['HTTP_RANGE'])) {
            $range = $_SERVER['HTTP_RANGE'];
            $range = str_replace('bytes=', '', $range);
            $range = explode('-', $range);
    
            $start = intval($range[0]);
            if (isset($range[1]) && is_numeric($range[1])) {
                $end = intval($range[1]);
            }
        }
    
        $length = $end - $start + 1;
    
        fseek($file, $start);
    
        $headers = [
            'Content-Type' => 'video/mp4',
            'Content-Length' => $length,
            'Accept-Ranges' => 'bytes',
            'Content-Range' => "bytes $start-$end/$size",
        ];
    
        return response()->stream(function () use ($file, $length) {
            $buffer = 1024 * 8;
            while (!feof($file) && $length > 0) {
                $read = ($length > $buffer) ? $buffer : $length;
                $length -= $read;
                echo fread($file, $read);
                flush();
            }
            fclose($file);
        }, 206, $headers);
    }
public function mostrar($id)
{
    $usuarioId = Auth::id();
    
    if (!$usuarioId) {
        return redirect()->route('login');
    }

    try {
        // Obtener datos del video y curso
        $video = DB::selectOne("
            SELECT v.*, c.titulo as curso_titulo, c.id as curso_id,
                   u.name as instructor_nombre
            FROM videos v
            JOIN cursos c ON v.curso_id = c.id
            JOIN users u ON c.instructor_id = u.id
            WHERE v.id = ?
        ", [$id]);

        if (!$video) {
            return redirect()->route('cursos.disponibles')->with('error', 'Video no encontrado');
        }

        // Extraer ID de YouTube
        $youtubeVideoId = $this->extractYouTubeVideoId($video->url);
        
        if (!$youtubeVideoId) {
            return back()->with('error', 'URL de YouTube inválida');
        }

        // Verificar si está inscrito en el curso
        $inscripcion = DB::selectOne("
            SELECT * FROM inscripciones 
            WHERE usuario_id = ? AND curso_id = ?
        ", [$usuarioId, $video->curso_id]);

        if (!$inscripcion) {
            return redirect()->route('curso.videos', $video->curso_id)->with('error', 'Debes estar inscrito para ver este video');
        }

        // Obtener comentarios del video
        $comentarios = DB::select("
            SELECT c.*, u.name as usuario_nombre, u.profile_photo_path
            FROM comentarios c
            JOIN users u ON c.usuario_id = u.id
            WHERE c.video_id = ?
            ORDER BY c.fecha_creacion DESC
        ", [$id]);

        foreach ($comentarios as $comentario) {
            $respuestas = DB::select("
                SELECT r.*, u.name as usuario_nombre, u.profile_photo_path
                FROM respuestas r
                JOIN users u ON r.usuario_id = u.id
                WHERE r.comentario_id = ?
                ORDER BY r.fecha_creacion ASC
            ", [$comentario->id]);
            
            $comentario->respuestas = $respuestas;
        }

        // Obtener el estado actual del progreso
        $progreso = DB::selectOne("
            SELECT completado FROM progreso 
            WHERE usuario_id = ? AND video_id = ?
        ", [$usuarioId, $id]);

        $yaVisto = $progreso ? $progreso->completado : false;

        return view('videos.mostrar', compact('video', 'comentarios', 'yaVisto', 'youtubeVideoId'));
     
    } catch (\Exception $e) {
        return back()->with('error', 'Error al cargar el video: ' . $e->getMessage());
    }
}



public function agregarComentario(Request $request, $videoId)
{
    try {
        $request->validate([
            'contenido' => 'required|string|max:1000'
        ]);

        $usuarioId = Auth::id();

        if (!$usuarioId) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no autenticado'
            ], 401);
        }

        // Verificar que el video existe
        $videoExists = DB::selectOne("SELECT id FROM videos WHERE id = ?", [$videoId]);
        if (!$videoExists) {
            return response()->json([
                'success' => false,
                'message' => 'Video no encontrado'
            ], 404);
        }

        DB::insert("
            INSERT INTO comentarios (usuario_id, video_id, contenido, fecha_creacion)
            VALUES (?, ?, ?, NOW())
        ", [$usuarioId, $videoId, $request->contenido]);

        // Obtener el comentario recién creado
        $comentario = DB::selectOne("
            SELECT c.*, u.name as usuario_nombre, u.profile_photo_path
            FROM comentarios c
            JOIN users u ON c.usuario_id = u.id
            WHERE c.usuario_id = ? AND c.video_id = ?
            ORDER BY c.fecha_creacion DESC
            LIMIT 1
        ", [$usuarioId, $videoId]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'comentario' => $comentario,
                'message' => 'Comentario agregado exitosamente'
            ]);
        }

        return redirect()->route('video.mostrar', $videoId)->with('success', 'Comentario agregado exitosamente');
        
    } catch (\Illuminate\Validation\ValidationException $e) {
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        }
        return back()->withErrors($e->errors())->withInput();
        
    } catch (\Exception $e) {
        Log::error('Error al agregar comentario: ' . $e->getMessage());
        
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor: ' . $e->getMessage(),
                'error_details' => $e->getTraceAsString()
            ], 500);
        }
        return back()->with('error', 'Error al agregar comentario: ' . $e->getMessage());
    }
}

public function agregarRespuesta(Request $request, $comentarioId)
{
    try {
        $request->validate([
            'contenido' => 'required|string|max:1000'
        ]);

        $usuarioId = Auth::id();

        if (!$usuarioId) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no autenticado'
            ], 401);
        }

        // Verificar que el comentario existe
        $comentarioExists = DB::selectOne("SELECT id FROM comentarios WHERE id = ?", [$comentarioId]);
        if (!$comentarioExists) {
            return response()->json([
                'success' => false,
                'message' => 'Comentario no encontrado'
            ], 404);
        }

        DB::insert("
            INSERT INTO respuestas (comentario_id, usuario_id, contenido, fecha_creacion)
            VALUES (?, ?, ?, NOW())
        ", [$comentarioId, $usuarioId, $request->contenido]);

        // Obtener la respuesta recién creada
        $respuesta = DB::selectOne("
            SELECT r.*, u.name as usuario_nombre, u.profile_photo_path
            FROM respuestas r
            JOIN users u ON r.usuario_id = u.id
            WHERE r.comentario_id = ? AND r.usuario_id = ?
            ORDER BY r.fecha_creacion DESC
            LIMIT 1
        ", [$comentarioId, $usuarioId]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'respuesta' => $respuesta,
                'message' => 'Respuesta agregada exitosamente'
            ]);
        }

        return back()->with('success', 'Respuesta agregada exitosamente');
        
    } catch (\Illuminate\Validation\ValidationException $e) {
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        }
        return back()->withErrors($e->errors())->withInput();
        
    } catch (\Exception $e) {
        Log::error('Error al agregar respuesta: ' . $e->getMessage());
        
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor: ' . $e->getMessage(),
                'error_details' => $e->getTraceAsString()
            ], 500);
        }
        return back()->with('error', 'Error al agregar respuesta: ' . $e->getMessage());
    }
}
public function marcarComoVisto(Request $request, $id)
{
    $usuarioId = Auth::id();

    if (!$usuarioId) {
        return response()->json([
            'success' => false,
            'message' => 'Usuario no autenticado'
        ], 401);
    }

    try {
        // Verificar que el video existe
        $video = DB::selectOne("SELECT v.*, c.id as curso_id FROM videos v JOIN cursos c ON v.curso_id = c.id WHERE v.id = ?", [$id]);
        if (!$video) {
            return response()->json([
                'success' => false,
                'message' => 'Video no encontrado'
            ], 404);
        }

        // Verificar que está inscrito en el curso
        $inscripcion = DB::selectOne("
            SELECT * FROM inscripciones 
            WHERE usuario_id = ? AND curso_id = ?
        ", [$usuarioId, $video->curso_id]);

        if (!$inscripcion) {
            return response()->json([
                'success' => false,
                'message' => 'No estás inscrito en este curso'
            ], 403);
        }

        // Marcar video como visto/completado
        DB::statement("
            INSERT INTO progreso (usuario_id, video_id, completado, ultima_vista)
            VALUES (?, ?, 1, NOW())
            ON DUPLICATE KEY UPDATE
            completado = 1, ultima_vista = NOW()
        ", [$usuarioId, $id]);

        return response()->json([
            'success' => true,
            'message' => 'Video marcado como completado'
        ]);

    } catch (\Exception $e) {
        
        return response()->json([
            'success' => false,
            'message' => 'Error interno del servidor'
        ], 500);
    }
}
// Agregar este método también al final de tu VideoController
private function extractYouTubeVideoId($url)
{
    $url = trim($url);
    $parsed = parse_url($url);
    
    if (!$parsed || !isset($parsed['host'])) {
        return null;
    }
    
    $host = strtolower($parsed['host']);
    
    if ($host === 'youtu.be') {
        return trim($parsed['path'], '/');
    } elseif (in_array($host, ['www.youtube.com', 'youtube.com', 'm.youtube.com'])) {
        if (isset($parsed['query'])) {
            parse_str($parsed['query'], $queryParams);
            return isset($queryParams['v']) ? $queryParams['v'] : null;
        }
    }
    
    return null;
}

}
