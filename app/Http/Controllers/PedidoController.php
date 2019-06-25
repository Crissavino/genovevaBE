<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function realizarPedido(Request $request) 
    {
        $datosOrden = [
            'user_id' => $request->userId,
            'numOrden' => mt_rand(000000001, 999999999),
            'envio_id' => 0,
        ];

        $orden = \App\Modelos\Ordene::create($datosOrden);

        $datosEnvio = [
            'user_id' => $request->userId,
            // 'ordene_id' => $request->ordene_id,
            'ordene_id' => $orden->id,
            'name' => $request->name,
            'lastname' => $request->lastname,
            'pais_id' => $request->pais_id,
            'direccion1' => $request->direccion1,
            'direccion2' => $request->direccion2,
            'cp' => $request->cp,
            'provincia' => $request->provincia,
            'ciudad' => $request->ciudad,
            'telefono' => $request->telefono,
            'email' => $request->email
        ];

        $envio = \App\Modelos\Envio::create($datosEnvio);

        $orden->update(['envio_id' => $envio->id]);

        $carritos = \App\Modelos\Carrito::WHERE('user_id', '=', $request->userId)->get();

        foreach ($carritos as $carrito) {
            $carrito->update(['ordene_id' => $orden->id]);
        }

        $message = 'La información del envío se guardo correctamente';

        $response = Response::json([
            'message'=> $message,
            'datosEnvio' => $envio,
        ], 201);

        return $response;
    }
}
