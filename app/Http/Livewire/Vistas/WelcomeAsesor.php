<?php

namespace App\Http\Livewire\Vistas;

use App\helpers\Myhelp;
use Livewire\Component;

use App\Models\OrdenCompra;
use App\Models\OrdenCompra_User;
use App\Models\Reporte;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class WelcomeAsesor extends Component
{
    public $ordenesPendientesWelcome=0;
    public $ordenesRechazadasWelcome=0;
    public $isadmin;

    public function mount(){
        $ListaControladoresYnombreClase = (explode('\\',get_class($this))); $nombreC = end($ListaControladoresYnombreClase);
        $thisuser = Myhelp::AuthU();
        Myhelp::EscribirEnLog($this);

        $userId = Auth::user()->id;
        $this->isadmin = Auth::user()->is_admin;
        $OrdenesDelUs = OrdenCompra_User::Where('user_id',$userId)->pluck('orden_compra_id');
        $this->ordenesPendientesWelcome = Count(OrdenCompra
            ::WhereIn('id',$OrdenesDelUs)
            ->WhereNot('horasdisponibles',0)
            ->where('estado_tarea',0)
            ->get()
        );

        $this->ordenesRechazadasWelcome = Count(Reporte::Where('aprobado',3)->Where('user_id',$userId)->get());
    }
    public function render() { return view('livewire.vistas.welcome-asesor'); }
}
