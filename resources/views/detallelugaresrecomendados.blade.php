<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $lugar['nombre'] }}</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

@include('navbar')

<main class="contenedor">
    <div class="tarjeta">
        <img src="{{ asset('imagenes/' . $lugar['imagen']) }}" alt="{{ $lugar['nombre'] }}" class="tarjeta-img">
        <div class="tarjeta-contenido">
            <div class="tarjeta-header">
                <h3 class="nombre">{{ $lugar['nombre'] }}</h3>
                <span class="puntuacion">
                    <img src="{{ asset('imagenes/estrella.png') }}" class="icono">{{ $lugar['puntuacion'] }}
                </span>
            </div>
            <p class="ubicacion">
                <img src="{{ asset('imagenes/ubicacion.png') }}" class="icono">{{ $lugar['ubicacion'] }}
            </p>
            <h3 class="nombre">Descripción</h3>
            <p class="descripcion">{{ $lugar['descripcion'] }}</p>
            <a href="{{ route('inicio') }}" class="leer-mas">Volver</a>
        </div>
    </div>
</main>

</body>
</html>
