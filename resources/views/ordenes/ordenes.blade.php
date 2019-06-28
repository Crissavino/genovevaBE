@extends('app')

@section('main')
<div class="container">

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
            <tr>
                <th class="text-center" scope="col"># Orden</th>
                <th class="text-center" scope="col">Nombre Usuario</th>
                <th class="text-center" scope="col">Producto</th>
                <th class="text-center" scope="col">Estado del Pago</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>

            @foreach ($ordenes as $orden)
            <tr>
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
                    <select class="form-control" name="estadoPago" id="">
                        <option value="">Estado</option>
                        @foreach ($estadoPagos as $estado)
                            @php
                                $selected = ($estado->id == $orden->estadopago_id) ? 'selected' : '';
                            @endphp
                            <option value="{{$estado->id}}"  {{ $selected }}>{{$estado->nombre}}</option>                            
                        @endforeach
                    </select>
                </td>
                <td></td>
                <td></td>
            </tr>    
            @endforeach
        </tbody>
    </table>
</div>
{{-- <script async>
    $('.popover-dismiss').popover({
        trigger: 'focus'
    })
</script> --}}
@endsection

