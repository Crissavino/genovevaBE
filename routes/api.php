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
Route::get('/productosdestacados', 'Productos\ProductController@getProductosDestacados')->middleware('cors');

Route::get('/producto/{id}', 'Productos\ProductController@getProducto')->middleware('cors');

Route::get('/producto/{id}/stock', 'Productos\ProductController@getStockProducto')->middleware('cors');
// Route::get('/productos/stock', 'Productos\ProductController@getStockProducto')->middleware('cors');

Route::get('/datos', 'Productos\ProductController@getDatos')->middleware('cors');

Route::get('/imagenesShop', 'Productos\ProductController@getImagenesShop')->middleware('cors');

Route::get('/relcolores', 'Productos\ProductController@getRelColores')->middleware('cors');

Route::get('/imagenesDetalle', 'Productos\ProductController@getImagenesDetalle')->middleware('cors');
// Route::get('/imagenesDetalle/{id}', 'Productos\ProductController@getImagenesDetalle')->middleware('cors');

Route::get('/usuarios', 'Controller@getUsuarios')->middleware('cors');
Route::get('/usuario/{id}', 'Controller@getUsuario')->middleware('cors');

// retuas login y registro
// Auth::routes();

Route::post('/login', 'Auth\LoginController@authenticate')->middleware('cors');
Route::post('/registro', 'Auth\RegisterController@registroAngular')->middleware('cors');
Route::get('/logout', 'Auth\LoginController@logout')->middleware('cors');
Route::post('/cambiarpass', 'Auth\RegisterController@cambiarPassAngular')->middleware('cors');

// carrito
Route::post('/guardarCarrito', 'Productos\ProductController@guardarCarrito')->middleware('cors');
Route::get('/getCarrito/{userId}', 'Productos\ProductController@getCarrito')->middleware('cors');
Route::delete('/deleteCarrito/{userId}', 'Productos\ProductController@deleteCarrito')->middleware('cors');

// favoritos
Route::post('/guardarProductoFavorito', 'Productos\ProductController@guardarProductoFavorito')->middleware('cors');
Route::get('/getProductosFavoritos/{userId}', 'Productos\ProductController@getProductosFavoritos')->middleware('cors');
Route::delete('/deleteFavorito/{prodFavoritoId}', 'Productos\ProductController@deleteFavorito')->middleware('cors');

// pedidos
Route::post('/realizarPedido', 'PedidoController@realizarPedido')->middleware('cors');
Route::delete('/deletePedido/{idUser}', 'PedidoController@borrarPedido')->middleware('cors');
Route::put('/acomodarStock', 'PedidoController@acomodarStock')->middleware('cors');
Route::post('/pagarMP', 'PedidoController@pagarMP')->middleware('cors');
Route::get('/obtenerMediosDePago', 'PedidoController@obtenerMediosDePago')->middleware('cors');
Route::get('/calcularenvio/{dimensions}/{peso}/{zip_code}/{item_price}', 'PedidoController@getEnvio')->middleware('cors');


// ordenes
Route::get('/ordenes', 'Ordenes\OrdenesController@getOrdenes')->middleware('cors');

