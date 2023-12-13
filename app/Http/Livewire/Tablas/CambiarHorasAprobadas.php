<?php

namespace App\Http\Livewire\Tablas;

use App\helpers\Myhelp;
use App\Models\Reporte;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class CambiarHorasAprobadas extends Component
{
    public $reporte,$horasAprob;

    public function mount($id) { //!not used
        Myhelp::EscribirEnLog($this);
        $this->reporte = Reporte::find($id);
        $this->horasAprob = $this->reporte->horasaprobadas;
    }

    public function changeHoras()
    {
        $this->reporte->update([
            'horasaprobadas' => $this->horasAprob
        ]);
    }

    public function render()
    {
        return view('livewire.tablas.cambiar-horas-aprobadas');
    }
}
