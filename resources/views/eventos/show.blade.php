@extends('layouts.app')

@section('content')
<div class="container">
    @if(session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <h1 style="color: #ff6600; margin-bottom: 20px;">Detalle del Evento</h1>

    <div style="margin-bottom: 15px;">
        <strong>Nombre del Evento:</strong>
        <p>{{ $evento->nombre_evento }}</p>
    </div>

    <div style="margin-bottom: 15px;">
        <strong>Descripción:</strong>
        <p>{{ $evento->descripcion_evento }}</p>
    </div>

    <div style="margin-bottom: 15px;">
        <strong>Ubicación:</strong>
        <p>{{ $evento->ubicacion_dada_evento }}</p>
    </div>

    <div style="margin-bottom: 15px;">
        <strong>Fecha de Inicio:</strong>
        <p>{{ $evento->fecha_inicio_evento }}</p>
    </div>

    <div style="margin-bottom: 15px;">
        <strong>Fecha de Fin:</strong>
        <p>{{ $evento->fecha_fin_evento }}</p>
    </div>

    <div style="margin-bottom: 15px;">
        <strong>Horario:</strong>
        <p>{{ $evento->hora_inicio_evento }}</p>
    </div>

    <div style="margin-bottom: 15px;">
        <strong>Imágenes:</strong>
        <div style="display: flex; flex-wrap: wrap; gap: 10px;">
            @foreach($evento->imagenes as $imagen)
                <img src="{{ asset('storage/' . $imagen->ruta_imagen_evento) }}" alt="Imagen del evento" style="width: 150px; height: 100px; object-fit: cover; border-radius: 5px;">
            @endforeach
        </div>
    </div>

    <div style="margin-top: 20px;">
        <a href="{{ route('eventos.edit', $evento->id_evento) }}" style="background-color: #ff6600; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; margin-right: 10px;">Editar</a>
        <a href="{{ route('eventos.index') }}" style="background-color: #ccc; color: black; padding: 10px 20px; border-radius: 5px; text-decoration: none;">Volver al listado</a>
    </div>
</div>
@endsection
