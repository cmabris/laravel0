<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        $title = 'Usuarios';

        return view('users.index')->with(compact('users', 'title'));

        /*return view('users.index')
            ->with('users', User::all())
            ->with('title', 'Listado de Usuarios');*/
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {

        User::create([
            'name' => 'Pepe',
            'email' => 'pepe@mail.es',
            'password' => bcrypt('123456')
        ]);

        return redirect()->route('users.index');
    }

    public function show(User $user)
    {
        if ($user == null) {
            return response()->view('errors.404', [], 404);
        }

        return view('users.show', compact('user'));
    }
}
