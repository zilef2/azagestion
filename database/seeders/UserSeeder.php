<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->create(
            [
                'name' => 'Superadmin',
                'name_no_spaces' => 'Superadmin',
                'email' => 'superadmin@superadmin.com',
                'password'          => bcrypt('alejo+-*/asd00+*??'),
                'is_admin'=>2,
                'rol_id' => 2 //1 y 2 son revisor y asignador (por ahora son lo mismo)
            ],
        );

        // Anna Lucia Zuluaga A
        // analuzu@hotmail.com

        \App\Models\User::factory()->create([
            'name'           => 'Admin',
            'name_no_spaces' => 'Admin',
            'email'          => 'admin@admin.com',
            'password'       => bcrypt('alejoasd00+*??'),
            'is_admin' => 1,
            'rol_id' => 2
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Anna Lucia Zuluaga A',
            'name_no_spaces' => 'AnnaLuciaZuluagaA',
            'email' => 'azasas@azagestionriesgo.com',
            'password' => bcrypt('43865015*'),
            'cedula' => '43865015',
            'is_admin'=>1,
            'rol_id' => 2
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Adriana Acevedo Garzon',
            'name_no_spaces' => 'AdrianaAcevedoGarzon',
            'email' => 'auxadministrativa2@azagestionriesgo.com',
            'password' => bcrypt('43154528*'),
            'cedula' => '43154528',
            'is_admin'=>0,
            'rol_id' => 2
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Alejandra Lopez Lopez',
            'name_no_spaces' => 'AlejandraLopezLopez',
            'email' => 'auxadministrativa3@azagestionriesgo.com',
            'password' => bcrypt('1017125498*'),
            'cedula' => '1017125498',
            'is_admin'=>0,
            'rol_id' => 2
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Paola Andrea Londoño Gomez',
            'name_no_spaces' => 'PaolaAndreaLondoñoGomez',
            'email' => 'auxadministrativa@azagestionriesgo.com',
            'password' => bcrypt('66803763*'),
            'cedula' => '66803763',
            'is_admin'=>0,
            'rol_id' => 2
        ]);

        // \App\Models\User::factory()->create(
        //     [
        //         'name'              => 'operator',
        //         'name_no_spaces'              => 'operator',
        //         'email'             => 'operator@operator.com',
        //         'password'          => bcrypt('operator00+*'),
        //         'is_admin'=>0,
        //         'rol_id' => 3
        //     ],
        // );
    }
}
