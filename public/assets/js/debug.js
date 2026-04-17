// ========================================
// VIVELAND DEBUG LOGGER
// Log para diagnóstico de errores en producción
// ========================================

const VivelandDebug = {
  logs: [],
  
  init() {
    console.log('%c🔍 VIVELAND DEBUG INICIADO', 'color: #4A90E2; font-weight: bold; font-size: 14px;');
    
    // Log de información base
    this.logBaseInfo();
    
    // Verificar recursos
    this.checkResources();
    
    // Escuchar errores de red
    this.listenNetworkErrors();
    
    // Log final
    this.displaySummary();
  },

  logBaseInfo() {
    const baseInfo = {
      'URL Actual': window.location.href,
      'Hostname': window.location.hostname,
      'Pathname': window.location.pathname,
      'Protocol': window.location.protocol,
      'User Agent': navigator.userAgent.substring(0, 50) + '...',
      'Timestamp': new Date().toISOString()
    };
    
    console.group('%c📋 Información Base', 'color: #4A90E2; font-weight: bold;');
    Object.entries(baseInfo).forEach(([key, value]) => {
      console.log(`%c${key}:`, 'color: #666; font-weight: bold;', value);
      this.logs.push(`${key}: ${value}`);
    });
    console.groupEnd();
  },

  checkResources() {
    console.group('%c📦 Verificando Recursos', 'color: #25D366; font-weight: bold;');
    
    // Verificar CSS
    this.checkCSS();
    
    // Verificar JS
    this.checkJS();
    
    // Verificar Imágenes
    this.checkImages();
    
    console.groupEnd();
  },

  checkCSS() {
    console.group('%c🎨 Hojas de Estilo (CSS)', 'color: #FF9800;');
    const stylesheets = document.styleSheets;
    
    if (stylesheets.length === 0) {
      console.warn('❌ No se encontraron hojas de estilo');
      this.logs.push('ERROR: No CSS files found');
    } else {
      for (let sheet of stylesheets) {
        try {
          const href = sheet.href || 'inline style';
          console.log(`✅ ${href}`);
          this.logs.push(`CSS: ${href}`);
        } catch (e) {
          console.warn('⚠️ No se puede acceder a:', sheet);
          this.logs.push(`CSS Error: ${e.message}`);
        }
      }
    }
    console.groupEnd();
  },

  checkJS() {
    console.group('%c⚙️ Scripts (JS)', 'color: #FF9800;');
    const scripts = document.querySelectorAll('script[src]');
    
    if (scripts.length === 0) {
      console.warn('❌ No se encontraron scripts externos');
    } else {
      scripts.forEach(script => {
        console.log(`✅ ${script.src}`);
        this.logs.push(`JS: ${script.src}`);
      });
    }
    console.groupEnd();
  },

  checkImages() {
    console.group('%c🖼️ Imágenes', 'color: #FF9800;');
    const images = document.querySelectorAll('img[src]');
    
    console.log(`Total de imágenes encontradas: ${images.length}`);
    
    // Solo mostrar las primeras 5 para no saturar
    Array.from(images).slice(0, 5).forEach((img, index) => {
      const status = img.complete && img.naturalHeight > 0 ? '✅' : '⚠️';
      console.log(`${status} ${index + 1}. ${img.src}`);
      this.logs.push(`IMG: ${img.src} (${img.complete ? 'loaded' : 'loading'})`);
    });
    
    if (images.length > 5) {
      console.log(`... y ${images.length - 5} imágenes más`);
    }
    console.groupEnd();
  },

  listenNetworkErrors() {
    console.group('%c🔴 Escuchando Errores de Red', 'color: #E74C3C;');
    
    // Escuchar errores de recursos
    window.addEventListener('error', (event) => {
      if (event.target !== window) {
        const errorMsg = `Error cargando: ${event.target.src || event.target.href}`;
        console.error(`❌ ${errorMsg}`);
        this.logs.push(`ERROR: ${errorMsg}`);
      }
    }, true);
    
    // Escuchar errores de red (fetch)
    window.addEventListener('unhandledrejection', (event) => {
      console.error('❌ Promise Rejection:', event.reason);
      this.logs.push(`Promise Error: ${event.reason}`);
    });
    
    console.log('✅ Listeners de error activados');
    console.groupEnd();
  },

  displaySummary() {
    console.group('%c📊 Resumen General', 'color: #4A90E2; font-weight: bold;');
    console.log('%c✅ VIVELAND está listo para diagnóstico', 'color: #25D366; font-weight: bold; font-size: 12px;');
    console.log('%cPara ver el log completo, ejecuta: console.log(VivelandDebug.logs)', 'color: #666; font-style: italic;');
    console.groupEnd();
    
    // También guardar en window para acceso fácil
    window.VivelandDebug = this;
  },

  // Función para exportar logs
  exportLogs() {
    const logText = this.logs.join('\n');
    console.log('%cLogs Exportados:', 'font-weight: bold;');
    console.log(logText);
    return logText;
  },

  // Función para verificar ruta de un recurso específico
  checkResource(url) {
    fetch(url, { method: 'HEAD' })
      .then(response => {
        if (response.ok) {
          console.log(`✅ Recurso disponible: ${url}`);
        } else {
          console.error(`⚠️ Recurso retorna ${response.status}: ${url}`);
        }
      })
      .catch(err => {
        console.error(`❌ Error accediendo: ${url} - ${err.message}`);
      });
  }
};

// Iniciar cuando el DOM esté listo
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', () => VivelandDebug.init());
} else {
  VivelandDebug.init();
}
