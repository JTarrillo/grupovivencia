/**
 * ========================================
 * VIVELAND - FAQ Component
 * Accordion-style FAQ handler
 * ========================================
 */

export class FAQ {
  constructor(selector = '.faq-item') {
    this.items = document.querySelectorAll(selector);
    this.allowMultiple = false; // Only one open at a time
    this.init();
  }

  /**
   * Initialize FAQ
   */
  init() {
    this.items.forEach(item => {
      const question = item.querySelector('.faq-question');
      if (question) {
        question.addEventListener('click', () => this.toggleItem(item));
      }
    });
    this.dispatchEvent('initialized');
  }

  /**
   * Toggle FAQ item open/close
   */
  toggleItem(item) {
    const isOpen = item.classList.contains('active');

    if (!this.allowMultiple && isOpen === false) {
      // Close all other items if only one should be open
      this.items.forEach(faqItem => {
        if (faqItem !== item) {
          faqItem.classList.remove('active');
          this.dispatchEvent('itemClosed', { item: faqItem });
        }
      });
    }

    item.classList.toggle('active');
    const newState = item.classList.contains('active');

    this.dispatchEvent(newState ? 'itemOpened' : 'itemClosed', {
      item,
      question: item.querySelector('.faq-question')?.textContent
    });
  }

  /**
   * Open specific FAQ item
   */
  openItem(index) {
    if (this.items[index]) {
      if (!this.allowMultiple) {
        this.items.forEach((item, i) => {
          if (i !== index) item.classList.remove('active');
        });
      }
      this.items[index].classList.add('active');
      this.dispatchEvent('itemOpened', { index, item: this.items[index] });
    }
  }

  /**
   * Close specific FAQ item
   */
  closeItem(index) {
    if (this.items[index]) {
      this.items[index].classList.remove('active');
      this.dispatchEvent('itemClosed', { index, item: this.items[index] });
    }
  }

  /**
   * Close all items
   */
  closeAll() {
    this.items.forEach(item => item.classList.remove('active'));
    this.dispatchEvent('allClosed');
  }

  /**
   * Open all items
   */
  openAll() {
    this.items.forEach(item => item.classList.add('active'));
    this.dispatchEvent('allOpened');
  }

  /**
   * Set whether multiple items can be open
   */
  setAllowMultiple(allow = true) {
    this.allowMultiple = allow;
    if (!allow) {
      this.closeAll();
    }
  }

  /**
   * Dispatch custom event
   */
  dispatchEvent(eventName, detail = {}) {
    const event = new CustomEvent(`faq:${eventName}`, { detail });
    document.dispatchEvent(event);
  }

  /**
   * Destroy FAQ (cleanup)
   */
  destroy() {
    this.items.forEach(item => {
      const question = item.querySelector('.faq-question');
      if (question) {
        question.replaceWith(question.cloneNode(true));
      }
    });
    this.dispatchEvent('destroyed');
  }
}

export default FAQ;
