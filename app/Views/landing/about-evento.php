<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="VIVELAND - Sobre el Evento Inmobiliario en Cusco">
    <meta name="theme-color" content="#4A90E2">
    <title>Sobre el Evento - VIVELAND 2026</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo site_url('assets/front/img/ico/vivencia.png'); ?>">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Main Stylesheet (compiled SCSS) -->
    <link rel="stylesheet" href="<?php echo site_url('assets/css/main.css'); ?>">
    <!-- About Evento Stylesheet -->
    <link rel="stylesheet" href="<?php echo site_url('assets/css/about-evento.css'); ?>">
</head>

<body>

    <!-- ========================================
         HEADER / NAVIGATION
         ======================================== -->
    <header>
        <div class="header-container">
            <div class="logo-section">
                <img src="<?php echo site_url('assets/front/img/logo/Recursovivencia.png'); ?>" alt="Logo">
            </div>
            <button class="hamburger-menu" id="hamburgerMenu" aria-label="Menú">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <nav class="nav-menu" id="navMenu">
                <ul class="nav-items">
                    <li><a href="<?php echo site_url('viveland'); ?>">Inicio</a></li>
                    <li><a href="<?php echo site_url('viveland'); ?>#expertos">Expertos</a></li>
                    <li><a href="<?php echo site_url('viveland/sobre-evento'); ?>">Sobre el evento</a></li>
                    <li><a href="<?php echo site_url('viveland'); ?>#tickets">Tickets</a></li>
                    <li><a href="<?php echo site_url('viveland'); ?>#registro" class="nav-registro">Registro</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- ========================================
         HERO SECTION
         ======================================== -->
    <section class="hero-about">
        <!-- Banner para Escritorio -->
        <div class="banner-web"></div>
        
        <!-- Banner para Móvil -->
        <div class="banner-mobile"></div>
        
        <!-- Contenido de texto (oculto) -->
        <div style="display: none;">
            <h1>VIVELAND 2026</h1>
            <p class="subtitle-primary">Cumbre del Desarrollo Inmobiliario</p>
            <p class="subtitle-secondary">Impulsa tu crecimiento inmobiliario</p>
        </div>
    </section>

    <!-- ========================================
         SOBRE EL EVENTO
         ======================================== -->
    <section class="section section-white">
        <h2 class="section-title">Sobre el Entrenamiento</h2>

        <div class="container-xl">
            <div class="evento-grid">
                <div class="evento-text">
                    <p>
                        Este <span class="highlight-large">13 de junio</span> llega a <strong class="highlight">Cusco
                            VIVELAND</strong>,
                        un entrenamiento de alto valor diseñado para <span class="highlight">empresarios,
                            inversionistas, asesores comerciales,
                            emprendedores y dueños de negocio</span> que quieran crecer en ventas y generar mayores
                        ingresos.
                    </p>

                    <div class="instructores-box">
                        <p class="instructores-box-title">
                            <i class="fas fa-star"></i>Nuestros Expertos
                        </p>

                        <div class="instructor-item">
                            <i class="fas fa-user-circle"></i>
                            <div>
                                <div class="instructor-name">Luis Enrique</div>
                                <div class="instructor-role">Tributación y Finanzas</div>
                            </div>
                        </div>

                        <div class="instructor-item">
                            <i class="fas fa-user-circle"></i>
                            <div>
                                <div class="instructor-name">Tim Villafuerte</div>
                                <div class="instructor-role">Ventas Masivas</div>
                            </div>
                        </div>

                        <div class="instructor-item">
                            <i class="fas fa-user-circle"></i>
                            <div>
                                <div class="instructor-name">Javier Cubas</div>
                                <div class="instructor-role">Ventas e Inversiones</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="evento-card">
                    <div class="evento-card-content">
                        <div class="evento-card-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>

                        <p class="evento-card-date">13 de Junio 2026</p>

                        <div class="evento-card-details">
                            <div>
                                <div class="evento-card-detail-icon"><i class="fas fa-clock"></i></div>
                                <p class="evento-card-detail-text">8:00 AM - 6:00 PM</p>
                            </div>
                            <div>
                                <div class="evento-card-detail-icon"><i class="fas fa-location-dot"></i></div>
                                <p class="evento-card-detail-text">Cusco</p>
                            </div>
                        </div>

                        <div class="evento-card-footer">
                            <p>
                                <i class="fas fa-map-marker-alt"></i>
                                Centro De Convenciones<br />
                                Alabado 207, Cusco 08002
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================
         ¿PARA QUIÉN ES?
         ======================================== -->
    <section class="section section-gradient">
        <h2 class="section-title">¿Para quién es esta capacitación?</h2>

        <div class="container-xl">
            <div class="target-cards-container">
                <div class="target-cards-grid" id="targetCarousel">
                    <div class="target-card">
                        <div class="target-icon"><i class="fas fa-user-tie"></i></div>
                        <p>Agentes inmobiliarios</p>
                    </div>
                    <div class="target-card">
                        <div class="target-icon"><i class="fas fa-briefcase"></i></div>
                        <p>Dueños de negocio</p>
                    </div>
                    <div class="target-card">
                        <div class="target-icon"><i class="fas fa-chart-line"></i></div>
                        <p>Profesionales independientes</p>
                    </div>
                    <div class="target-card">
                        <div class="target-icon"><i class="fas fa-home"></i></div>
                        <p>Desarrolladores inmobiliarios</p>
                    </div>
                    <div class="target-card">
                        <div class="target-icon"><i class="fas fa-handshake"></i></div>
                        <p>Vendedores y asesores</p>
                    </div>
                    <div class="target-card">
                        <div class="target-icon"><i class="fas fa-piggy-bank"></i></div>
                        <p>Inversionistas inmobiliarios</p>
                    </div>
                    <div class="target-card">
                        <div class="target-icon"><i class="fas fa-building"></i></div>
                        <p>Constructoras</p>
                    </div>
                    <div class="target-card">
                        <div class="target-icon"><i class="fas fa-lightbulb"></i></div>
                        <p>Emprendedores</p>
                    </div>
                </div>
            </div>

            <!-- Carousel Controls -->
            <div class="carousel-controls">
                <button class="carousel-btn carousel-prev" id="carouselPrev" title="Anterior">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <div class="carousel-indicators" id="carouselIndicators"></div>
                <button class="carousel-btn carousel-next" id="carouselNext" title="Siguiente">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- ========================================
         QUÉ APRENDERÁS
         ======================================== -->
    <section class="section section-white">
        <h2 class="section-title">¿Qué aprenderás en VIVELAND?</h2>

        <div class="container-xl">
            <div class="learn-cards-grid">
                <div class="learn-card">
                    <div class="learn-icon"><i class="fas fa-chalkboard-user"></i></div>
                    <h3>Vender cualquier tipo de producto</h3>
                    <p>Dominando estrategias de comunicación, negociación y cierre de ventas de alto valor.</p>
                </div>

                <div class="learn-card">
                    <div class="learn-icon"><i class="fas fa-award"></i></div>
                    <h3>El método de Tim Villafuerte</h3>
                    <p>Que le llevó a vender más de <strong>4,500 lotes en un solo año</strong>.</p>
                </div>

                <div class="learn-card">
                    <div class="learn-icon"><i class="fas fa-users-line"></i></div>
                    <h3>Captar más clientes</h3>
                    <p>Generar negocios y oportunidades de forma constante y sistemática.</p>
                </div>

                <div class="learn-card">
                    <div class="learn-icon"><i class="fas fa-chart-pie"></i></div>
                    <h3>Estrategias contables y financieras</h3>
                    <p>Para hacer crecer tu negocio de manera sostenible y rentable.</p>
                </div>

                <div class="learn-card">
                    <div class="learn-icon"><i class="fas fa-receipt"></i></div>
                    <h3>Planificación tributaria</h3>
                    <p>Optimizada para maximizar tus ganancias legalmente y eficientemente.</p>
                </div>

                <div class="learn-card">
                    <div class="learn-icon"><i class="fas fa-rocket"></i></div>
                    <h3>Escalamiento de negocios</h3>
                    <p>Sin límites y hacia nuevos mercados con estrategia clara.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================
         POR QUÉ ASISTIR
         ======================================== -->
    <section class="section section-gradient">
        <h2 class="section-title">¿Por qué asistir a VIVELAND?</h2>

        <div class="container-xl">
            <div class="why-items-container">
                <div class="why-item">
                    <div class="why-icon"><i class="fas fa-check-circle"></i></div>
                    <div class="why-content">
                        <h4>Conocimiento especializado</h4>
                        <p>Acceso exclusivo a conocimiento en ventas masivas, contabilidad y desarrollo inmobiliario de
                            expertos del mercado.</p>
                    </div>
                </div>

                <div class="why-item">
                    <div class="why-icon"><i class="fas fa-check-circle"></i></div>
                    <div class="why-content">
                        <h4>Networking de alto nivel</h4>
                        <p>Conecta con agentes inmobiliarios, empresarios, inversionistas y líderes comerciales del
                            sector en un ambiente profesional.</p>
                    </div>
                </div>

                <div class="why-item">
                    <div class="why-icon"><i class="fas fa-check-circle"></i></div>
                    <div class="why-content">
                        <h4>Alianzas comerciales reales</h4>
                        <p>Expande tu red de contactos y genera oportunidades reales de negocio que pueden transformar
                            tu empresa.</p>
                    </div>
                </div>

                <div class="why-item">
                    <div class="why-icon"><i class="fas fa-check-circle"></i></div>
                    <div class="why-content">
                        <h4>Estrategias probadas en el mercado</h4>
                        <p>Aprende métodos que funcionan en el mercado inmobiliario real, directamente de los expertos
                            con track record comprobado.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================
         CTA SECTION - COMENTADO
         ======================================== -->
    <!-- 
    <section class="section section-white cta-section-wrapper">
        <h2 class="section-title">Asegura Tu Lugar Ahora</h2>
        <p class="section-subtitle">No pierdas esta oportunidad de crecer tu negocio inmobiliario</p>

        <div class="container-xl">
            <div class="cta-buttons">
                <a href="<?php echo site_url('viveland'); ?>#tickets" class="btn-primary-about">
                    <i class="fas fa-ticket-alt"></i> Ver Zonas y Precios
                </a>
                <a href="<?php echo site_url('viveland'); ?>#registro" class="btn-outline-about">
                    <i class="fas fa-check-circle"></i> Registrarse Ahora
                </a>
            </div>
        </div>
    </section>
    -->

    <!-- ========================================
         FOOTER
         ======================================== -->
    <footer>
        <div class="footer-content">
            <p>&copy; 2026 VIVELAND - Entrenamiento Inmobiliario | Vivencia Group</p>
            <div class="footer-social">
                <a href="https://www.tiktok.com/@viveland.pe" target="_blank" title="TikTok" class="social-icon">
                    <i class="fab fa-tiktok"></i>
                </a>
                <a href="https://www.instagram.com/viveland.pe" target="_blank" title="Instagram" class="social-icon">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>
        </div>
    </footer>

    <!-- ========================================
         FLOATING WHATSAPP BUTTON
         ======================================== -->
    <a href="https://chat.whatsapp.com/Fog6lcdyRrc9XMLI8YbV0T" target="_blank" class="whatsapp-btn-floating"
        data-tooltip="Únete a nuestro grupo de WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Hamburger Menu Functionality -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const hamburgerMenu = document.getElementById('hamburgerMenu');
        const navMenu = document.getElementById('navMenu');
        const navItems = document.querySelectorAll('.nav-items a');

        if (hamburgerMenu) {
            // Toggle menu cuando se hace click en el hamburger
            hamburgerMenu.addEventListener('click', function() {
                hamburgerMenu.classList.toggle('active');
                navMenu.classList.toggle('active');
            });

            // Cerrar menú cuando se hace click en un link
            navItems.forEach(item => {
                item.addEventListener('click', function() {
                    hamburgerMenu.classList.remove('active');
                    navMenu.classList.remove('active');
                });
            });

            // Cerrar menú cuando se hace click fuera
            document.addEventListener('click', function(event) {
                const isClickInside = hamburgerMenu.contains(event.target) || navMenu.contains(event
                    .target);
                if (!isClickInside && hamburgerMenu.classList.contains('active')) {
                    hamburgerMenu.classList.remove('active');
                    navMenu.classList.remove('active');
                }
            });
        }
    });
    </script>

    <!-- Target Carousel Module -->
    <script src="<?php echo site_url('assets/js/target-carousel.js'); ?>"></script>

    <!-- About-Evento Module -->
    <script src="<?php echo site_url('assets/js/about-evento.js'); ?>"></script>
</body>

</html>