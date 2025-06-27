<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Editar Evento</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'poppins', sans-serif;
      font-size: 14px;
      background: #f8f8f8;
      margin: 0;
      padding: 0;
    }
    label,
    input,
    select,
    button,
    textarea,
    .multi-select-container {
      font-family: 'Poppins', sans-serif;
      font-size: 14px;
    }

    .container {
      max-width: 700px;
      margin: auto;
      background: #fff;
      padding: 20px 30px;
    }

    header {
      max-width: 728px;
      margin: 20px auto 0 auto;
      background-color: #ff6600;
      color: white;
      padding: 15px;
      text-align: center;
      position: relative;
      font-size: 18px;
      font-weight: bold;
      border-radius: 6px 6px 0 0;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .back-button {
      position: absolute;
      left: 20px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      font-size: 24px;
      color: white;
      padding: 5px;
      border-radius: 4px;
    }
    .back-button:hover {
        background-color: rgba(255, 255, 255, 0.2);
    }

    .logo {
      height: 50px;
      position: absolute;
      right: 20px;
      top: 50%;
      transform: translateY(-50%);
    }

    label {
      font-weight: bold;
      margin-bottom: 6px;
      display: inline-block;
    }

    .section {
      margin-bottom: 20px;
    }

    input,
    textarea,
    select {
      width: 100%;
      margin-bottom: 10px;
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 14px;
    }

    textarea {
      resize: vertical;
      min-height: 80px;
    }

    .image-upload {
      display: flex;
      gap: 15px;
      flex-wrap: wrap;
      margin: 10px 0;
      justify-content: flex-start;
      align-items: flex-start;
      width: 100%;
    }

    .image-upload > div {
      width: 150px;
      height: 100px;
      border: 1px solid #ccc;
      border-radius: 8px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      background: #fff;
      cursor: pointer;
      overflow: hidden;
      position: relative;
      padding: 5px;
      box-sizing: border-box;
      flex-shrink: 0;
      box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .image-upload > div:hover {
        background-color: #f9f9f9;
    }

    .image-upload .bi-image {
      font-size: 48px;
      color: #999;
    }

    .image-upload .upload-text {
        display: none;
    }

    .image-upload .loaded-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 6px;
        position: absolute;
        top: 0;
        left: 0;
    }

    .image-upload .fa-times-circle {
        position: absolute;
        top: 5px;
        right: 5px;
        color: red;
        cursor: pointer;
        font-size: 18px;
        background-color: white;
        border-radius: 50%;
        z-index: 10;
        padding: 2px;
        box-shadow: 0 0 3px rgba(0,0,0,0.3);
    }

    small {
      display: block;
      color: #000;
      opacity: 0.5;
      margin-bottom: 8px;
      font-size: 13px;
    }

    .add-btn,
    .average-btn {
      background-color: #ff6600;
      color: white;
      border: none;
      padding: 7px 14px;
      border-radius: 6px;
      cursor: pointer;
      margin-top: 10px;
      font-size: 14px;
    }

    .multi-select-container,
    .single-select-container {
      position: relative;
      width: fit-content;
      margin-top: 5px;
    }

    .multi-select-header,
    .single-select-header {
      border: 1px solid #ccc;
      padding: 8px 12px;
      border-radius: 6px;
      background: #fff;
      cursor: pointer;
      display: flex;
      justify-content: space-between;
      align-items: center;
      min-height: 20px;
      width: fit-content;
      min-width: 200px;
      max-width: 300px;
    }

    .multi-select-options,
    .single-select-options {
      display: none;
      position: absolute;
      width: fit-content;
      min-width: 200px;
      max-width: 300px;
      border: 1px solid #ccc;
      border-top: none;
      background: #fff;
      z-index: 100;
      max-height: 150px;
      overflow-y: auto;
      border-radius: 0 0 6px 6px;
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .multi-select-option,
    .single-select-option {
      padding: 6px 12px;
      cursor: pointer;
      position: relative;
      padding-left: 25px;
    }

    .multi-select-option:before,
    .single-select-option:before {
      content: "•";
      position: absolute;
      left: 10px;
      color: #ff6600;
    }

    .multi-select-option.selected,
    .single-select-option.selected {
      background-color: #ff6600;
      color: white;
    }

    .multi-select-option.selected:before,
    .single-select-option.selected:before {
      color: white;
    }

    .multi-select-option:hover:not(.selected),
    .single-select-option:hover:not(.selected) {
      background-color: #f5f5f5;
    }

    .multi-select-container.open .multi-select-options,
    .single-select-container.open .single-select-options {
      display: block;
    }

    .selected-tags {
      display: flex;
      flex-wrap: wrap;
      gap: 5px;
      margin-top: 5px;
    }

    .selected-tag {
      background: #ff6600;
      color: white;
      padding: 3px 8px;
      border-radius: 12px;
      font-size: 12px;
      display: flex;
      align-items: center;
    }

    .selected-tag i {
      margin-left: 5px;
      cursor: pointer;
      font-size: 10px;
    }

    .single-select-tag {
      background: #ff6600;
      color: white;
      padding: 3px 8px;
      border-radius: 12px;
      font-size: 12px;
      display: inline-flex;
      align-items: center;
      margin-top: 5px;
    }

    .single-select-tag i {
      margin-left: 5px;
      cursor: pointer;
      font-size: 10px;
    }

    .date-input-wrapper {
      display: flex;
      align-items: center;
      border: 1px solid #ccc;
      border-radius: 6px;
      padding: 4px 10px;
      margin-bottom: 10px;
      background-color: #fff;
    }

    .date-input-wrapper input[type="date"] {
      border: none;
      outline: none;
      flex: 1;
      padding: 0;
      margin-bottom: 0;
      background: transparent;
      text-align: left;
      margin-right: 8px;

      -webkit-appearance: none !important;
      -moz-appearance: none !important;
      appearance: none !important;
      background-image: none !important;

      &::-webkit-inner-spin-button,
      &::-webkit-calendar-picker-indicator {
          display: none !important;
          -webkit-appearance: none !important;
      }
    }

    .date-input-wrapper .bi-calendar3 {
      margin-left: auto;
      color: #555;
      font-size: 18px;
      cursor: pointer;
    }

    .date-group {
      display: flex;
      gap: 60px;
      margin-top: 6px;
      margin-bottom: 10px;
      align-items: flex-start;
    }

    .date-picker {
      display: flex;
      flex-direction: column;
      width: 180px;
    }

    .service-row {
      display: flex;
      gap: 10px;
      margin-bottom: 10px;
    }

    .service-row input {
      flex: 1;
      font-size: 14px;
      padding: 8px 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }

    .service-row button {
      background-color: #ff6600;
      color: white;
      border: none;
      padding: 0 10px;
      border-radius: 4px;
      cursor: pointer;
    }

    .service-buttons {
      display: flex;
      flex-direction: column;
      gap: 10px;
      margin-top: 10px;
      align-items: flex-start;
    }

    .submit-buttons {
      display: flex;
      gap: 15px;
      margin-top: 25px;
      justify-content: center;
      width: 100%;
    }

    .submit-buttons button {
      flex-grow: 0;
      flex-shrink: 0;
      width: 140px;
      padding: 8px 15px;
      border: none;
      border-radius: 25px;
      cursor: pointer;
      font-weight: bold;
      font-size: 15px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .submit-buttons .publish {
      background-color: #ff6600;
      color: white;
      border: 1px solid #ff6600;
    }

    .submit-buttons .cancel {
      background-color: #fff;
      color: #ff6600;
      border: 1px solid #ff6600;
    }

    .average {
      color: black;
      font-weight: bold;
      margin-top: 10px;
    }

    .average-price {
      color: orange;
    }

    input[type="file"] {
      display: none;
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
    <div class="section">
      <label>Nombre del Evento</label>
      <input type="text" name="nombre_evento" value="{{ $evento->nombre_evento }}" required>
    </div>
    <div class="section">
      <label>Descripción del Evento</label>
      <textarea name="descripcion_evento" required>{{ $evento->descripcion_evento }}</textarea>
    </div>
    <div class="section">
      <label>Imagen de Portada</label>
      <input type="file" name="imagen_portada" accept="image/*">
      @if($evento->imagenes->first())
        <img src="{{ asset('storage/' . $evento->imagenes->first()->ruta_imagen_evento) }}" alt="Imagen actual" width="100">
      @endif
    </div>
    <div class="section">
      <label>Agregar más Imágenes de Muestra</label>
      <input type="file" name="imagenes_muestra[]" multiple accept="image/*">
    </div>
    <div class="section">
      <label>Etiquetas del Evento</label>
      <select name="tipos_evento[]" multiple required>
        @foreach($tipos as $tipo)
          <option value="{{ $tipo->id_tipo_evento }}" {{ in_array($tipo->id_tipo_evento, $evento->tipos->pluck('id_tipo_evento')->toArray()) ? 'selected' : '' }}>
            {{ $tipo->tipo_de_evento }}
          </option>
        @endforeach
      </select>
    </div>
    <div class="section">
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
    </div>
    <div class="section date-group">
      <div class="date-picker">
        <label>Fecha de Inicio</label>
        <input type="date" name="fecha_inicio_evento" value="{{ $evento->fecha_inicio_evento }}" required>
      </div>
      <div class="date-picker">
        <label>Hora de Inicio</label>
        <input type="time" name="hora_inicio_evento" value="{{ $evento->hora_inicio_evento }}" required>
      </div>
    </div>
    <div class="section">
      <label>Ubicación del Evento</label>
      <input type="text" name="ubicacion_dada_evento" value="{{ $evento->ubicacion_dada_evento }}" required>
    </div>
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