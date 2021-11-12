@extends('layout')

@section('title', 'Editar usuario')

@section('content')
    @card
        @slot('header', 'Editar usuario')

        @include('shared._errors')

        <form action="{{ route('users.update', $user) }}" method="POST">
            {{ method_field('PUT') }}

            @include('users._fields')

            <div class="form-group mt-4">
                <button type="submit">Actualizar usuario</button>
                <a href="{{ route('users.index') }}" class="btn btn-link">Regresar al listado de usuarios</a>
            </div>
        </form>
    @endcard
@endsection
