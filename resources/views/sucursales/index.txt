<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sucursales Guardadas</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 20px;
        }

        header {
            background-color: #ff6600;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .sucursal-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .sucursal-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            overflow: hidden;
            transition: transform 0.2s;
        }

        .sucursal-card:hover {
            transform: scale(1.02);
        }

        .sucursal-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }

        .sucursal-info {
            padding: 10px;
        }

        .sucursal-info h3 {
            margin: 0;
            font-size: 16px;
            color: #ff6600;
        }

        .sucursal-info p {
            font-size: 13px;
            margin: 5px 0;
        }

        .edit-button {
            display: inline-block;
            margin-top: 10px;
            padding: 5px 10px;
            background-color: #ff6600;
            color: white;
            border-radius: 4px;
            text-decoration: none;
        }

        .no-sucursales {
            text-align: center;
            font-style: italic;
            color: #666;
        }

        .btn-crear {
            display: block;
            margin: 30px auto 0;
            padding: 10px 20px;
            background-color:  #ff6600;
            color: white;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            text-align: center;
            width: fit-content;
        }
    </style>
</head>
<body>

<header>Sucursales </header>

@if(session('success'))
    <div style="color: green; text-align: center; font-weight: bold;">{{ session('success') }}</div>
@endif

@if ($sucursales->isEmpty())
    <p class="no-sucursales">No hay sucursales registradas.</p>
@else
    <div class="sucursal-container">
        @foreach($sucursales as $sucursal)
            <div class="sucursal-card">
                @if($sucursal->imagenesSucursal->isNotEmpty())
                    <img src="{{ asset('storage/' . $sucursal->imagenesSucursal[0]->ruta_imagen_sucursal) }}" alt="Imagen de la sucursal">
                @else
                    <img src="{{ asset('img/sin-imagen.png') }}" alt="Sin imagen">
                @endif
                <div class="sucursal-info">
                    <h3>{{ $sucursal->nombre_sucursal }}</h3>
                    <p>{{ Str::limit($sucursal->descripcion_sucursal, 50) }}</p>
                    <a href="{{ route('sucursales.edit', ['sucursal' => $sucursal->id_sucursal]) }}" class="edit-button">Modificar</a>
                </div>
            </div>
        @endforeach
    </div>
@endif

<a href="{{ route('sucursales.create') }}" class="btn-crear">Crear nueva sucursal</a>

</body>
</html>

