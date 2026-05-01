/**
 * VivelandForm.js
 * Maneja el formulario de registro de VIVELAND
 */

class VivelandForm {
    constructor(options = {}) {
        // Manejar AMBOS formularios
        this.vivelandForm = document.querySelector('#vivelandForm');
        this.quickRegisterForm = document.querySelector('#quickRegisterForm');
        
        // Inicializar formulario principal
        if (this.vivelandForm) {
            this.form = this.vivelandForm;
            this.messageElement = document.getElementById('formMessage');
            this.submitBtn = this.form.querySelector('[type="submit"]');
            this.originalBtnText = this.submitBtn?.textContent;
            this.isSubmitting = false;
            this.formType = 'main';
            this.init();
        }
        
        // Inicializar formulario rápido con búsqueda dinámica
        if (this.quickRegisterForm) {
            console.log('✅ Formulario rápido encontrado, asignando listener...');
            this.quickRegisterForm.addEventListener('submit', (e) => this.handleQuickRegisterSubmit(e));
        } else {
            // Intentar encontrarlo cuando esté disponible
            setTimeout(() => {
                const qrForm = document.querySelector('#quickRegisterForm');
                if (qrForm) {
                    console.log('✅ Formulario rápido encontrado (defer), asignando listener...');
                    qrForm.addEventListener('submit', (e) => this.handleQuickRegisterSubmit(e));
                }
            }, 500);
        }
    }
    
    init() {
        if (!this.vivelandForm) return;
        
        this.vivelandForm.addEventListener('submit', (e) => this.handleSubmit(e));
        this.addValidationListeners();
        
        console.log('%c✅ VivelandForm INICIALIZADO', 'color: #28a745; font-weight: bold; font-size: 14px;');
        console.log('📋 Formulario Principal:', this.vivelandForm);
        console.log('📋 Formulario Rápido:', this.quickRegisterForm ? 'Encontrado' : 'Pendiente (aún no en DOM)');
    }
    
