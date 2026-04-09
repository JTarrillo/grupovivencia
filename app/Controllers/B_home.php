<?php

namespace App\Controllers;

use App\Models\ComisionesInmobiliariasModel;
use App\Models\CustomerModel;
use App\Models\RangesModel;
use App\Models\CalificationModel;
use App\Controllers\B_carrera;
use App\Libraries\Evox;
use Fluent\ShoppingCart\Facades\Cart;

class B_home extends BaseController
{
    public function index()
    {
        //call library Evox
        $evox = new Evox();

    $ComisionesInmobiliarias = new ComisionesInmobiliariasModel();
        //get count product shopping cart
        $cart_count = Cart::count();
        //get data session
        $session = session();
        $id = $session->get('client_id');
        //get fortnightly period
        
        //get current period
        $dataPeriod = $evox->get_period();

        //get data point ranges
        $point = 0;
        $percent = 0;
        //get data customer
        $Customer = new CustomerModel();
        //get all row
        $obj_customer = $Customer->get_all_data($id);
        $total_team_active = $obj_customer->total_team_active;

        // Obtener lotes asignados con contrato
        $LotModel = new \App\Models\LotModel();
        $ContractModel = new \App\Models\ContractModel();
        // Contar contratos del cliente en lugar de lotes
        $total_lotes_contrato = $ContractModel->where('customer_id', $id)->countAllResults();

        // Obtener total de comisiones inmobiliarias como en Home.php
        $total_periodo = $ComisionesInmobiliarias
            ->selectSum('monto')
            ->where('beneficiario_id', $id)
            ->whereIn('estado', ['aprobada', 'pagada'])
            ->where('fecha_generada >=', $dataPeriod->begin)
            ->where('fecha_generada <=', $dataPeriod->end)
            ->first()['monto'] ?? 0;
        $total_disponible = $total_periodo; // Si hay lógica de retenciones/pagos, ajustar aquí
        $total_comissions = $total_periodo; // Para compatibilidad con la vista
        $code_period = date('my'); // O usa el código de periodo que corresponda

        // Obtener historial de comisiones inmobiliarias del periodo (últimas 30)

        $obj_commissions = $ComisionesInmobiliarias
            ->where('beneficiario_id', $id)
            ->whereIn('estado', ['aprobada', 'pagada'])
            ->where('fecha_generada >=', $dataPeriod->begin)
            ->where('fecha_generada <=', $dataPeriod->end)
            ->orderBy('fecha_generada', 'DESC')
            ->findAll(30);
        // Convertir a objetos para acceso tipo $comision->campo en la vista
        $obj_commissions = array_map(function($row) { return (object)$row; }, $obj_commissions);

        
        //get range_id and next range
        $Ranges = new RangesModel();
        $obj_ranges = $Ranges->get_range_next($id);
        //get the full rating for the period
        
        //to obtain group points for the period    
        $info = $evox->get_point_current_period($id);
        $point =  $info['point'];

        $next_range_point = $obj_ranges->next_range_point?$obj_ranges->next_range_point:0;
        if($next_range_point){
            $percent = ($point / $next_range_point) * 100;
            if ($percent > 100) {
                $percent = 100;
            }
        }else{
            $percent = 100;
        }
        
        //get percent
        //set var team active range
        $title = "Panel";
        //set data view
        $data = array(
            'obj_customer' => $obj_customer,
            'obj_ranges' => $obj_ranges,
            'dataPeriod' => $dataPeriod,
            'total_comissions' => $total_comissions,
            'total_disponible' => $total_disponible,
            'total_periodo' => $total_periodo,
            'obj_commissions' => $obj_commissions,
            'code_period' => $code_period,
            'point' => $point,
            'total_team_active' => $total_team_active,
            'percent' => $percent,
            'title' => $title,
            'cart_count' => $cart_count,
            'total_lotes_contrato' => $total_lotes_contrato
        );
        // Crear log de datos enviados al home
        $logData = [
            'datetime' => date('Y-m-d H:i:s'),
            'customer_id' => $id,
            'data' => $data
        ];
        $logFile = WRITEPATH . 'logs/home_' . $id . '_' . date('Ymd_His') . '.log';
        file_put_contents($logFile, json_encode($logData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        return view('backoffice_new/home', $data);
    }

    public function home2()
    {
        // KPIs inmobiliarios
        $inmuebleModel = new \App\Models\InmuebleModel();
        $lotModel = new \App\Models\LotModel();
        $contractModel = new \App\Models\ContractModel();

        // Total proyectos, activos, en planificación, vendidos
        $dashboardStats = $inmuebleModel->getDashboardStats();

        // Total contratos activos
        $total_contratos_activos = $contractModel->where('status', 'active')->countAllResults();

        // Total lotes disponibles
        $total_lotes_disponibles = $lotModel->where('status', 'available')->countAllResults();

        // Total pagos pendientes (ejemplo: contratos con status 'pending_payment')
        $total_pagos_pendientes = $contractModel->where('status', 'pending_payment')->countAllResults();

        // Total facturas emitidas (ejemplo: contratos con status 'invoiced')
        $total_facturas_emitidas = $contractModel->where('status', 'invoiced')->countAllResults();

        // Obtener datos del cliente para la cabecera
        $Customer = new \App\Models\CustomerModel();
        $session = session();
        $id = $session->get('client_id');
        $obj_customer = $Customer->get_all_data($id);

        // Obtener cantidad de productos en el carrito
        $cart_count = \Fluent\ShoppingCart\Facades\Cart::count();

        $data = [
            'obj_customer' => $obj_customer,
            'total_contratos_activos' => $total_contratos_activos,
            'total_lotes_disponibles' => $total_lotes_disponibles,
            'total_pagos_pendientes' => $total_pagos_pendientes,
            'total_facturas_emitidas' => $total_facturas_emitidas,
            'dashboardStats' => $dashboardStats,
            'title' => 'Panel Inmobiliario',
            'cart_count' => $cart_count
        ];
        return view('backoffice_new/home2', $data);
    }

    public function logout()
    {
        $session = session();
        // Destruir completamente la sesión
        $session->destroy();
        return redirect()->to('/iniciar-sesion');
    }
}