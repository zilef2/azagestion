<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Livewire\WithFileUploads;

class RegistrarUsuariosImport implements ToModel,WithChunkReading,ShouldQueue, WithValidation, WithHeadingRow
{
    use Importable;
    use WithFileUploads;

    public function rules(): array
    {
        return [
            // '1' => [Rule::unique(['users', 'email'])],
            // '1' => 'email',
            'correo' => 'required',
            'cedula' => 'required|min:6',
            'usuario' => 'min:2'
        ];
    }

    public function chunkSize(): int { return 15000; }

    public function model(array $row)
    {
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
                // dd(
                //     $usuario,$row['correo'],
                //     User::where('email', $row['correo'])->exists(),
                //     User::where('email', $row['correo'])->get(),
                //     User::where('name_no_spaces', $nameNoSpaces)->get()
                // );
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
                    $usuario = User::Create([
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
        return $usuario;
    }
}
