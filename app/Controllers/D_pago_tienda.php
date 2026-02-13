<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\InvoicesModel;
use App\Models\Invoice_detail_membershipModel;
use App\Models\CommissionsModel;
use App\Models\OutgoingModel;
use Dompdf\Dompdf;
use App\Models\MembershipsModel;
use App\Models\Payment_optionsModel;
use App\Libraries\Evox;

class D_pago_tienda extends BaseController
{
    public function index()
    {
        //nuevas compras
        //get data session
        $session_name = $_SESSION['first_name'] . " " . $_SESSION['last_name'];
        //get data invoices by customer
        $Invoices = new InvoicesModel();
        $obj_invoices = $Invoices->get_data_pay_tienda();
        //send
        $data = array(
            'obj_invoices' => $obj_invoices,
            'session_name' => $session_name
        );
        return view('admin/pago_tienda/list', $data);
    }

    public function load($id = false)
    {
        //get data session
        $session_name = $_SESSION['first_name'] . " " . $_SESSION['last_name'];
        //isset id
        if ($id != "") {
            //get data invoice
            $Invoices = new InvoicesModel();
            $obj_invoices = $Invoices->get_data_pay_tienda_id($id);

            

            $Customer = new CustomerModel();
            $obj_customer = $Customer->get_search_by_id($obj_invoices->customer_id);

            

            //get data invoice_detail
            $invoice_detail_membership = new Invoice_detail_membershipModel();
            $obj_invoice_detail = $invoice_detail_membership->get_invoices_by_id($id);

            

            $Payment_options = new Payment_optionsModel();
            $obj_payment  = $Payment_options->get_all();

            

            $obj_membership = null;
            $membership_id = null;
            if (isset($obj_invoices->temporal_membership)) {
                $membership_id = $obj_invoices->temporal_membership;
            } elseif (isset($obj_invoices->membership_id)) {
                $membership_id = $obj_invoices->membership_id;
            }
            if (isset($membership_id)) {
                //get membership+
                $Membership = new MembershipsModel();
                //set var membership
                $obj_membership = $Membership->get_membership_by_id($membership_id);
            }
        }

        //send data
        $data = array(
            'obj_invoices' => $obj_invoices,
            'obj_invoice_detail' => $obj_invoice_detail,
            'session_name' => $session_name,
            'membership_id' => $membership_id,
            'obj_membership' => $obj_membership,
            'obj_payment' => $obj_payment,
            'obj_customer' => $obj_customer
        );
        return view('admin/pago_tienda/load', $data);
    }

    public function export_pdf($invoice_id = null)
    {
        //get data session
        $id = $_SESSION['id'];
        //get data planes
        $Invoices = new InvoicesModel();
        //get total comissions
        $obj_invoices = $Invoices->invoices_id($invoice_id);
        //get product detail
        $Invoice_detail_membership = new Invoice_detail_membershipModel();
        $obj_product_detail = $Invoice_detail_membership->get_invoices_by_id($invoice_id);
        $dompdf = new \Dompdf\Dompdf();
        $options = $dompdf->getOptions();
        $options->setDefaultFont('Courier');
        $dompdf->setOptions($options);

        $obj_membership = null;
        $membership_id = null;
        if (isset($obj_invoices->temporal_membership)) {
            $membership_id = $obj_invoices->temporal_membership;
        } elseif (isset($obj_invoices->membership_id)) {
            $membership_id = $obj_invoices->membership_id;
        }

        if (isset($membership_id)) {
            //get membership+
            $Membership = new MembershipsModel();
            //set var membership
            $obj_membership = $Membership->get_membership_by_id($membership_id);
        }

        //send data
        $data = [
            'obj_invoices' => $obj_invoices,
            'obj_product_detail' => $obj_product_detail,
            'obj_membership' => $obj_membership
        ];
        $dompdf->loadHTML(
            view("admin/pago_tienda/pdf_view", $data)
        );

        
        // Configurar el tamaño del papel (ancho y alto en puntos; 1 punto = 1/72 pulgadas)
        $customPaper = array(0, 0, 285, 800); // Ajusta el alto según la longitud del ticket

        // Establecer el tamaño del papel personalizado
        $dompdf->setPaper($customPaper);

        //$dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream();
    }

    public function verificadas()
    {
        //get data session
        $session_name = $_SESSION['first_name'] . " " . $_SESSION['last_name'];
        //get data invoices by customer
        $Invoices = new InvoicesModel();
        $obj_invoices = $Invoices->get_data_pay_tienda_2();

        //send
        $data = array(
            'obj_invoices' => $obj_invoices,
            'session_name' => $session_name
        );
        return view('admin/pago_tienda/list_verify', $data);
    }

