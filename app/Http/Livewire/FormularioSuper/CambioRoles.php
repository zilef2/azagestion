<?php

namespace App\Http\Livewire\FormularioSuper;

use App\helpers\Myhelp;
use App\Models\OrdenCompra;
use App\Models\OrdenCompra_User;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class CambioRoles extends Component
{
    use WithPagination;
    public $usuarios,$TodosLosRoles,$searchTerm = ''; //array of objects

    public $perPage = 10;
    public $currentPage = 1;

    public $rolSeleccionado,$adminSeleccionado; //valores inputs

    public function mount(){
        Myhelp::EscribirEnLog($this);

        $this->TodosLosRoles = Roles::where('id', '>',1)->get();
    }


    public function rolActualizado($userid,$rolid) {
        User::find($userid)->update([
            'rol_id' => $rolid
        ]);
        return redirect(request()->header('Referer'));
    }
    public function adminActualizado($userid,$adminoNO) {
        User::find($userid)->update([
            'is_admin' => $adminoNO
        ]);
        return redirect(request()->header('Referer'));
    }

    public function setPage($page) {
        $this->currentPage = $page;
        $this->emit('pageChanged', $page);
    }
    public function eliminarUser($id) {
        $resultado = User::Find($id);
        if($resultado->is_admin){
            Myhelp::EscribirEnLog($this,' intento borrar al administrador '.$resultado->name,2);
            session()->flash('message', 'El usuario no pudo ser borrado, es un administrador.');
        }else{
            try {
                $ordenUser = OrdenCompra_User::where('user_id',$id);
                if($ordenUser->exists()){
                    $orden = OrdenCompra::find($ordenUser->first()->orden_compra_id);

                    Myhelp::EscribirEnLog($this,' el usuario tiene  asociado la OC/OS #'.$orden->codigo, '| ID ed la ordenCompra = '.$orden->id,2);
                    session()->flash('messageError', 'El usuario tiene asociado la OC/OS #'.$orden->codigo);
                }else{
                    if($resultado->rol_id === 2){
                        Myhelp::EscribirEnLog($this,' intento borrar al asignador '.$resultado->name,2);

                        session()->flash('messageError', 'El usuario no pudo ser borrado, es asignador.');
                    }
                    $resultado->delete();
                    if($resultado){
                        Myhelp::EscribirEnLog($this,' Se borro a '.$resultado->name .' userid = '.$id);
                        session()->flash('message', 'Usuario borrado correctamente.');
                    } else{
                        Myhelp::EscribirEnLog($this,'Error inesperado',2);
                        session()->flash('messageError', 'El usuario no pudo ser borrado, error inesperado.');
                    }
                }
            } catch (\Throwable $th) {
                Myhelp::EscribirEnLog($this,'Error inesperado',1,$th);
                session()->flash('messageError', 'El usuario no pudo ser borrado, error inesperado.');
            }
        }

        // $this->mount();
        // return redirect(request()->header('Referer'));
    }

    public function actualizarUsuarios()
    {
        if($this->adminSeleccionado){
            $this->rolSeleccionado = [];
        }
        if($this->rolSeleccionado){
            $this->adminSeleccionado = [];
        }
        $users = User::Where(function($query){
                $query->where('name', 'like', '%' . $this->searchTerm . '%')
                ->orWhere('email', 'like', '%' . $this->searchTerm . '%');
            })
            ->WhereNotIn('name', ['Superadmin','admin','operator'])
            ->orderby('is_admin','desc')
            ->orderby('rol_id')
            ->orderby('name')
            ->paginate($this->perPage, ['*'], 'page', $this->currentPage);
        return $users;
    }

    public function render() {
        $users = $this->actualizarUsuarios();

        return view('livewire.formulario-super.cambio-roles', [
            'users' => $users,
        ]);
    }
}
