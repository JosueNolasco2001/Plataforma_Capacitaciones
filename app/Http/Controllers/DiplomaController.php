<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use Spatie\Browsershot\Browsershot;
use Carbon\Carbon;

class DiplomaController extends Controller
{
    public function generarDiploma(Request $request)
    {
        try {
            // Solo obtener el usuario autenticado
            $usuario = Auth::user();
            
            if (!$usuario) {
                return redirect()->back()->with('error', 'Usuario no autenticado');
            }
            
            // Validar datos requeridos
            if (!$request->curso_titulo || !$request->instructor_nombre) {
                return redirect()->back()->with('error', 'Datos del curso incompletos');
            }

            // Convertir logo a base64
            $logoPath = public_path('img/Logo-senacit-original.jpg');
            $logoBase64 = '';

            if (file_exists($logoPath)) {
                $logoData = file_get_contents($logoPath);
                $logoBase64 = 'data:image/jpeg;base64,' . base64_encode($logoData);
            }

            // Recibir todos los datos desde la vista
            $dataDiploma = [
                'logo_base64' => $logoBase64,
                'estudiante_nombre' => $usuario->name,
                'curso_titulo' => $request->curso_titulo,
                'instructor_nombre' => $request->instructor_nombre,
                'curso_descripcion' => $request->curso_descripcion ?? 'Curso de programación',
                'total_videos' => $request->total_videos ?? 0,
                'videos_completados' => $request->videos_completados ?? 0,
                'fecha_completado' => $this->obtenerFechaCompletadoCurso($request->curso_id),
                'codigo_diploma' => 'DIP-' . strtoupper(substr($request->curso_titulo ?? 'CUR', 0, 3)) . '-' . $usuario->id . '-' . date('Ymd'),
                'ano_actual' => Carbon::now()->year
            ];
            
            // Renderizar la vista
            $html = view('diploma.template', $dataDiploma)->render();
            
            // Generar PDF con Puppeteer
            $pdf = Browsershot::html($html)
                ->waitUntilNetworkIdle()
                ->paperSize(297, 210, 'mm')    // A4 horizontal como Canva
                ->margins(0, 0, 0, 0)          // Sin márgenes
                ->scale(1.0)                   // Escala 1:1
                ->pdf();
            
            $nombreArchivo = 'Diploma-' . str_replace([' ', '/'], ['-', '-'], $request->curso_titulo ?? 'curso') . '-' . str_replace(' ', '-', $usuario->name) . '.pdf';
            
            // Retornar como descarga
            return response($pdf)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="' . $nombreArchivo . '"')
                ->header('Content-Length', strlen($pdf));
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al generar el diploma: ' . $e->getMessage());
        }
    }
    
    public function mostrarDiploma(Request $request)
    {
        try {
            // Solo obtener el usuario autenticado
            $usuario = Auth::user();
            
            if (!$usuario) {
                return redirect()->back()->with('error', 'Usuario no autenticado');
            }
            
            // Validar datos requeridos
            if (!$request->curso_titulo || !$request->instructor_nombre) {
                return redirect()->back()->with('error', 'Datos del curso incompletos');
            }

            // Convertir logo a base64
            $logoPath = public_path('img/Logo-senacit-original.jpg');
            $logoBase64 = '';

            if (file_exists($logoPath)) {
                $logoData = file_get_contents($logoPath);
                $logoBase64 = 'data:image/jpeg;base64,' . base64_encode($logoData);
            }

            // Recibir todos los datos desde la vista
            $dataDiploma = [
                'logo_base64' => $logoBase64,
                'estudiante_nombre' => $usuario->name,
                'curso_titulo' => $request->curso_titulo,
                'instructor_nombre' => $request->instructor_nombre,
                'curso_descripcion' => $request->curso_descripcion ?? 'Curso de programación',
                'total_videos' => $request->total_videos ?? 0,
                'videos_completados' => $request->videos_completados ?? 0,
                'fecha_completado' => $this->obtenerFechaCompletadoCurso($request->curso_id),
                'codigo_diploma' => 'DIP-' . strtoupper(substr($request->curso_titulo ?? 'CUR', 0, 3)) . '-' . $usuario->id . '-' . date('Ymd'),
                'ano_actual' => Carbon::now()->year
            ];
            
            // Renderizar la vista
            $html = view('diploma.template', $dataDiploma)->render();
            
            // Generar PDF con Puppeteer
            $pdf = Browsershot::html($html)
                ->waitUntilNetworkIdle()
                ->paperSize(297, 210, 'mm')    // A4 horizontal como Canva
                ->margins(0, 0, 0, 0)          // Sin márgenes
                ->scale(1.0)                   // Escala 1:1
                ->pdf();
            
            // Mostrar en navegador
            return response($pdf)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'inline; filename="diploma.pdf"');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al mostrar el diploma: ' . $e->getMessage());
        }
    }
    
    // Método de prueba simple con Puppeteer
    public function test()
    {
        try {
            $data = [
                'titulo' => 'Test Diploma',
                'estudiante' => 'Usuario Prueba',
                'fecha' => now()->format('d/m/Y')
            ];
            
            $html = view('diploma.template', $data)->render();
            
            $pdf = Browsershot::html($html)
                ->waitUntilNetworkIdle()
                ->paperSize(297, 210, 'mm')
                ->margins(0, 0, 0, 0)
                ->scale(1.0)
                ->pdf();
                
            return response($pdf)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'inline; filename="test.pdf"');
                
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    /**
     * Obtiene la fecha en que el usuario completó todos los videos del curso
     */
    private function obtenerFechaCompletadoCurso($cursoId)
    {
        $usuario = Auth::user();
        
        // Obtener la fecha del último video completado por el usuario en este curso
        $ultimaVisualizacion = DB::table('progreso')
            ->join('videos', 'progreso.video_id', '=', 'videos.id')
            ->where('videos.curso_id', $cursoId)
            ->where('progreso.usuario_id', $usuario->id)
            ->where('progreso.completado', 1)
            ->orderBy('progreso.ultima_vista', 'desc')
            ->first();
            
        if ($ultimaVisualizacion) {
            return Carbon::parse($ultimaVisualizacion->ultima_vista)
                ->locale('es')
                ->isoFormat('D [de] MMMM [de] Y');
        }
        
        // Si no se encuentra fecha específica, usar la fecha actual como fallback
        return Carbon::now()->locale('es')->isoFormat('D [de] MMMM [de] Y');
    }
}