    public function load_verify($id = false)
    {
        //get data session
        $session_name = $_SESSION['first_name'] . " " . $_SESSION['last_name'];
        //isset id
        $obj_sponsor = null;
        if ($id != "") {
            //get data invoice
            $Invoices = new InvoicesModel();
            $obj_invoices = $Invoices->get_data_pay_tienda_id($id);
            //get data invoice_detail
            $invoice_detail_membership = new Invoice_detail_membershipModel();
            $obj_invoice_detail = $invoice_detail_membership->get_invoices_by_id($id);

            $Payment_options = new Payment_optionsModel();
            $obj_payment  = $Payment_options->get_all();

            $obj_membership = null;
            $membership_id = null;
            if (isset($obj_invoices->temporal_membership)) {
                $membership_id = $obj_invoices->temporal_membership;
            } elseif (isset($obj_invoices->membership_id)) {
                $membership_id = $obj_invoices->membership_id;
            }

            if (isset($membership_id)) {
                //get membership+
                $Membership = new MembershipsModel();
                //set var membership
                $obj_membership = $Membership->get_membership_by_id($membership_id);
            }
        }
        //send data
        $data = array(
            'obj_invoices' => $obj_invoices,
            'obj_invoice_detail' => $obj_invoice_detail,
            'session_name' => $session_name,
            'obj_membership' => $obj_membership,
            'obj_payment' => $obj_payment
        );
        return view('admin/pago_tienda/load_verify', $data);
    }

    public function procesar()
    {
        
        if ($this->request->isAJAX()) {

            $period = period();
            $Invoices = new InvoicesModel();
            $Invoice_detail_membershipModel = new Invoice_detail_membershipModel();
            $Outgoing = new OutgoingModel();
            //get data post
            $res = service('request')->getPost();
            $invoice_id = $res['invoice_id'];
            $customer_id = $res['customer_id'];
            $point = $res['point'];
            $membership_id = $res['membership_id'];
            $payment = $res['payment'];
            //get all payment options
            $Payment_options = new Payment_optionsModel();
            $obj_payment  = $Payment_options->get_all_name();
            $array = array_values($obj_payment);

            $string = "";
            //Build string variable payment
            foreach ($array as $key => $value) {
                if($payment[$key]){
                    $string .= $value->name.": ".$payment[$key].", ";  
                }
            }

            // Remover la última coma y espacio
            $string = rtrim($string, ', ');
            //get data invoice product detail
            $params = array(
                "select" => "invoice_detail_membership.id, invoice_detail_membership.qty, invoice_detail_membership.price,invoice_detail_membership.membership_id, invoice_detail_membership.detail,invoice_detail_membership.sub_total, memberships.name, memberships.unit_cost, memberships.slug",
                "join" => array('memberships, invoice_detail_membership.membership_id = memberships.id'
                ),
                "where" => "invoice_id = $invoice_id"
            );
            $obj_products = $Invoice_detail_membershipModel->search($params);

            foreach ($obj_products as $value) {
                //set total_cost
                $total_cost = $value->unit_cost * $value->qty;
                $param = array(
                    'membership_id' => $value->membership_id,
                    'invoice_id' => $invoice_id,
                    'store_id' => $res['store_id'],
                    'qty' => $value->qty,
                    'unit_cost' => $value->unit_cost,
                    'total_cost' => $total_cost,
                    'date' => date("Y-m-d H:i:s"),
                    'active' => '1',
                    'created_at' => date("Y-m-d H:i:s"),
                );
                $Outgoing->insertar($param);
            }

            //call library Evox
            $evox = new Evox(); 

            //COMPENSATION PLAN
            $db = \Config\Database::connect();
            $obj_tree = $db->query("SELECT unilevels.sponsor_id, unilevels.node, customers.active, customers.range_id FROM unilevels  JOIN customers ON unilevels.sponsor_id = customers.id WHERE customer_id = $customer_id")->getRow();

            //obtain all points per montly and activate user
            $evox->active_customer($customer_id, $point, $membership_id, $res['phone']);

            //Verify ranges achieved
            $evox->check_ranges($obj_tree->node);

            //Verify that it is not a regular purchase    
            if($membership_id != 1){
                //sponsorship bonus and and points for ranks
                $evox->pay_directo($customer_id, $invoice_id, $point, $obj_tree->sponsor_id, $obj_tree->active, $membership_id);
            }else{
                //add group points
                $evox->add_points_unilevel($point, $customer_id, $invoice_id, $obj_tree->node);
                //propio consumo bonus
                $evox->pay_propio_consumo($customer_id, $invoice_id);
                if ($obj_tree) {
                    //unilevel bonus
                    $evox->pay_unilevel($customer_id, $obj_tree->node, $invoice_id, $point);
                }
            }

            //Check if I have stagnant commissions
            $evox->unilevel_dynamic_compression($customer_id, $point); 
            
            //update invoice status
            $param = array(
                'payment_options' => $string,
                'delivery' => '2',
                'active' => '2',
            );
            $Invoices->update($invoice_id, $param);
            $data['status'] = true;
            $data['message'] = "Compra con éxito";
            echo json_encode($data);
            exit();
        }
    }

