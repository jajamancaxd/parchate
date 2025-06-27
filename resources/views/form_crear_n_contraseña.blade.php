<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Crear nueva contraseña</title>
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
      margin-bottom: 30px;
    }

    form {
      width: 100%;
    }

    label {
      display: block;
      font-weight: bold;
      color: #f35c0c;
      margin-bottom: 8px;
      text-align: left;
      margin-left: 15px;
    }

    input[type="password"] {
      width: 90%;
      padding: 10px;
      border: 2px solid #ccc;
      border-radius: 20px;
      margin-bottom: 20px;
      font-size: 16px;
      outline: none;
      box-sizing: border-box;
    }

    .submit-btn {
      background-color: #f35c0c;
      color: white;
      border: none;
      padding: 10px 40px;
      font-size: 16px;
      font-weight: bold;
      border-radius: 8px;
      cursor: pointer;
    }

    .error, .success {
      font-size: 14px;
      margin-bottom: 10px;
    }

    .error {
      color: red;
    }

    .success {
      color: green;
    }
  </style>
</head>
<body>

  <div class="container">
    <img src="{{ asset('img/parchatelogo.png') }}" alt="Logo" />
    <h2>Crear nueva contraseña</h2>

    @if (session('success'))
      <div class="success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
      <div class="error">
        @foreach ($errors->all() as $error)
          <div>{{ $error }}</div>
        @endforeach
      </div>
    @endif

    <form method="POST" action="{{ route('actualizar_contraseña') }}">
      @csrf
      <label for="password">Nueva contraseña</label>
      <input type="password" id="password" name="password" placeholder="Nueva contraseña" required>

      <label for="password_confirmation">Confirmar contraseña</label>
      <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirmar contraseña" required>

      <button type="submit" class="submit-btn">Crear</button>
    </form>
  </div>

</body>
</html>
