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
                        @if(count($errors) !== 0)
                            <div class="alert alert-danger" role="alert">
                                
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>
                                        {{ $error }}
                                    </li>
                                    @endforeach
                                </ul>
                                
                            </div>
                        @endif
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Nuevo Producto</h4>
                                </div>
                                <div class="card-body">
                                    <form class="form" name="form" id="formEdit" onsubmit="validateForm()" enctype='multipart/form-data' action="" method="post">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="">Titulo</label>
                                            <input type="text" name="titulo" class="form-control" placeholder="Título del producto"
                                                value="{{ $producto->titulo }}">
                                        </div>
                                    
                                        <div class="form-group">
                                            <label for="">Categoria Principal</label>
                                            <select name="categoria_id" class="form-control">
                                                <option value="0">Seleccioná la categoria principal</option>
                                                @foreach ($categoriasPrincipales as $categoria)
                                                    @php
                                                        $selected = ($categoria->id == $producto->categoria_id) ? 'selected' : '';
                                                    @endphp
                                                    <option value="{{ $categoria->id }}" {{ $selected }}>
                                                        {{ $categoria->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                    
                                        <div class="form-group esNuevo">
                                            <label class="d-block" for="">Es un producto nuevo?</label>
                                            <small class="d-block">Aparecerá una etiqueta arriba del producto que dice NEW</small>
                                            <div class="d-inline-block mr-3">
                                                <label for="">Sí</label>
                                                @if ($producto->nuevo == 1)
                                                    <input type="checkbox" name="nuevo" id="nuevoSi" checked value="1">                                
                                                @else
                                                    <input type="checkbox" name="nuevo" id="nuevoSi" value="1">
                                                @endif
                                            </div>
                                            <div class="d-inline-block">
                                                <label for="">No</label>
                                                @if ($producto->nuevo == 0)
                                                    <input type="checkbox" name="nuevo" id="nuevoNo" checked value="0">                                
                                                @else
                                                    <input type="checkbox" name="nuevo" id="nuevoNo" value="0">
                                                @endif
                                            </div>
                                        </div>
                    
                                        <div class="form-group esPopular">
                                            <label class="d-block" for="">Queres destacar el producto?</label>
                                            <small class="d-block">Aparecerá en el home como Producto Popular</small>
                                            <div class="d-inline-block mr-3">
                                                <label for="">Sí</label>
                                                @if ($producto->popular == 1)
                                                    <input type="checkbox" name="popular" id="popularSi" checked value="1">
                                                @else
                                                    <input type="checkbox" name="popular" id="popularSi" value="1">
                                                @endif
                                            </div>
                                            <div class="d-inline-block">
                                                <label for="">No</label>
                                                @if ($producto->popular == 0)
                                                    <input type="checkbox" name="popular" id="popularNo" checked value="0">
                                                @else
                                                    <input type="checkbox" name="popular" id="popularNo" value="0">
                                                @endif
                                            </div>
                                        </div>
                                    
                                        <div class="catSecundarias">
                                            <div class="mb-3">
                                                <label class="d-block" for="">Categoria secundaria</label>
                                                <small>Podes seleccionar hasta 3</small>
                                            </div>
                                            <div class="row form-group">
                                                @foreach ($categoriasSecundarias as $categoria)
                                                    @php
                                                        $categoriaIds = $producto->categoriassecundarias->pluck('id')->toArray();
                                                        $checked = (in_array($categoria->id, $categoriaIds)) ? 'checked' : ''
                                                    @endphp
                                                <div class="col-6 col-sm-3 pl-sm-3">
                                                    <label class="mr-1" for="{{ $categoria->id }}">{{ $categoria->nombre }}</label>
                                                    <input {{ $checked }} type="checkbox" name="categoriasSecundarias[]" value="{{ $categoria->id }}"
                                                        id="{{ $categoria->id }}">
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    
                                        <div class="imagenShopDiv">
                                            <div class="mb-3">
                                                <label class="d-block for="">Imagenes que se verán en el shop</label>
                                                <small>Tenes que seleccionar dos</small>
                                            </div>
                                            <div class=" form-group custom-file mb-4">
                                                <label for="" class="custom-file-label imagenShop">Click para agregar</label>
                                                <input class="custom-file-input imagenShop-input" type="file" lang="es" name="imagenShop[]" multiple>
                                            </div>
                                            <label class="mt-3" for="">Imágenes cargadas actualmente</label><br>
                                            <div class="mb-4 imagenesShopAnterioresDiv">
                                                @foreach ($imagenesshops as $imagen)
                                                    @foreach ($producto->imagenesshops as $imagenProd)
                                                        @if ($imagenProd->id == $imagen->id)
                                                            {{-- <div style="display:inline-block; margin: 10px; width: 100px; height: 100px;"> --}}
                                                            <div class="d-inline-block col-sm-4 mt-4">
                                                                <img class="m-auto imagenesShopAnteriores" style="display:block;" src="{{asset($imagen->path)}}" id="imagenShop-preview" width="200px;">
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            </div>
                                        </div>
                                    
                                        <div class="imagenDetalleDiv">
                                            <div class="mb-3 mt-4">
                                                <label class="d-block for="">Imagenes que se verán en la descripcion del producto</label>
                                                <small>Podes seleccionar hasta 5</small>
                                            </div>
                                            <div class="form-group custom-file mb-4">
                                                <label for="" class="custom-file-label imagenDetalle">Click para agregar</label>
                                                <input class="custom-file-input imagenDetalle-input" type="file" lang="es" name="imagenDetalle[]" multiple>
                                            </div>
                                            <label class="mt-3" for="">Imágenes cargadas actualmente</label><br>
                                            <div class="mb-4 imagenesDetalleAnterioresDiv">
                                                @foreach ($imagenesdetalles as $imagen)
                                                    @foreach ($producto->imagenesdetalles as $imagenProd)
                                                        @if ($imagenProd->id == $imagen->id)
                                                            <div class="d-inline-block col-sm-4 mt-4">
                                                                <img class="m-auto imagenesDetalleAnteriores" style="display:block; width:200px;" src="{{asset($imagen->path)}}" id="imagenDetalle-preview">
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            </div>
                                        </div>
                                    
                                        <div class="form-group mt-4 mb-5">
                                            <label for="">Detalle</label>
                                            <input type="text" name="detalle" class="form-control" placeholder="Detalle" value="{{ $producto->detalle }}">
                                        </div>
                    
                                        <label for="">Stock por talles</label><br>
                                        <div class="">
                                            @if (!empty($producto->stocks))
                                                @foreach ($talles as $talle)
                                                        @foreach ($producto->stocks as $item)
                                                                @if ($item->talle_id == $talle->id)
                                                                    <div class="alert alert-info">
                                                                        {{'Quedan '. $item->cantidad .' '. $talle->nombre }}
                                                                    </div>
                                                                @endif
                                                        @endforeach
                                                @endforeach
                                            @else
                                                <div class="alert alert-danger">
                                                    {{'No queda ningun producto en stock!!!'}}
                                                </div>
                                            @endif
                                        </div>
                    
                                        <div class="alert alert-success">
                                            <label for="">Hace click si queres modificar el Stock</label>
                                            <input type="checkbox" class="modificarStock" name="modificarStock" value="si">
                                        </div>
                                        {{-- ojo que uso la posicion de d-none para validad por javascritp --}}
                                        <div class="d-none form-group p-0 tablaStock talles" style="width: 100%;">
                                            <label class="d-block mb-3" for="">Tabla de stock y talles</label>
                                    
                                            <table class="table text-center table-borderless table-hover border">
                                                <thead class=" thead-light">
                                                    <tr>
                                                        <th style="width: 5%" scope="col"></th>
                                                        <th style="width: 5%" scope="col">Talle</th>
                                                        <th style="width: 90%" scope="col">Cantidad</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($talles as $talle)
                                                        <tr height="70px">
                                                            <th scope="row">
                                                                <input type="checkbox" name="talles[]" class="talleId{{$talle->id}}" value="{{$talle->id}}" id="{{$talle->id}}"
                                                                    onclick="agregarTalle('{{$talle->id}}')">
                                                            </th>
                                                            <td>
                                                                <label for="{{$talle->id}}">{{$talle->nombre}}</label>
                                                            </td>
                                                            <td>
                                                                <input type="number" name="cantidadId{{$talle->id}}" class="form-control d-none {{$talle->nombre}}"
                                                                    placeholder="Cantidad {{$talle->nombre}}">
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                    
                                        <div class="colors">
                                            <div class="mb-3">
                                                <label class="d-block" for="">Colores</label>
                                                <small>Podes seleccionar hasta 4 colores</small>
                                            </div>
                                            <div class="row form-group">
                                                @foreach ($colores as $color)
                                                        @php
                                                            $coloresIds = $producto->colores->pluck('id')->toArray();
                                                            $checked = (in_array($color->id, $coloresIds)) ? 'checked' : ''
                                                        @endphp
                                                    <div class="col-4 col-sm-3 pl-sm-3">
                                                        <label for="{{ $color->nombre }}" class="m-auto"
                                                            style="border: black solid 1px; width: 16px; height: 16px; background-color: {{$color->nombre}};"></label>
                                                        <input {{ $checked }} type="checkbox" style="margin-bottom: -10px;" name="colores[]" value="{{ $color->id }}"
                                                            id="{{ $color->nombre }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    
                                        <div class="form-group">
                                            <label for="">Descripción</label>
                                            <textarea name="descripcion" cols="30" rows="10" class="form-control">{{ $producto->descripcion }}</textarea>
                                        </div>
                                    
                                        <div class="form-group">
                                            <label for="">Precio</label>
                                            <input type="number" name="precio" class="form-control" placeholder="Precio" value="{{ $producto->precio }}">
                                        </div>
                                    
                                        <div class="form-group">
                                            <label for="">Descuento</label><small> - en porcentaje</small>
                                            <input type="number" name="descuento" class="form-control" placeholder="Descuento en porcentaje"
                                                value="{{ $producto->descuento }}">
                                        </div>
                                    
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-outline-primary btnEnviarForm">Actualizar producto</button>
                                        </div>
                                    
                                    </form>
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
 