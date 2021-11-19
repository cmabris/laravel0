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

    /** @test */
    public function it_sends_a_user_to_the_trash()
    {
        $user = factory(User::class)->create();

        $this->patch('usuarios/' . $user->id . '/papelera')
            ->assertRedirect('usuarios');

        //opción 1
        $this->assertSoftDeleted('users', [
            'id' => $user->id,
        ]);

        //opción 2
        $user->refresh();
        $this->assertTrue($user->trashed());
    }

    /** @test */
    public function it_cannot_delete_a_user_that_is_not_en_the_trash()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create([
            'deleted_at' => null,
        ]);

        $this->delete('usuarios/' . $user->id)
            ->assertStatus(404);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'deleted_at' => null,
        ]);
    }
}
