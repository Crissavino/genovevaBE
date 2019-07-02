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
            'user_id' => $request->user_id,
            // 'user_id' => $request->userId,
            'numOrden' => mt_rand(000000001, 999999999),
            'envio_id' => 0,
            'estadopago_id' => 4,
            'estadoenvio_id' => 1,
        ];

        $orden = \App\Modelos\Ordene::create($datosOrden);

        $datosEnvio = [
            'user_id' => $request->user_id,
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

        $carritos = \App\Modelos\Carrito::WHERE('user_id', '=', $request->user_id)->WHERE('ordene_id', '=', 0)->get();

        foreach ($carritos as $carrito) {
            $carrito->update(['ordene_id' => $orden->id]);
        }

        $message = 'La información del envío se guardo correctamente';

        $response = Response::json([
            'message'=> $message,
            'datosEnvio' => $envio,
            'datosOrden' => $orden,
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
// envio
$shipments = new MercadoPago\Shipments();
$shipments->mode = "me2";
$shipments->dimensions = "30x30x30,500";
$shipments->receiver_address = array(
    "zip_code" => "5700",
    "street_number" => 123,
    "street_name" => "Street",
    "floor" => 4,
    "apartment" => "C",
);
// fin envio

        if ($request->metodo) {
            // // pago en efectivo funciona
            //     MercadoPago\SDK::setAccessToken("TEST-8447599831708568-062517-59dec1ad9697d89f066c24c7528a2fb8-447000507");

            //     $payment = new MercadoPago\Payment();
            //     $payment->transaction_amount = $request->total;
            //     // $payment->notification_url = "direccion/donde/va/el/receptor/de/notificaciones --> recibirNotificacionMP()"; // url para la notifiacion del estado del pago e ir actualizandolo
            //     $payment->description = $request->descripcion;
            //     $payment->payment_method_id = $request->metodo;
            //     $payment->payer = array(
            //         "email" => $request->email,
            //     );
                

            //     $payment->save();

            //     $response = Response::json([
            //         'estado' => $payment->status,
            //         'detalle' => $payment->status_detail,
            //         'detalle de transaccion' => $payment->transaction_details,
            //         'recursoExterno' => $payment->transaction_details->external_resource_url,
            //         'referencia externa' => $payment->transaction_details->payment_method_reference_id,
            //     ], 201);
            // // fin pago en efectivo funciona

            //pagon en efectivo con preference

                MercadoPago\SDK::setAccessToken("TEST-8447599831708568-062517-59dec1ad9697d89f066c24c7528a2fb8-447000507");

                $payment = new MercadoPago\Payment();
                $payment->transaction_amount = $request->total;
                // $payment->notification_url = "direccion/donde/va/el/receptor/de/notificaciones --> recibirNotificacionMP()"; // url para la notifiacion del estado del pago e ir actualizandolo
                $payment->description = $request->descripcion;
                $payment->payment_method_id = $request->metodo;
                $payment->payer = array(
                    "email" => $request->email,
                );

                $payment->save();

                $preference = new MercadoPago\Preference();

                $shipments = new MercadoPago\Shipments();
                $shipments->mode = "me2";
                $shipments->dimensions = "20x30x30,800";
                // $shipment->default_shipping_method = 73328;
                // $shipments->free_methods = array(
                //     array("id" => 73328),
                // );
                $shipments->receiver_address = array(
                    "zip_code" => "1900",
                    "street_number" => 1542,
                    "street_name" => "135",
                    // "floor" => 4,
                    // "apartment" => "C",
                );

                $preference->shipments = $shipments;

                $preference->save();

                $response = Response::json([
                    'estado' => $payment->status,
                    'detalle' => $payment->status_detail,
                    'detalle de transaccion' => $payment->transaction_details,
                    'recursoExterno' => $payment->transaction_details->external_resource_url,
                    'referencia externa' => $payment->transaction_details->payment_method_reference_id,
                ], 201);
                //fin paga en efectivo con preference

        }

        if ($request->emisorTarjeta) {
            //funciona, asi se reciben pagos con tarjeta tanto para uno como mas cuotas
                MercadoPago\SDK::setAccessToken("TEST-8447599831708568-062517-59dec1ad9697d89f066c24c7528a2fb8-447000507");

                $payment = new MercadoPago\Payment();
                $payment->transaction_amount = $request->total;
                // $payment->notification_url = "direccion/donde/va/el/receptor/de/notificaciones --> recibirNotificacionMP()"; // url para la notifiacion del estado del pago e ir actualizandolo
                $payment->token = $request->token; // response.id de sdkResponseHandler
                $payment->description = $request->description;
                $payment->installments = $request->cuotas;
                $payment->payment_method_id = $request->emisorTarjeta; // respone[0].id de setPaymentMethodInfo
                $payment->payer = array(
                    "email" => $request->email,
                );

                // envio
                $shipments = new MercadoPago\Shipments();
                $shipments->mode = "me2";
                $shipments->dimensions = "30x30x30,500";
                $shipments->receiver_address = array(
                    "zip_code" => "5700",
                    "street_number" => 123,
                    "street_name" => "Street",
                    "floor" => 4,
                    "apartment" => "C",
                );
                // fin envio

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

    public function recibirNotificacionMP() {
        // // para recibir notificaciones
            // MercadoPago\SDK::setAccessToken("TEST-8447599831708568-062517-59dec1ad9697d89f066c24c7528a2fb8-447000507");

            // curl -X GET \
            //     'https://api.mercadopago.com/v1/payments/:id?access_token=ACCESS_TOKEN_ENV' 
            // switch ($_POST["type"]) {
            //     case "payment":
            //         $payment = MercadoPago\SDK::Payment(find_by_id($_POST["id"]));
            //         // $payment = MercadoPago\Payment.find_by_id($_POST["id"]);
            //         break;
            //     case "plan":
            //         $plan = MercadoPago\SDK::Plan(find_by_id($_POST["id"]));
            //         // $plan = MercadoPago\Plan.find_by_id($_POST["id"]);
            //         break;
            //     case "subscription":
            //         $plan = MercadoPago\SDK::Subscription(find_by_id($_POST["id"]));
            //         // $plan = MercadoPago\Subscription.find_by_id($_POST["id"]);
            //         break;
            //     case "invoice":
            //         $plan = MercadoPago\SDK::Invoice(find_by_id($_POST["id"]));
            //         // $plan = MercadoPago\Invoice.find_by_id($_POST["id"]);
            //         break;
            // }

        // // fin recibir notificaciones
    }
}
