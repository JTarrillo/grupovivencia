<?php

namespace App\Controllers;
use App\Models\CustomerModel;
use App\Models\CommissionsModel;
use App\Controllers\B_perfil;
use Fluent\ShoppingCart\Facades\Cart;

class B_files extends BaseController
{   
    public function index()
    {
        //get count product shopping cart
        $cart_count = Cart::count();
        //get data session
        $id = $_SESSION['id'];
        //get data customer
        $Customer = new CustomerModel();
        $B_perfil =new B_perfil();
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
        return view('backoffice_new/files', $data);
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
