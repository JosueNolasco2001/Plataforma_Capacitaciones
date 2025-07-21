<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Mpdf\Mpdf;
use Carbon\Carbon;

class DiplomaController extends Controller
{
    public function generarDiploma(Request $request)
    {
        try {
            // Debug: Verificar que los datos lleguen
            
            // Solo obtener el usuario autenticado
            $usuario = Auth::user();
            
            if (!$usuario) {
                return redirect()->back()->with('error', 'Usuario no autenticado');
            }
            
            // Validar datos requeridos
            if (!$request->curso_titulo || !$request->instructor_nombre) {
                return redirect()->back()->with('error', 'Datos del curso incompletos');
            }
            
            // Recibir todos los datos desde la vista
            $dataDiploma = [
                'estudiante_nombre' => $usuario->name,
                'curso_titulo' => $request->curso_titulo,
                'instructor_nombre' => $request->instructor_nombre,
                'curso_descripcion' => $request->curso_descripcion ?? 'Curso de programación',
                'total_videos' => $request->total_videos ?? 0,
                'videos_completados' => $request->videos_completados ?? 0,
                'fecha_completado' => Carbon::now()->locale('es')->isoFormat('D [de] MMMM [de] Y'),
                'codigo_diploma' => 'DIP-' . strtoupper(substr($request->curso_titulo ?? 'CUR', 0, 3)) . '-' . $usuario->id . '-' . date('Ymd'),
                'ano_actual' => Carbon::now()->year
            ];
            
            
            // Renderizar la vista
            $html = view('diploma.template', $dataDiploma)->render();
            
            // Debug: Verificar que el HTML se genere
            
            // Configurar mPDF con configuración más básica primero
           // Configurar mPDF
            $mpdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4-L',
                'orientation' => 'L',
                'margin_left' => 5,
                'margin_right' => 5,
                'margin_top' => 5,
                'margin_bottom' => 5,
                'default_font' => 'DejaVuSans',
                'tempDir' => storage_path('app/temp')
            ]);
            
            // Escribir HTML al PDF
            $mpdf->WriteHTML($html);
            
            $nombreArchivo = 'Diploma-' . str_replace([' ', '/'], ['-', '-'], $request->curso_titulo ?? 'curso') . '-' . str_replace(' ', '-', $usuario->name) . '.pdf';
            
            
            // Generar el PDF en string
            $pdfContent = $mpdf->Output('', \Mpdf\Output\Destination::STRING_RETURN);
            
            // Retornar como descarga
            return response($pdfContent)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="' . $nombreArchivo . '"')
                ->header('Content-Length', strlen($pdfContent));
            
        } catch (\Mpdf\MpdfException $e) {
            return redirect()->back()->with('error', 'Error al generar PDF: ' . $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al generar el diploma: ' . $e->getMessage());
        }
    }
    
    public function mostrarDiploma(Request $request)
    {
        try {
            // Debug: Verificar que los datos lleguen
            
            // Solo obtener el usuario autenticado
            $usuario = Auth::user();
            
            if (!$usuario) {
                return redirect()->back()->with('error', 'Usuario no autenticado');
            }
            
            // Validar datos requeridos
            if (!$request->curso_titulo || !$request->instructor_nombre) {
                return redirect()->back()->with('error', 'Datos del curso incompletos');
            }
            
            // Recibir todos los datos desde la vista
            $dataDiploma = [
                'estudiante_nombre' => $usuario->name,
                'curso_titulo' => $request->curso_titulo,
                'instructor_nombre' => $request->instructor_nombre,
                'curso_descripcion' => $request->curso_descripcion ?? 'Curso de programación',
                'total_videos' => $request->total_videos ?? 0,
                'videos_completados' => $request->videos_completados ?? 0,
                'fecha_completado' => Carbon::now()->locale('es')->isoFormat('D [de] MMMM [de] Y'),
                'codigo_diploma' => 'DIP-' . strtoupper(substr($request->curso_titulo ?? 'CUR', 0, 3)) . '-' . $usuario->id . '-' . date('Ymd'),
                'ano_actual' => Carbon::now()->year
            ];
            
            // Renderizar la vista
            $html = view('diploma.template', $dataDiploma)->render();
            
            // Configurar mPDF
            $mpdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4-L',
                'orientation' => 'L',
                'margin_left' => 5,
                'margin_right' => 5,
                'margin_top' => 5,
                'margin_bottom' => 5,
                'default_font' => 'DejaVuSans',
                'tempDir' => storage_path('app/temp')
            ]);
            
            // Escribir HTML al PDF
            $mpdf->WriteHTML($html);
            
            // Generar el PDF en string
            $pdfContent = $mpdf->Output('', \Mpdf\Output\Destination::STRING_RETURN);
            
            // Mostrar en navegador
            return response($pdfContent)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'inline; filename="diploma.pdf"');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al mostrar el diploma: ' . $e->getMessage());
        }
    }
    
    // Método de prueba simple
    public function test()
    {
        try {
            $mpdf = new Mpdf();
            $mpdf->WriteHTML('<h1>Test PDF</h1><p>Si ves esto, mPDF funciona correctamente.</p>');
            $pdfContent = $mpdf->Output('', \Mpdf\Output\Destination::STRING_RETURN);
            
            return response($pdfContent)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'inline; filename="test.pdf"');
                
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}