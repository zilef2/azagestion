<?php 

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;


class ExportablePorTablas implements FromQuery, WithTitle, WithHeadings, ShouldAutoSize
{
    private $tabla;
    // private $year;

    public function __construct($tabla) {
        $this->tabla = $tabla;
        // $this->year  = $year;
    }

    public function query() {
        
        $result = app("App\\Models\\".$this->tabla)->query();
        if($this->tabla == 'User'){
            $result = User::Where('is_admin','<',2);
        }
        // dd( $result );
        return $result;
    }

    public function headings(): array
    {
        if($this->tabla == 'Clasificacion') return [ 'id', 'Creado','Actualizado','nombre'];
        if($this->tabla == 'Empresa') return [ 'id', 'nombre','Creado','Actualizado'];
        // if($this->tabla == 'Historicoc') return [ 'id', 'Creado','Actualizado', 'codigo', 'fecha_aprobacion', 'horas_aprobadas', 'estado_tarea', 'prestador', 'empresa', 'tarea', 'clasificacion'];
        if($this->tabla == 'Municipios') return [ 'id', 'Creado','Actualizado','nombre'];
        // if($this->tabla == 'OrdenCompra_User') return [ 'id', 'Creado','Actualizado','orden_compra_id','user_id'];
        if($this->tabla == 'OrdenCompra') return [ 'id', 'Creado','Actualizado', 'codigo', 'fecha_aprobacion', 'horasaprobadas', 'horasaprobadasAsignador', 'horasdisponibles', 'estado_tarea', 'empresa_id', 'tarea_id', 'clasificacion_id'];

        if($this->tabla == 'Reporte') return [ 'id',
            'Creado',
            'Actualizado',
            'horas',
            'aprobadas',
            'fecha_reporte',
            'fecha_ejecucion',
            'observaciones',
            'requiere_transporte',
            'justificacion',
            'novedad',
            'photo',
            'aprobado',
            'adjunto',
            'bancohoras',
            'orden_compra_id',
            'user_id',
            'municipio_id'
        ];

        if($this->tabla == 'Roles') return [ 'id', 'Creado','Actualizado','nombre'];
        if($this->tabla == 'Tarea') return [ 'id', 'nombre','Creado','Actualizado'];
        if($this->tabla == 'User') return [ 'id','email', 'Creado','Actualizado','nombre',
                                            'nombreSinEspacios','es_admin','cedula', 'cedulaAutomatica',
                                             'sexo', 'cel',
                                             'Verificado','','','', 'rol_id'];
    }

    // public function columnWidths(): array
    // {
    //     return [
    //         'id' => 35,
    //         'Creado' => 75,
    //         'Actualizado' => 75,
    //     ];
    // }

    public function title(): string {
        return $this->tabla;
    }
}