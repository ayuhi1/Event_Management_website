document.addEventListener('DOMContentLoaded', function() {
    // Slider functionality
    const slider = document.querySelector('.slider');
    const slides = document.querySelectorAll('.slide');
    let currentSlide = 0;

    // Modal functionality
    const readMoreBtn = document.querySelector('.read-more-btn');
    const modalOverlay = document.createElement('div');
    modalOverlay.className = 'modal-overlay';
    document.body.appendChild(modalOverlay);

    modalOverlay.innerHTML = `
        <div class="modal">
            <button class="modal-close">&times;</button>
            <img src="images/slide1.jpeg" alt="Featured Image">
            <div class="modal-content">
                <h2>About Us</h2>
                <p>We are a leading event management company with years of experience in creating memorable experiences. Our team specializes in corporate events, trade shows, and conferences that help brands connect with their audiences in meaningful ways.</p>
                <p>Through innovative design and meticulous planning, we transform ordinary spaces into extraordinary environments that leave lasting impressions.</p>
            </div>
        </div>
    `;

    readMoreBtn.addEventListener('click', function(e) {
        e.preventDefault();
        modalOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    });

    const closeBtn = modalOverlay.querySelector('.modal-close');
    closeBtn.addEventListener('click', function() {
        modalOverlay.classList.remove('active');
        document.body.style.overflow = '';
    });

    modalOverlay.addEventListener('click', function(e) {
        if (e.target === modalOverlay) {
            modalOverlay.classList.remove('active');
            document.body.style.overflow = '';
        }
    });


    function updateSlider() {
        currentSlide = (currentSlide + 1) % slides.length;
        slider.style.transform = `translateX(-${currentSlide * 33.333}%)`;
    }

    // Backup JavaScript control in case CSS animation fails
    setInterval(updateSlider, 5000);

    // Add touch support for mobile devices
    let touchStartX = 0;
    let touchEndX = 0;

    slider.addEventListener('touchstart', function(e) {
        touchStartX = e.touches[0].clientX;
    });

    slider.addEventListener('touchend', function(e) {
        touchEndX = e.changedTouches[0].clientX;
        handleSwipe();
    });

    function handleSwipe() {
        const difference = touchStartX - touchEndX;
        if (Math.abs(difference) > 50) {
            if (difference > 0) {
                // Swipe left
                currentSlide = (currentSlide + 1) % slides.length;
            } else {
                // Swipe right
                currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            }
            slider.style.transform = `translateX(-${currentSlide * 33.333}%)`;
        }
    }
});