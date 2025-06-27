@extends('layout')

@section('title', 'Administradores')

{{-- Estilos extra para responsividad ligera --}}
@section('styles')
  <link rel="stylesheet" href="{{ asset('css/Administradores/style.css') }}">

  <style>
    /* Ajustes rápidos de responsividad (puedes moverlos a tu CSS) */
    @media (max-width: 600px) {
      .admin-cards { flex-direction: column; align-items: center; }
      .admin-card { width: 90%; }
    }
  </style>
@endsection

@section('content')
  <div class="admin-header" style="display:flex;align-items:center;gap:1rem;flex-wrap:wrap;">
    <h1 style="margin:0;">Administradores</h1>

    {{-- Mensajes flash (éxito / error / info) --}}
    <div class="flash-messages">
      @if(session('success'))
        <p class="flash-success">{{ session('success') }}</p>
      @endif
      @if(session('error'))
        <p class="flash-error">{{ session('error') }}</p>
      @endif
      @if(session('info'))
        <p class="flash-info">{{ session('info') }}</p>
      @endif
    </div>

    {{-- Botón “Agregar Usuario” solo para líderes --}}
    @if(auth()->check() && auth()->user()->rol_del_administrador === 'lider')
      <a href="{{ route('Administradores.Crear') }}" class="add-user-btn">Agregar Usuario</a>
    @endif
  </div>

  <div class="admin-cards">
    @forelse ($administradores as $admin)
      <div class="admin-card">
        <img src="{{ asset('images/perfil.png') }}" alt="Avatar" />
        <div class="admin-info">
          <h3>{{ $admin->nombre_usuario_administrador }}</h3>
          <p class="role">{{ ucfirst($admin->rol_del_administrador) }}</p>
          <p class="email">{{ $admin->correo_electronico_administrador }}</p>

          {{-- Acciones SOLO para líderes y nunca sobre sí mismo --}}
          @if(auth()->check() && auth()->user()->rol_del_administrador === 'lider' && auth()->user()->correo_electronico_administrador !== $admin->correo_electronico_administrador)
            <div class="actions">
              <a href="{{ route('Administradores.Modificar', $admin->correo_electronico_administrador) }}" class="add-user-btn">Modificar</a>

              <form action="{{ route('Administradores.Eliminar', $admin->correo_electronico_administrador) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-delete" onclick="return confirm('¿Estás seguro de eliminar este administrador?')">Eliminar</button>
              </form>
            </div>
          @endif
        </div>
      </div>
    @empty
      <p class="no-admins">No hay administradores registrados.</p>
    @endforelse
  </div>
@endsection

@section('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      setTimeout(() => {
        document.querySelectorAll('.flash-messages p').forEach(el => {
          el.style.transition = 'opacity 0.5s ease';
          el.style.opacity = '0';
          setTimeout(() => el.remove(), 500);
        });
      }, 3000);
    });
  </script>
@endsection
