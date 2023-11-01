<?php

namespace App\Http\Livewire\TablaActions;

use App\Models\OrdenCompra;
use App\Models\OrdenCompra_User;
use App\Models\User;
use Livewire\Component;

class ActionEditarAsignacion extends Component
{
    public $usuario,$ordenCompra_user,$OrdenCompra;

    public $ordenes_compra, $nuevaOrdenCompraid;

    public function mount($id){
        $this->ordenCompra_user = OrdenCompra_User::findorfail($id);
        $this->usuario = User::find($this->ordenCompra_user->user_id);
        $this->OrdenCompra = OrdenCompra::find($this->ordenCompra_user->orden_compra_id);

        $ordenesNoSonDelUsuario = OrdenCompra_User::whereNot('user_id',$this->usuario->id)
            ->pluck('orden_compra_id');

        $this->ordenes_compra = OrdenCompra::whereNotIn('id',$ordenesNoSonDelUsuario)->get();
        // ->where()

    }

    public function render()
    {
        return view('livewire.tabla-actions.action-editar-asignacion');
    }
}
