@extends('app')

@section('main')
<div class="">

    <div class="row animated fadeIn fast">
        <div class="col-md-12 text-right mb-2">
            <a href="/admin/producto/nuevo" class="btn btn-outline-success mb-3">Agregar producto nuevo</a>
        </div>
    </div>

    @if(Session::has('message'))
    <p class="alert alert-info">{{ Session::get('message') }}</p>
    @endif

    <table class="table table-hover table-borderless animated fadeIn fast">
        <thead class="thead-light">
            <tr scope="row">
                <th class="text-center" scope="col"></th>
                <th class="text-center" scope="col"></th>
                <th class="text-center" scope="col"></th>
                <th class="text-center" scope="col"></th>
                <th class="text-center" scope="col" colspan="3">Envio</th>
                <th class="text-center" scope="col"></th>
            </tr>
            <tr scope="row">
                <th class="text-center" scope="col"># Orden</th>
                <th class="text-center" scope="col">Nombre Usuario</th>
                <th class="text-center" scope="col">Producto</th>
                <th class="text-center" scope="col">Estado del Pago</th>
                <th class="text-center" scope="col">Dirección</th>
                <th class="text-center" scope="col">Ciudad - Provincia - Pais</th>
                <th class="text-center" scope="col">CP</th>
                <th class="text-center" scope="col">Estado Envio</th>
                {{-- <th scope="col"></th> --}}
            </tr>
        </thead>
        <tbody>

            @foreach ($ordenes as $orden)
            <tr scope="row">
                <th>{{$orden->numOrden}}</th>
                <td>
                    @foreach ($usuarios as $user)
                        @if ($user->id === $orden->user_id)
                            <div class="sobre">
                                {{$user->name}} {{$user->lastname}}
                                <span class="informacion-abajo btn-info">
                                    {{$user->email}}
                                </span>
                            </div>
                        @endif
                    @endforeach
                </td>
                <td>
                    @php
                        $productosComprados = [];
                    @endphp
                    @foreach ($carritos as $carrito)
                        @if ($carrito->ordene_id === $orden->id)
                            @foreach ($productos as $producto)
                                @if ($producto->id === $carrito->producto_id)
                                    @php
                                        $productosComprados[] = $producto->titulo;
                                    @endphp
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                    <div class="sobre btn btn-outline-success btn-block">Productos
                        <span class="informacion-derecha btn-info">
                            <ul class="list-group">
                                @foreach ($productosComprados as $prod)
                                    {{-- <li class="list-group-item"> --}}
                                    <li style="list-style:none;">
                                        @php
                                            echo $prod
                                        @endphp
                                    </li>
                                @endforeach
                            </ul>
                                
                        </span>
                    </div>
                </td>
                <td>
                    <form action="/admin/ordenes/{{$orden->id}}" id="estadoPagoForm{{$orden->id}}" method="post">
                        @csrf
                        @method('PUT')
                        <select class="form-control btn-outline-dark" name="estadoPago" id="estadoPago{{$orden->id}}">
                            <option value="">Estado</option>
                            @foreach ($estadoPagos as $estado)
                                @php
                                    $selected = ($estado->id == $orden->estadopago_id) ? 'selected' : '';
                                @endphp
                                <option value="{{$estado->id}}" {{ $selected }}>{{$estado->nombre}}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="d-none"></button>
                        <script>
                            document.querySelector('#estadoPago{{$orden->id}}').addEventListener('change', () => {
                                document.querySelector('#estadoPagoForm{{$orden->id}}').submit();

                            });
                        </script>
                    </form>
                </td>
                <td>
                    @foreach ($envios as $envio)
                        @if ($envio->ordene_id === $orden->id)
                            {{$envio->direccion1}}
                        @endif
                    @endforeach
                </td>
                <td>
                    @foreach ($envios as $envio)
                        @if ($envio->ordene_id === $orden->id)
                            {{$envio->ciudad}} - {{$envio->provincia}} - {{$envio->pais_id}}
                        @endif
                    @endforeach
                </td>
                <td>
                    @foreach ($envios as $envio)
                        @if ($envio->ordene_id === $orden->id)
                            {{$envio->cp}}
                        @endif
                    @endforeach
                </td>
                <td>
                    <form action="/admin/ordenes/{{$orden->id}}" id="estadoEnvioForm{{$orden->id}}" method="post">
                        @csrf
                        @method('PUT')
                        <select class="form-control btn-outline-dark" name="estadoEnvio" id="estadoEnvio{{$orden->id}}">
                            <option value="">Estado</option>
                            @foreach ($estadoEnvios as $estado)
                                @php
                                    $selected = ($estado->id == $orden->estadoenvio_id) ? 'selected' : '';
                                @endphp
                                <option value="{{$estado->id}}" {{ $selected }}>{{$estado->nombre}}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="d-none"></button>
                        <script>
                            document.querySelector('#estadoEnvio{{$orden->id}}').addEventListener('change', () => {
                                document.querySelector('#estadoEnvioForm{{$orden->id}}').submit();
                            });
                        </script>
                    </form>
                </td>
            </tr>    
            @endforeach
        </tbody>
    </table>
</div>
@endsection

