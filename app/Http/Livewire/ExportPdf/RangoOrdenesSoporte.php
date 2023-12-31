<?php

namespace App\Http\Livewire\ExportPdf;

use App\helpers\Myhelp;
use App\Models\OrdenCompra;
use App\Models\Reporte;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use ZipArchive;

class RangoOrdenesSoporte extends Component
{

    public $fechaini,$fechafin;
    public $validate = true,$totalArchivos = 0;


    public function mount() {
        $ListaControladoresYnombreClase = (explode('\\',get_class($this))); $nombreC = end($ListaControladoresYnombreClase);

        if(Auth::User()->is_admin > 0) {
            Myhelp::EscribirEnLog($this);
            $this->fechaini="2023-03-09";
            $this->fechafin="2023-12-12";
        }else{
            Myhelp::EscribirEnLog($this);
        }
    }

    public function updated() {
        if ($this->fechaini && $this->fechafin) {
            $this->validate = strtotime($this->fechaini) <= strtotime($this->fechafin);
            if($this->validate){
                $this->totalArchivos = Reporte::whereNotNull('adjunto')
                ->WhereBetween('fecha_reporte',[$this->fechaini,$this->fechafin])
                ->WhereIn('aprobado',[2,4])
                ->count();
            }
        }
    }

    public function arreglarFechas() {
        $fecha1 = strtotime($this->fechaini);
        $fecha2 = strtotime($this->fechafin);
        if (date('Y', $fecha1) == date('Y', $fecha2)) {
            return '' . date('j M', $fecha1) . ' - ' . date('j M', $fecha2);
        } else {
            return '' . date('j M Y', $fecha1) . ' - ' . date('j M Y', $fecha2);
        }
    }

    public function DescargarOrdenes() {
        $ListaControladoresYnombreClase = (explode('\\',get_class($this)));
        $nombreC = end($ListaControladoresYnombreClase);

        if ($this->fechaini && $this->fechafin) {
            $this->validate = strtotime($this->fechaini) <= strtotime($this->fechafin);
        }
        if($this->validate){
            try {
                $zip = new ZipArchive();
                // $zipName = 'Soportes_'.$this->arreglarFechas().'.zip';
                // $zipName = storage_path('app/myzipfile.zip');
                $zipName = storage_path('app/Soportes_'.$this->arreglarFechas().'.zip');

                $createZip = $zip->open($zipName, ZipArchive::CREATE);

                $reportes = Reporte::whereNotNull('adjunto')
                            ->WhereBetween('fecha_reporte',[$this->fechaini,$this->fechafin])
                            ->WhereIn('aprobado',[2,4])
                            ->orderby('fecha_reporte')->get();

                if(count($reportes) > 0){
                    if($createZip){
                        $contador=1;
                        foreach ($reportes as $value) {
                            if($value->adjunto){
                                // $pdfFiles[] = $value->adjunto;
                                $Ord = OrdenCompra::find($value->orden_compra_id);

                                $empresaNom = preg_replace('([^A-Za-z0-9 ])', '', $Ord->empresa->nombre);
                                $tareaNom =   preg_replace('([^A-Za-z0-9 ])', '', $Ord->tare->nombre);
                                $empresaNom = substr($empresaNom, 0,30);
                                $tareaNom =   substr($tareaNom, 0,50);
                                $laFecha = date('Y m d h:i', strtotime($value->fecha_ejecucion));
                                $zip->addFromString('OC '.
                                    $Ord->codigo
                                    .' '.$empresaNom
                                    .' '.$tareaNom
                                    .' '.$laFecha
                                    .'.pdf',
                                    Storage::disk('public')->get($value->adjunto)
                                );
                                $contador++;
                            }
                        }
                        $zip->close();
                        // return response()->download($zipName);

                        Myhelp::EscribirEnLog($this);
                        return response()->download($zipName)->deleteFileAfterSend(true);

                    }else {
                        session()->flash('messageError', 'Error interno al crear el archivo comprimido');
                        Myhelp::EscribirEnLog($this,'Error interno al crear el archivo comprimido',2);
                    }
                }else{
                    session()->flash('messageError', 'Es necesario que exista por lo menos un archivo');
                    Myhelp::EscribirEnLog($this,' intento descargar el zip con rango incorrecto, con cero reportes',2);
                }
                // return response()->download($pdfFiles);
                // return Storage::disk('public')->download($pdfFiles);
            } catch (\Throwable $th) {
                Myhelp::EscribirEnLog($this,'',1,$th);
                session()->flash('messageError', $th->getMessage());
                // $this->addError('archivoExcelSubir', "Formato invalido");
            }
        }else{
            Myhelp::EscribirEnLog($this,' intento descargar el zip con una fecha inicial posterior a la fecha final',2);
            session()->flash('message', 'La fecha inicial tiene que ser inferior a la final.');
        }
        return null;
    }

    public function render()
    {
        return view('livewire.export-pdf.rango-ordenes-soporte');
    }
}
