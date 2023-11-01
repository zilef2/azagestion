<?php

namespace App\Http\Livewire\FormularioSuper;

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
        $ListaControladoresYnombreClase = (explode('\\',get_class($this))); $nombreC = end($ListaControladoresYnombreClase);
        if(Auth::User()->is_admin > 0) {
            log::channel('eladmin')->info('Vista:' . $nombreC. '|  U:'.Auth::user()->name.'');
        }else{
            log::info('Vista:  ' . $nombreC. '  Usuario -> '.Auth::user()->name );
        }
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

        $ListaControladoresYnombreClase = (explode('\\',get_class($this)));
        $nombreC = end($ListaControladoresYnombreClase);
        log::info('En ' . $nombreC. '  el Usuario -> '.Auth::user()->name. ' inicio el proceso para eliminar al usuario '.$resultado->name );

        if($resultado->is_admin){
            log::alert('En ' . $nombreC. '  el Usuario -> '.Auth::user()->name. ' intento borrar al administrador '.$resultado->name );
            session()->flash('message', 'El usuario no pudo ser borrado, es un administrador.');
        }else{
            try {
                $ordenUser = OrdenCompra_User::where('user_id',$id);
                if($ordenUser->exists()){
                    $orden = OrdenCompra::find($ordenUser->first()->orden_compra_id);
                    Log::alert('U -> '.Auth::user()->name .' en la vista a '.$nombreC.' al eliminar el usuario '.$id.
                         ' el aplicativo no permitio dado que tiene la orden'. $orden->codigo .' asignada');
                    session()->flash('messageError', 'El usuario tiene asociado la OC/OS #'.$orden->codigo);
                }else{
                    if($resultado->rol_id === 2){
                        Log::alert('El  Usuario -> '.Auth::user()->name .' en la vista a '.$nombreC.' al eliminar el usuario '.$id.
                         ' el aplicativo no permitio dado que es un asignador');
                        session()->flash('messageError', 'El usuario no pudo ser borrado, es asignador.');
                    }
                    $resultado->delete();
                    if($resultado){
                        Log::info('Vista:  ' . get_called_class(). '  Usuario -> '.Auth::user()->name. ' y borro al usuario '.$id );
                        session()->flash('message', 'Usuario borrado correctamente.');
                    } else{
                        Log::alert('El  Usuario -> '.Auth::user()->name .' en la vista a '.$nombreC.' al eliminar el usuario '.$id.
                        ' razon: la operacion en la BD falló');
                        session()->flash('messageError', 'El usuario no pudo ser borrado, error inesperado.');
                    }
                }
            } catch (\Throwable $th) {
                Log::critical('El  Usuario -> '.Auth::user()->name .' en la vista a '.$nombreC.' al eliminar el usuario '.$id.
                        ' razon: '. $th->getMessage());
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
