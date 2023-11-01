<?php

namespace App\Http\Livewire\Maestros;

use Livewire\Component;
use App\Models\Clasificacion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class NuevClasificacion extends Component
{

    public $mensajeTitular='Nueva Clasificacion';
    public $mensajeTabla='Lista Clasificacions';

    public $laClase = 'Clasificacion';
    public $nombre;
    public $losAtributos;
    public $losInputs =[
        [ 'variable' =>'nombre','variableLegible' => 'Nombre de la Clasificacion', 'tipoVariable' => 'text']
    ];

    public $todas;

    public function mount(){
        $ListaControladoresYnombreClase = (explode('\\',get_class($this))); $nombreC = end($ListaControladoresYnombreClase);

        if(Auth::User()->is_admin > 0) {
            Log::channel('eladmin')->debug('Vista:' . $nombreC. '|  U:'.Auth::user()->name.'');
        }else{
            log::debug('Vista:  ' . $nombreC. ' U:'.Auth::user()->name );
        }
        $this->losAtributos = ( (new Clasificacion)->getFillable() );
        $this->todas = Clasificacion::where('id','>',0)->get();
    }

    protected $rules = [
        'nombre' => 'required',
    ];

    public function justBack() { return redirect()->to('dashboard'); }
    public function submit() {
        try{
            $this->validate();
            $creando=[];
            foreach ($this->losInputs as $key => $value) {
                $creando[$value['variable'] ] = $this->nombre;
            }
            Clasificacion::create($creando);

            // Clasificacion::create([
            //     'nombre' => $this->nombre
            // ]);

            session()->flash('message', 'Operacion correctamente finalizada');
            $this->reset(); $this->mount();
        } catch (\Throwable $th) {
            session()->flash('messageError', 'Operacion fallida, error inesperado');
            session()->flash('message', substr($th,0,200));
        }
    }

    public function render()
    {
        return view('livewire.maestros.nuev-clasificacion');
    }
}
