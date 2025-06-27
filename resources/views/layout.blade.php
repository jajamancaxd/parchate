<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>@yield('title', 'Parchate')</title>

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <!-- Estilos personalizados -->
  <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
  @yield('styles')
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Logo -->
    <div class="logo">
      <img src="{{ asset('imagenes/logo.png') }}" alt="Logo Parchate">
      <span class="logo-text">PARCHATE</span>
    </div>

    <div class="menu-section-title">MENÚ</div>

    <!-- Menú principal -->
    <a href="{{ route('Lugares') }}" class="menu-link">
      <i class="bi bi-layout-sidebar-inset"></i> Revisión Lugares
    </a>

    <a href="{{ route('Eventos') }}" class="menu-link">
      <i class="bi bi-magic"></i> Revisión Eventos
    </a>

    <!-- Otros -->
    <div class="menu-section-title otros">OTROS</div>

    <a href="{{ route('Negocios') }}" class="menu-link otros-link">
      <i class="bi bi-gear"></i> Revisión Negocios
    </a>

    <a href="{{ route('Administradores') }}" class="menu-link otros-link">
      <i class="bi bi-people-fill"></i> Administradores
    </a>

     <!-- Mostrar nombre administrador actual -->
    <div class="logout-container">
  <div class="admin-name">
    {{ Auth::user()->nombre_usuario_administrador ?? 'Usuario' }} /
    {{ Auth::user()->rol_del_administrador ?? 'Rol' }}
  </div>
  
  <form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit" class="logout-link" title="Cerrar sesión">
      <i class="bi bi-power"></i> Cerrar sesión
    </button>
  </form>
</div>


  </div>


  <!-- Contenido principal -->
  <main class="content">
    @yield('content')
    @yield('scripts')
  </main>

</body>
</html>
