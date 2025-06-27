<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar sucursal</title>
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
    <h2>Editar sucursal</h2>
    @if($errors->any())
        <div class="error">
            <ul>@foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
    @endif

    <form action="{{ route('sucursales.update', $sucursal->id_sucursal) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label>Nombre sucursal:</label>
        <input type="text" name="nombre_sucursal" value="{{ old('nombre_sucursal', $sucursal->nombre_sucursal) }}" required>

        <label>Descripción de sucursal:</label>
        <textarea name="descripcion_sucursal" required>{{ old('descripcion_sucursal', $sucursal->descripcion_sucursal) }}</textarea>

        <label>Imagen principal actual:</label>
        @php
            $imagenPrincipal = $sucursal->imagenesSucursal->firstWhere('imagen_sucursal_orden', 'principal');
        @endphp
        @if($imagenPrincipal)
            <img src="{{ asset('storage/' . $imagenPrincipal->ruta_imagen_sucursal) }}" style="max-width: 100%; max-height: 150px; margin-top: 10px;">
        @endif
        <br>
        <label>Reemplazar imagen principal:</label>
        <input type="file" name="imagen_principal" accept="image/*">

        <label>Tipo de lugar:</label>
        <select name="tipo_sucursal[]" multiple required>
            @foreach($tipos as $tipo)
                <option value="{{ $tipo->id_tipo_de_sucursal }}"
                    {{ $sucursal->tipos->contains('id_tipo_de_sucursal', $tipo->id_tipo_de_sucursal) ? 'selected' : '' }}>
                    {{ $tipo->tipo_de_sucursal }}
                </option>
            @endforeach
        </select>

        <label>Tabla de precios (productos o servicios):</label>
        <div class="productos-group" id="productos">
            @foreach($sucursal->productos as $i => $producto)
                <div>
                    <input type="text" name="productos[{{ $i }}][nombre]" value="{{ $producto->nombre_producto_sucursal }}" required>
                    <input type="number" name="productos[{{ $i }}][precio]" value="{{ $producto->precio_producto_sucursal }}" required>
                    <button type="button" onclick="this.parentNode.remove()">-</button>
                </div>
            @endforeach
        </div>
        <button type="button" onclick="agregarProducto()">+ Agregar producto</button>

        <label>Día de servicio:</label>
        <select name="dia_de_servicio" required>
            @foreach($dias as $dia)
                <option value="{{ $dia->id_dia_de_servicio }}"
                    {{ $sucursal->id_dia_de_servicio == $dia->id_dia_de_servicio ? 'selected' : '' }}>
                    {{ $dia->dias_de_servicios }}
                </option>
            @endforeach
        </select>

        <label>Horario de servicio:</label>
        @php
            $horarioActual = optional($sucursal->horariosDeApertura)->horario;
        @endphp
        <select name="horario_de_servicio" required>
            @foreach(['Madrugada: de 00:00 a 5:00','Mañana: de 5:00 a 12:00','Tarde: de 12:00 a 18:00','Noche: de 18:00 a 00:00','24 horas'] as $horario)
                <option value="{{ $horario }}" {{ $horarioActual === $horario ? 'selected' : '' }}>{{ $horario }}</option>
            @endforeach
        </select>

        <label>Ubicación sucursal:</label>
        <input type="text" name="ubicacion_dada_sucursal" value="{{ old('ubicacion_dada_sucursal', $sucursal->ubicacion_dada_sucursal) }}" required>

        <div class="acciones">
            <button type="submit">Guardar cambios</button>
            <a href="{{ route('sucursales.index') }}">Cancelar</a>
        </div>
    </form>

    <script>
        let index = {{ $sucursal->productos->count() }};
        function agregarProducto() {
            let div = document.createElement('div');
            div.innerHTML = `<input type="text" name="productos[${index}][nombre]" placeholder="Producto o servicio" required>
                             <input type="number" name="productos[${index}][precio]" placeholder="Precio" min="0" required>
                             <button type="button" onclick="this.parentNode.remove()">-</button>`;
            document.getElementById('productos').appendChild(div);
            index++;
        }
    </script>
</body>
</html>
