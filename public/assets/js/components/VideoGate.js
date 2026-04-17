/**
 * VideoGate.js
 * Controla reproducción de video y desbloquea el registro
 */

class VideoGate {
    constructor(options = {}) {
        this.videoSelector = options.videoSelector || '#heroVideo';
        this.playBtnSelector = options.playBtnSelector || '#playBtn';
        this.fullscreenBtnSelector = options.fullscreenBtnSelector || '#fullscreenBtn';
        this.registerBtnSelector = options.registerBtnSelector || '#btnRegistro';
        this.progressBarSelector = options.progressBarSelector || '#progressBar';
        this.progressTextSelector = options.progressTextSelector || '#progressText';
        this.progressPercentSelector = options.progressPercentSelector || '#progressPercent';
        this.overlaySelector = options.overlaySelector || '#videoOverlay';
        this.messageAlertSelector = options.messageAlertSelector || '#videoMessageAlert';
        
        this.video = document.querySelector(this.videoSelector);
        this.playBtn = document.querySelector(this.playBtnSelector);
        this.fullscreenBtn = document.querySelector(this.fullscreenBtnSelector);
        this.registerBtn = document.querySelector(this.registerBtnSelector);
        this.progressBar = document.querySelector(this.progressBarSelector);
        this.progressText = document.querySelector(this.progressTextSelector);
        this.progressPercent = document.querySelector(this.progressPercentSelector);
        this.overlay = document.querySelector(this.overlaySelector);
        this.messageAlert = document.querySelector(this.messageAlertSelector);
        
        this.videoWatched = false;
        this.watchThreshold = options.watchThreshold || 100; // Requiere ver 100%
        
        if (!this.video) {
            console.warn('VideoGate: Video no encontrado');
            return;
        }
        
        this.init();
    }
    
    init() {
        this.setupEventListeners();
        console.log('VideoGate initialized');
    }
    
    setupEventListeners() {
        // Play button
        if (this.playBtn) {
            this.playBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.togglePlay();
            });
        }
        
        // Fullscreen button
        if (this.fullscreenBtn) {
            this.fullscreenBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.toggleFullscreen();
            });
        }
        
        // Video events
        this.video.addEventListener('play', () => this.onVideoPlay());
        this.video.addEventListener('pause', () => this.onVideoPause());
        this.video.addEventListener('timeupdate', () => this.onVideoTimeUpdate());
        this.video.addEventListener('ended', () => this.onVideoEnded());
        
        // Prevenir seek en el video (no permitir que el usuario avance/retroceda)
        this.video.addEventListener('seeking', (e) => {
            this.video.currentTime = this.lastValidTime || 0;
            e.preventDefault();
        });
        
        this.video.addEventListener('timeupdate', () => {
            this.lastValidTime = this.video.currentTime;
        });
        
        // Deshabilitar click derecho en el progreso
        if (this.progressBar) {
            this.progressBar.parentElement.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
            });
        }
        
        // Click en overlay para play
        if (this.overlay) {
            this.overlay.addEventListener('click', () => this.togglePlay());
        }
    }
    
    togglePlay() {
        if (this.video.paused) {
            this.video.play();
        } else {
            this.video.pause();
        }
    }
    
    onVideoPlay() {
        if (this.playBtn) {
            this.playBtn.innerHTML = '<i class="fas fa-pause"></i>';
        }
    }
    
    onVideoPause() {
        if (this.playBtn) {
            this.playBtn.innerHTML = '<i class="fas fa-play"></i>';
        }
    }
    
    onVideoTimeUpdate() {
        // Actualizar barra de progreso
        const percent = (this.video.currentTime / this.video.duration) * 100;
        
        if (this.progressBar) {
            this.progressBar.style.width = percent + '%';
        }
        
        if (this.progressPercent) {
            this.progressPercent.textContent = Math.floor(percent) + '%';
        }
        
        // Ocultar overlay cuando comience a reproducir
        if (percent > 5 && this.overlay && !this.overlay.classList.contains('hidden')) {
            this.overlay.classList.add('hidden');
        }
        
        // Verificar si se vio suficiente
        if (percent >= this.watchThreshold && !this.videoWatched) {
            this.unlockRegister();
        }
    }
    
    onVideoEnded() {
        this.unlockRegister();
        // Reiniciar video automáticamente SOLO si no ha sido visto aún
        if (!this.videoWatched) {
            this.video.currentTime = 0;
            this.video.play();
        }
    }
    
    unlockRegister() {
        if (this.videoWatched) return; // Ya desbloqueado
        
        this.videoWatched = true;
        
        // Desbloquear botón
        if (this.registerBtn) {
            this.registerBtn.disabled = false;
            this.registerBtn.classList.add('unlocked');
            this.registerBtn.innerHTML = '<i class="fas fa-check-circle"></i> Elige Tu Entrada Ahora';
        }
        
        // Actualizar mensaje
        if (this.progressText) {
            this.progressText.innerHTML = '<i class="fas fa-check-circle" style="color: #25D366; margin-right: 0.5rem;"></i>¡Video completado! Ahora elige tu entrada a VIVELAND 2026';
        }
        
        // Ocultar alerta
        if (this.messageAlert) {
            this.messageAlert.style.display = 'none';
        }
        
        // Mostrar alerta de éxito
        this.showSuccessMessage();
        
        // Abrir modal del formulario rápido
        setTimeout(() => {
            const modal = document.getElementById('quickRegisterModal');
            if (modal) {
                modal.classList.add('active');
            }
        }, 500);
    }
    
    toggleFullscreen() {
        if (this.video.requestFullscreen) {
            this.video.requestFullscreen();
        } else if (this.video.webkitRequestFullscreen) {
            this.video.webkitRequestFullscreen();
        }
    }
    
    showSuccessMessage() {
        // Crear mensaje temporal
        const successMsg = document.createElement('div');
        successMsg.className = 'video-success-message';
        successMsg.innerHTML = '<i class="fas fa-star"></i> ¡Excelente! Ya puedes completar tu registro y seleccionar tu entrada a VIVELAND 2026';
        
        document.body.appendChild(successMsg);
        
        setTimeout(() => {
            successMsg.classList.add('show');
        }, 100);
        
        setTimeout(() => {
            successMsg.classList.remove('show');
            setTimeout(() => successMsg.remove(), 300);
        }, 3000);
    }
    
    setWatchThreshold(percent) {
        this.watchThreshold = percent;
    }
}

export default VideoGate;
