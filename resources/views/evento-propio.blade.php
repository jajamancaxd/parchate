@extends('componentes_permanentes_negocio')

@section('titulo', 'Eventos Propios')

@section('content')
<style>
    body {
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
        background: #fff;
        color: #000;
    }

    .titulo {
        text-align: center;
        font-size: 1.8em;
        font-weight: bold;
        color: #FF6600;
        margin-top: 25px;
        margin-bottom: 10px;
    }

    .search {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 10px;
        margin: 20px;
        padding-right: 20px;
    }

    .search input {
        padding: 8px;
        width: 200px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .search button {
        padding: 8px 12px;
        background: #FF6600;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 12px;
        padding: 15px 20px;
        margin: 0 20px 20px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        font-family: 'Poppins', sans-serif;
    }

    .card img {
        width: 120px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        margin-left: 20px;
    }

    .card-info {
        flex: 1;
        margin-right: 20px;
    }

    .card-info h2 {
        margin: 0;
        color: #FF6600;
        font-size: 1.2em;
    }

    .card-info p {
        margin: 5px 0 0;
        color: #555;
        font-size: 0.9em;
    }

    .card-meta {
        display: flex;
        gap: 15px;
        margin-top: 10px;
        font-size: 0.8em;
        color: #666;
    }

    .card-meta span {
        display: flex;
        align-items: center;
    }

    .card-meta .icono {
        width: 14px;
        height: 14px;
        margin-right: 5px;
    }

    .tipo-evento {
        display: inline-block;
        padding: 3px 8px;
        background-color: #f0f0f0;
        border-radius: 4px;
        font-size: 0.8em;
        color: #555;
    }

    .card-actions {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        margin-left: 20px;
        gap: 10px;
    }

    .card-actions a,
    .card-actions button {
        text-decoration: none;
        color: #fff;
        background: #ff6600;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        border: none;
        cursor: pointer;
        text-align: center;
        min-width: 80px;
    }

    .card-actions button.delete {
        background: #cc0000;
    }

    .footer {
        text-align: center;
        padding: 30px;
    }

    .add-button {
        display: inline-block;
        width: 120px;
        height: 70px;
        border: 2px solid #FF6600;
        border-radius: 10px;
        text-align: center;
        font-size: 2.5em;
        line-height: 70px;
        color: #FF6600;
        text-decoration: none;
        font-weight: bold;
    }

    .add-button:hover {
        background: #FF6600;
        color: #fff;
    }

    .no-events {
        text-align: center;
        padding: 40px;
        color: #666;
        font-size: 1.1em;
    }
</style>

<div class="titulo">Eventos Propios</div>

<form action="{{ route('evento-propio.buscar') }}" method="POST" class="search">
    @csrf
    <input type="text" name="buscar" placeholder="Buscar mis eventos" value="{{ $buscar ?? '' }}">
    <button type="submit">Buscar</button>
</form>

@forelse($eventospropios as $evento)
<div class="card">
    <div class="card-info">
        <h2>{{ $evento->nombre_evento }}</h2>
        <p>{{ Str::limit($evento->descripcion_evento, 100) }}</p>
        
        <div class="card-meta">
            <span class="tipo-evento">{{ ucfirst($evento->tipo_evento) }}</span>
            <span>
                <img src="{{ asset('imagenes/calendario.png') }}" class="icono">
                {{ \Carbon\Carbon::parse($evento->fecha_evento)->format('d/m/Y') }}
            </span>
            <span>
                <img src="{{ asset('imagenes/reloj.png') }}" class="icono">
                {{ \Carbon\Carbon::parse($evento->hora_evento)->format('h:i A') }}
            </span>
            <span>
                <img src="{{ asset('imagenes/corazon.png') }}" class="icono">
                {{ $evento->favoritos_count ?? 0 }} favoritos
            </span>
        </div>
    </div>

    @php $imagenEvento = $evento->imagenes->first(); @endphp
    @if($imagenEvento)
        <img src="{{ asset('storage/' . $imagenEvento->ruta_imagen_evento) }}" alt="{{ $evento->nombre_evento }}">
    @else
        <img src="{{ asset('imagenes/imagen-no-disponible.png') }}" alt="Imagen no disponible">
    @endif

    <div class="card-actions">
        <a href="{{ route('eventos.edit', $evento->id_evento) }}">Editar</a>
    </div>
</div>
@empty
<div class="no-events">No has creado ningún evento aún.</div>
@endforelse

<div class="footer">
    <a href="{{ route('eventos.create') }}" class="add-button">+</a>
</div>

@endsection

@section('scripts')
    <script src="{{ asset('js/eventosrecomendados.js') }}"></script>
@endsection