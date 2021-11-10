<?php

namespace Tests\Feature\Admin;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_deletes_a_user()
    {
        $user = factory(User::class)->create();

        $this->delete('usuarios/' . $user->id)
            ->assertRedirect('usuarios');

        $this->assertDatabaseEmpty('users');
    }
}
