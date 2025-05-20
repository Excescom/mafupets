
let boton = document.getElementById("menu-button");
let menu = document.getElementById("menu");
let icono = document.getElementById("icono");

boton.addEventListener("click", ocultar);

function ocultar() {
    icono.classList.toggle("rotate-90");
    menu.classList.toggle("flex");
    menu.classList.toggle("flex-col");
    icono.classList.toggle("translate-y-2");
    icono.classList.toggle("translate-x-2");
    
    menu.classList.toggle("hidden");
}