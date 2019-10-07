<?php

namespace App\Http\Controllers\Productos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function showProducts()
    {
        // $productos = \App\Modelos\Producto::all();
        // ordenados por created_at
        // $productosLatest = \App\Modelos\Producto::latest()->get();
        // ordenados por updated_at
        $productosOrderBy = \App\Modelos\Producto::orderBy('updated_at', 'desc')->get();

        $response = Response::json($productosOrderBy, 200);

        return $response;
    }
    
    // public function getCategoriasP(){
        
    //     $categoriasPrincipales = \App\Modelos\Categoria::all();
        
    //     $response = Response::json($categoriasPrincipales, 200);
    //     return $response;
    // }

    public function getDatos(){

        $categoriasPrincipales = \App\Modelos\Categoria::all();
        $categoriasSecundarias = \App\Modelos\Categoriassecundaria::all();
        $talles = \App\Modelos\Talle::all();
        $colores = \App\Modelos\Colore::all();
        $data = ['principales' => $categoriasPrincipales, 'secundarias' => $categoriasSecundarias, 'talles' => $talles, 'colores' => $colores];

        $response = Response::json($data, 200);

        return $response;
    }

    public function getImagenesShop(){
        
        // $imagenesShop = DB::table('aformularios')->all();

        $imagenesShop = \App\Modelos\Imagenesshop::all();

        $response = Response::json($imagenesShop, 200);

        return $response;
    }

    public function getRelColores(){
        
        $relColores = DB::table('colore_producto')->get();

        $response = Response::json($relColores, 200);

        return $response;
    }

    public function getProducto($id){
        $producto = \App\Modelos\Producto::find($id);

        if (!$producto) {
            return Response::json([
                'error' => [
                    'message' => 'No se ha encontrado el producto',
                ],
            ], 404);
        }

        return Response::json($producto, 200);

    }

    public function getProductosDestacados(){

        $productosDestacados = \App\Modelos\Producto::WHERE('popular', '=', 1)->get();

        $response = Response::json($productosDestacados, 200);

        return $response;
    }

    public function getImagenesDetalle(){
    // public function getImagenesDetalle($id){
        
        // $imagenesDetalle = \App\Modelos\Imagenesdetalle::WHERE('producto_id', '=', $id)->get();
        $imagenesDetalle = \App\Modelos\Imagenesdetalle::all();

        $response = Response::json($imagenesDetalle, 200);

        return $response;
    }

    // public function getStockProducto(){
    public function getStockProducto($id){
        
        $stockProducto = \App\Modelos\Stock::WHERE('producto_id', '=', $id)->get();
        // $stockProducto = \App\Modelos\Stock::all();

        $response = Response::json($stockProducto, 200);

        return $response;
    }

    public function guardarCarrito(Request $request){

        $datos = [
            'id' => $request->id,
            'producto_id' => $request->productId,
            'user_id' => $request->userId,
            'cantidad' => $request->cantidad,
            'talle' => $request->talle,
            'talle_id' => $request->talle_id,
            'ordene_id' => 0
        ];

        $carrito = \App\Modelos\Carrito::create($datos);

        $message = 'El carrito se guardo correctamente';

        $response = Response::json([
            'message'=> $message,
            'data' => $carrito,
        ], 201);

        return $response;

    }

    public function getCarrito($userId) {

        $carrito = \App\Modelos\Carrito::WHERE('user_id', '=', $userId)->get();

        $response = Response::json($carrito, 200);

        return $response;

    }

    public function deleteCarrito($id){

        \App\Modelos\Carrito::find($id)->delete();

    }

    public function guardarProductoFavorito(Request $request) {
        $datos = [
            'id' => $request->id,
            'producto_id' => $request->productId,
            'user_id' => $request->userId,
        ];

        $favorito = \App\Modelos\Favorito::create($datos);

        $message = 'El producto favorito se guardo correctamente';

        $response = Response::json([
            'message'=> $message,
            'data' => $favorito,
        ], 201);

        return $response;
    }

    public function deleteFavorito($id){

        \App\Modelos\Favorito::find($id)->delete();

    }

    public function getProductosFavoritos($userId) {

        $favoritos = \App\Modelos\Favorito::WHERE('user_id', '=', $userId)->get();

        $response = Response::json($favoritos, 200);

        return $response;

    }

}
