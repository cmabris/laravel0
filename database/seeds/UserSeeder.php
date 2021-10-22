<?php

use App\{Profession,User};
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
        User::create([
            'name' => 'Pepe Pérez',
            'email' => 'pepe@mail.es',
            'password' => bcrypt('123456'),
            'profession_id' => Profession::whereTitle('Desarrollador Back-End')->value('id'),
            'is_admin' => true,
        ]);

        User::create([
            'name' => 'Juan Martínez',
            'email' => 'juan@mail.es',
            'password' => bcrypt('123456'),
            'profession_id' => Profession::whereTitle('Desarrollador Back-End')->value('id'),
        ]);

        User::create([
            'name' => 'Jaime Sánchez',
            'email' => 'jaime@mail.es',
            'password' => bcrypt('123456'),
            'profession_id' => null,
        ]);
    }
}
