<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('usuarios', 'UserController@index');
Route::get('usuarios/nuevo', 'UserController@create');
Route::get('usuarios/{id}', 'UserController@show')->where('id', '[0-9]+');

Route::get('saludo/{name}/{nickname?}', 'WelcomeUserController');
