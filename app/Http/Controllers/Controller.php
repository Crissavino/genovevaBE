<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
//agregados por mi
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function show()
    {
        $ejemplos = \App\Ejemplo::all();
        $response = Response::json($ejemplos, 200);
        return $response;
    }

    public function store(Request $request)
    {
        //validacion
        if ((!$request->title) || (!$request->description)) {
            $response = Response::json([
                'message' => 'Por favor escriba todos los campos requeridos',
            ], 422);
            return $response;
        }

        $ejemplo = new \App\Ejemplo(array(
            'title' => trim($request->title),
            'description' => trim($request->description),
            'user_id' => 1,
        ));

        $ejemplo->save();

        $message = 'Su imagen ha sido guardada correctamente';

        $response = Response::json([
            'message' => $message,
            'data' => $ejemplo,
        ], 201);

        return $response;



    }
}
