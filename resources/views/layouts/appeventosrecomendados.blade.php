<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Parchate')</title>
    <link rel="stylesheet" href="{{ asset('css/eventosrecomendados.css') }}">
</head>
<body>

    @include('navbar')

    <main class="contenedor">
        @yield('content')
    </main>

    <script src="{{ asset('js/script.js') }}"></script>
    @stack('scripts')
</body>
</html>