/**
 * EventCarousel.js
 * Carrusel creativo para galería de eventos con miniaturas deslizables
 */

class EventCarousel {
    constructor(options = {}) {
        this.selector = options.selector || '#eventCarousel';
        this.carouselElement = document.querySelector(this.selector);
        
        if (!this.carouselElement) {
            console.warn('EventCarousel: Element not found:', this.selector);
            return;
        }
        
        this.currentIndex = 0;
        this.images = [
            { src: '/assets/front/img/slides/slide1.jpg', label: 'Sala Principal' },
            { src: '/assets/front/img/slides/slide2.jpg', label: 'Expositores' },
            { src: '/assets/front/img/slides/slide3.jpg', label: 'Networking' },
            { src: '/assets/front/img/slides/slide1.jpg', label: 'Participantes' }
        ];
        
        this.autoPlayInterval = null;
        this.autoPlay = options.autoPlay !== false;
        this.autoPlayDelay = options.autoPlayDelay || 30000;
        
        this.init();
    }
    
    init() {
        this.setupElements();
        this.setupEventListeners();
        this.updateCarousel();
        
        if (this.autoPlay) {
            this.startAutoPlay();
        }
        
        console.log('EventCarousel initialized');
    }
    
    setupElements() {
        this.mainImage = this.carouselElement.querySelector('.carousel-main-image');
        this.prevBtn = this.carouselElement.querySelector('.carousel-nav-prev');
        this.nextBtn = this.carouselElement.querySelector('.carousel-nav-next');
        this.thumbnails = this.carouselElement.querySelectorAll('.carousel-thumbnail');
        this.indicators = this.carouselElement.querySelectorAll('.indicator');
        this.currentSlideDisplay = document.querySelector('#currentSlide');
        this.thumbnailsContainer = this.carouselElement.querySelector('.carousel-thumbnails');
    }
    
    setupEventListeners() {
        // Botones de navegación
        this.prevBtn.addEventListener('click', () => this.previousSlide());
        this.nextBtn.addEventListener('click', () => this.nextSlide());
        
        // Miniaturas
        this.thumbnails.forEach((thumb, index) => {
            thumb.addEventListener('click', () => {
                this.pauseAutoPlay();
                this.goToSlide(index);
                this.resetAutoPlay();
            });
        });
        
        // Indicadores
        this.indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                this.pauseAutoPlay();
                this.goToSlide(index);
                this.resetAutoPlay();
            });
        });
        
        // Teclado
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') this.previousSlide();
            if (e.key === 'ArrowRight') this.nextSlide();
        });
        
        // Pausa al hover
        this.carouselElement.addEventListener('mouseenter', () => {
            this.pauseAutoPlay();
        });
        
        this.carouselElement.addEventListener('mouseleave', () => {
            if (this.autoPlay) {
                this.resetAutoPlay();
            }
        });
    }
    
    goToSlide(index) {
        this.currentIndex = (index + this.images.length) % this.images.length;
        this.updateCarousel();
    }
    
    nextSlide() {
        this.goToSlide(this.currentIndex + 1);
    }
    
    previousSlide() {
        this.goToSlide(this.currentIndex - 1);
    }
    
    updateCarousel() {
        const currentImage = this.images[this.currentIndex];
        
        // Fade out
        this.mainImage.style.opacity = '0';
        
        // Cambiar imagen después de fade out
        setTimeout(() => {
            this.mainImage.src = currentImage.src;
            this.mainImage.style.opacity = '1';
        }, 150);
        
        // Actualizar miniaturas
        this.thumbnails.forEach((thumb, index) => {
            thumb.classList.toggle('active', index === this.currentIndex);
        });
        
        // Actualizar indicadores
        this.indicators.forEach((indicator, index) => {
            indicator.classList.toggle('active', index === this.currentIndex);
        });
        
        // Actualizar contador
        if (this.currentSlideDisplay) {
            this.currentSlideDisplay.textContent = this.currentIndex + 1;
        }
        
        // Scroll miniaturas al centro
        this.scrollThumbnailsToCenter();
        
        // Dispatch evento personalizado
        this.dispatchEvent({
            type: 'carouselSlideChange',
            detail: {
                currentIndex: this.currentIndex,
                currentImage: currentImage
            }
        });
    }
    
    scrollThumbnailsToCenter() {
        if (!this.thumbnailsContainer) return;
        
        const activeThumbnail = this.thumbnails[this.currentIndex];
        const containerWidth = this.thumbnailsContainer.clientWidth;
        const thumbWidth = activeThumbnail.clientWidth;
        const scrollPosition = activeThumbnail.offsetLeft - 
                               (containerWidth / 2) + 
                               (thumbWidth / 2);
        
        this.thumbnailsContainer.scrollTo({
            left: scrollPosition,
            behavior: 'smooth'
        });
    }
    
    startAutoPlay() {
        this.autoPlayInterval = setInterval(() => {
            this.nextSlide();
        }, this.autoPlayDelay);
    }
    
    pauseAutoPlay() {
        if (this.autoPlayInterval) {
            clearInterval(this.autoPlayInterval);
            this.autoPlayInterval = null;
        }
    }
    
    resetAutoPlay() {
        this.pauseAutoPlay();
        if (this.autoPlay) {
            this.startAutoPlay();
        }
    }
    
    dispatchEvent(data) {
        const event = new CustomEvent('eventCarousel:slideChange', { detail: data.detail });
        document.dispatchEvent(event);
    }
    
    destroy() {
        this.pauseAutoPlay();
        console.log('EventCarousel destroyed');
    }
}

export default EventCarousel;
