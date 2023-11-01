<?php

namespace App\Exports;

use Illuminate\Support\Facades\File;
// use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class BDExport implements WithMultipleSheets
{
    use Exportable;

    // protected $year;
    
    public function __construct() {
        // $this->year = $year;
    }
    public function sheets(): array {
        // $tablas = [
        //     'users',
        //     'tareas'
        // ];

        $tablas = File::files(app_path('Models'));
        foreach ($tablas as $table) {
            $model = pathinfo($table, PATHINFO_FILENAME);
            if($model == 'OrdenCompra_User')continue;
            if($model == 'Historicoc')continue;

            $sheets[] = new ExportablePorTablas($model);
        }

        return $sheets;
    }
}
