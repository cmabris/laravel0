@extends('layout')

@section('title', 'Listado de usuarios')

@section('content')
    <h1>{{ $title }}</h1>

    @if( $users->count() )
        <ul>
            @foreach ($users as $user)
                <li>
                    {{ $user->name }}, {{ $user->email }}
                    <a href="{{ route('users.show', $user->id) }}">Ver detalles</a>
                </li>
            @endforeach
        </ul>
    @else
        <p>No hay usuarios registrados</p>
    @endif
@endsection

@section('sidebar')
    Barra Lateral
@endsection