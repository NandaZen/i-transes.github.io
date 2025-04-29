let index = 0;

function moveSlide(step) {
    const carousel = document.querySelector('.carousel');
    const totalSlides = document.querySelectorAll('.car').length;
    index = (index + step + totalSlides) % totalSlides;

    console.log(`Moving to slide: ${index}`);

    carousel.style.transition = 'transform 0.7s ease-in-out';
    carousel.style.transform = `translateX(-${index * 100}%)`;
}

// === Observer untuk animasi tampil ===
const sections = document.querySelectorAll("section");

const observer = new IntersectionObserver(entries => {
  entries.forEach((entry, i) => {
    if (entry.isIntersecting && !entry.target.classList.contains("show")) {
      // Tambahkan delay berdasarkan urutan section
      setTimeout(() => {
        entry.target.classList.add("show");
      }, i * 300);
    }
  });
}, {
  threshold: 0.1
});

sections.forEach(section => { 
  observer.observe(section);
});
