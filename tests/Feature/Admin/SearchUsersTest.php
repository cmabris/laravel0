<?php

namespace Tests\Feature\Admin;

use App\Team;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function search_users_by_first_name()
    {
        factory(User::class)->create([
            'first_name' => 'Joel'
        ]);
        factory(User::class)->create([
            'first_name' => 'Ellie'
        ]);

        $this->get('usuarios?search=Joel')
            ->assertStatus(200)
            ->assertSee('Joel')
            ->assertDontSee('Ellie');
    }

    /** @test */
    public function partial_search_by_first_name()
    {
        factory(User::class)->create([
            'first_name' => 'Joel'
        ]);
        factory(User::class)->create([
            'first_name' => 'Ellie'
        ]);

        $this->get('usuarios?search=Jo')
            ->assertStatus(200)
            ->assertSee('Joel')
            ->assertDontSee('Ellie');
    }

    /** @test */
    public function search_users_by_full_name()
    {
        factory(User::class)->create([
            'first_name' => 'Joel',
            'last_name' => 'Miller',
        ]);
        factory(User::class)->create([
            'first_name' => 'Ellie',
            'last_name' => 'Williams'
        ]);

        $this->get('usuarios?search=Joel Miller')
            ->assertStatus(200)
            ->assertSee('Joel Miller')
            ->assertDontSee('Ellie Williams');
    }

    /** @test */
    public function partial_search_by_full_name()
    {
        factory(User::class)->create([
            'first_name' => 'Joel',
            'last_name' => 'Miller',
        ]);
        factory(User::class)->create([
            'first_name' => 'Ellie',
            'last_name' => 'Williams'
        ]);

        $this->get('usuarios?search=Joel M')
            ->assertStatus(200)
            ->assertSee('Joel Miller')
            ->assertDontSee('Ellie Williams');
    }

    /** @test */

    public function search_users_by_email()
    {
        factory(User::class)->create([
            'email' => 'joel@example.com'
        ]);
        factory(User::class)->create([
            'email' => 'ellie@example.com'
        ]);

        $this->get('usuarios?search=joel@example.com')
            ->assertStatus(200)
            ->assertSee('Usuarios')
            ->assertSee('joel@example.com')
            ->assertDontSee('ellie@example.com');
    }

    /** @test */
    public function show_results_with_a_partial_search_by_email()
    {
        factory(User::class)->create([
            'email' => 'joel@example.com'
        ]);
        factory(User::class)->create([
            'email' => 'ellie@example.com'
        ]);

        $this->get('usuarios?search=el@exam')
            ->assertStatus(200)
            ->assertSee('Usuarios')
            ->assertSee('joel@example.com')
            ->assertDontSee('ellie@example.com');
    }

    /** @test */
    public function search_users_by_team_name()
    {
        factory(User::class)->create([
            'first_name' => 'Joel',
            'team_id' => factory(Team::class)->create(['name' => 'Smuggler'])->id,
        ]);
        factory(User::class)->create([
            'first_name' => 'Ellie',
            'team_id' => null,
        ]);
        factory(User::class)->create([
            'first_name' => 'Marlene',
            'team_id' => factory(Team::class)->create(['name' => 'Firefly'])->id,
        ]);

        $this->get('usuarios?search=Firefly')
            ->assertStatus(200)
            ->assertSee('Marlene')
            ->assertDontSee('Joel')
            ->assertDontSee('Ellie');
    }

    /** @test */
    public function partial_search_users_by_team_name()
    {
        factory(User::class)->create([
            'first_name' => 'Joel',
            'team_id' => factory(Team::class)->create(['name' => 'Smuggler'])->id,
        ]);
        factory(User::class)->create([
            'first_name' => 'Ellie',
            'team_id' => null,
        ]);
        factory(User::class)->create([
            'first_name' => 'Marlene',
            'team_id' => factory(Team::class)->create(['name' => 'Firefly'])->id,
        ]);

        $this->get('usuarios?search=Fire')
            ->assertStatus(200)
            ->assertSee('Marlene')
            ->assertDontSee('Joel')
            ->assertDontSee('Ellie');
    }
}
