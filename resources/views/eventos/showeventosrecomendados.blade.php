@extends('layouts.appeventosrecomendados')

@section('content')
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $evento->nombre_evento }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

    <style>
        /* Tu CSS adaptado aquí */
        /* --- RESET --- */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #ffffff;
            color: #333;
        }

        .header {
            background-color: #ff6600;
            padding: 16px;
            text-align: center;
            color: white;
        }

        .header h1 {
            font-size: 1.5rem;
        }

        .container {
            max-width: 900px;
            margin: 24px auto;
            padding: 24px;
            background-color: #f9f9f9;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .event-title {
            font-size: 1.8rem;
            text-align: center;
            margin-bottom: 8px;
            color: #ff6600;
        }

        .event-meta {
            text-align: center;
            font-size: 0.95rem;
            color: #777;
            margin-bottom: 24px;
        }

        .carousel {
            display: flex;
            overflow-x: auto;
            gap: 12px;
            margin-bottom: 24px;
        }

        .carousel img {
            height: 200px;
            min-width: 300px;
            border-radius: 12px;
            object-fit: cover;
            flex-shrink: 0;
        }

        .description {
            margin-bottom: 24px;
            line-height: 1.6;
            font-size: 1rem;
        }

        .description strong{
            color: #ff6600;
        }

        .details {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 24px;
        }

        .details div {
            flex: 1 1 200px;
        }

        .details strong {
            color: #ff6600;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            justify-content: center;
            margin-bottom: 24px;
        }

        .actions button {
            padding: 10px 18px;
            font-size: 1rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .fav-btn {
            background-color: transparent;
            border: 2px solid #ff6600;
            color: #ff6600;
        }

        .fav-btn.active {
            background-color: #ff6600;
            color: white;
        }

        .follow-btn {
            background-color: #ff6600;
            color: white;
        }

        .follow-btn.unfollow {
            background-color: #999;
        }

        .cancel-btn {
            background-color: #ddd;
            color: #333;
        }

        .price-section {
            background-color: #f0f0f0;
            padding: 16px;
            border-radius: 12px;
            margin-top: 20px;
        }

        .price-section h3 {
            margin-bottom: 12px;
            color: #ff6600;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #eee;
        }

        @media (max-width: 600px) {
            .carousel img {
                min-width: 90%;
            }
        }
    </style>
</head>

<body>

    <main class="container">
        <h2 class="event-title">{{ $evento->nombre_evento }}</h2>

        @if ($evento->imagenes->count() > 0)
        <!-- Carrusel Bootstrap dinámico -->
        <div id="carouselEvento" class="carousel slide mb-4" data-bs-ride="carousel" style="max-width: 600px; margin: auto;">
            <div class="carousel-inner rounded">
                @foreach ($evento->imagenes as $index => $imagen)
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                    <img src="{{ asset('storage/' . $imagen->ruta_imagen_evento) }}" class="d-block w-100" alt="Imagen {{ $index + 1 }}">
                </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselEvento" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselEvento" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
        @else
        <p class="text-center text-muted">No hay imágenes disponibles para este evento.</p>
        @endif

        <!-- Descripción del evento -->
        <p class="description">
            <div><strong>Descripcion:</strong>{{ $evento->descripcion_evento }}
        </p>

        <!-- Detalles -->
        <div class="details">
            <div><strong>Ubicación:</strong> {{ $evento->ubicacion_dada_evento }}</div>
            <div><strong>Favoritos:</strong> <span id="fav-count">0</span></div>
        </div>

        <!-- Botones -->
        <div class="actions">
            <button id="fav-btn" class="fav-btn">♡ Favorito</button>
            <button id="follow-btn" class="follow-btn">Seguir</button>
            <a href="{{ url()->previous() }}" class="cancel-btn btn">← Volver</a>
        </div>

        <!-- Tabla ejemplo (opcional) -->
        <div class="price-section">
            <h3>Productos y Servicios</h3>
            <table>
                <thead>
                    <tr>
                        <th>Producto / Servicio</th>
                        <th>Precio</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Bebidas</td>
                        <td>$10.000</td>
                    </tr>
                    <tr>
                        <td>Comidas</td>
                        <td>$20.000</td>
                    </tr>
                    <tr>
                        <td>Boletería</td>
                        <td>$30.000</td>
                    </tr>
                    <tr>
                        <td><strong>Promedio</strong></td>
                        <td><strong>$20.000</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

    <script>
        const favBtn = document.getElementById('fav-btn');
        const favCount = document.getElementById('fav-count');
        const followBtn = document.getElementById('follow-btn');

        let isFav = false;
        let isFollowing = false;

        favBtn.addEventListener('click', () => {
            isFav = !isFav;
            favBtn.classList.toggle('active');
            favBtn.textContent = isFav ? '❤️ Favorito' : '♡ Favorito';
            let current = parseInt(favCount.textContent);
            favCount.textContent = isFav ? current + 1 : current - 1;
        });

        followBtn.addEventListener('click', () => {
            isFollowing = !isFollowing;
            followBtn.textContent = isFollowing ? 'Dejar de seguir' : 'Seguir';
            followBtn.classList.toggle('unfollow');
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>

</html>
@endsection

