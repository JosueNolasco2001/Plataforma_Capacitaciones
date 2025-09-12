<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class IntentoExamen extends Model
{
    use HasFactory;

    protected $table = 'intentos_examen';

    protected $fillable = [
        'usuario_id',
        'examen_id',
        'respuestas',
        'puntaje_obtenido',
        'aprobado',
        'tiempo_empleado',
        'fecha_inicio',
        'fecha_finalizacion',
        'intento_numero',
        'estado'
    ];

    protected $casts = [
        'respuestas' => 'array',
        'puntaje_obtenido' => 'decimal:2',
        'aprobado' => 'boolean',
        'fecha_inicio' => 'datetime',
        'fecha_finalizacion' => 'datetime'
    ];

    /**
     * Obtener usuario por consulta directa
     */
    public function getUsuario()
    {
        return DB::selectOne("SELECT * FROM users WHERE id = ?", [$this->usuario_id]);
    }

    /**
     * Obtener examen por consulta directa
     */
    public function getExamen()
    {
        return DB::selectOne("SELECT * FROM examenes WHERE id = ?", [$this->examen_id]);
    }

    /**
     * Verificar si el intento está en curso
     */
    public function enCurso()
    {
        return $this->estado === 'iniciado';
    }

    /**
     * Verificar si el intento está completado
     */
    public function completado()
    {
        return $this->estado === 'completado';
    }

    /**
     * Obtener tiempo restante en segundos
     */
    public function getTiempoRestante()
    {
        if (!$this->enCurso()) {
            return 0;
        }

        $examen = $this->getExamen();
        $configuracion = json_decode($examen->configuracion, true);
        $tiempoLimite = ($configuracion['tiempo_limite'] ?? 60) * 60;
        
        $tiempoTranscurrido = Carbon::now()->diffInSeconds($this->fecha_inicio);
        
        return max(0, $tiempoLimite - $tiempoTranscurrido);
    }

    /**
     * Verificar si el tiempo se agotó
     */
    public function tiempoAgotado()
    {
        return $this->getTiempoRestante() <= 0;
    }

    /**
     * Obtener duración del intento en formato legible
     */
    public function getDuracionFormateada()
    {
        if (!$this->tiempo_empleado) {
            return 'N/A';
        }

        $minutos = floor($this->tiempo_empleado / 60);
        $segundos = $this->tiempo_empleado % 60;

        return sprintf('%02d:%02d', $minutos, $segundos);
    }

    /**
     * Obtener estado del intento con formato legible
     */
    public function getEstadoFormateado()
    {
        switch ($this->estado) {
            case 'iniciado':
                return 'En curso';
            case 'completado':
                return $this->aprobado ? 'Aprobado' : 'Reprobado';
            case 'abandonado':
                return 'Abandonado';
            default:
                return ucfirst($this->estado);
        }
    }

    /**
     * Métodos estáticos para consultas comunes
     */
    public static function aprobados($usuarioId = null)
    {
        $sql = "SELECT * FROM intentos_examen WHERE aprobado = 1";
        $params = [];
        
        if ($usuarioId) {
            $sql .= " AND usuario_id = ?";
            $params[] = $usuarioId;
        }
        
        return DB::select($sql, $params);
    }

    public static function delExamen($examenId)
    {
        return DB::select("SELECT * FROM intentos_examen WHERE examen_id = ?", [$examenId]);
    }
}