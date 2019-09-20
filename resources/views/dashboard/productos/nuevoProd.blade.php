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
                                    <form class="form" name="form" onsubmit="validateForm()" enctype='multipart/form-data' action="" method="post">
                                        @csrf 
                                        @method('POST')
                                        <div class="form-group">
                                            <label for="">Titulo</label> <span style="color:red">*</span>
                                            <input type="text" name="titulo" class="form-control" placeholder="Título del producto" value="{{old('titulo')}}">
                                        </div>
                    
                                        <div class="form-group">
                                            <label for="">Categoria Principal</label> <span style="color:red">*</span>
                                            <select name="categoria_id" class="form-control">
                                                <option value="0">Seleccioná la categoria principal</option>
                                                @foreach ($categoriasPrincipales as $categoria)
                                                <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>{{ $categoria->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                
                                        <div class="form-group esNuevo">
                                            <label class="d-block" for="">Es un producto nuevo? <span style="color:red">*</span></label>
                                            <small class="d-block">Aparecerá una etiqueta arriba del producto que dice NEW</small>
                                            <div class="d-inline-block mr-3">
                                                <label for="">Sí</label>
                                                <input type="checkbox" name="nuevo" id="nuevoSi" value="1">
                                            </div>
                                            <div class="d-inline-block">
                                                <label for="">No</label>
                                                <input type="checkbox" name="nuevo" id="nuevoNo" value="0">
                                            </div>
                                        </div>
                
                                        <div class="form-group esPopular">
                                            <label class="d-block" for="">Queres destacar el producto? <span style="color:red">*</span></label>
                                            <small class="d-block">Aparecerá en el home como Producto Popular</small>
                                            <div class="d-inline-block mr-3">
                                                <label for="">Sí</label>
                                                <input type="checkbox" name="popular" id="popularSi" value="1">
                                            </div>
                                            <div class="d-inline-block">
                                                <label for="">No</label>
                                                <input type="checkbox" name="popular" id="popularNo" value="0">
                                            </div>
                                        </div>
                                        
                                        <div class="catSecundarias">
                                            <div class="mb-3">
                                                <label class="d-block" for="">Categoria secundaria <span style="color:red">*</span></label>
                                                <small>Podes seleccionar hasta 3</small>
                                            </div>
                                            <div class="row form-group">
                                                @foreach ($categoriasSecundarias as $categoria)
                                                    <div class="col-6 col-sm-3 pl-sm-3">
                                                        <label class="mr-1" for="{{ $categoria->id }}">{{ $categoria->nombre }}</label>
                                                        <input type="checkbox" name="categoriasSecundarias[]" value="{{ $categoria->id }}" id="{{ $categoria->id }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                
                                        <div class="imagenShopDiv">
                                            <div class="mb-3">
                                                <label class="d-block for="">Imagenes que se verán en el shop <span style="color:red">*</span></label>
                                                <small>Tenes que seleccionar 2</small>
                                            </div>
                                            <div class="form-group custom-file mb-4">
                                                <label for="" class="custom-file-label imagenShop d-block">Click para agregar</label>
                                                <input class="custom-file-input imagenShop-input" type="file" lang="es" name="imagenShop[]" multiple>
                                            </div>
                                        </div>
                                        <div class="imagenShopAgregadas d-none">
                                            <label class="mt-3" for="">Imágenes cargadas actualmente</label><br>
                                            <div class="mb-4 imagenesShopAgregadasDiv"></div>
                                        </div>
                                        
                                        <div class="imagenDetalleDiv">
                                            <div class="mb-3">
                                                <label class="d-block for="">Imagenes que se verán en la descripcion del producto <span style="color:red">*</span></label>
                                                <small>Podes seleccionar hasta 5</small>
                                            </div>
                                            <div class="form-group custom-file mb-4">
                                                <label for="" class="custom-file-label imagenDetalle">Click para agregar</label>
                                                <input class="custom-file-input imagenDetalle-input" type="file" lang="es" name="imagenDetalle[]" multiple>
                                            </div>
                                        </div>
                                        <div class="imagenDetalleAgregadas d-none">
                                            <label class="mt-3" for="">Imágenes cargadas actualmente</label><br>
                                            <div class="mb-4 imagenesDetalleAgregadasDiv"></div>
                                        </div>
                    
                                        <div class="form-group mb-5">
                                            <label for="">Detalle</label> <span style="color:red">*</span>
                                            <input type="text" name="detalle" class="form-control" placeholder="Detalle" value="{{old('detalle')}}">
                                        </div>
                
                                        <div class="form-group p-0 talles" style="width: 100%;">
                                            <label class="d-block mb-3" for="">Tabla de stock y talles <span style="color:red">*</span></label>
                
                                            <table class="table text-center table-borderless table-hover border"">
                                                <thead class="thead-light">
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
                                                <label class="d-block" for="">Colores <span style="color:red">*</span></label>
                                                <small>Podes seleccionar hasta 4 colores</small>
                                            </div>
                                            <div class="row form-group">
                                                @foreach ($colores as $color)
                                                    <div class="col-4 col-sm-3 pl-sm-3">
                                                        <label for="{{ $color->nombre }}" class="m-auto"
                                                            style="border: black solid 1px; width: 16px; height: 16px; background-color: {{$color->nombre}};"></label>
                                                        <input type="checkbox" style="margin-bottom: -10px;" name="colores[]" value="{{ $color->id }}"
                                                            id="{{ $color->nombre }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                
                                        <div class="form-group">
                                            <label for="">Descripción</label> <span style="color:red">*</span>
                                            <textarea name="descripcion" cols="30" rows="10" class="form-control" ></textarea>
                                        </div>
                    
                                        <div class="form-group">
                                            <label for="">Precio</label> <span style="color:red">*</span>
                                            <input type="number" name="precio" class="form-control" placeholder="Precio" value="{{old('precio')}}">
                                        </div>
                    
                                        <div class="form-group">
                                            <label for="">Descuento</label><small> - en porcentaje</small>
                                            <input type="number" name="descuento" class="form-control" placeholder="Descuento en porcentaje" value="{{old('descuento')}}">
                                        </div>
                    
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-outline-primary btnEnviarForm btn-block">Guardar
                                                cambios</button>
                                        </div>
                    
                                    </form>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-md-4">
                            
                        </div> --}}
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
 