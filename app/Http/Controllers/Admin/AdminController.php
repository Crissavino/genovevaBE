<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function show()
    {
        $productos = \App\Modelos\Producto::all();

        $productosLatest = \App\Modelos\Producto::latest()->get();
        $productosOrderBy = \App\Modelos\Producto::orderBy('updated_at', 'desc')->get();
        dd($productosLatest, $productosOrderBy);


        $categoriasPrincipales = \App\Modelos\Categoria::all();
        $categoriasSecundarias = \App\Modelos\Categoriassecundaria::all();
        $colores = \App\Modelos\Colore::all();
        $stocks = \App\Modelos\Stock::all();
        $talles = \App\Modelos\Talle::all();

        // return view('admin.admin', [ 
        //                             'productos' => $productos,
        //                             'categoriasPrincipales' => $categoriasPrincipales,
        //                             'categoriasSecundarias' => $categoriasSecundarias,
        //                             'colores' => $colores,
        //                             'stocks' => $stocks,
        //                             'talles' => $talles,
        //                         ]);
        return view('dashboard.productos.productos', [ 
            'productos' => $productos,
            'categoriasPrincipales' => $categoriasPrincipales,
            'categoriasSecundarias' => $categoriasSecundarias,
            'colores' => $colores,
            'stocks' => $stocks,
            'talles' => $talles,
        ]);
    }

    public function createProducto()
    {
        $categoriasPrincipales = \App\Modelos\Categoria::all();
        $categoriasSecundarias = \App\Modelos\Categoriassecundaria::all();
        $colores = \App\Modelos\Colore::all();
        $stocks = \App\Modelos\Stock::all();
        $talles = \App\Modelos\Talle::all();

        // return view('admin.producto-nuevo', [
        //                             'categoriasPrincipales' => $categoriasPrincipales,
        //                             'categoriasSecundarias' => $categoriasSecundarias,
        //                             'colores' => $colores,
        //                             'stocks' => $stocks,
        //                             'talles' => $talles,
        //                         ]);
        return view('dashboard.productos.nuevoProd', [
            'categoriasPrincipales' => $categoriasPrincipales,
            'categoriasSecundarias' => $categoriasSecundarias,
            'colores' => $colores,
            'stocks' => $stocks,
            'talles' => $talles,
        ]);
    }

    public function insertProducto()
    {
        request()->validate(
            [
                'titulo' => 'required | min:3 | max:30',
                'categoria_id' => 'required | numeric',
                'nuevo' => 'required',
                'popular' => 'required',
                'categoriasSecundarias' => 'required | array | min:1 | max:3',
                'imagenShop' => 'required | array | min:2 | max:2',
                'imagenDetalle' => 'required | array | min:1 | max:5',
                'detalle' => 'required | min:10 | max:60',
                'talles' => 'required | array | min:1',
                // 'descripcion' => 'required | min:20',
                'precio' => 'required | numeric | min:1 | max:10000',
                'descuento' => 'nullable | numeric | min:1 | max:100',
            ],
            [
                'titulo.required' => 'Tenes que agregar un título',
                'titulo.min' => 'El título debe tener como mínimo 3 letras',
                'titulo.max' => 'El título debe tener como máximo 30 letras',
                'categoria_id.required' => 'Tenes que elegir una categoria',
                'nuevo.required' => 'Tenes que elegir si es un producto nuevo',
                'popular.required' => 'Tenes que elegir si queres destacarlo',
                'categoriasSecundarias.required' => 'Tenes que elegir por lo menos una categoria secundaria',
                'categoriasSecundarias.min' => 'Como mínimo tenes que elegir 1 categoria secundaria',
                'categoriasSecundarias.max' => 'Como máximo podes elegir 3 categorias secundarias',
                'imagenShop.required' => 'Tenes que seleccionar dos imagenes para el shop',
                'imagenShop.min' => 'Tenes que seleccionar dos imagenes para el shop',
                'imagenShop.max' => 'Tenes que seleccionar dos imagenes para el shop',
                // valido formato de imagen con js
                'imagenDetalle.required' => 'Tenes que seleccionar las imagenes que se verán en el detalle del producto',
                'imagenDetalle.min' => 'Tenes que seleccionar como mínimo 1 imagen para el detalle del producto',
                'imagenDetalle.max' => 'Podes seleccionar como máximo 5 imagenes para el detalle del producto',
                // valido formato de imagen con js
                'detalle.required' => 'Tenes que agregar un detalle',
                'detalle.min' => 'El detalle debe tener como mínimo 10 letras',
                'detalle.max' => 'El detalle debe tener como máximo 60 letras',
                'talles.required' => 'Tenes que seleccionar un talle',
                'talles.min' => 'Tenes que seleccionar por lo menos un talle',
                // 'descripcion.required' => 'Tenes que agregar una descripción',
                // 'descripcion.min' => 'La descripción debe tener como mínimo 20 letras',
                'precio.required' => 'Tenes que agregar un precio',
                'precio.numeric' => 'El precio debe ser un número',
                'precio.min' => 'El precio debe ser mayor a $ 1',
                'precio.max' => 'El precio debe ser menor a $ 10.000',
                'descuento.numeric' => 'El descuento debe ser un número',
                'descuento.min' => 'El descuento debe ser mayor a 0%',
                'descuento.max' => 'El descuento debe ser menor a 100%',
            ]);
        
        
        $data = request()->all();
        // al producto van titulo descripcion detalle descuento categoria_id precio nuevo popular

        $guardoProducto = \App\Modelos\Producto::create($data);

        $idProducto = $guardoProducto->id;

        $producto = \App\Modelos\Producto::find($idProducto);
        
        // guardo relacion de categorias secundarias en tabla pivot
        $guardoCategoriasSecundarias = $producto->categoriassecundarias()->sync($data['categoriasSecundarias']);

        //guardo las imagenes del shop en su tabla y relaciono
        for ($i=0; $i < count($data['imagenShop']); $i++) { 

            $imagen = str_slug($data['titulo']).'-ImagenShop'.($i + 1);

            $imagen = $imagen.'.'.request()->file('imagenShop')[$i]->extension();

            $pathImagen = request()->file('imagenShop')[$i]->storeAs('public/productos/imagenesShop', $imagen);

            $pathImagen = str_replace('public', 'storage', $pathImagen);

            $urlBackEnd = 'https://genovevabe.cf/';
            // $urlBackEnd = 'http://127.0.0.1:8000/';

            $datos = ['path' => $urlBackEnd.$pathImagen, 'producto_id' => $idProducto];

            $guardoImagenShop = \App\Modelos\Imagenesshop::create($datos);

            // $imagenesShopsIds[] = $guardoImagenShop->id;

        }

        //guardo la relacion con imagenesShop en la tabla pivot
        // $producto->imagenesshops()->sync($imagenesShopsIds);

        //guardo las imagenes del detalle en su tabla y relaciono
        for ($i=0; $i < count($data['imagenDetalle']); $i++) { 

            $imagen = str_slug($data['titulo']).'-ImagenDetalle'.($i + 1);

            $imagen = $imagen.'.'.request()->file('imagenDetalle')[$i]->extension();

            $pathImagen = request()->file('imagenDetalle')[$i]->storeAs('public/productos/imagenesDetalle', $imagen);

            $pathImagen = str_replace('public', 'storage', $pathImagen);

            $urlBackEnd = 'https://genovevabe.cf/';
            // $urlBackEnd = 'http://127.0.0.1:8000/';

            $datos = ['path' => $urlBackEnd.$pathImagen, 'producto_id' => $idProducto];

            $guardoImagenDetalle = \App\Modelos\Imagenesdetalle::create($datos);

            // $imagenesDetallesIds[] = $guardoImagenDetalle->id;
        }
        
        //guardo la relacion con imagenesDetalle en la tabla pivot
        // $producto->imagenesdetalles()->sync($imagenesDetallesIds);
        
        for ($i=0; $i < count($data['talles']); $i++) {
            $stock = ['producto_id' => $idProducto, 'talle_id' => $data['talles'][$i], 'cantidad' => $data['cantidadId'.$data['talles'][$i]]];
            
            $guardoStock = \App\Modelos\Stock::create($stock);

            $stockIds[] = $guardoStock->id;
        }

        // guardo relacion producto talle
        $producto->talles()->sync($data['talles']);
        
        // no puedo hacerlo porque es hasMany
        // $producto->stocks()->sync($stockIds);

        //guardo los colores del producto
        $guardoRelacionColores = $producto->colores()->sync($data['colores']);

        return redirect('/admin/productos');

    }

    public function editProducto($id)
    {
        $producto = \App\Modelos\Producto::find($id);

        $categoriasPrincipales = \App\Modelos\Categoria::all();
        $categoriasSecundarias = \App\Modelos\Categoriassecundaria::all();
        $colores = \App\Modelos\Colore::all();
        $stocks = \App\Modelos\Stock::all();
        $talles = \App\Modelos\Talle::all();

        $imagenesshops = \App\Modelos\Imagenesshop::all();

        $imagenesdetalles = \App\Modelos\Imagenesdetalle::all();

        // return view('admin.producto-edit', [
        //                                     'producto' => $producto,
        //                                     'categoriasPrincipales' => $categoriasPrincipales,
        //                                     'categoriasSecundarias' => $categoriasSecundarias,
        //                                     'colores' => $colores,
        //                                     'stocks' => $stocks,
        //                                     'talles' => $talles,
        //                                     'imagenesshops' => $imagenesshops,
        //                                     'imagenesdetalles' => $imagenesdetalles,
        //                                 ]);
        return view('dashboard.productos.editProd', [
            'producto' => $producto,
            'categoriasPrincipales' => $categoriasPrincipales,
            'categoriasSecundarias' => $categoriasSecundarias,
            'colores' => $colores,
            'stocks' => $stocks,
            'talles' => $talles,
            'imagenesshops' => $imagenesshops,
            'imagenesdetalles' => $imagenesdetalles,
        ]);
    }

    public function updateProducto($id){
        $data = request()->all();

        // agarro el producto a actualizar
        $producto = \App\Modelos\Producto::find($id);

        // actualizoProducto
        $producto->update($data);
        
        $guardoCategoriasSecundarias = $producto->categoriassecundarias()->sync($data['categoriasSecundarias']);

        if (isset($data['imagenShop'])) {

            //borro las imagenes que estaban cargadas antes
            foreach ($producto->imagenesshops as $imagenShop) {
                $imagenShop->delete();
            }

            for ($i=0; $i < count($data['imagenShop']); $i++) { 
                
                $imagen = str_slug($data['titulo']).'-ImagenShop'.($i + 1);

                $imagen = $imagen.'.'.request()->file('imagenShop')[$i]->extension();

                $pathImagen = request()->file('imagenShop')[$i]->storeAs('public/productos/imagenesShop', $imagen);

                $pathImagen = str_replace('public', 'storage', $pathImagen);

                $urlBackEnd = 'https://genovevabe.cf/';
                // $urlBackEnd = 'http://127.0.0.1:8000/';

                $datos = ['path' => $urlBackEnd.$pathImagen, 'producto_id' => $id];

                $guardoImagenShop = \App\Modelos\Imagenesshop::create($datos);
                // $imagenesShopsIds[] = $producto->imagenesshops[$i]->id;

            }
            //guardo la relacion con imagenesShop en la tabla pivot
            // $producto->imagenesshops()->sync($imagenesShopsIds);

        }

        //guardo las imagenes del detalle en su tabla y relaciono

        if (isset($data['imagenDetalle'])) {

            //borro las imagenes que estaban cargadas antes
            foreach ($producto->imagenesdetalles as $imagenDetalle) {
                $imagenDetalle->delete();
            }

            for ($i=0; $i < count($data['imagenDetalle']); $i++) { 

                $imagen = str_slug($data['titulo']).'-ImagenDetalle'.($i + 1);
    
                $imagen = $imagen.'.'.request()->file('imagenDetalle')[$i]->extension();
    
                $pathImagen = request()->file('imagenDetalle')[$i]->storeAs('public/productos/imagenesDetalle', $imagen);
    
                $pathImagen = str_replace('public', 'storage', $pathImagen);
    
                $urlBackEnd = 'https://genovevabe.cf/';
                // $urlBackEnd = 'http://127.0.0.1:8000/';
    
                $datos = ['path' => $urlBackEnd.$pathImagen, 'producto_id' => $id];
    
                $guardoImagenDetalle = \App\Modelos\Imagenesdetalle::create($datos);
    
                // $imagenesDetallesIds[] = $guardoImagenDetalle->id;
            }


            // if (count($data['imagenDetalle']) > count($producto->imagenesdetalles)) {
            //     // $imagenesDetallesIds = [];
            //     for ($i=0; $i < count($producto->imagenesdetalles); $i++) { 

            //         $imagen = str_slug($data['titulo']).'-ImagenDetalle'.($i + 1);

            //         $imagen = $imagen.'.'.request()->file('imagenDetalle')[$i]->extension();

            //         $pathImagen = request()->file('imagenDetalle')[$i]->storeAs('public/productos/imagenesDetalle', $imagen);

            //         $pathImagen = str_replace('public', 'storage', $pathImagen);

            //         $urlBackEnd = 'https://genovevabe.cf/';
            //         // $urlBackEnd = 'http://127.0.0.1:8000/';

            //         $datos = ['path' => $urlBackEnd.$pathImagen, 'producto_id' => $id];

            //         $producto->imagenesdetalles[$i]->update($datos);

            //         // $imagenesDetallesIds[] = $producto->imagenesdetalles[$i]->id;

            //     }

            //     for ($i=count($producto->imagenesdetalles); $i < count($data['imagenDetalle']); $i++) { 

            //         $imagen = str_slug($data['titulo']).'-ImagenDetalle'.($i + 1);

            //         $imagen = $imagen.'.'.request()->file('imagenDetalle')[$i]->extension();

            //         $pathImagen = request()->file('imagenDetalle')[$i]->storeAs('public/productos/imagenesDetalle', $imagen);

            //         $pathImagen = str_replace('public', 'storage', $pathImagen);

            //         $urlBackEnd = 'https://genovevabe.cf/';
            //         // $urlBackEnd = 'http://127.0.0.1:8000/';

            //         $datos = ['path' => $urlBackEnd.$pathImagen, 'producto_id' => $id];

            //         $guardoImagenDetalle = \App\Modelos\Imagenesdetalle::create($datos);

            //         // $imagenesDetallesIds[] = $guardoImagenDetalle->id;

            //     }
            // }else{

            //     for ($i=0; $i < count($data['imagenDetalle']); $i++) { 
                    
            //         $imagen = str_slug($data['titulo']).'-ImagenDetalle'.($i + 1);

            //         $imagen = $imagen.'.'.request()->file('imagenDetalle')[$i]->extension();

            //         $pathImagen = request()->file('imagenDetalle')[$i]->storeAs('public/productos/imagenesDetalle', $imagen);

            //         $pathImagen = str_replace('public', 'storage', $pathImagen);

            //         $urlBackEnd = 'https://genovevabe.cf/';
            //         // $urlBackEnd = 'http://127.0.0.1:8000/';

            //         $datos = ['path' => $urlBackEnd.$pathImagen, 'producto_id' => $id];

            //         $producto->imagenesdetalles[$i]->update($datos);

            //         // $imagenesDetallesIds[] = $producto->imagenesdetalles[$i]->id;
            //     }

            //     for ($i=count($data['imagenDetalle']); $i < count($producto->imagenesdetalles); $i++) { 
            //         $producto->imagenesdetalles[$i]->delete();
            //     }
            // }
            //guardo la relacion con imagenesDetalle en la tabla pivot
            // $producto->imagenesdetalles()->sync($imagenesDetallesIds);
        }
        
        if (isset($data['talles'])) {
            
            for ($i=0; $i < count($data['talles']); $i++) {
                if (\App\Modelos\Stock::WHERE('producto_id', '=', $id)->WHERE('talle_id', '=', $data['talles'][$i])->exists()) {
                    
                    $datos = ['producto_id' => $id, 'talle_id' => $data['talles'][$i], 'cantidad' => $data['cantidadId' . $data['talles'][$i]]];

                    $stock = \App\Modelos\Stock::WHERE('producto_id', '=', $id)->WHERE('talle_id', '=', $data['talles'][$i]);

                    $stock->update($datos);

                }else{

                    $datos = ['producto_id' => $id, 'talle_id' => $data['talles'][$i], 'cantidad' => $data['cantidadId'.$data['talles'][$i]]];
                
                    $stock = \App\Modelos\Stock::create($datos);

                }
            }

            // guardo relacion producto talle
            $producto->talles()->sync($data['talles']);
        }

        //guardo los colores del producto
        $guardoRelacionColores = $producto->colores()->sync($data['colores']);

        return redirect('/admin/productos');

    }

    public function destroyProducto($id)
    {
        $fecha_hoy = Carbon::now();

        $producto = \App\Modelos\Producto::find($id);

        //borra completamente la relacion
        $producto->categoriassecundarias()->detach();

        $producto->colores()->detach();

        $producto->imagenesshops()->delete();

        $producto->imagenesdetalles()->delete();

        $producto->talles()->detach();

        $producto->stocks()->delete();
        
        $producto->delete();

        session()->flash('message', 'El producto se eliminó con éxito.');
        
        return redirect('/admin');

    }

    public function deleteProducto($prodId)
    {

        $producto = \App\Modelos\Producto::find($prodId);
        
        $producto->delete();

        $mensaje = 'Se eliminó el producto correctamente';

        $response = Response::json(['mensaje' => $mensaje], 200);

        return $response;
    }

    public function updateVisible($prodId){

        $producto = \App\Modelos\Producto::find($prodId);

        $data = request()->all();

        $dato = ['visible' => $data['visible']];

        $producto->update($dato);

        if ($data['visible'] == 1) {
            session()->flash('message', $producto->titulo.' es ahora visible para todos.');
        }

        if ($data['visible'] == 2) {
            session()->flash('message', $producto->titulo.' no es mas visible.');
        }

        return redirect('/admin/productos/');
    }
}
