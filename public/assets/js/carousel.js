// Carrusel de Expertos - Control Manual
document.addEventListener('DOMContentLoaded', function() {
  const carousel = document.querySelector('.experts-carousel');
  const indicators = document.querySelectorAll('.carousel-indicators .indicator');
  let currentRotation = 0;
  let currentSlide = 0;
  
  console.log('Carousel:', carousel);
  console.log('Indicators:', indicators);
  
  if (!carousel || indicators.length === 0) {
    console.error('Carousel o indicadores no encontrados en el DOM');
    return;
  }
  
  function rotateCarousel() {
    currentRotation += 120;
    carousel.style.transition = 'transform 0.6s ease';
    carousel.style.transform = `rotateY(${currentRotation}deg)`;
    
    currentSlide = (currentSlide + 1) % 3;
    updateIndicators();
    console.log('Rotated to slide:', currentSlide);
  }
  
  function updateIndicators() {
    // Con un solo indicador, solo actualizar el atributo data-slide
    if (indicators.length === 1) {
      indicators[0].setAttribute('data-slide', currentSlide);
    }
  }
  
  // Permitir click en el indicador para pausar/reanudar
  indicators.forEach((indicator, index) => {
    indicator.addEventListener('click', function(e) {
      e.preventDefault();
      console.log('Clicked indicator');
      
      // Toggle seleccionado/deseleccionado
      const isActive = indicator.classList.contains('active');
      
      if (isActive) {
        // Si está activo, deseleccionar y reanudar
        indicator.classList.remove('active');
        carousel.style.animationPlayState = 'running';
        console.log('Circle deselected - Animation resumed');
      } else {
        // Si está inactivo, seleccionar y pausar
        indicator.classList.add('active');
        carousel.style.animationPlayState = 'paused';
        console.log('Circle selected - Animation paused');
      }
    });
  });
  
  // Inicializar indicador activo
  updateIndicators();
});

