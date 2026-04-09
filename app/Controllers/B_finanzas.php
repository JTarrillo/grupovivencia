<?php

namespace App\Controllers;

use App\Models\ComisionesInmobiliariasModel;
use App\Models\InvoicesModel;
use App\Models\CustomerModel;
use App\Models\Invoice_detail_membershipModel;
use Dompdf\Dompdf;
use Fluent\ShoppingCart\Facades\Cart;
use App\Models\MembershipsModel;

class B_finanzas extends BaseController
{
    public function index()
    {
        //get fortnightly period
        $period = period();
        //get count product shopping cart
        $cart_count = Cart::count();
        //get data session
        $id = $_SESSION['client_id'];
        //get data planes
        $ComisionesInmobiliarias = new ComisionesInmobiliariasModel();
        $res = service('request')->getGet();

        // --- Log de la consulta y parámetros antes de ejecutarla ---
        $where_params = [
            'beneficiario_id' => $id
        ];
        $logQuery = [
            'datetime' => date('Y-m-d H:i:s'),
            'session_id' => $id,
            'where' => $where_params
        ];
        $logFileQuery = WRITEPATH . 'logs/historial_query_debug_' . date('Ymd_His') . '.log';
        file_put_contents($logFileQuery, json_encode($logQuery, JSON_PRETTY_PRINT));
        // --- Fin log de consulta ---

        // Mostrar todas las comisiones inmobiliarias del usuario, sin filtrar por fecha
        $obj_commissions = $ComisionesInmobiliarias
            ->where('beneficiario_id', $id)
            ->orderBy('id', 'DESC')
            ->findAll();

        // --- Log personalizado para depuración de usuario y comisiones ---
        $customLog = [
            'datetime' => date('Y-m-d H:i:s'),
            'session_id' => $id,
            'comisiones_ids' => array_map(function($c) {
                // Soporte para array u objeto
                if (is_array($c) && isset($c['id'])) return $c['id'];
                if (is_object($c) && isset($c->id)) return $c->id;
                return null;
            }, $obj_commissions),
        ];
        $logFile = WRITEPATH . 'logs/historial_debug_' . date('Ymd_His') . '.log';
        file_put_contents($logFile, json_encode($customLog, JSON_PRETTY_PRINT));
        // --- Fin log personalizado ---

        //get data customer
        $Customer = new CustomerModel();
        $obj_customer = $Customer->get_data_customer($id);

        // Calcular total de comisiones inmobiliarias (sin filtro de fecha)
        $obj_total = $ComisionesInmobiliarias
            ->selectSum('monto')
            ->where('beneficiario_id', $id)
            ->whereIn('estado', ['aprobada', 'pagada'])
            ->first()['monto'] ?? 0;

        $title = HISTORY;
        $data = array(
            'title' => $title,
            'obj_commissions' => $obj_commissions,
            'date_begin' => null,
            'date_end' => null,
            'obj_total' => $obj_total,
            'fortnightly_period' => $period,
            'obj_customer' => $obj_customer,
            'cart_count' => $cart_count
        );
        return view('backoffice_new/historial', $data);
    }

    public function facturas()
    {
        //get count product shopping cart
        $cart_count = Cart::count();
        //get data session
        $id = $_SESSION['client_id'];
        $Invoices = new InvoicesModel();
        //get total comissions
        $obj_invoices = $Invoices->get_invoices_by_id_membership_id($id);
        //get data customer
        $Customer = new CustomerModel();
        $obj_customer = $Customer->get_data_customer_perfil($id);
        //set title
        $title = lang('Global.compras');
        //send
        $data = array(
            'title' => $title,
            'obj_customer' => $obj_customer,
            'obj_invoices' => $obj_invoices,
            'cart_count' => $cart_count
        );
        return view('backoffice_new/invoice', $data);
    }

    public function facturas_detail($invoice_id = null)
    {
        //get count product shopping cart
        $cart_count = Cart::count();
        //get data session
        $id = $_SESSION['client_id'];
        //get data planes
        $Invoices = new InvoicesModel();
        //get total comissions
        $obj_invoices = $Invoices->invoices_by_id($id, $invoice_id);
        
        //get product detail
        $Invoice_detail_membership = new Invoice_detail_membershipModel();
        $obj_product_detail = $Invoice_detail_membership->get_invoices_by_id($invoice_id);
        //get data customer
        $Customer = new CustomerModel();
        $obj_customer = $Customer->get_data_customer_perfil($id);
        //set title
        $title = lang('Global.compras');
        $obj_membership = null;
        $membership_id = $obj_invoices->temporal_membership;
        if (isset($membership_id)) {
            //get membership+
            $Membership = new MembershipsModel();
            //set var membership
            $obj_membership = $Membership->get_membership_by_id($membership_id);
        }
        //render
        $data = array(
            'title' => $title,
            'obj_customer' => $obj_customer,
            'obj_invoices' => $obj_invoices,
            'obj_product_detail' => $obj_product_detail,
            'cart_count' => $cart_count,
            'obj_membership' => $obj_membership
        );
        return view('backoffice_new/invoice_details', $data);
    }

    public function delete_invoice(){
        //ACTIVE CUSTOMER NORMALY
        if ($this->request->isAJAX()) {
            $Invoices = new InvoicesModel();
            //get data post
            $res = service('request')->getPost();
            $id = $res['id'];
            //verify                     
            if($id != null){
                $result = $Invoices->eliminar($id);
                if(!is_null($result)){
                    $data['status'] = true;
                    $data['message'] = DELETED;
                }else{
                    $data['status'] = false;
                    $data['message'] = ERROR;
                }     
            }else{
                $data['status'] = false;
                $data['message'] = ERROR;
            }
            echo json_encode($data); 
            exit();
        }
    }


    public function export_pdf($invoice_id = null)
    {
        //get data session
        $id = $_SESSION['client_id'];
        //get data planes
        $Invoices = new InvoicesModel();
        //get total comissions
        $obj_invoices = $Invoices->invoices_by_id($id, $invoice_id);
        //get product detail
        $Invoice_detail_membership = new Invoice_detail_membershipModel();
        $obj_product_detail = $Invoice_detail_membership->get_invoices_by_id($invoice_id);
        $dompdf = new \Dompdf\Dompdf();
        $options = $dompdf->getOptions();
        $options->setDefaultFont('Courier');
        $dompdf->setOptions($options);

        $obj_membership = null;
        $membership_id = $obj_invoices->temporal_membership;
        if (isset($membership_id)) {
            //get membership+
            $Membership = new MembershipsModel();
            //set var membership
            $obj_membership = $Membership->get_membership_by_id($membership_id);
        }

        // get customer data
        $Customer = new CustomerModel();
        $obj_customer = $Customer->get_data_customer_perfil($id);

        //send data
        $data = [
            'obj_invoices' => $obj_invoices,
            'obj_product_detail' => $obj_product_detail,
            'obj_membership' => $obj_membership,
            'obj_customer' => $obj_customer
        ];
        $dompdf->loadHTML(
            view("backoffice_new/pdf_view", $data)
        );
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream();
    }
}