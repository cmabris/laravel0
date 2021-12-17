@extends('livewire-layout')

@section('title', 'Usuarios')

@section('content')
    <h1>{{ trans('users.title.' . $view) }}</h1>
    <p>
        @if($view == 'index')
            <a href="{{ route('users.trashed') }}" class="btn btn-outline-dark">Ver papelera</a>
            <a href="{{ route('users.create') }}" class="btn btn-primary">Nuevo usuario</a>
        @else
            <a href="{{ route('users.index') }}" class="btn btn-outline-dark">Regresar al listado de usuarios</a>
        @endif
    </p>

    @livewire('users-list', compact(['view']))

@endsection
