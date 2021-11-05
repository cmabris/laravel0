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
        $professionId = Profession::whereTitle('Desarrollador Back-End')->value('id');

        $user = User::create([
            'name' => 'Pepe Pérez',
            'email' => 'pepe@mail.es',
            'password' => bcrypt('123456'),
            'is_admin' => true,
        ]);

        $user->profile()->create([
            'bio' => 'Programador',
            'profession_id' => $professionId,
        ]);

        factory(User::class, 49)->create()->each(function ($user) {
            $user->profile()->create(
                factory(App\UserProfile::class)->raw()
            );
        });
    }
}
