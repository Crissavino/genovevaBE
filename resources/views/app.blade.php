<!DOCTYPE html>
<html>

<head>
    @include('partials.head')
    <title>Genoveva - Tablero Administrador</title>
</head>

<body>

    <section class="conteiner">
        @include('partials.header')

        <main class="container-fluid">
            @yield('main')
        </main>

    </section>

    @include('partials.scripts')

</body>

</html>