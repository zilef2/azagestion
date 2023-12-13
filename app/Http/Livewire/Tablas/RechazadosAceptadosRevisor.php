<?php

namespace App\Http\Livewire\Tablas;

use App\Models\Reporte;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class RechazadosAceptadosRevisor extends Component
{
    public $ahora,$pendientes,$completos;

    public function mount() {
        $ListaControladoresYnombreClase = (explode('\\',get_class($this)));
        $nombreC = end($ListaControladoresYnombreClase);
        Log::info('Vista:  ' . $nombreC. ' U:'.Auth::user()->name );
        
        $this->ahora = Carbon::now();
        $this->completos = Reporte::Where('aprobado',4)->count();
        $this->pendientes = Reporte::Where('aprobado',2)->count();
        /*
            aprobado = 0 no se ha diligenciado 
            aprobado = 1 se dilingencio 
            aprobado = 2 se aprobo por el revisor
            aprobado = 3 rechazo por el revisor
            aprobado = 4 aprobado por completo
         */
    }
    

    public function render() {
        return view('livewire.tablas.rechazados-aceptados-revisor');
    }
}
