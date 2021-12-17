@extends('layout')

@section('title', 'Crear nuevo usuario')

@section('content')
    <x-card>
        @slot('header', 'Crear nuevo usuario')

        @include('shared._errors')

        <form action="{{ route('users.store') }}" method="POST">

            @include('users._fields')

            <div class="form-group mt-4">
                <button type="submit">Crear usuario</button>
                <a href="{{ route('users.index') }}" class="btn btn-link">Regresar al listado de usuarios</a>
            </div>
        </form>
    </x-card>
@endsection
