<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Crear Sucursal</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <h1>Crear Nueva Sucursal</h1>

    <form action="{{ route('sucursal.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label for="nombre_sucursal">Nombre:</label>
        <input type="text" name="nombre_sucursal" required><br><br>

        <label for="descripcion_sucursal">Descripción:</label>
        <textarea name="descripcion_sucursal" required></textarea><br><br>

        <label for="ubicacion_dada_sucursal">Ubicación:</label>
        <input type="text" name="ubicacion_dada_sucursal" required><br><br>

        <label for="imagen">Imagen:</label>
        <input type="file" name="imagen" accept="image/*" required><br><br>

        <button type="submit">Guardar</button>
    </form>

    <a href="{{ route('inicio') }}">Volver al inicio</a>
</body>
</html>
