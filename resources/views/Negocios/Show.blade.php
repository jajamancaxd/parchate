<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle del Negocio - {{ $negocio->nombre_negocio }}</title>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Estilo personalizado -->
    <link rel="stylesheet" href="{{ asset('css/Negocios/show.css') }}">
</head>
<body>

    <!-- Botón de regresar FUERA de la tarjeta -->
    <div class="volver-container">
        <a href="{{ route('Negocios') }}" class="volver-link">
            <i class="bi bi-arrow-left"></i> Regresar
        </a>
    </div>

    <!-- Contenido centrado -->
    <div class="centro-contenido">
        <div class="tarjeta-negocio">

            <!-- Logo a la derecha -->
            <div class="encabezado">
                <img src="{{ asset('storage/' . $negocio->ruta_imagen_logo) }}" class="logo-negocio" alt="Logo del Negocio">
            </div>

            <!-- Nombre y correo -->
            <h3 class="nombre">{{ $negocio->nombre_negocio }}</h3>
            <p class="correo">{{ $negocio->correo_electronico_negocios }}</p>

            <!-- Descripción -->
            @if($negocio->descripcion_negocio)
                <p class="subtitulo">Descripción</p>
                <p class="descripcion">{{ $negocio->descripcion_negocio }}</p>
            @endif

            <!-- Documento -->
            @if($negocio->ruta_documentos_negocios)
                <a href="{{ route('Negocios.DescargarDocumento', $negocio->ruta_documentos_negocios) }}" class="btn-descargar">
                    <i class="bi bi-download"></i> Descargar
                </a>
            @else
                <p class="descripcion"><em>No hay documentos disponibles.</em></p>
            @endif

            <!-- Botones -->
            <div class="btn-group">
                <form action="{{ route('Negocios.CambiarEstado', $negocio->id_negocio) }}" method="POST">
                    @csrf
                    <input type="hidden" name="estado" value="aceptada">
                    <button type="submit" class="btn btn-orange">Aceptar</button>
                </form>

                <form action="{{ route('Negocios.CambiarEstado', $negocio->id_negocio) }}" method="POST">
                    @csrf
                    <input type="hidden" name="estado" value="rechazada">
                    <button type="submit" class="btn btn-red">Rechazar</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
