<header class="navbar">
  <div class="navbar-left">
    <img src="{{ asset('imagenes/logo.png') }}" alt="Logo" class="logo"/>

    <div class="dropdown">
      <a href="#" class="nav-item" onclick="event.preventDefault(); toggleDropdown('guardadosDropdown')">
        <img src="{{ asset('imagenes/guardados.png') }}" alt="Guardados"/> Guardados
      </a>
      <div class="dropdown-menu" id="guardadosDropdown">
        <button onclick="window.location.href='{{ url('/lugares-guardados') }}'">Lugares guardados</button>
        <button onclick="window.location.href='{{ url('/eventos-guardados') }}'">Eventos guardados</button>
      </div>
    </div>

    <a href="lugaresrecomendados" class="nav-item">
      <img src="{{ asset('imagenes/lugares.png') }}" alt="Lugares"/> Lugares
    </a>

    <a href="eventosrecomendados" class="nav-item">
      <img src="{{ asset('imagenes/eventos.png') }}" alt="Eventos"/> Eventos
    </a>
  </div>

  <div class="navbar-right">
    <div class="dropdown">
      <a href="#" class="nav-item" onclick="event.preventDefault(); toggleDropdown('perfilDropdown')">
        <img src="{{ asset(Auth::user()->ruta_img_perfil) }}"
     alt="Perfil"
     style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;">

      </a>
      <div class="dropdown-menu" id="perfilDropdown">
        <button onclick="window.location.href='{{ url('/usuario/perfil') }}'">Configuración de cuenta</button>
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
    document.querySelectorAll('.dropdown-menu').forEach(menu => {
      if (menu.id !== id) menu.style.display = 'none';
    });
    dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
  }

  document.addEventListener('click', e => {
    if (!e.target.closest('.dropdown')) {
      document.querySelectorAll('.dropdown-menu').forEach(menu => menu.style.display = 'none');
    }
  });
</script>
