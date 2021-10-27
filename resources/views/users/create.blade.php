@extends('layout')

@section('title', 'Detalles de un usuario')

@section('content')
    <h1>Crear nuevo usuario</h1>

    <form action="{{ route('users.store') }}" method="POST">
        {{ csrf_field() }}

        <label for="name">Nombre:</label>
        <input type="text" name="name">
        <br>
        <label for="email">Correo Electrónico</label>
        <input type="email" name="email">
        <br>
        <label for="password">Contraseña: </label>
        <input type="password" name="password">
        <br>
        <button type="submit">Crear usuario</button>
    </form>

    <p>
        <a href="{{ route('users.index') }}">Regresar al listado de usuarios</a>
    </p>
@endsection
