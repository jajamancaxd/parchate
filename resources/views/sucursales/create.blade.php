<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear nueva sucursal</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f8f8f8; padding: 30px; }
        h2 { color: #ff6600; text-align: center; }
        form { max-width: 680px; margin: auto; background: white; padding: 28px 40px 40px 40px; border-radius: 16px; box-shadow: 0 2px 10px #0001; }
        label { display: block; margin-top: 21px; color: #333; font-weight: 500; }
        input[type="text"], input[type="number"], textarea, select { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px; margin-top: 6px; }
        textarea { resize: vertical; }
        input[type="file"] { margin-top: 7px; }
        .error { color: #f00; background: #fff0f0; border: 1px solid #f99; padding: 7px 12px; border-radius: 4px; margin-bottom: 23px; }
        .acciones { margin-top: 32px; display: flex; gap: 18px; }
        .acciones button, .acciones a { background: #ff6600; color: #fff; border: none; border-radius: 6px; padding: 11px 20px; text-decoration: none; font-weight: bold; cursor: pointer; }
        .acciones a { background: #bbb; color: #222; }
        .productos-group > div { display: flex; gap: 9px; margin-top: 9px; }
        .productos-group input[type="text"], .productos-group input[type="number"] { width: 48%; }
        .productos-group button { padding: 0 8px; font-size: 18px; background: #ff6600; color: #fff; border: none; border-radius: 4px; }
        select[multiple] { height: 102px; }
        .descripcion-campo { font-size: 12px; color: #888; margin-bottom: 2px; }
    </style>
</head>
<body>
    <h2>Crear nueva sucursal</h2>
    @if($errors->any())
        <div class="error">
            <ul>@foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
    @endif

    <form action="{{ route('sucursales.store') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
        @csrf

        <label>Nombre sucursal:</label>
        <div class="descripcion-campo">Ingrese el nombre de la sucursal que desea publicar.</div>
        <input type="text" name="nombre_sucursal" value="{{ old('nombre_sucursal') }}" required>

        <label>Descripción de sucursal:</label>
        <div class="descripcion-campo">Describa las actividades, productos y/o servicios que ofrece la sucursal.</div>
        <textarea name="descripcion_sucursal" required>{{ old('descripcion_sucursal') }}</textarea>

        <label>Imagen principal (portada):</label>
        <div class="descripcion-campo">Suba la imagen de portada de la sucursal (se verá en la tarjeta principal).</div>
        <input type="file" name="imagen_principal" required accept="image/*">

        <label>Imágenes de muestra:</label>
        <div class="descripcion-campo">Suba imágenes de su establecimiento, productos o de la sucursal en funcionamiento.</div>
        <input type="file" name="imagenes_muestra[]" multiple accept="image/*">

        <label>Tipo de lugar (puede seleccionar varios):</label>
        <div class="descripcion-campo">Seleccione las etiquetas que describen el tipo de lugar de su sucursal.</div>
            <select id="tipo_sucursal" name="tipo_sucursal[]" multiple required>
                @foreach($tipos as $tipo)
                    <option value="{{ $tipo->id_tipo_de_sucursal }}">{{ $tipo->tipo_de_sucursal }}</option>
                @endforeach
            </select>

        <label>Tabla de precios (productos o servicios):</label>
        <div class="descripcion-campo">Agregue los productos y/o servicios ofrecidos con su respectivo precio.</div>
        <div class="productos-group" id="productos">
            <div>
                <input type="text" name="productos[0][nombre]" placeholder="Producto o servicio" required>
                <input type="number" name="productos[0][precio]" placeholder="Precio" min="0" required>
                <button type="button" onclick="agregarProducto()">+</button>
            </div>
        </div>

        <label>Día de servicio:</label>
        <div class="descripcion-campo">
            Seleccione la etiqueta que describa en qué días funciona la sucursal (solo una opción).
        </div>
        <select name="dia_de_servicio" required>
            @foreach($dias as $dia)
                <option value="{{ $dia->id_dia_de_servicio }}">{{ $dia->dias_de_servicios }}</option>
            @endforeach
        </select>

        <label>Horario de servicio:</label>
        <div class="descripcion-campo">
            Seleccione el horario en el que funciona la sucursal (solo una opción).
        </div>
        <select name="horario_de_servicio" required>
            <option value="Madrugada: de 00:00 a 5:00">Madrugada: de 00:00 a 5:00</option>
            <option value="Mañana: de 5:00 a 12:00">Mañana: de 5:00 a 12:00</option>
            <option value="Tarde: de 12:00 a 18:00">Tarde: de 12:00 a 18:00</option>
            <option value="Noche: de 18:00 a 00:00">Noche: de 18:00 a 00:00</option>
            <option value="24 horas">24 horas</option>
        </select>

        <label>Ubicación sucursal:</label>
        <div class="descripcion-campo">Ingrese la ubicación donde se encuentra la sucursal.</div>
        <input type="text" name="ubicacion_dada_sucursal" value="{{ old('ubicacion_dada_sucursal') }}" required>

        <div class="acciones">
            <button type="submit">Publicar</button>
            <a href="{{ route('sucursales.negocio') }}">Cancelar</a>
        </div>
    </form>

    <script>
        let index = 1;
        function agregarProducto() {
            let div = document.createElement('div');
            div.innerHTML = `<input type="text" name="productos[${index}][nombre]" placeholder="Producto o servicio" required>
                             <input type="number" name="productos[${index}][precio]" placeholder="Precio" min="0" required>
                             <button type="button" onclick="this.parentNode.remove()">-</button>`;
            document.getElementById('productos').appendChild(div);
            index++;
        }
        
        document.addEventListener('DOMContentLoaded', function () {
        $('#tipo_sucursal').select2({
            placeholder: "Selecciona uno o varios tipos",
            width: '100%'
        });
    });
    </script>
</body>
</html>
