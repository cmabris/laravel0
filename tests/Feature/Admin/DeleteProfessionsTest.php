<?php

namespace Tests\Feature\Admin;

use App\Profession;
use App\User;
use App\UserProfile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteProfessionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_deletes_a_profession()
    {
        $profession = factory(Profession::class)->create();

        $response = $this->delete('profesiones/' . $profession->id);

        $response->assertRedirect();

        $this->assertDatabaseEmpty('professions');
    }

    /** @test */
    public function a_profession_associated_to_a_profile_cannot_be_deleted()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $profession = factory(Profession::class)->create();
        $user->profile()->update([
            'profession_id' => $profession->id,
        ]);

        $response = $this->delete('profesiones/' . $profession->id);
        $response->assertStatus(400);

        $this->assertDatabaseHas('professions', [
            'id' => $profession->id,
        ]);
    }
}
