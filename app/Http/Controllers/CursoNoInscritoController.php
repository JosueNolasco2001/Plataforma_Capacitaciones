<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CursoNoInscritoController extends Controller
{

    public function mostrarCursosDisponibles()
{
    $usuarioId = Auth::id();
    
    if (!$usuarioId) {
        return redirect()->route('login');
    }

    try {
        // Reutilizar la lógica del método index()
        $cursosInscritos = DB::select("
            SELECT curso_id 
            FROM inscripciones 
            WHERE usuario_id = ?
        ", [$usuarioId]);
        
        $idsInscritos = array_column($cursosInscritos, 'curso_id');
        
        if (empty($idsInscritos)) {
            $cursos = DB::select("
                SELECT c.*,
                       (SELECT COUNT(*) FROM videos WHERE curso_id = c.id) as videos_count,
                       (SELECT COUNT(*) FROM comentarios co JOIN videos v ON co.video_id = v.id WHERE v.curso_id = c.id) as comentarios_count,
                       u.name as instructor_nombre
                FROM cursos c
                JOIN users u ON c.instructor_id = u.id
            ");
        } else {
            $placeholders = implode(',', array_fill(0, count($idsInscritos), '?'));
            $cursos = DB::select("
                SELECT c.*,
                       (SELECT COUNT(*) FROM videos WHERE curso_id = c.id) as videos_count,
                       (SELECT COUNT(*) FROM comentarios co JOIN videos v ON co.video_id = v.id WHERE v.curso_id = c.id) as comentarios_count,
                       u.name as instructor_nombre
                FROM cursos c
                JOIN users u ON c.instructor_id = u.id
                WHERE c.id NOT IN ($placeholders)
            ", $idsInscritos);
        }

        return view('cursos.disponibles', compact('cursos'));
        
    } catch (\Exception $e) {
        return back()->with('error', 'Error al cargar cursos disponibles');
    }
}
    public function index()
    {
        $usuarioId = Auth::id();
        
        if (!$usuarioId) {
            return response()->json([
                'message' => 'No autorizado'
            ], 401);
        }
        
        try {
            // Obtener IDs de cursos inscritos
            $cursosInscritos = DB::select("
                SELECT curso_id 
                FROM inscripciones 
                WHERE usuario_id = ?
            ", [$usuarioId]);
            
            $idsInscritos = array_column($cursosInscritos, 'curso_id');
            
            // Si no está inscrito en ningún curso, obtener todos
            if (empty($idsInscritos)) {
                $cursos = DB::select("
                    SELECT c.*, 
                           (SELECT COUNT(*) FROM videos WHERE curso_id = c.id) as videos_count,
                           (SELECT COUNT(*) FROM comentarios co JOIN videos v ON co.video_id = v.id WHERE v.curso_id = c.id) as comentarios_count,
                           u.name as instructor_nombre
                    FROM cursos c
                    JOIN users u ON c.instructor_id = u.id
                ");
            } else {
                // Obtener cursos no inscritos
                $placeholders = implode(',', array_fill(0, count($idsInscritos), '?'));
                $cursos = DB::select("
                    SELECT c.*, 
                           (SELECT COUNT(*) FROM videos WHERE curso_id = c.id) as videos_count,
                           (SELECT COUNT(*) FROM comentarios co JOIN videos v ON co.video_id = v.id WHERE v.curso_id = c.id) as comentarios_count,
                           u.name as instructor_nombre
                    FROM cursos c
                    JOIN users u ON c.instructor_id = u.id
                    WHERE c.id NOT IN ($placeholders)
                ", $idsInscritos);
            }
            
            return response()->json([
                'data' => $cursos,
                'message' => 'Cursos disponibles obtenidos con éxito'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener cursos',
                'error' => $e->getMessage()
            ], 500);
        }
    }

public function mostrarVideos($id)
{
    $usuarioId = Auth::id();
    
    if (!$usuarioId) {
        return redirect()->route('login');
    }

    try {
        // Obtener datos del curso
        $curso = DB::selectOne("
            SELECT c.*, u.name as instructor_nombre
            FROM cursos c
            JOIN users u ON c.instructor_id = u.id
            WHERE c.id = ?
        ", [$id]);

        if (!$curso) {
            return redirect()->route('cursos.disponibles')->with('error', 'Curso no encontrado');
        }

        // Verificar si el usuario está inscrito en el curso
        $inscripcion = DB::selectOne("
            SELECT * FROM inscripciones 
            WHERE usuario_id = ? AND curso_id = ?
        ", [$usuarioId, $id]);

        $estaInscrito = !is_null($inscripcion);

        // Obtener videos del curso con estado de progreso
        $videos = DB::select("
            SELECT v.*, 
                   COALESCE(p.completado, 0) as completado,
                   p.ultima_vista
            FROM videos v
            LEFT JOIN progreso p ON v.id = p.video_id AND p.usuario_id = ?
            WHERE v.curso_id = ?
            ORDER BY v.orden ASC
        ", [$usuarioId, $id]);

        // Calcular progreso del curso
        $totalVideos = count($videos);
        $videosCompletados = 0;

        if ($estaInscrito && $totalVideos > 0) {
            foreach ($videos as $video) {
                if ($video->completado == 1) {
                    $videosCompletados++;
                }
            }
        }
        
        $porcentajeProgreso = $totalVideos > 0 ? round(($videosCompletados / $totalVideos) * 100) : 0;

        return view('cursos.videos', compact('curso', 'videos', 'porcentajeProgreso', 'estaInscrito', 'videosCompletados', 'totalVideos'));
        
    } catch (\Exception $e) {
        return redirect()->route('cursos.disponibles')->with('error', 'Error al cargar el curso');
    }
}

public function suscribirse(Request $request, $cursoId)
{
    $usuarioId = Auth::id();
    
    if (!$usuarioId) {
        return response()->json([
            'success' => false,
            'message' => 'Usuario no autenticado'
        ], 401);
    }

    try {
        // Verificar que el curso existe
        $curso = DB::selectOne("SELECT id FROM cursos WHERE id = ?", [$cursoId]);
        if (!$curso) {
            return response()->json([
                'success' => false,
                'message' => 'Curso no encontrado'
            ], 404);
        }

        // Verificar si ya está inscrito
        $inscripcionExistente = DB::selectOne("
            SELECT * FROM inscripciones 
            WHERE usuario_id = ? AND curso_id = ?
        ", [$usuarioId, $cursoId]);

        if ($inscripcionExistente) {
            return response()->json([
                'success' => false,
                'message' => 'Ya estás inscrito en este curso'
            ], 409);
        }

        // Inscribir al usuario
        DB::insert("
            INSERT INTO inscripciones (usuario_id, curso_id, fecha_inscripcion)
            VALUES (?, ?, NOW())
        ", [$usuarioId, $cursoId]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Te has suscrito exitosamente al curso'
            ]);
        }

        return redirect()->route('curso.videos', $cursoId)->with('success', 'Te has suscrito exitosamente al curso');
        
    } catch (\Exception $e) {
        
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Error al suscribirse: ' . $e->getMessage()
            ], 500);
        }
        return back()->with('error', 'Error al suscribirse al curso');
    }
}
}