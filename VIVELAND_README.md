# VIVELAND - Landing Page Profesional

## 🏆 Stack Tecnológico

- **HTML5**: Semántico y limpio
- **Bootstrap 5**: Framework UI responsivo
- **SASS/SCSS**: CSS modular y mantenible
- **Vanilla JavaScript**: Componentes modulares (sin dependencias)
- **Font Awesome**: Iconos profesionales

---

## 📁 Estructura de Carpetas

```
public/assets/
├── css/
│   ├── main.css (compilado de SCSS - NO EDITAR DIRECTAMENTE)
│   └── ...
├── scss/
│   ├── main.scss (punto de entrada)
│   ├── variables.scss (colores, tipografía, espaciados)
│   ├── mixins.scss (utilidades reutilizables)
│   └── components/
│       ├── header.scss
│       ├── hero.scss
│       ├── gallery.scss
│       └── cards.scss
├── js/
│   ├── main.js (inicializador principal)
│   └── components/
│       ├── Gallery.js (galería con lightbox)
│       ├── Carousel.js (slider de testimonios)
│       └── FAQ.js (acordeón de preguntas)
└── images/
    └── (imágenes globales)

app/Views/landing/
├── viveland.php (versión antigua - DEPRECADA)
└── viveland_new.php (NUEVA - USAR ESTA)
```

---

## 🚀 Instalación & Setup

### 1. Instalar Dependencias

```bash
npm install
```

### 2. Compilar SCSS a CSS

**Compilación única:**

```bash
npm run scss:build
```

**Compilación en tiempo real (desarrollo):**

```bash
npm run scss
```

El CSS compilado se guarda en `public/assets/css/main.css`

---

## 📝 Cómo Usar

### Cambiar Rutas

Si quieres usar la nueva landing page:

1. En `app/Config/Routes.php`:

```php
$routes->get('/viveland', 'LandingController::viveland');
```

2. Cambiar el método del controlador para devolver `viveland_new.php`:

```php
public function viveland()
{
    return view('landing/viveland_new');
}
```

### Compilar CSS después de cambios SCSS

Mientras desarrollas, ejecuta:

```bash
npm run scss
```

Esto compilará cualquier cambio en SCSS automáticamente.

---

## 🎨 Estructura SCSS

### Variables (variables.scss)

```scss
$primary: #4a90e2; // Color principal
$spacing-lg: 2rem; // Espaciados
$font-size-4xl: 2.5rem; // Tipografía
$breakpoint-md: 768px; // Breakpoints responsive
```

### Mixins (mixins.scss)

Reutiliza código común:

```scss
// Flexbox
@include flex-center; // Centra elementos
@include flex-between; // Espacio entre items

// Responsive
@include media-md {
} // Media query tablet

// Transiciones
@include transition-base; // Transición estándar

// Botones
@include btn-base($color); // Estilo de botón
```

### Componentes

Cada componente tiene su archivo SCSS separado:

- `header.scss` - Encabezado
- `hero.scss` - Sección hero
- `gallery.scss` - Galería con lightbox
- `cards.scss` - Tarjetas (expertos, beneficios, tickets, FAQ)

---

## 🧩 Componentes JavaScript

### Gallery (Galería con Lightbox)

```javascript
import Gallery from "./components/Gallery.js";

const gallery = new Gallery(".gallery-item");

// Eventos
document.addEventListener("gallery:Open", (e) => {
  console.log("Galería abierta:", e.detail);
});
```

**Características:**

- Navegación con flechas
- Controles por teclado (←, →, ESC)
- Click en fondo para cerrar
- Lazy loading

---

### Carousel (Testimonios)

```javascript
import Carousel from "./components/Carousel.js";

const testimonials = new Carousel({
  selector: ".testimonial-card",
  dotsSelector: ".slider-dots .dot",
  autoPlay: true,
  interval: 6000, // 6 segundos
});

// Eventos
document.addEventListener("carousel:sliderChange", (e) => {
  console.log("Slide actual:", e.detail.index);
});
```

**Características:**

- Auto-play automático
- Navegación por puntos (dots)
- Pausa al interactuar
- Eventos personalizados

---

### FAQ (Acordeón)

```javascript
import FAQ from "./components/FAQ.js";

const faq = new FAQ(".faq-item");

// Métodos útiles
faq.openItem(0); // Abre primer item
faq.closeAll(); // Cierra todos
faq.setAllowMultiple(true); // Permite múltiples abiertos
```

**Características:**

- Solo un item abierto a la vez (configurable)
- Animaciones suaves
- Eventos personalizados

---

## 📱 Responsividad

Breakpoints disponibles:

```scss
$breakpoint-sm: 576px; // Teléfonos
$breakpoint-md: 768px; // Tablets
$breakpoint-lg: 992px; // Desktops
$breakpoint-xl: 1200px; // Desktops grandes
```

Usa en SCSS:

```scss
.mi-clase {
  font-size: 2rem;

  @include media-md {
    font-size: 1.5rem; // Tablet y móvil
  }
}
```

---

## 🎯 Personalización

### Cambiar Colores

En `public/assets/scss/variables.scss`:

```scss
$primary: #TU_COLOR;
$secondary: #TU_OTRO_COLOR;
```

Luego compila: `npm run scss:build`

### Agregar Nuevas Secciones

1. Crea archivo en `public/assets/scss/components/mi-componente.scss`
2. Importa en `main.scss`: `@import 'components/mi-componente';`
3. Compila SCSS
4. Usa las clases en HTML

### Crear Nuevo Componente JS

1. Crea archivo en `public/assets/js/components/MiComponente.js`
2. Exporta la clase: `export class MiComponente { }`
3. Importa en `main.js`: `import MiComponente from './components/MiComponente.js';`
4. Instancia en `DOMContentLoaded`

---

## 🔍 Debugging

El app tiene modo console:

```javascript
// En browser console
window.VIVELAND.gallery; // Accede a galería
window.VIVELAND.carousel; // Accede a testimonios
window.VIVELAND.faq; // Accede a FAQ
window.VIVELAND.animations; // Accede a animaciones

// Ejemplo
window.VIVELAND.carousel.nextSlide(); // Siguiente testimonio
```

---

## ✅ Checklist Final

- [ ] `npm install` ejecutado
- [ ] SCSS compilado: `npm run scss:build`
- [ ] Rutas configuradas en CodeIgniter
- [ ] Vista usando `viveland_new.php`
- [ ] Imágenes en `public/upload/`
- [ ] Logo en `public/assets/front/img/logo/vivencia.png`
- [ ] Bootstrap y Font Awesome cargando desde CDN
- [ ] Console sin errores

---

## 📚 Documentación Referencia

- [Bootstrap 5](https://getbootstrap.com/docs/5.3/)
- [SASS](https://sass-lang.com/documentation)
- [Font Awesome](https://fontawesome.com/docs)

---

## 🤝 Soporte

Para cambios o problemas:

1. Revisa console del navegador (F12)
2. Verifica que SCSS esté compilado a CSS
3. Limpia caché del navegador (Ctrl+Shift+R)
4. Recarga terminal de Node si usas watch mode

---

**Versión:** 1.0.0  
**Última actualización:** Abril 2026  
**Mantenedor:** Vivencia Group
