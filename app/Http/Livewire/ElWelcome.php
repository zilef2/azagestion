<?php

namespace App\Http\Livewire;

use App\helpers\Myhelp;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ElWelcome extends Component
{
    use WithFileUploads;

    public $numeroEntradas = 4; //ojala un numero par
    public $contenido; //solo para admin
    public $contenidoAdmin,$contenidoAlejo;


    public function mount(){
        Myhelp::EscribirEnLog($this);

        $this->contenido = [
            // ['titulo' => 'Revisar ordenes', 'link' => ''],
            // ['titulo' => 'Revisar ordenes rechazadas', 'link' => ''],
            ['titulo' => 'Nueva orden', 'link' => 'FormNuevaOrden'],
        ];
        $this->contenidoAdmin = [
            ['titulo' => 'Nueva Clasificacion', 'link' => 'NuevClasificacion'],
            ['titulo' => 'Nueva Tarea', 'link' => 'NuevTarea'],
            ['titulo' => 'Nueva Empresa', 'link' => 'NuevEmpresa'],
            // ['titulo' => 'Nuevo Rol', 'link' => 'NuevRol'],
        ];
        $this->contenidoAlejo = [
            ['titulo' => 'archivos', 'link' => 'NuevasFunciones'],
            ['titulo' => 'asignar usuario', 'link' => 'cambiarAsignacion'],
        ];

    }

    public function render()
    {
        return view('livewire.el-welcome');
    }
}
