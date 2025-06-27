document.addEventListener("DOMContentLoaded", () => {
    const selectButtons = document.querySelectorAll(".select-btn");
    const submitButton = document.querySelector(".submit-btn");

    selectButtons.forEach(button => {
        button.addEventListener("click", () => {
            const section = button.closest(".form-section");
            const selected = section.querySelectorAll(".select-btn.selected");

            if (!button.classList.contains("selected") && selected.length >= 3) {
                alert("Solo puedes seleccionar 3 opciones por categoría.");
                return;
            }

            button.classList.toggle("selected");
            checkSelections();
        });
    });

    function checkSelections() {
        const sections = document.querySelectorAll(".form-section");
        let allValid = true;

        sections.forEach(section => {
            const selected = section.querySelectorAll(".select-btn.selected");
            if (selected.length !== 3) {
                allValid = false;
            }
        });

        submitButton.disabled = !allValid;
    }

    submitButton.addEventListener("click", () => {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const lugares = [];
        const eventos = [];

        document.querySelector('[data-tipo="lugares"]').querySelectorAll(".select-btn").forEach((btn, i) => {
            const id = parseInt(btn.getAttribute("data-id"));
            const index = btn.classList.contains("selected") ? [...btn.parentElement.children].filter(b => b.classList.contains("selected")).indexOf(btn) : null;
            lugares.push({
                id,
                puntos: index === 0 ? 3 : index === 1 ? 2 : index === 2 ? 1 : null
            });
        });

        document.querySelector('[data-tipo="eventos"]').querySelectorAll(".select-btn").forEach((btn, i) => {
            const id = parseInt(btn.getAttribute("data-id"));
            const index = btn.classList.contains("selected") ? [...btn.parentElement.children].filter(b => b.classList.contains("selected")).indexOf(btn) : null;
            eventos.push({
                id,
                puntos: index === 0 ? 3 : index === 1 ? 2 : index === 2 ? 1 : null
            });
        });

        fetch("/preferencias", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            body: JSON.stringify({ lugares, eventos })
        })
        .then(res => res.json())
        .then(data => {
            alert(data.mensaje || "¡Preferencias guardadas!");
            window.location.href = redireccionDestino; //esta es la vista a modificar
        })
        .catch(err => {
            console.error("❌ Error:", err);
            alert("Ocurrió un error al guardar las preferencias.");
        });
    });
});
