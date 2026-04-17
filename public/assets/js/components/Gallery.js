/**
 * ========================================
 * VIVELAND - Gallery Component
 * Professional Gallery with Lightbox
 * ========================================
 */

export class Gallery {
  constructor(selector = '.gallery-item') {
    this.galleryItems = document.querySelectorAll(selector);
    this.currentIndex = 0;
    this.images = [];
    this.lightbox = document.querySelector('.lightbox');
    this.lightboxImage = document.querySelector('.lightbox-image');

    this.init();
  }

  /**
   * Initialize gallery and lightbox
   */
  init() {
    this.collectImages();
    this.setupGalleryItems();
    this.setupLightbox();
    this.setupKeyboardNavigation();
  }

  /**
   * Collect all gallery images
   */
  collectImages() {
    this.images = Array.from(this.galleryItems).map(item => {
      const img = item.querySelector('img');
      return img ? img.src : null;
    }).filter(src => src !== null);
  }

  /**
   * Setup gallery item click events
   */
  setupGalleryItems() {
    this.galleryItems.forEach((item, index) => {
      item.addEventListener('click', () => this.openLightbox(index));
      item.style.cursor = 'pointer';
    });
  }

  /**
   * Setup lightbox controls
   */
  setupLightbox() {
    const closeBtn = document.querySelector('.lightbox-close');
    const prevBtn = document.querySelector('.lightbox-prev');
    const nextBtn = document.querySelector('.lightbox-next');

    if (closeBtn) closeBtn.addEventListener('click', () => this.closeLightbox());
    if (prevBtn) prevBtn.addEventListener('click', () => this.previousImage());
    if (nextBtn) nextBtn.addEventListener('click', () => this.nextImage());

    // Close on backdrop click
    if (this.lightbox) {
      this.lightbox.addEventListener('click', (e) => {
        if (e.target === this.lightbox) this.closeLightbox();
      });
    }
  }

  /**
   * Setup keyboard navigation (Arrow keys, Escape)
   */
  setupKeyboardNavigation() {
    document.addEventListener('keydown', (e) => {
      if (!this.lightbox?.classList.contains('active')) return;

      switch (e.key) {
        case 'Escape':
          this.closeLightbox();
          break;
        case 'ArrowLeft':
          this.previousImage();
          break;
        case 'ArrowRight':
          this.nextImage();
          break;
      }
    });
  }

  /**
   * Open lightbox with image at index
   */
  openLightbox(index) {
    this.currentIndex = index;
    if (this.lightboxImage && this.images[index]) {
      this.lightboxImage.src = this.images[index];
      this.lightbox?.classList.add('active');
      document.body.style.overflow = 'hidden';
      this.dispatchEvent('galleryOpen', { index, src: this.images[index] });
    }
  }

  /**
   * Close lightbox
   */
  closeLightbox() {
    this.lightbox?.classList.remove('active');
    document.body.style.overflow = 'auto';
    this.dispatchEvent('galleryClosed');
  }

  /**
   * Show next image
   */
  nextImage() {
    this.currentIndex = (this.currentIndex + 1) % this.images.length;
    this.updateLightboxImage();
  }

  /**
   * Show previous image
   */
  previousImage() {
    this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
    this.updateLightboxImage();
  }

  /**
   * Update lightbox image display
   */
  updateLightboxImage() {
    if (this.lightboxImage && this.images[this.currentIndex]) {
      this.lightboxImage.src = this.images[this.currentIndex];
      this.dispatchEvent('imageChanged', { index: this.currentIndex });
    }
  }

  /**
   * Dispatch custom event
   */
  dispatchEvent(eventName, detail = {}) {
    const event = new CustomEvent(eventName, { detail });
    document.dispatchEvent(event);
  }
}

export default Gallery;
