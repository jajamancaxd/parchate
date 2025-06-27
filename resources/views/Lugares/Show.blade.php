<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle del Lugar - {{ $sucursal->nombre_sucursal }}</title>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />

    <!-- CSS personalizado -->
    <link rel="stylesheet" href="{{ asset('css/Lugares/show.css') }}">
</head>
<body>
    <div class="sucursal-info">
        <!-- Botón regresar -->
        <div class="top-bar">
            <a href="{{ route('Lugares') }}" class="btn-regresar">
                <i class="bi bi-arrow-left"></i> Regresar
            </a>
        </div>

        <!-- Línea gris -->
        <div class="divider"></div>

        <!-- Título -->
        <h2 class="sucursal-title">{{ $sucursal->nombre_sucursal }}</h2>

        <!-- Carrusel -->
        <div class="swiper-container">
            <div class="swiper-wrapper">
                @if($sucursal->imagenes && $sucursal->imagenes->isNotEmpty())
                    @foreach($sucursal->imagenes as $imagen)
                        <div class="swiper-slide">
                            <img src="{{ asset($imagen->ruta_imagen_sucursal) }}" alt="Imagen del lugar">
                        </div>
                    @endforeach
                @else
                    <p>No hay imágenes disponibles para este lugar.</p>
                @endif
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>

        <!-- Info + Productos -->
        <div class="info-productos-box">
            <div class="left-info">
                <p>
                    <i class="bi bi-geo-alt-fill" style="color: #FF6600;"></i> {{ $sucursal->ubicacion_dada_sucursal }}
                    <i class="bi bi-star-fill" style="color: #FF6600;"></i> {{ $sucursal->favoritos_usuarios_count }}
                </p>
                <p><strong style="color: #FF6600;">Tipo de lugar:</strong> {{ $sucursal->tipos->pluck('tipo_de_sucursal')->join(', ') }}</p>

                @if($sucursal->horariosSucursal->isNotEmpty())
                    <p style="color: #FF6600;"><strong>Horarios</strong></p>
                    @foreach($sucursal->horariosSucursal as $hs)
                        @if($hs->horario && $hs->diaServicio)
                            <p>
                                <strong>{{ ucfirst($hs->diaServicio->dias_de_servicios) }}:</strong> {{ $hs->horario->horario }}
                            </p>
                        @elseif($hs->horario)
                            <p>
                                <strong>Día no especificado:</strong> {{ $hs->horario->horario }}
                            </p>
                        @else
                            <p>Horario no disponible</p>
                        @endif
                    @endforeach
                @else
                    <p style="color: rgb(0, 0, 0); text-align:center;">Este lugar no tiene horarios definidos.</p>
                @endif

                <p style="color: #FF6600;"><strong>Descripción</strong></p>
                <p>{{ $sucursal->descripcion_sucursal }}</p>
            </div>

            @if($sucursal->productos->isNotEmpty())
                <div class="right-card">
                    <h4>Productos</h4>
                    @foreach($sucursal->productos as $producto)
                        <p>{{ $producto->nombre_producto_sucursal }} ${{ number_format($producto->precio_producto_sucursal, 0, ',', '.') }}</p>
                    @endforeach
                    <p>
                        <strong style="color: #FF6600;">
                            Promedio: ${{ number_format($sucursal->productos->avg('precio_producto_sucursal'), 0, ',', '.') }}
                        </strong>
                    </p>
                </div>
            @else
                <div class="right-card">
                    <h4>Productos</h4>
                    <p style="text-align: center;">Este lugar no tiene productos asociados.</p>
                </div>
            @endif
        </div>

        <!-- Botones -->
        <div class="btn-group">
            <form action="{{ route('Lugares.CambiarEstado', $sucursal->id_sucursal) }}" method="POST" style="display:inline;">
                @csrf
                <input type="hidden" name="estado" value="aceptado">
                <button type="submit" class="btn-orange">Aceptar</button>
            </form>

            <form action="{{ route('Lugares.CambiarEstado', $sucursal->id_sucursal) }}" method="POST" style="display:inline;">
                @csrf
                <input type="hidden" name="estado" value="rechazado">
                <button type="submit" class="btn-red">Rechazar</button>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper('.swiper-container', {
            loop: true,
            centeredSlides: true,
            slidesPerView: 'auto',
            spaceBetween: 30,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    </script>
</body>
</html>
