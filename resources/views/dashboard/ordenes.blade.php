<!-- 
=========================================================
 Light Bootstrap Dashboard - v2.0.1
=========================================================

 Product Page: https://www.creative-tim.com/product/light-bootstrap-dashboard
 Copyright 2019 Creative Tim (https://www.creative-tim.com)
 Licensed under MIT (https://github.com/creativetimofficial/light-bootstrap-dashboard/blob/master/LICENSE)

 Coded by Creative Tim

=========================================================

 The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.  -->
 <!DOCTYPE html>

 <html lang="en">
 
 <head>
    @include('dashboard.partials.head')
 </head>
 
 <body>
    <div class="wrapper">
        @include('dashboard.partials.sidebar')
        <div class="main-panel">
            <!-- Navbar -->
            @include('dashboard.partials.navbar')
            <!-- End Navbar -->

            <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Ordenes de envío</h4><br>
                                    </div>
                                    <div class="card-body">
                                        @if(Session::has('message'))
                                            <p class="alert alert-info">{{ Session::get('message') }}</p>
                                        @endif

                                        <div class="col-md-6 col-12 p-0">
                                            @php
                                                $ordenesEsteMes = 0;
                                                $ordenesMesAnterior = 0;
                                                $ordenesMesAnteriorAnterior = 0;
                                            @endphp

                                            @foreach ($ordenes as $orden)
                                                @if (date("n") == $orden->created_at->format('n'))
                                                    @php
                                                        $ordenesEsteMes++
                                                    @endphp
                                                @endif

                                                @if ((date("n") - 1) == $orden->created_at->format('n'))
                                                    @php
                                                        $ordenesMesAnterior++
                                                    @endphp
                                                @endif

                                                @if ((date("n") - 2) == $orden->created_at->format('n'))
                                                    @php
                                                        $ordenesMesAnteriorAnterior++
                                                    @endphp
                                                @endif
                                            @endforeach

                                            <div class="card">
                                                <div class="card-header ">
                                                    <h4 class="card-title">Estadisticas de ventas</h4>
                                                    <p class="card-category">Ventas ultimos meses</p>
                                                </div>
                                                <div class="card-body">
                                                    <div id="chartPreferences" class="ct-chart ct-perfect-fourth"></div>
                                                    <div class="legend">
                                                        {{-- <i class="fa fa-circle text-success"></i> Ventas de este mes <br> --}}
                                                        {{-- <i class="fa fa-circle text-danger"></i> Ventas del mes {{ date('n') - 1}} <br> --}}
                                                        {{-- <i class="fa fa-circle text-info"></i> Ventas del mes {{ date('n') - 2}} <br> --}}
                                                        <i class="fa fa-circle text-info"></i> Ventas de este mes <br>
                                                        <i class="fa fa-circle text-danger"></i> Ventas del mes {{ date('n') - 1}} <br>
                                                        <i class="fa fa-circle text-warning"></i> Ventas del mes {{ date('n') - 2}} <br>
                                                    </div>
                                                    {{-- <hr>
                                                    <div class="stats">
                                                        <i class="fa fa-clock-o"></i> Campaign sent 2 days ago
                                                    </div> --}}
                                                </div>
                                            </div>
                                        </div>
                                    
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><img src="/img/search.svg" alt="" style="height:22px;"></span>
                                            </div>
                                            <input type="text" id="inputBusquedaNombre" onkeyup="buscarNombre()" class="form-control" placeholder="Buscar por nombre.." aria-label="Username"
                                                aria-describedby="basic-addon1">
                                        </div>
                                    
                                        <div class="row d-flex justify-content-around tarjetas m-3 p-0">
                                            @foreach ($ordenes as $orden)
                                                {{-- <div class="card mb-3 col-12" id="tarjeta" style="height: 300px; overflow:hidden"> --}}
                                                <div class="card float-left col-12 col-md-3 m-2" id="tarjeta" style="min-width: 280px;">
                                                        {{-- <div class="card m-3 float-left" id="tarjeta" style="max-width: 450px;"> --}}
                                                    <div class="row no-gutters">
                                                        <div class="col-md-12">
                                                            <div class="card-body">
                                                                <h5 class="card-title text-left font-weight-bolder"># Orden: {{ $orden->numOrden }}</h5>
                                                            </div>
                                                            <ul class="list-group border-0">
                                                                <li class="list-group-item border-0">
                                                                    @foreach ($usuarios as $user)
                                                                        @if ($user->id === $orden->user_id)
                                                                            {{-- @dd($user) --}}
                                                                            <div class="">
                                                                                <label class="d-block mb-1 mt-1" for="">Nombre de Usuario</label>
                                                                                <h5 class="titulo m-0">{{$user->name}} {{$user->lastname}}</h5>
                                                                                <label class="d-block mb-1 mt-1" for="">Envio a nombre de</label>
                                                                                @foreach ($envios as $envio)
                                                                                    @if ($envio->user_id === $orden->user_id)
                                                                                        <h5 class="m-0">{{$envio->name_lastname}}</h5>
                                                                                        @php
                                                                                            break;
                                                                                        @endphp
                                                                                    @endif
                                                                                @endforeach
                                                                                @foreach ($envios as $envio)
                                                                                    @if ($envio->user_id === $orden->user_id)
                                                                                        <label class="d-block mb-1 mt-1" for="">DNI</label>
                                                                                        <p class="d-block m-0">
                                                                                            {{ $envio->dni }}
                                                                                        </p>
                                                                                        @php
                                                                                            break;
                                                                                        @endphp
                                                                                    @endif
                                                                                @endforeach
                        
                                                                                <label class="d-block mb-1 mt-1" for="">Email</label>
                                                                                <p class="d-block m-0">
                                                                                    <a style="color: black;" href="mailto:{{$user->email}}">{{$user->email}}</a>
                                                                                </p>
                        
                                                                                @foreach ($envios as $envio)
                                                                                    @if ($envio->user_id === $orden->user_id)
                                                                                        <label class="d-block mb-1 mt-1" for="">Telefono</label>
                                                                                        <p class="d-block m-0">
                                                                                            <a style="color: black;" href="tel:+{{$envio->telefono}}">{{$envio->telefono}}</a>
                                                                                        </p>
                                                                                        @php
                                                                                            break;
                                                                                        @endphp
                                                                                    @endif
                                                                                @endforeach
                                                                                {{-- <span class="informacion-abajo btn-info">
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
                                                                                </span> --}}
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                </li>
                                                                <li class="list-group-item border-0">
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
                                                                    <label class="d-block mb-1 mt-1" for="">Productos comprados</label>
                                                                        @foreach ($productosComprados as $prod)
                                                                            <p class="d-block m-0">
                                                                                @php
                                                                                    echo $prod
                                                                                @endphp
                                                                            </p>
                                                                        @endforeach
                                                                    {{-- <div class="sobre btn btn-outline-success btn-block">Productos
                                                                        <span class="informacion-derecha btn-info">
                                                                            <ul class="list-group">
                                                                                @foreach ($productosComprados as $prod)
                                                                                    <li style="list-style:none;">
                                                                                        @php
                                                                                            echo $prod
                                                                                        @endphp
                                                                                    </li>
                                                                                @endforeach
                                                                            </ul>
                                                                                
                                                                        </span>
                                                                    </div> --}}
                                                                </li>
                                                                <li class="list-group-item border-0">
                                                                    <form action="/admin/ordenes/{{$orden->id}}" id="estadoPagoForm{{$orden->id}}" method="post">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <label class="d-block mb-1 mt-1" for="">Estado del Pago</label>
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
                                                                </li>
                        
                                                                <li class="list-group-item border-0">
                                                                    <label class="d-block mb-1 mt-1" class="col-md-12 pl-0" for="">Direccion de envío</label>
                                                                    <div class="d-block">
                                                                        @foreach ($envios as $envio)
                                                                            @if ($envio->ordene_id === $orden->id)
                                                                                {{$envio->calle}} - {{$envio->numero}}
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                    <div class="d-block">
                                                                        @foreach ($envios as $envio)
                                                                            @if ($envio->ordene_id === $orden->id)
                                                                                {{$envio->ciudad}} - {{$envio->provincia}} - {{$envio->pais_id}}
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                    <div class="d-block">
                                                                        @foreach ($envios as $envio)
                                                                            @if ($envio->ordene_id === $orden->id)
                                                                                {{$envio->cp}}
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                    
                                                                    
                                                                    
                                                                </li>
                        
                                                                <li class="list-group-item border-0">
                                                                    <form action="/admin/ordenes/{{$orden->id}}" id="estadoEnvioForm{{$orden->id}}" method="post">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <label class="d-block mb-1 mt-1" for="">Estado Envio</label>
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
                                                                </li>
                        
                                                                <li class="list-group-item border-0">
                                                                    @if ($orden->estadoenvio_id === 2)
                                                                        <form action="/admin/ordenes/{{$orden->id}}" id="numSeguimientoForm{{$orden->id}}" method="post">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <label class="d-block mb-1 mt-1" for="">Num seguimiento</label>
                                                                            <input type="text" class="form-control" id="numSeguimiento{{$orden->id}}" value="{{$orden->numSeguimiento}}" name="numSeguimiento" placeholder="Num seguimiento">
                                                                            <button type="submit" class="d-none"></button>
                                                                        </form>
                                                                    @endif
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    
                                        <script>
                                    
                                            // function buscarNombre() {
                                            //     // Declare variables
                                            //     var input, filter, table, tr, td, i, txtValue;
                                            //     input = document.getElementById("inputBusquedaNombre");
                                            //     filter = input.value.toUpperCase();
                                            //     table = document.getElementById("miTabla");
                                            //     tr = table.getElementsByTagName("tr");
                                                
                                            //     // Loop through all table rows, and hide those who don't match the search query
                                            //     for (i = 0; i < tr.length; i++) { 
                                            //         td = tr[i].getElementsByTagName("td")[1]; 
                                            //         console.log(td);
                                                    
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
                                                tarjetas = document.getElementsByClassName("tarjetas");
                                                tarjeta = tarjetas[0].getElementsByClassName("titulo");
                                                
                                                // Loop through all table rows, and hide those who don't match the search query
                                                for (i = 0; i < tarjeta.length; i++) { 
                                                    let h5 = tarjeta[i];
                                                    let card = tarjeta[i].parentElement.parentElement.parentElement.parentElement.parentElement.parentElement;
                                                    console.log(card);
                                                    
                                                    if (h5) { 
                                                        txtValue = h5.textContent || h5.innerText; 
                                                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                                            card.style.display = "";
                                                        } else {
                                                            card.style.display = "none";
                                                        }
                                                    }
                                                }
                                            }
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>

    @include('partials.scripts')
    @include('dashboard.partials.scripts')
    <script src="/js/swal2.js"></script>
    <script src="/dashboard/assets/js/demo.js"></script>
    <script type="text/javascript">

        function initDashboardPageCharts(){

            let ventasTotalesTresMeses = {{ $ordenesEsteMes }} + {{ $ordenesMesAnterior }} + {{ $ordenesMesAnteriorAnterior }}
            let porceVentasEsteMes = (({{ $ordenesEsteMes }} / ventasTotalesTresMeses) * 100).toFixed(2)
            let porceVentasMesAnterior = (({{ $ordenesMesAnterior }} / ventasTotalesTresMeses) * 100).toFixed(2)
            let porceVentasMesAnteriorAnterior = (({{ $ordenesMesAnteriorAnterior }} / ventasTotalesTresMeses) * 100).toFixed(2)


            var dataPreferences = {
                series: [
                    [25, 30, 20, 25]
                ]
            };

            var optionsPreferences = {
                donut: true,
                donutWidth: 40,
                startAngle: 0,
                total: 100,
                showLabel: false,
                axisX: {
                    showGrid: false
                }
            };

            Chartist.Pie('#chartPreferences', dataPreferences, optionsPreferences);

            Chartist.Pie('#chartPreferences', {
                labels: [porceVentasEsteMes + '% (' + {{$ordenesEsteMes}} + ')', porceVentasMesAnterior + '% (' + {{$ordenesMesAnterior}} + ')', porceVentasMesAnteriorAnterior + '% (' + {{$ordenesMesAnteriorAnterior}} + ')'],
                series: [porceVentasEsteMes, porceVentasMesAnterior, porceVentasMesAnteriorAnterior]
            });
            // if (porceVentasEsteMes == 0) {
            //     Chartist.Pie('#chartPreferences', {
            //         labels: [porceVentasMesAnterior + '% (' + {{$ordenesMesAnterior}} + ')', porceVentasMesAnteriorAnterior + '% (' + {{$ordenesMesAnteriorAnterior}} + ')'],
            //         series: [porceVentasMesAnterior, porceVentasMesAnteriorAnterior]
            //     });
            // }

            // if (porceVentasMesAnterior == 0) {
            //     Chartist.Pie('#chartPreferences', {
            //         labels: [porceVentasEsteMes + '% (' + {{$ordenesEsteMes}} + ')', porceVentasMesAnteriorAnterior + '% (' + {{$ordenesMesAnteriorAnterior}} + ')'],
            //         series: [porceVentasEsteMes, porceVentasMesAnteriorAnterior]
            //     });
            // } 

            // if (porceVentasMesAnteriorAnterior == 0) {
            //     Chartist.Pie('#chartPreferences', {
            //         labels: [porceVentasEsteMes + '% (' + {{$ordenesEsteMes}} + ')', porceVentasMesAnterior + '% (' + {{$ordenesMesAnterior}} + ')'],
            //         series: [porceVentasEsteMes, porceVentasMesAnterior]
            //     });
            // }

            // if (porceVentasEsteMes != 0 && porceVentasMesAnterior != 0 && porceVentasMesAnteriorAnterior != 0) {
            //     Chartist.Pie('#chartPreferences', {
            //         labels: [porceVentasEsteMes + '% (' + {{$ordenesEsteMes}} + ')', porceVentasMesAnterior + '% (' + {{$ordenesMesAnterior}} + ')', porceVentasMesAnteriorAnterior + '% (' + {{$ordenesMesAnteriorAnterior}} + ')'],
            //         series: [porceVentasEsteMes, porceVentasMesAnterior, porceVentasMesAnteriorAnterior]
            //     });
            // }
        }

        $(document).ready(function() {
            // Javascript method's body can be found in assets/js/demos.js
            initDashboardPageCharts();
        });
    </script>
    </body>
 
 </html>
 