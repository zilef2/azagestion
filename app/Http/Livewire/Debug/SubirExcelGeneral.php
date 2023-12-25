<?php

namespace App\Http\Livewire\Debug;

use App\helpers\Myhelp;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Imports\OrdenesImport;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use PhpOffice\PhpSpreadsheet\Settings;

class SubirExcelGeneral extends Component
{

    use WithFileUploads,WithPagination;

    public $failures,$ListaErrores; //manejo de errores
    public $archivoExcelSubir,$progress;
    public $nombreArchivo;

    public function importarUsuariosPrueba() {
        $this->validate([
            'archivoExcelSubir' => 'max:8192', // 8MB Max
        ]);
        set_time_limit(360);//6mins

        try {
            $import = new OrdenesImport();
            Settings::setLibXmlLoaderOptions(LIBXML_COMPACT | LIBXML_PARSEHUGE);
            // $import->import($this->archivoExcelSubir);
            // $import->queue($this->archivoExcelSubir);
            Excel::import($import, $this->archivoExcelSubir);
            $mensajewarn = '';
            $usuariosNuevos = session('CountNuevosUsuarios',0);
            $mensajeUsuariosNuevos = $this->archivoExcelSubir->getClientOriginalName().' se ha cargado correctamente. '
                .$import->getNumberColums()." Filas leidas y ".
                $import->getNumberColumsExecuted()." Ejecutadas por completo.";
            if($import->getHasFormulas()){
                $mensajewarn .= " ¡Se encontraron valores no numericos en cantidad pendientes por facturar!";
            }

            if($usuariosNuevos == 0){
                $mensajeUsuariosNuevos .=' Sin usuarios nuevos';
                session()->flash('message',$mensajeUsuariosNuevos);
            }else{
                if ($usuariosNuevos == 1) {
                    $mensajewarn .= ' 1 usuario desconocido';
                } else {
                    $mensajewarn .= ' '.$usuariosNuevos.' usuarios desconocidos';
                }
            }
            if($mensajewarn !== ''){
                session()->flash('WarningMessage', $mensajewarn);
            }
            Myhelp::EscribirEnLog($this,'SubirExcelGeneral. Usuarios desconocidos: '.$usuariosNuevos.' advertencia: '.$mensajewarn);
            session(['CountNuevosUsuarios' => 0]);
            $this->reset();
            // $this->mount();
        } catch (ValidationException $e) {
            foreach ($e->failures() as $failu) {
                $this->ListaErrores = $failu->errors();
                $this->failures = "Ocurrio un error en la fila ".$failu->row();
            }
            Myhelp::EscribirEnLog($this,'',1,$e);

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
            // $this->reset(); $this->mount();
            Myhelp::EscribirEnLog($this,'',1,$th);
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
        return view('livewire.debug.subir-excel-general');
    }
}
