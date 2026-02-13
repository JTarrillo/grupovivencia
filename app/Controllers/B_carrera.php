<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\RangesModel;
use App\Models\UnilevelsModel;
use App\Models\InvoicesModel;
use App\Libraries\Evox;
use Fluent\ShoppingCart\Facades\Cart;

class B_carrera extends BaseController
{   
    public function index()
    { 
        //get count product shopping cart
        $cart_count = Cart::count();
        //get data session
        $id = $_SESSION['id'];

        //call library Evox
        $evox = new Evox();
        //get data planes
        $Ranges = new RangesModel();
        
        //get total comissions

        $periodData = $evox->get_period();
        $begin = $periodData->begin;
        $end = $periodData->end;

        $point = 0;
        $info = $evox->get_point_current_period($id);
        //get EVOX library information
        $personal_point =  $info['personal_point'];
        $point = $info['point'];
        $obj_customer = $info['obj_customer'];
        //obtain range information
        $obj_range = $Ranges->get_all();
        //set data ranges
        $Ranges = new RangesModel();
        $obj_ranges_now = $Ranges->get_range_next($id);

        //get direct active , >= 500 pts in repurche
        $Invoices = new InvoicesModel();
        //get total directo active
        $dataCustomer = $Invoices->get_monthly_shopping_points($id, $begin, $end);
        //set var 
        $total_active = $dataCustomer->total_referred;
        //set title
        $title = lang('Global.carrera');
        //send data        
        $data = array(
            'obj_range' => $obj_range,
            'obj_ranges_now' => $obj_ranges_now,
            'total_active' => $total_active,
            'title' => $title,
            'personal_point' => $personal_point,
            'point' => $point,
            'obj_customer' => $obj_customer,
            'cart_count' => $cart_count,
        );
        return view('backoffice_new/carrera', $data);
    }
     
    
    public function get_point_current_period($customer_id)
    {
        $Customer = new CustomerModel();
        //get dat 1 -31
        $day = date("j");
        $year = date("Y");
        $month = date("m");


        if($day >= '1' && $day <= '15'){
            $first_month_day = first_month_day($month,$year);
            $last_month_day = "$year-$month-15";    
        }else{
            $first_month_day = "$year-$month-16" ;
            $last_month_day = last_month_day($month,$year);    
        }


        //get data points by customer
        //points are verified every 30 days
        $obj_customer = $Customer->get_data_customer_range($customer_id, $first_month_day, $last_month_day);
        //get total point
        $point =  $obj_customer->total_point;
        //send data
        return $info = array(
                        'obj_customer' => $obj_customer,
                        'point' => $point,
                    );
    }
}
