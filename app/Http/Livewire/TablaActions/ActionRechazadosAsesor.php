<?php

namespace App\Http\Livewire\TablaActions;

use App\helpers\Myhelp;
use App\Models\Clasificacion;
use Livewire\Component;

use App\Models\Empresa;
use App\Models\Municipios;
use App\Models\OrdenCompra;
use App\Models\Tarea;
use Illuminate\Support\Carbon;
use Livewire\WithFileUploads;
use App\Models\Reporte;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class ActionRechazadosAsesor extends Component
{
    use WithFileUploads;

    public $reporte, $adjunto, $codigo, $observaciones, $horas, $fechaOrden, $siOno, $siNoMensaje, $fecha_ejecucion; //inputs
    public $laOC_user, $ordenCorregir;
    //pure models
    public $losSelect, $codigoid, $codigosPendientes;
    public $tareas, $empresas, $clasificacions, $municipios;
    public $tareaid, $empresasid, $clasificacionid, $municipio;
    public $esCapacitacion, $adjuntoListo, $original_filename, $elPDF; //necesita pdf
    public $fotoRechazo;
    public $bancohoras;



    //reporte
    public $MaxHoras, $horasAcumuladas = 0;
    //mensajes
    public $mensajeRevisor;

    //mensajes
    public $mensajeError = '';

    public function mount($id)
    {
        Myhelp::EscribirEnLog($this);

        $this->reporte = Reporte::find($id);
        $this->ordenCorregir = OrdenCompra::find($this->reporte->orden_compra_id);
        $this->esCapacitacion = $this->ordenCorregir->clasificacion_id == 2;
        if ($this->reporte->aprobado == 3) { //la orden tiene que ser rechazada
            /*
                aprobado = 0 no se ha diligenciado
                aprobado = 1 se dilingencio
                aprobado = 2 se aprobo por el revisor
                aprobado = 3 rechazo por el revisor
                aprobado = 4 aprobado por completo
            */
            $this->horasAcumuladas = Reporte::where('orden_compra_id', $this->ordenCorregir->id)->sum('horas');
            $this->MaxHoras = floatval($this->ordenCorregir->{'horasaprobadas'} - $this->horasAcumuladas);

            $this->empresas = Empresa::all();
            $this->tareas = Tarea::all();
            $this->clasificacions = Clasificacion::all();
            $this->municipios = Municipios::all();

            $this->codigoid = $this->ordenCorregir->id;
            $this->tareaid = $this->ordenCorregir->tarea_id;
            $this->empresasid = $this->ordenCorregir->empresa_id;
            $this->clasificacionid = $this->ordenCorregir->clasificacion_id;
            $this->municipio = $this->reporte->municipio_id;

            $this->observaciones = $this->reporte->observaciones;
            $this->mensajeRevisor = $this->reporte->justificacion;
            $this->fecha_ejecucion = Carbon::parse($this->reporte->fecha_ejecucion)->format('Y-m-d');
            $this->fechaOrden = Carbon::now()->format('Y-m-d');
            $this->horas = isset($this->reporte->horas) ? $this->reporte->horas : null;
            $this->siOno = $this->reporte->{'requiere_transporte'};
            $this->bancohoras = $this->reporte->{'bancohoras'};
            // $this->adjuntoListo = isset($this->reporte->adjunto) ? $this->reporte->adjunto : null;
            $this->adjuntoListo = $this->reporte->adjunto ?? null;

            if ($this->adjuntoListo) {
                $this->original_filename = $this->reporte->getPDF();
                $this->elPDF = 'public/filesOrdenesCompra/' . $this->reporte->adjunto;
            }
            if ($this->reporte->photo) {
                $this->fotoRechazo = $this->reporte->getPhoto();
            }

            $horasAcumuladas = Reporte::where('orden_compra_id', $this->ordenCorregir->id)->sum('horas');

            $this->MaxHoras = floatval($this->ordenCorregir->{'horasaprobadas'} - ($horasAcumuladas - $this->horas));
        } else {
            $this->mensajeError = 'La orden ya fue corregida';
        }
    }

    public function updatedAdjunto()
    {
        if ($this->adjunto) {
            $this->validate([
                'adjunto' => 'file|mimes:pdf' //8MB
            ]);
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'horas' => 'numeric|max:' . $this->MaxHoras,
            'fecha_ejecucion' => 'date|before_or_equal:today',
        ]);
    }

    protected $rules = [
        'horas' => 'required',
        'fechaOrden' => 'required',
        'municipio' => 'required',
        'fecha_ejecucion' => 'date|before_or_equal:today',
    ];

    public function justBack()
    {
        return redirect()->to('dashboard');
    }

    public function calcularHorasDisponibles()
    {
        $otrosReportes = Reporte::where('orden_compra_id', $this->ordenCorregir->id)->whereNot('id', $this->reporte->id);
        if (count($otrosReportes->get()) > 0) {
            $horasAcumuladas = $otrosReportes->sum('horas');
        } else {
            $horasAcumuladas = 0;
        }
        return floatval($this->ordenCorregir->horasaprobadas) - (floatval($horasAcumuladas) + floatval($this->horas));
    }


    public function submitAsesor()
    {
        if (!$this->adjuntoListo) {
            $this->validate();
        }
        $this->validate([
            'horas' => 'required|numeric|max:' . $this->MaxHoras,
            'fecha_ejecucion' => 'date|before_or_equal:today',
        ]);
        try {
            $ListaControladoresYnombreClase = (explode('\\', get_class($this)));
            $nombreC = end($ListaControladoresYnombreClase);

            $horasdisponibles = $this->calcularHorasDisponibles();
            $this->ordenCorregir->update([
                'horasdisponibles' => $horasdisponibles
            ]);

            if ($this->esCapacitacion) { // con adjunto
                if ($this->adjunto) {
                    $this->reporte->update([
                        'adjunto' => $this->adjunto->store('filesOrdenesCompra', 'public'),
                        'observaciones' => $this->observaciones,
                        'horas' => $this->horas,
                        'requiere_transporte' => $this->siOno,
                        'fecha_ejecucion' => $this->fecha_ejecucion,
                        'aprobado' => 1 //0:recien creado | 1: diligenciado | 2:aceptado | 3: rechazado
                    ]);
                    session()->flash('message', 'Orden y Archivo guardados correctamente.');
                    Myhelp::EscribirEnLog($this,'diligenció la orden ' . $this->reporte->id . ' y actualizao su adjunto');

                    return redirect()->to('dashboard');
                } else {
                    $this->reporte->update([
                        'fecha_ejecucion' => $this->fecha_ejecucion,
                        'observaciones' => $this->observaciones,
                        'horas' => $this->horas,
                        'requiere_transporte' => $this->siOno,
                        'aprobado' => 1 //0:recien creado | 1: diligenciado | 2:aceptado | 3: rechazado
                    ]);
                    session()->flash('message', 'Orden guardada correctamente.');
                    Myhelp::EscribirEnLog($this,'diligenció la orden ' . $this->reporte->id . ' y no actualizó adjunto');

                    return redirect()->to('dashboard');
                }
            } else { // sin adjunto
                $this->reporte->update([
                    'fecha_ejecucion' => $this->fecha_ejecucion,
                    'observaciones' => $this->observaciones,
                    'horas' => $this->horas,
                    'requiere_transporte' => $this->siOno,
                    'aprobado' => 1 //0:recien creado | 1: diligenciado | 2:aceptado | 3: rechazado
                ]);
                session()->flash('message', 'Orden guardada correctamente.');
                Myhelp::EscribirEnLog($this,'actualizo la orden ' . $this->reporte->id . ' que no era capacitacion (SIN adjunto)');
                return redirect()->to('dashboard');
            }
        } catch (\Throwable $th) {
            session()->flash('messageError', 'Orden de compra no guardada, error inesperado');
            Myhelp::EscribirEnLog($this,'',1,$th);
        }
    }

    public function render()
    {
        $this->codigosPendientes = OrdenCompra::all();
        return view('livewire.tabla-actions.action-rechazados-asesor');
    }
}
