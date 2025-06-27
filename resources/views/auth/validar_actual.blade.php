<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmación Usuario</title>
    <link rel="stylesheet" href="{{ asset('css/cambiar_contra.css') }}">
</head>
<body>

<div class="header">
    <a href="{{ route('usuario_natural.perfil') }}">←</a>
</div>

<div class="card">
    <img src="{{ asset('imagenes/logo.png') }}" alt="Logo" class="logo"/>
    <h2>Confirmación Usuario</h2>

    @if ($errors->any())
        <div style="color: red;">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('usuario_natural.validar_actual') }}">
        @csrf
        <p>Ingrese su contraseña actual:</p>
        <input type="password" name="contraseña_actual" required>
        <div class="buttons">
            <button class="btn-aceptar" type="submit">Aceptar</button>
            <button class="btn-cancelar" type="button" onclick="window.location.href='{{ route('usuario_natural.perfil') }}'">Cancelar</button>
        </div>
    </form>
</div>

</body>
</html>
