/**
 * QuickRegistration.js
 * Modal de registro rápido que envía datos a WhatsApp
 */

class QuickRegistration {
    constructor(options = {}) {
        this.modalSelector = options.modalSelector || '#quickRegisterModal';
        this.formSelector = options.formSelector || '#quickRegisterForm';
        this.openBtnSelector = options.openBtnSelector || '#btnQuieroParticipar';
        this.closeBtnSelector = options.closeBtnSelector || '#closeQuickRegister';
        this.whatsappNumber = options.whatsappNumber || '51999999999'; // Número de WhatsApp
        this.groupLink = options.groupLink || 'https://chat.whatsapp.com/Fog6lcdyRrc9XMLI8YbV0T';
        
        this.modal = document.querySelector(this.modalSelector);
        this.form = document.querySelector(this.formSelector);
        this.openBtn = document.querySelector(this.openBtnSelector);
        this.closeBtn = document.querySelector(this.closeBtnSelector);
        
        if (!this.form || !this.modal) {
            console.warn('QuickRegistration: Modal o formulario no encontrado');
            return;
        }
        
        this.init();
    }
    
    init() {
        this.setupEventListeners();
        console.log('QuickRegistration initialized');
    }
    
    setupEventListeners() {
        // Abrir modal
        if (this.openBtn) {
            this.openBtn.addEventListener('click', () => this.open());
        }
        
        // Cerrar modal con el botón X
        if (this.closeBtn) {
            this.closeBtn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                this.close();
            });
        } else {
            console.warn('QuickRegistration: closeBtn no encontrado');
        }
        
        // Cerrar al hacer click en la overlay (fondo oscuro)
        const overlay = this.modal?.querySelector('.quick-register-overlay');
        if (overlay) {
            overlay.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                this.close();
            });
        }
        
        // Cerrar con Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.modal?.classList.contains('active')) {
                this.close();
            }
        });
        
        // Enviar formulario
        this.form.addEventListener('submit', (e) => this.handleSubmit(e));
    }
    
    open() {
        if (!this.modal) return;
        
        this.modal.classList.add('active');
        document.body.style.overflow = 'hidden';
        
        console.log('QuickRegistration modal opened');
    }
    
    close() {
        if (!this.modal) return;
        
        this.modal.classList.remove('active');
        document.body.style.overflow = 'auto';
        this.form.reset();
        
        console.log('QuickRegistration modal closed');
    }
    
    handleSubmit(e) {
        e.preventDefault();
        
        // Obtener elemento del formulario directamente
        const nombreInput = document.getElementById('qr-nombre');
        const emailInput = document.getElementById('qr-email');
        
        // Obtener valores directamente
        const nombre = nombreInput?.value.trim() || '';
        const email = emailInput?.value.trim() || '';
        
        // Obtener del FormData el resto
        const formData = new FormData(this.form);
        const telefono = (formData.get('telefono') || '').trim();
        const zona = (formData.get('zona') || '').trim() || 'No especificada';
        const interes = (formData.get('interes') || '').trim() || 'General';
        
        // Validación SIMPLE - Todos opcionales pero si se completan deben tener formato correcto
        // Nombre: opcional, pero si se pone debe tener al menos 3 caracteres
        if (nombre.length > 0 && nombre.length < 3) {
            alert('Por favor ingresa Nombre y Apellido completo');
            return;
        }
        
        // Email: opcional, pero si se pone debe ser válido
        if (email.length > 0) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert('Por favor ingresa un email válido');
                return;
            }
        }
        
        // Construir mensaje para WhatsApp
        const mensaje = this.construirMensajeWhatsApp(nombre, email, telefono, zona, interes);
        
        // Crear URL de WhatsApp
        const urlWhatsApp = this.generarURLWhatsApp(mensaje);
        
        // Cerrar modal
        this.close();
        
        // Redirigir a WhatsApp
        setTimeout(() => {
            window.open(urlWhatsApp, '_blank');
        }, 300);
    }
    
    construirMensajeWhatsApp(nombre, email, telefono, zona, interes) {
        return `¡Hola! Me gustaría participar en VIVELAND 2026 🏆

👤 *Nombre:* ${nombre}
📧 *Email:* ${email}
📱 *Teléfono:* ${telefono}
🎫 *Entrada Seleccionada:* ${zona}
⭐ *Interés:* ${interes}

¡Estoy listo para participar en este increíble evento!`;
    }
    
    generarURLWhatsApp(mensaje) {
        // Usar el grupo de WhatsApp directamente
        const mensajeCodificado = encodeURIComponent(mensaje);
        return `${this.groupLink}?text=${mensajeCodificado}`;
    }
}

export default QuickRegistration;
