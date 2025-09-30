/**
 * Delivery Carousel Functionality
 * Handles automatic rotation and manual navigation of the delivery hero carousel
 */

document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.querySelector('.carousel-container');
    if (!carousel) return;

    const slides = carousel.querySelectorAll('.carousel-slide');
    const indicators = carousel.querySelectorAll('.indicator');
    let currentSlide = 0;
    let slideInterval;

    // Function to show a specific slide
    function showSlide(index) {
        // Remove active class from all slides and indicators
        slides.forEach(slide => slide.classList.remove('active'));
        indicators.forEach(indicator => indicator.classList.remove('active'));

        // Add active class to current slide and indicator
        slides[index].classList.add('active');
        indicators[index].classList.add('active');

        currentSlide = index;
    }

    // Function to go to next slide
    function nextSlide() {
        const nextIndex = (currentSlide + 1) % slides.length;
        showSlide(nextIndex);
    }

    // Function to start automatic rotation
    function startCarousel() {
        slideInterval = setInterval(nextSlide, 4000); // Change slide every 4 seconds
    }

    // Function to stop automatic rotation
    function stopCarousel() {
        clearInterval(slideInterval);
    }

    // Add click event listeners to indicators
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', function() {
            showSlide(index);
            stopCarousel();
            startCarousel(); // Restart automatic rotation
        });
    });

    // Pause carousel on hover
    carousel.addEventListener('mouseenter', stopCarousel);
    carousel.addEventListener('mouseleave', startCarousel);

    // Start the carousel
    startCarousel();

    // Optional: Add keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft') {
            const prevIndex = currentSlide === 0 ? slides.length - 1 : currentSlide - 1;
            showSlide(prevIndex);
            stopCarousel();
            startCarousel();
        } else if (e.key === 'ArrowRight') {
            nextSlide();
            stopCarousel();
            startCarousel();
        }
    });
});
