const carousel = document.querySelector('.carousel');
const items = document.querySelectorAll('.car');
const prev = document.querySelector('.prev');
const next = document.querySelector('.next');
let currentIndex = 0;

function getItemsPerSlide() {
  const screenWidth = window.innerWidth;

  if (screenWidth >= 1400) {
    return 4;
  } else if (screenWidth >= 1200) {
    return 2;
  } else if (screenWidth >= 768) {
    return 1;
  } else {
    return 1;
  }
}

function updateCarousel() {
  const itemsPerSlide = getItemsPerSlide();
  const offset = currentIndex * (100 / itemsPerSlide);
  carousel.style.transform = `translateX(-${offset}%)`;
  carousel.style.transition = 'transform 0.5s ease'; // optional
  console.log("Current Index:", currentIndex);
}

next.addEventListener('click', () => {
  const itemsPerSlide = getItemsPerSlide();
  const maxIndex = items.length - itemsPerSlide;

  if (currentIndex >= maxIndex) {
    currentIndex = 0; // balik ke awal
  } else {
    currentIndex++;
  }

  updateCarousel();
});

prev.addEventListener('click', () => {
  const itemsPerSlide = getItemsPerSlide();
  const maxIndex = items.length - itemsPerSlide;

  if (currentIndex <= 0) {
    currentIndex = maxIndex; // balik ke akhir
  } else {
    currentIndex--;
  }

  updateCarousel();
});

window.addEventListener('resize', () => {
  // Reset index agar tidak error saat jumlah item per slide berubah
  const itemsPerSlide = getItemsPerSlide();
  const maxIndex = items.length - itemsPerSlide;
  if (currentIndex > maxIndex) {
    currentIndex = maxIndex;
  }
  updateCarousel();
});

updateCarousel();

// Animasi bagian .section jika diperlukan
const sections = document.querySelectorAll('.section');

sections.forEach((section, index) => {
  setTimeout(() => {
    section.classList.add('show');
  }, index * 300);
});
