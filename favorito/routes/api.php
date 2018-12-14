<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route:: post('auth/login','AuthController@login');
Route:: post('new/user','PessoaController@store');
Route::post('auth/logout', 'AuthController@logout');
Route::post('auth/refresh', 'AuthController@refresh');

Route::group(['middleware'=>'jwt.auth'], function(){
    Route::get('auth/me', 'AuthController@me');
    Route::resource('favorito','FavoritoController');
});
