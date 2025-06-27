<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lugares Recomendados</title>
    <link rel="stylesheet" href="{{ asset('css/lugaresrecomendados.css') }}">
</head>
<body>

@include('navbar')

<main class="contenedor">
    <div class="barra-superior">
        <!-- Filtro a la izquierda -->
        <form method="GET" action="{{ route('lugares.recomendados') }}" class="filtro-lado-izquierdo">
            <button type="button" id="filtro-btn">Filtrar <img src="{{ asset('imagenes/filtro.png') }}" class="icono"></button>

            <div id="filtro-box" class="filtro-box">
                <label for="ubicacion">Ubicación</label>
                <select name="ubicacion" id="ubicacion">
                    <option value="">Seleccionar</option>
                    <option value="Cerca de">Cerca de</option>
                    <option value="Sin importancia">Sin importancia</option>
                    <option value="Lugar en especifico">Lugar en especifico</option>
                </select>

                <label for="tipo">Tipo de lugar</label>
                <select name="tipo" id="tipo">
                    <option value="">Seleccionar</option>
                    <option value="Balneario">Balnearios</option>
                    <option value="discotecas">discotecas</option>
                    <option value="restaurantes">restaurantes</option>
                    <option value="públicas">públicas</option>
                    <option value="museos">museos</option>
                    <option value="centros comerciales">centros comerciales</option>
                    <option value="miradores">miradores</option>
                    <option value="parques">parques</option>
                    <option value="teatro">teatro</option>
                    <option value="iglesias">iglesias</option>
                </select>

                <label for="horario">Horario</label>
                <select name="horario" id="horario">
                    <option value="">Seleccionar</option>
                    <option value="madrugada">Madrugada: de 00:00 a 5:00</option>
                    <option value="mañana">Mañana: de 5:00 a 12:00</option>
                    <option value="tarde">Tarde: de 12:00 a 18:00</option>
                    <option value="noche">Noche: de 18:00 a 00:00</option>
                    <option value="24horas">24 horas</option>
                </select>

                <label for="dia">Día</label>
                <select name="dia" id="dia">
                    <option value="">Seleccionar</option>
                    <option value="diadesemana">Dia de semana</option>
                    <option value="findesemana">Fin de semana</option>
                    <option value="todalasemana">Toda la semana</option>
                    <option value="lunes">Lunes</option>
                    <option value="marte">Martes</option>
                    <option value="miercoles">Miercoles</option>
                    <option value="jueves">Jueves</option>
                    <option value="viernes">Viernes</option>
                    <option value="sabado">Sábado</option>
                    <option value="domingo">Domingo</option>
                    <option value="noimpoorta">No importa</option>
                </select>

                <label for="presupuesto">Presupuesto (COP)</label>
                <input type="number" name="presupuesto" id="presupuesto" min="0" step="1000" placeholder="$">

                <div class="botones-filtro">
                    <button type="submit" class="btn-buscar">Buscar</button>
                    <button type="button" class="btn-cancelar">Cancelar</button>
                </div>
            </div>
        </form>

        <!-- Botón Lugares Recomendados en el centro -->
        <div class="tabs-centro">
            <button class="tab">Lugares Recomendados</button>
        </div>

        <!-- Buscador a la derecha -->
        <form action="{{ route('buscar') }}" method="POST" class="buscador-derecha">
            @csrf
            <input type="text" name="buscar" placeholder="Buscar lugares" value="{{ $buscar ?? '' }}">
            <button type="submit">Buscar</button>
        </form>
    </div>

    <!-- Tarjetas -->
    <div class="tarjetas {{ count($sucursales) == 1 ? 'centrado' : '' }}">
        @forelse($sucursales as $sucursal)
            <div class="tarjeta">
                <a href="{{ route('sucursal.show', $sucursal->id_sucursal) }}" style="text-decoration: none; color: inherit;">
                    @php $imagenSucursal = $sucursal->imagenes->first(); @endphp

                    @if($imagenSucursal)
                        <img src="{{ asset('storage/' . $imagenSucursal->ruta_imagen_sucursal) }}" 
                             alt="{{ $sucursal->nombre_sucursal }}" 
                             class="tarjeta-img">
                    @else
                        <img src="{{ asset('imagenes/imagen-no-disponible.png') }}" 
                             alt="Imagen no disponible" 
                             class="tarjeta-img">
                    @endif

                    <div class="tarjeta-contenido">
                        <div class="tarjeta-header">
                            <h3 class="nombre">{{ $sucursal->nombre_sucursal }}</h3>
                            <span class="puntuacion">
                                <img src="{{ asset('imagenes/estrella.png') }}" class="icono">
                                {{ $sucursal->promedio_productos ?? 0 }}
                            </span>
                        </div>
                        <p class="ubicacion">
                            <img src="{{ asset('imagenes/ubicacion.png') }}" class="icono">
                            {{ $sucursal->ubicacion_dada_sucursal }}
                        </p>
                        <h3 class="nombre">Descripción</h3>
                        <p class="descripcion" id="descripcion-{{ $sucursal->id_sucursal }}">
                            {{ $sucursal->descripcion_sucursal }}
                        </p>
                        <a href="javascript:void(0);" 
                           class="leer-mas" 
                           id="btn-{{ $sucursal->id_sucursal }}"
                           onclick="toggleDescripcion({{ $sucursal->id_sucursal}})">Read More</a>
                    </div>
                </a>

               
            </div>
        @empty
            <p>No se encontraron resultados.</p>
        @endforelse
    </div>
</main>

<script src="{{ asset('js/lugaresrecomendados.js') }}"></script>



</body>
</html>
