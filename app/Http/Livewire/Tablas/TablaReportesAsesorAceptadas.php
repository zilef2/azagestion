<?php

namespace App\Http\Livewire\Tablas;

use App\helpers\Myhelp;
use App\Models\OrdenCompra;
use App\Models\OrdenCompra_User;
use App\Models\Reporte;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\DateColumn;

class TablaReportesAsesorAceptadas extends LivewireDatatable
{
    public $hideable = 'select';

    public $perPage;
    public $model = Reporte::class;
    public $aceptadas;


    public $totalRow;

    public function builder()
    {
        $this->totalRow = [
            'cantidad' => 1001,
        ];

        $idUser = Auth::user()->id;
        // $OrdenesDelUsuario = OrdenCompra_User::Where('user_id',$idUser)->pluck('orden_compra_id')->unique();

        $aprobados = $this->aceptadas === "0" ? [1] : [2, 4];
        $Resultado = Reporte::query()
            ->Join('orden_compras', 'orden_compras.id', 'reportes.orden_compra_id')
            ->Join('municipios', 'municipios.id', 'reportes.municipio_id')
            ->Join('users', 'users.id', 'reportes.user_id')
            ->WhereIn('aprobado', $aprobados)
            ->where('reportes.user_id', $idUser)
            ->where('reportes.created_at', '>=', Carbon::now()->addMonth(-4));
        /*
            aprobado = 0 no se ha diligenciado
            aprobado = 1 se dilingencio
            aprobado = 2 se aprobo por el revisor
            aprobado = 3 rechazo por el revisor
            aprobado = 4 aprobado por completo
         */
        return $Resultado;
    }

    public function columns()
    {
        $elReturn = [
            // Column::name('users.name')->label('Nombre')->searchable(),
            Column::name('orden_compras.codigo')->label('OC/OS'),

            NumberColumn::name('horas')->label('horas ejecutadas'),
            NumberColumn::name('aprobadas')->label('horas aprobadas'),
            NumberColumn::name('orden_compras.horasaprobadas')->label('horas solicitadas'),
            BooleanColumn::name('reportes.bancohoras')->label('Banco de horas'),
            DateColumn::name('fecha_reporte')->label('fecha del reporte'),
            DateColumn::name('fecha_ejecucion')->label('Ejecucion'),
            Column::name('observaciones')->label('observaciones'),
            BooleanColumn::name('requiere_transporte')->label('requiere transporte')->hide(),
            Column::name('municipios.nombre')->label('municipio')->hide(),
            BooleanColumn::name('adjunto')->label('adjunto')->hide(),

            DateColumn::callback(['updated_at'], function ($updated_at) {
                return Carbon::createFromDate($updated_at)->diffForHumans(Carbon::now());
            })->label('Actualizado')->hide()->defaultSort('desc'),

        ];
        if ($this->aceptadas === "0") {
            $elReturn[] = DateColumn::callback(['id'], function ($id) {
                return " <button wire:click=borrarUs($id)>❌</button> ";
            })->label('Borrar');
        }
        // if (Auth::user()->is_admin>=1) {
        // $elReturn[]=Column::delete()->label('Eliminar')->hide();
        // }
        return $elReturn;
    }


    public function borrarUs($id)
    {
        $ListaControladoresYnombreClase = (explode('\\', get_class($this)));
        $nombreC = end($ListaControladoresYnombreClase);

        $repor = Reporte::find($id);
        $orden = OrdenCompra::find($repor->orden_compra_id);
        $nuevasHoras = floatval($orden->horasdisponibles) + floatval($repor->horas);
        // dd(
        //     $nuevasHoras,
        //     floatval($orden->horasdisponibles) , floatval($repor->horas)
        // );
        if ($nuevasHoras <= $orden->horasaprobadas) {
            $orden->update([
                'horasdisponibles' => $nuevasHoras
            ]);

            $repor->delete();
            Myhelp::EscribirEnLog($this,'se elimino el reporte codigo: ' . $orden->codigo);
        } else {
            Myhelp::EscribirEnLog($this,'intento eliminar un reporte que iba a quedar con ' . $nuevasHoras . 'horas disponibles, codigode la orden: ' . $orden->codigo,1);
            session()->flash('messageError', 'Error, las horas no concuerdan');
            return redirect(request()->header('Referer'));
        }
    }

    public function aceptarReporte($id)
    {
        $reporte = Reporte::find($id);
        // $IntAceptar = $this->estado == 2 ? 4 : 4;
        $reporte->update([
            'aprobado' => 4
        ]);
        Myhelp::EscribirEnLog($this,'se acepto un reporte');

        return redirect(request()->header('Referer'));
    }
}
