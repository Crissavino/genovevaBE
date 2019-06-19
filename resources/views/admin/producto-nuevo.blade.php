@extends('app')

@section('main')
    <div class="container">
    
        <div class="container">
            <h3 *ngIf="!producto">Nuevo Producto</h3>
            <a class="btn btn-outline-danger" href="/admin">Regresar</a>
    
            <hr>
            {{--
                <div *ngIf="actualizando" class="alert alert-info text-center" role="alert">
                    <strong>Actualizando...</strong> por favor espere
                </div> --}}

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
                {{-- con js le agrego una clase que tenga el borde rojo a los campos con error --}}
            @endif
    
            <div class="row animated fadeIn fast">
                <div class="col-12">
    
                    <form class="form" name="form" onsubmit="validateForm()" enctype='multipart/form-data' action="" method="post">
                        @csrf 
                        @method('POST')
                        <div class="form-group">
                            <label for="">Titulo</label>
                            <input type="text" name="titulo" class="form-control" placeholder="Título del producto" value="{{old('titulo')}}">
                        </div>
    
                        <div class="form-group">
                            <label for="">Categoria Principal</label>
                            <select name="categoria_id" class="form-control">
                                <option value="0">Seleccioná la categoria principal</option>
                                @foreach ($categoriasPrincipales as $categoria)
                                <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>{{ $categoria->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="d-block" for="">Es un producto nuevo?</label>
                            <small class="d-block">Aparecerá una etiqueta arriba del producto que dice NEW</small>
                            <div class="d-inline-block mr-3">
                                <label for="">Sí</label>
                                <input type="checkbox" name="nuevo" id="" value="1">
                            </div>
                            <div class="d-inline-block">
                                <label for="">No</label>
                                <input type="checkbox" name="nuevo" id="" value="0">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="d-block" for="">Queres destacar el producto?</label>
                            <small class="d-block">Aparecerá en el home como Producto Popular</small>
                            <div class="d-inline-block mr-3">
                                <label for="">Sí</label>
                                <input type="checkbox" name="popular" id="" value="1">
                            </div>
                            <div class="d-inline-block">
                                <label for="">No</label>
                                <input type="checkbox" name="popular" id="" value="0">
                            </div>
                        </div>
    
                        <div class="mb-3">
                            <label class="d-block" for="">Categoria secundaria</label>
                            <small>Podes seleccionar hasta 3</small>
                        </div>
                        <div class="row form-group">
                            @foreach ($categoriasSecundarias as $categoria)
                            <div class="colo-3 col-sm-3">
                                <label class="mr-1" for="{{ $categoria->id }}">{{ $categoria->nombre }}</label>
                                <input type="checkbox" name="categoriasSecundarias[]" value="{{ $categoria->id }}" id="{{ $categoria->id }}">
                            </div>
                            @endforeach
                        </div>

                        <div class="mb-3">
                            <label class="d-block for="">Imagenes que se verán en el shop</label>
                            <small>Tenes que seleccionar dos</small>
                        </div>
                        <div class="form-group custom-file mb-4">
                            <label for="" class="custom-file-label imagenShop">Click para agregar</label>
                            <input class="custom-file-input imagenShop-input" type="file" lang="es" name="imagenShop[]"
                                multiple>
                                {{-- <div style="display:inline-block; margin: 10px; width: 100px; height: 200px;">
                                    <img style="display:block;" src="" id="imagenShop-preview" width="100px;">
                                </div> --}}
                                {{-- <div class="invalid-feedback"></div> --}}
                        </div>
                        
                        <div class="mb-3">
                            <label class="d-block for="">Imagenes que se verán en la descripcion del producto</label>
                            <small>Podes seleccionar hasta 5</small>
                        </div>
                        <div class="form-group custom-file mb-4">
                            <label for="" class="custom-file-label imagenDetalle">Click para agregar</label>
                            <input class="custom-file-input imagenDetalle-input" type="file" lang="es"
                                name="imagenDetalle[]" multiple>
                            {{-- <div style="display:inline-block; margin: 10px; width: 100px; height: 200px;">
                                    <img style="display:block;" src="" id="imagenShop-preview" width="100px;">
                                </div> --}}
                            {{-- <div class="invalid-feedback"></div> --}}
                        </div>
    
                        <div class="form-group mb-5">
                            <label for="">Detalle</label>
                            <input type="text" name="detalle" class="form-control" placeholder="Detalle" value="{{old('detalle')}}">
                        </div>

                        <div class="form-group p-0" style="width: 100%;">
                            <label class="d-block mb-3" for="">Tabla de stock y talles</label>

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
                        <div class="mb-3">
                            <label class="d-block" for="">Colores</label>
                            <small>Podes seleccionar hasta 4 colores</small>
                        </div>
                        <div class="row form-group">
                            @foreach ($colores as $color)
                                <div class="col-sm-1">
                                    <label for="{{ $color->nombre }}" class="m-auto" style="border: black solid 1px; width: 16px; height: 16px; background-color: {{$color->nombre}};"></label>
                                    <input type="checkbox" style="margin-bottom: -10px;" name="colores[]" value="{{ $color->id }}" id="{{ $color->nombre }}">
                                </div>
                            @endforeach
                        </div>

                        <div class="form-group">
                            <label for="">Descripción</label>
                            <textarea name="descripcion" cols="30" rows="10" class="form-control" ></textarea>
                        </div>
    
                        <div class="form-group">
                            <label for="">Precio</label>
                            <input type="number" name="precio" class="form-control" placeholder="Precio" value="{{old('precio')}}">
                        </div>
    
                        <div class="form-group">
                            <label for="">Descuento</label><small> - en porcentaje</small>
                            <input type="number" name="descuento" class="form-control" placeholder="Descuento en porcentaje" value="{{old('descuento')}}">
                        </div>
    
                        <div class="form-group">
                            <button type="submit" class="btn btn-outline-primary btnEnviarForm">Guardar
                                cambios</button>
                        </div>
    
                    </form>
    
                </div>
            </div>
        </div>
    
    </div>
@endsection