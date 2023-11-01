<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historicoc extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'fecha_aprobacion',
        'horas_aprobadas',
        'estado_tarea',
        'prestador',
        'empresa',
        'tarea',
        'clasificacion',
        //'user_id',
    ];
}
