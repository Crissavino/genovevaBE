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
        $stocks = \App\Modelos\Stock::all();

        $prodIds = $request->productosIds;

        foreach ($stocks as $stock) {
            $cantidadVenta = 0;
            $id = 0;
            foreach ($prodIds as $idProducto) {
                if ($stock->producto_id === $idProducto) {
                    $cantidadVenta++;
                    $id = $idProducto;
                }
            }
            if ($stock->cantidad < $cantidadVenta && $stock->producto_id === $idProducto) {
                $message = 'No hay stock';

                $response = Response::json([
                    'message' => $message,
                    'noStock' => $idProducto,
                ], 201);

                return $response;
            } else {
                $nuevoCantidad = $stock->cantidad - $cantidadVenta;
                $stock->update(['cantidad' => $nuevoCantidad]);
            }
        }
        
        $datosOrden = [
            'user_id' => $request->user_id,
            // 'user_id' => $request->userId,
            'numOrden' => mt_rand(000000001, 999999999),
            'envio_id' => 0,
            'estadopago_id' => 4,
            'estadoenvio_id' => 1,
            'totalOrden' => $request->totalOrden,
        ];

        $orden = \App\Modelos\Ordene::create($datosOrden);

        $datosEnvio = [
            'user_id' => $request->user_id,
            // 'ordene_id' => $request->ordene_id,
            'ordene_id' => $orden->id,
            'name' => $request->name,
            'lastname' => $request->lastname,
            'pais_id' => $request->pais_id,
            'calle' => $request->calle,
            'numero' => $request->numero,
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
                $payment->payer = (object)array(
                    "email" => $request->email,
                );
                $payment->additional_info = (object)array(
                    'shipments' => (object)array(
                        'receiver_address' => (object)array(
                            "zip_code" => $request->cp,
                            'state_name' => $request->provincia,
                            'city_name' => $request->ciudad,
                            "street_number" => $request->numero,
                            "street_name" => $request->calle
                        ),
                    )
                );
                
                $payment->save();

                $preference = new MercadoPago\Preference();
                $preference->items = array(
                    'title' => "Genoveva Shop Online",
                    'quantity' => 1,
                    'currency_id' => "ARS",
                    'unit_price' => $request->total

                );
                $preference->payer = (object)array(
                    'email' => $request->email
                );
                $preference->shipments = (object)array(
                    'receiver_address' => (object)array(
                        "zip_code" => $request->cp,
                        'state_name' => $request->provincia,
                        'city_name' => $request->ciudad,
                        "street_number" => $request->numero,
                        "street_name" => $request->calle
                    ),
                    'mode' => "me2",
                    'dimensions' => "30x30x20,800",
                );

                $preference->save();

                $message = 'El pago se genero correctamente';

                $response = Response::json([
                    'message' => $message,
                    'payment' => $payment,
                    'estado' => $payment->status,
                    'detalle' => $payment->status_detail,
                    'total' => $payment->transaction_amount,
                    'envio' => $payment->additional_info,
                    'detalle de transaccion' => $payment->transaction_details,
                    'recursoExterno' => $payment->transaction_details->external_resource_url,
                    'referencia externa' => $payment->transaction_details->payment_method_reference_id,
                    'preference' => $preference,
                    'preferenceId' => $preference->id,
                    'preference1' => $preference->notification_url,
                    'preference2' => $preference->init_point,
                ], 201);

                // # Create a preference object
                // $preference = new MercadoPago\Preference();
                // # Create an item object
                // $item = new MercadoPago\Item();
                // $item->id = "1234";
                // $item->title = "Lightweight Paper Table";
                // $item->quantity = 3;
                // $item->currency_id = "ARS";
                // $item->unit_price = 55.41;
                // # Create a payer object
                // $payer = new MercadoPago\Payer();
                // $payer->name = "Charles";
                // $payer->surname = "Luevano";
                // $payer->email = "charles@hotmail.com";
                // $payer->date_created = "2018-06-02T12:58:41.425-04:00";
                // $payer->phone = array(
                //     "area_code" => "",
                //     "number" => "949 128 866"
                // );
                // $payer->identification = array(
                //     "type" => "DNI",
                //     "number" => "12345678"
                // );
                // $payer->address = array(
                //     "street_name" => "Cuesta Miguel Armendáriz",
                //     "street_number" => 1004,
                //     "zip_code" => "11020"
                // );
                // # creo el envio
                // $shipments = new MercadoPago\Shipments();
                // $shipments->mode = "me2";
                // $shipments->dimensions = "30x30x30,500";
                // $shipments->receiver_address = array(
                //     "zip_code" => "5700",
                //     "street_number" => 123,
                //     "street_name" => "Street",
                //     "floor" => 4,
                //     "apartment" => "C",
                // );

                // # Setting preference properties
                // $preference->back_urls = array(
                //     'success' => 'localhost:4200/#/home',
                //     'pending' => 'localhost:4200/#/shop',
                //     'failure' => 'localhost:4200/#/shop/descuentos'
                // );
                // $preference->items = array($item);
                // $preference->items = array(
                //     'id' => '1234',
                //     'title' => 'Lightweight Paper Table',
                //     'quantity' => 3,
                //     'currency_id' => 'ARS',
                //     'unit_price' => 55.41
                // );
                // $preference->payer = $payer;
                // $preference->payer = $payer;
                // $preference->shipments = $shipments;
                // # Save and posting preference
                // $preference->save();


                // $response = Response::json([
                //     'preference' => $preference->items,
                //     // 'backs' => $preference->back_urls
                // ], 201);
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
                // $shipments = new MercadoPago\Shipments();
                // $shipments->mode = "me2";
                // $shipments->dimensions = "30x30x30,500";
                // $shipments->receiver_address = array(
                //     "zip_code" => "5700",
                //     "street_number" => 123,
                //     "street_name" => "Street",
                //     "floor" => 4,
                //     "apartment" => "C",
                // );
                // fin envio

                // Save and posting the payment
                $payment->save();

                $preference = new MercadoPago\Preference();
                $preference->items = array(
                    'title' => "Genoveva Shop Online",
                    'quantity' => 1,
                    'currency_id' => "ARS",
                    'unit_price' => $request->total

                );
                $preference->payer = (object)array(
                    'email' => $request->email
                );
                $preference->shipments = (object)array(
                    'receiver_address' => (object)array(
                        "zip_code" => $request->cp,
                        'state_name' => $request->provincia,
                        'city_name' => $request->ciudad,
                        "street_number" => $request->numero,
                        "street_name" => $request->calle
                    ),
                    'mode' => "me2",
                    'dimensions' => "30x30x20,800",
                );

                $preference->save();
                //...
                // Print the payment status
                $message = 'El pago se genero correctamente';
                
                $response = Response::json([
                    'message' => $message,
                    'estado' => $payment->status,
                    'detalle' => $payment->status_detail,
                    'fecha' => $payment->date_approved,
                    'id' => $payment->id,
                    'payment_method_id' => $payment->payment_method_id,
                    'email' => $payment->payer->email,
                    'preference' => $preference,
                    'preferenceId' => $preference->id,
                    'preference1' => $preference->notification_url,
                    'preference2' => $preference->init_point,
                ], 201);
            //fin pagos con tarjeta
        }

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

    public function getEnvio($dimensions, $peso, $zip_code, $item_price)
    {
        MercadoPago\SDK::setClientId("8447599831708568");

        MercadoPago\SDK::setClientSecret("LoPu5tRluVz2kJMMhzdmQrSV7SV0kO14");

        $params = [ 'url_query' => [ 'dimensions' => $dimensions.','.$peso , 'zip_code' => $zip_code, 'item_price' => $item_price]]; //opcional ] ];

        $response = MercadoPago\SDK::get('/shipping_options', $params);

        $resp = Response::json($response, 200);

        return $resp;
    }
}
