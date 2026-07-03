<script src="<?php echo site_url()."assets/admin/js/vendor-all.js";?>"></script>
<script src="<?php echo site_url()."assets/admin/js/bootstrap.js";?>"></script>
<script src="<?php echo site_url()."assets/admin/js/pcoded.js";?>"></script>
<script src="<?php echo site_url()."assets/admin/js/amcharts.js";?>"></script>
<script src="<?php echo site_url()."assets/admin/js/serial.js";?>"></script>
<script src="<?php echo site_url()."assets/admin/js/pie.js";?>"></script>
<script src="<?php echo site_url()."assets/admin/js/datatables.js";?>"></script>
<script src="<?php echo site_url()."assets/admin/js/bl-datatable-custom.js";?>"></script>
<script src="<?php echo site_url()."assets/admin/lightbox/lightbox.js";?>"></script>
<script src="<?php echo site_url()."assets/admin/js/inputmask.js";?>"></script>
<script src="<?php echo site_url()."assets/admin/js/jquery.inputmask.js";?>"></script>
<script src="<?php echo site_url()."assets/admin/js/autoNumeric.js";?>"></script>
<script src="<?php echo site_url()."assets/admin/js/form-masking-custom.js";?>"></script>
<!-- Include Date Range Picker -->
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script>
// ========== GLOBAL MENU HANDLER - FUNCIONA EN TODAS LAS PÁGINAS ==========
document.addEventListener('DOMContentLoaded', function() {
    // #region debug-point C:reporter
    const reportMenuDebug = function(hypothesisId, msg, data) {
        fetch('http://127.0.0.1:7777/event', {
            method: 'POST',
            keepalive: true,
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                sessionId: 'menu-clicks',
                runId: 'pre-fix',
                hypothesisId: hypothesisId,
                location: 'app/Views/admin/footer.php',
                msg: '[DEBUG] ' + msg,
                data: data || {},
                ts: Date.now()
            })
        }).catch(() => {});
    };
    // #endregion

    // #region debug-point C:window-error
    window.addEventListener('error', function(event) {
        reportMenuDebug('C', 'JavaScript error global en admin', {
            message: event.message,
            source: event.filename,
            line: event.lineno,
            column: event.colno
        });
    });
    // #endregion

    console.log('🔧 Inicializando manejador global de menú pcoded...');
    
    // Obtener todos los elementos del menú que tienen submenu
    const menuItems = document.querySelectorAll('.pcoded-navbar .nav-item.pcoded-hasmenu');
    const sidebar = document.querySelector('.pcoded-navbar');
    
    console.log(`📍 Encontrados ${menuItems.length} items de menú con submenu`);
    // #region debug-point E:menu-scan
    reportMenuDebug('E', 'Escaneo inicial del sidebar', {
        menuCount: menuItems.length,
        labels: Array.from(menuItems).map(item => item.querySelector(':scope > a.nav-link')?.textContent.trim() || '(sin label)')
    });
    // #endregion

    // #region debug-point A:sidebar-capture
    if (sidebar) {
        sidebar.addEventListener('click', function(event) {
            const anchor = event.target.closest('a');
            reportMenuDebug('A', 'Click capturado dentro del sidebar', {
                targetTag: event.target?.tagName || null,
                anchorText: anchor?.textContent?.trim() || null,
                anchorHref: anchor?.getAttribute('href') || null,
                defaultPrevented: event.defaultPrevented
            });
        }, true);
    }
    // #endregion
    
    menuItems.forEach((item, index) => {
        // Obtener el link principal y el submenu
        const link = item.querySelector(':scope > a.nav-link');
        const submenu = item.querySelector(':scope > ul.pcoded-submenu');
        
        if (!link || !submenu) {
            console.warn(`⚠️ Item ${index}: estructura inválida`);
            return;
        }
        
        const itemText = link.textContent.trim();
        console.log(`✓ Item ${index}: "${itemText}"`);
        
        // Inicializar estilos del submenu
        submenu.style.transition = 'all 0.3s ease-in-out';
        submenu.style.overflow = 'hidden';
        
        // Agregar click handler al link
        link.addEventListener('click', function(e) {
            // #region debug-point A:top-link-click
            reportMenuDebug('A', 'Click en item principal del menu', {
                index: index,
                text: itemText,
                href: link.getAttribute('href'),
                wasOpen: item.classList.contains('pcoded-trigger'),
                submenuHeight: submenu.scrollHeight
            });
            // #endregion
            e.preventDefault();
            e.stopPropagation();
            
            // Toggle la clase pcoded-trigger
            const isOpen = item.classList.contains('pcoded-trigger');
            
            if (isOpen) {
                // Cerrar
                item.classList.remove('pcoded-trigger');
                submenu.style.maxHeight = '0px';
                submenu.style.opacity = '0';
                submenu.style.overflow = 'hidden';
                window.setTimeout(function() {
                    if (!item.classList.contains('pcoded-trigger')) {
                        submenu.style.display = 'none';
                    }
                }, 300);
            } else {
                // Cerrar otros submenús abiertos
                document.querySelectorAll('.pcoded-navbar .nav-item.pcoded-hasmenu.pcoded-trigger').forEach(otherItem => {
                    if (otherItem !== item) {
                        otherItem.classList.remove('pcoded-trigger');
                        const otherSubmenu = otherItem.querySelector(':scope > ul.pcoded-submenu');
                        if (otherSubmenu) {
                            otherSubmenu.style.maxHeight = '0px';
                            otherSubmenu.style.opacity = '0';
                            otherSubmenu.style.display = 'none';
                        }
                    }
                });
                
                // Abrir este
                item.classList.add('pcoded-trigger');
                submenu.style.display = 'block';
                submenu.style.maxHeight = submenu.scrollHeight + 'px';
                submenu.style.opacity = '1';
                submenu.style.overflow = 'visible';
            }

            // #region debug-point E:toggle-result
            reportMenuDebug('E', 'Resultado del toggle del submenu', {
                index: index,
                text: itemText,
                isOpenAfter: item.classList.contains('pcoded-trigger'),
                maxHeight: submenu.style.maxHeight,
                opacity: submenu.style.opacity
            });
            // #endregion
        });

        // #region debug-point B:submenu-links
        submenu.querySelectorAll('a').forEach((subLink) => {
            subLink.addEventListener('click', function(event) {
                reportMenuDebug('B', 'Click en enlace de submenu', {
                    parentText: itemText,
                    linkText: subLink.textContent.trim(),
                    href: subLink.getAttribute('href'),
                    defaultPrevented: event.defaultPrevented
                });
            }, true);
        });
        // #endregion
        
        // Si ya está activo, abrir por defecto
        if (item.classList.contains('active') || item.classList.contains('pcoded-trigger')) {
            submenu.style.display = 'block';
            submenu.style.maxHeight = submenu.scrollHeight + 'px';
            submenu.style.opacity = '1';
            item.classList.add('pcoded-trigger');
        } else {
            submenu.style.display = 'none';
            submenu.style.maxHeight = '0px';
            submenu.style.opacity = '0';
        }
    });
    
    console.log('✅ Manejador global de menú inicializado');
});

// Compatibilidad global: asegura que la X/cerrar funcione en modales aunque falte data-dismiss
$(document).on('click', '.modal .close, .modal [data-dismiss="modal"], .modal [data-bs-dismiss="modal"]', function (e) {
	var $modal = $(this).closest('.modal');
	if (!$modal.length) {
		return;
	}

	e.preventDefault();

	// Bootstrap 4 (jQuery plugin)
	if (typeof $modal.modal === 'function') {
		$modal.modal('hide');
		return;
	}

	// Fallback seguro
	$modal.removeClass('show').hide();
	$('body').removeClass('modal-open').css('padding-right', '');
	$('.modal-backdrop').remove();
});
</script>
</body>
</html>
