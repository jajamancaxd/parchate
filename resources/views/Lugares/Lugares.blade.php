@extends('layout')

@section('title', 'Lugares')

@section('styles')
  <link rel="stylesheet" href="{{ asset('css/Lugares/style.css') }}">
@endsection

@section('content')
<div class="contenido-lugares">
    <div class="encabezado">
        <h1>Lugares</h1>
        <div class="flash-messages">
            @if(session('success'))
                <div class="flash-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="flash-error">{{ session('error') }}</div>
            @endif

        </div>
        <div class="ordenar">
           
            @php
                $ordenActual = request('orden', 'desc');
                $nuevoOrden = $ordenActual === 'asc' ? 'desc' : 'asc';
                $rotacion = $ordenActual === 'asc' ? 'rotate(180deg)' : 'rotate(0deg)';
                $texto = $ordenActual === 'asc' ? 'Más recientes' : 'Más antiguos';
            @endphp

            <a href="{{ request()->fullUrlWithQuery(['orden' => $nuevoOrden]) }}" class="boton-orden">
                <i class="bi bi-arrow-down-up flecha" style="transform: {{ $rotacion }};"></i>
                <span>{{ $texto }}</span>
            </a>
        </div>


    </div>

    <div class="grid-tarjetas">
        @foreach ($sucursales as $sucursal)
            <a href="{{ route('Lugares.Show', $sucursal->id_sucursal) }}" class="tarjeta-evento-link" style="text-decoration: none; color: inherit;">
                <div class="tarjeta-lugar">
                    <img src="{{ asset($sucursal->imagenPrincipal->ruta_imagen_sucursal ?? 'images/Lugares/default.png') }}" alt="Lugar" class="imagen-lugar">

                    <div class="contenido">
                        <div class="header-tarjeta">
                            <h3>{{ $sucursal->nombre_sucursal }}</h3>
                            <div class="likes">
                                <i class="bi bi-star-fill"></i> {{ $sucursal->favoritos_usuarios_count }}
                            </div>
                        </div>

                        <p class="ubicacion"><i class="bi bi-geo-alt-fill"></i> {{ $sucursal->ubicacion_dada_sucursal }}</p>

                        <p class="tipo">
                            <span class="etiqueta">Tipo de lugar:</span>
                            {{ $sucursal->tipos->pluck('tipo_de_sucursal')->join(', ') }}
                        </p>

                        <p class="descripcion"><span class="etiqueta">Descripción:</span><br>{{ $sucursal->descripcion_sucursal }}</p>

                        <span class="etiqueta">Leer más</span>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    setTimeout(() => {
      document.querySelectorAll('.flash-messages > *').forEach(el => {
        el.style.transition = 'opacity 0.5s ease';
        el.style.opacity = '0';
        setTimeout(() => {
          el.style.display = 'none';
        }, 500);
      });
    }, 3000);
  });
</script>
@endsection