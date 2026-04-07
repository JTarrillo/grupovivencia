<?php

namespace App\Controllers;

use App\Models\GastosModel;
use App\Models\ComprasModel;

class D_gastos extends BaseController
{
    protected $gastosModel;
    protected $comprasModel;

    public function __construct()
    {
        $this->gastosModel = new GastosModel();
        $this->comprasModel = new ComprasModel();
    }

    /**
     * Dashboard de gastos
     */
    public function index()
    {
        $session = session();

        if (!$session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        $gastos = $this->gastosModel->getGastosWithDetails();
        $estadisticas = $this->gastosModel->getEstadisticasGastos();
        $resumen = $this->gastosModel->getResumenGastos();
        $gastosPorMes = $this->gastosModel->getGastosPorMes(date('Y'));

        $data = [
            'session_id' => $session->get('id'),
            'session_name' => $session->get('name') . " " . $session->get('lastname'),
            'title' => 'Módulo de Gastos',
            'gastos' => $gastos,
            'estadisticas' => $estadisticas,
            'resumen' => $resumen,
            'gastosPorMes' => $gastosPorMes
        ];

        return view('admin/gastos/index', $data);
    }

    /**
     * Reporte de gastos por período
     */
    public function reporte()
    {
        $session = session();

        if (!$session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        $fecha_inicio = $this->request->getGet('fecha_inicio') ?? date('Y-m-01');
        $fecha_fin = $this->request->getGet('fecha_fin') ?? date('Y-m-d');
        $clasificacion = $this->request->getGet('clasificacion');

        $gastos = $this->gastosModel->getGastosPorPeriodo($fecha_inicio, $fecha_fin);
        $resumenPorTipo = $this->gastosModel->getTotalGastosPorTipo();
        $estadisticas = $this->gastosModel->getEstadisticasGastos();

        if ($clasificacion) {
            $gastos = array_filter($gastos, function ($g) use ($clasificacion) {
                return $g['clasificacion'] == $clasificacion;
            });
        }

        $data = [
            'session_id' => $session->get('id'),
            'session_name' => $session->get('name') . " " . $session->get('lastname'),
            'title' => 'Reporte de Gastos',
            'gastos' => $gastos,
            'resumenPorTipo' => $resumenPorTipo,
            'estadisticas' => $estadisticas,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'clasificacion' => $clasificacion
        ];

        return view('admin/gastos/reporte', $data);
    }

    /**
     * Reporte analítico (análisis de gastos por proyecto)
     */
    public function analitico()
    {
        $session = session();

        if (!$session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        $año = $this->request->getGet('año') ?? date('Y');
        $gastosPorMes = $this->gastosModel->getGastosPorMes($año);
        $resumenPorTipo = $this->gastosModel->getTotalGastosPorTipo();

        $data = [
            'session_id' => $session->get('id'),
            'session_name' => $session->get('name') . " " . $session->get('lastname'),
            'title' => 'Análisis de Gastos',
            'gastosPorMes' => $gastosPorMes,
            'resumenPorTipo' => $resumenPorTipo,
            'año' => $año
        ];

        return view('admin/gastos/analitico', $data);
    }

    /**
     * Gastos pendientes de aprobación (para gerente/contador)
     */
    public function pendientes()
    {
        $session = session();

        if (!$session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        $gastosPendientes = $this->gastosModel->getGastosPendientesAprobacion();

        $data = [
            'session_id' => $session->get('id'),
            'session_name' => $session->get('name') . " " . $session->get('lastname'),
            'title' => 'Gastos Pendientes de Aprobación',
            'gastos' => $gastosPendientes
        ];

        return view('admin/gastos/pendientes', $data);
    }

    /**
     * Exportar gastos a Excel/PDF
     */
    public function exportar()
    {
        if (strtoupper($this->request->getMethod()) !== 'POST') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Método no permitido'
            ]);
        }

        try {
            $formato = $this->request->getPost('formato'); // excel, pdf
            $fecha_inicio = $this->request->getPost('fecha_inicio');
            $fecha_fin = $this->request->getPost('fecha_fin');
            $clasificacion = $this->request->getPost('clasificacion');

            $gastos = $this->gastosModel->getGastosPorPeriodo($fecha_inicio, $fecha_fin);

            if ($clasificacion) {
                $gastos = array_filter($gastos, function ($g) use ($clasificacion) {
                    return $g['clasificacion'] == $clasificacion;
                });
            }

            if ($formato === 'excel') {
                return $this->exportarExcel($gastos, $fecha_inicio, $fecha_fin);
            } elseif ($formato === 'pdf') {
                return $this->exportarPDF($gastos, $fecha_inicio, $fecha_fin);
            }

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Formato no válido'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error al exportar: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Generar tabla/datos para análisis comparativo
     */
    public function comparativo()
    {
        $session = session();

        if (!$session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        $año_anterior = date('Y') - 1;
        $año_actual = date('Y');

        $gastosAnterior = $this->gastosModel->getGastosPorMes($año_anterior);
        $gastosActual = $this->gastosModel->getGastosPorMes($año_actual);

        $data = [
            'session_id' => $session->get('id'),
            'session_name' => $session->get('name') . " " . $session->get('lastname'),
            'title' => 'Análisis Comparativo de Gastos',
            'gastosAnterior' => $gastosAnterior,
            'gastosActual' => $gastosActual,
            'año_anterior' => $año_anterior,
            'año_actual' => $año_actual
        ];

        return view('admin/gastos/comparativo', $data);
    }

    /**
     * Método auxiliar: exportar a Excel
     */
    private function exportarExcel($gastos, $fecha_inicio, $fecha_fin)
    {
        // Implementación con PHPExcel o similar
        // Por ahora, retornar notificación
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Exportación a Excel pendiente de implementar',
            'formato' => 'excel',
            'records' => count($gastos)
        ]);
    }

    /**
     * Método auxiliar: exportar a PDF
     */
    private function exportarPDF($gastos, $fecha_inicio, $fecha_fin)
    {
        // Implementación con Dompdf o similar
        // Por ahora, retornar notificación
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Exportación a PDF pendiente de implementar',
            'formato' => 'pdf',
            'records' => count($gastos)
        ]);
    }

    /**
     * API: obtener gastos por proyecto
     */
    public function gastosPorProyecto()
    {
        if ($this->request->isAJAX()) {
            $proyecto_id = $this->request->getGet('proyecto_id');

            if (!$proyecto_id) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'ID de proyecto requerido'
                ]);
            }

            $gastos = $this->gastosModel->getGastosPorProyecto($proyecto_id);

            return $this->response->setJSON([
                'success' => true,
                'data' => $gastos,
                'total' => array_sum(array_column($gastos, 'total'))
            ]);
        }

        return $this->response->setStatusCode(403);
    }

    /**
     * API: obtener estadísticas rápidas
     */
    public function estadisticas()
    {
        if ($this->request->isAJAX()) {
            $estadisticas = $this->gastosModel->getEstadisticasGastos();
            $resumen = $this->gastosModel->getResumenGastos();

            return $this->response->setJSON([
                'success' => true,
                'estadisticas' => $estadisticas,
                'resumen' => $resumen
            ]);
        }

        return $this->response->setStatusCode(403);
    }
}
