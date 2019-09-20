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

// Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('admin/productos', 'Admin\AdminController@show');

Route::get('/admin/producto/nuevo', 'Admin\AdminController@createProducto');
Route::post('/admin/producto/nuevo', 'Admin\AdminController@insertProducto');
Route::get('/admin/producto/{id?}', 'Admin\AdminController@editProducto');
Route::put('/admin/producto/{id}', 'Admin\AdminController@updateProducto');
Route::put('/dashboard/productos/visible/{prodId}', 'Admin\AdminController@updateVisible');
Route::delete('/admin/producto/borrar/{id}', 'Admin\AdminController@destroyProducto');
Route::delete('/dashboard/productos/borrar/{prodId}', 'Admin\AdminController@deleteProducto');


// ordenes
Route::get('/admin/ordenes', 'Ordenes\OrdenesController@showOrdenes');
Route::put('/admin/ordenes/{id}', 'Ordenes\OrdenesController@updateOrden');


