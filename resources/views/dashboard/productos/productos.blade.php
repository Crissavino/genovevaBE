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
                                    <h4 class="card-title">Productos en la tienda</h4><br>
                                    <button class="btn btn-outline"><a style="text-decoration:none; color:gray;" href="/admin/producto/nuevo">Agregar producto</a></button>
                                </div>
                                <div class="card-body">
                                    @if(Session::has('message'))
                                        <p class="alert alert-info">{{ Session::get('message') }}</p>
                                    @endif
                            
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><img src="/img/search.svg" alt="" style="height:22px;"></span>
                                        </div>
                                        <input type="text" id="inputBusqueda" onkeyup="buscar()" class="form-control" placeholder="Buscar por nombre.." aria-label="Username"
                                            aria-describedby="basic-addon1">
                                    </div>

                                    {{-- <div class="categorias">
                                        @php
                                            $categoriasPresentes = [];
                                        @endphp
                                        @foreach ($productos as $prod)
                                            @foreach ($categoriasPrincipales as $categoria)
                                                @if ($prod->categoria_id === $categoria->id)
                                                    @if (!in_array($categoria->nombre, $categoriasPresentes))
                                                        @php
                                                            $categoriasPresentes[] = [ 'id' => $categoria->id, 'nombre' => $categoria->nombre]
                                                        @endphp
                                                    @endif
                                                @endif
                                            @endforeach
                                        @endforeach

                                        @foreach ($categoriasPresentes as $categoria)
                                            <button class="btn btn-outline-dark catId{{$categoria['id']}}" onclick="filtrarCategoria({{$categoria['id']}})">{{$categoria['nombre']}}</button>
                                        @endforeach
                                    </div> --}}

                                    <div class="row d-flex justify-content-around tarjetas">
                                        @foreach ($productos as $producto)
                                            <div class="card float-left col-12 col-md-6 m-2 tarjeta" id="prodId{{ $producto->id }}" style="max-width: 350px;">
                                                <div class="row no-gutters">
                                                    {{-- <div class="col-md-4 d-inline-block m-auto pl-1" style="overflow:hidden;">
                                                        <img src="{{$producto->imagenesshops[0]['path']}}" class="card-img align-middle" alt="...">
                                                    </div> --}}
                                                    <div class="col-md-12">
                                                        <div class="card-body">
                                                            <h5 class="card-title text-center titulo font-weight-bolder">{{ $producto->titulo }}</h5>
                                                        </div>
                                                        <ul class="list-group border-0">
                                                            <li class="list-group-item border-0">
                                                                <p class="descripcionP card-text">{{ $producto->descripcion }}</p>
                                                            </li>
                                                            <li class="list-group-item border-0">
                                                                @php
                                                                    $stockAcumulado = 0
                                                                @endphp
                                                                @foreach ($stocks as $stock)
                                                                    @if ($stock->producto_id == $producto->id)
                                                                        @php
                                                                            $stockAcumulado += $stock->cantidad                                    
                                                                        @endphp
                                                                    @endif
                                                                @endforeach
                                                                <label for="">Stock</label>
                                                                @if ($stockAcumulado === 0)
                                                                    <p style="color: red; font-weight:bolder">{{ $stockAcumulado }}</p>
                                                                    @else
                                                                        @if ($stockAcumulado === 1)
                                                                            <p style="color: cyan; font-weight:bolder">{{ $stockAcumulado }}</p>
                                                                        @else
                                                                            <p>{{ $stockAcumulado }}</p>
                                                                        @endif
                                                                @endif
                                                            </li>
                                                            <li class="list-group-item border-0">
                                                                Visible: 
                                                                @if ($producto->visible === 1)
                                                                    <form action="/dashboard/productos/visible/{{$producto->id}}" class="d-inline-block w-50" method="post">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <select class="form-control" onchange="submit()" name="visible" id="">
                                                                            <option selected value="1">Si</option>
                                                                            <option value="2">No</option>
                                                                        </select>
                                                                    </form>
                                                                @else
                                                                    <form action="/dashboard/productos/visible/{{$producto->id}}" class="d-inline-block w-50" method="post">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <select class="form-control" onchange="submit()" name="visible" id="">
                                                                            <option value="1">Si</option>
                                                                            <option selected value="2">No</option>
                                                                        </select>
                                                                    </form>
                                                                @endif
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-around ">
                                                            <a href="/admin/producto/{{ $producto->id }}" class="btn btn-primary mr-2 ">Editar</a>
                                                            <a style="cursor:pointer;" onclick="eliminarProducto({{ $producto->id }})" class="btn btn-danger ">Eliminar</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                            
                                    <script>
                                        function filtrarCategoria(catId){
                                            console.log(catId);
                                            
                                        }

                                        function buscar() {
                                            // Declare variables
                                            var input, filter, table, tr, td, i, txtValue;
                                            input = document.getElementById("inputBusqueda");
                                            filter = input.value.toUpperCase();
                                            tarjetas = document.getElementsByClassName("tarjetas");
                                            tarjeta = tarjetas[0].getElementsByClassName("titulo");
                                            
                                            // Loop through all table rows, and hide those who don't match the search query
                                            for (i = 0; i < tarjeta.length; i++) { 
                                                let h5 = tarjeta[i];
                                                let card = tarjeta[i].parentElement.parentElement.parentElement.parentElement;
                                                
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
    <script src="/dashboard/js/productos.js"></script>
    </body>
 
 </html>
 