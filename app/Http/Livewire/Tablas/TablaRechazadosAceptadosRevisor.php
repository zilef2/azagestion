<?php

namespace App\Http\Livewire\Tablas;

use Carbon\Carbon;
use App\Models\Reporte;
use App\Models\OrdenCompra;
use App\Models\OrdenCompra_User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;


class TablaRechazadosAceptadosRevisor extends LivewireDatatable
{
    public $hideable = 'select';

    public $perPage,$horasAprob=[];
    public $model = OrdenCompra::class;
    // public $model = OrdenCompra_User::class;

    public function builder (){

        $Resultado = Reporte::query()
            ->Join('orden_compras','orden_compras.id','reportes.orden_compra_id')
            ->Join('empresas','empresas.id','orden_compras.empresa_id')
            ->Join('tareas','tareas.id','orden_compras.tarea_id')
            
            ->Join('users','users.id','reportes.user_id')
            ->Join('municipios','municipios.id','reportes.municipio_id')
            ->Join('clasificacions','clasificacions.id','orden_compras.clasificacion_id')
            ->where('aprobado',1);

        /* aprobado = 0 no se ha diligenciado aprobado = 1 se dilingencio aprobado = 2 se aprobo por el revisor aprobado = 3 rechazo por el revisor aprobado = 4 aprobado por completo */
        Return $Resultado;
    }

    public function columns() {
        $elReturn = [
                Column::callback(['reportes.id','horas'], function ($reportesid,$noUse) {
                    $estilo1 = 'basis-1/2 text-blue-600 h-10 rounded cursor-pointer center -pt-5';
                    return view('livewire.tablas.aceptar-orden', [
                        'id' => $reportesid,
                        'estilo1' => $estilo1,
                    ]);
                })->label('Aceptar'),
                // rechazar
                Column::callback(['reportes.id','fecha_reporte'], function ($reportesid,$nouse) {
                        $estilo1 = 'basis-1/2 text-blue-600 h-10 rounded cursor-pointer center -pt-5';

                        return view('livewire.tablas.rechazar-orden', [
                            'id' => $reportesid,
                            'estilo1' => $estilo1,
                        ]); 
                })->label('Opciones'),

                Column::name('users.name')->label('Nombre')->searchable(),
                Column::name('orden_compras.codigo')->label('OC/OS')->searchable(),

                NumberColumn::name('orden_compras.horasaprobadas')->label('horas solicitadas'), 
                NumberColumn::name('reportes.horas')->label('horas ejecutadas'),
                NumberColumn::name('reportes.aprobadas')->label('horas aprobadas'),


                BooleanColumn::name('reportes.bancohoras')->label('Banco de horas'),                
                Column::name('clasificacions.nombre')->label('Clasificación'),
                DateColumn::name('reportes.fecha_reporte')->label('Fecha del reporte')->hide(),
                DateColumn::name('reportes.fecha_ejecucion')->label('Ejecución'),
                Column::name('empresas.nombre')->label('Empresa'),
                Column::name('tareas.nombre')->label('Tarea')->unwrap(),
                Column::name('reportes.observaciones')->label('observaciones'),


                BooleanColumn::name('reportes.requiere_transporte')->label('requiere transporte'),
                Column::name('municipios.nombre')->label('municipio'),

                BooleanColumn::name('reportes.adjunto')->label('adjunto')->hide(),

                DateColumn::callback(['reportes.updated_at'], function ($updated_at) {
                    return Carbon::createFromDate($updated_at)->diffForHumans(Carbon::now());
                })->label('Actualizado')->defaultSort('desc')->hide(),


                Column::callback(['reportes.id','adjunto'], function ($reportesid,$adjunto) {
                    $estilo1 = 'basis-1/2 text-blue-600 h-10 rounded cursor-pointer center -pt-5';

                    return view('livewire.tablas.pdf-orden', [
                        'id' => $reportesid,
                        "adjunto" => $adjunto,
                        'estilo1' => $estilo1,
                    ]); })->label('Soporte'),
            ];
            // if (Auth::user()->is_admin>1) { $elReturn[]=Column::delete()->label('Eliminar')->hide(); }
            return $elReturn;
    }

    public function aceptarReporte($id) {
        $ListaControladoresYnombreClase = (explode('\\',get_class($this))); $nombreC = end($ListaControladoresYnombreClase);
        
        $reporte = Reporte::find($id);

        if($reporte->aprobado == 1){
            $reporte->update([
                'aprobado' => 4,
                'aprobadas' => $reporte->horas
            ]);
        }else{
            $reporte->update([
                'aprobado' => 4,
            ]);
        }
            
        Log::info('Tabla: ' . $nombreC. ' U:'.Auth::user()->name. ' Se aprobó el reporte = '.$id);
        return redirect(request()->header('Referer'));
    }

    public function aceptarAmediasReporte($id) {//not using
        $reporte=Reporte::find($id);
        $reporte->update([
            'aprobado' => 2
        ]);
        return redirect(request()->header('Referer'));
    }

    public function changeHoras($id) {//not using
        Reporte::find($id)->update([
            'aprobadas' => $this->horasAprob[$id]
        ]);
    }
}
