<?php

namespace Tests\Feature\Admin;

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
        $activeUser = factory(User::class)->create();
        $inactiveUser = factory(User::class)->state('inactive')->create();

        $response = $this->get('usuarios?state=active');

        $response->assertViewCollection('users')
            ->contains($activeUser)
            ->notContains($inactiveUser);
    }

    /** @test */
    public function filter_users_by_state_inactive()
    {
        $activeUser = factory(User::class)->create();
        $inactiveUser = factory(User::class)->state('inactive')->create();

        $response = $this->get('usuarios?state=inactive');

        $response->assertViewCollection('users')
            ->contains($inactiveUser)
            ->notContains($activeUser);
    }
}
