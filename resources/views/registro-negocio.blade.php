<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Registro de negocio</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f7f7f7;
    }

    header {
      background-color: #f35c0c;
      color: white;
      padding: 1rem 1.5rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    header h1 {
      font-size: 1.4rem;
      margin: 0;
    }

    .back-btn {
      background: none;
      border: none;
      font-size: 1.6rem;
      color: white;
      cursor: pointer;
    }

    main {
      padding: 2rem 1.5rem;
      max-width: 600px;
      margin: 0 auto;
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      margin-top: 2rem;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 1.2rem;
    }

    label {
      font-weight: bold;
      color: #333;
    }

    input[type="text"],
    input[type="file"],
    textarea {
      width: 100%;
      padding: 0.9rem 1rem;
      border: 1px solid #ccc;
      border-radius: 10px;
      font-size: 15px;
      background-color: #fafafa;
    }

    textarea {
      height: 120px;
      resize: none;
    }

    .file-preview {
      width: 150px;
      height: 110px;
      background-color: #f0f0f0;
      border: 1px dashed #bbb;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      margin-bottom: 0.5rem;
    }

    .file-preview img {
      width: 100%;
      height: 100%;
      object-fit: contain;
    }

    .btn {
      padding: 10px 18px;
      font-weight: bold;
      font-size: 15px;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .btn.primary {
      background-color: #f35c0c;
      color: white;
      border: none;
    }

    .btn.primary:hover {
      background-color: #d84e00;
    }

    .btn.outline {
      background-color: transparent;
      color: #f35c0c;
      border: 2px solid #f35c0c;
    }

    .btn.outline:hover {
      background-color: #f35c0c;
      color: white;
    }

    .form-actions {
      display: flex;
      gap: 1.5rem;
      justify-content: center;
      margin-top: 1rem;
    }

    .alert {
      padding: 1rem;
      border-radius: 8px;
      font-size: 14px;
      margin-bottom: 1.2rem;
    }

    .alert-success {
      background-color: #d4edda;
      color: #155724;
    }

    .alert-danger {
      background-color: #f8d7da;
      color: #721c24;
    }

    @media (max-width: 480px) {
      .form-actions {
        flex-direction: column;
        gap: 0.8rem;
      }

      .file-preview {
        width: 100%;
        height: 120px;
      }
    }
  </style>
</head>
<body>

  <header>
    <a href="/register"><button class="back-btn">&larr;</button></a>
    <h1>Registro de negocio</h1>
    <div></div>
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
      <input type="text" id="nombre_negocio" name="nombre_negocio" placeholder="Ej: Tienda Bulevar" required />

      <label for="descripcion_negocio">Descripción del negocio</label>
      <textarea id="descripcion_negocio" name="descripcion_negocio" placeholder="Describe tu negocio aquí..." required></textarea>

      <label for="ruta_imagne_logo">Logo del negocio</label>
      <div class="file-preview" id="logoPreview">
        <img src="https://img.icons8.com/ios/50/image--v1.png" alt="preview logo" />
      </div>
      <input type="file" id="ruta_imagne_logo" name="ruta_imagne_logo" accept="image/*" hidden />
      <button type="button" class="btn outline" onclick="document.getElementById('ruta_imagne_logo').click()">Subir logo</button>

      <label for="ruta_documentos_negocios">Cédula del dueño del negocio</label>
      <div class="file-preview" id="cedulaPreview">
        <img src="https://img.icons8.com/ios/50/image--v1.png" alt="preview documento" />
      </div>
      <input type="file" id="ruta_documentos_negocios" name="ruta_documentos_negocios" accept="image/*" hidden />
      <button type="button" class="btn outline" onclick="document.getElementById('ruta_documentos_negocios').click()">Subir documento</button>

      <div class="form-actions">
        <button type="submit" class="btn primary">Registrar</button>
        <a href="/register"><button type="button" class="btn outline">Cancelar</button></a>
      </div>
    </form>
  </main>

  <script>
    // Vista previa de imágenes seleccionadas
    document.getElementById('ruta_imagne_logo').addEventListener('change', function (e) {
      const preview = document.getElementById('logoPreview');
      const file = e.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = () => {
          preview.innerHTML = `<img src="${reader.result}" alt="Logo">`;
        };
        reader.readAsDataURL(file);
      }
    });

    document.getElementById('ruta_documentos_negocios').addEventListener('change', function (e) {
      const preview = document.getElementById('cedulaPreview');
      const file = e.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = () => {
          preview.innerHTML = `<img src="${reader.result}" alt="Documento">`;
        };
        reader.readAsDataURL(file);
      }
    });
  </script>

</body>
</html>
