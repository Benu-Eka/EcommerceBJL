// resources/js/carousel.js

document.addEventListener('DOMContentLoaded', function() {
    const slidesContainer = document.getElementById('slides-container');
    const indicatorsContainer = document.getElementById('carousel-indicators');
    
    // Cek apakah elemen ada sebelum melanjutkan
    if (!slidesContainer || !indicatorsContainer) {
        console.error("Carousel elements not found. Stopping script.");
        return;
    }

    const slides = slidesContainer.children;
    const totalSlides = slides.length;
    let currentSlide = 0;
    let slideInterval;
    
    // **Tambahan: Perbaiki Durasi Transisi di HTML menjadi duration-500/700
    // atau tambahkan class di JS jika Anda tidak ingin mengubah HTML:**
    // slidesContainer.classList.add('duration-500'); 
    
    // 1. Inisialisasi Indikator
    for (let i = 0; i < totalSlides; i++) {
        const indicator = document.createElement('button');
        indicator.classList.add('w-2.5', 'h-2.5', 'rounded-full', 'bg-white', 'bg-opacity-50', 'hover:bg-opacity-100', 'transition', 'duration-300');
        if (i === 0) {
            indicator.classList.add('!bg-opacity-100', 'w-6');
        }
        indicator.dataset.index = i;
        indicator.addEventListener('click', () => {
            goToSlide(i);
            resetInterval();
        });
        indicatorsContainer.appendChild(indicator);
    }

    const indicators = indicatorsContainer.children;

    // 2. Fungsi Transisi Slide
    function goToSlide(index) {
        currentSlide = index;
        const offset = -index * 100;
        slidesContainer.style.transform = `translateX(${offset}%)`;
        
        // Update Indikator
        Array.from(indicators).forEach((indicator, i) => {
            indicator.classList.remove('!bg-opacity-100', 'w-6');
            indicator.classList.add('bg-opacity-50', 'w-2.5');
            if (i === index) {
                indicator.classList.add('!bg-opacity-100', 'w-6');
            }
        });
    }

    // 3. Fungsi Auto-Slide
    function startInterval() {
        slideInterval = setInterval(() => {
            currentSlide = (currentSlide + 1) % totalSlides;
            goToSlide(currentSlide);
        }, 5000); // Ganti slide setiap 5 detik
    }

    // 4. Fungsi Reset Interval
    function resetInterval() {
        clearInterval(slideInterval);
        startInterval();
    }

    // Mulai Auto-Slide saat halaman dimuat
    startInterval();
});