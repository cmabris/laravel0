<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('usuarios', function () {
    return '<h1>Usuarios/as/es</h1>';
});

/*Route::get('usuarios/detalles', function () {
    return 'mostrando detalles del usuario: ' . $_GET['id'];
});*/

Route::get('usuarios/nuevo', function () {
    return 'Creando nuevo usuario';
});

Route::get('usuarios/{id}', function ($id) {
    return 'Mostrando detalles del usuario: ' . $id;
})->where('id', '[0-9]+');

Route::get('saludo/{name}/{nickname?}', function ($name, $nickname = null) {
    /*if ($nickname) {
        return 'Bienvenido ' . $name . '. Tu apodo es ' . $nickname;
    }
    return 'Bienvenido ' . $name . '.';*/

    return $nickname
        ? 'Bienvenido ' . ucfirst($name) . '. Tu apodo es ' . $nickname
        : 'Bienvenido ' . ucfirst($name) . '.';

});
