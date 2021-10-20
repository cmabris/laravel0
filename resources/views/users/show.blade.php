@extends('layout')

@section('title', 'Detalles de un usuario')

@section('content')
    <h1>Usuario #{{ $id }}</h1>

    <p>Mostrando detalles del usuario: {{ $id }}</p>
@endsection