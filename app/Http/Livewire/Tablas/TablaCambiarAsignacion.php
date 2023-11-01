<?php

namespace App\Http\Livewire\Tablas;

use Livewire\Component;

use App\Models\OrdenCompra_User;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\DateColumn;


class TablaCambiarAsignacion extends LivewireDatatable
{
    public $hideable = 'select';

    // public $perPage;
    public $model = OrdenCompra_User::class;

    public function builder (){
        // $this->perPage = 15;

        $asd= OrdenCompra_User::query()
                ->leftJoin('orden_compras','orden_compras.id','orden_compra_users.orden_compra_id')
                ->leftJoin('users','users.id','orden_compra_users.user_id');
// dd( $asd->get() );
                Return $asd;
    }

    public function columns() {
        $elReturn = [
                Column::name('users.name')->label('Nombre')->filterable($this->names),
                Column::name('users.email')->label('email')->hide(),
                Column::name('orden_compras.codigo')->label('codigo'),
                Column::name('orden_compra_id')->label('Orden Numero'),
                // Column::name('user_id')->label('user_id'),
                // Column::name('tprocesos.nombre')->label('Proceso')->filterable($this->tprocesos),

                DateColumn::callback(['updated_at'], function ($updated_at) {
                    return Carbon::createFromDate($updated_at)->diffForHumans(Carbon::now());
                })->label('Actualizado')->defaultSort('desc'),

                Column::callback(['id'], function ($id) {
                    return view('livewire.tabla-actions',
                        ['id' => $id,'tabla'=>"cambiarAsignacion"]);
                })->label('Editar'),
            ];



            // if (Auth::user()->is_admin>1) {
                $elReturn[]=Column::delete()->label('Eliminar')->hide();
            // }
            return $elReturn;
    }

    // public function getTprocesosProperty()
    // {
    //     return tprocesos::pluck('nombre');
    // }
    public function getNamesProperty()
    {
        return User::pluck('name');
    }

}
