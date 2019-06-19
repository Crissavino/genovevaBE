<?php

namespace App\Http\Controllers\Productos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class ProductController extends Controller
{
    public function showProducts()
    {
        $productos = \App\Modelos\Producto::all();
        $response = Response::json($productos, 200);
        return $response;
    }
    
    // public function getCategoriasP(){
        
    //     $categoriasPrincipales = \App\Modelos\Categoria::all();
        
    //     $response = Response::json($categoriasPrincipales, 200);
    //     return $response;
    // }

    public function getDatos(){
    // public function getCategoriasS(){

        $categoriasPrincipales = \App\Modelos\Categoria::all();
        $categoriasSecundarias = \App\Modelos\Categoriassecundaria::all();
        $talles = \App\Modelos\Talle::all();
        $colores = \App\Modelos\Colore::all();
        $data = ['principales' => $categoriasPrincipales, 'secundarias' => $categoriasSecundarias, 'talles' => $talles, 'colores' => $colores];

        $response = Response::json($data, 200);

        return $response;
    }

    public function getImagenesShop(){
        
        $imagenesShop = \App\Modelos\Imagenesshop::all();

        $response = Response::json($imagenesShop, 200);

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

    public function getImagenesDetalle($id){
        
        $imagenesDetalle = \App\Modelos\Imagenesdetalle::WHERE('producto_id', '=', $id)->get();

        $response = Response::json($imagenesDetalle, 200);

        return $response;
    }

    public function getStockProducto($id){
        
        $stockProducto = \App\Modelos\Stock::WHERE('producto_id', '=', $id)->get();

        $response = Response::json($stockProducto, 200);

        return $response;
    }

    public function guardarCarrito(Request $request){

        $data = [
            'producto_id' => $request->productId, 
            'user_id' => $request->userId, 
            'cantidad' => $request->cantidad,
            'talle' => $request->talle
        ];

        // $carrito = \App\Modelos\Carrito::create($data);

        return \App\Modelos\Carrito::create($data);

    }

    public function getCarrito($userId) {

        $carrito = \App\Modelos\Carrito::WHERE('user_id', '=', $userId)->get();

        $response = Response::json($carrito, 200);

        return $response;

    }

    public function deleteCarrito($id){

        \App\Modelos\Carrito::find($id)->delete();

    }

}
