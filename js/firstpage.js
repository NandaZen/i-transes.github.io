let index = 0;
function moveSlide(step) {
    const carousel = document.querySelector('.carousel');
    const totalSlides = document.querySelectorAll('.car').length;
    index = (index + step + totalSlides) % totalSlides;
    
    // Debugging
    console.log(`Moving to slide: ${index}`); // Menampilkan indeks slide

    carousel.style.transition = 'transform 0.7s ease-in-out';  // Menambahkan durasi transisi setiap kali slide bergerak
    carousel.style.transform = `translateX(-${index * 100}%)`;
}
