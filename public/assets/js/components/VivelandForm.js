/**
 * VivelandForm.js
 * Maneja el formulario de registro de VIVELAND
 */

class VivelandForm {
    constructor(options = {}) {
        this.formSelector = options.formSelector || '#vivelandForm';
        this.form = document.querySelector(this.formSelector);
        
        if (!this.form) {
            console.warn('VivelandForm: Formulario no encontrado');
            return;
        }
        
        this.messageElement = document.getElementById('formMessage');
        this.submitBtn = this.form.querySelector('[type="submit"]');
        this.originalBtnText = this.submitBtn?.textContent;
        this.isSubmitting = false; // Flag para prevenir envíos duplicados
        
        this.init();
    }
    
    init() {
        if (!this.form) return;
        
        this.form.addEventListener('submit', (e) => this.handleSubmit(e));
        this.addValidationListeners();
        
        console.log('%c✅ VivelandForm INICIALIZADO', 'color: #28a745; font-weight: bold; font-size: 14px;');
        console.log('Form:', this.form);
        console.log('Submit button:', this.submitBtn);
        console.log('Message element:', this.messageElement);
    }
    
    addValidationListeners() {
        const inputs = this.form.querySelectorAll('.form-control');
        inputs.forEach(input => {
            input.addEventListener('blur', () => this.validateField(input));
            input.addEventListener('focus', () => this.clearFieldError(input));
        });
    }
    
    validateField(field) {
        const value = field.value.trim();
        let isValid = true;
        let errorMessage = '';
        
        // Validación básica por tipo
        if (field.hasAttribute('required') && !value) {
            isValid = false;
            errorMessage = 'Este campo es requerido';
        } else if (field.type === 'email' && value) {
            if (!this.isValidEmail(value)) {
                isValid = false;
                errorMessage = 'Email inválido';
            }
        } else if (field.type === 'tel' && value) {
            if (!this.isValidPhone(value)) {
                isValid = false;
                errorMessage = 'Teléfono inválido';
            }
        }
        
        if (!isValid) {
            this.showFieldError(field, errorMessage);
        } else {
            this.clearFieldError(field);
        }
        
        return isValid;
    }
    
    showFieldError(field, message) {
        field.classList.add('is-invalid');
        field.style.borderColor = '#dc3545';
        
        const errorLabel = field.parentElement.querySelector('.form-text');
        if (errorLabel) {
            errorLabel.textContent = message;
            errorLabel.style.display = 'block';
        }
    }
    
    clearFieldError(field) {
        field.classList.remove('is-invalid');
        field.style.borderColor = '';
        
        const errorLabel = field.parentElement.querySelector('.form-text');
        if (errorLabel) {
            errorLabel.style.display = 'none';
        }
    }
    
    isValidEmail(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }
    
    isValidPhone(phone) {
        const regex = /^[0-9+\s\-()]{7,}$/;
        return regex.test(phone);
    }
    
    async handleSubmit(e) {
        e.preventDefault();
        
        // Prevenir envío duplicado
        if (this.isSubmitting) {
            console.log('Envío ya en progreso, ignorar...');
            return;
        }
        
        // Validar todos los campos
        const inputs = this.form.querySelectorAll('[required]');
        let isFormValid = true;
        
        inputs.forEach(input => {
            if (!this.validateField(input)) {
                isFormValid = false;
            }
        });
        
        // Validar checkbox de términos
        const terminos = this.form.querySelector('#terminos');
        if (!terminos.checked) {
            this.showMessage('Debes aceptar los términos y condiciones', 'error');
            return;
        }
        
        if (!isFormValid) {
            this.showMessage('Por favor completa todos los campos requeridos correctamente', 'error');
            return;
        }
        
        // Marcar como enviando
        this.isSubmitting = true;
        this.setLoading(true);
        
        try {
            const formData = new FormData(this.form);
            
            // Obtener sitio URL dinámicamente
            const baseUrl = window.location.origin;
            const response = await fetch(baseUrl + '/viveland/guardar_registro', {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            
            if (response.ok && data.success) {
                this.showMessage(data.message, 'success');
                this.form.reset();
                this.scrollToMessage();
                
                // Dispatchear evento personalizado
                this.dispatchEvent({
                    type: 'registroExitoso',
                    detail: data
                });
                
                // Opcional: Redirigir después de 3 segundos
                setTimeout(() => {
                    // window.location.href = '/gracias';
                }, 3000);
            } else {
                this.showMessage(
                    data.error || 'Error al procesar el registro. Intenta de nuevo.',
                    'error'
                );
            }
        } catch (error) {
            console.error('Error:', error);
            this.showMessage('Error de conexión. Intenta de nuevo.', 'error');
        } finally {
            this.isSubmitting = false; // Resetear flag
            this.setLoading(false);
        }
    }
    
    setLoading(loading) {
        if (!this.submitBtn) return;
        
        if (loading) {
            this.submitBtn.disabled = true;
            this.submitBtn.innerHTML = `
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                <span style="margin-left: 0.5rem;">Procesando...</span>
            `;
        } else {
            this.submitBtn.disabled = false;
            this.submitBtn.innerHTML = this.originalBtnText;
        }
    }
    
    showMessage(message, type = 'success') {
        if (!this.messageElement) return;
        
        this.messageElement.className = `form-message ${type}`;
        this.messageElement.textContent = message;
        this.messageElement.style.display = 'block';
    }
    
    scrollToMessage() {
        if (this.messageElement) {
            this.messageElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }
    
    dispatchEvent(data) {
        const event = new CustomEvent('viveland:' + data.type, { detail: data.detail });
        document.dispatchEvent(event);
    }
}

export default VivelandForm;
