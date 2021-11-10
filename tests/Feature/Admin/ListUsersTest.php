<?php

namespace Tests\Feature\Admin;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_shows_the_users_list()
    {
        factory(User::class)->create([
            'name' => 'Joel',
        ]);
        factory(User::class)->create([
            'name' => 'Ellie'
        ]);

        $this->get('usuarios')
            ->assertStatus(200)
            ->assertSee('Usuarios')
            ->assertSee('Joel')
            ->assertSee('Ellie');
    }

    /** @test */
    public function it_shows_a_default_message_if_the_users_list_is_empty()
    {
        $this->get('usuarios')
            ->assertStatus(200)
            ->assertSee('Usuarios')
            ->assertSee('No hay usuarios registrados');
    }
}
