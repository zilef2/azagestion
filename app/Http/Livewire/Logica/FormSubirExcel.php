<?php

namespace App\Http\Livewire\Logica;

use App\helpers\Myhelp;
use Livewire\Component;
use App\Imports\OrdenesImport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

use Livewire\WithFileUploads;
class FormSubirExcel extends Component
{
    use WithFileUploads;

    public $archivoExcel;

    public $archivoExcelSubir;
    public $nombreArchivo;

    public function mount(){
        $ListaControladoresYnombreClase = (explode('\\',get_class($this))); $nombreC = end($ListaControladoresYnombreClase);

        Myhelp::EscribirEnLog($this);
    }

    public function uploadArchivoExcelSubir() {
        if($this->archivoExcelSubir){
            $this->nombreArchivo = $this->archivoExcelSubir->getClientOriginalName();
        }
    }

    public function importarUsuariosPrueba() {
        $this->validate([
            'archivoExcelSubir' => 'max:8192', // 8MB Max
        ]);

        try {
            $ListaControladoresYnombreClase = (explode('\\',get_class($this))); $nombreC = end($ListaControladoresYnombreClase);

            Excel::import(new OrdenesImport, $this->archivoExcelSubir);
            Myhelp::EscribirEnLog($this);

            session()->flash('message', 'El Archivo se ha cargado correctamente.');
        } catch (\Throwable $th) {
            $this->archivoExcelSubir = null;

            Myhelp::EscribirEnLog($this);

            if (config('app.env') === 'production') {
                session()->flash('message', $th->getMessage());
            }else{
                session()->flash('message', substr($th,22,1200));
            }

            $this->addError('archivoExcelSubir', "Formato invalido");
        }
    }
    public function render() { return view('livewire.logica.form-subir-excel'); }
}
