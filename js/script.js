document.addEventListener('DOMContentLoaded', function() {
    // Profile dropdown toggle functionality
    const userProfile = document.querySelector('.user-profile');
    if (userProfile) {
        userProfile.addEventListener('click', function(e) {
            e.stopPropagation();
            this.classList.toggle('active');
        });
        
        // Close dropdown only when clicking outside
        // This ensures dropdown stays visible until clicked again
        document.addEventListener('click', function(e) {
            if (!userProfile.contains(e.target)) {
                userProfile.classList.remove('active');
            }
        });
    }
    
    // Slider functionality
    const slides = document.querySelectorAll('.slide');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    let currentSlide = 0;
    
    // Initialize the first slide
    if (slides.length > 0) {
        slides[0].classList.add('active');
    }
    
    // Function to show a specific slide
    function showSlide(index) {
        // Hide all slides
        slides.forEach(slide => {
            slide.classList.remove('active');
        });
        
        // Show the selected slide
        slides[index].classList.add('active');
    }
    
    // Next slide function
    function nextSlide() {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
    }
    
    // Previous slide function
    function prevSlide() {
        currentSlide = (currentSlide - 1 + slides.length) % slides.length;
        showSlide(currentSlide);
    }
    
    // Add event listeners to buttons if they exist
    if (prevBtn) {
        prevBtn.addEventListener('click', prevSlide);
    }
    
    if (nextBtn) {
        nextBtn.addEventListener('click', nextSlide);
    }
    
    // Auto-advance slides every 5 seconds
    setInterval(nextSlide, 5000);
    
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


    // Add touch support for mobile devices
    const slider = document.querySelector('.slider');
    if (slider) {
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
                    nextSlide();
                } else {
                    // Swipe right
                    prevSlide();
                }
            }
        }
    }
});