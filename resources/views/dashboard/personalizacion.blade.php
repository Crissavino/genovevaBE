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
    <style>

        .page-title h2 {
            font-size: 30px;
            text-transform: uppercase;
            font-weight: 700;
            font-family: "Ubuntu", sans-serif;
            letter-spacing: 1px;
            margin-bottom: 0; 
        }

        .total-products p {
            margin-bottom: 0;
            font-size: 12px;
            font-weight: 600;
            color: #000000;
            text-transform: uppercase;
            letter-spacing: 0.75px; 
        }
        .total-products p span {
            /* color: #f7cce5;  */
        }

        .new-badge {
            height: 25px;
            /* background-color: #f7cce5; */
            color: #ffffff;
            font-family: "Ubuntu", sans-serif;
            font-weight: 700;
            font-size: 12px;
            padding: 0 10px;
            display: inline-block;
            line-height: 25px;
            z-index: 10; 
        }

        .offer-badge {
            height: 25px;
            /* background-color: #dc0345; */
            color: #ffffff;
            font-family: "Ubuntu", sans-serif;
            font-weight: 700;
            font-size: 12px;
            padding: 0 10px;
            display: inline-block;
            line-height: 25px;
            z-index: 10; 
        }
    </style>
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
                                    <h4 class="card-title">Personalizá tu shop</h4>
                                </div>
                                <div class="card-body">

                                <form class="mt-3 mb-3" action="/dashboard/personalizacion/{{auth()->user()->id}}/guardarBanner" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('POST')
                                    <div class="form-group">
                                        <h5>Imagen del banner</h5>
                                        <small id="helpId" class="text-muted">Este es la imagen que se verá en el banner de tu shop</small>
                                        {{-- <img src="{{auth()->user()->bannerMarcaUrl}}" alt="" class="col-12"> --}}

                                        <div class="rounded mb-3 imagenBanner" style="background-image: url({{auth()->user()->bannerMarcaUrl}}); height: 300px;">
                                            <div class="container h-100">
                                              <div class="row h-100 align-items-center">
                                                <div class="col-12" style="">
                                                  <div class="page-title text-center">
                                                    <h2 style="font-family: 'Poppins', sans-serif !important; font-weight: lighter;">{{auth()->user()->nombreMarca}}</h2>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                        </div>

                                        <div class="form-group custom-file">
                                            <label for="" class="custom-file-label bannerMarca">Elegir/cambiar banner...</label>
                                            <input class="custom-file-input bannerMarca-input validarLogo" id="bannerMarcaInput" type="file" lang="es" name="bannerMarca">
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-outline btn-block">Actualizar banner</button>
                                </form>

                                    <form class="mt-3 mb-3" action="/dashboard/personalizacion/{{auth()->user()->id}}/guardarColorLetra" method="post">
                                        @csrf
                                        @method('POST')
                                        <div class="form-group">
                                            <h5>Color detalle de letras</h5>
                                            <small id="helpId" class="text-muted">Elegí el color de los detalles de las letras</small>
                                            <div class="d-block m-4">
                                                <div class="total-products">
                                                <p><span class="colorLetra" style="color: {{auth()->user()->colorLetra}}">40</span> productos encontrados</p>
                                                </div>
                                            </div>
                                            <div class="row form-group m-auto">
                                                @foreach ($colores as $color)
                                                    <div class="col-3 d-block">
                                                        <label for="{{ $color->nombre }}" class="m-auto"
                                                            style="border: black solid 1px; width: 16px; height: 16px; background-color: {{$color->nombre}};"></label>
                                                        <input type="checkbox" class="checkColorLetra" style="margin-bottom: -10px; padding-left: 6px !important;" name="colorLetra" value="{{ $color->nombre }}"
                                                            id="{{ $color->nombre }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-outline btn-block">Actualizar color de letras</button>
                                    </form>

                                    <form class="mt-3 mb-3" action="/dashboard/personalizacion/{{auth()->user()->id}}/guardarColorNew" method="post">
                                        @csrf
                                        @method('POST')
                                        <div class="form-group">
                                            <h5>Color cuadro NEW</h5>
                                            <small id="helpId" class="text-muted">Elegí el color de los detalles de las letras</small>
                                            <div class="d-block m-4">
                                            <div class="new-badge colorNew" style="background-color: {{auth()->user()->colorNew}}">
                                                    <span>NEW</span>
                                                </div>
                                            </div>
                                            <div class="row form-group m-auto">
                                                @foreach ($colores as $color)
                                                    <div class="col-3 d-block">
                                                        <label for="{{ $color->nombre }}" class="m-auto"
                                                            style="border: black solid 1px; width: 16px; height: 16px; background-color: {{$color->nombre}};"></label>
                                                        <input type="checkbox" class="checkColorNew" style="margin-bottom: -10px; padding-left: 6px !important;" name="colorNew" value="{{ $color->nombre }}"
                                                            id="{{ $color->nombre }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-outline btn-block">Actualizar color de cuadro NEW</button>
                                    </form>

                                    <form class="mt-3 mb-3" action="/dashboard/personalizacion/{{auth()->user()->id}}/guardarColorDescuento" method="post">
                                        @csrf
                                        @method('POST')
                                        <div class="form-group">
                                            <h5>Color cuadro % descuento</h5>
                                            <small id="helpId" class="text-muted">Elegí el color de los detalles de las letras</small>
                                            <div class="d-block m-4">
                                                <div class="offer-badge colorDescuento" style="background-color: {{auth()->user()->colorDescuento}}">
                                                    <span>20%</span>
                                                </div>
                                            </div>
                                            <div class="row form-group m-auto">
                                                @foreach ($colores as $color)
                                                    <div class="col-3 d-block">
                                                        <label for="{{ $color->nombre }}" class="m-auto"
                                                            style="border: black solid 1px; width: 16px; height: 16px; background-color: {{$color->nombre}};"></label>
                                                        <input type="checkbox" class="checkColorDescuento" style="margin-bottom: -10px; padding-left: 6px !important;" name="colorDescuento" value="{{ $color->nombre }}"
                                                            id="{{ $color->nombre }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-outline btn-block">Actualizar color de cuadro % descuento</button>
                                    </form>

                                    <form class="mt-3 mb-3" action="/dashboard/personalizacion/{{auth()->user()->id}}/guardarCatPrincipal" method="post">
                                        @csrf
                                        @method('POST')
                                        <div class="form-group">
                                            <h5>Categorias principales de tu tienda</h5>
                                            <ul class="row container m-auto categoriaPrincipalUl">
                                                @foreach ($categoriasPrincipales as $categoria)
                                                    @if ($categoria->user_id === auth()->user()->id)
                                                        <li class="list-group-item border-0 m-0 col-3 categoriaPrincipalLi" id="catPrinId{{ $categoria->id }}" style="padding-left: 6px !important;">
                                                            {{ $categoria->nombre }}
                                                            <a style="cursor: pointer;" class="quitarCategoriaPrincipal{{$categoria->id}}" onclick="quitarCategoriaPrincipal({{auth()->user()->id}}, {{$categoria->id}})"><img src="/img/close.svg" width="16" alt=""></a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                            <input type="text" class="catEliminadas d-none" name="catEliminadas[]">

                                            <div class="d-block">
                                                <small id="helpId" class="text-muted">Agregar categoria a tu tienda</small>
                                                <input type="text" class="form-control" name="catParaAgregar" id="">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-outline btn-block">Actualizar categorias principales</button>
                                    </form>

                                    <form class="mt-3 mb-3" action="/dashboard/personalizacion/{{auth()->user()->id}}/guardarCatSecundaria" method="post">
                                        @csrf
                                        @method('POST')
                                        <div class="form-group">
                                            <h5>Categorias secundarias/tags de tu tienda</h5>
                                            <ul class="row container m-auto categoriaSecundariaUl">
                                                @foreach ($categoriasSecundarias as $categoria)
                                                    @if ($categoria->user_id === auth()->user()->id)
                                                        <li class="list-group-item border-0 m-0 col-3 categoriaSecundariaLi" id="catSecId{{ $categoria->id }}" style="padding-left: 6px !important;">
                                                            {{ $categoria->nombre }} 
                                                            <a style="cursor: pointer;" class="quitarCategoriaSecundaria{{$categoria->id}}" onclick="quitarCategoriaSecundaria({{auth()->user()->id}}, {{$categoria->id}})"><img src="/img/close.svg" width="16" alt=""></a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                            <input type="text" class="catSecEliminadas d-none" name="catSecEliminadas[]">

                                            <small id="helpId" class="text-muted">Agregar categoria secundaria/tag a tu tienda</small>
                                            <input type="text" class="form-control" name="catSecParaAgregar" id="">
                                        </div>
                                        <button type="submit" class="btn btn-outline btn-block">Actualizar categorias secundarias</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.scripts')
    @include('dashboard.partials.scripts')
    <script src="/js/swal2.js"></script>
    <script src="/js/dashboard/personalizacion.js"></script>
    </body>
 
 </html>
 