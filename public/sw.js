//asignar un nombre y versión al cache
const CACHE_NAME = 'v1_cache_azbel',
  urlsToCache = [
    './assets/front/css/widget-styles.css',
    './assets/front/css/style.min.css',
    './assets/front/css/wc-blocks-vendors-style.css',
    './assets/front/css/wc-blocks-style.css',
    './assets/front/css/eae.min.css',
    './assets/front/css/vegas.min.css',
    './assets/front/css/woocommerce-layout.css',
    './assets/front/css/woocommerce-smallscreen.css',
    './assets/front/css/woocommerce.css',
    './assets/front/css/elementor-icons.min.css',
    './assets/front/css/frontend-lite.min.css',
    './assets/front/css/global.css',
    './assets/front/css/post-49.css',
    './assets/front/css/post-51.css',
    './assets/front/css/frontend.css',
    './assets/front/css/post-8.css',
    './assets/front/css/post-39.css',
    './assets/front/css/post-57.css',
    './assets/front/css/simple-line-icons.css',
    './assets/front/css/htflexboxgrid.css',
    './assets/front/css/slick.css',
    './assets/front/css/woolentor-widgets.css',
    './assets/front/css/webfont.min.css',
    './assets/front/css/public.min.css',
    './assets/front/css/style.css',
    './assets/front/css/animate.min.css',
    './assets/front/css/flaticon.css',
    './assets/front/css/line-icons.css',
    './assets/front/css/owl.carousel.min.css',
    './assets/front/css/default.css',
    './assets/front/css/footer.css',
    './assets/front/css/header.css',
    './assets/front/css/responsive.css',
    './assets/front/css/ekiticons.css',
    './assets/front/css/responsive2.css',
    './assets/front/css/bootstrap.min.css',
    './assets/front/css/style2.css',
    './assets/front/css/styles.css',
    './assets/front/css/all.min.css',
    './assets/front/js/jquery.min.js',
    './assets/front/js/jquery-migrate.min.js',
    './assets/front/js/navigation.js',
    './assets/front/css/animations.min.css',
    './assets/front/js/eae.min.js',
    './assets/front/js/v4-shims.min.js',
    './assets/front/js/animated-main.min.js',
    './assets/front/js/particles.min.js',
    './assets/front/js/magnific.min.js',
    './assets/front/js/vegas.min.js',
    './assets/front/js/jquery.blockUI.min.js',
    './assets/front/js/js.cookie.min.js',
    './assets/front/js/woocommerce.min.js',
    './assets/front/js/bootstrap.min.js',
    './assets/front/js/owl.carousel.min.js',
    './assets/front/js/main.js',
    './assets/front/js/widget-scripts.js',
    './assets/front/js/frontend-modules.min.js',
    './assets/front/js/waypoints.min.js',
    './assets/front/js/core.min.js',
    './assets/front/js/frontend.min.js',
    './assets/front/js/animate-circle.js',
    './assets/front/js/elementor.js',
    './assets/metronic8/plugins/custom/fullcalendar/fullcalendar.bundle.css',
    './assets/metronic8/plugins/custom/datatables/datatables.bundle.css',
    './assets/metronic8/plugins/custom/prismjs/prismjs.bundle.css',
    './assets/metronic8/plugins/custom/vis-timeline/vis-timeline.bundle.css',
    './assets/admin/lightbox/lightbox.css',
    './assets/metronic8/plugins/global/plugins.bundle.css',
    './assets/metronic8/css/style.bundle.css',
    './assets/metronic8/plugins/global/plugins.bundle.js',
    './assets/metronic8/js/scripts.bundle.js',
    './assets/metronic8/plugins/custom/datatables/datatables.bundle.js?123',
    './assets/metronic8/plugins/custom/prismjs/prismjs.bundle.js',
    './assets/metronic8/js/widgets.bundle.js',
    './assets/metronic8/js/custom/widgets.js'
  ]

//durante la fase de instalación, generalmente se almacena en caché los activos estáticos
self.addEventListener('install', e => {
  e.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => {
        return cache.addAll(urlsToCache)
          .then(() => self.skipWaiting())
      })
      .catch(err => console.log('Falló registro de cache', err))
  )
})

//una vez que se instala el SW, se activa y busca los recursos para hacer que funcione sin conexión
self.addEventListener('activate', e => {
  const cacheWhitelist = [CACHE_NAME]

  e.waitUntil(
    caches.keys()
      .then(cacheNames => {
        return Promise.all(
          cacheNames.map(cacheName => {
            //Eliminamos lo que ya no se necesita en cache
            if (cacheWhitelist.indexOf(cacheName) === -1) {
              return caches.delete(cacheName)
            }
          })
        )
      })
      // Le indica al SW activar el cache actual
      .then(() => self.clients.claim())
  )
})

//cuando el navegador recupera una url
self.addEventListener('fetch', e => {
  //Responder ya sea con el objeto en caché o continuar y buscar la url real
  e.respondWith(
    caches.match(e.request)
      .then(res => {
        if (res) {
          //recuperar del cache
          return res
        }
        //recuperar de la petición a la url
        return fetch(e.request)
      })
  )
})