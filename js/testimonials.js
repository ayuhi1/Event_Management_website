document.addEventListener('DOMContentLoaded', function() {
    // Function to initialize testimonial sliders
    function initTestimonialSliders() {
        const testimonialSliders = document.querySelectorAll('.testimonial-grid, .testimonial-slider');
        
        testimonialSliders.forEach(slider => {
            // Get all testimonial cards in this slider
            const cards = slider.querySelectorAll('.testimonial-card');
            if (cards.length <= 1) return; // No need to scroll if only one card
            
            let currentIndex = 0;
            const totalCards = cards.length;
            
            // Create navigation buttons if they don't exist
            if (!slider.querySelector('.testimonial-nav')) {
                const navContainer = document.createElement('div');
                navContainer.className = 'testimonial-nav';
                
                const prevBtn = document.createElement('button');
                prevBtn.className = 'testimonial-nav-btn prev';
                prevBtn.innerHTML = '<i class="fas fa-chevron-left"></i>';
                
                const nextBtn = document.createElement('button');
                nextBtn.className = 'testimonial-nav-btn next';
                nextBtn.innerHTML = '<i class="fas fa-chevron-right"></i>';
                
                navContainer.appendChild(prevBtn);
                navContainer.appendChild(nextBtn);
                
                // Add navigation after the slider
                slider.parentNode.insertBefore(navContainer, slider.nextSibling);
                
                // Add event listeners to buttons
                prevBtn.addEventListener('click', () => {
                    currentIndex = (currentIndex - 1 + totalCards) % totalCards;
                    updateSlider();
                });
                
                nextBtn.addEventListener('click', () => {
                    currentIndex = (currentIndex + 1) % totalCards;
                    updateSlider();
                });
            }
            
            // Function to update the slider position
            function updateSlider() {
                cards.forEach((card, index) => {
                    if (index === currentIndex) {
                        card.style.display = 'block';
                        card.classList.add('active');
                    } else {
                        card.style.display = 'none';
                        card.classList.remove('active');
                    }
                });
            }
            
            // Initialize the slider
            updateSlider();
            
            // Auto-scroll every 5 seconds
            setInterval(() => {
                currentIndex = (currentIndex + 1) % totalCards;
                updateSlider();
            }, 5000);
        });
    }
    
    // Initialize testimonial sliders
    initTestimonialSliders();
});