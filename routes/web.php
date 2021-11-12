<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('usuarios', 'UserController@index')->name('users.index');
Route::get('usuarios/crear', 'UserController@create')->name('users.create');
Route::post('usuarios', 'UserController@store')->name('users.store');
Route::get('usuarios/{user}/editar', 'UserController@edit')->name('users.edit');
Route::get('usuarios/{user}', 'UserController@show')
    ->where('id', '[0-9]+')->name('users.show');
Route::put('usuarios/{user}', 'UserController@update')->name('users.update');
Route::delete('usuarios/{user}', 'UserController@destroy')->name('users.destroy');

Route::get('editar-perfil', 'ProfileController@edit');
Route::put('editar-perfil', 'ProfileController@update');

Route::get('saludo/{name}/{nickname?}', 'WelcomeUserController');
