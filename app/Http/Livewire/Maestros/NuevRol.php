<?php

namespace App\Http\Livewire\Maestros;
use App\Models\Roles;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class NuevRol extends Component
{
    public $mensajeTitular='Nueva Roles';
    public $mensajeTabla='Lista Roles';

    public $laClase = 'Roles';
    public $nombre;
    public $losAtributos;
    public $losInputs =[
        [ 'variable' =>'nombre','variableLegible' => 'Nombre del Roles', 'tipoVariable' => 'text']
    ];

    public $todas;

    public function mount(){
    log::debug('Vista:  ' . get_class($this). '  Usuario -> '.Auth::user()->name );
        $this->losAtributos = ( (new Roles)->getFillable() );
        $this->todas = Roles::where('id','>',0)->get();
    }

    protected $rules = [
        'nombre' => 'required',
    ];

    public function justBack() { return redirect()->to('dashboard'); }
    public function submit()
    {
        try{
            $this->validate();
            $creando=[];
            foreach ($this->losInputs as $key => $value) {
                $creando[$value['variable'] ] = $this->nombre;
            }
            Roles::create($creando);
            session()->flash('message', 'Operacion correctamente finalizada');
            $this->reset(); $this->mount();
        } catch (\Throwable $th) {
            session()->flash('messageError', 'Operacion fallida, error inesperado');
            session()->flash('message', substr($th,0,200));
        }
    }

    public function render()
    {
        return view('livewire.maestros.nuev-rol');
    }
}
