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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/productos', 'Productos\ProductController@showProducts')->middleware('cors');

Route::get('/producto/{id}', 'Productos\ProductController@getProducto')->middleware('cors');

Route::get('/producto/{id}/stock', 'Productos\ProductController@getStockProducto')->middleware('cors');

Route::get('/datos', 'Productos\ProductController@getDatos')->middleware('cors');

Route::get('/imagenesShop', 'Productos\ProductController@getImagenesShop')->middleware('cors');

Route::get('/imagenesDetalle/{id}', 'Productos\ProductController@getImagenesDetalle')->middleware('cors');

Route::get('/usuario/{id}', 'Controller@getUsuario')->middleware('cors');

// retuas login y registro
// Auth::routes();

Route::post('/login', 'Auth\LoginController@authenticate');
Route::post('/registro', 'Auth\RegisterController@registroAngular');
Route::get('/logout', 'Auth\LoginController@logout');




