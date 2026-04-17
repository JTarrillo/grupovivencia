/**
 * Debug Script - Botón "Quiero Participar"
 * Diagnóstico para resolver problemas de apertura del modal
 */

console.log('🔍 === DEBUG QUIERO PARTICIPAR INICIADO ===');

// Esperar a que el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    console.log('✓ DOM Ready - Iniciando diagnóstico');
    
    // 1. Verificar que el botón existe
    const btnQuieroParticipar = document.getElementById('btnQuieroParticipar');
    console.log('📌 Búsqueda: #btnQuieroParticipar');
    console.log('   Resultado:', btnQuieroParticipar ? '✅ ENCONTRADO' : '❌ NO ENCONTRADO');
    
    if (btnQuieroParticipar) {
        console.log('   - Elemento:', btnQuieroParticipar);
        console.log('   - HTML:', btnQuieroParticipar.outerHTML);
        console.log('   - Visible:', btnQuieroParticipar.offsetHeight > 0 ? '✅ Sí' : '❌ No');
        console.log('   - Display:', window.getComputedStyle(btnQuieroParticipar).display);
        console.log('   - Pointer-events:', window.getComputedStyle(btnQuieroParticipar).pointerEvents);
    }
    
    // 2. Verificar que el modal existe
    const modal = document.getElementById('quickRegisterModal');
    console.log('\n📌 Búsqueda: #quickRegisterModal');
    console.log('   Resultado:', modal ? '✅ ENCONTRADO' : '❌ NO ENCONTRADO');
    
    if (modal) {
        console.log('   - Elemento:', modal);
        console.log('   - Tiene clase "active":', modal.classList.contains('active'));
    }
    
    // 3. Buscar QuickRegistration en window
    console.log('\n📌 Búsqueda: window.VIVELAND');
    if (window.VIVELAND) {
        console.log('   ✅ VIVELAND object encontrado');
        console.log('   - Propiedades:', Object.keys(window.VIVELAND));
    } else {
        console.log('   ❌ VIVELAND object NO encontrado');
    }
    
    // 4. Agregar listener de prueba directamente
    if (btnQuieroParticipar) {
        console.log('\n📌 Test: Agregando listener de prueba');
        
        btnQuieroParticipar.addEventListener('click', (e) => {
            console.log('🎯 CLICK DETECTADO en btnQuieroParticipar');
            console.log('   - Evento:', e);
            console.log('   - Target:', e.target);
            
            // Intentar abrir modal manualmente
            if (modal) {
                console.log('   📍 Abriendo modal manualmente...');
                modal.classList.add('active');
                console.log('   ✅ Clase "active" agregada al modal');
            } else {
                console.log('   ❌ Modal no encontrado para abrir');
            }
        });
        
        console.log('   ✅ Listener agregado - el botón responderá al click');
    }
    
    // 5. Simular un click después de 2 segundos para prueba
    setTimeout(() => {
        console.log('\n📌 Test: Simulando click en 5 segundos para prueba...');
        console.log('   (Abre la consola para ver resultados)');
        
        setTimeout(() => {
            if (btnQuieroParticipar) {
                console.log('🧪 Simulando click del usuario...');
                btnQuieroParticipar.click();
            }
        }, 5000);
    }, 2000);
    
    // 6. Monitorear errores
    console.log('\n📌 Monitoreo: Escuchando errores globales');
    window.addEventListener('error', (event) => {
        console.log('❌ ERROR GLOBAL DETECTADO:', event.message);
        console.log('   - Archivo:', event.filename);
        console.log('   - Línea:', event.lineno);
    });
    
    // 7. Información final
    console.log('\n📊 === RESUMEN DE DIAGNÓSTICO ===');
    console.log('✓ Si ves "CLICK DETECTADO" → el botón está funcionando');
    console.log('✓ Si el modal tiene clase "active" → debería estar visible');
    console.log('✓ Revisa la consola (F12) para ver estos mensajes en tiempo real');
    console.log('✓ Un click de prueba se simulará en 5 segundos');
});

// Escuchar cambios en el modal
const observer = new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
        if (mutation.attributeName === 'class') {
            const modal = document.getElementById('quickRegisterModal');
            console.log('👀 Modal clase cambió:', modal?.className);
        }
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('quickRegisterModal');
    if (modal) {
        observer.observe(modal, { attributes: true });
        console.log('👀 Observador de cambios en modal activado');
    }
});

console.log('🔍 === DEBUG SCRIPT CARGADO ===\n');
