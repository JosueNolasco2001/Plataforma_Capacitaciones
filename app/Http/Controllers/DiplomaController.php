<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DiplomaController extends Controller
{
    /**
     * Descargar diploma (POST - desde botón)
     */
    public function generarDiploma(Request $request)
    {
        return $this->servirDiploma($request->curso_id, 'attachment');
    }

    /**
     * Ver diploma (POST - desde botón)
     */
    public function mostrarDiploma(Request $request)
    {
        return $this->servirDiploma($request->curso_id, 'inline');
    }

    /**
     * Ver diploma (GET - URL directa)
     */
    public function verDiplomaPorCurso($cursoId)
    {
        return $this->servirDiploma($cursoId, 'inline');
    }

    /**
     * Descargar diploma (GET - URL directa)
     */
    public function descargarDiplomaPorCurso($cursoId)
    {
        return $this->servirDiploma($cursoId, 'attachment');
    }

    /**
     * Servir diploma desde storage
     */
    private function servirDiploma($cursoId, $disposition = 'inline')
    {
        $usuario = Auth::user();
        
        if (!$usuario) {
            return redirect()->back()->with('error', 'Usuario no autenticado');
        }

        // Buscar diploma existente
        $diploma = DB::selectOne("
            SELECT * FROM diplomas 
            WHERE usuario_id = ? AND curso_id = ?
        ", [$usuario->id, $cursoId]);

        if (!$diploma) {
            return redirect()->back()->with('error', 'No tienes un diploma para este curso. Asegúrate de haber completado el 100% del curso.');
        }

        if (!Storage::disk('public')->exists($diploma->ruta_archivo)) {
            return redirect()->back()->with('error', 'El archivo del diploma no existe. Por favor, recarga la página del curso para regenerarlo.');
        }

        // Servir el archivo desde storage
        $contenido = Storage::disk('public')->get($diploma->ruta_archivo);
        
        // Actualizar estado si se descarga
        if ($disposition === 'attachment') {
            DB::update("
                UPDATE diplomas 
                SET estado = 'descargado', updated_at = ? 
                WHERE id = ?
            ", [now(), $diploma->id]);
        }
        
        return response($contenido)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', $disposition . '; filename="' . $diploma->nombre_archivo . '"')
            ->header('Content-Length', strlen($contenido));
    }
}