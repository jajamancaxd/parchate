@extends('layout')

@section('title', 'Negocios')

@section('styles')
  <link rel="stylesheet" href="{{ asset('css/Negocios/style.css') }}">
@endsection

@section('content')

<div class="negocios-container">
    <h3 class="titulo">Negocios</h3>

    <div class="flash-messages">
        @if(session('success'))
            <div class="flash-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="flash-error">{{ session('error') }}</div>
        @endif
    </div>

    <div class="tarjetas-grid">
        @foreach ($negocios as $negocio)
            <a href="{{ route('Negocios.Show', $negocio->id_negocio) }}" class="tarjeta-negocio">
                <img src="{{ asset('images/default2.png') }}" alt="Logo de {{ $negocio->nombre_negocio }}">
                <div class="tarjeta-negocio-content">
                    <h4>{{ $negocio->nombre_negocio }}</h4>
                    <p>{{ $negocio->correo_electronico_negocios }}</p>
                </div>
            </a>
        @endforeach
    </div>
</div>

@endsection

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    setTimeout(() => {
      document.querySelectorAll('.flash-messages > *').forEach(el => {
        el.style.transition = 'opacity 0.5s ease';
        el.style.opacity = '0';
        setTimeout(() => {
          el.style.display = 'none';
        }, 500);
      });
    }, 3000);
  });
</script>
@endsection
