<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('usuarios', 'UserController@index')->name('users.index');
Route::get('usuarios/crear', 'UserController@create')->name('users.create');
Route::post('usuarios', 'UserController@store')->name('users.store');
Route::get('usuarios/{user}/editar', 'UserController@edit')->name('users.edit');
Route::put('usuarios/{user}', 'UserController@update')->name('users.update');
Route::get('usuarios/papelera', 'UserController@trashed')->name('users.trashed');
Route::get('usuarios/{user}', 'UserController@show')
    ->where('id', '[0-9]+')->name('users.show');
Route::delete('usuarios/{id}', 'UserController@destroy')->name('users.destroy');
Route::patch('usuarios/{user}/papelera', 'UserController@trash')->name('users.trash');


Route::get('editar-perfil', 'ProfileController@edit');
Route::put('editar-perfil', 'ProfileController@update');

Route::get('profesiones', 'ProfessionController@index')->name('professions.index');
Route::delete('profesiones/{profession}', 'ProfessionController@destroy');

Route::get('habilidades', 'SkillController@index')->name('skills.index');

Route::get('saludo/{name}/{nickname?}', 'WelcomeUserController');
