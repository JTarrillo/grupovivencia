/**
 * ========================================
 * VIVELAND - Main JavaScript
 * Initialize all components
 * ========================================
 */

import Gallery from './components/Gallery.js';
import Carousel from './components/Carousel.js';
import FAQ from './components/FAQ.js';
import EventCarousel from './components/EventCarousel.js';
import VivelandForm from './components/VivelandForm.js';
import VideoGate from './components/VideoGate.js';
import VideoModal from './components/VideoModal.js';

/**
 * ========================================
 * ANIMATION HANDLER
 * ========================================
 */

class AnimationHandler {
  constructor() {
    this.init();
  }

  init() {
    this.setupIntersectionObserver();
    this.setupLazyLoading();
  }

  setupIntersectionObserver() {
    const options = {
      threshold: 0.1,
      rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.style.animationDelay = '0s';
          observer.unobserve(entry.target);
        }
      });
    }, options);

    document.querySelectorAll(
      '.expert-card, .benefit-card, .ticket-card, .bonus-card, .testimonial-card'
    ).forEach((el, index) => {
      el.style.animation = 'fadeInUp 0.6s ease forwards';
      el.style.opacity = '0';
      el.style.animationDelay = `${index * 0.1}s`;
      observer.observe(el);
    });
  }

  setupLazyLoading() {
    if ('IntersectionObserver' in window) {
      const imageObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const img = entry.target;
            if (img.dataset.src) {
              img.src = img.dataset.src;
            }
            img.classList.add('loaded');
            imageObserver.unobserve(img);
          }
        });
      });

      document.querySelectorAll('img[data-src]').forEach(img => {
        imageObserver.observe(img);
      });
    }
  }
}

/**
 * ========================================
 * SMOOTH SCROLL UTILITY
 * ========================================
 */

function setupSmoothScroll() {
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });
}

/**
 * ========================================
 * INITIALIZATION
 * ========================================
 */

document.addEventListener('DOMContentLoaded', () => {
  console.log('🚀 VIVELAND - Initializing Components');

  // Initialize Gallery
  const gallery = new Gallery('.gallery-item');
  console.log('✓ Gallery component initialized');

  // Initialize Testimonials Carousel
  const carousel = new Carousel({
    selector: '.testimonial-card',
    dotsSelector: '.slider-dots .dot',
    autoPlay: true,
    interval: 6000
  });
  console.log('✓ Carousel component initialized');

  // Initialize FAQ
  const faq = new FAQ('.faq-item');
  console.log('✓ FAQ component initialized');

  // Initialize Event Carousel (Galería)
  const eventCarousel = new EventCarousel({
    selector: '#eventCarousel',
    autoPlay: true,
    autoPlayDelay: 5000
  });
  console.log('✓ Event Carousel initialized');

  // Initialize Video Gate
  const videoGate = new VideoGate({
    watchThreshold: 90
  });
  console.log('✓ Video Gate initialized');

  // Initialize Video Modal (Fullscreen)
  const videoModal = new VideoModal();
  console.log('✓ Video Modal initialized');

  // Initialize VIVELAND Form
  const vivelandForm = new VivelandForm();
  console.log('✓ VIVELAND Form initialized');

  // Autoplay video when page loads
  const heroVideo = document.getElementById('heroVideo');
  if (heroVideo) {
    const playPromise = heroVideo.play();
    if (playPromise !== undefined) {
      playPromise.catch(error => {
        console.log('Autoplay prevented:', error);
      });
    }
  }
  
  // Close banner when user clicks on the overlay
  const heroBannerOverlay = document.getElementById('heroBannerOverlay');
  if (heroBannerOverlay) {
    heroBannerOverlay.addEventListener('click', (e) => {
      if (e.target === heroBannerOverlay) {
        heroBannerOverlay.classList.add('hidden');
      }
    });
  }
  
  console.log('✓ Hero Banner overlay initialized');

  // Close Quick Register Modal
  const closeQuickRegisterBtn = document.getElementById('closeQuickRegister');
  const quickRegisterModal = document.getElementById('quickRegisterModal');
  const quickRegisterOverlay = document.querySelector('.quick-register-overlay');
  const btnQuieroParticipar = document.getElementById('btnQuieroParticipar');

  if (closeQuickRegisterBtn && quickRegisterModal) {
    closeQuickRegisterBtn.addEventListener('click', (e) => {
      e.preventDefault();
      e.stopPropagation();
      quickRegisterModal.classList.remove('active');
      document.body.style.overflow = 'auto';
      console.log('🔒 Quick Register Modal closed');
    });
  }

  // Open Quick Register Modal
  if (btnQuieroParticipar && quickRegisterModal) {
    btnQuieroParticipar.addEventListener('click', () => {
      quickRegisterModal.classList.add('active');
      document.body.style.overflow = 'hidden';
      console.log('🎯 Quick Register Modal opened');
    });
  }

  // Close modal when clicking on overlay (pero NO en el contenido)
  if (quickRegisterOverlay && quickRegisterModal) {
    quickRegisterOverlay.addEventListener('click', (e) => {
      // Solo cerrar si se hace click directamente en el overlay, no en elementos dentro
      if (e.target === quickRegisterOverlay) {
        e.preventDefault();
        e.stopPropagation();
        quickRegisterModal.classList.remove('active');
        document.body.style.overflow = 'auto';
        console.log('🔒 Quick Register Modal closed via overlay');
      }
    });
  }

  // Close modal on ESC key
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && quickRegisterModal?.classList.contains('active')) {
      e.preventDefault();
      quickRegisterModal.classList.remove('active');
      document.body.style.overflow = 'auto';
      console.log('🔒 Quick Register Modal closed via ESC key');
    }
  });

  console.log('✓ Quick Register Modal close handlers initialized');

  // Initialize Animations
  const animations = new AnimationHandler();
  console.log('✓ Animation handlers initialized');

  // Setup Smooth Scroll
  setupSmoothScroll();
  console.log('✓ Smooth scroll initialized');

  // Make components globally accessible for debugging
  window.VIVELAND = {
    gallery,
    carousel,
    faq,
    eventCarousel,
    videoGate,
    vivelandForm,
    animations
  };

  console.log('✓ VIVELAND ready! Access components via window.VIVELAND');

  // Dispatch app ready event
  document.dispatchEvent(new CustomEvent('viveland:ready'));
});

/**
 * ========================================
 * EXPORT FOR EXTERNAL USE
 * ========================================
 */

export { Gallery, Carousel, FAQ, EventCarousel, VivelandForm, AnimationHandler };
