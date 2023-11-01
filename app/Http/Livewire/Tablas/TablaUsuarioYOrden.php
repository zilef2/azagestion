<?php

namespace App\Http\Livewire\Tablas;

use App\Models\OrdenCompra;
use App\Models\OrdenCompra_User;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\DateColumn;

class TablaUsuarioYOrden extends LivewireDatatable {
    public $hideable = 'select';
    public $limitante;
    // public $model = OrdenCompra_User::class;
    public $model = User::class;

    public function builder (){
        if($this->limitante == "0"){
            $utlimosIds = OrdenCompra::Pluck('id');
        }else{
            $utlimosIds = OrdenCompra::take($this->limitante)->pluck('id');
        }

        $Resultado = User::Join('orden_compra_users','orden_compra_users.user_id','users.id')
            ->Join('orden_compras','orden_compras.id','orden_compra_users.orden_compra_id')->distinct()
            ->whereIn('orden_compras.id', $utlimosIds)
            ;
            // dd($Resultado->get());
        Return $Resultado;
    }

    public function columns() {
        $elReturn = [
                // Column::name('name')->label('Nombre')->filterable($this->names),
                Column::name('name')->label('Nombre')->searchable(),
                Column::name('email')->label('email')->hide(),
                Column::name('cedula')->label('cedula')->hide(),
                Column::name('cedula2')->label('cedula inicial (automatica)')->hide(),
                Column::name('orden_compras.codigo')->label('OC/OS'),
                Column::name('orden_compras.fecha')->label('Fecha Aprobacion'),
                Column::name('orden_compras.horasaprobadas')->label('horas solicitadas'),
                DateColumn::callback(['updated_at'], function ($updated_at) {
                    return Carbon::createFromDate($updated_at)->diffForHumans(Carbon::now());
                })->label('Actualizado')->defaultSort('desc')
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
