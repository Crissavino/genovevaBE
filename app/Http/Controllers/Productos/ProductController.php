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
        $data = ['principales' => $categoriasPrincipales, 'secundarias' => $categoriasSecundarias];

        $response = Response::json($data, 200);

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

     public function storeProduct()
    {
        // la imagen debe guardarse en --> http://127.0.0.1:8000/storage/productos/imagen2/product-9.jpg (storage/productos/imagen2/product-9.jpg)

    }
    
    public function editarProducto(Request $request, $id)
    {
        // tengo que ver el video de youtube para ver como guardar y editar imagene
        // https: //www.youtube.com/watch?v=irfbIOi6DkQ&list=PLEtcGQaT56chhi-qsqxIrUG_n9pXYCZ8z&index=27
        // if ((!$request->titulo) || (!$request->descripcion) || (!$request->detalle) || (!$request->imagen1) || (!$request->imagen2) || (!$request->categoria_id) || (!$request->precio) || (!$request->stock)) {
        //     $response = Response::json([
        //         'message' => 'Por favor escriba todos los campos requeridos',
        //     ], 422);

        //     return $response;
        // }

        // $producto = \App\Modelos\Producto::find($request->id);

        // if (!$producto) {
        //     return Response::json([
        //         'error' => [
        //             'message' => 'No se ha encontrado el producto',
        //         ],
        //     ], 404);
        // }



        // $producto->titulo = trim($request->titulo);
        // $producto->descripcion = trim($request->descripcion);
        // $producto->detalle = trim($request->detalle);
        // $producto->imagen1 = trim($request->imagen1);
        // $producto->imagen2 = trim($request->imagen2);
        // $producto->categoria_id = trim($request->categoria_id);
        // $producto->precio = trim($request->precio);
        // if ($request->descuento) {
        //     $producto->descuento = trim($request->descuento);
        // }
        // $producto->stock = trim($request->stock);
        // $producto->save();

        // $message = 'El producto se actualizó correctamente';

        // $response = Response::json([
        //     'message' => $message,
        //     'data' => $producto,
        // ], 201);

        $respuesta = $request;
        
        return $respuesta;

    }

    public function guardarImagenes(Request $request) 
    {
        $data = $request;

        // $archivo = $data['0']['archivo'];
        return $data;
        // return $request;
    }
}
