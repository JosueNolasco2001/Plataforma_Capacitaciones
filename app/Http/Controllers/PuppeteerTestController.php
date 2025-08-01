<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;

class PuppeteerTestController extends Controller
{
    public function test()
    {
        try {
            $data = [
                'titulo' => 'Mi Diploma de Prueba',
                'estudiante' => 'Juan Pérez',
                'fecha' => now()->format('d/m/Y')
            ];
            
            $html = view('diploma.template', $data)->render();
            
            $pdf = Browsershot::html($html)
                ->waitUntilNetworkIdle()
                ->paperSize(297, 210, 'mm')    // ← Exactamente como tu Canva
                ->margins(0, 0, 0, 0)          // ← Sin márgenes como Canva
                ->scale(1.0)                   // ← Escala 1:1
                ->pdf();
                
            return response($pdf)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'inline; filename="diploma.pdf"');
                
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
}