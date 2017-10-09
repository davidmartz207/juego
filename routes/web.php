<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//rutas del timestamp print
Route::get('timestamp','timestampController@printTimestamp')->name('timestamp');

//rutas para guardar y listar  Entradas de blog/posts
Route::post('post','postController@store');
Route::get('user/{userId}/posts/{limit?}/{offset?}','postController@show');

//rutas para juego
Route::post('user/jugar','juegoController@jugar');
Route::post('leaderboard','juegoController@leaderBoard');
Route::post('usersave','usuarioController@userSave');
Route::post('userload','usuarioController@userLoad');

