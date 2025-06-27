<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Usuario Negocio</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #fff;
            margin: 0; padding: 0;
        }
        .header {
            background-color: #FF6600;
            color: white;
            padding: 15px;
            position: relative;
            text-align: center;
            font-weight: 600;
            font-size: 1.2rem;
        }
        .logo {
            position: absolute;
            top: 50%;
            right: 20px;
            transform: translateY(-50%);
            height: 55px;
        }
        .back-arrow {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.5rem;
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        .container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            padding: 30px;
            max-width: 1000px;
            margin: auto;
        }
        .profile, .info {
            flex: 1;
            min-width: 250px;
            text-align: center;
        }
        .profile img {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #FF6600;
        }
        .edit-icon {
            position: relative;
            display: inline-block;
        }
        .edit-icon input[type="file"] {
            display: none;
        }
        .edit-icon label {
            position: absolute;
            bottom: 5px;
            right: 10px;
            background: white;
            border-radius: 50%;
            border: 1px solid #ccc;
            padding: 5px 8px;
            cursor: pointer;
            font-size: 0.9em;
            color: #333;
        }
        .buttons button {
            margin: 10px auto;
            display: block;
            background: #E0E0E0;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
        }
        .info h2 {
            margin-bottom: 0;
        }
        .info p {
            margin-top: 5px;
            color: #666;
        }
    </style>
</head>
<body>

<div class="header">
    <a href="javascript:history.back()" class="back-arrow">←</a>
    Usuario Negocio
    <img src="{{ asset('img/parchatelogo.png') }}" class="logo" alt="Logo">
</div>

@if(session('success'))
    <div style="color: green; text-align: center; margin-top: 10px;">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div style="color: red; text-align: center; margin-top: 10px;">{{ session('error') }}</div>
@endif

<div class="container">
    <div class="profile">
        <form id="logo-form" action="{{ url('/usuario-negocio/logo') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="edit-icon">
                <img id="preview-logo" src="{{ asset($negocio->ruta_imagne_logo ?? 'img/parchatelogo.png') }}" alt="Logo empresa">
                <label for="file-upload">✎</label>
                <input type="file" id="file-upload" name="logo" accept="image/*" onchange="document.getElementById('logo-form').submit();">
            </div>
        </form>
        <div class="buttons">
            <p><strong>Selecciona la acción que quieras realizar</strong></p>
            <a href="/restablecer_contra">
                <button>Cambiar contraseña</button>
            </a>
                <a href="/registro-negocio">
            </a>
        </div>
    </div>

    <div class="info">
        <h2>{{ $negocio->nombre_negocio }}</h2>
        <p>{{ $negocio->correo_electronico_negocios }}</p>
    </div>
</div>

</body>
</html>
