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
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Editar Perfil</h4>
                                </div>
                                <div class="card-body">
                                    <form enctype='multipart/form-data' id="formEditarPerfil" method="post">
                                        
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Marca</label>
                                                    <input type="text" name="nombreMarca" class="form-control validar" disabled="" placeholder="Nombre de la marca..." value="{{ auth()->user()->nombreMarca }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="text" name="email" class="form-control validar" placeholder="Email..." value="{{ auth()->user()->email }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nombre</label>
                                                    <input type="text" name="name" class="form-control validar" placeholder="Nombre..." value="{{ auth()->user()->name }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Apellido</label>
                                                    <input type="text" name="lastName" class="form-control validar" placeholder="Apellido..." value="{{ auth()->user()->lastName }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Pais</label>
                                                    <input disabled type="text" name="pais" class="form-control" id="pais" placeholder="Pais..." value="{{ auth()->user()->pais }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Provincia</label>
                                                    <input type="text" name="provincia" class="form-control validar" placeholder="Provincia..." value="{{ auth()->user()->provincia }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Ciudad</label>
                                                    <input type="text" name="ciudad" class="form-control validar" placeholder="Ciudad..." value="{{ auth()->user()->ciudad }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">Logo de la marca</label>
                                                    <img src="{{ auth()->user()->logoMarcaUrl }}" class="rounded imagenLogo" width="200">
                                                </div>
                                                <div class="form-group custom-file">
                                                    <label for="" class="custom-file-label logoMarca">Elegir/cambiar logo...</label>
                                                    <input class="custom-file-input logoMarca-input validarLogo" type="file" lang="es" name="logoMarca">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Sobre la marca</label>
                                                    <textarea name="sobreLaMarca" rows="4" class="form-control validar" placeholder="Contanos de que trata, que vende, a quienes..." value="">{{ auth()->user()->sobreLaMarca }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <h2>Redes Sociales</h2>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label><img src="/img/instagram.png" width="14px" height="14px" style="opacity: 0.6" alt=""> Instagram</label>
                                                    <input type="text" name="instagram" class="form-control validar" placeholder="@..." value="{{ auth()->user()->instagram }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label><img src="/img/facebook.png" width="14px" height="14px" style="opacity: 0.6" alt=""> Facebook</label>
                                                    <input type="text" name="facebook" class="form-control validar" placeholder='@...' value="{{ auth()->user()->facebook }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label><img src="/img/twitter.png" width="14px" height="14px" style="opacity: 0.6" alt=""> Twitter</label>
                                                    <input type="text" name="twitter" class="form-control validar" placeholder="@..." value="{{ auth()->user()->twitter }}">
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-block mt-5">Actualizar perfil</button>
                                        {{-- <div class="clearfix"></div> --}}
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-user">
                                <div class="card-image">
                                    {{-- <img src="{{ auth()->user()->logoMarcaUrl }}" alt="..."> --}}
                                </div>
                                <div class="card-body">
                                    <div class="author">
                                        <a href="#">
                                            <img class="avatar border-gray" src="{{ auth()->user()->logoMarcaUrl }}" alt="...">
                                            <h5 class="title">{{ auth()->user()->nombreMarca }}</h5>
                                        </a>
                                        <p class="description">
                                            {{ auth()->user()->name }} {{ auth()->user()->lastName }}
                                        </p>
                                    </div>
                                    <p class="description text-center">
                                        {{ auth()->user()->sobreLaMarca }}
                                    </p>
                                </div>
                                <hr>
                                <div class="button-container mr-auto ml-auto">
                                    <a target="_blank" href="https://www.instagram.com/{{ auth()->user()->instagram }}/" class="btn btn-simple btn-link btn-icon">
                                        <img src="/img/instagram.png" width="20px" style="opacity: 0.8" alt="">
                                    </a>
                                    <a target="_blank" href="https://www.facebook.com/{{ auth()->user()->facebook }}" class="btn btn-simple btn-link btn-icon">
                                        <img src="/img/facebook.png" width="20px" style="opacity: 0.8" alt="">
                                    </a>
                                    <a target="_blank" href="https://twitter.com/{{ auth()->user()->twitter }}" class="btn btn-simple btn-link btn-icon">
                                        <img src="/img/twitter.png" width="20px" style="opacity: 0.8" alt="">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.scripts')
    <script src="/js/dashboard/perfil.js"></script>
    @include('dashboard.partials.scripts')

</body>
 
</html>
 