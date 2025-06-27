<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Editar Evento</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f8f8f8;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 700px;
      margin: auto;
      background: #fff;
      padding: 30px 40px;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    header {
      background-color: #ff6600;
      color: white;
      padding: 15px;
      text-align: center;
      font-size: 20px;
      font-weight: bold;
      border-radius: 0 0 12px 12px;
      position: relative;
    }

    .back-button {
      position: absolute;
      left: 20px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 22px;
      color: white;
      text-decoration: none;
    }

    label {
      display: block;
      margin-top: 20px;
      font-weight: bold;
    }

    input, textarea, select {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 8px;
      margin-top: 6px;
      font-size: 14px;
      box-sizing: border-box;
    }

    textarea {
      resize: vertical;
      min-height: 100px;
    }

    .img-preview {
      margin-top: 10px;
      max-width: 100px;
      border-radius: 8px;
    }

    .submit-buttons {
      display: flex;
      justify-content: center;
      gap: 20px;
      margin-top: 30px;
    }

    .submit-buttons button,
    .submit-buttons a {
      width: 160px;
      padding: 10px 20px;
      border-radius: 25px;
      font-weight: bold;
      font-size: 15px;
      text-align: center;
      cursor: pointer;
      text-decoration: none;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      transition: all 0.3s ease;
    }

    .submit-buttons .publish {
      background-color: #ff6600;
      color: white;
      border: none;
    }

    .submit-buttons .publish:hover {
      background-color: #e05500;
    }

    .submit-buttons .cancel {
      background-color: white;
      color: #ff6600;
      border: 2px solid #ff6600;
    }

    .submit-buttons .cancel:hover {
      background-color: #ffece0;
    }

    .service-row {
      display: flex;
      gap: 10px;
      margin-top: 10px;
    }

    .service-row input {
      flex: 1;
    }

    .add-btn {
      background-color: #ff6600;
      color: white;
      border: none;
      padding: 8px 16px;
      border-radius: 8px;
      cursor: pointer;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <header>
    <a href="{{ route('eventos.index') }}" class="back-button">&larr;</a>
    Editar Evento
  </header>

  <div class="container">
    <form action="{{ route('eventos.update', $evento->id_evento) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <label>Nombre del Evento</label>
      <input type="text" name="nombre_evento" value="{{ $evento->nombre_evento }}" required>

      <label>Descripción</label>
      <textarea name="descripcion_evento" required>{{ $evento->descripcion_evento }}</textarea>

      <label>Imagen de Portada</label>
      <input type="file" name="imagen_portada" accept="image/*">
      @if($evento->imagenes->first())
        <img class="img-preview" src="{{ asset('storage/' . $evento->imagenes->first()->ruta_imagen_evento) }}" alt="Imagen actual">
      @endif

      <label>Agregar Imágenes de Muestra</label>
      <input type="file" name="imagenes_muestra[]" multiple accept="image/*">

      <label>Etiquetas del Evento</label>
      <select name="tipos_evento[]" multiple required>
        @foreach($tipos as $tipo)
          <option value="{{ $tipo->id_tipo_evento }}" {{ in_array($tipo->id_tipo_evento, $evento->tipos->pluck('id_tipo_evento')->toArray()) ? 'selected' : '' }}>
            {{ $tipo->tipo_de_evento }}
          </option>
        @endforeach
      </select>

      <label>Productos / Servicios</label>
      <div id="productos-container">
        @foreach($evento->productos as $i => $producto)
          <div class="service-row">
            <input type="text" name="productos[{{ $i }}][nombre]" value="{{ $producto->nombre_producto_evento }}" required>
            <input type="number" name="productos[{{ $i }}][precio]" value="{{ $producto->precio_producto_evento }}" required>
          </div>
        @endforeach
      </div>
      <button type="button" class="add-btn" onclick="agregarProducto()">Agregar otro</button>

      <label>Fecha de Inicio</label>
      <input type="date" name="fecha_inicio_evento" value="{{ $evento->fecha_inicio_evento }}" required>

      <label>Hora de Inicio</label>
      <input type="time" name="hora_inicio_evento" value="{{ $evento->hora_inicio_evento }}" required>

      <label>Ubicación</label>
      <input type="text" name="ubicacion_dada_evento" value="{{ $evento->ubicacion_dada_evento }}" required>

      <div class="submit-buttons">
        <a href="{{ route('eventos.index') }}" class="cancel">Cancelar</a>
        <button type="submit" class="publish">Guardar Cambios</button>
      </div>
    </form>
  </div>

  <script>
    let count = {{ count($evento->productos) }};
    function agregarProducto() {
      const container = document.getElementById('productos-container');
      const div = document.createElement('div');
      div.className = 'service-row';
      div.innerHTML = `
        <input type="text" name="productos[${count}][nombre]" placeholder="Nombre del producto" required>
        <input type="number" name="productos[${count}][precio]" placeholder="Precio" required>
      `;
      container.appendChild(div);
      count++;
    }
  </script>
</body>
</html>
