<?php

namespace App\Http\Controllers\Ordenes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrdenesController extends Controller
{
    public function showOrdenes()
    {
        $productos = \App\Modelos\Producto::all();
        $categoriasPrincipales = \App\Modelos\Categoria::all();
        $categoriasSecundarias = \App\Modelos\Categoriassecundaria::all();
        $colores = \App\Modelos\Colore::all();
        $stocks = \App\Modelos\Stock::all();
        $talles = \App\Modelos\Talle::all();
        $ordenes = \App\Modelos\Ordene::all();
        $carritos = \App\Modelos\Carrito::all();
        $estadoPagos = \App\Modelos\Estadopago::all();
        $usuarios = \App\User::all();



        return view('ordenes.ordenes', [ 
                                    'productos' => $productos,
                                    'categoriasPrincipales' => $categoriasPrincipales,
                                    'categoriasSecundarias' => $categoriasSecundarias,
                                    'colores' => $colores,
                                    'stocks' => $stocks,
                                    'talles' => $talles,
                                    'ordenes' => $ordenes,
                                    'carritos' => $carritos,
                                    'usuarios' => $usuarios,
                                    'estadoPagos' => $estadoPagos,
                                ]);
    }
}
