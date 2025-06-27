<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos Recomendados</title>
    <link rel="stylesheet" href="{{ asset('css/eventosrecomendados.css') }}">
</head>

<body>

    @include('navbar')

    <main class="contenedor">
        <div class="barra-superior">
            <!-- Filtro a la izquierda -->
            <form method="GET" action="{{ route('eventos.recomendados') }}" class="filtro-lado-izquierdo">
                <button type="button" id="filtro-btn">Filtrar <img src="{{ asset('imagenes/filtro.png') }}" class="icono"></button>

                <div id="filtro-box" class="filtro-box">
                    <label for="ubicacion">Ubicación</label>
                    <select name="ubicacion" id="ubicacion">
                        <option value="">Seleccionar</option>
                        <option value="Cerca de">Cerca de</option>
                        <option value="Sin importancia">Sin importancia</option>
                        <option value="Lugar en especifico">Lugar en especifico</option>
                    </select>

                    <label for="tipo">Tipo de evento</label>
                    <select name="tipo" id="tipo">
                        <option value="">Seleccionar</option>
                        <option value="deportivos">Deportivos</option>
                        <option value="danza">Danza</option>
                        <option value="cultural">Culturales</option>
                        <option value="exposiciones">Exposiciones</option>
                        <option value="conciertos">Conciertos</option>
                        <option value="desfiles">Desfiles</option>
                        <option value="teatro">Teatro</option>
                        <option value="gastronomicos">Gastronomicos</option>
                        <option value="tecnologicos">Tecnologicos</option>
                        <option value="religiosos">Religiosos</option>
                    </select>

                    <label for="fecha">Fecha</label>
                    <input type="date" name="fecha" id="fecha">

                    <label for="hora">Hora del evento</label>
                    <input type="time" name="hora" id="hora">

                    <label for="presupuesto">Presupuesto (COP)</label>
                    <input type="number" name="presupuesto" id="presupuesto" min="0" step="1000" placeholder="$">

                    <div class="botones-filtro">
                        <button type="submit" class="btn-buscar">Buscar</button>
                        <button type="button" class="btn-cancelar">Cancelar</button>
                    </div>
                </div>
            </form>

            <!-- Tabs en el centro -->
            <div class="tabs-centro">
                <button class="tab">Eventos Recomendados</button>
            </div>

            <!-- Buscador a la derecha -->
            <form action="{{ route('evento.buscar') }}" method="POST" class="buscador-derecha">
                @csrf
                <input type="text" name="buscar" placeholder="Buscar lugares" value="{{ $buscar ?? '' }}">
                <button type="submit">Buscar</button>
            </form>
        </div>

        <!-- Contenedor de tarjetas -->
        <div class="tarjetas {{ count($Eventos) == 1 ? 'centrado' : '' }}">
            @forelse($Eventos as $evento)
                <div class="tarjeta">
                <a href="{{ route('evento.show', $evento->id_evento) }}"  style="text-decoration: none; color: inherit;">
                    @php $imagenEvento = $evento->imagenes->first(); @endphp

                    @if($imagenEvento)
                        <img src="{{ asset('storage/' . $imagenEvento->ruta_imagen_evento) }}" 
                             alt="{{ $evento->nombre_evento }}" 
                             class="tarjeta-img">
                    @else
                        <img src="{{ asset('imagenes/imagen-no-disponible.png') }}" 
                             alt="Imagen no disponible" 
                             class="tarjeta-img">
                    @endif

                    <div class="tarjeta-contenido">
                        <div class="tarjeta-header">
                            <h3 class="nombre">{{ $evento->nombre_evento }}</h3>
                            <span class="puntuacion">
                                <img src="{{ asset('imagenes/estrella.png') }}" class="icono">
                                {{ $evento->presupuesto_evento ?? 0 }}
                            </span>
                        </div>

                        <p class="ubicacion">
                            <img src="{{ asset('imagenes/ubicacion.png') }}" class="icono">
                            {{ $evento->ubicacion_dada_evento }}
                        </p>

                        <h3 class="nombre">Descripción</h3>
                        <p class="descripcion" id="descripcion-{{ $evento->id_evento }}">
                            {{ $evento->descripcion_evento }}
                        </p>

                        <a href="javascript:void(0);" 
                           class="leer-mas" 
                           id="btn-{{ $evento->id_evento }}"
                           onclick="toggleDescripcion({{ $evento->id_evento }})">Read More</a>
                    </div>
                    </a>
                </div>
            @empty
                <p>No se encontraron resultados.</p>
            @endforelse
        </div>
    </main>
    <script src="{{ asset('js/eventosrecomendados.js') }}"></script>
</body>
</html>
