<?php

namespace App\Http\Livewire\Maestros;

use App\helpers\Myhelp;
use App\Models\Empresa;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class NuevEmpresa extends Component
{
    public $mensajeTitular='Nueva Empresa';
    public $mensajeTabla='Lista Empresas';

    public $laClase = 'Empresa';
    public $nombre;
    public $losAtributos;
    public $losInputs =[
        [ 'variable' =>'nombre','variableLegible' => 'Nombre de la empresa', 'tipoVariable' => 'text']
    ];

    public $todas;

    public function mount(){
        Myhelp::EscribirEnLog($this);
        $this->losAtributos = ( (new Empresa)->getFillable() );
        $this->todas = Empresa::where('id','>',0)->get();
    }

    protected $rules = [
        'nombre' => 'required',
    ];

    public function justBack() { return redirect()->to('dashboard'); }
    public function submit()
    {
        // dd( $this->losInputs[0]['variable'] );
        try{
            $this->validate();
            $creando=[];
            foreach ($this->losInputs as $key => $value) {
                $creando[$value['variable'] ] = $this->nombre;
            }
            Empresa::create($creando);

            // Empresa::create([
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
        return view('livewire.maestros.nuev-empresa');
    }
}
