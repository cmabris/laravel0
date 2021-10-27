@extends('layout')

@section('title', 'Detalles de un usuario')

@section('content')
    <h1>Usuario #{{ $user->id }}</h1>

    <p>Mostrando detalles del usuario: {{ $user->name }}</p>

    <p>
        <a href="{{ route('users.index') }}">Regresar al listado de usuarios</a>
    </p>
@endsection