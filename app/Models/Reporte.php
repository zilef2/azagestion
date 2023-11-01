<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Reporte extends Model
{
    use HasFactory;

    protected $fillable =[
        'horas',
        'fecha_reporte',
        'observaciones',
        'requiere_transporte',
        'justificacion',
        'photo',
        'aprobado',//0:recien creado | 1: diligenciado | 2:casi aceptado | 3: rechazado | 4:aprobado totalmente
        'adjunto',
        'orden_compra_id',
        'fecha_ejecucion',
        'user_id',
        'bancohoras',
        'municipio_id',
        'novedad',
        //23/05/2023
        'aprobadas'
    ];

    // public function getUrlPdf(){ return \Illuminate\Support\Facades\Storage::url($this->adjunto); }
    // public function getUrlphoto(){ return \Illuminate\Support\Facades\Storage::url($this->photo); }


    public function getPDF(){return Storage::url($this->adjunto);}

    public function getPhoto(){ return Storage::url($this->photo); }
    
    // if (app()->environment() !== 'production') {

    public function usuario() { return $this->BelongsTo(User::class,'user_id'); }

    public function muni() { return $this->belongsTo(Municipios::class,'municipio_id'); }
    public function orden() { return $this->belongsTo(OrdenCompra::class,'orden_compra_id'); }

}
