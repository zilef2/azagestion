<?php

namespace App\Http\Livewire\Vistas;

use App\helpers\Myhelp;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Imports\OrdenesImport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use PhpOffice\PhpSpreadsheet\Settings;

class SubirOrdenesDeCompra extends Component
{
    use WithFileUploads;

    public $errora = 0,$failures,$ListaErrores; //manejo de errores
    public $archivoExcelSubir;
    public $nombreArchivo;
    public $messages = [];

    public function mount(){
        Myhelp::EscribirEnLog($this);
    }

    public function updatedArchivoExcelSubir() {
        $Kilobytes = (int)(($this->archivoExcelSubir->getSize())/1024);
        if($Kilobytes > 8192){
            // $this->addError('archivoExcelSubir', 'El Archivo es demasiado pesado.');
            session()->flash('messageError', 'El Archivo es demasiado pesado, debe ser menor a 8MB');
            // $this->reset();
        }
    }

    public function importarUsuariosPrueba() {
        $this->validate([
            'archivoExcelSubir' => 'max:8192', // 8MB Max
        ]);
        set_time_limit(360);//6mins

        try {
            $import = new OrdenesImport();
            Settings::setLibXmlLoaderOptions(LIBXML_COMPACT | LIBXML_PARSEHUGE);
            Excel::import($import, $this->archivoExcelSubir);
            $usuariosNuevos = session('CountNuevosUsuarios',0);
            if($usuariosNuevos == 0){
                $mensajeUsuariosNuevos = 'Sin usuarios nuevos';
                 session()->flash('message', $this->archivoExcelSubir->getClientOriginalName().' se ha cargado correctamente. ' .$mensajeUsuariosNuevos);
                Myhelp::EscribirEnLog($this,'subio ordenes sin usuarios desconcidos');
            }else{
                if ($usuariosNuevos == 1) {
                    $mensajeUsuariosNuevos = '1 usuario desconocido';
                } else {
                    $mensajeUsuariosNuevos = $usuariosNuevos.' usuarios desconocidos';
                }
                Myhelp::EscribirEnLog($this,'subio ordenes con '.$usuariosNuevos.' usuarios desconcidos');
                 session()->flash('message', $this->archivoExcelSubir->getClientOriginalName().' se ha cargado.');
                 session()->flash('WarningMessage', $mensajeUsuariosNuevos);
            }
            session(['CountNuevosUsuarios' => 0]);

            $this->reset();
            // $this->mount();
        } catch (ValidationException $e) {
            foreach ($e->failures() as $failu) {
                $this->ListaErrores = $failu->errors();
                $this->failures = "Ocurrio un error en la fila ".$failu->row();
            }
        } catch (\Throwable $th) {
            $countfilas = session('CountFilas',0);

            if (config('app.env') === 'production') {
                if($th->getMessage() != null){
                     session()->flash('WarningMessage', ' Fila#'.$countfilas.', '.$th->getMessage().'.');
                }else{
                     session()->flash('messageError', ' Fila#'.$countfilas);
                }
            } else {
                 session()->flash('WarningMessage', $th->getMessage());
                 session()->flash('messageError', ' Fila#'.$countfilas. ' --- '.substr($th,0,600));
            }
             $this->reset(); $this->mount();
        }
        session(['CountFilas' => 0]);
    }
    public function render()
    {
        if($this->archivoExcelSubir){
            $this->nombreArchivo = $this->archivoExcelSubir->getClientOriginalName();
        }else{
            $this->nombreArchivo = 'No hay archivo cargado';
        }
        return view('livewire.vistas.subir-ordenes-de-compra');
    }
}
