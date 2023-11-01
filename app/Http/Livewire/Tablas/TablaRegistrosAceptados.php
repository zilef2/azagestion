<?php

namespace App\Http\Livewire\Tablas;

use App\Models\OrdenCompra_User;
use App\Models\Reporte;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\DateColumn;


class TablaRegistrosAceptados extends LivewireDatatable
{
    public $hideable = 'select';

    public $estado;
    public $perPage;
    public $model = OrdenCompra_User::class;

    public function builder (){
        $Resultado = Reporte::query()
            ->Join('orden_compras','orden_compras.id','reportes.orden_compra_id')
            ->Join('municipios','municipios.id','reportes.municipio_id')
            ->Join('users','users.id','reportes.user_id')
            ->where('aprobado',$this->estado);
        /*
            aprobado = 0 no se ha diligenciado 
            aprobado = 1 se dilingencio 
            aprobado = 2 se aprobo por el revisor
            aprobado = 3 rechazo por el revisor
            aprobado = 4 aprobado por completo
         */
        Return $Resultado;
    }

    public function columns() {
        $elReturn = [];
        if($this->estado === 2){
            $elReturn = [
                Column::callback(['reportes.id','horas'], function ($reportesid,$noUse) {
                    $estilo1 = 'basis-1/2 text-blue-600 h-10 rounded cursor-pointer center -pt-5';
                    return view('livewire.tablas.aceptar-orden', [
                        'id' => $reportesid,
                        'estilo1' => $estilo1,
                    ]);
                })->label('Aceptar'),
                
                Column::callback(['reportes.id','fecha_reporte'], function ($reportesid,$nouse) {
                    $estilo1 = 'basis-1/2 text-blue-600 h-10 rounded cursor-pointer center -pt-5';

                    return view('livewire.tablas.rechazar-orden', [
                        'id' => $reportesid,
                        'estilo1' => $estilo1,
                    ]); 
                })->label('Opciones'),
            ];
        }

        $elReturn2 = [
            Column::name('users.name')->label('Nombre')->searchable(),
            Column::name('orden_compras.codigo')->label('OC')->searchable(),

            NumberColumn::name('horas')->label('horas ejecutadas'),
            NumberColumn::name('orden_compras.horasaprobadas')->label('horas solicitadas'),
            NumberColumn::name('aprobadas')->label('horas Aprobadas'),
            BooleanColumn::name('reportes.bancohoras')->label('Banco de horas'),                

            DateColumn::name('fecha_reporte')->label('fecha del reporte'),
            DateColumn::name('fecha_ejecucion')->label('Ejecución'),
            BooleanColumn::name('requiere_transporte')->label('requiere transporte'),
            Column::name('municipios.nombre')->label('municipio'),
            BooleanColumn::name('adjunto')->label('adjunto')->hide(),
            Column::name('observaciones')->label('observaciones'),
            Column::name('justificacion')->label('justificacion'),

            DateColumn::callback(['updated_at'], function ($updated_at) {
                return Carbon::createFromDate($updated_at)->diffForHumans(Carbon::now());
            })->label('Actualizado')->hide()->defaultSort('desc'),

        ];
        $finalR = array_merge($elReturn,$elReturn2);
        return $finalR;
    }

    public function aceptarReporte($id)
    {
        $reporte=Reporte::find($id);
        // $IntAceptar = $this->estado == 2 ? 4 : 4; 
        $reporte->update([
            'aprobado' => 4,
            // 'justificacion' => '' //todo: preguntar si se elimina este comentario
        ]);

        return redirect(request()->header('Referer'));
    }
}

