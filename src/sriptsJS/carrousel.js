const slider = document.getElementById("slider");
const prev = document.getElementById("prev");
const next = document.getElementById("next");

let index = 0;

next.addEventListener("click", () => {
    index = (index + 1) % 3; // Cambia según el número de imágenes

    updateSlider();
});

prev.addEventListener("click", () => {
    index = (index - 1 + 3) % 3;
    updateSlider();
});

function updateSlider() {
    const translateX = -index * 100;
    slider.style.transform = `translateX(${translateX}%)`;
}


function carrouselAdaptativo(index,cantidad)
{
    
    next.addEventListener("click", () => {
        index = (index + 1) % cantidad; // Cambia según el número de imágenes
    
        updateSlider();
    });
    
    prev.addEventListener("click", () => {
        index = (index - 1 + cantidad) % cantidad;
        updateSlider();
    });
    
    function updateSlider() {
        const translateX = -index * 100;
        slider.style.transform = `translateX(${translateX}%)`;
    }
}