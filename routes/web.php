<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('usuarios', 'UserController@index')->name('users.index');
Route::get('usuarios/nuevo', 'UserController@create')->name('users.create');
Route::get('usuarios/{user}', 'UserController@show')
    ->where('id', '[0-9]+')->name('users.show');

Route::get('saludo/{name}/{nickname?}', 'WelcomeUserController');
