<?php

namespace App\Http\Controllers\Ordenes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

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
        // $ordenes = \App\Modelos\Ordene::all();
        $ordenes = \App\Modelos\Ordene::orderBy('created_at', 'desc')->get();
        // $ordenes = \App\Modelos\Ordene::WHERE('envio_id', '!=', 0)->orderBy('created_at', 'desc')->get();
        $envios = \App\Modelos\Envio::all();
        $carritos = \App\Modelos\Carrito::all();
        $estadoPagos = \App\Modelos\Estadopago::all();
        $estadoEnvios = \App\Modelos\Estadoenvio::all();
        $usuarios = \App\User::all();



        // return view('ordenes.ordenes', [ 
        //                             'productos' => $productos,
        //                             'categoriasPrincipales' => $categoriasPrincipales,
        //                             'categoriasSecundarias' => $categoriasSecundarias,
        //                             'colores' => $colores,
        //                             'stocks' => $stocks,
        //                             'talles' => $talles,
        //                             'ordenes' => $ordenes,
        //                             'carritos' => $carritos,
        //                             'usuarios' => $usuarios,
        //                             'estadoPagos' => $estadoPagos,
        //                             'estadoEnvios' => $estadoEnvios,
        //                             'envios' => $envios,
        //                         ]);
        return view('dashboard.ordenes', [ 
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
            'estadoEnvios' => $estadoEnvios,
            'envios' => $envios,
        ]);
    }

    public function updateOrden($id)
    {
        $data = request()->all();

        $orden = \App\Modelos\Ordene::find($id);

        if (isset($data['estadoPago'])) {
            $orden->update(['estadopago_id' => $data['estadoPago']]);
        }

        if (isset($data['estadoEnvio'])) {
            $orden->update(['estadoenvio_id' => $data['estadoEnvio']]);
        }

        if (isset($data['numSeguimiento'])) {
            $orden->update(['numSeguimiento' => $data['numSeguimiento']]);
        }

        return redirect('/admin/ordenes');

    }

    public function getOrdenes()
    {
        $ordenes = \App\Modelos\Ordene::all();

        $response = Response::json($ordenes, 200);

        return $response;
    }

}
