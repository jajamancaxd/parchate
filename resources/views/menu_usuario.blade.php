<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Navbar con Submenús</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      margin: 0;
      font-family: Arial, sans-serif;
    }

    .navbar {
      background-color: #ff6600;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1px 20px;
      color: white;
    }

    .navbar-left,
    .navbar-right {
      display: flex;
      align-items: center;
      gap: 100px;
      padding-right: 150px;
    }

    .logo {
      height: 80px;
    }

    .nav-item {
      display: flex;
      flex-direction: column;
      align-items: center;
      font-size: 14px;
      color: white;
      text-decoration: none;
    }

    .nav-item img {
      width: 30px;
      height: 30px;
      margin-bottom: 4px;
    }

    .nav-item:hover {
      opacity: 0.85;
    }

    /* Corrige comportamiento por defecto de los <a> */
    a.nav-item, a.nav-item:visited {
      color: white;
      text-decoration: none;
    }

    .dropdown {
      position: relative;
    }

    .dropdown-menu {
      display: none;
      position: absolute;
      top: 60px;
      background-color: #fff;
      border: 1px solid #ccc;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      z-index: 1000;
      min-width: 200px;
      padding: 10px 0;
    }

    .dropdown-menu button,
    .dropdown-menu form button {
      background-color: transparent;
      border: none;
      padding: 10px 20px;
      text-align: left;
      width: 100%;
      font-size: 14px;
      font-weight: bold;
      color: #000;
      cursor: pointer;
      transition: background 0.2s ease;
    }

    .dropdown-menu button:hover,
    .dropdown-menu form button:hover {
      background-color: #ff6600;
      color: white;
      border-radius: 0;
    }
  </style>
</head>
<body>

  <header class="navbar">
    <div class="navbar-left">
      <img src="{{ asset('imagenes/logo.png') }}" alt="Logo" class="logo" />

    <div class="dropdown">
    <a href="#" class="nav-item" onclick="toggleDropdown('guardadosDropdown')">
    <img src="{{ asset('imagenes/guardados.png') }}" alt="Guardados" />
    Guardados
    </a>
  <div class="dropdown-menu" id="guardadosDropdown">
    <button onclick="window.location.href='{{ url('/lugares-guardados')}}'">Lugares guardados</button>
    <button onclick="window.location.href='{{ url('/eventos-guardados')}}'">Eventos guardados</button>
  </div>
</div>

</div>


      <a href="{{ url('lugaresrecomendados') }}" class="nav-item">
        <img src="{{ asset('imagenes/lugares.png') }}" alt="Lugares" />
        Lugares
      </a>

      <a href="{{ url('eventosrecomendados') }}" class="nav-item">
        <img src="{{ asset('imagenes/eventos.png') }}" alt="Eventos" />
        Eventos
      </a>
    </div>

    <div class="navbar-right">
      <div class="dropdown">
        <a href="#" class="nav-item" onclick="toggleDropdown('perfilDropdown')">
          <img src="{{ asset('imagenes/perfil.png') }}" alt="Perfil" />
          Perfil
        </a>
        <div class="dropdown-menu" id="perfilDropdown">
          <button onclick="window.location.href='{{ url('/configuracion') }}'">Configuración de cuenta</button>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Cerrar sesión</button>
          </form>
        </div>
      </div>
    </div>
  </header>

  <script>
    function toggleDropdown(id) {
      const dropdown = document.getElementById(id);
      const allDropdowns = document.querySelectorAll('.dropdown-menu');

      allDropdowns.forEach(menu => {
        if (menu.id !== id) menu.style.display = 'none';
      });

      dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
    }

    document.addEventListener('click', function (e) {
      if (!e.target.closest('.dropdown')) {
        document.querySelectorAll('.dropdown-menu').forEach(menu => menu.style.display = 'none');
      }
    });
  </script>

</body>
</html>
