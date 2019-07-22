@extends('app')

@section('title', 'Tablero Administrador')

@section('main')
<div class="container" style="margin-top: 50px;">

    <div *ngIf="!cargando" class="container mt-100">
        <h3 *ngIf="!producto">Nuevo Producto</h3>
        <a class="btn btn-outline-danger" href="/admin">Regresar</a>

        <hr>
        <div class="row animated fadeIn fast">
            <div class="col-12">
                
                <form class="form" name="form" onsubmit="validateForm()" enctype='multipart/form-data' action="" method="post">
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
                            <div class="colo-3 col-sm-3">
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
                            
                            <label class="mt-3" for="">Imágenes cargadas actualmente</label><br>
                            <div class="mb-4">
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
                    </div>
                
                    <div class="imagenDetalleDiv">
                        <div class="mb-3 mt-4">
                            <label class="d-block for="">Imagenes que se verán en la descripcion del producto</label>
                            <small>Podes seleccionar hasta 5</small>
                        </div>
                        <div class="form-group custom-file mb-4">
                            <label for="" class="custom-file-label imagenDetalle">Click para agregar</label>
                            <input class="custom-file-input imagenDetalle-input" type="file" lang="es" name="imagenDetalle[]" multiple>

                            <label class="mt-3" for="">Imágenes cargadas actualmente</label><br>
                            <div class="mb-4">
                                @foreach ($imagenesdetalles as $imagen)
                                    @foreach ($producto->imagenesdetalles as $imagenProd)
                                        @if ($imagenProd->id == $imagen->id)
                                            <div class="d-inline-block mt-4 col-sm-3">
                                                <img class="d-block imagenesDetalleAnteriores" style="display:block;" src="{{asset($imagen->path)}}" id="imagenDetalle-preview" width="200px;">
                                            </div>
                                        @endif
                                    @endforeach
                                @endforeach
                            </div>
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
                                <div class="col-sm-1">
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

<script>

    // funcionalidad alerta si modificas imagenesShop
        let banderaShop = false;
        var imagenShopInput = document.querySelector('.imagenShop-input');

        imagenShopInput.addEventListener('click', function (event) {
            if (banderaShop) {
                banderaShop = false;
                return;
            }
            event.preventDefault();

            swal("Tené en cuenta que vas a tener que agregar todas las imagenes, no podes reemplazar una sola!\n\n Queres continuar?", {
                buttons: 
                    {
                        cancel: 'No',
                        si: true,
                    }
            })
            .then((value) => {
                switch (value) {
                    case "si":
                        banderaShop = true;
                        imagenShopInput.click();
                        break;

                    case "cancel":
                        break;

                }
            });
        });
    // fin

    // funcionalidad alerta si modificas imagenesInput
        let banderaInput = false;
        var imagenDetalleInput = document.querySelector('.imagenDetalle-input');

        imagenDetalleInput.addEventListener('click', function(event){
            if (banderaInput) {
                banderaInput = false;
                return;
            }
            event.preventDefault();

            swal("Tené en cuenta que vas a tener que agregar todas las imagenes, no podes reemplazar una sola!\n\n Queres continuar?", {
                buttons: 
                    {
                        cancel: 'No',
                        si: true,
                    }
            })
            .then((value) => {
                switch (value) {
                    case "si":
                        banderaInput = true;
                        imagenDetalleInput.click();
                        break;

                    case "cancel":
                        break;

                }
            });
        });
    // fin

</script>
@endsection