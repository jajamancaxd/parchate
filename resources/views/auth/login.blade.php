<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Inicio de sesión</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: url('{{ asset("img/bulevaro.png") }}') no-repeat center center fixed;
      background-size: cover;
    }

    .login-container {
      width: 420px;
      background-color: white;
      margin: 60px auto;
      padding: 40px 25px;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0,0,0,0.3);
      text-align: center;
      box-sizing: border-box;
      height: 540px;
      position: relative;
    }

    .login-container img {
      width: 130px;
      height: 130px;
      transform: scale(1.4);
      margin-bottom: 5px;
    }

    .alert-error,
    .alert-success {
      position: absolute;
      top: 150px;
      left: 50%;
      transform: translateX(-50%);
      padding: 12px;
      border-radius: 8px;
      font-size: 14px;
      text-align: center;
      width: 90%;
      z-index: 10;
      animation: fadeOut 4s forwards;
    }

    .alert-error {
      background-color: #f8d7da;
      color: #721c24;
    }

    .alert-success {
      background-color: #d4edda;
      color: #155724;
    }

    @keyframes fadeOut {
      0% { opacity: 1; }
      70% { opacity: 1; }
      100% { opacity: 0; }
    }

    .login-container h1 {
      font-size: 32px;
      font-weight: 800;
      margin-bottom: 20px;
      transform: scale(1.3);
    }

    .form-group {
      display: flex;
      align-items: center;
      margin-bottom: 18px;
    }

    .form-group label {
      width: 120px;
      text-align: left;
      color: #f35c0c;
      font-weight: bold;
    }

    .form-group input {
      flex: 1;
      padding: 8px 12px;
      border: 1px solid #ccc;
      border-radius: 20px;
      outline: none;
      font-size: 14px;
    }

    .login-container button {
      width: 220px;
      padding: 8px;
      font-weight: bold;
      font-size: 15px;
      cursor: pointer;
      border-radius: 8px;
      margin: 8px auto;
      display: block;
    }

    .login-btn {
      background-color: #f35c0c;
      color: white;
      border: none;
    }

    .register-btn {
      background-color: #ffffff;
      color: #f35c0c;
      border: 2px solid #f35c0c;
    }

    .login-container .links {
      margin-top: 10px;
      font-size: 13px;
    }

    .login-container .links a {
      color: gray;
      text-decoration: none;
    }

    .login-container .links a:hover {
      text-decoration: underline;
    }

    .button-wrapper {
      margin-top: 30px;
    }
  </style>
</head>
<body>

  <div class="login-container">
    <img src="{{ asset('img/parchatelogo.png') }}" alt="Logo Parchate">

    @if (session('success'))
      <div class="alert-success">
        {{ session('success') }}
      </div>
    @endif

    @if ($errors->any())
      <div class="alert-error">
        @foreach ($errors->all() as $error)
          <p style="margin: 0;">{{ $error }}</p>
        @endforeach
      </div>
    @endif

    <h1>Inicio de sesión</h1>

    <form method="POST" action="{{ route('login.submit') }}">
      @csrf

      <div class="form-group">
        <label for="correo">Correo</label>
        <input type="email" id="correo" name="correo" value="{{ old('correo') }}" required>
      </div>

      <div class="form-group">
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" required>
      </div>

      <div class="button-wrapper">
        <button type="submit" class="login-btn">Iniciar sesión</button>
        <a href="{{ route('register') }}">
          <button type="button" class="register-btn">Registrarse</button>
        </a>
      </div>
    </form>

    <div class="links">
      <a href="{{ route('recuperar.formulario') }}">¿Olvidaste tu contraseña? Recupera aquí</a>
    </div>
  </div>

</body>
</html>
