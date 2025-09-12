<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Examen extends Model
{
    use HasFactory;

    protected $table = 'examenes';
    
    protected $fillable = [
        'curso_id',
        'titulo',
        'descripcion',
        'configuracion',
        'preguntas',
        'estado'
    ];

    protected $casts = [
        'configuracion' => 'array',
        'preguntas' => 'array',
        'estado' => 'boolean'
    ];

    /**
     * Obtener curso por consulta directa
     */
    public function getCurso()
    {
        return DB::selectOne("SELECT * FROM cursos WHERE id = ?", [$this->curso_id]);
    }

    /**
     * Obtener intentos de un usuario específico
     */
    public function intentosUsuario($usuarioId)
    {
        return DB::select("
            SELECT * FROM intentos_examen 
            WHERE examen_id = ? AND usuario_id = ?
            ORDER BY intento_numero DESC
        ", [$this->id, $usuarioId]);
    }

    /**
     * Verificar si un usuario ya aprobó este examen
     */
    public function usuarioAprobado($usuarioId)
    {
        $intento = DB::selectOne("
            SELECT * FROM intentos_examen 
            WHERE examen_id = ? AND usuario_id = ? AND aprobado = 1
            LIMIT 1
        ", [$this->id, $usuarioId]);
        
        return !is_null($intento);
    }

    /**
     * Contar intentos realizados por un usuario
     */
    public function contarIntentosUsuario($usuarioId)
    {
        $resultado = DB::selectOne("
            SELECT COUNT(*) as total FROM intentos_examen 
            WHERE examen_id = ? AND usuario_id = ?
        ", [$this->id, $usuarioId]);
        
        return $resultado->total;
    }

    /**
     * Verificar si el usuario puede tomar el examen
     */
    public function puedeTomarExamen($usuarioId)
    {
        $intentosPermitidos = $this->configuracion['intentos_permitidos'] ?? 3;
        $intentosRealizados = $this->contarIntentosUsuario($usuarioId);
        
        return $intentosRealizados < $intentosPermitidos && !$this->usuarioAprobado($usuarioId);
    }

    /**
     * Obtener tiempo límite en minutos
     */
    public function getTiempoLimiteAttribute()
    {
        return $this->configuracion['tiempo_limite'] ?? 60;
    }

    /**
     * Obtener puntaje mínimo de aprobación
     */
    public function getPuntajeMinimoAttribute()
    {
        return $this->configuracion['puntaje_minimo_aprobacion'] ?? 70;
    }
}