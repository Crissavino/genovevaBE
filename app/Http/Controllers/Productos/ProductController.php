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

    // public function getImagenesProducto($id){

    // }

}
