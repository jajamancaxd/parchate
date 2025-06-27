<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro</title>
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
      max-width: 430px;
      background-color: rgba(255, 255, 255, 0.97);
      padding: 40px 25px;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.4);
      text-align: center;
      position: relative;
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

    .floating-error {
      position: absolute;
      top: -20px;
      left: 50%;
      transform: translateX(-50%);
      background-color: #f8d7da;
      color: #721c24;
      padding: 10px 16px;
      border-radius: 8px;
      font-size: 14px;
      width: 90%;
      animation: fadeOut 4s forwards;
      text-align: center;
    }

    .floating-error ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    h1 {
      font-size: 28px;
      font-weight: 700;
      color: #333;
      margin-bottom: 20px;
    }

    .form-group {
      text-align: left;
      margin-bottom: 18px;
    }

    .form-group label {
      display: block;
      margin-bottom: 6px;
      color: #f35c0c;
      font-weight: bold;
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

    .form-options {
      text-align: left;
      font-size: 14px;
      color: #f35c0c;
      margin: 20px 0 10px 0;
    }

    .form-options label {
      display: block;
      font-weight: bold;
      margin-bottom: 6px;
    }

    .form-options input[type="radio"] {
      margin-right: 6px;
    }

    .terms {
      font-size: 13px;
      margin: 20px 0;
      color: #f35c0c;
      font-weight: bold;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      flex-wrap: wrap;
      text-align: center;
    }

    .login-container button {
      width: 100%;
      padding: 10px;
      font-weight: bold;
      font-size: 15px;
      border-radius: 25px;
      cursor: pointer;
      background-color: #f35c0c;
      color: white;
      border: none;
      transition: 0.3s;
    }

    .login-container button:hover {
      background-color: #e14c00;
    }

    .links {
      margin-top: 15px;
      font-size: 13px;
    }

    .links a {
      color: #555;
      text-decoration: none;
    }

    .links a:hover {
      color: #f35c0c;
      text-decoration: underline;
    }

    @media (max-width: 480px) {
      .login-container { padding: 30px 20px; }
      h1 { font-size: 24px; }
    }
  </style>
</head>
<body>

  <div class="login-container">
    <img src="{{ asset('img/parchatelogo.png') }}" alt="Logo Parchate">

    @if ($errors->any())
      <div id="mensaje-error" class="floating-error">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <h1>Registro</h1>

    <form method="POST" action="{{ route('register') }}">
      @csrf

      <div class="form-group">
        <label for="correo">Correo</label>
        <input type="email" id="correo" name="correo" required value="{{ old('correo') }}">
      </div>

      <div class="form-group">
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" required>
      </div>

      <div class="form-options">
        <label>
          <input type="radio" name="tipo_persona" value="usuario" {{ old('tipo_persona') == 'usuario' ? 'checked' : '' }}>
          Persona Natural
        </label>
        <label>
          <input type="radio" name="tipo_persona" value="negocio" {{ old('tipo_persona') == 'negocio' ? 'checked' : '' }}>
          Negocio
        </label>
        <label>
          <input type="radio" name="tipo_persona" value="administrador" {{ old('tipo_persona') == 'administrador' ? 'checked' : '' }}>
          Administrador
        </label>
      </div>

      <div class="terms">
        <input type="checkbox" id="terminos" name="terminos" {{ old('terminos') ? 'checked' : '' }} required>
        <label for="terminos">
          Acepto <a href="{{ route('terminosycondiciones') }}" target="_blank" style="color: #f35c0c; text-decoration: underline;">términos y condiciones</a>
        </label>
      </div>

      <button type="submit">Registrarme</button>
    </form>

    <div class="links">
      <a href="{{ route('login') }}">¿Ya tienes una cuenta? Inicia sesión aquí</a>
    </div>
  </div>

</body>
</html>
