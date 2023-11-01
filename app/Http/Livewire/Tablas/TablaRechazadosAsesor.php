<?php

namespace App\Http\Livewire\Tablas;

use App\Models\OrdenCompra_User;
use App\Models\Reporte;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\TimeColumn;

class TablaRechazadosAsesor extends LivewireDatatable
{
    public $hideable = 'select';

    public $perPage;
    public $model = OrdenCompra_User::class;

    public function builder (){
        $idUser = Auth::user()->id;
        // $OrdenesDelUsuario = OrdenCompra_User::Where('user_id',$idUser)->pluck('orden_compra_id')->unique();
        
        $Resultado = Reporte::query()
        ->Join('orden_compras','orden_compras.id','reportes.orden_compra_id')
        // ->Join('orden_compra_users','orden_compra_users.orden_compra_id','orden_compras.id')
        ->Join('users','users.id','reportes.user_id')
        ->where('reportes.user_id',$idUser)
        ->where('aprobado',3)
        ;
        /*
            aprobado = 0 no se ha diligenciado
            aprobado = 1 se dilingencio 
            aprobado = 2 se aprobo por el revisor
            aprobado = 3 rechazo por el revisor
         */
        Return $Resultado;
    }

    public function columns() {
        $elReturn = [
                // Column::name('users.name')->label('Nombre'),
                // Column::name('users.email')->label('email')->hide(),
                Column::name('orden_compras.codigo')->label('OC/OS'),

                NumberColumn::name('horas')->label('horas ejecutadas'),
                DateColumn::name('fecha_reporte')->label('fecha_reporte'),
                Column::name('observaciones')->label('observaciones'),
                BooleanColumn::name('requiere_transporte')->label('requiere transporte'),
                Column::name('justificacion')->label('justificacion'),
                // Column::name('orden_compras.justificacion')->label('justificación'),
                // Column::name('users.name')->label('Asesor'),

                // DateColumn::name('updated_at ')->label('Actualizado')->defaultSort('desc')->hide(),
                // TimeColumn::name('updated_at')->label('Actualizado H')->defaultSort('desc')->hide(),
                DateColumn::callback(['updated_at'], function ($updated_at) {
                    return Carbon::createFromDate($updated_at)->diffForHumans(Carbon::now());
                })->label('Actualizado')->defaultSort('desc')->hide(),

                Column::callback(['id'], function ($id) {
                    return view('livewire.tabla-actions',
                        ['id' => $id,'tabla'=>"ActionRechazadosAsesor"]);
                })->label('Corregir'),
            ];
            // if (Auth::user()->is_admin>1) {
            //     $elReturn[]=Column::delete()->label('Eliminar')->hide();
            // }

            return $elReturn;
    }
    public function getNamesProperty()
    {
        return User::pluck('name');
    }

}
