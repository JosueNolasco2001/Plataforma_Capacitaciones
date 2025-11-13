<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Log;
class CursoNoInscritoController extends Controller
{

public function buscarCursos(Request $request)
{
    $usuarioId = Auth::id();
    
    if (!$usuarioId) {
        return redirect()->route('login');
    }

    $busqueda = $request->get('buscar', '');
    
    // Inicializar query base
    $query = DB::table('cursos as c')
        ->join('users as u', 'c.instructor_id', '=', 'u.id')
        ->leftJoin('inscripciones as i', function($join) use ($usuarioId) {
            $join->on('c.id', '=', 'i.curso_id')
                 ->where('i.usuario_id', '=', $usuarioId);
        })
        ->select([
            'c.*',
            'u.name as instructor_nombre',
            DB::raw('(SELECT COUNT(*) FROM videos WHERE curso_id = c.id) as videos_count'),
            DB::raw('(SELECT COUNT(*) FROM comentarios co JOIN videos v ON co.video_id = v.id WHERE v.curso_id = c.id) as comentarios_count'),
            DB::raw('CASE WHEN i.usuario_id IS NOT NULL THEN "inscrito" ELSE "disponible" END as estado_inscripcion')
        ])
        ->orderBy('c.titulo');

    // Si hay búsqueda, aplicar filtros
    if (!empty(trim($busqueda)) && strlen(trim($busqueda)) >= 2) {
        $query->where(function($subQuery) use ($busqueda) {
            $subQuery->where('c.titulo', 'LIKE', "%$busqueda%")
                     ->orWhere('c.descripcion', 'LIKE', "%$busqueda%")
                     ->orWhere('u.name', 'LIKE', "%$busqueda%");
        });
    } else {
        // Si no hay búsqueda, no mostrar resultados
        $query->whereRaw('1 = 0'); // Esto hace que no devuelva resultados
    }

    try {
        $cursos = $query->paginate(6)->appends($request->query());
    } catch (\Exception $e) {
        return back()->with('error', 'Error en la búsqueda: ' . $e->getMessage());
    }

    return view('buscar-video', compact('cursos', 'busqueda'));
}
public function mostrarCursosDisponibles() 
{
    $usuarioId = Auth::id();
    
    if (!$usuarioId) {
        return redirect()->route('login');
    }

    try {
        $perPage = 8; // 9 cursos por página (3x3 grid)
        
        // Obtener IDs de cursos en los que el usuario ya está inscrito
        $cursosInscritos = DB::table('inscripciones')
            ->where('usuario_id', $usuarioId)
            ->pluck('curso_id')
            ->toArray();

        // Query base para cursos disponibles (no inscritos)
        $query = DB::table('cursos as c')
            ->join('users as u', 'c.instructor_id', '=', 'u.id')
            ->select([
                'c.*',
                'u.name as instructor_nombre',
                DB::raw('(SELECT COUNT(*) FROM videos WHERE curso_id = c.id) as videos_count'),
                DB::raw('(SELECT COUNT(*) FROM comentarios co JOIN videos v ON co.video_id = v.id WHERE v.curso_id = c.id) as comentarios_count')
            ]);

        // Excluir cursos en los que ya está inscrito
        if (!empty($cursosInscritos)) {
            $query->whereNotIn('c.id', $cursosInscritos);
        }

        // Aplicar paginación
        $cursos = $query->orderBy('c.titulo')
                       ->paginate($perPage);

        return view('cursos.disponibles', compact('cursos'));
        
    } catch (\Exception $e) {
        return back()->with('error', 'Error al cargar cursos disponibles');
    }
}

// Cursos EN PROGRESO (inscritos pero no completados al 100%)
public function misCursos()
{
    $usuarioId = Auth::id();
    
    if (!$usuarioId) {
        return redirect()->route('login');
    }

    try {
        $cursos = DB::select("
            SELECT c.*,
                   (SELECT COUNT(*) FROM videos WHERE curso_id = c.id) as videos_count,
                   (SELECT COUNT(*) FROM comentarios co JOIN videos v ON co.video_id = v.id WHERE v.curso_id = c.id) as comentarios_count,
                   u.name as instructor_nombre,
                   (SELECT COUNT(*) FROM videos v 
                    JOIN progreso p ON v.id = p.video_id 
                    WHERE v.curso_id = c.id AND p.usuario_id = ? AND p.completado = 1) as videos_completados,
                   CASE 
                       WHEN (SELECT COUNT(*) FROM videos WHERE curso_id = c.id) = 0 THEN 0
                       ELSE ROUND(
                           (SELECT COUNT(*) FROM videos v 
                            JOIN progreso p ON v.id = p.video_id 
                            WHERE v.curso_id = c.id AND p.usuario_id = ? AND p.completado = 1) 
                           * 100.0 / 
                           (SELECT COUNT(*) FROM videos WHERE curso_id = c.id), 0
                       )
                   END as porcentaje_progreso
            FROM cursos c
            JOIN users u ON c.instructor_id = u.id
            JOIN inscripciones i ON c.id = i.curso_id
            WHERE i.usuario_id = ?
            HAVING porcentaje_progreso < 100
            ORDER BY i.fecha_inscripcion DESC
        ", [$usuarioId, $usuarioId, $usuarioId]);

        return view('cursos.mis-cursos', compact('cursos'));
        
    } catch (\Exception $e) {
        return back()->with('error', 'Error al cargar mis cursos');
    }
}

// Cursos COMPLETADOS (100% de videos vistos)
public function cursosCompletados()
{
    $usuarioId = Auth::id();
    
    if (!$usuarioId) {
        return redirect()->route('login');
    }

    try {
        $cursos = DB::select("
            SELECT c.*,
                   (SELECT COUNT(*) FROM videos WHERE curso_id = c.id) as videos_count,
                   (SELECT COUNT(*) FROM comentarios co JOIN videos v ON co.video_id = v.id WHERE v.curso_id = c.id) as comentarios_count,
                   u.name as instructor_nombre,
                   (SELECT COUNT(*) FROM videos v 
                    JOIN progreso p ON v.id = p.video_id 
                    WHERE v.curso_id = c.id AND p.usuario_id = ? AND p.completado = 1) as videos_completados,
                   100 as porcentaje_progreso,
                   (SELECT MAX(p.ultima_vista) FROM videos v 
                    JOIN progreso p ON v.id = p.video_id 
                    WHERE v.curso_id = c.id AND p.usuario_id = ?) as fecha_completado
            FROM cursos c
            JOIN users u ON c.instructor_id = u.id
            JOIN inscripciones i ON c.id = i.curso_id
            WHERE i.usuario_id = ?
            HAVING videos_completados = videos_count AND videos_count > 0
            ORDER BY fecha_completado DESC
        ", [$usuarioId, $usuarioId, $usuarioId]);

        return view('cursos.completados', compact('cursos'));
        
    } catch (\Exception $e) {
        return back()->with('error', 'Error al cargar cursos completados');
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
        // Obtener datos del curso (código existente)
        $curso = DB::selectOne("
            SELECT c.*, u.name as instructor_nombre
            FROM cursos c
            JOIN users u ON c.instructor_id = u.id
            WHERE c.id = ?
        ", [$id]);

        if (!$curso) {
            return redirect()->route('cursos.disponibles')->with('error', 'Curso no encontrado');
        }

        // Verificar si el usuario está inscrito en el curso (código existente)
        $inscripcion = DB::selectOne("
            SELECT * FROM inscripciones 
            WHERE usuario_id = ? AND curso_id = ?
        ", [$usuarioId, $id]);

        $estaInscrito = !is_null($inscripcion);

        // Obtener videos del curso con estado de progreso (código existente)
        $videos = DB::select("
            SELECT v.*,
                   COALESCE(p.completado, 0) as completado,
                   p.ultima_vista
            FROM videos v
            LEFT JOIN progreso p ON v.id = p.video_id AND p.usuario_id = ?
            WHERE v.curso_id = ?
            ORDER BY v.orden ASC
        ", [$usuarioId, $id]);

        // Calcular progreso del curso (código existente)
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

        // *** NUEVO: Verificar si hay examen para este curso y si puede realizarlo ***
        $examenCurso = DB::selectOne("
            SELECT * FROM examenes 
            WHERE curso_id = ? AND estado = 1
            ORDER BY orden ASC 
            LIMIT 1
        ", [$id]);

        $puedeRealizarExamen = false;
        $tieneExamenPendiente = false;
        $mejorCalificacion = 0;

        if ($examenCurso && $estaInscrito) {
            // Verificar si completó todos los videos
            $puedeRealizarExamen = ($videosCompletados >= $totalVideos);
            
            // Verificar intentos previos
            $resultadosExamen = DB::select("
                SELECT * FROM resultados_examenes 
                WHERE usuario_id = ? AND examen_id = ?
                ORDER BY intento DESC
            ", [$usuarioId, $examenCurso->id]);

            if (count($resultadosExamen) > 0) {
                // Obtener la mejor calificación
                $mejorCalificacion = max(array_column($resultadosExamen, 'calificacion'));
                
                // Verificar si tiene intentos disponibles
                $ultimoIntento = $resultadosExamen[0];
                $tieneExamenPendiente = ($ultimoIntento->completado == 0);
            }
        }

        // *** Lógica existente del diploma ***
        $diplomaGenerado = false;
        if ($porcentajeProgreso == 100 && $estaInscrito) {
            $diplomaGenerado = $this->generarDiplomaAutomatico($curso, $totalVideos, $videosCompletados, $usuarioId);
        }

        return view('cursos.videos', compact(
            'curso', 
            'videos', 
            'porcentajeProgreso', 
            'estaInscrito', 
            'videosCompletados', 
            'totalVideos',
            'diplomaGenerado',
            // Nuevas variables para el examen
            'examenCurso',
            'puedeRealizarExamen',
            'tieneExamenPendiente',
            'mejorCalificacion'
        ));

    } catch (\Exception $e) {
        return redirect()->route('cursos.disponibles')->with('error', 'Error al cargar el curso');
    }
}

/**
 * Obtener fecha de completado para MOSTRAR (formato español)
 */
private function obtenerFechaCompletadoFormateada($cursoId, $usuarioId)
{
    $ultimaVisualizacion = DB::selectOne("
        SELECT p.ultima_vista
        FROM progreso p
        JOIN videos v ON p.video_id = v.id
        WHERE v.curso_id = ? AND p.usuario_id = ? AND p.completado = 1
        ORDER BY p.ultima_vista DESC
        LIMIT 1
    ", [$cursoId, $usuarioId]);
        
    if ($ultimaVisualizacion) {
        // Retorna formato bonito: "1 de agosto del 2025"
        return \Carbon\Carbon::parse($ultimaVisualizacion->ultima_vista)
            ->locale('es')
            ->isoFormat('D [de] MMMM [del] Y');
    }
    
    // Si no encuentra nada, usa la fecha actual formateada
    return \Carbon\Carbon::now()
        ->locale('es')
        ->isoFormat('D [de] MMMM [del] Y');
}

/**
 * Generar diploma automáticamente si no existe
 */
private function generarDiplomaAutomatico($curso, $totalVideos, $videosCompletados, $usuarioId)
{
    Log::info("=== INICIO GENERACIÓN DIPLOMA ===", [
        'usuario_id' => $usuarioId,
        'curso_id' => $curso->id,
    ]);

    $diplomaExistente = DB::selectOne("
        SELECT * FROM diplomas 
        WHERE usuario_id = ? AND curso_id = ?
    ", [$usuarioId, $curso->id]);

    if ($diplomaExistente && Storage::disk('public')->exists($diplomaExistente->ruta_archivo)) {
        Log::info("Diploma ya existe");
        return true;
    }
      $logoAbsolutePath = public_path('img/logo-senacit-diploma.png');
        
        Log::info("Ruta absoluta del logo", [
            'ruta' => $logoAbsolutePath,
            'existe' => file_exists($logoAbsolutePath)
        ]);
        
 
    try {
        DB::beginTransaction();
        
        $codigoDiploma = $this->generarCodigoDiploma($curso->id, $usuarioId);
        
        $datosParaTemplate = [
            'estudiante_nombre' => Auth::user()->name,
            'curso_titulo' => $curso->titulo,
            'instructor_nombre' => $curso->instructor_nombre ?? 'Instructor del Curso',
            'fecha_completado' => $this->obtenerFechaCompletadoFormateada($curso->id, $usuarioId),
            'codigo_diploma' => $codigoDiploma,
            'logo_path' => $logoAbsolutePath,
    
      
        ];
        
        Log::info("Generando PDF vertical");
        
        // CONFIGURACIÓN VERTICAL (portrait) - MÁS ESTABLE
   $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('diploma.template', $datosParaTemplate)
            ->setPaper('a4', 'portrait') // VERTICAL
            ->setOption('isRemoteEnabled', true);
        $pdfContent = $pdf->output();
        
        Log::info("PDF generado", ['size' => strlen($pdfContent)]);

        $nombreArchivo = $this->generarNombreArchivo($curso->titulo, Auth::user()->name, $codigoDiploma);
        $rutaArchivo = 'diplomas/' . $usuarioId . '/' . $nombreArchivo;
        
        Storage::disk('public')->put($rutaArchivo, $pdfContent);
        
        if ($diplomaExistente) {
            DB::update("
                UPDATE diplomas 
                SET ruta_archivo = ?, nombre_archivo = ?, codigo_diploma = ?, 
                    datos_curso = ?, updated_at = ?
                WHERE id = ?
            ", [
                $rutaArchivo, 
                $nombreArchivo, 
                $codigoDiploma,
                json_encode([
                    'titulo' => $curso->titulo,
                    'instructor_nombre' => $curso->instructor_nombre,
                    'total_videos' => $totalVideos,
                    'videos_completados' => $videosCompletados
                ]),
                now(),
                $diplomaExistente->id
            ]);
        } else {
            DB::insert("
                INSERT INTO diplomas (usuario_id, curso_id, codigo_diploma, ruta_archivo, 
                                    nombre_archivo, fecha_completado, datos_curso, estado, 
                                    created_at, updated_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ", [
                $usuarioId,
                $curso->id,
                $codigoDiploma,
                $rutaArchivo,
                $nombreArchivo,
                $this->obtenerFechaCompletado($curso->id, $usuarioId),
                json_encode([
                    'titulo' => $curso->titulo,
                    'instructor_nombre' => $curso->instructor_nombre,
                    'total_videos' => $totalVideos,
                    'videos_completados' => $videosCompletados
                ]),
                'generado',
                now(),
                now()
            ]);
        }

        DB::commit();
        Log::info("Diploma generado exitosamente");
        return true;
        
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error("ERROR al generar diploma", [
            'error' => $e->getMessage(),
        ]);
        
        if (isset($rutaArchivo) && Storage::disk('public')->exists($rutaArchivo)) {
            Storage::disk('public')->delete($rutaArchivo);
        }
        
        return false;
    }
}

/**
 * Obtener logo en base64
 */
private function obtenerLogoBase64()
{
    $logoPath = public_path('img/Logo-senacit-original.jpg');
    if (file_exists($logoPath)) {
        $logoData = file_get_contents($logoPath);
        return 'data:image/jpeg;base64,' . base64_encode($logoData);
    }
    return '';
}

/**
 * Generar código único del diploma
 */
private function generarCodigoDiploma($cursoId, $usuarioId)
{
    $fecha = date('Ymd');
    $base = 'DIP-' . str_pad($cursoId, 3, '0', STR_PAD_LEFT) . '-' . str_pad($usuarioId, 4, '0', STR_PAD_LEFT) . '-' . $fecha;
    
    $contador = 1;
    $codigo = $base;
    
    while (DB::selectOne("SELECT id FROM diplomas WHERE codigo_diploma = ?", [$codigo])) {
        $codigo = $base . '-' . str_pad($contador, 2, '0', STR_PAD_LEFT);
        $contador++;
    }
    
    return $codigo;
}

/**
 * Generar nombre del archivo
 */
private function generarNombreArchivo($cursoTitulo, $nombreUsuario, $codigo)
{
    $cursoLimpio = preg_replace('/[^a-zA-Z0-9\s]/', '', $cursoTitulo);
    $cursoLimpio = str_replace([' ', '/'], ['-', '-'], $cursoLimpio);
    $cursoLimpio = substr($cursoLimpio, 0, 50);
    
    $nombreLimpio = preg_replace('/[^a-zA-Z0-9\s]/', '', $nombreUsuario);
    $nombreLimpio = str_replace(' ', '-', $nombreLimpio);
    $nombreLimpio = substr($nombreLimpio, 0, 30);
    
    return 'Diploma-' . $cursoLimpio . '-' . $nombreLimpio . '-' . $codigo . '.pdf';
}

/**
 * Obtener fecha de completado del curso
 */
/**
 * Modificar este método en tu controlador para retornar la fecha formateada
 */
/**
 * Obtener fecha de completado para BASE DE DATOS (formato Y-m-d)
 */
private function obtenerFechaCompletado($cursoId, $usuarioId)
{
    $ultimaVisualizacion = DB::selectOne("
        SELECT p.ultima_vista
        FROM progreso p
        JOIN videos v ON p.video_id = v.id
        WHERE v.curso_id = ? AND p.usuario_id = ? AND p.completado = 1
        ORDER BY p.ultima_vista DESC
        LIMIT 1
    ", [$cursoId, $usuarioId]);
        
    if ($ultimaVisualizacion) {
        // Retorna formato de BD: 2025-08-01
        return \Carbon\Carbon::parse($ultimaVisualizacion->ultima_vista)->format('Y-m-d');
    }
    
    // Si no encuentra nada, usa la fecha actual en formato BD
    return \Carbon\Carbon::now()->format('Y-m-d');
}

// Entonces en tu template solo usas:
// {{ $fecha_completado }}
// Y ya sale: "5 de noviembre del 2025"

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