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

    public function getUsuario($id)
    {
        $usuario = \App\User::find($id);

        $response = Response::json($usuario, 200);

        return $response;
    }

    public function getUsuarios()
    {
        $usuarios = \App\User::all();

        $response = Response::json($usuarios, 200);

        return $response;
    }

    public function getMantenimiento()
    {
        $mantenimiento = \App\Mantenimiento::first()->estaEnMantenimiento;

        $response = Response::json($mantenimiento, 200);

        return $response;
    }

    public function putMantenimiento(Request $request)
    {
        $estaEnMantenimiento = $request->estaEnMantenimiento;

        $mantenimiento = \App\Mantenimiento::first();

        $mantenimiento->update(['estaEnMantenimiento' => $estaEnMantenimiento]);

        $mensaje = 'Se actualizo';

        $response = Response::json($mensaje, 200);

        return $response;
    }

}
