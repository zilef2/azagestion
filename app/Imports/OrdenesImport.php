<?php

namespace App\Imports;

use App\helpers\Myhelp;
use App\Models\Clasificacion;
use App\Models\Empresa;
use App\Models\Historicoc;
use App\Models\OrdenCompra;
use App\Models\OrdenCompra_User;
use App\Models\Reporte;
use App\Models\Tarea;
use App\Models\User;
use DateTime;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

//validacion
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Row;



//,WithValidation, WithHeadingRow,  SkipsOnError, SkipsOnFailure,ShouldQueue
class OrdenesImport implements OnEachRow, WithCalculatedFormulas,SkipsEmptyRows,WithChunkReading, WithStartRow {
     use Importable;
    /*
        posiciones: [
            A - 0 numero de orden
            B - 1 fecha de aprobacion
            G - 6 empresa
            H - 7 tarea
            J - 9 clasificacion
            L - 11 prestador
            M - 12 cantidad pedida            /N - 13 CANTIDAD SIN PROGRAMAR
            U - 20 estado de la tarea
        ]
    */
    public $thisYear; //to make usuarioDesconocido
    public $NumberColums;

    public function __construct()
    {
        $this->thisYear = (int)date('Y');
        $this->NumberColums = 0;
        $this->NumberColumsExecuted = 0;
        $this->TieneFormulas = false;
    }

    //<editor-fold desc="GETS">
    public function getNumberColums():int{return $this->NumberColums;}
    public function getNumberColumsExecuted():int{return $this->NumberColumsExecuted;}
    public function getHasFormulas():bool{return $this->TieneFormulas;}
    //</editor-fold>

    public function startRow(): int{return 2;}

