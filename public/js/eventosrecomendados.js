document.addEventListener('DOMContentLoaded', () => {
    const inputBuscar = document.querySelector('.buscador input');
    const btnBuscar = document.querySelector('.buscador button');
    const tarjetas = document.querySelectorAll('.tarjeta');
    const contenedor = document.querySelector('.tarjetas');
    const botonesLeerMas = document.querySelectorAll('.leer-mas');

    // Buscar al presionar el botón
    btnBuscar.addEventListener('click', () => {
        const texto = inputBuscar.value.toLowerCase();
        let tarjetasVisibles = 0;

        tarjetas.forEach(tarjeta => {
            const nombre = tarjeta.querySelector('.nombre').textContent.toLowerCase();
            if (nombre.includes(texto)) {
                tarjeta.style.display = 'flex';
                tarjetasVisibles++;
            } else {
                tarjeta.style.display = 'none';
            }
        });

        if (tarjetasVisibles === 1) {
            contenedor.classList.add('centrado');
        } else {
            contenedor.classList.remove('centrado');
        }
    });

    // Leer más / Leer menos
    botonesLeerMas.forEach(boton => {
        boton.addEventListener('click', (e) => {
            e.preventDefault();

            const tarjetaSeleccionada = boton.closest('.tarjeta');

            if (boton.textContent === 'Leer más') {
                // Ocultar todas las tarjetas
                tarjetas.forEach(tarjeta => {
                    tarjeta.style.display = 'none';
                });

                // Mostrar solo la seleccionada
                tarjetaSeleccionada.style.display = 'flex';
                contenedor.classList.add('centrado');

                // Cambiar a "Leer menos"
                boton.textContent = 'Leer menos';
            } else {
                // Mostrar todas las tarjetas nuevamente
                tarjetas.forEach(tarjeta => {
                    tarjeta.style.display = 'flex';
                });

                contenedor.classList.remove('centrado');

                // Cambiar de nuevo a "Leer más"
                boton.textContent = 'Leer más';
            }
        });
    });

    // ✅ Mostrar/ocultar el filtro
    const filtroBtn = document.getElementById("filtro-btn");
    const filtroBox = document.getElementById("filtro-box");
    const cancelarBtn = document.querySelector(".btn-cancelar");

    if (filtroBtn && filtroBox) {
        filtroBtn.addEventListener("click", () => {
            filtroBox.style.display = filtroBox.style.display === "block" ? "none" : "block";
        });
    }

    if (cancelarBtn) {
        cancelarBtn.addEventListener("click", () => {
            filtroBox.style.display = "none";
        });
    }
});

function toggleDescripcion(id) {
    const descripcion = document.getElementById('descripcion-' + id);
    const boton = document.getElementById('btn-' + id);

    // Si el texto está expandido
    if (descripcion.style.webkitLineClamp === 'unset') {
        // Contraer texto
        descripcion.style.display = '-webkit-box';
        descripcion.style.webkitLineClamp = '3';
        descripcion.style.maxHeight = '4.5em';
        boton.textContent = 'Read More';
    } else {
        // Expandir texto
        descripcion.style.webkitLineClamp = 'unset';
        descripcion.style.maxHeight = 'none';
        boton.textContent = 'Read Less';
    }
}

        const filtroBtn = document.getElementById("filtro-btn");
        const filtroBox = document.getElementById("filtro-box");
        const cancelarBtn = document.querySelector(".btn-cancelar");

        filtroBtn.addEventListener("click", () => {
            filtroBox.style.display = filtroBox.style.display === "block" ? "none" : "block";
        });

        cancelarBtn.addEventListener("click", () => {
            filtroBox.style.display = "none";
        });