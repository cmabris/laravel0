<?php

namespace Tests\Feature\Admin;

use App\Profession;
use App\Skill;
use App\User;
use App\UserProfile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateUsersTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'first_name' => 'Pepe',
        'last_name' => 'Pérez',
        'email' => 'pepe@mail.es',
        'password' => '123456',
        'profession_id' => '',
        'bio' => 'Programador de Laravel y Vue.js',
        'twitter' => 'https://twitter.com/pepe',
        'role' => 'user',
        'state' => 'active',
    ];

    /** @test */
    public function it_loads_the_edit_user_page()
    {
        $user = factory(User::class)->create();

        $this->get('usuarios/' . $user->id . '/editar')
            ->assertStatus(200)
            ->assertViewIs('users.edit')
            ->assertSee('Editar usuario')
            ->assertViewHas('user', function ($viewUser) use ($user) {
                return $viewUser->id === $user->id;
            });
    }

    /** @test */
    public function it_updates_a_user()
    {
        $user = factory(User::class)->create();

        $oldProfession = factory(Profession::class)->create();
        $user->profile()->update([
            'profession_id' => $oldProfession->id,
        ]);

        $oldSkill1 = factory(Skill::class)->create();
        $oldSkill2 = factory(Skill::class)->create();
        $user->skills()->attach([$oldSkill1->id, $oldSkill2->id]);

        $newProfession = factory(Profession::class)->create();
        $newSkill1 = factory(Skill::class)->create();
        $newSkill2 = factory(Skill::class)->create();

        $this->put('usuarios/' . $user->id, $this->withData([
            'role' => 'admin',
            'profession_id' => $newProfession->id,
            'skills' => [$newSkill1->id, $newSkill2->id],
            'state' => 'inactive'
        ]))->assertRedirect('usuarios/' . $user->id);

        $this->assertCredentials([
            'first_name' => 'Pepe',
            'last_name' => 'Pérez',
            'email' => 'pepe@mail.es',
            'password' => '123456',
            'role' => 'admin',
            'active' => false,
        ]);

        $this->assertDatabaseHas('user_profiles', [
            'user_id' => $user->id,
            'bio' => 'Programador de Laravel y Vue.js',
            'twitter' => 'https://twitter.com/pepe',
            'profession_id' => $newProfession->id,
        ]);

        $this->assertDatabaseCount('skill_user', 2);

        $this->assertDatabaseHas('skill_user', [
            'user_id' => $user->id,
            'skill_id' => $newSkill1->id,
        ]);

        $this->assertDatabaseHas('skill_user', [
            'user_id' => $user->id,
            'skill_id' => $newSkill2->id,
        ]);
    }

    /** @test */
    public function the_first_name_is_required()
    {
        $this->handleValidationExceptions();

        $user = factory(User::class)->create();

        $this->from('usuarios/' . $user->id . '/editar')
            ->put('usuarios/' . $user->id, $this->withData([
                'first_name' => '',
            ]))->assertRedirect('usuarios/' . $user->id . '/editar')
            ->assertSessionHasErrors(['first_name']);

        $this->assertDatabaseMissing('users', ['email' => 'pepe@mail.es']);
    }

    /** @test */
    public function the_last_name_is_required()
    {
        $this->handleValidationExceptions();

        $user = factory(User::class)->create();

        $this->from('usuarios/' . $user->id . '/editar')
            ->put('usuarios/' . $user->id, $this->withData([
                'last_name' => '',
            ]))->assertRedirect('usuarios/' . $user->id . '/editar')
            ->assertSessionHasErrors(['last_name']);

        $this->assertDatabaseMissing('users', ['email' => 'pepe@mail.es']);
    }

    /** @test */
    public function the_email_is_required()
    {
        $this->handleValidationExceptions();

        $user = factory(User::class)->create();

        $this->from('usuarios/' . $user->id . '/editar')
            ->put('usuarios/' . $user->id, $this->withData([
                'email' => '',
            ]))->assertRedirect('usuarios/' . $user->id . '/editar');

        $this->assertDatabaseMissing('users', ['first_name' => 'Pepe']);
    }

    /** @test */
    public function the_email_must_be_valid()
    {
        $this->handleValidationExceptions();

        $user = factory(User::class)->create();

        $this->from('usuarios/' . $user->id . '/editar')
            ->put('usuarios/' . $user->id, $this->withData([
                'email' => 'correo-no-valido',
            ]))->assertRedirect('usuarios/' . $user->id . '/editar')
            ->assertSessionHasErrors('email');

        $this->assertDatabaseMissing('users', ['first_name' => 'Pepe']);
    }

    /** @test */
    public function the_email_must_be_unique()
    {
        $this->handleValidationExceptions();

        factory(User::class)->create([
            'email' => 'existing_email@mail.es'
        ]);
        $user = factory(User::class)->create([
            'email' => 'pepe@mail.es',
        ]);

        $this->from('usuarios/' . $user->id . '/editar')
            ->put('usuarios/' . $user->id, $this->withData([
                'email' => 'existing_email@mail.es',
            ]))->assertRedirect('usuarios/' . $user->id . '/editar')
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function the_password_is_optional()
    {
        $oldPassword = 'CLAVE_ANTERIOR';
        $user = factory(User::class)->create([
            'password' => bcrypt($oldPassword),
        ]);

        $this->from('usuarios/' . $user->id . '/editar')
            ->put('usuarios/' . $user->id, $this->withData([
                'password' => ''
            ]))->assertRedirect('usuarios/' . $user->id);

        $this->assertCredentials([
            'first_name' => 'Pepe',
            'email' => 'pepe@mail.es',
            'password' => $oldPassword
        ]);
    }

    /** @test */
    public function the_user_email_can_stay_the_same()
    {
        $user = factory(User::class)->create([
            'email' => 'pepe@mail.es',
        ]);

        $this->from('usuarios/' . $user->id . '/editar')
            ->put('usuarios/' . $user->id, $this->withData([
                'email' => 'pepe@mail.es',
            ]))->assertRedirect('usuarios/' . $user->id);

        $this->assertDatabaseHas('users', [
            'first_name' => 'Pepe',
            'email' => 'pepe@mail.es',
        ]);
    }

    /** @test */
    public function it_detaches_all_the_skills_if_none_is_checked()
    {
        $user = factory(User::class)->create();

        $oldSkill1 = factory(Skill::class)->create();
        $oldSkill2 = factory(Skill::class)->create();
        $user->skills()->attach([$oldSkill1->id, $oldSkill2->id]);

        $this->put('usuarios/' . $user->id, $this->withData([]))
            ->assertRedirect('usuarios/' . $user->id);

        $this->assertDatabaseEmpty('skill_user');
    }

    /** @test */
    public function the_state_is_required()
    {
        $this->handleValidationExceptions();

        $user = factory(User::class)->create();

        $this->from('usuarios/' . $user->id . '/editar')
            ->put('usuarios/' . $user->id, $this->withData([
                'state' => '',
            ]))->assertRedirect('usuarios/' . $user->id . '/editar')
            ->assertSessionHasErrors(['state']);

        $this->assertDatabaseMissing('users', ['first_name' => 'Pepe']);
    }

    /** @test */
    public function the_state_must_be_valid()
    {
        $this->handleValidationExceptions();

        $user = factory(User::class)->create();

        $this->from('usuarios/' . $user->id . '/editar')
            ->put('usuarios/' . $user->id, $this->withData([
                'state' => 'state-invalid',
            ]))->assertRedirect('usuarios/' . $user->id . '/editar')
            ->assertSessionHasErrors(['state']);

        $this->assertDatabaseMissing('users', ['first_name' => 'Pepe']);
    }
}
