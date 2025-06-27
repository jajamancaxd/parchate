<!DOCTYPE html> 
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Formulario Usuario Primerizo</title>
    <link rel="stylesheet" href="{{ asset('css/usuarioprimerizo.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

    <main class="container">
        <h1>Personaliza tus recomendaciones</h1>
        <p>Selecciona tus lugares y eventos favoritos por orden de preferencia</p>

        <section class="form-section" data-tipo="lugares">
            <h2>Lugares predilectos</h2>
            <p>Selecciona 3 y ordénalos por prioridad</p>
            <div class="option-grid">
                <button class="select-btn" data-id="1">Balnearios</button>
                <button class="select-btn" data-id="2">Bar</button>
                <button class="select-btn" data-id="3">Discotecas</button>
                <button class="select-btn" data-id="4">Restaurantes</button>
                <button class="select-btn" data-id="5">Públicas</button>
                <button class="select-btn" data-id="6">Museos</button>
                <button class="select-btn" data-id="7">Centros Comerciales</button>
                <button class="select-btn" data-id="8">Miradores</button>
                <button class="select-btn" data-id="9">Parques</button>
                <button class="select-btn" data-id="10">Teatro</button>
                <button class="select-btn" data-id="11">Iglesias</button>
            </div>
        </section>

        <section class="form-section" data-tipo="eventos">
            <h2>Eventos predilectos</h2>
            <p>Selecciona 3 y ordénalos por prioridad</p>
            <div class="option-grid">
                <button class="select-btn" data-id="1">Deportivos</button>
                <button class="select-btn" data-id="2">Danza</button>
                <button class="select-btn" data-id="3">Culturales</button>
                <button class="select-btn" data-id="4">Exposiciones</button>
                <button class="select-btn" data-id="5">Conciertos</button>
                <button class="select-btn" data-id="6">Desfiles</button>
                <button class="select-btn" data-id="7">Teatro</button>
                <button class="select-btn" data-id="8">Gastronómicos</button>
                <button class="select-btn" data-id="9">Tecnológicos</button>
                <button class="select-btn" data-id="10">Religiosos</button>
            </div>
        </section>

        <button class="submit-btn" disabled>Aceptar</button>
    </main>

    <script>
        const redireccionDestino = "{{ route('lugares.recomendados') }}"; // Ruta de la página a la que se redirigirá al hacer clic en "Aceptar"
    </script>

    <script src="{{ asset('js/usuarioprimerizo.js') }}"></script>
</body>
</html>
