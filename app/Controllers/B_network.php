<?php

namespace App\Controllers;
use App\Models\CustomerModel;
use App\Models\UnilevelsModel;
use App\Models\CommissionsModel;
use App\Models\InvoicesModel;
use App\Libraries\Evox;
use App\Controllers\B_carrera;

use Fluent\ShoppingCart\Facades\Cart;


class B_network extends BaseController
{   
    public function index()
    {
        //get count product shopping cart
        $cart_count = Cart::count();
        //get data session
        $id = $_SESSION['client_id'];
        $Unilevel =new UnilevelsModel();
        $Customer =new CustomerModel();
        //set var
        $obj_total_direct = 0;
        //the dates are being put, so as not to give errors
        $period = period();
        $Unilevel = new UnilevelsModel();

        //get partner level 2
        $obj_customer_n2 = $Unilevel->get_partners_by_level($id, $period['first_month_day'], $period['last_month_day']); 

        //total referred
        $obj_total_direct = count($obj_customer_n2);

        //get data customer
        $obj_customer = $Customer->get_data_customer_perfil($id);
        

        $params = array(
            "select" => "*",
            "join" => array('countries, `customers`.`country_id` = `countries`.`id`',
                            'unilevels, `unilevels`.`customer_id` = `customers`.`id`',
                            'ranges, `customers`.`range_id` = `ranges`.`id`'),
            "where" => "`customers`.`active` = '1' AND `unilevels`.`sponsor_id` = $id and countries.id_idioma = 7",
            "order" => "`unilevels`.`id` ASC"
        );
        $total_active = $Customer->total_records($params);
        //get data total
        $Commissions = new CommissionsModel();
        $obj_commission_total = $Commissions->get_total_commission($id);
        //set var total & available
        $obj_earn_total = $obj_commission_total->total_comissions;
        $obj_earn_disponible = $obj_commission_total->total_disponible;
        //set title
        $title = lang('Global.equipo');
        //send data
        $data = array(
            'title' => $title,
            'obj_earn_total' => $obj_earn_total,
            'obj_earn_disponible' => $obj_earn_disponible,
            'obj_customer' => $obj_customer,
            'total_active' => $total_active,
            'obj_total_direct' => $obj_total_direct,
            'obj_customer_n2' => $obj_customer_n2,
            'cart_count' => $cart_count
        );
        return view('backoffice_new/referred', $data);
    }

