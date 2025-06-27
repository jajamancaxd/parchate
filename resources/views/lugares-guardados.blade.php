<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lugares Guardados</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #fff;
            margin: 0;
            padding: 0;
        }
        header {
            background: #ff6600;
            color: white;
            padding: 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .volver {
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
        }
        .clickable-logo {
            cursor: pointer;
            font-weight: bold;
            transition: color 0.2s;
        }
        .clickable-logo:hover {
            color: #ffe0c2;
        }
        .container {
            padding: 20px;
        }
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            gap: 20px;
        }
        .ordenar {
            display: flex;
            align-items: center;
            text-decoration: none;
            font-weight: bold;
            color: black;
            font-size: 14px;
        }
        .flecha {
            font-size: 18px;
            margin-right: 6px;
        }
        .search-box {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .search-box input[type="text"] {
            padding: 6px 12px;
            border-radius: 10px;
            border: 1px solid #ccc;
            outline: none;
            width: 180px;
        }
        .buscar-btn {
            padding: 6px 14px;
            background-color: #FF6600;
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(270px, 1fr));
            gap: 20px;
            margin-top: 20px;
            padding: 0 30px; 
        }
        .card {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: scale(1.02);
        }
        .card img {
            width: 100%;
            height: 160px;
            object-fit: cover;
        }
        .card-body {
            padding: 15px;
        }
        .card-body h3 {
            font-size: 1rem;
            margin: 0;
        }
        .card-body p {
            font-size: 0.9rem;
            color: #555;
        }
    </style>
</head>
<body>
    <header>
        <a href="{{ url('/lugaresrecomendados') }}" class="volver" style="text-decoration: none; color: white;">←</a>
        <div class="clickable-logo" onclick="window.location.href='/lugaresrecomendados'">Parchate</div>
        <div style="width: 24px;"></div>
    </header>

    <div class="topbar">
        <a href="{{ url('/lugares-guardados') }}?orden={{ request('orden') === 'asc' ? 'desc' : 'asc' }}&buscar={{ request('buscar') }}" class="ordenar">
            <span class="flecha">{{ request('orden') === 'asc' ? '↑' : '↓' }}</span>
            <span class="texto">Mas nuevo</span>
        </a>

        <form class="search-box" method="GET" action="{{ url('/lugares-guardados') }}">
            <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar...">
            <input type="hidden" name="orden" value="{{ request('orden', 'desc') }}">
            <button type="submit" class="buscar-btn">Buscar</button>
        </form>
    </div>

    <div class="grid">
        @foreach($sucursales as $favorito)
            @if ($favorito->sucursal)
                <div class="card">
                    <img src="{{ asset('storage/sucursal/' . ($favorito->sucursal->imagenes->first()->imagen ?? 'bulevaro.png')) }}">
                    <div class="card-body">
                        <h3>{{ $favorito->sucursal->nombre_sucursal }}</h3>
                        <p><strong>📍</strong> {{ $favorito->sucursal->ubicacion_dada_sucursal }}</p>
                        <p><strong>Descripción:</strong><br>
                            {{ $favorito->sucursal->descripcion_sucursal }}
                        </p>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</body>
</html>
