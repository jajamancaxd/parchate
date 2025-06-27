<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Inicio de sesión</title>
  <style>
    * { box-sizing: border-box; }

    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: url('{{ asset("img/bulevaro.png") }}') no-repeat center center fixed;
      background-size: cover;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      padding: 20px;
      animation: fadeIn 1s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    .login-container {
      width: 100%;
      max-width: 420px;
      background-color: rgba(255, 255, 255, 0.97);
      padding: 40px 25px;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.4);
      text-align: center;
      animation: slideUp 0.8s ease forwards;
      transform: translateY(20px);
      opacity: 0;
    }

    @keyframes slideUp {
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    .login-container img {
      width: 100px;
      height: 100px;
      margin-bottom: 10px;
    }

    .alert-success, .alert-error {
      position: absolute;
      top: 15px;
      left: 50%;
      transform: translateX(-50%);
      width: 90%;
      padding: 10px;
      border-radius: 8px;
      font-size: 14px;
      animation: fadeOut 4s forwards;
      text-align: center;
    }

    .alert-success { background: #d4edda; color: #155724; }
    .alert-error { background: #f8d7da; color: #721c24; }

    @keyframes fadeOut {
      0%, 70% { opacity: 1; }
      100% { opacity: 0; }
    }

    h1 {
      font-size: 28px;
      margin: 20px 0;
      color: #333;
    }

    .form-group {
      text-align: left;
      margin-bottom: 18px;
    }

    .form-group label {
      font-weight: bold;
      color: #f35c0c;
      margin-bottom: 4px;
      display: block;
    }

    .form-group input {
      width: 100%;
      padding: 10px 15px;
      border: 1px solid #ccc;
      border-radius: 25px;
      font-size: 15px;
      outline: none;
    }

    .form-group input:focus {
      border-color: #f35c0c;
      box-shadow: 0 0 8px rgba(243, 92, 12, 0.3);
    }

    .button-wrapper {
      margin-top: 25px;
    }

    .login-container button {
      width: 100%;
      padding: 10px;
      font-weight: bold;
      font-size: 15px;
      border-radius: 25px;
      cursor: pointer;
      margin-bottom: 12px;
      transition: 0.3s ease;
    }

    .login-btn {
      background: #f35c0c;
      color: white;
      border: none;
    }

    .register-btn {
      background: white;
      color: #f35c0c;
      border: 2px solid #f35c0c;
    }

    .register-btn:hover {
      background: #f35c0c;
      color: white;
    }

    .links {
      margin-top: 10px;
      font-size: 13px;
    }

    .links a {
      color: gray;
      text-decoration: none;
    }

    .links a:hover {
      color: #f35c0c;
      text-decoration: underline;
    }

    @media (max-width: 480px) {
      h1 { font-size: 24px; }
      .login-container { padding: 30px 20px; }
    }
  </style>
</head>
<body>

  <div class="login-container">
    <img src="{{ asset('img/parchatelogo.png') }}" alt="Logo Parchate">

    @if(session('success'))
      <div class="alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
      <div class="alert-error">
        @foreach($errors->all() as $error)
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
