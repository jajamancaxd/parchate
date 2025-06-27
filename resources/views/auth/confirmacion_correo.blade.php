<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Confirmación de correo</title>
  <style>
    * { box-sizing: border-box; }

    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: url("{{ asset('img/bulevaro.png') }}") no-repeat center center fixed;
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

    .confirm-container {
      width: 100%;
      max-width: 420px;
      background-color: rgba(255, 255, 255, 0.97);
      padding: 40px 30px;
      border-radius: 15px;
      box-shadow: 0 0 25px rgba(0, 0, 0, 0.35);
      text-align: center;
      display: flex;
      flex-direction: column;
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

    .confirm-container img {
      width: 100px;
      height: 100px;
      margin-bottom: 15px;
    }

    h2 {
      font-size: 24px;
      font-weight: 700;
      margin-bottom: 10px;
      color: #333;
    }

    p {
      font-size: 14px;
      color: #444;
      margin-bottom: 25px;
    }

    .code-label {
      color: #f35c0c;
      font-weight: bold;
      margin-bottom: 10px;
      font-size: 15px;
    }

    .code-inputs {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin-bottom: 30px;
      flex-wrap: wrap;
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
      gap: 15px;
      justify-content: center;
      flex-wrap: wrap;
    }

    .button-wrapper button {
      width: 130px;
      padding: 10px;
      font-weight: bold;
      font-size: 15px;
      cursor: pointer;
      border-radius: 25px;
    }

    .verify-btn {
      background-color: #f35c0c;
      color: white;
      border: none;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .verify-btn:hover {
      background-color: #e14c00;
    }

    .cancel-btn {
      background-color: white;
      color: #f35c0c;
      border: 2px solid #f35c0c;
    }

    .cancel-btn:hover {
      background-color: #f35c0c;
      color: white;
    }

    .error {
      color: red;
      font-size: 14px;
      margin-bottom: 10px;
    }

    .success {
      color: green;
      font-size: 14px;
      margin-bottom: 10px;
    }

    .spinner {
      border: 3px solid #fff;
      border-top: 3px solid #f35c0c;
      border-radius: 50%;
      width: 18px;
      height: 18px;
      animation: spin 0.8s linear infinite;
      display: none;
      vertical-align: middle;
      margin-right: 8px;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    @media (max-width: 480px) {
      .code-inputs input {
        width: 40px;
        height: 45px;
        font-size: 20px;
      }

      .button-wrapper button {
        width: 100%;
      }
    }
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
        <button type="submit" class="verify-btn" id="verify-button">
          <span class="spinner" id="spinner"></span>
          <span class="text">Verificar</span>
        </button>
        <a href="{{ route('login') }}">
          <button type="button" class="cancel-btn">Cancelar</button>
        </a>
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

    document.querySelector('form').addEventListener('submit', function() {
      document.getElementById('verify-button').disabled = true;
      document.getElementById('spinner').style.display = 'inline-block';
      document.querySelector('#verify-button .text').textContent = 'Verificando...';
    });
  </script>

</body>
</html>
