<?php

namespace App\Http\Livewire\Ultimasvistas;

use App\Models\Reporte;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class VerAdjunto extends Component
{
    public $original_file;

    public function mount($id) {
        log::info('Entro a ver un PDF en la vista ' . get_called_class(). '  Usuario -> '.Auth::user()->name. ' ID del reporte '.$id );
        $this->original_file = Reporte::find($id)->getPDF();
    }
    public function render() {
        return view('livewire.ultimasvistas.ver-adjunto');
    }
}
