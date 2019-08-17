@extends('app')

@section('main')
<div class="">

    @if(Session::has('message'))
    <p class="alert alert-info">{{ Session::get('message') }}</p>
    @endif

    {{-- <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
        </div>
        <input type="text" id="inputBusqueda" onkeyup="buscar()" class="form-control" placeholder="Buscar por # orden.." aria-label="Username"
            aria-describedby="basic-addon1">
    </div> --}}

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
        </div>
        <input type="text" id="inputBusquedaNombre" onkeyup="buscarNombre()" class="form-control" placeholder="Buscar por nombre.." aria-label="Username"
            aria-describedby="basic-addon1">
    </div>

    <table id="miTabla" class="table table-hover table-borderless animated fadeIn fast">
        <thead class="thead-light">
            <tr scope="row">
                <th class="text-center" scope="col"></th>
                <th class="text-center" scope="col"></th>
                <th class="text-center" scope="col"></th>
                <th class="text-center" scope="col"></th>
                <th class="text-center" scope="col" colspan="3">Envio</th>
                <th class="text-center" scope="col"></th>
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
                <th class="text-center" scope="col">Num seguimiento</th>
                {{-- <th scope="col"></th> --}}
            </tr>
        </thead>
        <tbody>

            @foreach ($ordenes as $orden)
            <tr scope="row">
                <td>{{$orden->numOrden}}</td>
                <td>
                    @foreach ($usuarios as $user)
                        @if ($user->id === $orden->user_id)
                            {{-- @dd($user) --}}
                            <div class="sobre">
                                {{$user->name}} {{$user->lastname}}
                                <span class="informacion-abajo btn-info">
                                    <ul class="list-group">
                                        <li style="list-style:none;">
                                            @foreach ($envios as $envio)
                                                @if ($envio->user_id === $orden->user_id)
                                                    DNI: {{ $envio->dni }}
                                                    @php
                                                        break;
                                                    @endphp
                                                @endif
                                            @endforeach
                                        </li>
                                        <li style="list-style:none;">
                                            <a style="color: white;" href="mailto:{{$user->email}}">{{$user->email}}</a>
                                        </li>
                                        <li style="list-style:none;">
                                            @foreach ($envios as $envio)
                                                @if ($envio->user_id === $orden->user_id)
                                                    <a style="color: white;" href="tel:+{{$envio->telefono}}">{{$envio->telefono}}</a>
                                                    @php
                                                        break;
                                                    @endphp
                                                @endif
                                            @endforeach
                                        </li>
                                    </ul>
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
                            {{$envio->calle}} - {{$envio->numero}}
                           
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
                <td>
                    @if ($orden->estadoenvio_id === 2)
                    <form action="/admin/ordenes/{{$orden->id}}" id="numSeguimientoForm{{$orden->id}}" method="post">
                        @csrf
                        @method('PUT')
                        <input type="text" class="form-control" id="numSeguimiento{{$orden->id}}" value="{{$orden->numSeguimiento}}" name="numSeguimiento" placeholder="Num seguimiento">
                        <button type="submit" class="d-none"></button>
                        {{-- <script>
                            document.querySelector('#numSeguimientoForm{{$orden->id}}').addEventListener('keyup', function(event) {
                                event.preventDefault();
                                if (event.keyCode === 13) {
                                    console.log('enter');
                                }
                            });
                        </script> --}}
                    </form>
                    @endif
                </td>
            </tr>    
            @endforeach
        </tbody>
    </table>

    <script>
        // function buscar() {
        //     // Declare variables
        //     var input, filter, table, tr, td, i, txtValue;
        //     input = document.getElementById("inputBusqueda");
        //     filter = input.value.toUpperCase();
        //     table = document.getElementById("miTabla");
        //     tr = table.getElementsByTagName("tr");
            
        //     // Loop through all table rows, and hide those who don't match the search query
        //     for (i = 0; i < tr.length; i++) { 
        //         td = tr[i].getElementsByTagName("td")[0]; 
                
        //         if (td) { 
        //             txtValue = td.textContent || td.innerText; 
        //             if (txtValue.toUpperCase().indexOf(filter) > -1) {
        //                 tr[i].style.display = "";
        //             } else {
        //                 tr[i].style.display = "none";
        //             }
        //         }
        //     }
        // }

        function buscarNombre() {
            // Declare variables
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("inputBusquedaNombre");
            filter = input.value.toUpperCase();
            table = document.getElementById("miTabla");
            tr = table.getElementsByTagName("tr");
            
            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) { 
                td = tr[i].getElementsByTagName("td")[1]; 
                console.log(td);
                
                if (td) { 
                    txtValue = td.textContent || td.innerText; 
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
</div>
@endsection

