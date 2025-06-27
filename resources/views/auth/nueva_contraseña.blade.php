<!-- resources/views/auth/nueva_contraseña.blade.php -->

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Nueva contraseña</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: url("{{ asset('img/bulevaro.png') }}") no-repeat center center fixed;
      background-size: cover;
    }

    .container {
      width: 420px;
      height: 540px;
      background-color: white;
      margin: 60px auto;
      padding: 40px 25px;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0,0,0,0.3);
      text-align: center;
      box-sizing: border-box;
      position: relative;
    }

    .container img {
      width: 130px;
      height: 130px;
      transform: scale(1.4);
      margin-bottom: 5px;
    }

    .container h2 {
      font-size: 26px;
      color: #333;
      font-weight: bold;
      margin-top: 20px;
      margin-bottom: 30px;
    }

    .form-group {
      margin-bottom: 20px;
      text-align: left;
    }

    .form-group label {
      display: block;
      margin-bottom: 6px;
      color: #f35c0c;
      font-size: 15px;
      font-weight: bold;
    }

    .form-group input {
      width: 100%;
      padding: 10px 14px;
      border: 1px solid #ccc;
      border-radius: 20px;
      outline: none;
      font-size: 14px;
      box-sizing: border-box;
    }

    .btn {
      width: 220px;
      padding: 10px;
      font-weight: bold;
      font-size: 15px;
      cursor: pointer;
      border-radius: 8px;
      margin-top: 20px;
      background-color: #f35c0c;
      color: white;
      border: none;
    }

    .alert-error {
      position: absolute;
      top: 150px;
      left: 50%;
      transform: translateX(-50%);
      background-color: #f8d7da;
      color: #721c24;
      padding: 12px;
      border-radius: 8px;
      font-size: 14px;
      text-align: center;
      width: 90%;
      z-index: 10;
      animation: fadeOut 4s forwards;
    }

    @keyframes fadeOut {
      0% { opacity: 1; }
      70% { opacity: 1; }
      100% { opacity: 0; }
    }
  </style>
</head>
<body>

  <div class="container">
    <img src="{{ asset('img/parchatelogo.png') }}" alt="Logo Parchate">

    {{-- Error por JS (contraseñas no coinciden) --}}
    <div id="js-error" class="alert-error" style="display: none;"></div>

    {{-- Errores del backend --}}
    @if ($errors->any())
      <div class="alert-error">
        @foreach ($errors->all() as $error)
          <p style="margin: 0;">{{ $error }}</p>
        @endforeach
      </div>
    @endif

    <h2>Ingresa tu nueva contraseña</h2>

    <form method="POST" action="{{ route('recuperar.actualizar') }}" onsubmit="return validarContraseñas();">
      @csrf
      <input type="hidden" name="correo" value="{{ $correo }}">
      <input type="hidden" name="tipo" value="{{ $tipo }}">

      <div class="form-group">
        <label for="nueva_contraseña">Nueva contraseña</label>
        <input type="password" id="nueva_contraseña" name="nueva_contraseña" required minlength="6">
      </div>

      <div class="form-group">
        <label for="confirmar_contraseña">Repetir contraseña</label>
        <input type="password" id="confirmar_contraseña" required>
      </div>

      <button type="submit" class="btn">Actualizar contraseña</button>
    </form>
  </div>

  <script>
    function validarContraseñas() {
      const nueva = document.getElementById('nueva_contraseña').value;
      const confirmar = document.getElementById('confirmar_contraseña').value;
      const errorDiv = document.getElementById('js-error');

      if (nueva !== confirmar) {
        errorDiv.innerHTML = "<p style='margin: 0;'>Las contraseñas no coinciden.</p>";
        errorDiv.style.display = "block";
        errorDiv.classList.remove('alert-error'); // reset animation
        void errorDiv.offsetWidth; // reflow
        errorDiv.classList.add('alert-error'); // restart animation

        return false;
      }

      errorDiv.style.display = "none";
      return true;
    }
  </script>

</body>
</html>
