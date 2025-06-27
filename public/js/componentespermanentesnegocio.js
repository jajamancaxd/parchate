const iconoPerfil = document.getElementById("icono-perfil");
const submenu = document.getElementById("submenu-perfil");

iconoPerfil.addEventListener("click", () => {
  submenu.style.display = submenu.style.display === "block" ? "none" : "block";
});

// Cierra el menú si se hace clic fuera
window.addEventListener("click", function(e) {
  if (!iconoPerfil.contains(e.target) && !submenu.contains(e.target)) {
    submenu.style.display = "none";
  }
});
