<?php

namespace App\Http\Livewire\Ultimasvistas;

use Illuminate\Support\Carbon;
use Livewire\Component;

class Logviez extends Component
{
    public $minHour, $maxHour, $minLine, $maxLine; //datos log
    public $fechaini;
    public $todosLosDeHoy = [];
    public $nuevaOrden = [];

    public function mount()
    {
        // $this->fechaini = Carbon::now()->setTime(0, 0, 0)->format('Y-m-d h:i:s A');
        $this->fechaini = Carbon::now()->format('Y-m-d');
        // dd($this->fechaini);
        $logFilePath = storage_path('logs/laravel.log');
        $dateToCheck = $this->fechaini;
        // $dateToCheck = '2023-06-22';

        $lines = file($logFilePath); // Lee el contenido del archivo en un array, una línea por elemento

        $minTime = PHP_INT_MAX; // Inicializa con un valor alto para comparar y encontrar el mínimo
        $maxTime = 0; // Inicializa con un valor bajo para comparar y encontrar el máximo
        $contador = 0;

        foreach ($lines as $line) {
            if (strpos($line, $dateToCheck) !== false) {
                $contador++;
                if ($contador < 2)
                    $this->todosLosDeHoy[] = $line;

                // Extrae la marca de tiempo de la línea utilizando una expresión regular
                preg_match('/\[(.*?)\]/', $line, $matches);
                if (isset($matches[1])) {
                    $timestamp = strtotime($matches[1]);
                    if ($timestamp < $minTime) {
                        $minTime = $timestamp;
                        $this->minLine = substr($line, 21);
                    }
                    if ($timestamp > $maxTime) {
                        $maxTime = $timestamp;
                        $this->maxLine = substr($line, 21);
                    }
                }


                // $posicionError = strpos(strtolower($line), 'error'); //extrae si es un error
                $posicionForm = strpos(strtolower($line), 'lige'); //extrae si un usuario reporto
                if ($posicionForm !== false) {
                    $this->nuevaOrden[] = substr($line, $posicionForm);
                }

                if ($contador > 120) break;
            }
        }

        // $this->minHour = Carbon::createFromTimestamp($minTime)->format('d/m/Y H:i:s');
        $fechaMin = Carbon::createFromTimestamp($minTime);
        $this->minHour = $fechaMin->diffForHumans(Carbon::now()) . ' | ' . $fechaMin->format(' H:i A');
        $this->maxHour = Carbon::createFromTimestamp($maxTime)->diffForHumans(Carbon::now());
        // $this->minHour = date('H:i:s', $minTime); // Convierte la marca de tiempo mínima a formato de hora
        // $this->maxHour = date('H:i:s', $maxTime);
    }

    public function recalcularFechaLog()
    {
    }
    public function render()
    {
        return view('livewire.ultimasvistas.logviez');
    }
}
