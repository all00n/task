<?php

use Illuminate\Http\Request;

Route::get('users','UserController@getUsers');
Route::get('user/{id}','UserController@getUser');
Route::post('user','UserController@createUser');
Route::put('user/{id}','UserController@editUser');
Route::delete('user/{id}','UserController@deleteUser');

Route::get('roles','RolesController@getRoles');