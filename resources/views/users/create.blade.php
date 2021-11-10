@extends('layout')

@section('title', 'Detalles de un usuario')

@section('content')
    <div class="card">
        <div class="card-header h4">
            Crear nuevo usuario
        </div>

        <div class="card-body">
            @include('shared._errors')

            <form action="{{ route('users.store') }}" method="POST">

                @include('users._fields')

                <div class="form-group mt-4">
                    <button type="submit">Crear usuario</button>
                    <a href="{{ route('users.index') }}" class="btn btn-link">Regresar al listado de usuarios</a>
                </div>
            </form>
        </div>
    </div>

@endsection
