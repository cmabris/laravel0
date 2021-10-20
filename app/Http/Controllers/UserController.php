<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        if (request()->has('empty')) {
            $users = [];
        } else {
            $users = ['Joel', 'Ellie', 'Tess', 'Tommy', 'Bill'];
        }

        $title = 'Usuarios';

        return view('users.index')->with(compact('users', 'title'));
    }

    public function create()
    {
        return 'Creando nuevo usuario';
    }

    public function show($id)
    {
        return view('users.show', compact('id'));
    }
}
