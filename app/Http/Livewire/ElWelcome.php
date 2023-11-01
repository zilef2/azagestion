<?php

namespace App\Http\Livewire;

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
        $ListaControladoresYnombreClase = (explode('\\',get_class($this))); $nombreC = end($ListaControladoresYnombreClase);

        if(Auth::User()->is_admin) {
            log::channel('eladmin')->info('Vista:' . $nombreC. '|  U:'.Auth::user()->name);
        }else{
            log::info('Vista:  ' . $nombreC. ' U:'.Auth::user()->name );
        }
        
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
