<?php

namespace App\Http\Livewire\Tabla;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\DateColumn;

class UsuariosAsignadores extends LivewireDatatable{
public $hideable = 'select';
public $limitante;
// public $model = OrdenCompra_User::class;
public $model = User::class;


public function builder (){
    $Resultado = User::Where('rol_id', 2)->Where('is_admin',0);
        // dd($Resultado->get());
    Return $Resultado;
}

public function columns() {
    $elReturn = [
            Column::name('name')->label('Nombre')->searchable(),
            Column::name('email')->label('email'),
            Column::name('cedula')->label('cedula'),
            DateColumn::callback(['updated_at'], function ($updated_at) {
                return Carbon::createFromDate($updated_at)->diffForHumans(Carbon::now());
            })->label('Actualizado')->defaultSort('desc')
        ];

        if (Auth::user()->is_admin>=1) {
            $elReturn[]=Column::delete()->label('Eliminar')->hide();
        }

        return $elReturn;
}
public function getNamesProperty()
{
    return User::pluck('name');
}

}
