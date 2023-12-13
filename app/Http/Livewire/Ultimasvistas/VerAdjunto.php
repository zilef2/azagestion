<?php

namespace App\Http\Livewire\Ultimasvistas;

use App\helpers\Myhelp;
use App\Models\Reporte;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class VerAdjunto extends Component
{
    public $original_file;

    public function mount($id) {
        Myhelp::EscribirEnLog($this);
        $this->original_file = Reporte::find($id)->getPDF();
    }
    public function render() {
        return view('livewire.ultimasvistas.ver-adjunto');
    }
}
