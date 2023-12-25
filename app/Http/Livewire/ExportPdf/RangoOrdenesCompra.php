<?php

namespace App\Http\Livewire\ExportPdf;

use App\Exports\ReportesExport;
use App\helpers\Myhelp;
use App\Models\OrdenCompra;
use App\Models\Reporte;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class RangoOrdenesCompra extends Component
{
    use WithFileUploads;

    public $fechaini, $fechafin, $nombreC;
    public $primerR, $ultimoR;
    // public $fechaini="2023-04-30T05:00"; public $fechafin="2023-05-13T15:00";

    public $validate = true, $totalHoras = 0, $totalReportes = 0;

    public function mount()
    {
        Myhelp::EscribirEnLog($this);

    }

    public function updated()
    {
        if ($this->fechaini && $this->fechafin) {
            $this->validate = strtotime($this->fechaini) <= strtotime($this->fechafin);
            if ($this->validate) {
                $reportes = Reporte::WhereBetween('fecha_reporte', [$this->fechaini, $this->fechafin])
                    ->WhereIn('aprobado', [2, 4])
                    ->get();

                $total = 0;
                foreach ($reportes as $value) {
                    if (User::find($value->user_id)) {
                        $total += floatval($value->horas);
                    }
                }
                $this->totalHoras = $total;
                $this->totalReportes = count($reportes);

                $reportesOtraVez = Reporte::WhereBetween('fecha_reporte', [$this->fechaini, $this->fechafin])
                    ->WhereIn('aprobado', [2, 4]);
                $primeR = $reportesOtraVez->first();
                $ultimr = $reportesOtraVez->latest()->first();
                if ($primeR != null) {
                    $this->primerR = OrdenCompra::find($primeR->orden_compra_id)->codigo;
                    $this->primerR .= ' - ' . User::find($primeR->user_id)->name;
                    $this->primerR .= ' el ' . $this->mostrarFechasSinAnio($primeR->fecha_reporte);
                } else {
                    $primeR = '';
                }
                if ($ultimr != null) {
                    $this->ultimoR = OrdenCompra::find($ultimr->orden_compra_id)->codigo;
                    $this->ultimoR .= ' - ' . User::find($ultimr->user_id)->name;
                    $this->ultimoR .= ' el ' . $this->mostrarFechasSinAnio($ultimr->fecha_reporte);
                } else {
                    $ultimr = '';
                }
            } else {
                session()->flash('message', 'La fecha inicial tiene que ser anterior a la final.');
            }
        }
    }

    public function mostrarFechasSinAnio($fechaString)
    {
        Carbon::setLocale('es');
        $fecha = Carbon::create($fechaString);
        if (Carbon::now()->year == $fecha->year) {
            return $fecha->isoFormat('dddd D [de] MMMM h:mm A');
        } else {
            return $fecha->isoFormat('dddd D [de] MMMM [de] YYYY h:mm A');
        }
    }

    public function arreglarFechas()
    {
        $fecha1 = strtotime($this->fechaini);
        $fecha2 = strtotime($this->fechafin);
        if (date('Y', $fecha1) == date('Y', $fecha2)) {
            return '' . date('j M', $fecha1) . ' - ' . date('j M', $fecha2);
        } else {
            return '' . date('j M Y', $fecha1) . ' - ' . date('j M Y', $fecha2);
        }
    }

    public function DescargarOrdenes()
    {
        // dd($this->fechaini);
        if ($this->fechaini && $this->fechafin) {
            $this->validate = strtotime($this->fechaini) <= strtotime($this->fechafin);
        }
        if ($this->validate) {
            try {
                Myhelp::EscribirEnLog($this);
                return Excel::download(
                    new ReportesExport($this->fechaini, $this->fechafin),
                    'RelacionEntrega - ' . $this->arreglarFechas() . '.xlsx'
                );
            } catch (\Throwable $th) {
                $this->addError('archivoExcelSubir', "Formato invalido");
                if (config('app.env') === 'production') {
                    session()->flash('messageError', $th->getMessage());
                } else {
                    session()->flash('messageError', $th->getMessage() . ' :__: ' . substr($th, 0, 700));
                }
                Myhelp::EscribirEnLog($this,'',1,$th);
            }
        } else {
            $mensajeFinal = 'La fecha inicial tiene que ser inferior a la final.';
            session()->flash('message', $mensajeFinal);
            Myhelp::EscribirEnLog($this,$mensajeFinal,2);
        }
    }

    public function render()
    {
        return view('livewire.export-pdf.rango-ordenes-compra');
    }
}
