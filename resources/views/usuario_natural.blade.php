<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Usuario Natural</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/usuarionatural.css') }}">
</head>
<body>

<div class="header">
    <a href="{{ route('lugares.recomendados') }}" class="back-arrow">←</a>
    Usuario Natural
    <img src="{{ asset('img/parchatelogo.png') }}" class="logo" alt="Logo">
</div>

@if(session('success'))
    <div style="color: green; text-align: center; margin-top: 10px;">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div style="color: red; text-align: center; margin-top: 10px;">{{ session('error') }}</div>
@endif

<div class="container">
    <div class="profile">
        <form id="logo-form" action="{{ route('usuario_natural.actualizarLogo') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="edit-icon">
                <img id="preview-logo" 
                     src="{{ asset($usuario->ruta_img_perfil ?? 'img/parchatelogo.png') }}" 
                     alt="Imagen de perfil"
                     onerror="this.onerror=null;this.src='{{ asset('img/parchatelogo.png') }}';">
                <label for="file-upload">✎</label>
                <input type="file" id="file-upload" name="logo" accept="image/*" onchange="document.getElementById('logo-form').submit();">
            </div>
        </form>
        <!-- Acciones y configuraciones -->
        <div class="actions">
                <p>Selecciona la acción que quieras realizar</p>
                <button onclick="window.location.href='{{ route('usuario_natural.validar_actual') }}'">Cambiar contraseña</button>
        </div>
    </div>

    <div class="info">
        <h2>{{ $usuario->correo_electronico }}</h2>
        <p>ID usuario: {{ $usuario->id_usuario }}</p>
    </div>
</div>

</body>
</html>
