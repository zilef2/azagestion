<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\CentroCosto;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Roles::create([ 'nombre' => 'Revisor']);
        \App\Models\Roles::create([ 'nombre' => 'Asignador']);
        \App\Models\Roles::create([ 'nombre' => 'Asesor']);
        $this->call([
            UserSeeder::class,
            MunicipiosSeeder::class,
            ClasificacionSeeder::class,
        ]);
    }
}
