@extends('componentes_permanentes_negocio')

@section('content')

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: #f9f9f9;
        color: #222;
        margin: 0;
        padding: 0;
    }

    .titulo {
        text-align: center;
        font-size: 2em;
        font-weight: 700;
        color: #f35c0c;
        margin-top: 30px;
        margin-bottom: 10px;
    }

    .search {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding: 0 20px;
        margin-bottom: 25px;
    }

    .search input {
        padding: 10px;
        width: 230px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 14px;
    }

    .search button {
        padding: 10px 16px;
        background: #f35c0c;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: background 0.3s;
    }

    .search button:hover {
        background: #d94e00;
    }

    .card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: white;
        border: 1px solid #e1e1e1;
        border-radius: 14px;
        padding: 20px;
        margin: 15px 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    }

    .card-info {
        flex: 1;
        margin-right: 20px;
    }

    .card-info h2 {
        margin: 0 0 8px 0;
        color: #f35c0c;
        font-size: 20px;
        font-weight: 700;
    }

    .card-info p {
        margin: 0;
        font-size: 14px;
        color: #444;
    }

    .card img {
        width: 140px;
        height: 90px;
        object-fit: cover;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .card-actions {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 10px;
        margin-left: 20px;
    }

    .card-actions a,
    .card-actions button {
        text-decoration: none;
        color: #fff;
        background: #f35c0c;
        padding: 8px 14px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        border: none;
        cursor: pointer;
        transition: background 0.3s;
    }

    .card-actions a:hover {
        background: #d94e00;
    }

    .card-actions button.delete {
        background: #cc0000;
    }

    .footer {
        text-align: center;
        padding: 40px 0;
    }

    .add-button {
        display: inline-block;
        width: 65px;
        height: 65px;
        background: transparent;
        border: 3px dashed #f35c0c;
        border-radius: 50%;
        color: #f35c0c;
        font-size: 2em;
        font-weight: bold;
        line-height: 65px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .add-button:hover {
        background: #f35c0c;
        color: white;
        border-style: solid;
    }
</style>

<div class="titulo">Sucursales del Negocio</div>

<div class="search">
    <input type="text" placeholder="Buscar sucursal">
    <button>Buscar</button>
</div>

@foreach ($sucursales as $sucursal)
<div class="card">
    <div class="card-info">
        <h2>{{ $sucursal->nombre_sucursal }}</h2>
        <p>{{ $sucursal->descripcion_sucursal }}</p>
    </div>

    @if($sucursal->imagenes->first())
        <img src="{{ asset('storage/' . $sucursal->imagenes->first()->ruta_imagen_sucursal) }}" alt="Imagen Sucursal">
    @endif

    <div class="card-actions">
        <a href="{{ route('sucursales.edit', $sucursal->id_sucursal) }}">Editar</a>
    </div>
</div>
@endforeach

<div class="footer">
    <a href="{{ route('sucursales.create') }}" class="add-button">+</a>
</div>

@endsection
