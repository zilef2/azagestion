<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClasificacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Clasificacion::create([ 'nombre' => 'ASESORÍA']);
        \App\Models\Clasificacion::create([ 'nombre' => 'CAPACITACIÓN']);
    }
}
