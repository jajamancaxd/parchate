<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Modificar Cuenta</title>
  <link rel="stylesheet" href="{{ asset('css/Administradores/crear.css') }}">
</head>
<body>

  <a href="{{ route('Administradores') }}" class="back">← Regresar</a>

  <div class="wrapper">
    <div class="logo-container">
      <img src="{{ asset('imagenes/logo.png') }}" alt="Logo" class="logo" />
    </div>
    <h1>Modificar Cuenta</h1>

    <form id="registerForm" action="{{ route('Administradores.Update', $admin->correo_electronico_administrador) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="form-group">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre_usuario_administrador"
        value="{{ old('nombre_usuario_administrador', $admin->nombre_usuario_administrador) }}"
        pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
        title="Solo se permiten letras y espacios"
        required>

        @error('nombre_usuario_administrador')
          <div class="error">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        <label for="cc">Número C.C</label>
        <input type="text" id="cc" name="numero_documentos_usuario"
        maxlength="10"
        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" 
        value="{{ old('numero_documentos_usuario', $admin->numero_documentos_usuario ?? '') }}" 
        required>

        @error('numero_documentos_usuario')
          <div class="error">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        <label for="correo">Correo</label>
        <input type="email" id="correo" name="correo_electronico_administrador" value="{{ old('correo_electronico_administrador', $admin->correo_electronico_administrador) }}">
        @error('correo_electronico_administrador')
          <div class="error">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        <label for="password">Contraseña (dejar vacío para no cambiar)</label>
        <input type="password" id="password" name="contraseña_administrador" autocomplete="new-password">
        @error('contraseña_administrador')
          <div class="error">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        <label for="confirmar">Confirmar Contraseña</label>
        <input type="password" id="confirmar" name="confirmar" autocomplete="new-password">
        <div class="error" id="error-confirmar"></div>
        @error('confirmar')
          <div class="error">{{ $message }}</div>
        @enderror
      </div>

      <div class="buttons">
        <button type="submit" class="btn btn-create">Modificar</button>
        <button type="button" class="btn btn-cancel" onclick="window.location.href='{{ route('Administradores') }}'">Cancelar</button>
      </div>
    </form>
  </div>

  <script>
    document.getElementById('registerForm').addEventListener('submit', function(e) {
      const pass = document.getElementById('password').value;
      const confirmar = document.getElementById('confirmar').value;
      const errorConfirmar = document.getElementById('error-confirmar');
      errorConfirmar.innerText = '';

      // Solo validar si alguna de las dos contraseñas tiene contenido (para no validar si no se cambia)
      if ((pass || confirmar) && pass !== confirmar) {
        e.preventDefault(); // Detiene el envío
        errorConfirmar.innerText = 'Las contraseñas no coinciden.';
      }
    });
  </script>

</body>
</html>
