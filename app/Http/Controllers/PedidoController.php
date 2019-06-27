<?php

namespace App\Http\Controllers;
require '../vendor/autoload.php';

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use MercadoPago;

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

    public function pagarMP(Request $request)
    {
        // mi usuario
            // MercadoPago\SDK::setClientId("3543348832977202");
            // MercadoPago\SDK::setClientSecret("0GpqH4oK6neBq6g1fnuLldzP6nmuB1d3");
            // MercadoPago\SDK::setPublicKey("TEST-be45daa0-f3d3-46c8-8914-a2ff1a498443");
            // MercadoPago\SDK::setAccessToken("TEST-3543348832977202-062514-dc88e6a8deedcc7ddbc8f0b8f524dfbf-446908096");
        //fin mi usuario

        // usuario vendedor
            // test_user_99495498@testuser.com
            // qatest8869
            // MercadoPago\SDK::setClientId("8447599831708568");
            // MercadoPago\SDK::setClientSecret("LoPu5tRluVz2kJMMhzdmQrSV7SV0kO14");
            // MercadoPago\SDK::setPublicKey("TEST-0dd0d31e-809e-4bb1-89c7-29742cf40abe");
            // MercadoPago\SDK::setAccessToken("TEST-8447599831708568-062517-59dec1ad9697d89f066c24c7528a2fb8-447000507");
        // fin usuario vendedor

        // usuario comprador
            // test_user_4855076@testuser.com
            // qatest8496
        // fin usuario comprador

        if ($request->metodo) {
            // pago en efectivo
                MercadoPago\SDK::setAccessToken("TEST-8447599831708568-062517-59dec1ad9697d89f066c24c7528a2fb8-447000507");

                $payment = new MercadoPago\Payment();
                $payment->transaction_amount = $request->total;
                $payment->description = $request->descripcion;
                $payment->payment_method_id = $request->metodo;
                $payment->payer = array(
                    "email" => $request->email,
                );

                $payment->save();

                $response = Response::json([
                    'estado' => $payment->status,
                    'detalle' => $payment->status_detail,
                    'detalle de transaccion' => $payment->transaction_details,
                    'recursoExterno' => $payment->transaction_details->external_resource_url,
                    'referencia externa' => $payment->transaction_details->payment_method_reference_id,
                ], 201);
            // fin pago en efectivo
        }

        if ($request->emisorTarjeta) {
            //funciona, asi se reciben pagos con tarjeta tanto para uno como mas cuotas
                MercadoPago\SDK::setAccessToken("TEST-8447599831708568-062517-59dec1ad9697d89f066c24c7528a2fb8-447000507");

                $payment = new MercadoPago\Payment();
                $payment->transaction_amount = $request->total;
                $payment->token = $request->token; // response.id de sdkResponseHandler
                $payment->description = $request->description;
                $payment->installments = $request->cuotas;
                $payment->payment_method_id = $request->emisorTarjeta; // respone[0].id de setPaymentMethodInfo
                $payment->payer = array(
                    "email" => $request->email,
                );

                // Save and posting the payment
                $payment->save();
                //...
                // Print the payment status
                
                $response = Response::json([
                    'estado' => $payment->status,
                    'detalle' => $payment->status_detail,
                    'fecha' => $payment->date_approved,
                    'id' => $payment->id,
                    'payment_method_id' => $payment->payment_method_id,
                    'email' => $payment->payer->email,
                ], 201);
            //fin pagos con tarjeta
        }

        // $response = Response::json([
        //     'no entro' => 'no entro en ninguno',
        // ], 201);
        return $response;
        
    }

    public function obtenerMediosDePago(){

        MercadoPago\SDK::setAccessToken("TEST-8447599831708568-062517-59dec1ad9697d89f066c24c7528a2fb8-447000507");

        $payment_methods = MercadoPago\SDK::get("/v1/payment_methods");

        $response = Response::json($payment_methods, 200);

        return $response;
    }

    // public function crearOrdenMP() {
    //     MercadoPago\SDK::setAccessToken("TEST-8447599831708568-062517-59dec1ad9697d89f066c24c7528a2fb8-447000507");

    //     $payment_methods = MercadoPago\SDK::post("/merchant_orders", $infoOrden);
    // }
}
