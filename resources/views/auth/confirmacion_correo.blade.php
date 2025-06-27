<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Confirmación de correo</title>
  <style>
     body {
    margin: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: url("{{ asset('img/bulevaro.png') }}") no-repeat center center fixed;
    background-size: cover;
  }

    .confirm-container {
      width: 420px;
      height: 540px;
      background-color: white;
      margin: 60px auto;
      padding: 40px 25px;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
      text-align: center;
      box-sizing: border-box;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: flex-start;
    }

    .confirm-container img {
      width: 130px;
      height: 130px;
      transform: scale(1.4);
      margin-bottom: 10px;
    }

    .confirm-container h2 {
      font-size: 22px;
      font-weight: 700;
      margin-bottom: 10px;
    }

    .confirm-container p {
      font-size: 14px;
      color: #444;
      margin-bottom: 20px;
    }

    .code-label {
      color: #f35c0c;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .code-inputs {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin-bottom: 30px;
    }

    .code-inputs input {
      width: 45px;
      height: 50px;
      text-align: center;
      font-size: 24px;
      border: 2px solid #ccc;
      border-radius: 10px;
      outline: none;
      transition: border-color 0.3s;
    }

    .code-inputs input:focus {
      border-color: #f35c0c;
    }

    .button-wrapper {
      display: flex;
      gap: 20px;
      justify-content: center;
    }

    .button-wrapper button {
      width: 120px;
      padding: 10px;
      font-weight: bold;
      font-size: 15px;
      cursor: pointer;
      border-radius: 8px;
    }

    .verify-btn {
      background-color: #f35c0c;
      color: white;
      border: none;
    }

    .cancel-btn {
      background-color: #fff;
      color: #f35c0c;
      border: 2px solid #f35c0c;
    }

    .error { color: red; font-size: 14px; margin-bottom: 10px; }
    .success { color: green; font-size: 14px; margin-bottom: 10px; }
  </style>
</head>
<body>

  <div class="confirm-container">
    <img src="{{ asset('img/parchatelogo.png') }}" alt="Logo" />
    <h2>Confirmación correo</h2>
    <p>Introduce el código que hemos<br>enviado a tu correo electrónico</p>

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

    <form method="POST" action="{{ route('confirmacion_correo') }}">
      @csrf

      <div class="code-label">Código</div>
      <div class="code-inputs">
        <input type="text" maxlength="1" class="code-digit" required>
        <input type="text" maxlength="1" class="code-digit" required>
        <input type="text" maxlength="1" class="code-digit" required>
        <input type="text" maxlength="1" class="code-digit" required>
        <input type="text" maxlength="1" class="code-digit" required>
        <input type="text" maxlength="1" class="code-digit" required>
      </div>

      <input type="hidden" name="codigo" id="codigo_completo">

      <div class="button-wrapper">
        <button type="submit" class="verify-btn">Verificar</button>
        <a href="{{ route('login') }}"><button type="button" class="cancel-btn">Cancelar</button></a>
      </div>
    </form>
  </div>

  <script>
    const inputs = document.querySelectorAll('.code-digit');
    const hiddenInput = document.getElementById('codigo_completo');

    inputs.forEach((input, index) => {
      input.addEventListener('input', (e) => {
        const value = e.target.value;
        if (value.length === 1 && index < inputs.length - 1) {
          inputs[index + 1].focus();
        }
        updateHiddenInput();
      });

      input.addEventListener('keydown', (e) => {
        if (e.key === 'Backspace' && input.value === '' && index > 0) {
          inputs[index - 1].focus();
        }
      });
    });

    function updateHiddenInput() {
      hiddenInput.value = Array.from(inputs).map(i => i.value).join('');
    }
  </script>

</body>
</html>
