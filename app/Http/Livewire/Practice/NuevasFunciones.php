<?php

namespace App\Http\Livewire\Practice;


use App\helpers\Myhelp;
use App\Models\OrdenCompra;
use App\Models\OrdenCompra_User;
use App\Exports\EmpresasExport;
use App\Imports\OrdenesImport;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\OrdenesCompraMail;
use Illuminate\Support\Facades\Mail;

use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class NuevasFunciones extends Component
{
    use WithFileUploads;

    public $archivoExcel;

        //subir excel
        public $tamanoUno = 0;
        public $archivoExcelSubir;
        public $nombreUno;

        //subirimg
        public $photo, $title;

        //asignarordenes
        public $ordenesSinasignar,$ordenesSeleccionadas,$userSelected;

    public function mount(){
        Myhelp::EscribirEnLog($this);
        //asignarordenes
        $ordenesSinDueno = OrdenCompra_User::all()->pluck('orden_compra_id');
        $this->ordenesSinasignar = OrdenCompra::whereNotIn('id',$ordenesSinDueno)->get();
    }

    public function mandarCorreo() {
        Mail::to('alejofg2@gmail.com')->send(new OrdenesCompraMail(
            "Orden #123 ha sido rechazada",
            "Señor(a) 123 ha sido rechazada"
        ));
    }

    public function asignarDueno() {
        try {
            if ($this->ordenesSeleccionadas) {
                foreach ($this->ordenesSeleccionadas as $key => $value) {
                    OrdenCompra_User::create([
                        'user_id'=> 1,
                        // 'user_id'=> $this->userSelected,
                        'orden_compra_id'=> $value,
                    ]);
                }
                session()->flash('message', 'ordenes asignadas correctamente.');
                $this->reset();$this->mount();
            }else{
                session()->flash('message', 'no hay ordenes seleccionadas');
            }
        } catch (\Throwable $th) {
            session()->flash('message', substr($th,3,300));
        }
    }

    public function exportarEmpresas() {
        return Excel::download(new EmpresasExport, 'Empresas.xlsx');
    }

    public function importarUsuariosPrueba() {
        $this->validate([
            'archivoExcelSubir' => 'max:4096', // 4MB Max
        ]);

        try {
            // session(['ImportTiemposN' => 0]);
            Excel::import(new OrdenesImport, $this->archivoExcelSubir);
            session()->flash('message', 'El Archivo se ha cargado correctamente.');
        } catch (\Throwable $th) {
            $this->archivoExcelSubir = null;
            session()->flash('message', substr($th,63,200));

            $this->addError('archivoExcelSubir', "Formato invalido");
        }
    }

    public function subirIMG() {
        try {
            $validatedData = $this->validate([ 'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048']);//2MB
            $validatedData['photo'] = $this->photo->store('imagenesSubidas', 'public');
            // File::create($validatedData);
            session()->flash('message', 'Imagen cargada correctamente.');
            $this->reset(); $this->mount();
        } catch (\Throwable $th) {
            session()->flash('message', 'Error al subir imagen.');
        }
    }

    public function render() {
        return view('livewire.practice.nuevas-funciones');
    }
}
