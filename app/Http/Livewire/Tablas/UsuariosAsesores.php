<?php

namespace App\Http\Livewire\Tablas;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\DateColumn;

class UsuariosAsesores extends LivewireDatatable
{
    public $hideable = 'select';

    public $perPage;
    public $model = User::class;

    public function builder() {
        // $this->perPage = 15;
        // $userid = Auth::user()->id;
        $Resultado = User::query()
                ->where('rol_id',3)
                ->where('is_admin',0)
                ;
        Return $Resultado;
    }

    public function columns() {
        $elReturn = [
                Column::name('name')->label('Nombre')->filterable($this->names)->searchable(),
                Column::name('email')->label('email')->editable()->searchable(),
                Column::name('cedula')->label('cedula')->searchable(),
                Column::name('cedula2')->label('cedula inicial (automatica)'),

                DateColumn::callback(['updated_at'], function ($updated_at) {
                    return Carbon::createFromDate($updated_at)->diffForHumans(Carbon::now());
                })->label('Actualizado')->defaultSort('desc'),
            ];
            if (Auth::user()->is_admin >= 1) {
                $elReturn[]=Column::delete()->label('Eliminar')->hide();
            }
            return $elReturn;
    }

    public function getNamesProperty() {
        return User::where('rol_id',3)->where('is_admin',0)->pluck('name');
    }

}

