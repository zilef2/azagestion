<?php

namespace App\Http\Livewire\Internal;

use App\helpers\Myhelp;
use App\Imports\OrdenesDesactualizadasImport;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Settings;

class ActualizacionDBDiciembre extends Component
{
    use WithFileUploads,WithPagination;

    public $archivoExcelSubir;
    public $nombreArchivo;
    public $failures,$ListaErrores; //manejo de errores

    public function SalieronErroes($BadFormat, $IntNusers,
                                    $OrdenConInsuficientesHoras,
                                    $OrdenesNocoincidenModel,
                                    $OrdenesNocoincidenCodigo)
    {

        if($IntNusers !== 0) {
            $warning = "Existen $IntNusers ordenes de compra no registradas.";
            if(count($OrdenesNocoincidenModel) > 0 || count($OrdenesNocoincidenCodigo) > 0){

                $warning .= " Hubo ordenes que no coinciden con su id ";
                Myhelp::EscribirEnLog($this," Models: ". implode(",-,",$OrdenesNocoincidenModel));
                Myhelp::EscribirEnLog($this," Codigo: ". implode(",-,",$OrdenesNocoincidenCodigo));
            }
            session()->flash('WarningMessage', $warning);
        }

        $warningError = '';
        if($BadFormat) {
            $warningError = 'Archivo con las columnas incorrectas.';
        }
        if(count($OrdenConInsuficientesHoras) > 0) {
            $warningError .= " Ordenes con horas Aprobadas menores al valor a subir: ";
            $warningError .= implode(',',$OrdenConInsuficientesHoras);
            session()->flash('messageError', $warningError);
        }
    }
    public function importarOCDesactualizadas(){
         $this->validate([
             'archivoExcelSubir' => 'max:8192', // 8MB Max
         ]);
        set_time_limit(360);//6mins

        try {
            Myhelp::EscribirEnLog($this,'Inicio la subida del archivo de actualizaciones de la ordenes viejas');

            $impo = new OrdenesDesactualizadasImport();
            Settings::setLibXmlLoaderOptions(LIBXML_COMPACT | LIBXML_PARSEHUGE);

            Excel::import($impo, $this->archivoExcelSubir);
//            $impo->queue($this->archivoExcelSubir);
            Myhelp::EscribirEnLog($this);

            $IntNusers = $impo->getNumberReportesSinUser();
            $BadFormat = $impo->getHasBadFormat();
            $OrdenConInsuficientesHoras = $impo->getOrdenConInsuficientesHoras();
            $OrdenesNocoincidenModel = $impo->getOrdenesNocoincidenModel();
            $OrdenesNocoincidenCodigo = $impo->getOrdenesNocoincidenCodigo();

            if($BadFormat || $IntNusers !== 0 || count($OrdenConInsuficientesHoras) > 0) {
                $this->SalieronErroes($BadFormat,
                    $IntNusers,
                    $OrdenConInsuficientesHoras,
                    $OrdenesNocoincidenModel,
                    $OrdenesNocoincidenCodigo);

            }else {
                //all ok
                $ColsLeidas = $impo->getNumberColumsLeidas();
                $ReportesCreados = $impo->getNumberReportesCreados();

                session()->flash('message', 'Actualización correcta. Dentro de unos minutos se notaran los cambios '
//                    ."Se leyeron $ColsLeidas filas. "
//                    ."Se Crearon $ReportesCreados reportes. "
                );
            }
        } catch (\Throwable $th) {
            $ColsLeidas = $ColsLeidas ?? -1;
            $ReportesCreados = $ReportesCreados ?? -1;
            Myhelp::EscribirEnLog($this);
            $mensajeError = "Archivo: ". $th->getFile()." -- Linea: ".$th->getLine()." -- ".$th->getMessage();

            if (config('app.env') === 'production') {
                session()->flash('WarningMessage', "Se llego hasta la fila $ColsLeidas y se crearon $ReportesCreados reportes.".
                    " ERROR = ". $mensajeError);
            }else{
                session()->flash('WarningMessage', $mensajeError. ' -- mensajeFULL: '.substr($th,22,1200));
            }
            $this->addError('archivoExcelSubir', "Formato invalido");
        }
    }

    public function render(){
//        if($this->archivoExcelSubir){
//            $this->nombreArchivo = $this->archivoExcelSubir->getClientOriginalName();
//        }else{
//            $this->nombreArchivo = 'No hay archivo cargado';
//        }
        return view('livewire.internal.actualizacion-d-b-diciembre');
    }
}
