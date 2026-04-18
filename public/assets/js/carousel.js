// Carrusel de Expertos - Control Manual con DEBUG
console.log('🎬 === CAROUSEL.JS INICIANDO ===');

document.addEventListener('DOMContentLoaded', function() {
  console.log('📍 DOMContentLoaded disparado');
  
  const carousel = document.querySelector('.experts-carousel');
  const carouselCards = document.querySelectorAll('.expert-card-carousel');
  const indicators = document.querySelectorAll('.carousel-indicators .indicator');
  
  console.log('✓ Carousel encontrado:', !!carousel);
  console.log('✓ Cantidad de tarjetas:', carouselCards.length);
  console.log('✓ Indicadores encontrados:', indicators.length);
  
  // DEBUG: Mostrar info de cada tarjeta
  carouselCards.forEach((card, index) => {
    const name = card.querySelector('.expert-name')?.textContent || 'Sin nombre';
    const styles = window.getComputedStyle(card);
    console.log(`\n📋 Tarjeta ${index + 1} - ${name}`);
    console.log(`   - Animation: ${styles.animation || styles.animationName || 'NINGUNA'}`);
    console.log(`   - Animation Delay: ${styles.animationDelay}`);
    console.log(`   - Z-Index: ${styles.zIndex}`);
    console.log(`   - Opacity: ${styles.opacity}`);
  });
  
  if (!carousel || carouselCards.length === 0 || indicators.length === 0) {
    console.error('❌ Carousel elementos no encontrados en el DOM');
    return;
  }
  
  // Monitor de animación en tiempo real
  let animationFrame;
  const monitorAnimation = () => {
    carouselCards.forEach((card, index) => {
      const styles = window.getComputedStyle(card);
      const animState = styles.animationPlayState;
      
      // Log cada 3 segundos
      if (!window.lastAnimationLog || Date.now() - window.lastAnimationLog > 3000) {
        console.log(`\n⏱️  Estado en tiempo real (${new Date().toLocaleTimeString()})`);
        carouselCards.forEach((c, i) => {
          const name = c.querySelector('.expert-name')?.textContent || 'Sin nombre';
          const s = window.getComputedStyle(c);
          console.log(`   Tarjeta ${i + 1} (${name}): AnimState=${s.animationPlayState}, zIndex=${s.zIndex}, opacity=${s.opacity}`);
        });
        window.lastAnimationLog = Date.now();
      }
    });
    animationFrame = requestAnimationFrame(monitorAnimation);
  };
  monitorAnimation();
  
  // Permitir click en el indicador para pausar/reanudar la animación
  indicators.forEach((indicator, index) => {
    indicator.addEventListener('click', function(e) {
      e.preventDefault();
      
      const isActive = indicator.classList.contains('active');
      
      if (isActive) {
        // Si está activo, deseleccionar y reanudar
        indicator.classList.remove('active');
        carouselCards.forEach(card => {
          card.style.animationPlayState = 'running';
        });
        console.log('✅ Carrusel REANUDADO');
      } else {
        // Si está inactivo, seleccionar y pausar
        indicator.classList.add('active');
        carouselCards.forEach(card => {
          card.style.animationPlayState = 'paused';
        });
        console.log('⏸️  Carrusel PAUSADO');
      }
      
      // Log detallado del estado después del click
      setTimeout(() => {
        console.log('\n📊 Estado después de la acción:');
        carouselCards.forEach((card, i) => {
          const name = card.querySelector('.expert-name')?.textContent || 'Sin nombre';
          const styles = window.getComputedStyle(card);
          console.log(`   ${name}: zIndex=${styles.zIndex}, transform=${styles.transform}, opacity=${styles.opacity}`);
        });
      }, 100);
    });
  });
  
  console.log('🎬 === CAROUSEL.JS LISTO ===\n');
});

