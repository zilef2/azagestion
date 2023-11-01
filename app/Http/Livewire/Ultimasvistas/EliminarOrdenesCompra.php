<?php

namespace App\Http\Livewire\Ultimasvistas;

use App\Models\OrdenCompra;
use App\Models\Reporte;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class EliminarOrdenesCompra extends Component {
    use WithPagination;
    public $usuarios,$TodosLosRoles,$searchTerm = ''; //array of objects

    public $perPage = 10;
    public $currentPage = 1;

    public $rolSeleccionado,$adminSeleccionado; //valores inputs

    public function mount(){
        $ListaControladoresYnombreClase = (explode('\\',get_class($this))); $nombreC = end($ListaControladoresYnombreClase);
        if(Auth::User()->is_admin > 0) {
            log::channel('eladmin')->info('Vista:' . $nombreC. '|  U:'.Auth::user()->name.'');
        }else{
            log::info('Vista:  ' . $nombreC. '  Usuario -> '.Auth::user()->name );
        }
    }


    public function setPage($page) {
        $this->currentPage = $page;
        $this->emit('pageChanged', $page);
    }

    public function eliminarUser($id) {
        $resultado = Reporte::Find($id);

        $ListaControladoresYnombreClase = (explode('\\',get_class($this))); $nombreC = end($ListaControladoresYnombreClase);
        log::info('En ' . $nombreC. ' U -> '.Auth::user()->name. ' intenta eliminar la orden '.$resultado->id );
        session()->flash('message', 'Reporte borrado correctamente');

        try {
            $ordenAsociada = OrdenCompra::find($resultado->orden_compra_id);
            $ordenAsociada->update([
                'horasdisponibles' => doubleval( $ordenAsociada->horasdisponibles) + $resultado->horas
            ]);

            $resultado->delete();

        } catch (\Throwable $th) {
            Log::critical('Usuario -> '.Auth::user()->name .' en la vista a '.$nombreC.' al eliminar el reporte '.$id.
                    ' razon: '. $th->getMessage());
            session()->flash('messageError', 'El reporte no pudo ser borrado, error inesperado.');
        }
    }

    public function actualizarReportes() {
        // $reporteQuery = Reporte::query();
        

        // $hoy = date('Y-m-d');
        $hoy = Carbon::today()->toDateString();
        $reportes[0] = Reporte::WhereDate('fecha_reporte', $hoy);

        $reportes[1] = Reporte::WhereDate('fecha_reporte', '<' ,$hoy);
            
        if($this->searchTerm != ''){

            $reportes[0] = Reporte::Where(function($query){
                $query->where('observaciones', 'like', '%' . $this->searchTerm . '%')
                ->orWhere('justificacion', 'like', '%' . $this->searchTerm . '%')
                ->orWhere('horas', 'like', '%' . $this->searchTerm . '%')
                ->orWhere('orden.codigo', 'like', '%' . $this->searchTerm . '%')
                ;
            })->WhereDate('fecha_reporte', $hoy);
            
            $reportes[1] = Reporte::Where(function($query){
                $query->where('observaciones', 'like', '%' . $this->searchTerm . '%')
                ->orWhere('justificacion', 'like', '%' . $this->searchTerm . '%')
                ->orWhere('horas', 'like', '%' . $this->searchTerm . '%')
                ;
            });
        }

        $reportes[0] = $reportes[0]->orderby('fecha_reporte')->get();
        $reportes[1] = $reportes[1]->orderby('fecha_reporte')->paginate($this->perPage, ['*'], 'page', $this->currentPage);
        return $reportes;
    }

    public function render() {
        $repor =($this->actualizarReportes());
        return view('livewire.ultimasvistas.eliminar-ordenes-compra', [
            'reporteshoy' => $repor[0],
            'reportes' => $repor[1],
        ]);
    }
}
