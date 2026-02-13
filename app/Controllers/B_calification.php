<?php

namespace App\Controllers;
use App\Models\CustomerModel;
use App\Models\CommissionsModel;
use App\Models\CalificationModel;
use App\Controllers\B_home;
use Fluent\ShoppingCart\Facades\Cart;

class B_calification extends BaseController
{   
    public function index()
    {
        $B_home = new B_home;
        //get count product shopping cart
        $cart_count = Cart::count();
        //obtain all the qualifiers of the current period
        $date = begin_end_periodo();
        //get data session
        $id = $_SESSION['id'];
        //get data customer
        $Customer = new CustomerModel();
        $obj_customer = $Customer->get_data_customer_perfil($id);
        //get total calification
        $num_period_calification = $B_home->get_calificacion_travel($id);
        //obtain all the qualifiers of the current period
        $Calification = new CalificationModel();
        $obj_calification = "";
        if ($id) {
            $obj_calification = $Calification->get_calification_by_period_id($id, $date['begin'], $date['end']);
        }
        //get calification global
        //set title page
        $title = "Detalle de Calificación";
        //get data Customer
        $data = array(
            'title' => $title,
            'obj_calification' => $obj_calification,
            'obj_customer' => $obj_customer,
            'num_period_calification' => $num_period_calification,
            'cart_count' => $cart_count
        );
        return view('backoffice_new/calification', $data);
    }
    

    public function media()
    {
        //get count product shopping cart
        $cart_count = Cart::count();
        //get data session
        $id = $_SESSION['id'];
        //get data customer
        $Customer = new CustomerModel();
        $obj_customer = $Customer->get_data_customer_perfil($id);
        //get total commissions
        $Commissions = new CommissionsModel();
        $obj_commission_total = $Commissions->get_total_commission($id);
        //set var
        $obj_earn_total = $obj_commission_total->total_comissions;
        $obj_earn_disponible = $obj_commission_total->total_disponible;
        //set title page
        $title = lang('Global.documentos');
        //get data Customer
        $data = array(
            'title' => $title,
            'obj_earn_total' => $obj_earn_total,
            'obj_earn_disponible' => $obj_earn_disponible,
            'obj_customer' => $obj_customer,
            'id' => $id,
            'cart_count' => $cart_count,
        );
        return view('backoffice_new/files_media', $data);
    }

    public function presentacion()
    {
        //get count product shopping cart
        $cart_count = Cart::count();
        //get data session
        $id = $_SESSION['id'];
        //get data customer
        $Customer = new CustomerModel();
        $obj_customer = $Customer->get_data_customer_perfil($id);
        //get total commissions
        $Commissions = new CommissionsModel();
        $obj_commission_total = $Commissions->get_total_commission($id);
        //set var
        $obj_earn_total = $obj_commission_total->total_comissions;
        $obj_earn_disponible = $obj_commission_total->total_disponible;
        //set title page
        $title = lang('Global.documentos');
        //get data Customer
        $data = array(
            'title' => $title,
            'obj_earn_total' => $obj_earn_total,
            'obj_earn_disponible' => $obj_earn_disponible,
            'obj_customer' => $obj_customer,
            'id' => $id,
            'cart_count' => $cart_count,
        );
        return view('backoffice_new/files_presentacion', $data);
    }
}
