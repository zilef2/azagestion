<?php

namespace App\Http\Livewire\Vistas;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\OrdenCompra;
use App\Models\Reporte;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WelcomeAsignador extends Component
{
    use WithFileUploads;

    public $archivoExcel;

    public $archivoExcelSubir;
    public $nombreArchivo;

    public $NumReportesSubidos = 0;
    public $NumReportesDiligenciados = 0;
    public $NumReportesAceptados = 0;
    public $NumReportesRechazados = 0;
    public $numOrdenes = 0;

    public function mount(){
        // Artisan::call('schedule:run');
        // php artisan schedule:run

        $ListaControladoresYnombreClase = (explode('\\',get_class($this))); $nombreC = end($ListaControladoresYnombreClase);
        if(Auth::User()->is_admin > 0) {
            Log::channel('eladmin')->info('Vista:' . $nombreC. '|  U:'.Auth::user()->name.'');
        }else{
            log::info('Vista:  ' . $nombreC. '  Usuario -> '.Auth::user()->name );
        }

        //0:recien creado | 1: diligenciado | 2:aceptado parcialmente | 3: rechazado | 4: aceptado completamente
        $this->numOrdenes = OrdenCompra::count();

    }

    public function render() {
        $this->NumReportesSubidos = Reporte::Where('aprobado', 0)->get()->count();
        $this->NumReportesDiligenciados = Reporte::Where('aprobado', 1)->get()->count();
        $this->NumReportesAceptados = Reporte::Where('aprobado', 2)->get()->count();
        $this->NumReportesRechazados = Reporte::Where('aprobado', 3)->get()->count();
        
        if($this->archivoExcelSubir){
            $this->nombreArchivo = $this->archivoExcelSubir->getClientOriginalName();
        }else{
            $this->nombreArchivo = 'No hay archivo cargado';
        }
        return view('livewire.vistas.welcome-asignador');
    }
}
