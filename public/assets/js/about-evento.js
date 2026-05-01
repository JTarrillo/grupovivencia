/**
 * ABOUT-EVENTO PAGE - Stars Animation & Interactions
 * ================================================
 * 
 * Maneja las animaciones de las estrellas (why-items)
 * Componentes modulares y responsables
 */

// ========================================
// MODULE: Stars Animation
// ========================================
const StarsAnimation = (() => {
    const config = {
        container: '.why-items-container',
        items: '.why-item',
        animationDuration: 6000, // ms
        floatDistance: 8, // pixels
    };

    /**
     * Inicializa las animaciones de las estrellas
     */
    const init = () => {
        console.log('🌟 Stars Animation initialized');
        applyStaggeredAnimation();
        attachInteractions();
    };

    /**
     * Aplica animaciones escalonadas a cada estrella
     */
    const applyStaggeredAnimation = () => {
        const items = document.querySelectorAll(config.items);
        items.forEach((item, index) => {
            const delay = index * (config.animationDuration / 4);
            item.style.animationDelay = `${delay / 1000}s`;
        });
    };

    /**
     * Agrega interacciones al pasar el mouse
     */
    const attachInteractions = () => {
        const items = document.querySelectorAll(config.items);
        
        items.forEach(item => {
            item.addEventListener('mouseenter', () => {
                item.style.animationPlayState = 'paused';
            });

            item.addEventListener('mouseleave', () => {
                item.style.animationPlayState = 'running';
            });
        });
    };

    return {
        init,
    };
})();

// ========================================
// MODULE: Smooth Scroll
// ========================================
const SmoothScroll = (() => {
    /**
     * Inicializa smooth scroll para enlaces CTA
     */
    const init = () => {
        const ctaButtons = document.querySelectorAll('.btn-primary-about, .btn-outline-about');
        
        ctaButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                const href = button.getAttribute('href');
                if (href && href.includes('#')) {
                    e.preventDefault();
                    smoothScrollToElement(href);
                }
            });
        });
    };

    /**
     * Realiza scroll suave a un elemento
     */
    const smoothScrollToElement = (selector) => {
        const element = document.querySelector(selector);
        if (element) {
            element.scrollIntoView({ behavior: 'smooth' });
        }
    };

    return {
        init,
    };
})();

// ========================================
// MODULE: Performance Optimization
// ========================================
const Performance = (() => {
    /**
     * Detecta si el navegador prefiere movimiento reducido
     */
    const prefersReducedMotion = () => {
        return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    };

    /**
     * Desactiva animaciones en navegadores con reduced motion
     */
    const respectMotionPreference = () => {
        if (prefersReducedMotion()) {
            console.log('⚠️ User prefers reduced motion - disabling animations');
            const style = document.createElement('style');
            style.textContent = `
                .why-item {
                    animation: none !important;
                }
            `;
            document.head.appendChild(style);
        }
    };

    return {
        respectMotionPreference,
        prefersReducedMotion,
    };
})();

// ========================================
// INITIALIZATION
// ========================================
document.addEventListener('DOMContentLoaded', () => {
    // Respetar preferencias de movimiento del usuario
    Performance.respectMotionPreference();
    
    // Inicializar módulos
    StarsAnimation.init();
    SmoothScroll.init();
    
    console.log('✅ About-Evento page initialized');
});
