// Configuración del carrusel
let currentIndex = 0;
const slides = document.querySelectorAll('.carousel-slide');
const totalSlides = slides.length;
const intervalTime = 5000;
let autoPlay;

function showSlide(index) {
    const carousel = document.getElementById('carousel');
    if (carousel) {
        carousel.style.transform = `translateX(-${index * 100}%)`;
    }
}

function nextSlide() {
    currentIndex = (currentIndex + 1) % totalSlides;
    showSlide(currentIndex);
}

function prevSlide() {
    currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
    showSlide(currentIndex);
}

function startAutoPlay() {
    autoPlay = setInterval(nextSlide, intervalTime);
}

// Pausar el carrusel cuando el mouse está sobre él
const carouselContainer = document.querySelector('.carousel-container');
if (carouselContainer) {
    carouselContainer.addEventListener('mouseenter', () => {
        clearInterval(autoPlay);
    });
    
    carouselContainer.addEventListener('mouseleave', startAutoPlay);
}

// Iniciar el carrusel cuando la página carga
document.addEventListener('DOMContentLoaded', () => {
    showSlide(currentIndex);
    startAutoPlay();
    
    // Configurar los botones de navegación
    const prevBtn = document.querySelector('.prev');
    const nextBtn = document.querySelector('.next');
    
    if (prevBtn) prevBtn.addEventListener('click', prevSlide);
    if (nextBtn) nextBtn.addEventListener('click', nextSlide);
});