    public function unilevel()
    {
        //get count product shopping cart
        $cart_count = Cart::count();
        //call library Evox
        $evox = new Evox();
        //get data session
        $id = $_SESSION['client_id'];
        //GET DATA URL
        $url = explode("/",uri_string());
        $Customer = new CustomerModel();
        if(isset($url[2])){
            $param = $url[2];
            // Si es numérico, se asume que es un id encriptado, si no, es un dni
            if (is_numeric($param)) {
                // Buscar por dni
                $customer_obj = $Customer->get_search_by_dni($param);
                $customer_id = $customer_obj ? $customer_obj->id : $_SESSION['client_id'];
            } else {
                // Buscar por id encriptado (legacy)
                $customer_id = decrypt($param);
            }
        }else{
            $customer_id = $_SESSION['client_id'];
        }
        //set var
        $direct_3 = null;
        $direct_4 = null;
        $obj_customer_n2 = null;
        $obj_customer_n3 = null;
        $obj_customer_n4 = null;

        //get period 
        $dataPeriod = $evox->get_period();
        $beginDate = $dataPeriod->begin;
        $endDate = $dataPeriod->end;

        //unilevel
        $Unilevel = new UnilevelsModel();
        $Customer = new CustomerModel();
        $obj_customer = $Unilevel->get_data_by_customer($customer_id, $beginDate, $endDate);
        // Enriquecer con todas las propiedades necesarias para la vista
        $full_customer = $Customer->get_data_by_id($customer_id);
        $obj_customer->tipo_agente = $full_customer->tipo_agente ?? null;
        $obj_customer->inscripcion_vigente = $Customer->isInscripcionVigente($customer_id);
        $obj_customer->active = $full_customer->active ?? null;
        $obj_customer->point_personal = $full_customer->point_personal ?? 0;
        $obj_customer->point_grupal = $full_customer->point_grupal ?? 0;
        $obj_customer->pais_img = $full_customer->pais_img ?? null;
        // Refuerzo: si falta range_img, lo consultamos directo
        if (!isset($obj_customer->range_img) || empty($obj_customer->range_img)) {
            $range = $Customer->db->query('SELECT img FROM ranges WHERE id = ?', [$obj_customer->range_id])->getRow();
            $obj_customer->range_img = $range ? $range->img : null;
        }

        //set var point personal
        $point_personal = $obj_customer->point_personal;
        //get partner level 2
        $obj_customer_n2 = $Unilevel->get_partners_by_level($customer_id, $beginDate, $endDate);
        // Enriquecer cada referido directo
        if ($obj_customer_n2) {
            foreach ($obj_customer_n2 as $key => $value) {
                $full_ref = $Customer->get_data_by_id($value->customer_id2);
                $value->tipo_agente = $full_ref->tipo_agente ?? null;
                $value->inscripcion_vigente = $Customer->isInscripcionVigente($value->customer_id2);
            }
        }

        //total referred
        $obj_total_direct = count($obj_customer_n2);
        //get partner level 3
        if(count($obj_customer_n2) > 0){
            $customer_id_n2 = "";
            foreach ($obj_customer_n2 as $key => $value) {
                $customer_id_n2 .= $value->customer_id2.",";
            }
            //DELETE LAST CARACTER ON STRING
            $customer_id_n2 = substr ($customer_id_n2, 0, strlen($customer_id_n2) - 1);
            if(!is_null($customer_id_n2) && $customer_id_n2 != ""){
                //get data level 3
                $obj_customer_n3 = $Unilevel->get_partners_in_level($customer_id_n2, $beginDate, $endDate);
                $direct_3 = count($obj_customer_n3);
                //GET CUSTOMER BY PARENTS_ID 4 LEVEL
                if(count($obj_customer_n3) > 0){
                    $customer_id_n3 = "";
                    foreach ($obj_customer_n3 as $key => $value) {
                        $customer_id_n3 .= $value->customer_id2.",";
                    }
                    //DELETE LAST CARACTER ON STRING
                    $customer_id_n3 = substr ($customer_id_n3, 0, strlen($customer_id_n3) - 1);
                    //get data level 4
                    $obj_customer_n4 = $Unilevel->get_partners_in_level($customer_id_n3, $beginDate, $endDate);
                    $direct_4 = count($obj_customer_n4);
                }
            }
        }
        //GET TOTAL REFERRED
        $obj_total_referidos = $Unilevel->get_total_partners($customer_id); 
        //get data total
        $Commissions = new CommissionsModel();
        $obj_commission_total = $Commissions->get_total_commission($id);
        //set var total & available
        $obj_earn_total = $obj_commission_total->total_comissions;
        $obj_earn_disponible = $obj_commission_total->total_disponible;
        //set title
        $title = UNILEVEL;
        //sen data
        $data = array(
            'title' => $title,
            'obj_earn_total' => $obj_earn_total,
            'obj_earn_disponible' => $obj_earn_disponible,
            'obj_total_referidos' => $obj_total_referidos,
            'obj_total_direct' => $obj_total_direct,
            'point_personal' => $point_personal,
            'direct_3' => $direct_3,
            'direct_4' => $direct_4,
            'obj_customer_n2' => $obj_customer_n2,
            'obj_customer_n3' => $obj_customer_n3,
            'obj_customer_n4' => $obj_customer_n4,
            'obj_customer' => $obj_customer,
            'cart_count' => $cart_count
        );
        return view('backoffice_new/unilevel', $data);
    }
public function get_partners_by_level($sponsor_id)
{
    $db = \Config\Database::connect();
    $builder = $db->table('unilevels');
    $builder->select('unilevels.customer_id, customers.*');
    $builder->join('customers', 'customers.id = unilevels.customer_id');
    $builder->where('unilevels.sponsor_id', $sponsor_id);
    $builder->where('unilevels.active', 1);
    return $builder->get()->getResult();
}
    public function up(){
        //ACTIVE CUSTOMER NORMALY
        if ($this->request->isAJAX()) {
            //var
            $sponsor_id = null;
            //get data mehotd post
            $res = service('request')->getPost();
            $id = $res['id'];
            //query
            $Unilevels = new UnilevelsModel();
            $obj_unilevel = $Unilevels->get_sponsor_id_by_customer_id($id);
            if($obj_unilevel){
                $sponsor_id = $obj_unilevel->sponsor_id;
            }
            //verify
            if(!is_null($sponsor_id) && $sponsor_id != 0){
                $sponsor_id = encrypt($sponsor_id);
                $data['status'] = true;
                $data['url'] = site_url()."backoffice_new/unilevel/$sponsor_id";
            }else{
                $data['status'] = false;
            }
            echo json_encode($data); 
            exit();
        }
    }
}