    public function cancel()
    {
        //ACTIVE CUSTOMER NORMALY
        if ($this->request->isAJAX()) {
            $Invoices = new InvoicesModel();
            $res = service('request')->getPost();
            $invoice_id = $res['invoice_id'];
            $param = array(
                'active' => '3'
            );
            $result = $Invoices->update($invoice_id, $param);
            //validate
            if (!is_null($result)) {
                $data['status'] = true;
            } else {
                $data['status'] = false;
            }
            echo json_encode($data);
            exit();
        }
    }

    public function message($customer_id)
    {
        //get data customer
        $db = \Config\Database::connect();
        $obj_customer = $db->query("SELECT name, email FROM `customers` where id = $customer_id")->getRow();
        $email_customer = $obj_customer->email;
        $name = $obj_customer->name;
        $mensaje = wordwrap("<html>
        <table width='750' border='0' align='center' cellpadding='0' cellspacing='0' bgcolor='#f8f6f7' style='padding:15px 75px 15px'>
        <tbody><tr>
          <td align='center'>
            <table width='100%' border='0' align='center' cellpadding='0' cellspacing='0' style='background-color:#fff'>
              <tbody>
              <tr>
                <td>
                  <table width='600' border='0' align='center' cellpadding='0' cellspacing='0'>
                    <tbody><tr>
                      <td width='100%' style='padding:43px 0 38px;text-align:center'>
                        <table align='center' bgcolor='#ffffff' border='0' cellpadding='0' cellspacing='0'>
                          <tbody>
                                <tr style='text-align:center'>
                                    <td height='26'>
                                        <img border='0' style='display:inline-block' src='https://azbel.com.es/assets/front/img/logo/logon.png' width='90' class='CToWUd'>
                                    </td>
                              </tr>
                        </tbody>
                      </table>
                    </td>
                    </tr>
                    <tr>
                      <td style='font:20px Arial;padding:0 0 11px;color:#485360;text-align:center'>
                            Felicidades, $name                                 
                      </td>
                    </tr>
                    <tr>
                      <td style='color:#485360;font:400 28px/28px Arial;padding:0 7%;text-align:center'>
                            Tu compra ha sido entregada exitosamente.
                      </td>
                    </tr>
                    <tr>
                      <td style='color:#2397d4;font:600 16px Arial;letter-spacing:-1px;padding:30px 0 22px;text-align:center'>
                        <p>Gracias por ser parte de nuestra familia.</p>
                      </td>
                    </tr>
      </tbody></table>
                    .</html>", 70, "\n", true);

        //set data to send email
        $email = \Config\Services::email();
        $email->setFrom("system@azbel.com.es", "Compra Entregada");
        $email->setTo($email_customer);
        $email->setSubject("Compra Entregada - [AZBEL]");
        $email->setMessage($mensaje);
        $email->send();
        return true;
    }

    public function new_method_payment()
    {
        if ($this->request->isAJAX()) {
            $Payment_options = new Payment_optionsModel();
            $res = service('request')->getPost();
            $payment_name = $res['payment_name'];
            //insert on table payment_options
            $param = array(
                'name' => $payment_name,
                'date' => date("Y-m-d"),
                'active' => '1'
            );
            $Payment_options_id = $Payment_options->insertar($param);
            //send respose
            if ($Payment_options_id <> 0) {
                $data['id'] = $Payment_options_id;
                $data['value'] = "$payment_name";
                $data['status'] = true;
                $data['message'] = "Creado &nbsp;<i class='fa fa-check-circle'></i>";
            } else {
                $data['status'] = false;
            }
            echo json_encode($data);
            exit();
        }
    }
}
