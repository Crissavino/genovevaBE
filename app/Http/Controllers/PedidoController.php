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
        $talles = \App\Modelos\Talle::all();

        $prodsIdsTalles = $request->prods;

        foreach ($stocks as $stock) {
            $cantidadVenta = 0;
            $id = 0;
            $talleId = 0;
            foreach ($prodsIdsTalles as $prod) {
                if ($stock->producto_id === $prod['id'] && $stock->talle_id === $prod['talle_id']) {
                    $cantidadVenta++;
                    $id = $prod['id'];
                    $talleId = $prod['talle_id'];
                }
            }
            if ($stock->cantidad < $cantidadVenta && $stock->producto_id === $id) {
                $message = 'No hay stock';

                foreach ($talles as $talle) {
                    if ($talle->id === $talleId) {
                        $talleAgotado = $talle->nombre;
                    }
                }


                $response = Response::json([
                    'message' => $message,
                    'noStock' => $id,
                    'talle' => $talleAgotado
                ], 201);

                return $response;
            } else {
                $nuevoCantidad = $stock->cantidad - $cantidadVenta;
                $updateStock[] = ['id' => $id, 'stockId' => $stock->id, 'nuevaCantidad' => $nuevoCantidad];
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
            // 'prods' => $request->prods,
            // 'updateStock'=> $updateStock,
            // 'datosEnvio' => $envio,
            // 'datosOrden' => $orden,
        ], 201);

        return $response;
    }

    public function borrarPedido($idUser)
    {
        // boror el envio y el pedido
        $envio = \App\Modelos\Envio::WHERE('user_id', '=', $idUser)->orderBy('created_at', 'desc')->first();
        $orden = \App\Modelos\Ordene::WHERE('user_id', '=', $idUser)->orderBy('created_at', 'desc')->first();
        $carritos = \App\Modelos\Carrito::WHERE('user_id', '=', $idUser)->WHERE('ordene_id', '=', $orden->id)->get();

        foreach ($carritos as $carrito) {
            $carrito->update(['ordene_id' => 0]);
        }

        $orden->delete();
        $envio->delete();

        $message = 'La orden y el envio se eliminaron correctamente';

        $response = Response::json([
            'message'=> $message,
        ], 201);

        return $response;
    }

    public function acomodarStock(Request $request)
    {
        $i = 0;

        $idsTalles = $request->prods;
        
        foreach ($idsTalles as $producto) {
            $i++;
            $stock = \App\Modelos\Stock::WHERE('producto_id', '=', $producto["id"])->WHERE('talle_id', '=', $producto["talle_id"])->first();

            $cantidadAcomodada = $stock->cantidad + 1;

            $stock->update(["cantidad" => $cantidadAcomodada]);
        }

        $message = 'La cantidad volvio a su valor original';

        return $response = Response::json([
            'message'=> $message,
            'data' => $request->prods,
            'cantidad' => $i,
        ], 201);
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

        // usuario mariana
            // MercadoPago\SDK::setPublicKey("APP_USR-e5f44d7a-86b1-429f-8fbd-6c9c231dfae9");
            // MercadoPago\SDK::setAccessToken("APP_USR-4686291555401662-070523-2ca9693199daa9b3788d4cd304f02332-204957269");
        // fin

        if ($request->metodo) {
            // pago en efectivo funciona
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
            // fin pago en efectivo funciona

            //pagon en efectivo con preference
                // token test
                // MercadoPago\SDK::setAccessToken("TEST-8447599831708568-062517-59dec1ad9697d89f066c24c7528a2fb8-447000507");

                // token mariana
                // MercadoPago\SDK::setPublicKey("APP_USR-e5f44d7a-86b1-429f-8fbd-6c9c231dfae9");
                MercadoPago\SDK::setAccessToken("APP_USR-4686291555401662-070523-2ca9693199daa9b3788d4cd304f02332-204957269");


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
                // $preference->items = (object)array(
                //     'title' => "Genoveva Shop Online",
                //     'quantity' => 1,
                //     'currency_id' => "ARS",
                //     'unit_price' => $request->total

                // );

                // ver nuevo item
                    $item = new MercadoPago\Item();
                    $item->title = "Genoveva Shop Online";
                    $item->quantity = 1;
                    $item->currency_id = "ARS";
                    $item->unit_price = $request->total;

                    $preference->items = array($item);
                // fin
                
                // $preference->payer = (object)array(
                //     'email' => $request->email
                // );

                // ver nuevo payer
                    $payer = new MercadoPago\Payer();
                    $payer->email = $request->email;
                    $preference->payer = $payer;
                // fin

                // $preference->shipments = (object)array(
                //     'receiver_address' => (object)array(
                //         "zip_code" => $request->cp,
                //         'state_name' => $request->provincia,
                //         'city_name' => $request->ciudad,
                //         "street_number" => $request->numero,
                //         "street_name" => $request->calle
                //     ),
                //     'mode' => "me2",
                //     'dimensions' => "30x30x20,800",
                // );

                // ver nuevo shipments
                    $shipments = new MercadoPago\Shipments();
                    $shipments->mode = 'me2';
                    $shipments->dimensions = '30x30x30,800';
                    $shipments->receiver_address = array(
                        "zip_code" => $request->cp,
                        'state_name' => $request->provincia,
                        'city_name' => $request->ciudad,
                        "street_number" => $request->numero,
                        "street_name" => $request->calle
                    );
                    $preference->shipments = $shipments;
                // fin

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
                    'preferenceItem' => $preference->items,
                    'preference' => $preference,
                    'preferenceColId' => $preference->collector_id,
                    'preferencePayer' => $preference->payer,
                    'preferenceClId' => $preference->client_id,
                    'preferenceId' => $preference->id,
                    'preferenceId' => $preference->init_point,
                    'preference1' => $preference->sandbox_init_point,
                    'preference2' => $preference->shipments->receiver_address,
                ], 201);
                //fin paga en efectivo con preference

        }

        if ($request->emisorTarjeta) {
            //funciona, asi se reciben pagos con tarjeta tanto para uno como mas cuotas
                // token test
                // MercadoPago\SDK::setAccessToken("TEST-8447599831708568-062517-59dec1ad9697d89f066c24c7528a2fb8-447000507");

                // token mariana
                // MercadoPago\SDK::setPublicKey("APP_USR-e5f44d7a-86b1-429f-8fbd-6c9c231dfae9");
                MercadoPago\SDK::setAccessToken("APP_USR-4686291555401662-070523-2ca9693199daa9b3788d4cd304f02332-204957269");

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

                // Save and posting the payment
                $payment->save();

                $preference = new MercadoPago\Preference();

                // ver nuevo item
                    $item = new MercadoPago\Item();
                    $item->title = "Genoveva Shop Online";
                    $item->quantity = 1;
                    $item->currency_id = "ARS";
                    $item->unit_price = $request->total;

                    $preference->items = array($item);
                // fin

                // ver nuevo payer
                    $payer = new MercadoPago\Payer();
                    $payer->email = $request->email;
                    $preference->payer = $payer;
                // fin

                // ver nuevo shipments
                    $shipments = new MercadoPago\Shipments();
                    $shipments->mode = 'me2';
                    $shipments->dimensions = '30x30x30,800';
                    $shipments->receiver_address = array(
                        "zip_code" => $request->cp,
                        'state_name' => $request->provincia,
                        'city_name' => $request->ciudad,
                        "street_number" => $request->numero,
                        "street_name" => $request->calle
                    );
                    $preference->shipments = $shipments;
                // fin

                $preference->save();
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
                    'preferenceColId' => $preference->collector_id,
                    'preferencePayer' => $preference->payer,
                    'preferenceClId' => $preference->client_id,
                    'preferenceId' => $preference->id,
                    'preferenceId' => $preference->init_point,
                    'preference1' => $preference->notification_url,
                    'preference2' => $preference->shipments,
                    'preferenceItem' => $preference->items,
                ], 201);
            //fin pagos con tarjeta
        }

        return $response;
        
    }

    public function obtenerMediosDePago(){

        // MercadoPago\SDK::setAccessToken("TEST-8447599831708568-062517-59dec1ad9697d89f066c24c7528a2fb8-447000507");
        // token de mariana
        MercadoPago\SDK::setAccessToken("APP_USR-4686291555401662-070523-2ca9693199daa9b3788d4cd304f02332-204957269");


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
        // MercadoPago\SDK::setClientId("8447599831708568");
        // clien id de mariana
        MercadoPago\SDK::setClientId("4686291555401662");

        // MercadoPago\SDK::setClientSecret("LoPu5tRluVz2kJMMhzdmQrSV7SV0kO14");
        // client secret de mariana
        MercadoPago\SDK::setClientSecret("EPbHPDfmCOl6lTnKOmSbMMXKodEJeU7b");

        $params = [ 'url_query' => [ 'dimensions' => $dimensions.','.$peso , 'zip_code' => $zip_code, 'item_price' => $item_price]]; //opcional ] ];
        $resp = Response::json($params, 200);
        return $resp;

        $response = MercadoPago\SDK::get('/shipping_options', $params);

        $resp = Response::json($response, 200);

        return $resp;
    }
}
