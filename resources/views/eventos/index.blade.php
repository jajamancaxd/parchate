@extends('componentes_permanentes_negocio')

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
        margin-bottom: 20px;
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

    .card .info {
        margin-left: 15px;
        display: flex;
        flex-direction: 1;
        flex: 1;
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
    }

    .card-actions button.delete {
        background: #cc0000;
    }

    .info h3 {
        margin: 0;
        color: #FF6600;
    }

    .info small {
        display: block;
        color: #555;
        margin-bottom: 5px;
    }

    .star {
        color: orange;
        font-size: 1.2em;
    }

    .tags {
        margin-top: 5px;
        color: #666;
        font-size: 0.9em;
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
</style>
    <div class="titulo">Mis Eventos</div>
  <div class="search">
    <input type="text" placeholder="Buscar evento...">
    <button>Buscar</button>
  </div>
  <div class="container">
    @foreach($eventos as $evento)
      <div class="card">
        <div class="info">
          <div>
            <h3>{{ $evento->nombre_evento }}</h3>
            <small>{{ Str::limit($evento->descripcion_evento, 100) }}</small>
            <div class="tags">{{ $evento->fecha_inicio_evento }} - {{ $evento->hora_inicio_evento }}</div>
          </div>
        </div>
        @if($evento->imagenes->first())
          <img src="{{ asset('storage/' . $evento->imagenes->first()->ruta_imagen_evento) }}" alt="Imagen del evento">
        @else
          <img src="{{ asset('img/sin-imagen.png') }}" alt="Sin imagen">
        @endif
        <div class="card-actions">
          <a href="{{ route('eventos.edit', $evento->id_evento) }}">Modificar</a>
        </div>
      </div>
    @endforeach
    <div class="footer">
      <a class="add-button" href="{{ route('eventos.create') }}">+</a>
    </div>
  </div>
@endsection
