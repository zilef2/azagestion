<?php

namespace App\Http\Livewire\Ultimasvistas;

use App\helpers\Myhelp;
use App\Models\OrdenCompra;
use App\Models\Reporte;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class EliminarOrdenesCompra extends Component
{
    use WithPagination;
    public $usuarios, $TodosLosRoles, $searchTerm = ''; //array of objects

    public $perPage = 10;
    public $currentPage = 1;

    public $reportyFin,$reportie,$rolSeleccionado, $adminSeleccionado; //valores inputs

    public function mount() {
        Myhelp::EscribirEnLog($this);

        $this->reportyFin = true;
        ($this->actualizarReportes());
    }


    public function setPage($page) {
        $this->currentPage = $page;
        $this->emit('pageChanged', $page);
    }

    public function eliminarUser($id) {
        $resultado = Reporte::Find($id);
        Myhelp::EscribirEnLog($this);

        session()->flash('message', 'Reporte borrado correctamente');

        try {
            $ordenAsociada = OrdenCompra::find($resultado->orden_compra_id);
            $ordenAsociada->update([
                'horasdisponibles' => doubleval($ordenAsociada->horasdisponibles) + $resultado->horas
            ]);

            $resultado->delete();
            $this->reset(); $this->mount();

        } catch (\Throwable $th) {
            Myhelp::EscribirEnLog($this,'',1,$th);
            session()->flash('messageError', 'El reporte no pudo ser borrado, error inesperado.');
        }
    }

    public function actualizarReportes() {
        // $reporteQuery = Reporte::query();
        // $hoy = date('Y-m-d');
        $hoy = Carbon::today()->toDateString();
        $reportes[0] = Reporte::WhereDate('fecha_reporte', $hoy);
        $reportes[1] = Reporte::WhereDate('fecha_reporte', '<', $hoy);
        $searching = $this->searchTerm;
        if ($searching != '') {

            // $reportes[0] = Reporte::Where(function ($query) {
            //     $query->where('observaciones', 'like', '%' . $searching . '%')
            //         ->orWhere('justificacion', 'like', '%' . $searching . '%')
            //         ->orWhere('horas', 'like', '%' . $searching . '%')
            //         ->orWhere('orden.codigo', 'like', '%' . $searching . '%');
            // })->WhereDate('fecha_reporte', $hoy);

            $reportes[0] = Reporte::whereHas('orden', function ($query) use ($searching) {
                $query->where('codigo', 'like', '%' . $searching . '%');
            });
            $reportes[1] = Reporte::Where(function ($query) use($searching) {
                $query->where('observaciones', 'like', '%' . $searching . '%')
                    ->orWhere('justificacion', 'like', '%' . $searching . '%')
                    ->orWhere('horas', 'like', '%' . $searching . '%');
            });
        }

        $reportes[0] = $reportes[0]->orderby('fecha_reporte')->get();
        $reportes[1] = $reportes[1]->orderby('fecha_reporte')->paginate($this->perPage, ['*'], 'page', $this->currentPage);
        $this->reportie = $reportes;
    }

    public function render() {
        // if($this->reportyFin){
        //     $this->reportie = ($this->actualizarReportes());
        //     $this->reportyFin = false;
        // }

        return view('livewire.ultimasvistas.eliminar-ordenes-compra', [
            'reporteshoy' => $this->reportie[0],
            'reportes' => $this->reportie[1],
        ]);
    }
}
