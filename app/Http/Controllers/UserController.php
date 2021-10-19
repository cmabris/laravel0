<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return '<h1>Usuarios/as/es</h1>';
    }

    public function create()
    {
        return 'Creando nuevo usuario';
    }

    public function show($id)
    {
        return 'Mostrando detalles del usuario: ' . $id;
    }
}
