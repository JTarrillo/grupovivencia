<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\MembershipsModel;
use App\Models\CommissionsModel;
use App\Models\Payment_optionsModel;
use App\Models\StoreModel;
use App\Models\InvoicesModel;
use App\Models\OutgoingModel;
use App\Models\PeriodModel;
use App\Models\Invoice_detail_membershipModel;
use App\Libraries\Evox;
use Fluent\ShoppingCart\Facades\Cart;

class D_nueva_venta extends BaseController
{
    public function index()
    {
        $session_name = $_SESSION['admin_name'] . " " . $_SESSION['admin_lastname'];
        //get count product shopping cart
        $cart_count = Cart::count();
        //get all producto countable
        $Memberships = new MembershipsModel();
        $obj_membership = $Memberships->get_all_product_stock();
        //get data session
        //send
        $data = array(
            'obj_membership' => $obj_membership,
            'cart_count' => $cart_count,
            'session_name' => $session_name
        );
        return view('admin/nueva_venta/list', $data);
    }

    public function cart()
    {
        $session_name = $_SESSION['admin_name'] . " " . $_SESSION['admin_lastname'];
        //set var
        $obj_membership = null;
        $customer_id = null;
        $membership_id = null;
        $phone = null;
        //get data membership no contable
        $Membership = new MembershipsModel();
        //Check for post method
        if ($_POST) {
            $Customer = new CustomerModel();
            $res = service('request')->getPost();
            $customer_id = $res['customer_id'];
            //get data from customer

            if($customer_id){
                //get data customer by id
                $obj_customer = $Customer->get_customer_by_membership_id($customer_id);
                //customer_id
                $customer_id = $obj_customer->id;
                $membership_id = $obj_customer->membership_id;
                $phone = $obj_customer->phone;
                //set var membership
                $obj_membership = $Membership->get_data_countable_mayor($obj_customer->membership_id);
            }
        }
        //get data store
        $Store = new StoreModel();
        $obj_store = $Store->get_all();
        //get all customer active
        $Customer = new CustomerModel();
        $obj_customer = $Customer->get_data_button_search();
        //get count product shopping cart
        $cart_count = Cart::count();
        //get data session
        //get data shoppint cart
        $content = Cart::content();
        $sub_total = Cart::subtotal();
        $total = Cart::total();

        // Obtener lotes disponibles por cada project_id en el carrito
        $db = \Config\Database::connect();
        $lotes = [];
        foreach ($content as $row) {
            $project_id = isset($row->options['project_id']) ? $row->options['project_id'] : null;
            if (!empty($project_id)) {
                if (!isset($lotes[$project_id])) {
                    $query = $db->table('lots')
                        ->where('project_id', $project_id)
                        ->where('status', 'available')
                        ->get();
                    $lotes[$project_id] = $query->getResult();
                }
            }
        }

        //send
        $data = array(
            'obj_customer' => $obj_customer,
            'customer_id' => $customer_id,
            'obj_membership' => $obj_membership,
            'membership_id' => $membership_id,
            'obj_store' => $obj_store,
            'content' => $content,
            'phone' => $phone,
            'sub_total' => $sub_total,
            'total' => $total,
            'cart_count' => $cart_count,
            'session_name' => $session_name,
            'lotes' => $lotes
        );
        return view('admin/nueva_venta/cart', $data);
    }

    public function delete_cart()
    {
        if ($this->request->isAJAX()) {
            //get data post
            $res = service('request')->getPost();
            $id = $res['row_id'];

            if ($id) {
                //remove product
                Cart::remove($id);
                $data['status'] = true;
            } else {
                $data['status'] = false;
            }

            echo json_encode($data);
            exit();
        }
    }

    public function checkout()
    {
        $session_name = $_SESSION['admin_name'] . " " . $_SESSION['admin_lastname'];
        //call model
        $Store = new StoreModel();
        $Commissions = new CommissionsModel();
        $Customer = new CustomerModel();
        //cart
        $cart_count = Cart::count();
        $content = Cart::content();

        $obj_membership = null;
        $obj_store = null;

        //get data session
        $res = service('request')->getPost();
        $customer_id = $res['customer_id'];
        $store_id = 1; //default store
        $phone = $res['phone'];
        $membership_id = isset($res['membership_id']) ? $res['membership_id'] : 1;
        //get data customer
        $obj_customer = $Customer->get_customer_by_membership_id($customer_id);
        //get data total    
        $obj_commission_total = $Commissions->get_total_commission($customer_id);
        //get data store
        $obj_store = $Store->get_by_id($store_id);
        //get all payment options
        $Payment_options = new Payment_optionsModel();
        $obj_payment  = $Payment_options->get_all();
        //get membership+
        $total = 0;
        //get cart data
        $sub_total = Cart::subtotal();
        $sub_total = str_replace(",", "", "$sub_total");
        $igv = $sub_total * 0.18;
        $total = Cart::total();
        $point = Cart::point();
        //send
        $data = array(
            'store_id' => $store_id,
            'phone' => $phone,
            'membership_id' => $membership_id,
            'obj_customer' => $obj_customer,
            'total_disponible' => $obj_commission_total->total_disponible,
            'obj_store' => $obj_store,
            'obj_payment' => $obj_payment,
            'customer_id' => $customer_id,
            'content' => $content,
            'sub_total' => $sub_total,
            'igv' => $igv,
            'point' => $point,
            'phone' => $phone,
            'total' => $total,
            'cart_count' => $cart_count,
            'session_name' => $session_name,
            'obj_membership' => $obj_membership
        );
        return view('admin/nueva_venta/checkout', $data);
    }

