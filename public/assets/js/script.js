const slider = document.getElementById("slider");
const slides = document.querySelectorAll(".slide");
let index = 0;

function showSlide() {
    slider.style.transform = `translateX(-${index * 100}%)`;
}

function nextSlide() {
    index = (index + 1) % slides.length;
    showSlide();
}

function prevSlide() {
    index = (index - 1 + slides.length) % slides.length;
    showSlide();
}

setInterval(nextSlide, 5000);