    addValidationListeners() {
        // Validar formulario principal
        if (this.vivelandForm) {
            const inputs = this.vivelandForm.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.addEventListener('blur', () => this.validateField(input));
                input.addEventListener('focus', () => this.clearFieldError(input));
            });
        }
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

    async showFancyAlert({
        title = 'Aviso',
        text = '',
        icon = 'info',
        confirmButtonText = 'Aceptar'
    } = {}) {
        if (window.Swal && typeof window.Swal.fire === 'function') {
            return window.Swal.fire({
                title,
                text,
                icon,
                confirmButtonText,
                confirmButtonColor: '#1f5e95',
                background: '#ffffff',
                customClass: {
                    popup: 'viveland-swal-popup',
                    title: 'viveland-swal-title',
                    confirmButton: 'viveland-swal-confirm'
                }
            });
        }

        alert(`${title}\n\n${text}`);
        return Promise.resolve();
    }
    
    async handleSubmit(e) {
        e.preventDefault();
        
        // Prevenir envío duplicado
        if (this.isSubmitting) {
            console.log('Envío ya en progreso, ignorar...');
            return;
        }
        
        // Validar todos los campos
        const inputs = this.vivelandForm.querySelectorAll('[required]');
        let isFormValid = true;
        
        inputs.forEach(input => {
            if (!this.validateField(input)) {
                isFormValid = false;
            }
        });
        
        // Validar checkbox de términos
        const terminos = this.vivelandForm.querySelector('#terminos');
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
            const formData = new FormData(this.vivelandForm);
            
            // Obtener sitio URL dinámicamente
            const baseUrl = window.location.origin;
            console.log('📝 Guardando registro en base de datos...');
            const response = await fetch(baseUrl + '/viveland/guardar_registro', {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            
            if (response.ok && data.success) {
                this.showMessage(data.message, 'success');
                this.vivelandForm.reset();
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
    
    // Nuevo método para el formulario rápido (modal)
    async handleQuickRegisterSubmit(e) {
        // DETENER PROPAGACIÓN Y PREVENIR COMPORTAMIENTO POR DEFECTO inmediatamente
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        
        console.log('🔴 FORMULARIO ENVIADO - preventDefault ejecutado');
        
        const submitBtn = e.target.querySelector('[type="submit"]');
        const originalText = submitBtn.textContent;
        
        try {
            // CAPTURAR VALORES INMEDIATAMENTE - ANTES de cualquier otra cosa
            console.log('📝 CAPTURANDO VALORES del formulario...');
            
            const inputNombre = document.getElementById('qr-nombre');
            const inputEmail = document.getElementById('qr-email');
            const inputTelefono = document.getElementById('qr-telefono');
            const inputZona = document.getElementById('qr-zona');
            const inputInteres = document.getElementById('qr-interes');
            
            console.log('📋 Inputs encontrados:', {
                nombre: !!inputNombre,
                email: !!inputEmail,
                telefono: !!inputTelefono,
                zona: !!inputZona,
                interes: !!inputInteres
            });
            
            const formData = {
                nombre: (inputNombre?.value || '').trim(),
                email: (inputEmail?.value || '').trim(),
                telefono: (inputTelefono?.value || '').trim(),
                zona: inputZona?.value || '',
                interes: inputInteres?.value || ''
            };
            
            console.log('📋 Form event target:', e.target.id);
            console.log('📋 Datos capturados:', formData);
            console.log('📋 Valores individuales:');
            console.log('   - nombre:', `"${formData.nombre}"`);
            console.log('   - email:', `"${formData.email}"`);
            console.log('   - telefono:', `"${formData.telefono}"`);
            console.log('   - zona:', `"${formData.zona}"`);
            console.log('   - interes:', `"${formData.interes}"`);
            
            // Validación de campos requeridos
            if (!formData.nombre) {
                await this.showFancyAlert({
                    title: 'Nombre requerido',
                    text: 'Por favor ingresa tu nombre completo.',
                    icon: 'warning'
                });
                console.error('⚠️  Campo nombre vacío');
                return;
            }
            if (!formData.email) {
                await this.showFancyAlert({
                    title: 'Email requerido',
                    text: 'Por favor ingresa tu correo electrónico.',
                    icon: 'warning'
                });
                console.error('⚠️  Campo email vacío');
                return;
            }
            if (!formData.telefono) {
                await this.showFancyAlert({
                    title: 'Teléfono requerido',
                    text: 'Por favor ingresa tu teléfono.',
                    icon: 'warning'
                });
                console.error('⚠️  Campo telefono vacío');
                return;
            }
            if (!formData.zona) {
                await this.showFancyAlert({
                    title: 'Zona requerida',
                    text: 'Selecciona una zona para continuar.',
                    icon: 'warning'
                });
                console.error('⚠️  Campo zona vacío');
                return;
            }
            if (!formData.interes) {
                await this.showFancyAlert({
                    title: 'Interés requerido',
                    text: 'Selecciona tu interés principal.',
                    icon: 'warning'
                });
                console.error('⚠️  Campo interes vacío');
                return;
            }
            
            // Validar formato de nombre
            if (formData.nombre.length < 3) {
                await this.showFancyAlert({
                    title: 'Nombre muy corto',
                    text: 'El nombre debe tener al menos 3 caracteres.',
                    icon: 'warning'
                });
                return;
            }
            
            // Validar email
            if (!this.isValidEmail(formData.email)) {
                await this.showFancyAlert({
                    title: 'Email inválido',
                    text: 'Por favor ingresa un correo válido.',
                    icon: 'warning'
                });
                return;
            }
            
            // Mostrar loading
            submitBtn.disabled = true;
            submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Procesando...`;
            
            // 1️⃣ GUARDAR EN BD
            const baseUrl = window.location.origin;
            console.log('📝 Guardando registro rápido en base de datos...', formData);
            const response = await fetch(baseUrl + '/viveland/guardar_registro', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            });
            
            const data = await response.json();
            
            if (response.ok && data.success) {
                console.log('✅ Registro guardado en BD:', data);
                
                // 2️⃣ CONSTRUIR MENSAJE Y ENVIAR A WHATSAPP
                const mensaje = `¡Hola! Me gustaría registrarme a VIVELAND.%0A%0A📋 *Datos del Registro:*%0A${formData.nombre}%0A📧 ${formData.email}%0A📱 ${formData.telefono}%0A🎟️ ${formData.zona}%0A⭐ Interés: ${formData.interes || 'No especificado'}`;
                
                // URL del grupo de WhatsApp
                const urlWhatsApp = `https://chat.whatsapp.com/Fog6lcdyRrc9XMLI8YbV0T?text=${mensaje}`;
                
                // Abrir WhatsApp
                window.open(urlWhatsApp, '_blank');
                
                // Cerrar modal y limpiar
                setTimeout(async () => {
                    // Resetear el formulario limpiando cada campo directamente
                    document.getElementById('qr-nombre').value = '';
                    document.getElementById('qr-email').value = '';
                    document.getElementById('qr-telefono').value = '';
                    document.getElementById('qr-zona').value = '';
                    document.getElementById('qr-interes').value = '';
                    
                    const modal = document.getElementById('quickRegisterModal');
                    if (modal) {
                        modal.classList.remove('active');
                    }
                    document.body.style.overflow = 'auto';
                    await this.showFancyAlert({
                        title: 'Registro guardado',
                        text: 'WhatsApp se abrió correctamente. Completa y envía tu mensaje.',
                        icon: 'success',
                        confirmButtonText: 'Entendido'
                    });
                    
                    // Restaurar botón
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }, 500);
            } else if (response.status === 422 && data.errors) {
                // Errores de validación
                let errorMsg = 'Errores de validación:\n\n';
                for (let field in data.errors) {
                    errorMsg += `• ${field}: ${data.errors[field]}\n`;
                }
                console.error('❌ Validación fallida:', data.errors);
                await this.showFancyAlert({
                    title: 'Revisa el formulario',
                    text: errorMsg,
                    icon: 'warning'
                });
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            } else {
                console.error('❌ Error del servidor:', data);
                await this.showFancyAlert({
                    title: 'No se pudo registrar',
                    text: data.error || 'No se pudo guardar el registro.',
                    icon: 'error'
                });
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        } catch (error) {
            console.error('Error:', error);
            await this.showFancyAlert({
                title: 'Error de conexión',
                text: 'Intenta de nuevo en unos segundos.',
                icon: 'error'
            });
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
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
