<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DesconocidosExport implements FromCollection , WithHeadings,ShouldAutoSize
{
    public function headings(): array {
        return [
            'Asesor',
            'Correo',
            'Cedula',
            'Cedula inicial (Automatica)'
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection() {
        $ListaControladoresYnombreClase = (explode('\\',get_class($this)));
        $nombreC = end($ListaControladoresYnombreClase);

        try {
            $desconocidos = User::select('name','email','cedula','cedula2')->where('rol_id',3)
                ->where(function($query){
                    $query->where('email','like','%UsuarioDesconocido%');
                })->get();
            // dd($desconocidos);
            Log::info(' U-> '.Auth::user()->name. ' en la funcion ' .$nombreC. ' se descargaron '. count($desconocidos).' usuarios desconocidos.' );
            return $desconocidos;
            
        } catch (\Throwable $th) {
            Log::critical(' U-> '.Auth::user()->name. ' en la funcion ' .$nombreC. ' produjo el siguiente error: '. $th );
            return null;
        }
    }
}
