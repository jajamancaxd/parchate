<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Negocios</title>
  <link rel="stylesheet" href="{{ asset('css/componentespermanentesnegocio.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
  <style>
    .body{
      font-family: 'Poppins', sans-serif;
    }
  </style>
<body>

  <header class="barra-naranja">
    <!-- Izquierda: logo -->
    <div class="barra-izquierda">
      <div class="logo">
        <img src="{{ asset('img/parchatelogo.png') }}" alt="Logo Párchate" class="logo-img">
      </div>
    </div>

    <!-- Centro: iconos con enlaces -->
    <div class="iconos-menu">
      <a href="/sucursales-negocio" title="Sucursales Negocio"><i class="fas fa-map-marker-alt"></i></a>
      <a href="{{ route('eventos.index') }}" title="Mis Eventos"><i class="fas fa-calendar-alt"></i></a>
    </div>

    <!-- Derecha: perfil -->
    <div class="barra-derecha">
      <div class="menu-perfil">
        <i class="fas fa-user" id="icono-perfil"></i>
      <div class="submenu-perfil" id="submenu-perfil">
    <button onclick="window.location.href='/usuario-negocio'">Configuración</button>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
      @csrf
      <button type="submit">Cerrar sesión</button>
    </form>
</div>

      </div>
    </div>
  </header>

  <!-- Contenido dinámico de cada vista -->
  <main>
    @yield('content')
  </main>

  <script src="{{ asset('js/componentespermanentesnegocio.js') }}"></script>

</body>
</html>
