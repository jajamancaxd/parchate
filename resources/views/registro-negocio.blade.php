<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Registro de negocio</title>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      margin: 0;
      padding: 0;
      background: #fff;
    }

    header {
      background-color: #ff6600;
      padding: 1rem;
      color: white;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    header h1 {
      margin: 0;
      font-size: 1.2rem;
    }

    .back-btn {
      background: none;
      border: none;
      font-size: 1.5rem;
      color: white;
      cursor: pointer;
    }

    main {
      padding: 1.5rem;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }

    label {
      font-weight: bold;
    }

    input[type="text"],
    input[type="file"],
    textarea {
      width: 100%;
      padding: 0.8rem;
      border: 1px solid #ccc;
      border-radius: 8px;
    }

    textarea {
      height: 120px;
      resize: none;
    }

    .file-preview {
      width: 140px;
      height: 100px;
      border: 1px solid #ccc;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .file-preview img {
      width: 40px;
      height: 40px;
    }

    .btn {
      background-color: #ff6600;
      color: white;
      padding: 0.5rem 1rem;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      width: fit-content;
    }

    .btn.outline {
      background: transparent;
      color: #ff6600;
      border: 1px solid #ff6600;
    }

    .btn.primary {
      background-color: #ff6600;
    }

    .form-actions {
      display: flex;
      gap: 2rem;
      margin-top: 2rem;
      justify-content: center;
    }

    .alert {
      padding: 1rem;
      border-radius: 5px;
      margin-bottom: 1rem;
    }

    .alert-success {
      background-color: #d4edda;
      color: #155724;
    }

    .alert-danger {
      background-color: #f8d7da;
      color: #721c24;
    }
  </style>
</head>
<body>
  <header>
    <a href="/register"><button class="back-btn">&larr;</button></a>
    <h1>Registro de negocio</h1>
    <div class="icon-location"></div>
  </header>

  <main>
    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

    @if($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form id="businessForm" method="POST" action="{{ route('registro.negocio.store') }}" enctype="multipart/form-data">
      @csrf 

      <label for="nombre_negocio">Nombre del negocio</label>
      <input type="text" id="nombre_negocio" name="nombre_negocio" placeholder="Ingresa el nombre del negocio" required />

      <label for="descripcion_negocio">Descripción del negocio</label>
      <textarea id="descripcion_negocio" name="descripcion_negocio" placeholder="Describe tu negocio" required></textarea>

     <label for="ruta_imagen_logo">Logo del negocio</label>
      <div class="file-preview" id="logoPreview">
      <img src="https://img.icons8.com/ios/50/image--v1.png" alt="placeholder" />
      </div>
      <input type="file" id="ruta_imagen_logo" name="ruta_imagen_logo" accept="image/*" hidden>
        <button type="button" class="btn" onclick="document.getElementById('ruta_imagen_logo').click()">Subir logo</button>

      <label for="ruta_documentos_negocios">Cédula del dueño del negocio</label>
      <div class="file-preview" id="cedulaPreview">
        <img src="https://img.icons8.com/ios/50/image--v1.png" alt="placeholder" />
      </div>
      <input type="file" id="ruta_documentos_negocios" name="ruta_documentos_negocios" accept="image/*" hidden />
      <button type="button" class="btn" onclick="document.getElementById('ruta_documentos_negocios').click()">Subir documento del negocio</button>

      <div class="form-actions">
        <button type="submit" class="btn primary">Registrar</button>
        <a href="/register"><button type="button" class="btn outline">Cancelar</button></a>
      </div>
    </form>
  </main>

  <script>
    function cancelarFormulario() {
      if (confirm("¿Estás seguro de que deseas cancelar?")) {
        window.location.reload();
      }
    }
  </script>
</body>
</html>
