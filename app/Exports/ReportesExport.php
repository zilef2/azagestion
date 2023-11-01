<?php

namespace App\Exports;

use App\Models\Clasificacion;
use App\Models\Empresa;
use App\Models\Municipios;
use App\Models\OrdenCompra;
use App\Models\Reporte;
use App\Models\Tarea;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportesExport implements FromView,ShouldAutoSize,WithStyles
{
    use Exportable;

    public $ini,$fin;
    public function __construct(string $ini,string $fin) {
        $this->ini = $ini;
        $this->fin = $fin;
    }

    public function arreglarFechas() {
        $fecha1 = strtotime($this->ini);
        $fecha2 = strtotime($this->fin);
        if (date('Y', $fecha1) == date('Y', $fecha2)) {
            return 'Desde el ' . date('j M', $fecha1) . ' hasta el ' . date('j M  h:i A', $fecha2);
        } else {
            return 'Desde el ' . date('j M Y', $fecha1) . ' hasta el ' . date('j M Y  h:i A', $fecha2);
        }
    }
    
    public function styles(Worksheet $sheet) {
        $lastRow = $sheet->getHighestRow();
        // Obtiene el estilo actual de las celdas de la última fila
        $style = $sheet->getStyle('A'.$lastRow.':Z'.$lastRow);
        // Define el estilo llamativo para la última fila
        $style->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'f7d305',
                ],
            ],
            'borders' => [
                'bottom' => [
                    'borderStyle' => Border::BORDER_MEDIUM,
                    'color' => [
                        'rgb' => '000000',
                    ],
                ],
            ],
        ]);
    }
    
    public function view(): View {

        $ListaControladoresYnombreClase = (explode('\\',get_class($this)));
        $nombreC = end($ListaControladoresYnombreClase);

        $reportes = Reporte::WhereBetween('fecha_reporte',[$this->ini,$this->fin])
            ->WhereIn('aprobado',[2,4])->get();
        
        $totalHoras = 0;
        try {
            $iduserBorrado = [];
            foreach ($reportes as $key => $value) {
                if($usuario = User::find($value->user_id)){

                    $orden = OrdenCompra::find($value->orden_compra_id);
                    $reportes[$key]->UsuarioName = $usuario->name;
                    // $reportes[$key]->UsuarioName = $value->usuario->name;
                    $reportes[$key]->ordenCodigo = $orden->codigo;
                    
                    $reportes[$key]->empresa2 = Empresa::find($orden->empresa_id)->nombre;
                    $reportes[$key]->tarea  = Tarea::find($orden->tarea_id)->nombre;
                    $reportes[$key]->clasif = Clasificacion::find($orden->clasificacion_id)->nombre;
                    
                    $reportes[$key]->munici = Municipios::find($value->municipio_id)->nombre;
                    $reportes[$key]->horasaprobadas = $orden->horasaprobadas;
                    $reportes[$key]->horasaprobadasAsigna = $value->aprobadas;
                    $totalHoras += $value->horas;

                }else{
                    $iduserBorrado[] = $value->user_id;
                    unset($reportes[$key]);
                }
            }

            if($iduserBorrado === []){
                    if(Auth::User()->is_admin) {
                        log::channel('eladmin')->info('Vista:' . $nombreC. '|  U:'.Auth::user()->name. ' esta exportando '.count($reportes).' reportes');
                    }else{
                        Log::info(' U:'.Auth::user()->name. ' en la clase ' . $nombreC . ' esta exportando '.count($reportes).' reportes');
                    }
                
            }else{ // usuario borrado
                $userBorrado = User::withTrashed()->WhereIn('id',$iduserBorrado)->pluck('name');
                $usuariosBorrados = '';
                foreach ($userBorrado as $key => $value) {
                    $usuariosBorrados .= $value. ' ';
                }
                session()->flash('message', ' Algunos asesores involucrados han sido borrados: '.$usuariosBorrados);
                Log::alert(' U:'.Auth::user()->name. ' fallo en el descargable de:' .$nombreC. ' Exportacion incorrecta. Uno o mas de los usuarios involucrados han sido borrados= '.$usuariosBorrados);
            }
            // dd($reportes);
            return view('exports.excelReporte', [
                'reportes' => $reportes,
                'total0' => $totalHoras,
                'fecha' =>  $this->arreglarFechas($this->ini,$this->fin),
            ]);
        } catch (\Throwable $th) {
            session()->flash('message', ' Exportacion incorrecta. '.$th->getMessage());
            Log::critical(' U:'.Auth::user()->name. ' fallo en el descargable ' .$nombreC. ' Detalles del error: '.$th->getMessage().' _____ Error Completo => '.$th);
            return null;
        }
      
    }
}
