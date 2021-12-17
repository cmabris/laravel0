<?php

namespace Tests\Feature\Admin;

use App\Skill;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FilterUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function filter_users_by_state_active()
    {
        factory(User::class)->create(['first_name' => 'Joel']);
        factory(User::class)->state('inactive')->create(['first_name' => 'Ellie']);

        $response = $this->get('usuarios?state=active');

        $response->assertSee('Joel')
            ->assertDontSee('Ellie');
    }

    /** @test */
    public function filter_users_by_state_inactive()
    {
        factory(User::class)->create(['first_name' => 'Joel']);
        factory(User::class)->state('inactive')->create(['first_name' => 'Ellie']);

        $response = $this->get('usuarios?state=inactive');

        $response->assertSee('Ellie')
            ->assertDontSee('Joel');
    }

    /** @test */
    public function filter_users_by_role_admin()
    {
        factory(User::class)->create(['first_name' => 'Joel', 'role' => 'admin']);

        factory(User::class)->create(['first_name' => 'Ellie', 'role' => 'user']);

        $response = $this->get('usuarios?role=admin');

        $response->assertStatus(200);

        $response->assertSee('Joel')
            ->assertDontSee('Ellie');
    }

    /** @test */
    public function filter_users_by_role_user()
    {
        factory(User::class)->create(['first_name' => 'Joel', 'role' => 'admin']);

        factory(User::class)->create(['first_name' => 'Ellie', 'role' => 'user']);

        $response = $this->get('usuarios?role=user');

        $response->assertStatus(200);

        $response->assertSee('Ellie')
            ->assertDontSee('Joel');
    }

    /** @test */
    public function filter_users_by_skill()
    {
        $php = factory(Skill::class)->create(['name' => 'php']);
        $css = factory(Skill::class)->create(['name' => 'css']);

        $backendDev = factory(User::class)->create(['first_name' => 'Joel']);
        $backendDev->skills()->attach($php);

        $fullStackDev = factory(User::class)->create(['first_name' => 'Ellie']);
        $fullStackDev->skills()->attach([$php->id, $css->id]);

        $frontendDev = factory(User::class)->create(['first_name' => 'Marlene']);
        $frontendDev->skills()->attach($css);

        $response = $this->get("usuarios?skills[0]={$php->id}&skills[1]={$css->id}");

        $response->assertStatus(200);

        $response->assertSee('Ellie')
            ->assertDontSee('Joel')
            ->assertDontSee('Marlene');
    }

    /** @test */
    public function filter_users_created_from_date()
    {
        factory(User::class)->create([
            'first_name' => 'Joel',
            'created_at' => '2018-10-02 12:00:00',
        ]);

        factory(User::class)->create([
            'first_name' => 'Ellie',
            'created_at' => '2018-09-29 12:00:00',
        ]);

        factory(User::class)->create([
            'first_name' => 'Marlene',
            'created_at' => '2018-10-01 00:00:00',
        ]);

        factory(User::class)->create([
            'first_name' => 'John',
            'created_at' => '2018-09-30 23:59:59',
        ]);

        $response = $this->get('usuarios?from=01/10/2018');

        $response->assertOk();

        $response->assertSee('Joel')
            ->assertSee('Marlene')
            ->assertDontSee('Ellie')
            ->assertDontSee('John');
    }

    /** @test */
    public function filter_users_created_to_date()
    {
        factory(User::class)->create([
            'first_name' => 'Joel',
            'created_at' => '2018-10-02 12:00:00',
        ]);

        factory(User::class)->create([
            'first_name' => 'Ellie',
            'created_at' => '2018-09-29 12:00:00',
        ]);

        factory(User::class)->create([
            'first_name' => 'Marlene',
            'created_at' => '2018-10-01 00:00:00',
        ]);

        factory(User::class)->create([
            'first_name' => 'John',
            'created_at' => '2018-09-30 23:59:59',
        ]);

        $response = $this->get('usuarios?to=30/09/2018');

        $response->assertOk();

        $response->assertSee('Ellie')
            ->assertSee('John')
            ->assertDontSee('Joel')
            ->assertDontSee('Marlene');
    }



}