    public function process_sale()
    {
        if ($this->request->isAJAX()) {
            //call library Evox
            $evox = new Evox();  
            //call models
            $Invoices = new InvoicesModel();
            $Outgoing = new OutgoingModel();
            $Invoice_detail_membershipModel = new Invoice_detail_membershipModel();
            $Memberships = new MembershipsModel();
            //get data post
            $res = service('request')->getPost();
            $membership_id = isset($res['membership_id']) && !is_null($res['membership_id']) ? $res['membership_id'] : 1;

            //verify if membership_id is null or empty
            if(!$membership_id){
                $membership_id = 1;
            }

            $customer_id = $res['customer_id'];
            $payment = $res['payment'];
            //get all payment options
            $Payment_options = new Payment_optionsModel();
            $obj_payment  = $Payment_options->get_all_name();
            $array = array_values($obj_payment);
            $string = "";
            //Build variable payment
            foreach ($array as $key => $value) {
                $string .= $value->name.": ".$payment[$key].", ";  
            }
            // Remover la última coma y espacio
            $string = rtrim($string, ', ');
            //cart 
            $content = Cart::content();
            $total = $res['sub_total'];
            //format db thousend 
            $total = str_replace(",", "", "$total");
            $igv = $total * 0.18;
            $subtotal = $total - $igv;
            $point = Cart::point();
            $point = floatval(str_replace(',', '', $point)); //formatear el número
            //get period
            $Period = new PeriodModel();
            $obj_period = $Period->get_last();

            //create invoice , active 2 (paid)
            $param = array(
                'customer_id' => $customer_id,
                'store_id' => $res['store_id'],
                'membership_id' => $membership_id,
                'period_id' => $obj_period->id,
                'phone' => $res['phone'],
                'details' => "",
                'amount' => $total,
                'igv' => $igv,
                'sub_total' => $subtotal,
                'points' => $point,
                'payment_options' => $string,
                'payment' => '3',
                'delivery' => '1',
                'date' => date("Y-m-d H:i:s"),
                'created_at' => date("Y-m-d H:i:s"),
                'active' => '2'
            );
            $invoice_id = $Invoices->insertar($param);
            // Automatización de comisiones multinivel (N1 y N2)
            // Llama a Evox->pay_multinivel_n1_n2 con el customer_id, monto de compra y invoice_id
            $evox->pay_multinivel_n1_n2($customer_id, $total, $invoice_id);
            //view products
            foreach ($content as $row) {
                $param = array(
                    'invoice_id' => $invoice_id,
                    'membership_id' => $row->id,
                    'qty' => $row->qty,
                    'price' => $row->price,
                    'sub_total' => $row->subtotal,
                    'detail' => "",
                    'created_at' => date("Y-m-d h:i:s")
                );
                $invoice_detail_id = $Invoice_detail_membershipModel->insertar($param); //insert detail invoice

                //get unit_cost by product
                $obj_product =  $Memberships->get_all_by_id($row->id);

                if ($obj_product) {
                    $unit_cost = $obj_product->unit_cost;
                    $total_cost = $row->qty * $unit_cost;
                } else {
                    $unit_cost = 0;
                    $total_cost = 0;
                }
                //set param for outgoing
                $param = array(
                    'membership_id' => $row->id,
                    'invoice_id' => $invoice_id,
                    'store_id' => $res['store_id'],
                    'qty' => $row->qty,
                    'unit_cost' => $unit_cost,
                    'total_cost' => $total_cost,
                    'date' => date("Y-m-d H:i:s"),
                    'active' => '1',
                    'created_at' => date("Y-m-d H:i:s"),
                );
                $Outgoing->insertar($param);
            }

            
          

            //COMPENSATION PLAN
            //get data binary by customer
            $db = \Config\Database::connect();
            $obj_tree = $db->query("SELECT unilevels.sponsor_id,unilevels.node, customers.active, customers.range_id FROM unilevels  JOIN customers ON unilevels.sponsor_id = customers.id WHERE customer_id = $customer_id")->getRow();

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
          
            //cart destroy
            Cart::destroy();
            //send message
            //   $this->message($_SESSION['admin_name'], $_SESSION['admin_email'], $price, $qty, $membership_id, $details, $res['store_id']);
            //update session
            $data['status'] = true;
            $data['message'] = "Compra con éxito";
            echo json_encode($data);
            exit();
        }
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