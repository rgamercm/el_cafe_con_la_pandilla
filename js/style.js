const userPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
const currentTheme = localStorage.getItem('theme') || (userPrefersDark ? 'dark' : 'light');
document.body.setAttribute('data-theme', currentTheme);

const themeToggle = document.getElementById('themeToggle');
themeToggle.textContent = currentTheme === 'dark' ? '🌙' : '☀️';

themeToggle.addEventListener('click', () => {
    const newTheme = document.body.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
    document.body.setAttribute('data-theme', newTheme);
    localStorage.setItem('theme', newTheme);
    themeToggle.textContent = newTheme === 'dark' ? '🌙' : '☀️';
});

let currentIndex = 0;
const slides = document.querySelectorAll('.carousel-slide');
const totalSlides = slides.length;
const intervalTime = 5000;
let autoPlay = setInterval(nextSlide, intervalTime);

function showSlide(index) {
    document.getElementById('carousel').style.transform = `translateX(-${index * 100}%)`;
}

function nextSlide() {
    currentIndex = (currentIndex + 1) % totalSlides;
    showSlide(currentIndex);
}

function prevSlide() {
    currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
    showSlide(currentIndex);
}

document.querySelector('.carousel-container').addEventListener('mouseover', () => {
    clearInterval(autoPlay);
});

document.querySelector('.carousel-container').addEventListener('mouseout', () => {
    autoPlay = setInterval(nextSlide, intervalTime);
});

const audio = document.getElementById("backgroundMusic");

audio.volume = 0.03;

const lastTime = localStorage.getItem("audioCurrentTime") || 0;
audio.currentTime = lastTime;

audio.play();

audio.addEventListener("timeupdate", () => {
    localStorage.setItem("audioCurrentTime", audio.currentTime);
});

