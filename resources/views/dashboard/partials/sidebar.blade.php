<div class="sidebar" data-color="green" data-image="/dashboard/assets/img/sidebar-4.jpg">
    <!--
    Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

    Tip 2: you can also add an image using data-image tag
    -->
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="https://genovevaok.com/#/home" class="ml-4" style="color:whitesmoke">Genoveva Shop Online</a>
        </div>
        <ul class="nav">
            {{-- <li class="nav-item float-left col-12">
                <a class="nav-link" href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit(); ">
                    <p>Cerrar sesión</p>
                </a>
                <form id="logout-form" action="/logout" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
            @if (strpos(Request::url(), 'home'))
                <li class="nav-item active float-left col-12">
                    <a class="nav-link" href="/admin/home">
                        <i class="nc-icon nc-chart-pie-35"></i>
                        <p>Home</p>
                    </a>
                </li>
            @else
                <li class="nav-item float-left col-12">
                    <a class="nav-link" href="/admin/home">
                        <i class="nc-icon nc-chart-pie-35"></i>
                        <p>Home</p>
                    </a>
                </li>
            @endif

            @if (strpos(Request::url(), 'perfil'))
                <li class="nav-item active float-left col-12">
                    <a class="nav-link" href="/admin/perfil">
                        <i class="nc-icon nc-circle-09"></i>
                        <p>Perfil</p>
                    </a>
                </li>
            @else
                <li class="nav-item float-left col-12">
                    <a class="nav-link" href="/admin/perfil">
                        <i class="nc-icon nc-circle-09"></i>
                        <p>Perfil</p>
                    </a>
                </li>
            @endif --}}

            @if (strpos(Request::url(), 'productos'))
                <li class="nav-item active float-left col-12">
                    <a class="nav-link" href="/admin/productos">
                        <i class="nc-icon nc-tag-content"></i>
                        <p>Productos</p>
                    </a>
                </li>
            @else
                <li class="nav-item float-left col-12">
                    <a class="nav-link" href="/admin/productos">
                        <i class="nc-icon nc-tag-content"></i>
                        <p>Productos</p>
                    </a>
                </li>
            @endif

            @if (strpos(Request::url(), 'ordenes'))
                <li class="nav-item active float-left col-12">
                    <a class="nav-link" href="/admin/ordenes">
                        <i class="nc-icon nc-cart-simple"></i>
                        <p>Ordenes</p>
                    </a>
                </li>
            @else
                <li class="nav-item float-left col-12">
                    <a class="nav-link" href="/admin/ordenes">
                        <i class="nc-icon nc-cart-simple"></i>
                        <p>Ordenes</p>
                    </a>
                </li>
            @endif
            
            {{-- @if (strpos(Request::url(), 'personalizacion'))
                <li class="nav-item active float-left col-12">
                    <a class="nav-link" href="/admin/personalizacion">
                        <i class="nc-icon nc-notes"></i>
                        <p>Personalización</p>
                    </a>
                </li>
            @else
                <li class="nav-item float-left col-12">
                    <a class="nav-link" href="/admin/personalizacion">
                        <i class="nc-icon nc-notes"></i>
                        <p>Personalización</p>
                    </a>
                </li>
            @endif --}}

            <li class="nav-item float-left col-12">
                <a class="nav-link">
                    {{-- <i class="nc-icon nc-settings-tool-66"></i> --}}
                    <label for="">Poner en mantenimiento?</label>
                    <form action="/mantenimiento" method="post" id="formMantenimiento">
                        <select name="estaEnMantenimiento" id="selectMantenimiento" class="form-control">
                            <option value="1">Si</option>
                            <option value="0">No</option>
                        </select>
                    </form>
                </a>
            </li>
        </ul>
    </div>
</div>

<script>
    let formMantenimiento = document.querySelector('#formMantenimiento');
    let mantenimientoUrl = '/api/mantenimiento'
    let selectMantenimiento = document.querySelector('#selectMantenimiento');

    fetch(mantenimientoUrl, {
        method: 'GET', // or 'PUT'
        // headers:{
        //   'Content-Type': 'application/json',
        //   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        // }
      }).then(res => res.text())
      .catch(error => console.error('Error:', error))
      .then(response => {
        document.querySelector('#selectMantenimiento').value = response;
      });

    function cambiarMantenimiento(valor){

        var mantenimientoUrl = '/api/mantenimiento';
        var data = {estaEnMantenimiento: valor};

        fetch(mantenimientoUrl, {
        method: 'PUT', // or 'PUT'
        body: JSON.stringify(data), // data can be `string` or {object}!
        headers:{
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        }).then(res => res.json())
        .catch(error => console.error('Error:', error))
        .then(response => {
            console.log('Success:', response)
        });
        // .then(response => console.log('Success:', response));



    }

    selectMantenimiento.addEventListener('change', () => {
        console.log(selectMantenimiento.value);
        cambiarMantenimiento(selectMantenimiento.value);
        if (selectMantenimiento.value == 1) {
            Swal.fire({
                title: 'Estado del shop: ACTUALIZANDO'
            });
        } else {
            Swal.fire({
                title: 'Estado del shop: ONLINE'
            });
        }
          
    });

    
</script>