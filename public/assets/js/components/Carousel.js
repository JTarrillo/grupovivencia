/**
 * ========================================
 * VIVELAND - Carousel Component
 * Auto-rotating testimonials slider
 * ========================================
 */

export class Carousel {
  constructor(options = {}) {
    this.options = {
      selector: '.testimonial-card',
      dotsSelector: '.slider-dots .dot',
      autoPlay: true,
      interval: 6000,
      ...options
    };

    this.items = document.querySelectorAll(this.options.selector);
    this.dots = document.querySelectorAll(this.options.dotsSelector);
    this.currentIndex = 0;
    this.autoPlayInterval = null;

    this.init();
  }

  /**
   * Initialize carousel
   */
  init() {
    this.setupDots();
    if (this.options.autoPlay) {
      this.startAutoPlay();
    }
    this.dispatchEvent('initialized');
  }

  /**
   * Setup dot navigation
   */
  setupDots() {
    this.dots.forEach((dot, index) => {
      dot.addEventListener('click', () => this.goToSlide(index));
    });
  }

  /**
   * Go to specific slide
   */
  goToSlide(index) {
    if (index >= this.items.length || index < 0) return;

    this.items.forEach(item => item.classList.remove('active'));
    this.dots.forEach(dot => dot.classList.remove('active'));

    if (this.items[index]) this.items[index].classList.add('active');
    if (this.dots[index]) this.dots[index].classList.add('active');

    this.currentIndex = index;
    this.dispatchEvent('sliderChange', { index, item: this.items[index] });

    // Reset auto-play timer when manually selected
    if (this.options.autoPlay) {
      this.resetAutoPlay();
    }
  }

  /**
   * Go to next slide
   */
  nextSlide() {
    const next = (this.currentIndex + 1) % this.items.length;
    this.goToSlide(next);
  }

  /**
   * Go to previous slide
   */
  prevSlide() {
    const prev = (this.currentIndex - 1 + this.items.length) % this.items.length;
    this.goToSlide(prev);
  }

  /**
   * Start auto-play
   */
  startAutoPlay() {
    this.autoPlayInterval = setInterval(() => {
      this.nextSlide();
    }, this.options.interval);
    this.dispatchEvent('autoPlayStarted');
  }

  /**
   * Stop auto-play
   */
  stopAutoPlay() {
    if (this.autoPlayInterval) {
      clearInterval(this.autoPlayInterval);
      this.autoPlayInterval = null;
      this.dispatchEvent('autoPlayStopped');
    }
  }

  /**
   * Reset auto-play timer
   */
  resetAutoPlay() {
    this.stopAutoPlay();
    if (this.options.autoPlay) {
      this.startAutoPlay();
    }
  }

  /**
   * Dispatch custom event
   */
  dispatchEvent(eventName, detail = {}) {
    const event = new CustomEvent(`carousel:${eventName}`, { detail });
    document.dispatchEvent(event);
  }

  /**
   * Destroy carousel (cleanup)
   */
  destroy() {
    this.stopAutoPlay();
    this.dots.forEach(dot => dot.replaceWith(dot.cloneNode(true)));
    this.dispatchEvent('destroyed');
  }
}

export default Carousel;
