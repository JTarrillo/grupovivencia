/**
 * TARGET CAROUSEL - Auto-scrolling carousel module
 * ================================================
 * 
 * Carrusel automático que muestra 3-4 items a la vez
 * Controles manual + auto-advance cada 5 segundos
 */

const TargetCarousel = (() => {
    const config = {
        carousel: '#targetCarousel',
        container: '.target-cards-container',
        itemsPerView: 4, // Items mostrados a la vez
        autoAdvanceTime: 5000, // ms
        scrollBehavior: 'smooth', // smooth scroll
    };

    let currentIndex = 0;
    let autoPlayTimer = null;
    let isDragging = false;

    /**
     * Información del carrusel
     */
    const carousel = {
        element: null,
        totalItems: 0,
        visibleItems: config.itemsPerView,
        cardWidth: 0, // Se calcula dinámicamente
        gapWidth: 0, // Se calcula dinámicamente
    };

    /**
     * Inicializa el carrusel
     */
    const init = () => {
        console.log('🎠 Target Carousel initialized');
        
        carousel.element = document.querySelector(config.carousel);
        if (!carousel.element) {
            console.warn('⚠️ Carousel element not found');
            return;
        }

        carousel.totalItems = carousel.element.querySelectorAll('.target-card').length;
        
        // Agregar clase modo carrusel
        carousel.element.classList.add('carousel-mode');
        
        // Crear indicadores
        createIndicators();
        
        // Agregar event listeners
        attachEvents();
        
        // Calcular dimensiones después de que el DOM esté completamente renderizado
        setTimeout(() => {
            calculateCardDimensions();
            // Iniciar auto-play después de calcular dimensiones
            startAutoPlay();
        }, 100);
    };

    /**
     * Calcula dinámicamente el ancho de las tarjetas
     */
    const calculateCardDimensions = () => {
        // Esperar a que el DOM esté completamente renderizado
        requestAnimationFrame(() => {
            const firstCard = carousel.element?.querySelector('.target-card');
            const gridElement = carousel.element;
            
            if (!firstCard || !gridElement) {
                console.warn('⚠️ Could not find cards');
                return;
            }

            // Usar computed style del grid para obtener el gap
            const gridStyle = window.getComputedStyle(gridElement);
            const gap = parseFloat(gridStyle.gap) || 24;

            // Calcular ancho de una tarjeta con paddings incluidos
            const cardRect = firstCard.getBoundingClientRect();
            carousel.cardWidth = cardRect.width || firstCard.offsetWidth;
            carousel.gapWidth = gap;

            console.log(`📐 Card Width: ${carousel.cardWidth}px, Gap: ${carousel.gapWidth}px`);
            console.log(`📊 Total Items: ${carousel.totalItems}, Items Per View: ${config.itemsPerView}`);
        });
    };

    /**
     * Crea los puntos indicadores
     */
    const createIndicators = () => {
        const container = document.querySelector('#carouselIndicators');
        if (!container) return;

        const totalSlides = Math.ceil(carousel.totalItems - config.itemsPerView + 1);
        
        for (let i = 0; i < totalSlides; i++) {
            const dot = document.createElement('div');
            dot.className = `carousel-dot ${i === 0 ? 'active' : ''}`;
            dot.addEventListener('click', () => goToSlide(i));
            container.appendChild(dot);
        }
    };

    /**
     * Agrega event listeners a los botones
     */
    const attachEvents = () => {
        const prevBtn = document.getElementById('carouselPrev');
        const nextBtn = document.getElementById('carouselNext');
        const container = document.querySelector(config.container);

        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                stopAutoPlay();
                prevSlide();
                startAutoPlay();
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                stopAutoPlay();
                nextSlide();
                startAutoPlay();
            });
        }

        // Pausar auto-play en hover
        if (container) {
            container.addEventListener('mouseenter', stopAutoPlay);
            container.addEventListener('mouseleave', startAutoPlay);
        }

        // Soporte táctil
        let startX = 0;
        carousel.element?.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
            isDragging = true;
        });

        carousel.element?.addEventListener('touchend', (e) => {
            if (!isDragging) return;
            
            const endX = e.changedTouches[0].clientX;
            const diff = startX - endX;

            if (Math.abs(diff) > 50) {
                diff > 0 ? nextSlide() : prevSlide();
                stopAutoPlay();
                startAutoPlay();
            }
            
            isDragging = false;
        });
    };

    /**
     * Avanza al siguiente slide
     */
    const nextSlide = () => {
        const maxIndex = carousel.totalItems - config.itemsPerView;
        currentIndex = currentIndex < maxIndex ? currentIndex + 1 : 0;
        updateCarousel();
    };

    /**
     * Retrocede al slide anterior
     */
    const prevSlide = () => {
        const maxIndex = carousel.totalItems - config.itemsPerView;
        currentIndex = currentIndex > 0 ? currentIndex - 1 : maxIndex;
        updateCarousel();
    };

    /**
     * Ir a un slide específico
     */
    const goToSlide = (index) => {
        currentIndex = Math.max(0, Math.min(index, carousel.totalItems - config.itemsPerView));
        stopAutoPlay();
        updateCarousel();
        startAutoPlay();
    };

    /**
     * Actualiza la posición del carrusel
     */
    const updateCarousel = () => {
        if (!carousel.element) return;

        // Calcular scroll position
        const scrollPosition = currentIndex * (carousel.cardWidth + carousel.gapWidth);

        // Aplicar scroll smooth
        carousel.element.parentElement.scrollLeft = scrollPosition;

        console.log(`📍 Scrolling to index ${currentIndex}, position: ${scrollPosition}px`);

        // Actualizar indicadores
        updateIndicators();
        updateButtons();
    };

    /**
     * Actualiza los puntos indicadores
     */
    const updateIndicators = () => {
        const dots = document.querySelectorAll('.carousel-dot');
        const maxIndex = carousel.totalItems - config.itemsPerView;
        
        dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === currentIndex);
        });
    };

    /**
     * Actualiza el estado de los botones
     */
    const updateButtons = () => {
        const prevBtn = document.getElementById('carouselPrev');
        const nextBtn = document.getElementById('carouselNext');
        const maxIndex = carousel.totalItems - config.itemsPerView;

        if (prevBtn) prevBtn.disabled = currentIndex === 0;
        if (nextBtn) nextBtn.disabled = currentIndex === maxIndex;
    };

    /**
     * Inicia el auto-play
     */
    const startAutoPlay = () => {
        if (autoPlayTimer) return;
        
        autoPlayTimer = setInterval(() => {
            nextSlide();
        }, config.autoAdvanceTime);

        console.log('▶️  Carousel auto-play started');
    };

    /**
     * Detiene el auto-play
     */
    const stopAutoPlay = () => {
        if (autoPlayTimer) {
            clearInterval(autoPlayTimer);
            autoPlayTimer = null;
            console.log('⏸️  Carousel auto-play stopped');
        }
    };

    return {
        init,
        nextSlide,
        prevSlide,
        goToSlide,
    };
})();

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    TargetCarousel.init();
});
