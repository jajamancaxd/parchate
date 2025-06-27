<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Recuperar contraseña</title>
  <style>
    * {
      box-sizing: border-box;
    }

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
      padding: 40px 30px;
      border-radius: 15px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.35);
      text-align: center;
      position: relative;
      animation: slideUp 0.7s ease forwards;
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
      margin-bottom: 15px;
    }

    .alert-error {
      position: absolute;
      top: -15px;
      left: 50%;
      transform: translateX(-50%);
      background-color: #f8d7da;
      color: #721c24;
      padding: 10px 16px;
      border-radius: 8px;
      font-size: 14px;
      width: 90%;
      animation: fadeOut 4s forwards;
      z-index: 10;
      text-align: center;
    }

    @keyframes fadeOut {
      0%, 70% { opacity: 1; }
      100% { opacity: 0; }
    }

    h1 {
      font-size: 26px;
      font-weight: 700;
      color: #333;
      margin-bottom: 25px;
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
      border-radius: 25px;
      outline: none;
      font-size: 15px;
      transition: border-color 0.3s ease;
    }

    .form-group input:focus {
      border-color: #f35c0c;
      box-shadow: 0 0 8px rgba(243, 92, 12, 0.3);
    }

    .login-container button {
      width: 100%;
      padding: 10px;
      font-weight: bold;
      font-size: 15px;
      cursor: pointer;
      border-radius: 25px;
      background-color: #f35c0c;
      color: white;
      border: none;
      transition: background-color 0.3s ease;
    }

    .login-container button:hover {
      background-color: #e14c00;
    }

    @media (max-width: 480px) {
      .login-container {
        padding: 30px 20px;
      }

      h1 {
        font-size: 22px;
      }

      .form-group label,
      .form-group input {
        font-size: 14px;
      }

      .login-container button {
        font-size: 14px;
      }
    }
  </style>
</head>
<body>

  <div class="login-container">
    <img src="{{ asset('img/parchatelogo.png') }}" alt="Logo Parchate">

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
