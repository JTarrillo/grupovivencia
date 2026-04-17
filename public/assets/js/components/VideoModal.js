/**
 * VideoModal.js
 * Gestiona la reproducción de video en modal fullscreen
 */

class VideoModal {
  constructor() {
    this.modal = document.getElementById('videoModal');
    this.overlay = document.querySelector('.video-modal-overlay');
    this.closeBtn = document.getElementById('videoModalClose');
    this.player = document.getElementById('videoModalPlayer');
    this.triggerElement = document.querySelector('.video-wrapper');
    this.videoElement = document.getElementById('vivelandVideo');

    this.init();
  }

  init() {
    // Event listeners
    this.triggerElement?.addEventListener('click', () => this.open());
    this.closeBtn?.addEventListener('click', () => this.close());
    this.overlay?.addEventListener('click', () => this.close());
    
    // Close modal with Escape key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && this.modal?.classList.contains('active')) {
        this.close();
      }
    });

    console.log('VideoModal initialized');
  }

  open() {
    if (!this.modal) return;

    // Get current video time and source
    const currentTime = this.videoElement?.currentTime || 0;
    const videoSource = this.videoElement?.querySelector('source')?.src;

    // Set modal video source
    if (videoSource) {
      this.player.src = videoSource;
    }

    // Set current time if video was already playing
    this.player.currentTime = currentTime;

    // Show modal
    this.modal.classList.add('active');
    document.body.style.overflow = 'hidden'; // Prevent scroll

    // Auto play
    this.player?.play();

    console.log('VideoModal opened');
  }

  close() {
    if (!this.modal) return;

    // Pause modal video
    this.player?.pause();
    this.player.currentTime = 0;

    // Hide modal
    this.modal.classList.remove('active');
    document.body.style.overflow = 'auto'; // Restore scroll

    console.log('VideoModal closed');
  }

  // Public method to get modal reference
  getPlayer() {
    return this.player;
  }
}

export default VideoModal;
