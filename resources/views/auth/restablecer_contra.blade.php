<!-- resources/views/auth/restablecer_contra.blade.php -->

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Recuperar contraseña</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: url('img/bulevaro.png') no-repeat center center fixed;
      background-size: cover;
    }

    .login-container {
      width: 360px;
      background-color: white;
      margin: 80px auto;
      padding: 30px 25px;
      border-radius: 10px;
      box-shadow: 0 0 18px rgba(0,0,0,0.25);
      text-align: center;
      box-sizing: border-box;
      min-height: 420px;
      position: relative;
    }

    .login-container img {
      width: 100px;
      height: 100px;
      transform: scale(1.3);
      margin-bottom: 10px;
    }

    .alert-error {
      position: absolute;
      top: 130px;
      left: 50%;
      transform: translateX(-50%);
      background-color: #f8d7da;
      color: #721c24;
      padding: 10px 12px;
      border-radius: 8px;
      font-size: 13px;
      width: 90%;
      text-align: center;
      z-index: 10;
      animation: fadeOut 4s forwards;
    }

    @keyframes fadeOut {
      0% { opacity: 1; }
      70% { opacity: 1; }
      100% { opacity: 0; }
    }

    .login-container h1 {
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 20px;
      text-align: left;
    }

    .form-group label {
      display: block;
      margin-bottom: 6px;
      color: #f35c0c;
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

    .login-container button {
      width: 200px;
      padding: 10px;
      font-weight: bold;
      font-size: 14px;
      cursor: pointer;
      border-radius: 8px;
      margin-top: 10px;
      background-color: #f35c0c;
      color: white;
      border: none;
    }
  </style>
</head>
<body>

  <div class="login-container">
    <img src="{{ asset('img/parchatelogo.png') }}" alt="Logo Parchate">

    {{-- Mensaje de error centrado, fijo, sin mover nada --}}
    @if ($errors->any())
      <div class="alert-error">
        @foreach ($errors->all() as $error)
          <p style="margin: 0;">{{ $error }}</p>
        @endforeach
      </div>
    @endif

    <h1>Recuperar contraseña</h1>

    <form method="POST" action="{{ route('recuperar.enviar') }}">
      @csrf
      <div class="form-group">
        <label for="correo">Correo electrónico</label>
        <input type="email" id="correo" name="correo" required>
      </div>
      <button type="submit">Enviar código</button>
    </form>
  </div>

</body>
</html>
