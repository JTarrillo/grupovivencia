<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="VIVELAND - Entrenamiento Inmobiliario en Cusco 13 de Junio">
    <meta name="theme-color" content="#4A90E2">
    <title>VIVELAND - Entrenamiento Inmobiliario</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo site_url('assets/front/img/ico/vivencia.png'); ?>">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Main Stylesheet (compiled SCSS) -->
    <link rel="stylesheet" href="<?php echo site_url('assets/css/main.css'); ?>">
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
                    <li><a href="#hero">Inicio</a></li>
                    <li><a href="#expertos">Expertos</a></li>
                    <li><a href="<?php echo site_url('viveland/sobre-evento'); ?>">Sobre el evento</a></li>
                    <li><a href="#tickets">Tickets</a></li>
                    <li><a href="#registro" class="nav-registro">Registro</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- ========================================
         HERO SECTION
         ======================================== -->
    <section class="hero" id="hero">
        <div class="hero-bg-carousel" id="heroBgVideo">
            <video id="heroMainVideo" class="hero-slide active" preload="metadata" playsinline
                poster="<?php echo site_url('assets/front/img/logo/bannerviveland1.png'); ?>">
                <source src="<?php echo site_url('assets/front/img/logo/video tim 2 .mp4'); ?>" type="video/mp4">
                Tu navegador no soporta videos HTML5.
            </video>
        </div>
        <div class="hero-bg-mobile">
            <img class="hero-mobile-image"
                src="<?php echo site_url('assets/front/img/logo/bannervivelandresponsive1.png'); ?>"
                alt="Banner responsive VIVELAND 2026">
        </div>
        <!-- Overlay de participación -->
        <div class="hero-overlay-content">
            <div class="hero-cta-box">
                <button type="button" class="btn-quiero-participar" id="btnQuieroParticipar">
                    <i class="fas fa-play-circle"></i> Ver video
                </button>
            </div>
        </div>
    </section>

    <!-- ========================================
         EXPERTOS SECTION - CARRUSEL
         ======================================== -->
    <section class="section section-white expertos-section" id="expertos">
        <h2 class="section-title">Nuestros Expertos</h2>

        <div class="container-xl">
            <div class="experts-container">
                <!-- CARRUSEL IZQUIERDA -->
                <div class="experts-carousel-wrapper">
                    <div class="experts-carousel">
                        <!-- Expert 1 - Javier Cubas -->
                        <div class="expert-card-carousel">
                            <div class="expert-image">
                                <img src="<?php echo site_url('assets/front/img/logo/javiercubas.png'); ?>"
                                    alt="Javier Cubas">
                            </div>
                            <div class="expert-info">
                                <h3 class="expert-name">Javier Cubas</h3>
                                <span class="expert-specialty">Ventas e Inversiones</span>
                                <p class="expert-description">
                                    Proceso de ventas, metas y plan de negocio. Piensa en grande y escala sin límites.
                                </p>
                            </div>
                        </div>

                        <!-- Expert 2 - Luis Enrique -->
                        <div class="expert-card-carousel">
                            <div class="expert-image">
                                <img src="<?php echo site_url('assets/front/img/logo/luis enrique.png'); ?>"
                                    alt="Luis Enrique">
                            </div>
                            <div class="expert-info">
                                <h3 class="expert-name">Luis Enrique</h3>
                                <span class="expert-specialty">Tributación y Finanzas</span>
                                <p class="expert-description">
                                    Estrategias financieras y tributación inmobiliaria. Gana más y paga lo justo.
                                </p>
                            </div>
                        </div>

                        <!-- Expert 3 - Tim Villafuerte -->
                        <div class="expert-card-carousel">
                            <div class="expert-image">
                                <img src="<?php echo site_url('assets/front/img/logo/timvillafuerte.png'); ?>"
                                    alt="Tim Villafuerte">
                            </div>
                            <div class="expert-info">
                                <h3 class="expert-name">Tim Villafuerte</h3>
                                <span class="expert-specialty">Ventas Masivas</span>
                                <p class="expert-description">
                                    Domina la estrategia de cierres de alto nivel. Aprende cómo cerrar más y mejor.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- INDICADOR ÚNICO -->
                    <div class="carousel-indicators">
                        <span class="indicator" data-slide="0"></span>
                    </div>
                </div>

                <!-- SERVICIOS DERECHA -->
                <div class="experts-info-wrapper">
                    <!-- Introducción -->
                    <div class="experts-intro">
                        <h3 style="font-size: 1.4rem; font-weight: 700; color: var(--text-dark); margin-bottom: 1rem;">
                            Lo Que Ofrecemos
                        </h3>
                        <p
                            style="color: var(--text-light); font-size: 0.95rem; line-height: 1.6; margin-bottom: 1.5rem;">
                            Nuestros expertos ponen a tu disposición sus conocimientos y experiencias para ayudarte a
                            alcanzar tus objetivos inmobiliarios.
                        </p>
                    </div>

                    <!-- Tarjeta de Servicios -->
                    <div class="expert-insight">
                        <h3><i class="fas fa-star"></i> Capacitación Especializada</h3>

                        <div class="insight-item">
                            <div class="insight-item-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="insight-item-content">
                                <h4>Ventas y Cierre de Negocios</h4>
                                <p>Técnicas probadas de Tim Villafuerte para aumentar conversiones y cerrar más
                                    operaciones de alto valor.</p>
                            </div>
                        </div>

                        <div class="insight-item">
                            <div class="insight-item-icon">
                                <i class="fas fa-coins"></i>
                            </div>
                            <div class="insight-item-content">
                                <h4>Planificación Tributaria</h4>
                                <p>Estrategias financieras con Luis Enrique para optimizar tu patrimonio y cumplir
                                    normativas tributarias.</p>
                            </div>
                        </div>

                        <div class="insight-item">
                            <div class="insight-item-icon">
                                <i class="fas fa-handshake"></i>
                            </div>
                            <div class="insight-item-content">
                                <h4>Escalamiento de Negocios</h4>
                                <p>Procesos de Javier Cubas para escalar tu operación inmobiliaria sin límites y
                                    alcanzar nuevos mercados.</p>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>

    <!-- ========================================
         BENEFICIOS
         ======================================== -->
    <section class="section section-white">
        <h2 class="section-title">¿Qué Obtendrás?</h2>
        <div class="container-xl">
            <div class="grid-2"
                style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
                <div class="benefit-card">
                    <div class="benefit-icon"><i class="fas fa-fire"></i></div>
                    <h3 class="benefit-title">Estrategias Comprobadas</h3>
                    <p class="benefit-text">Métodos que funcionan en el mercado inmobiliario real</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon"><i class="fas fa-lightbulb"></i></div>
                    <h3 class="benefit-title">Mentoría Directa</h3>
                    <p class="benefit-text">Aprende directamente de los expertos líderes</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon"><i class="fas fa-star"></i></div>
                    <h3 class="benefit-title">Resultados Reales</h3>
                    <p class="benefit-text">Implementa lo que funciona y crece exponencialmente</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon"><i class="fas fa-users"></i></div>
                    <h3 class="benefit-title">Networking</h3>
                    <p class="benefit-text">Conecta con profesionales de alto nivel</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================
         BONIFICACIONES
         ======================================== -->
    <section class="section section-gradient">
        <h2 class="section-title">Bonificaciones Incluidas</h2>
        <p class="section-subtitle">Todo lo que recibirás en el evento</p>

        <div class="container-xl">
            <div class="grid-4"
                style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 2rem;">
                <div class="bonus-card">
                    <div class="bonus-icon"><i class="fas fa-book"></i></div>
                    <h3 class="bonus-title">Material Digital</h3>
                    <p class="bonus-text">Manuales, templates y guías de implementación</p>
                </div>

                <div class="bonus-card">
                    <div class="bonus-icon"><i class="fas fa-video"></i></div>
                    <h3 class="bonus-title">Videos Grabados</h3>
                    <p class="bonus-text">Acceso de por vida a todas las sesiones</p>
                </div>

                <div class="bonus-card">
                    <div class="bonus-icon"><i class="fas fa-headset"></i></div>
                    <h3 class="bonus-title">Soporte Premium</h3>
                    <p class="bonus-text">Grupo exclusivo de WhatsApp con los mentores</p>
                </div>

                <div class="bonus-card">
                    <div class="bonus-icon"><i class="fas fa-certificate"></i></div>
                    <h3 class="bonus-title">Certificado</h3>
                    <p class="bonus-text">Documento verificado de participación</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================
         PREGUNTAS FRECUENTES
         ======================================== -->
    <section class="section section-white">
        <h2 class="section-title">Preguntas Frecuentes</h2>
        <p class="section-subtitle">Resolvemos tus dudas</p>

        <div class="container-xl" style="max-width: 800px;">
            <div class="faq-item">
                <div class="faq-question">
                    <span>¿Cuál es la fecha exacta del evento?</span>
                    <i class="fas fa-plus faq-icon"></i>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-text">El evento VIVELAND Cusco será el 13 de Junio en nuestras instalaciones
                        en Cusco. Puertas abren a las 8:00 AM.</div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>¿Puedo asistir si soy principiante?</span>
                    <i class="fas fa-plus faq-icon"></i>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-text">¡Claro! VIVELAND está diseñado para todos los niveles. Desde
                        principiantes hasta expertos encontrarán valor.</div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>¿Hay reembolso si no me gusta?</span>
                    <i class="fas fa-plus faq-icon"></i>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-text">Ofrecemos garantía de satisfacción 100% en los primeros 7 días si
                        realmente no quedaste conforme. Sin preguntas.</div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>¿Qué incluye el plan VIP?</span>
                    <i class="fas fa-plus faq-icon"></i>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-text">Plan VIP incluye: Sesión privada con expertos, certificado profesional,
                        acceso de por vida, soporte prioritario.</div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>¿Puedo llevar a un socio?</span>
                    <i class="fas fa-plus faq-icon"></i>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-text">¡Por supuesto! Manejamos descuentos para grupos. Contáctanos a través
                        de WhatsApp para consultar opciones.</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================
         TICKETS / PRICING - CARRUSEL 3D
         ======================================== -->
    <section class="section section-white" id="tickets">
        <h2 class="section-title">Elige Tu Zona</h2>
        <p class="section-subtitle">Selecciona tu ubicación en el evento del 13 de Junio</p>

        <!-- CARRUSEL 3D DE ZONAS -->
        <div class="container-xl">
            <div class="tickets-layout">
                <!-- COLUMNA IZQUIERDA - CARRUSEL 3D -->
                <div class="tickets-carousel-col">
                    <div class="zonas-carousel-wrapper">
                        <div class="zonas-carousel">
                            <!-- Zona Viveland -->
                            <div class="zona-carousel-card zona-viveland">
                                <div class="zona-label">Zona Viveland</div>
                                <div class="asientos-grid">
                                    <span class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span>
                                    <span class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span>
                                </div>
                                <div class="zona-price">S/. 450.00</div>
                                <button type="button" class="btn-zona-select"
                                    onclick="document.getElementById('registro').scrollIntoView({behavior: 'smooth'})">
                                    Seleccionar
                                </button>
                            </div>

                            <!-- Zona VIP -->
                            <div class="zona-carousel-card zona-vip">
                                <div class="zona-label">Zona VIP</div>
                                <div class="asientos-grid">
                                    <span class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span>
                                    <span class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span>
                                    <span class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span>
                                </div>
                                <div class="zona-price">S/. 289.00</div>
                                <button type="button" class="btn-zona-select"
                                    onclick="document.getElementById('registro').scrollIntoView({behavior: 'smooth'})">
                                    Seleccionar
                                </button>
                            </div>

                            <!-- Zona Platinum -->
                            <div class="zona-carousel-card zona-platinum">
                                <div class="zona-label">Zona Platinum</div>
                                <div class="asientos-grid">
                                    <span class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span>
                                    <span class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span>
                                    <span class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span>
                                    <span class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span>
                                </div>
                                <div class="zona-price">S/. 189.00</div>
                                <button type="button" class="btn-zona-select"
                                    onclick="document.getElementById('registro').scrollIntoView({behavior: 'smooth'})">
                                    Seleccionar
                                </button>
                            </div>

                            <!-- Zona General -->
                            <div class="zona-carousel-card zona-general">
                                <div class="zona-label">Zona General</div>
                                <div class="asientos-grid">
                                    <span class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span>
                                    <span class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span>
                                    <span class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span>
                                    <span class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span>
                                    <span class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span>
                                    <span class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span><span
                                        class="asiento"></span><span class="asiento"></span>
                                </div>
                                <div class="zona-price">S/. 89.00</div>
                                <button type="button" class="btn-zona-select"
                                    onclick="document.getElementById('registro').scrollIntoView({behavior: 'smooth'})">
                                    Seleccionar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- COLUMNA DERECHA - INFORMACIÓN Y PDF -->
                <div class="tickets-info-col">
                    <div class="tickets-info-card">
                        <div class="info-header">
                            <h3 class="tickets-info-title">Detalles del Evento</h3>
                            <p class="info-subtitle">Toda la información que necesitas</p>
                        </div>

                        <div class="tickets-info-content">
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <div class="info-text">
                                    <span class="info-label">FECHA</span>
                                    <p>13 de Junio 2026</p>
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-hourglass-start"></i>
                                </div>
                                <div class="info-text">
                                    <span class="info-label">HORARIO</span>
                                    <p>8:00 AM - 6:00 PM</p>
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-location-dot"></i>
                                </div>
                                <div class="info-text">
                                    <span class="info-label">UBICACIÓN</span>
                                    <p>Centro De Convenciones<br>Alabado 207, Cusco 08002</p>
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <div class="info-text">
                                    <span class="info-label">INSTRUCTORES</span>
                                    <p>Tim Villafuerte<br>Luis Enrique<br>Javier Cubas</p>
                                </div>
                            </div>
                        </div>

                        <div class="pdf-section">
                            <div class="pdf-header">
                                <i class="fas fa-file-pdf"></i>
                                <span>Brochure Informativo</span>
                            </div>
                            <p class="pdf-description">Descarga el documento con toda la información del evento, agenda
                                completa y detalles de cada sesión.</p>
                            <a href="<?php echo site_url('assets/BROCHURE-VIVELAND-MARZO_LITE.pdf'); ?>" download
                                class="btn-download-pdf">
                                <i class="fas fa-download"></i> Descargar PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================
         REGISTRO / FORMULARIO - INTEGRADO
         ======================================== -->
    <section class="section section-gradient" id="registro">
        <div class="container-xl">
            <div class="registro-container">
                <!-- COLUMNA IZQUIERDA - FORMULARIO -->
                <div class="registro-form-wrapper">
                    <h2 class="registro-title">Asegura Tu Lugar</h2>
                    <p class="registro-subtitle">Regístrate ahora y sé parte de VIVELAND</p>

                    <form id="vivelandForm" class="viveland-form">
                        <div class="form-group">
                            <label for="nombre" class="form-label">
                                <i class="fas fa-user"></i> Nombre Completo
                            </label>
                            <input type="text" class="form-control" id="nombre" name="nombre"
                                placeholder="Tu nombre completo" required>
                            <small class="form-text" style="display:none;"></small>
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope"></i> Email
                            </label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="tu@email.com"
                                required>
                            <small class="form-text" style="display:none;"></small>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="telefono" class="form-label">
                                    <i class="fas fa-phone"></i> Teléfono
                                </label>
                                <input type="tel" class="form-control" id="telefono" name="telefono"
                                    placeholder="+51 999 999 999" required>
                                <small class="form-text" style="display:none;"></small>
                            </div>

                            <div class="form-group">
                                <label for="zona" class="form-label">
                                    <i class="fas fa-ticket-alt"></i> Elige tu Entrada
                                </label>
                                <select class="form-control" id="zona" name="zona" required>
                                    <option value="">-- Selecciona tu zona --</option>
                                    <option value="Zona Viveland">Zona Viveland - S/. 450.00</option>
                                    <option value="Zona VIP">Zona VIP - S/. 289.00</option>
                                    <option value="Zona Platinum">Zona Platinum - S/. 189.00</option>
                                    <option value="Zona General">Zona General - S/. 89.00</option>
                                </select>
                                <small class="form-text" style="display:none;"></small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="interes" class="form-label">
                                <i class="fas fa-star"></i> ¿Cuál es tu mayor interés?
                            </label>
                            <select class="form-control" id="interes" name="interes" required>
                                <option value="">-- Selecciona una opción --</option>
                                <option value="Ventas Inmobiliarias">Aprender Ventas Inmobiliarias</option>
                                <option value="Tributación">Entender Tributación</option>
                                <option value="Inversiones">Estrategias de Inversión</option>
                                <option value="Networking">Hacer Networking</option>
                                <option value="Otro">Otro</option>
                            </select>
                            <small class="form-text" style="display:none;"></small>
                        </div>

                        <div class="form-checkbox">
                            <input type="checkbox" id="terminos" name="terminos" required>
                            <label for="terminos">
                                Acepto los términos y condiciones
                            </label>
                        </div>

                        <button type="submit" class="btn-submit btn-submit-registro" id="btnRegistro">
                            <i class="fas fa-check"></i> Registrarse Ahora
                        </button>

                        <div id="videoMessageAlert" class="video-message-alert" style="display:none;">
                            <i class="fas fa-info-circle"></i> Completa el video para desbloquear el registro
                        </div>

                        <div id="formMessage" class="form-message" style="display:none;"></div>
                    </form>
                </div>

                <!-- COLUMNA DERECHA - MAPA Y BENEFICIOS -->
                <div class="registro-side-wrapper">
                    <!-- MAPA -->
                    <div class="registro-map-wrapper">
                        <div class="map-container">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7758.6154904570085!2d-71.98297372639408!3d-13.516696071005844!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x916dd60cbac2ecd1%3A0xcd55c48d696bb8fd!2sCentro%20De%20Convenciones!5e0!3m2!1ses!2sus!4v1776305993677!5m2!1ses!2sus"
                                width="100%" height="250" style="border:0; border-radius: 8px;" allowfullscreen=""
                                loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                        <div class="map-address">
                            <p><strong>Centro De Convenciones</strong></p>
                            <p>Alabado 207, Cusco 08002, Perú</p>
                        </div>
                        <a href="https://maps.app.goo.gl/mP4ChFajKjoFkU8A7" target="_blank" class="btn-map-directions">
                            <i class="fas fa-map-marker-alt"></i> Ver Ubicación
                        </a>
                    </div>

                    <!-- BENEFICIOS -->
                    <div class="registro-benefits-wrapper">
                        <div class="benefits-card">
                            <div class="benefit-item">
                                <div class="benefit-icon">
                                    <i class="fas fa-rocket"></i>
                                </div>
                                <h4>Acceso Inmediato</h4>
                                <p>Comienza en el evento sin esperas</p>
                            </div>

                            <div class="benefit-item">
                                <div class="benefit-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <h4>Networking Elite</h4>
                                <p>Conecta con profesionales líderes</p>
                            </div>

                            <div class="benefit-item">
                                <div class="benefit-icon">
                                    <i class="fas fa-certificate"></i>
                                </div>
                                <h4>Certificación</h4>
                                <p>Obtén tu certificado oficial</p>
                            </div>

                            <div class="benefit-item">
                                <div class="benefit-icon">
                                    <i class="fas fa-headset"></i>
                                </div>
                                <h4>Soporte Completo</h4>
                                <p>Asistencia disponible 24/7</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================
         WHATSAPP SECTION
         ======================================== -->
    <section class="section section-gradient">
        <div class="container-xl" style="text-align: center;">
            <h2 class="section-title">¿Tienes Dudas?</h2>
            <p class="section-subtitle">Contáctanos por WhatsApp</p>
            <a href="https://chat.whatsapp.com/Fog6lcdyRrc9XMLI8YbV0T" target="_blank" class="whatsapp-icon-link"
                data-tooltip="Únete al Grupo">
                <i class="fab fa-whatsapp"></i>
            </a>
        </div>
    </section>

    <!-- ========================================
         VIDEO MODAL FULLSCREEN
         ======================================== -->
    <div id="videoModal" class="video-modal">
        <div class="video-modal-overlay"></div>
        <div class="video-modal-container">
            <button class="video-modal-close" id="videoModalClose">
                <i class="fas fa-times"></i>
            </button>
            <div class="video-modal-content">
                <video id="videoModalPlayer" class="video-modal-player" controls>
                    <source src="<?php echo site_url('assets/front/img/logo/video tim 2 .mp4'); ?>" type="video/mp4">
                    Tu navegador no soporta videos HTML5
                </video>
            </div>
        </div>
    </div>

    <!-- ========================================
         QUICK REGISTRATION MODAL
         ======================================== -->
    <div id="quickRegisterModal" class="quick-register-modal">
        <div class="quick-register-overlay"></div>
        <div class="quick-register-container">
            <button class="quick-register-close" id="closeQuickRegister">
                <i class="fas fa-times"></i>
            </button>
            <div class="quick-register-content">
                <h2>¡Únete a VIVELAND!</h2>
                <p>Completa tus datos y nos pondremos en contacto por WhatsApp</p>

                <form id="quickRegisterForm" class="quick-register-form">
                    <div class="form-group">
                        <label for="qr-nombre" class="form-label">
                            <i class="fas fa-user"></i> Nombre Completo
                        </label>
                        <input type="text" class="form-control" id="qr-nombre" name="nombre"
                            placeholder="Nombre y Apellido" required>
                    </div>

                    <div class="form-group">
                        <label for="qr-email" class="form-label">
                            <i class="fas fa-envelope"></i> Email
                        </label>
                        <input type="email" class="form-control" id="qr-email" name="email" placeholder="tu@email.com"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="qr-telefono" class="form-label">
                            <i class="fas fa-phone"></i> Teléfono
                        </label>
                        <input type="tel" class="form-control" id="qr-telefono" name="telefono"
                            placeholder="+51 999 999 999">
                    </div>

                    <div class="form-group">
                        <label for="qr-zona" class="form-label">
                            <i class="fas fa-ticket-alt"></i> Elige tu Entrada
                        </label>
                        <select class="form-control" id="qr-zona" name="zona" required>
                            <option value="">-- Selecciona tu entrada --</option>
                            <option value="Zona Viveland">Zona Viveland - S/. 450.00</option>
                            <option value="Zona VIP">Zona VIP - S/. 289.00</option>
                            <option value="Zona Platinum">Zona Platinum - S/. 189.00</option>
                            <option value="Zona General">Zona General - S/. 89.00</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="qr-interes" class="form-label">
                            <i class="fas fa-star"></i> ¿Tu interés?
                        </label>
                        <select class="form-control" id="qr-interes" name="interes">
                            <option value="">-- Selecciona una opción --</option>
                            <option value="Ventas Inmobiliarias">Ventas Inmobiliarias</option>
                            <option value="Tributación">Tributación</option>
                            <option value="Inversiones">Inversiones</option>
                            <option value="Networking">Networking</option>
                            <option value="General">General</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-quick-submit">
                        <i class="fab fa-whatsapp"></i> Contactarme por WhatsApp
                    </button>
                </form>
            </div>
        </div>
    </div>

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
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Carousel Script -->
    <script src="<?php echo site_url('assets/js/carousel.js'); ?>"></script>

    <!-- Script - Flujo Video + Formulario "Quiero Participar" -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnQuieroParticipar = document.getElementById('btnQuieroParticipar');
        const heroCtaBox = document.querySelector('.hero-cta-box');
        const videoModal = document.getElementById('videoModal');
        const videoModalPlayer = document.getElementById('videoModalPlayer');
        const videoModalClose = document.getElementById('videoModalClose');
        const quickRegisterModal = document.getElementById('quickRegisterModal');
        const closeQuickRegister = document.getElementById('closeQuickRegister');
        const quickRegisterOverlay = document.querySelector('.quick-register-overlay');

        // Abrir video en modal desde el botón Play
        if (btnQuieroParticipar) {
            btnQuieroParticipar.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('🎬 Iniciando flujo: Modal video → Formulario');

                if (heroCtaBox) {
                    heroCtaBox.style.opacity = '0';
                    heroCtaBox.style.transition = 'opacity 0.3s ease-out';
                    heroCtaBox.style.pointerEvents = 'none';
                }

                setTimeout(() => {
                    videoModal.classList.add('active');
                    document.body.style.overflow = 'hidden';

                    if (videoModalPlayer) {
                        videoModalPlayer.currentTime = 0;
                        videoModalPlayer.play().catch(err => console.log(
                            'Error al reproducir video modal:', err));
                    }
                }, 300);
            });
        }

        // Al terminar el video modal se abre el formulario rápido
        if (videoModalPlayer) {
            videoModalPlayer.addEventListener('ended', function() {
                console.log('✅ Video terminó - mostrando formulario');

                videoModal.classList.remove('active');

                setTimeout(() => {
                    quickRegisterModal.classList.add('active');
                    document.body.style.overflow = 'hidden';
                    console.log('📋 Formulario de registro abierto');
                }, 300);
            });
        }

        // Cerrar video modal manualmente
        if (videoModalClose) {
            videoModalClose.addEventListener('click', function() {
                videoModal.classList.remove('active');
                videoModalPlayer.pause();
                videoModalPlayer.currentTime = 0;
                document.body.style.overflow = 'auto';
                console.log('❌ Video cerrado manualmente');
            });
        }

        // Cerrar formulario modal
        if (closeQuickRegister) {
            closeQuickRegister.addEventListener('click', function() {
                quickRegisterModal.classList.remove('active');
                document.body.style.overflow = 'auto';
                console.log('❌ Formulario cerrado');
            });
        }

        // Cerrar formulario al hacer click en el overlay
        if (quickRegisterOverlay) {
            quickRegisterOverlay.addEventListener('click', function() {
                quickRegisterModal.classList.remove('active');
                document.body.style.overflow = 'auto';
            });
        }

        // Cerrar video modal si se hace click en el overlay
        const videoOverlay = document.querySelector('.video-modal-overlay');
        if (videoOverlay) {
            videoOverlay.addEventListener('click', function() {
                videoModal.classList.remove('active');
                videoModalPlayer.pause();
                videoModalPlayer.currentTime = 0;
                document.body.style.overflow = 'auto';
            });
        }
    });
    </script>

    <!-- Main JavaScript (Module) -->
    <script type="module" src="<?php echo site_url('assets/js/main.js'); ?>"></script>

    <!-- Debug Logger para diagnóstico en producción -->
    <script src="<?php echo site_url('assets/js/debug.js'); ?>"></script>

    <!-- CAROUSEL DEBUG SCRIPT -->
    <script>
    console.log('\n🔍 === CAROUSEL ADVANCED DEBUG ===\n');

    // Esperar a que el DOM esté completamente listo
    setTimeout(() => {
        const carouselContainer = document.querySelector('.experts-carousel');
        const cards = document.querySelectorAll('.expert-card-carousel');

        if (!carouselContainer || cards.length === 0) {
            console.error('❌ Carrusel no encontrado en el DOM');
            return;
        }

        console.log('✅ Carrusel DEBUG ACTIVO\n');

        // Información de cada tarjeta
        cards.forEach((card, idx) => {
            const name = card.querySelector('.expert-name')?.textContent || 'Sin nombre';
            const img = card.querySelector('img');
            const imgSrc = img?.src || 'Sin imagen';

            console.log(`\n📌 TARJETA ${idx + 1}: ${name}`);
            console.log(`   Imagen: ${imgSrc}`);
            console.log(`   Elemento: ${card.tagName}.${card.className}`);

            // Observar cambios en estilos calculados
            const observer = new MutationObserver(() => {
                const computed = window.getComputedStyle(card);
                if (computed.display !== 'none') {
                    console.log(
                        `   [ACTUALIZACIÓN] ${name} - zIndex: ${computed.zIndex}, opacity: ${computed.opacity}, animationPlayState: ${computed.animationPlayState}`
                        );
                }
            });

            observer.observe(card, {
                attributes: true,
                attributeFilter: ['style'],
                subtree: false
            });
        });

        // Monitorear cada 2 segundos
        console.log('\n⏱️  Monitoreo activo cada 2 segundos...\n');
        setInterval(() => {
            cards.forEach((card, idx) => {
                const name = card.querySelector('.expert-name')?.textContent || 'Sin nombre';
                const computed = window.getComputedStyle(card);
                const rect = card.getBoundingClientRect();
                const isVisible = rect.width > 0 && rect.height > 0 && computed.visibility !==
                    'hidden';

                console.log(
                    `${idx + 1}. ${name.padEnd(15)} | zIdx: ${computed.zIndex.padEnd(3)} | opacity: ${computed.opacity.padEnd(3)} | visible: ${isVisible ? '✓' : '✗'}`
                    );
            });
        }, 2000);

    }, 1000);
    </script>

    <!-- Hero Image Carousel Script -->
    <script>
    // Hamburger Menu Functionality
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

    // El carrusel gira automáticamente con CSS animation
    // No se necesita JavaScript adicional
    </script>
</body>

</html>