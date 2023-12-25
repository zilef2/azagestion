<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Row;

class RegistrarUsuariosImport implements OnEachRow, WithHeadingRow
{
    use Importable;
    use WithFileUploads;

//    public function chunkSize(): int { return 15000; }

    public function onRow(Row $row){
        $rowIndex = $row->getIndex();
        if($row['usuario'] != '' && $row['usuario'] !== ' '){

            $countfilas = session('CountFilas',0); session(['CountFilas' => $countfilas+1]);

            $nameNoSpaces = str_replace(' ', '', $row['usuario']);
            if (User::where('email', $row['correo'])->exists()) {
                $usuario = User::where('email', $row['correo'])->first();
                $usuario->update([
                    'name' => $row['usuario'],
                    'name_no_spaces' => $nameNoSpaces,
                    'cedula' => $row['cedula'],
                ]);
            }else{
                if (User::where('name_no_spaces', $nameNoSpaces)->exists()) {
                    $usuario = User::where('name_no_spaces', $nameNoSpaces)->first();

                    $usuario->update([
                        'name'  => $row['usuario'],
                        'name_no_spaces'  => $nameNoSpaces,
                        'email'  => preg_replace('/[^A-Za-z0-9\-_@.]/', '', $row['correo']),
                        'cedula' => $row['cedula'],
                    ]);
                }else{
                    if (User::where('name', $row['usuario'])->exists()) {
                        $usuario = User::where('name', $row['usuario'])->first();
                        $usuario->update([
                            'name_no_spaces'  => $nameNoSpaces,
                            'email'  => preg_replace('/[^A-Za-z0-9\-_@.]/', '', $row['correo']),
                            'cedula' => $row['cedula'],
                        ]);
                    }else{
                        User::Create([
                            'email'     => preg_replace('/[^A-Za-z0-9\-_@.]/', '', $row['correo']),
                            'name_no_spaces' => $nameNoSpaces,
                            'name'      => $row['usuario'],
                            'password'  => bcrypt($row['cedula']."*"),
                            'is_admin'  => 0,
                            'rol_id'    => 3,
                            'cedula' => $row['cedula'],
                            'cedula2' => $row['cedula'],
                        ]);
                    }
                }
            }
        }
    }
}
