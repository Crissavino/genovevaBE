
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

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" id="inputBusqueda" onkeyup="buscar()" class="form-control" placeholder="Buscar por nombre.." aria-label="Username"
                aria-describedby="basic-addon1">
        </div>
    
        <table id="miTabla" class="table table-hover table-borderless animated fadeIn fast">
            <thead class="thead-light">
                <tr>
                    <th class="text-center" scope="col"># ID</th>
                    <th class="text-center" scope="col">Producto</th>
                    <th class="text-center" scope="col">Stock</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                
                @foreach ($productos as $producto)
                <tr>
    
                    <th class="w-25" scope="row">{{ $producto->id }}</th>
    
                    <td class="w-25">{{ $producto->titulo }}</td>
    
                    <td class="w-25">
                        @php
                            $stockAcumulado = 0
                        @endphp
                        @foreach ($stocks as $stock)
                            @if ($stock->producto_id == $producto->id)
                                {{-- @dd($stock->cantidad) --}}
                                @php
                                    $stockAcumulado += $stock->cantidad                                    
                                @endphp
                            @endif
                        @endforeach
                        {{ $stockAcumulado }}
                    </td>
                    <td class="w-25 text-center">
                        <a href="/admin/producto/{{ $producto->id }}" class="mr-2 btn btn-outline-primary">Editar</a>
                        <form action="/admin/producto/borrar/{{ $producto->id }}" class="d-inline-block" method="post" id="form">
                            @method('DELETE') 
                            @csrf
                            <button class="btn btn-outline-danger" type="submit">Eliminar</button>
                            {{-- <a href="/admin/producto/borrar/{{ $producto->id }}" class="btn btn-outline-danger">Eliminar</a> --}}
                        </form>
                    </td>
    
                </tr>
                @endforeach
            </tbody>
        </table>

        <script>
            function buscar() {
                // Declare variables
                var input, filter, table, tr, td, i, txtValue;
                input = document.getElementById("inputBusqueda");
                filter = input.value.toUpperCase();
                table = document.getElementById("miTabla");
                tr = table.getElementsByTagName("tr");
                
                // Loop through all table rows, and hide those who don't match the search query
                for (i = 0; i < tr.length; i++) { 
                    td = tr[i].getElementsByTagName("td")[0]; 
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