    public function onRow(Row $row) {
        $rowIndex = $row->getIndex();
//        if (!isset($row[0]) || !isset($row[20]) || $row[0] === "ORDEN" || trim($row[0]) === "ORDEN" || $row[1] == "1" ) {
//            return null;
//        }
        $lafecha = $row[1];
        //the date fix
        if(is_numeric($row[1])){ //toproof
            $unixDate = ($lafecha - 25568) * 86400;
            // $unixDate = ($lafecha - 25569) * 86400;
            $readableDate = date('Y/m/d', $unixDate);
            $fechaAprobacion = DateTime::createFromFormat('Y/m/d', $readableDate);

            if($fechaAprobacion === false){
                $fechaAprobacion = DateTime::createFromFormat('Y/m/d', $lafecha);
                if ($fechaAprobacion === false) {
                    $fechaAprobacion = DateTime::createFromFormat('d/m/Y', $lafecha);
                    if ($fechaAprobacion === false) {
                        throw new \Exception('Fecha inválida. Fila '.$rowIndex);
                        // throw new \Exception('Fecha inválida '.$lafecha. ' --++--');
                    }
                }
            }
        }else{
            $fechaAprobacion = DateTime::createFromFormat('Y/m/d', $lafecha);
            if ($fechaAprobacion === false) {
                $fechaAprobacion = DateTime::createFromFormat('d/m/Y', $lafecha);
                if ($fechaAprobacion === false) {
                    throw new \Exception('Fecha inválida '.$lafecha. ' La fila '.$rowIndex );
                }
            }
        }

        //busca la orden de compra por codigo
        $OrdenCompraPorCodigo = OrdenCompra::Where('codigo',$row[0])->get();

        if(!is_numeric($row[18])){
            $this->TieneFormulas = true;
            return null;
        }

        if (($row[20] === "EJECUTADA" || $row[20] === "ejecutada" || $row[20] === "Ejecutada") && $row[18] <= 0){
            if (($OrdenCompraPorCodigo->count() != 0)) {
                $orden = $OrdenCompraPorCodigo->first();
                $orden->update([
                    'estado_tarea' => 1, //0 cuando aun no ha sido ejecutada | 1 cuando en el archivo de excel aparece ejecutada
                ]);
                $this->NumberColumsExecuted++;
            }
        }
        $this->NumberColums++;
        /*
            posiciones: [
                A 0 numero de orden
                B 1 fecha de aprobacion
                G 6 empresa
                H 7 tarea
                J 9 clasificacion
                L 11 prestador
                M 12 CANTIDAD PEDIDA //excel = horasaprobadas|  -> no se lee (N 13 CANTIDAD SIN PROGRAMAR)
                S 18 cantida pendiente por facturar (no se guarda en la BD)
                U 20 estado de la tarea
            ]
        */

        //editor-fold "empresa-tarea-clasificacion"
//            $empresaPorNombre = Empresa::Where('nombre',$row[6])->get();
            $empresaPorNombre = Empresa::Where('nombre','LIKE','%'.$row[6].'%')->get();

            if (($empresaPorNombre->count() === 0)) {
                $empresa = Empresa::Create(['nombre' => $row[6] ]);
                $empresaid = $empresa->id;
            }else{
                $empresaid = $empresaPorNombre->first()->id;
            }

//            $tareaPorNombre = Tarea::Where('nombre',$row[7])->get();
            $tareaPorNombre = Tarea::Where('nombre','LIKE','%'.$row[7].'%')->get();
            if (($tareaPorNombre->count() == 0)) {
                $tarea = Tarea::firstOrCreate(['nombre' => $row[7] ]);
                $tareaid = $tarea->id;
            }else{
                $tareaid = $tareaPorNombre->first()->id;
            }

//            $ClasificacionPorNombre = Clasificacion::Where('nombre',$row[9])->get();
            $ClasificacionPorNombre = Clasificacion::Where('nombre','LIKE','%'.$row[9].'%')->get();
            if (($ClasificacionPorNombre->count() == 0)) {
                $Clasificacion = Clasificacion::firstOrCreate(['nombre' => $row[9] ]);
                $Clasificacionid = $Clasificacion->id;
            }else{
                $Clasificacionid = $ClasificacionPorNombre->first()->id;
            }

        //si ya esta, solo actualize datos que no se llenan en el diligenciado
        $ordenid = 0;
        if (($OrdenCompraPorCodigo->count() == 0)) {
            $orden = OrdenCompra::Create([
                'codigo' => $row[0],
                'fecha' => $fechaAprobacion,
                'horasaprobadas' => $row[12],//excel = cantidad pedida
                'horasdisponibles' => $row[12],

                'empresa_id' => $empresaid,
                'tarea_id' => $tareaid,//7
                'clasificacion_id' => $Clasificacionid,//9
                'estado_tarea' => 0

            ]);
            $ordenid = $orden->id;
        }else{
            $orden = $OrdenCompraPorCodigo->first();
            $SusReportes = Reporte::where('orden_compra_id',$orden->id);
            if($SusReportes)
            $horasReportadas = $SusReportes->sum('horas');

            $orden->update([
                'fecha' => $fechaAprobacion,
                'horasaprobadas' => $row[12],
                'horasdisponibles' => $row[12] - $horasReportadas, // todo : validate
                'empresa_id' => $empresaid,
                'tarea_id' => $tareaid,
                'clasificacion_id' => $Clasificacionid,
                'estado_tarea' => 0
            ]);
            $ordenid = $orden->id;
        }

        // #USUARIOS
        $usuarioSLug = User::where('name_no_spaces', str_replace(' ', '', $row[11]))->get();

        // if (count($usuarioPorNombre) == 0 && count($usuarioSLug) == 0) {
        if (count($usuarioSLug) === 0) {
            $numAleatorio = random_int(100100,1001001);

            while (User::where('email', "UsuarioDesconocido".$numAleatorio."@test.com")->exists()) {
                $numAleatorio = (random_int(100100,200100) *100) + $this->thisYear;
            }
            $usuario = User::firstOrCreate([
                'name'      => $row[11],
                'name_no_spaces' => str_replace(' ', '', $row[11]),
                'email'     => "UsuarioDesconocido".$numAleatorio."@test.com",
                'cedula'  => $numAleatorio,
                'cedula2'  => $numAleatorio,
                'password'  => bcrypt($numAleatorio."*"),
                'is_admin'  => 0,
                'rol_id'    => 3,
            ]);
            if (($OrdenCompraPorCodigo->count() == 0)) {
                OrdenCompra_User::create([
                    'orden_compra_id' => $ordenid,
                    'user_id' => $usuario->id
                ]);
            }
            // comprobar que realmente sea nuevo usuario, y no que solo sea una fila con el mismo user
            $nuevosUs = session('CountNuevosUsuarios',0);
            session(['CountNuevosUsuarios' => $nuevosUs+1]);
        }else{
            //toproof: si ya no le quedan horas disponibles en la reasignacion
            OrdenCompra_User::firstOrCreate([
                'orden_compra_id' => $ordenid,
                'user_id' => $usuarioSLug->first()->id
            ]);
        }
    }

    public function chunkSize(): int{return 500;}

    public function onError(\Throwable $e)
    {
        Myhelp::EscribirEnLog($this,'',1,$e);
    }
}
