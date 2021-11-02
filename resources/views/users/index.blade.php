@extends('layout')

@section('title', 'Listado de usuarios')

@section('content')
    <h1>{{ $title }}</h1>
    <p>
        <a href="{{ route('users.create') }}">Nuevo usuario</a>
    </p>

    @if( $users->count() )
        <ul>
            @foreach ($users as $user)
                <li>
                    {{ $user->name }}, {{ $user->email }}
                    <a href="{{ route('users.show', $user->id) }}">Ver detalles</a> |
                    <a href="{{ route('users.edit', $user) }}">Editar</a> |
                    <form action="{{ route('users.destroy', $user) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submit">Eliminar</button>
                    </form>
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