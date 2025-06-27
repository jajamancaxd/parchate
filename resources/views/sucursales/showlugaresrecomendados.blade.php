@extends('layouts.applugaresrecomendados')

@section('content')
<div class="sucursal-detalle-vertical">
    @if ($sucursal->imagenes->first())
        <img src="{{ asset('storage/' . $sucursal->imagenes->first()->ruta_imagen_sucursal) }}" 
             alt="{{ $sucursal->nombre_sucursal }}"
             class="sucursal-imagen-vertical">
    @else
        <p class="sucursal-sin-imagen">No hay imagen disponible.</p>
    @endif

    <div class="sucursal-contenido-vertical">
        <h1 class="sucursal-titulo">{{ $sucursal->nombre_sucursal }}</h1>

        <p class="sucursal-info"><strong>Ubicación:</strong> {{ $sucursal->ubicacion_dada_sucursal }}</p>

        <p class="sucursal-descripcion">
            <strong>Descripción:</strong><br>
            {{ $sucursal->descripcion_sucursal }}
        </p>

        <a href="{{ route('lugares.recomendados') }}" class="btn-volver">
            ← Volver a la lista
        </a>
    </div>
</div>
@endsection
