<?php

namespace App\Controllers;

use App\Models\ComprasModel;
use App\Models\SuppliersModel;
use App\Models\ProjectModel;
use App\Models\ContractModel;

/**
 * Dashboard Controller - Proxy para redirecciones
 */
class Dashboard extends BaseController
{
    protected $comprasModel;
    protected $suppliersModel;
    protected $projectModel;
    protected $contractModel;

    public function __construct()
    {
        $this->comprasModel = new ComprasModel();
        $this->suppliersModel = new SuppliersModel();
        $this->projectModel = new ProjectModel();
        $this->contractModel = new ContractModel();
    }

    /**
     * Redireccionar al módulo de compras
     */
    public function compras()
    {
        $comprasController = new D_compras();
        return $comprasController->index();
    }

    /**
     * Crear nueva compra
     */
    public function crearCompra()
    {
        $comprasController = new D_compras();
        return $comprasController->create();
    }

    /**
     * Guardar compra
     */
    public function guardarCompra()
    {
        $comprasController = new D_compras();
        return $comprasController->store();
    }

    /**
     * Ver detalles de compra
     */
    public function verCompra($id)
    {
        $comprasController = new D_compras();
        return $comprasController->view($id);
    }

    /**
     * Clasificar compra
     */
    public function clasificarCompra()
    {
        $comprasController = new D_compras();
        return $comprasController->clasificar();
    }

    /**
     * Aprobar compra
     */
    public function aprobarCompra()
    {
        $comprasController = new D_compras();
        return $comprasController->aprobar();
    }

    /**
     * Reporte de compras
     */
    public function reporteCompras()
    {
        $comprasController = new D_compras();
        return $comprasController->reporte();
    }

    /**
     * Descargar comprobante
     */
    public function descargarComprobante($id)
    {
        $comprasController = new D_compras();
        return $comprasController->descargarComprobante($id);
    }

    /**
     * Obtener gastos por compra (AJAX) - DESACTIVADO
     * Las rutas explícitas en Routes.php para D_compras::getGastosByCompra tienen prioridad
     * Este método podría causar conflicto con el enrutamiento AJAX, por eso está desactivado
     * Si necesitas usar este proxy, asegúrate de que la ruta explícita tenga mayor prioridad
     */
    /*
    public function getGastosByCompra($compra_id = null)
    {
        $comprasController = new D_compras();
        return $comprasController->getGastosByCompra($compra_id);
    }
    */

    /**
     * Guardar clasificación de gasto - DESACTIVADO
     * Las rutas explícitas en Routes.php para D_compras::guardarClasificacionGasto tienen prioridad
     * Este método podría causar conflicto con el enrutamiento AJAX, por eso está desactivado
     */
    /*
    public function guardarClasificacionGasto()
    {
        $comprasController = new D_compras();
        return $comprasController->guardarClasificacionGasto();
    }
    */

    /**
     * Eliminar compra
     */
    public function eliminarCompra($id)
    {
        $comprasController = new D_compras();
        return $comprasController->delete($id);
    }
}
