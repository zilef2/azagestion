<?php

namespace App\Imports;

use App\helpers\Myhelp;
use App\Models\OrdenCompra;
use App\Models\Reporte;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\OnEachRow;

//validacion
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Row;
//,SkipsEmptyRows,WithValidation, WithHeadingRow,  SkipsOnError, SkipsOnFailure
class OrdenesDesactualizadasImport implements WithStartRow,ShouldQueue,WithChunkReading,
    ToCollection {
    //OnEachRow

     use Importable;
    /* columnas - posicion en $row: [
            0 A   id
            1 B   codigo
            2 C   fecha
            3 D   horasaprobadas
            4 E   horasdisponibles
            5 F   horasEjecutadas AZA
            6 G   Cumplimiento micrositio
            7 H   Valor a subir  a la BD
            8 I   Subir este valor a la BD para igualar el  valor del micrositio con el valor ejecutado en AZA
    */
    public $NumberColumsLeidas,$NumberReportesSinUser,$BadFormat; //errores

    public function __construct(){
//        $this->thisYear = (int)date('Y');
        $this->NumberColumsLeidas = 0;
        $this->NumberReportesSinUser = 0;
        $this->NumberReportesCreados = 0;
        $this->OrdenConInsuficientesHoras = [];
        $this->ordenesNocoincidenModel = [];
        $this->ordenesNocoincidenCodigo = [];
        $this->BadFormat = false;
    }

    //<editor-fold desc="GETS">
    public function getNumberReportesSinUser():int{return $this->NumberReportesSinUser;}
    public function getNumberColumsLeidas():int{return $this->NumberColumsLeidas;}
    public function getNumberReportesCreados():int{return $this->NumberReportesCreados;}
    public function getHasBadFormat():bool{return $this->BadFormat;}
    public function getOrdenConInsuficientesHoras():array{return $this->OrdenConInsuficientesHoras;}
    public function getOrdenesNocoincidenModel():array{return $this->ordenesNocoincidenModel;}
    public function getOrdenesNocoincidenCodigo():array{return $this->ordenesNocoincidenCodigo;}
    //</editor-fold>

    public function startRow(): int{return 2;}
    public function chunkSize(): int{return 500;} //WithCalculatedFormulas,

//    public function onRow(Row $row) {
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {

//                $rowIndex = $row->getIndex();
//                $row = $row->toArray();
                $this->NumberColumsLeidas++;
                $fechaDiciembre = Carbon::createFromDate(2023, 12, 8, 'America/Bogota');
                $fechaDiciembreDateTime = Carbon::create(2023, 12, 1, 11, 0, 0, 'America/Bogota');
                $numeroOrden = (int)$row[1];
                $orden = OrdenCompra::Where('codigo', $numeroOrden)->first();

                //la columna Valor a subir  a la BD debe ser entero y  Subir este valor a la BD...debe ser cadena
                if ($orden) {
                    $userReciente = $orden->users()->orderByPivot('created_at', 'desc')->first();
                    if (is_numeric($row[7]) && is_string($row[8])) {
                        if ($numeroOrden == $orden->codigo) {

                            $FloatHorasAprov = (float)$row[3];
                            $FloatHorasDisponibles = (float)$row[4];
                            $valorActualizar = (float)$row[7];
                            $horasDisponibles = $FloatHorasDisponibles - $valorActualizar;
                            if (is_numeric($horasDisponibles)) {
                                /* columnas - posicion en $row: [
                                    0 A   id +
                                    1 B   codigo
                                    2 C   fecha
                                    3 D   horasaprobadas+
                                    4 E   horasdisponibles+
                                    5 F   horasEjecutadas AZA
                                    6 G   Cumplimiento micrositio
                                    7 H   Valor a subir  a la BD+
                                    8 I   Subir este valor a la BD para igualar el  valor del micrositio con el valor ejecutado en AZA+
                                */
    //                        $orden->update([
    //                            'horasdisponibles' => $horasDisponibles
    //                        ]);

                                //REPORTE => aprobado //0:recien creado | 1: diligenciado | 2:casi aceptado | 3: rechazado | 4:aprobado totalmente
                                Reporte::Create([
                                    'horas' => $valorActualizar,
                                    'observaciones' => $row[8],

                                    //valores pedidos por aza
                                    'fecha_reporte' => $fechaDiciembreDateTime,
                                    'fecha_ejecucion' => $fechaDiciembre,

                                    'aprobado' => 4,
                                    'aprobadas' => $FloatHorasAprov,
                                    'orden_compra_id' => $orden->id,
                                    'user_id' => $userReciente->id,
                                    'requiere_transporte' => 0,
                                    'municipio_id' => 71,//medellin
                                ]);
                                $this->NumberReportesCreados++;
                            }
                        } else {
                            $this->ordenesNocoincidenModel[$this->NumberColumsLeidas] = 'Excel codigo: ' . $numeroOrden;
                            $this->ordenesNocoincidenCodigo[$this->NumberColumsLeidas] = $orden->id . '--' . $orden->codigo;
                        }
                    } else {
                        $this->BadFormat = true;
                    }
                } else {
                    $this->NumberReportesSinUser++;

                }
        }
    }
}
