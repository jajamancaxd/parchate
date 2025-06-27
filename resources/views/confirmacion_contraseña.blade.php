<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Contraseña modificada</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: url("{{ asset('img/bulevaro.png') }}") no-repeat center center fixed;
      background-size: cover;
    }

    .container {
      width: 420px;
      background-color: white;
      margin: 60px auto;
      padding: 40px 25px;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
      text-align: center;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .container img {
      width: 130px;
      height: 130px;
      transform: scale(1.4);
      margin-bottom: 10px;
    }

    h2 {
      font-size: 22px;
      font-weight: 700;
      margin-bottom: 15px;
    }

    p {
      font-size: 16px;
      margin-bottom: 30px;
    }

    .btn-login {
      background-color: #f35c0c;
      color: white;
      border: none;
      padding: 10px 40px;
      font-size: 16px;
      font-weight: bold;
      border-radius: 8px;
      cursor: pointer;
      text-decoration: none;
    }
  </style>
</head>
<body>

  <div class="container">
    <img src="{{ asset('img/parchatelogo.png') }}" alt="Logo" />
    <h2>Crear nueva contraseña</h2>
    <p>Contraseña modificada correctamente</p>
    <a href="{{ route('login') }}" class="btn-login">Iniciar sesión</a>
  </div>

</body>
</html>
