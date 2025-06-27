<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle del Evento - {{ $evento->nombre_evento }}</title>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/Eventos/show.css') }}">
</head>
<body>
    <div class="evento-info">
        <!-- Botón regresar -->
        <div class="top-bar">
            <a href="{{ route('Eventos') }}" class="btn-regresar">
                <i class="bi bi-arrow-left"></i> Regresar
            </a>
        </div>

        <!-- Línea gris -->
        <div class="divider"></div>

        <!-- Título -->
        <h2 class="evento-title">{{ $evento->nombre_evento }}</h2>

        <!-- Carrusel -->
        <div class="swiper-container">
            <div class="swiper-wrapper">
                @if($evento->imagenes && $evento->imagenes->isNotEmpty())
                    @foreach($evento->imagenes as $imagen)
                        <div class="swiper-slide">
                            <img src="{{ asset($imagen->ruta_imagen_evento) }}" alt="Imagen del evento">
                        </div>
                    @endforeach
                @else
                    <p>No hay imágenes disponibles para este evento.</p>
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
                    <i class="bi bi-geo-alt-fill" style="color: #FF6600;"></i> {{ $evento->ubicacion_dada_evento }}
                    <i class="bi bi-star-fill" style="color: #FF6600;"></i> {{ $evento->favoritos_usuarios_count }}
                </p>
                <p><strong style="color: #FF6600;">Tipo de evento:</strong> 
                    @forelse ($evento->tipos as $tipo)
                        {{ $tipo->tipo_de_evento }}{{ !$loop->last ? ', ' : '' }}
                    @empty
                        Sin tipo definido
                    @endforelse
                </p>


                <p><strong style="color: #FF6600;">Fecha de inicio:</strong> {{ $evento->fecha_inicio_evento }}</p>
                @if($evento->hora_inicio_evento)
                    <p><strong style="color: #FF6600;">Hora de inicio:</strong> 
                        {{ \Carbon\Carbon::createFromFormat('H:i:s', $evento->hora_inicio_evento)->format('H:i') }}
                    </p>
                @else   
                    <p style="color: rgb(0, 0, 0); text-align:center;">Este evento no tiene horarios definidos.</p>
                @endif

                <p style="color: #FF6600;"><strong>Descripción</strong></p>
                <p>{{ $evento->descripcion_evento }}</p>
            </div>

            



            @if($evento->productos->isNotEmpty())
                <div class="right-card">
                    <h4>Productos</h4>
                    @foreach($evento->productos as $producto)
                        <p>{{ $producto->nombre_producto_evento }} ${{ number_format($producto->precio_producto_evento, 0, ',', '.') }}</p>
                    @endforeach
                    <p>
                        <strong style="color: #FF6600;">
                            Promedio: ${{ number_format($evento->productos->avg('precio_producto_evento'), 0, ',', '.') }}
                        </strong>
                    </p>
                </div>
            @else
                <div class="right-card">
                    <h4>Productos</h4>
                    <p style="text-align: center;">Este evento no tiene productos asociados.</p>
                </div>
            @endif
        </div>

        <!-- Botones -->
        <div class="btn-group">
            <form action="{{ route('Eventos.CambiarEstado', $evento->id_evento) }}" method="POST" style="display:inline;">
                @csrf
                <input type="hidden" name="estado" value="aceptado">
                <button type="submit" class="btn-orange">Aceptar</button>
            </form>

            <form action="{{ route('Eventos.CambiarEstado', $evento->id_evento) }}" method="POST" style="display:inline;">
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
