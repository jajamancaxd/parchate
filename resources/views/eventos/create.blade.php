<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear nuevo evento</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f8f8;
            padding: 30px;
            margin: 0;
        }

        h2 {
            color: #ff6600;
            text-align: center;
        }

        form {
            max-width: 680px;
            margin: auto;
            background: white;
            padding: 28px 40px 40px 40px;
            border-radius: 16px;
            box-shadow: 0 2px 10px #0001;
        }

        label {
            display: block;
            margin-top: 21px;
            color: #333;
            font-weight: 500;
        }

        input[type="text"], input[type="number"], input[type="date"], input[type="time"], textarea, select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 6px;
        }

        textarea {
            resize: vertical;
        }

        input[type="file"] {
            margin-top: 7px;
        }

        .acciones {
            margin-top: 32px;
            display: flex;
            gap: 18px;
        }

        .acciones button, .acciones a {
            background: #ff6600;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 11px 20px;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
        }

        .acciones a {
            background: #bbb;
            color: #222;
        }

        .productos-group > div {
            display: flex;
            gap: 9px;
            margin-top: 9px;
        }

        .productos-group input[type="text"], .productos-group input[type="number"] {
            width: 48%;
        }

        .productos-group button {
            padding: 0 8px;
            font-size: 18px;
            background: #ff6600;
            color: #fff;
            border: none;
            border-radius: 4px;
        }

        select[multiple] {
            height: 102px;
        }

        .descripcion-campo {
            font-size: 12px;
            color: #888;
            margin-bottom: 2px;
        }

        #loader-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(255, 255, 255, 0.85);
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .loader {
            border: 6px solid #f3f3f3;
            border-top: 6px solid #ff6600;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .loader-text {
            margin-top: 15px;
            color: #ff6600;
            font-weight: 600;
            font-size: 16px;
        }
    </style>
</head>
<body>
<h2>Crear nuevo evento</h2>

<form action="{{ route('eventos.store') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
    @csrf

    <label>Nombre del evento:</label>
    <div class="descripcion-campo">Ingrese el nombre del evento.</div>
    <input type="text" name="nombre_evento" required>

    <label>Descripción del evento:</label>
    <div class="descripcion-campo">Describa los detalles, temática y lo que ofrece el evento.</div>
    <textarea name="descripcion_evento" required></textarea>

    <label>Imagen de portada:</label>
    <div class="descripcion-campo">Suba la imagen principal del evento (tarjeta principal).</div>
    <input type="file" name="imagen_portada" accept="image/*" required>

    <label>Imágenes de muestra:</label>
    <div class="descripcion-campo">Suba imágenes adicionales del evento.</div>
    <input type="file" name="imagenes_muestra[]" multiple accept="image/*">

    <label>Etiquetas del evento:</label>
    <div class="descripcion-campo">Seleccione las categorías o tipos de evento.</div>
    <select name="tipos_evento[]" multiple required>
        @foreach($tipos as $tipo)
            <option value="{{ $tipo->id_tipo_evento }}">{{ $tipo->tipo_de_evento }}</option>
        @endforeach
    </select>

    <label>Productos / Servicios:</label>
    <div class="descripcion-campo">Agregue productos o servicios ofrecidos durante el evento.</div>
    <div class="productos-group" id="productos">
        <div>
            <input type="text" name="productos[0][nombre]" placeholder="Producto o servicio" required>
            <input type="number" name="productos[0][precio]" placeholder="Precio" min="0" required>
            <button type="button" onclick="agregarProducto()">+</button>
        </div>
    </div>

    <label>Fecha y hora de inicio:</label>
    <div class="descripcion-campo">Seleccione cuándo comenzará el evento.</div>
    <input type="date" name="fecha_inicio_evento" required>
    <input type="time" name="hora_inicio_evento" required>

    <label>Ubicación del evento:</label>
    <div class="descripcion-campo">Ingrese la dirección o punto de encuentro del evento.</div>
    <input type="text" name="ubicacion_dada_evento" required>

    <div class="acciones">
        <button type="submit">Publicar</button>
        <a href="{{ route('eventos.index') }}">Cancelar</a>
    </div>
</form>

<div id="loader-overlay">
    <div class="loader"></div>
    <div class="loader-text">Publicando...</div>
</div>

<script>
    let index = 1;
    function agregarProducto() {
        const div = document.createElement('div');
        div.innerHTML = `
            <input type="text" name="productos[${index}][nombre]" placeholder="Producto o servicio" required>
            <input type="number" name="productos[${index}][precio]" placeholder="Precio" min="0" required>
            <button type="button" onclick="this.parentNode.remove()">-</button>
        `;
        document.getElementById('productos').appendChild(div);
        index++;
    }

    document.querySelector('form').addEventListener('submit', function () {
        document.getElementById('loader-overlay').style.display = 'flex';
    });
</script>
</body>
</html>
