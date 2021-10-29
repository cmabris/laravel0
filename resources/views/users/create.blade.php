@extends('layout')

@section('title', 'Detalles de un usuario')

@section('content')
    <h1>Crear nuevo usuario</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <h6>Por favor, corrige los siguientes errores</h6>
<!--            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>-->
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST">
        {{ csrf_field() }}

        <label for="name">Nombre:</label>
        <input type="text" name="name" value="{{ old('name') }}">
        @if($errors->has('name'))
            <p>{{ $errors->first('name') }}</p>
        @endif
        <br>
        <label for="email">Correo Electrónico</label>
        <input type="email" name="email" value="{{ old('email') }}">
        @if($errors->has('email'))
            <p>{{ $errors->first('email') }}</p>
        @endif
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
