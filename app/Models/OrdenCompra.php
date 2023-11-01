<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenCompra extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'fecha',
        'horasaprobadas', //Solicitadas
        'horasaprobadasAsignador', //
        'horasdisponibles',//uso para el desarrollador
        'estado_tarea',
        'empresa_id',//6
        'tarea_id',//7
        'clasificacion_id',//9
    ];

    public function users() {
        return $this->belongstoMany(User::class, 'orden_compra_users');
    }
    public function reportes() {
        return $this->hasMany(Reporte::class);
    }

    public function empresa() {
        return $this->belongsTo(Empresa::class,'empresa_id');
    }
    public function tare() {
        return $this->belongsTo(Tarea::class,'tarea_id');
    }
    public function clasi() {
        return $this->belongsTo(Clasificacion::class,'clasificacion_id');
    }
    
}
