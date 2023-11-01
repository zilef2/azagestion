<?php

namespace App\Http\Livewire\Maestros;

use App\Models\OrdenCompra;
use Livewire\Component;
use App\Models\Tarea;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class NuevTarea extends Component
{
    public $mensajeTitular='Nueva Tarea';
    public $mensajeTabla='Lista Tareas';

    public $laClase = 'Tarea';
    public $nombre;
    public $losAtributos;
    public $contarSinRepetidos;
    public $contarTodos;
    public $HayRepetidos;

    //# nombre de la
    public $losInputs =[
        [ 
            'variable' =>'nombre',
            'variableLegible' => 'Nombre de la Tarea',
            'tipoVariable' => 'text',
        ],
        [ 
            'variable' =>'contarSinRepetidos',
            'variableLegible' => 'contarSinRepetidos',
            'tipoVariable' => 'text',
        ],
        [ 
            'variable' =>'contarTodos',
            'variableLegible' => 'contarTodos',
            'tipoVariable' => 'text',
        ],
        [ 
            'variable' =>'HayRepetidos',
            'variableLegible' => 'HayRepetidos',
            'tipoVariable' => 'text',
        ],
    ];

    public $todas;

    public function mount(){
    log::debug('Vista:  ' . get_class($this). '  Usuario -> '.Auth::user()->name );
        $this->losAtributos = ( (new Tarea)->getFillable() );
        $this->todas = Tarea::All();
        $this->contarSinRepetidos = OrdenCompra::All()->unique('codigo')->count();
        $this->contarTodos = OrdenCompra::All()->count();
        if($this->contarSinRepetidos && $this->contarTodos)
            $this->HayRepetidos = intval($this->contarSinRepetidos) == intval($this->contarTodos);
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
            Tarea::create($creando);

            session()->flash('message', 'Operacion correctamente finalizada');
            $this->reset(); $this->mount();
        } catch (\Throwable $th) {
            session()->flash('messageError', 'Operacion fallida, error inesperado');
            session()->flash('message', substr($th,0,200));
        }
    }

    public function render()
    {
        return view('livewire.maestros.nuev-tarea');
    }
}
