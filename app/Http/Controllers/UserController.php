<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Profession;
use App\Skill;
use App\User;
use App\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        $title = 'Usuarios';

        return view('users.index')->with(compact('users', 'title'));
    }

    public function create()
    {
        return $this->form('users.create', new User);
    }

    public function store(CreateUserRequest $request)
    {
        $request->createUser();
        //User::createUser($request->validated());

        return redirect()->route('users.index');
    }

    public function show(User $user)
    {
        if ($user == null) {
            return response()->view('errors.404', [], 404);
        }

        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return $this->form('users.edit', $user);
    }

    public function update(User $user)
    {
        $data = request()->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => '',
            'role' => '',
            'bio' => '',
            'twitter' => '',
            'profession_id' => '',
            'skills' => '',
        ]);

        if ($data['password'] != null) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $user->fill($data);
        $user->role = $data['role'];
        $user->save();

        $user->profile->update($data);

        $user->skills()->sync($data['skills'] ?? []);

        return redirect()->route('users.show', $user);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index');
    }

    protected function form($view, User $user)
    {
        return view($view, [
            'user' => $user,
            'professions' => Profession::orderBy('title', 'ASC')->get(),
            'skills' => Skill::orderBy('name', 'ASC')->get(),
            'roles' => trans('users.roles')
        ]);
    }
}
