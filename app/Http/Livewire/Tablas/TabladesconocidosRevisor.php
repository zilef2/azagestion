<?php

namespace App\Http\Livewire\Tablas;

use App\Models\User;
use Illuminate\Support\Carbon;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\DateColumn;

class TabladesconocidosRevisor extends LivewireDatatable
{
    public $hideable = 'select';
    public $model = User::class;

    public function builder()
    {
        $Resultado = User::query()
            ->where('email', 'like', '%UsuarioDescono%');
        return $Resultado;
    }

    public function columns()
    {
        $elReturn = [
            Column::name('name')->label('Nombre')->editable()->searchable(),
            Column::name('email')->label('email')->editable()->searchable(),
            Column::name('cedula')->label('cedula')->editable(),
            Column::name('cedula2')->label('cedula inicial (automatica)'),

            DateColumn::callback(['updated_at'], function ($updated_at) {
                return Carbon::createFromDate($updated_at)->diffForHumans(Carbon::now());
            })->label('Actualizado')->defaultSort('desc'),

        ];
        // if (Auth::user()->is_admin>1) {
        //     $elReturn[]=Column::delete()->label('Eliminar')->hide();
        // }
        return $elReturn;
    }
}
