<?php
namespace App\Libraries;

/**
 * MenuBackup
 *
 * Clase pequeña para generar un menú limpio de respaldo para pruebas.
 * Uso: $menu = new \App\Libraries\MenuBackup(); echo $menu->render('clientes');
 */
class MenuBackup
{
    protected $items = [
        'panel' => ['label' => 'Panel', 'url' => '/dashboard/inmueble', 'icon' => 'feather icon-home'],
        'clientes' => ['label' => 'Clientes', 'url' => '/dashboard/clientes', 'icon' => 'fa fa-users'],
        'comisiones' => ['label' => 'Comisiones', 'url' => '/dashboard/comisiones', 'icon' => 'fa fa-money-bill'],
        'facturas' => ['label' => 'Facturas', 'url' => '/dashboard/facturas', 'icon' => 'fa fa-file-invoice'],
        'soporte' => ['label' => 'Soporte', 'url' => '/dashboard/ticket', 'icon' => 'fa fa-headphones'],
    ];

    /**
     * Renderiza el HTML del menú.
     * @param string|null $active clave del item que debe aparecer activo
     * @return string HTML
     */
    public function render($active = null)
    {
        $html = "<nav class=\"pcoded-navbar navbar-collapsed\" style=\"overflow-y:auto;overflow-x: hidden !important;\">\n";
        $html .= "  <div class=\"navbar-wrapper\">\n";
        $html .= "    <div class=\"navbar-content scroll-div\">\n";
        $html .= "      <ul class=\"nav pcoded-inner-navbar\">\n";

        foreach ($this->items as $key => $it) {
            $liClass = 'nav-item';
            $aClass = 'nav-link';
            if ($key === $active) {
                $aClass .= ' active_nav_backup';
                $liClass .= ' active';
            }
            $html .= "        <li class=\"" . $liClass . "\">\n";
            $html .= "          <a href=\"" . $it['url'] . "\" class=\"" . $aClass . "\">";
            $html .= "<span class=\"pcoded-micon\"><i class=\"" . $it['icon'] . "\"></i></span> <span class=\"pcoded-mtext\">" . $it['label'] . "</span>";
            $html .= "</a>\n";
            $html .= "        </li>\n";
        }

        $html .= "      </ul>\n";
        $html .= "    </div>\n";
        $html .= "  </div>\n";
        $html .= "</nav>\n";

        // Añadimos el estilo de prueba inline para no depender de archivos externos.
        $html .= "<style>.active_nav_backup{background-color:#ffefc1 !important;color:#333 !important;border-left:4px solid #ff9900 !important;}</style>\n";

        return $html;
    }
}
