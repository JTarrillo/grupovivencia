<header id="header-section" data-style="style-2" data-primary-skin="ut-primary-custom-skin"
    data-secondary-skin="ut-secondary-custom-skin"
    class="ha-header  ut-header-floating fullwidth bordered-top ut-primary-custom-skin" data-line-height="80"
    data-total-height="121" style="background-color: rgba(0, 0, 0, 0.75);">
    <div class="grid-container">
        <div class="ha-header-perspective clearfix">
            <div class="ha-header-front clearfix">
                <div class="site-logo-wrap grid-15 tablet-grid-80 mobile-grid-70"
                    style="display: flex; align-items: center;">
                    <div class="site-logo" style="margin-left: 35% !important;">
                        <h1 class="logo" style="text-align: center;">
                            <a href="<?php echo site_url();?>" rel="home" style="margin-left: 35% !important;">
                                <img src="<?php echo site_url()."assets/front/img/logo/logo_2025.png?1";?>" alt="logo">
                            </a>
                        </h1>
                    </div>
                </div>
                <nav id="navigation"
                    class="ut-horizontal-navigation ut-navigation-for-style-2 grid-70 hide-on-tablet hide-on-mobile ut-navigation-style-animation-line-middle ut-navigation-with-animation ut-navigation-with-link-animation ut-navigation-with-link-animation-type-border ">
                    <ul id="menu-main" class="ut-navigation-menu menu">
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-7 current_page_item menu-item-10 ut-menu-item-lvl-0 ut-home-link menu-item-object-custom"
                            data-menu-id="10">
                            <a href="<?php echo site_url();?>"
                                class="ut-main-navigation-link"><span>Bienvenido</span></a>
                        </li>
                        <!-- Módulos Inmobiliarios -->
                        <li class="menu-item menu-item-type-custom menu-item-object-custom ut-menu-item-lvl-0"
                            data-menu-id="1001">
                            <a href="<?php echo site_url('backoffice_new/projects'); ?>"
                                class="ut-main-navigation-link"><span>Proyectos</span></a>
                        </li>
                        <li class="menu-item menu-item-type-custom menu-item-object-custom ut-menu-item-lvl-0"
                            data-menu-id="1002">
                            <a href="<?php echo site_url('backoffice_new/lots'); ?>"
                                class="ut-main-navigation-link"><span>Lotes/Terrenos</span></a>
                        </li>
                        <li class="menu-item menu-item-type-custom menu-item-object-custom ut-menu-item-lvl-0"
                            data-menu-id="1003">
                            <a href="<?php echo site_url('backoffice_new/contracts'); ?>"
                                class="ut-main-navigation-link"><span>Contratos</span></a>
                        </li>
                        <li class="menu-item menu-item-type-custom menu-item-object-custom ut-menu-item-lvl-0"
                            data-menu-id="1004">
                            <a href="<?php echo site_url('backoffice_new/clients'); ?>"
                                class="ut-main-navigation-link"><span>Clientes</span></a>
                        </li>
                        <li class="menu-item menu-item-type-custom menu-item-object-custom ut-menu-item-lvl-0"
                            data-menu-id="1005">
                            <a href="<?php echo site_url('backoffice_new/payments'); ?>"
                                class="ut-main-navigation-link"><span>Pagos</span></a>
                        </li>
                        <!-- Módulos de Red Multinivel (solo 2 niveles) -->
                        <li class="menu-item menu-item-type-custom menu-item-object-custom ut-menu-item-lvl-0"
                            data-menu-id="2001">
                            <a href="<?php echo site_url('backoffice_new/unilevel'); ?>"
                                class="ut-main-navigation-link"><span>Red (Unilevel)</span></a>
                        </li>
                        <!-- Otros módulos antiguos o generales -->
                        <li class="menu-item menu-item-type-custom menu-item-object-custom ut-menu-item-lvl-0"
                            data-menu-id="555">
                            <a href="<?php echo site_url();?>#section-services"
                                class="ut-main-navigation-link"><span>Nosotros</span></a>
                        </li>
                        <li class="contact-us menu-item menu-item-type-custom menu-item-object-custom ut-menu-item-lvl-0"
                            data-menu-id="558">
                            <a href="<?php echo site_url();?>#section-contact"
                                class="ut-main-navigation-link"><span>Contacto</span></a>
                        </li>
                    </ul>
                </nav>
                <div class="tablet-grid-20 mobile-grid-30 hide-on-desktop">
                    <div class="ut-mm-trigger">
                        <div id="ut-hamburger-wrap-mobile" class="ut-hamburger-wrap">
                            <a id="ut-open-mobile-menu" class="ut-hamburger ut-hamburger--cross" type="button">
                                <span></span>
                            </a>
                        </div>
                    </div>
                </div>
                <nav id="ut-mobile-nav" class="ut-mobile-menu mobile-grid-100 tablet-grid-100 hide-on-desktop">
                    <div class="ut-scroll-pane-wrap">
                        <div class="ut-scroll-pane">
                            <ul id="ut-mobile-menu" class="ut-mobile-menu ut-mobile-menu-left">
                                <li id="menu-item-10"
                                    class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-7 current_page_item menu-item-10 ut-home-link menu-item-object-custom ut-front-page-link">
                                    <a href="<?php echo site_url();?>" class="selected">Bienvenido</a>
                                </li>
                                <li id="menu-item-554"
                                    class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-554">
                                    <a href="<?php echo site_url();?>#section-work">Productos</a>
                                </li>
                                <li id="menu-item-555"
                                    class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-555">
                                    <a href="<?php echo site_url();?>#section-services">Nosotros</a>
                                </li>
                                <li id="menu-item-556"
                                    class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-556">
                                    <a href="<?php echo site_url();?>#section-contact">Contacto</a>
                                </li>
                                <li id="menu-item-556"
                                    class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-556">
                                    <a href="<?php echo site_url()."iniciar-sesion";?>">Iniciar Sesión</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <div
                    class="ut-header-primary-extra-module ut-header-extra-module ut-header-extra-module-buttons ut-header-extra-module-right ut-header-extra-module-small  grid-15 hide-on-tablet hide-on-mobile">
                    <div id="ut-header-primary-extra-module" class="ut-horizontal-navigation">
                        <ul class="ut-header-extra-module-buttons ut-navigation-menu ut-navigation-more-disabled menu">
                            <li>
                                <div id="bklyn_btn_66703f49e7a7d" class="bklyn-btn-holder bklyn-btn-header">
                                    <a title="Iniciar Sesión" href="<?php echo site_url()."iniciar-sesion";?>"
                                        class="bklyn-btn"><span class="ut-btn-text">Iniciar Sesión</span></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>