<?php

namespace App\Libraries;

use App\Models\CommissionsModel;
use App\Models\CustomerModel;
use App\Models\InvoicesModel;
use App\Models\PointsModel;
use App\Models\Invoice_detail_membershipModel;
use App\Models\PeriodModel;
use App\Models\UnilevelsModel;
use App\Models\Range_customerModel;
use PhpOffice\PhpSpreadsheet\Reader\Xls\Escher;

class Evox
{
    protected $mivariable;

    public function __construct() {}

    //obtain available amount
    public function get_commission_by_period()
    {
        //get data session
        $id = $_SESSION['id'];

        $Commissions = new CommissionsModel();
        //get current period  data
        $dataPeriod = $this->get_period();
        $beginDate = $dataPeriod->begin;
        $endDate = $dataPeriod->end;

        $result = $Commissions->commission_by_period($id, $beginDate, $endDate);
        return $result;
    }
    /**
     * Asigna comisiones multinivel (nivel 1 y 2) según reglas de negocio
     * @param int $customer_id ID del afiliado que realiza la compra
     * @param float $monto_compra Monto base de la compra
     * @param int $invoice_id ID de la factura generada
     */
    public function pay_multinivel_n1_n2($customer_id, $monto_compra, $invoice_id)
    {
        $Unilevels = new \App\Models\UnilevelsModel();
        $Commissions = new \App\Models\CommissionsModel();
        $fecha = date("Y-m-d H:i:s");

        // Nivel 1
        $sponsor_n1 = $Unilevels->get_sponsor_level_1($customer_id);
        if ($sponsor_n1) {
            $comision_n1 = $monto_compra * 0.04;
            $Commissions->insertar([
                'customer_id' => $sponsor_n1,
                'invoice_id' => $invoice_id,
                'bonus_id' => 100, // ID de bono personalizado, ajústalo según tu catálogo
                'level' => 1,
                'arrive_id' => $customer_id,
                'date' => $fecha,
                'amount' => $comision_n1,
                'active' => '1',
                'created_at' => $fecha
            ]);
        }

        // Nivel 2
        $sponsor_n2 = $Unilevels->get_sponsor_level_2($customer_id);
        if ($sponsor_n2) {
            $comision_n2 = $monto_compra * 0.01;
            $Commissions->insertar([
                'customer_id' => $sponsor_n2,
                'invoice_id' => $invoice_id,
                'bonus_id' => 101, // ID de bono personalizado, ajústalo según tu catálogo
                'level' => 2,
                'arrive_id' => $customer_id,
                'date' => $fecha,
                'amount' => $comision_n2,
                'active' => '1',
                'created_at' => $fecha
            ]);
        }
    }
    public function get_commission_by_period_id($id = null)
    {
        //get data session
        $Commissions = new CommissionsModel();
        //get current period  data
        $dataPeriod = $this->get_period();
        $beginDate = $dataPeriod->begin;
        $endDate = $dataPeriod->end;

        $result = $Commissions->commission_by_period($id, $beginDate, $endDate);
        return $result;
    }

    public function available_balance($customer_id)
    {
        //load model commission
        $Commissions = new CommissionsModel();

        //get current period  data
        $dataPeriod = $this->get_period();
        $beginDate = $dataPeriod->begin;
        $endDAte = $dataPeriod->end;

        //get past period data
        $dataPastPeriod = $this->get_past_period($dataPeriod->id);
        $beginPast = $dataPastPeriod->begin;
        $endPast = $dataPastPeriod->end;

        //get data
        $total = $Commissions->commission_by_year($customer_id,  $beginDate, $endDAte, $beginPast, $endPast);
        return $total;
    }

    //get the current period
    public function get_period()
    {
        //load model commission
        $Period = new PeriodModel();

        $param = array(
            'select' => '*',
            'order' => 'id DESC'
        );

        //get data
        $data = $Period->get_search_row($param);

        return $data;
    }

    //get the last period
    public function get_past_period($id = null)
    {
        //load model commission
        $Period = new PeriodModel();

        $param = array(
            'select' => '*',
            'where' => "id < $id",
            'order' => 'id DESC',
            'limit' => '1'
        );

        //get data
        $data = $Period->get_search_row($param);

        return $data;
    }

    //get points the current period
    public function get_point_current_period($customer_id)
    {
        $Customer = new CustomerModel();
        //get dat 1 -31
        
        //get current period  data
        $dataPeriod = $this->get_period();
        $beginDate = $dataPeriod->begin;
        $endDate = $dataPeriod->end;

        //get data points by customer
        //points are verified every 30 days
        $obj_customer = $Customer->get_data_customer_range($customer_id, $beginDate, $endDate);

        //get total point
        $point =  $obj_customer->total_point;
        $personal_point =  $obj_customer->personal_point;
        //send data
        return $info = array(
                        'obj_customer' => $obj_customer,
                        'personal_point' => $personal_point,
                        'point' => $point,
                    );
    }

    //Begin compensation plan - 4 BONUS
    public function pay_directo($customer_id, $invoice_id, $point, $sponsor_id, $active, $membership_id)
    {
        //load model
        $Commissions = new CommissionsModel();
        $Points = new PointsModel();

        //set amount by level
        switch ($membership_id) {
            case 2:
                //Pack 400
                $level1 = 100;
                $level2 = 50;
                break;
            case 3:
                //Pack 800
                $level1 = 250;
                $level2 = 100;
                break;
            case 4:
                //Pack 1500
                $level1 = 600;
                $level2 = 100;
                break;
            default:
                //Pack 400
                $level1 = 100;
                $level2 = 50;
                break;
        }

            //INSERT COMMISSION TABLE
            $param = array(
                'customer_id' => $sponsor_id,
                'invoice_id' => $invoice_id,
                'bonus_id' => 1,
                'level' => 1,
                'arrive_id' => $customer_id,
                'date' => date("Y-m-d H:i:s"),
                'amount' => $level1,
                'active' => '1',
                'created_at' => date("Y-m-d H:i:s")
            );
            $Commissions->insertar($param);

            //insert table point
            $param_point = array(
                'customer_id' => $sponsor_id,
                'invoice_id' => $invoice_id, 
                'departure_id' => $customer_id, //Customer making the purchase
                'points' => $point,
                'date' => date("Y-m-d H:i:s"),
                'active' => '1'
            );
            $points_id = $Points->insertar($param_point);
   
        //get sponsor level 2
        $db = \Config\Database::connect();
        $obj_tree = $db->query("SELECT unilevels.sponsor_id,unilevels.node, customers.active FROM unilevels  JOIN customers ON unilevels.sponsor_id = customers.id WHERE customer_id = $sponsor_id")->getRow();
        //get data sponsor
        if ($obj_tree) {

                //INSERT COMMISSION TABLE
                $param = array(
                    'customer_id' => $obj_tree->sponsor_id,
                    'invoice_id' => $invoice_id,
                    'bonus_id' => 1,
                    'level' => 2,
                    'arrive_id' => $customer_id,
                    'date' => date("Y-m-d H:i:s"),
                    'amount' => $level2,
                    'active' => '1',
                    'created_at' => date("Y-m-d H:i:s")
                );
                $Commissions->insertar($param);

                //insert table point
                $param = array(
                    'customer_id' => $obj_tree->sponsor_id,
                    'invoice_id' => $invoice_id, 
                    'departure_id' => $customer_id, //Customer making the purchase
                    'points' => $point,
                    'date' => date("Y-m-d H:i:s"),
                    'active' => '1'
                );
                $Points->insertar($param);
        }
    }

    //royalties on purchases - regalias de compras
    public function pay_propio_consumo($customer_id, $invoice_id)
    {
        $Commissions = new CommissionsModel();
        $Customer = new CustomerModel();
        //get membership_id by customer
        $obj_customer = $Customer->get_search_by_id($customer_id);

        //cambio por fecha y id
        if($obj_customer->id < 109){ // 108 son los fundadores

            switch ($obj_customer->membership_id) {
                //price per unit according to payment plan
                    //Pack 400
                case 2:
                    $amount = 1.86;  
                    break;
                    //Pack 800
                case 3:
                    $amount = 4.66;
                    break;
                    //Pack 1600
                case 4:
                    $amount = 7.45;
                    break;
                default:
                    $amount = 1.86;
                    break;
            }

        }else{

            switch ($obj_customer->membership_id) {
                    //price per unit according to payment plan
                    //Pack 400
                case 2:
                    $amount = 1.86;  
                    break;
                    //Pack 1600
                case 4:
                    $amount = 4.66;
                    break;
                default:
                    $amount = 1.86;
                    break;
            }

        }

        //obtain the quantity of products purchased
        $Invoice_detail_membershipModel = new Invoice_detail_membershipModel();

        $params = array(
            "select" => "sum(invoice_detail_membership.qty) as total",
            "join" => array(
                'memberships, invoice_detail_membership.membership_id = memberships.id'
            ),
            "where" => "invoice_id = $invoice_id"
        );
        $obj_products = $Invoice_detail_membershipModel->get_search_row($params);
        //qty total
        $qty = $obj_products->total;
        $total_amount = $qty * $amount;

            //insert commission
            $param = array(
                'customer_id' => $customer_id,
                'invoice_id' => $invoice_id,
                'bonus_id' => 6, //propio consumo
                'arrive_id' => $customer_id,
                'date' => date("Y-m-d H:i:s"),
                'amount' => $total_amount,
                'active' => '1',
                'created_at' => date("Y-m-d H:i:s")
            );
            $Commissions->insertar($param);
    }

    //regalias de mlm 
    public function pay_unilevel($customer_id, $node, $invoice_id, $point)
    {

        $point = floatval(str_replace(',', '', $point)); // Convierte a número válido
        
        $Customer = new CustomerModel();
        $Commissions = new CommissionsModel();
        $Customer = new CustomerModel();

        

        //delete first character
        $node = substr($node, 1);

        
        if($node){
            //get active users by id
            $obj_customer = $Customer->get_customer_unilevel_in_id($node);
        }else{
            $obj_customer = array();
        }

        //set date
        $Invoices = new InvoicesModel();
        //BOUCLE ULTI 10 LEVEL
        foreach ($obj_customer as $key => $value) {
            $key += 1;
            switch ($key) {
                // 8% 6% 9% 3% 2% 1% 1% 1% 1% 1% percentages in 10 levels of depth of purchase points

                case 1: //earn 8% -> 7.45% (real payment)
                    $amount = $point * 0.0745;
                    //no payment restriction
                    //insert commission
                    $param = array(
                        'customer_id' => $value->id,
                        'level' => $key,
                        'invoice_id' => $invoice_id,
                        'bonus_id' => 5,
                        'arrive_id' => $customer_id,
                        'date' => date("Y-m-d H:i:s"),
                        'amount' => $amount,
                        'active' => '1',
                        'created_at' => date("Y-m-d H:i:s")
                    );
                    $Commissions->insertar($param);
                    
                    break;
                case 2: //earn 6% -> 5.59% (real payment)
                    $amount = $point * 0.0559;

                    //insert commission
                    $param = array(
                        'customer_id' => $value->id,
                        'level' => $key,
                        'invoice_id' => $invoice_id,
                        'bonus_id' => 5,
                        'arrive_id' => $customer_id,
                        'date' => date("Y-m-d H:i:s"),
                        'amount' => $amount,
                        'active' => '1',
                        'created_at' => date("Y-m-d H:i:s")
                    );
                    $Commissions->insertar($param);
                    break;
                case 3: //earn 9% -> 8.38% (real payment)
                    $amount = $point * 0.0838;
                    
                    //insert commission
                    $param = array(
                        'customer_id' => $value->id,
                        'level' => $key,
                        'invoice_id' => $invoice_id,
                        'bonus_id' => 5,
                        'arrive_id' => $customer_id,
                        'date' => date("Y-m-d H:i:s"),
                        'amount' => $amount,
                        'active' => '1',
                        'created_at' => date("Y-m-d H:i:s")
                    );
                    $Commissions->insertar($param);
                  
                    break;
                case 4: //earn 3% -> 2.79% (real payment)
                    $amount = $point * 0.0279;
                    //get period data
                    $period = period();
                    //get repurchase points current
                    $obj_invoices = $Invoices->get_monthly_shopping_points($value->id, $period['first_month_day'], $period['last_month_day']);
                    //set personal point    
                    $personal_points = $obj_invoices->amount; //only points repurchase (membership = 1)

                    //puntos de recompra >= 500 condicion
                    if($personal_points >= 500){

                        //insert commission
                        $param = array(
                            'customer_id' => $value->id,
                            'level' => $key,
                            'invoice_id' => $invoice_id,
                            'bonus_id' => 5,
                            'arrive_id' => $customer_id,
                            'date' => date("Y-m-d H:i:s"),
                            'amount' => $amount,
                            'active' => '1',
                            'created_at' => date("Y-m-d H:i:s")
                        );
                        $Commissions->insertar($param);
                    }
                    
                    break;
                case 5: //earn 2% -> 1.86% (real payment) - sapphire rank only
                    $amount = $point * 0.0186;

                    //sapphire rank only , id = 6
                    if($value->range_id >= 6){
                        //insert commission
                        $param = array(
                            'customer_id' => $value->id,
                            'level' => $key,
                            'invoice_id' => $invoice_id,
                            'bonus_id' => 5,
                            'arrive_id' => $customer_id,
                            'date' => date("Y-m-d H:i:s"),
                            'amount' => $amount,
                            'active' => '1',
                            'created_at' => date("Y-m-d H:i:s")
                        );
                        $Commissions->insertar($param);
                    }
                    break;
                case 6: //earn 1% -> 0.93% (real payment) - ruby rank only
                    $amount = $point * 0.0093;

                    //ruby rank only , id = 7
                    if($value->range_id >= 7){
                        //insert commission
                        $param = array(
                            'customer_id' => $value->id,
                            'level' => $key,
                            'invoice_id' => $invoice_id,
                            'bonus_id' => 5,
                            'arrive_id' => $customer_id,
                            'date' => date("Y-m-d H:i:s"),
                            'amount' => $amount,
                            'active' => '1',
                            'created_at' => date("Y-m-d H:i:s")
                        );
                        $Commissions->insertar($param);
                    }
                break;
                case 7: //earn 1% -> 0.93% (real payment) - diamond rank only
                    $amount = $point * 0.0093;

                    //Diamond rank only , id = 8
                    if($value->range_id >= 8){
                        //insert commission
                        $param = array(
                            'customer_id' => $value->id,
                            'level' => $key,
                            'invoice_id' => $invoice_id,
                            'bonus_id' => 5,
                            'arrive_id' => $customer_id,
                            'date' => date("Y-m-d H:i:s"),
                            'amount' => $amount,
                            'active' => '1',
                            'created_at' => date("Y-m-d H:i:s")
                        );
                        $Commissions->insertar($param);
                    }
                break;
                case 8: //earn 1% -> 0.93% (real payment) - doble diamond rank only
                    $amount = $point * 0.0093;

                    //Doble diamante rank only , id = 9
                    if($value->range_id >= 9){
                        //insert commission
                        $param = array(
                            'customer_id' => $value->id,
                            'level' => $key,
                            'invoice_id' => $invoice_id,
                            'bonus_id' => 5,
                            'arrive_id' => $customer_id,
                            'date' => date("Y-m-d H:i:s"),
                            'amount' => $amount,
                            'active' => '1',
                            'created_at' => date("Y-m-d H:i:s")
                        );
                        $Commissions->insertar($param);
                    }
                break;
                case 9: //earn 1% -> 0.93% (real payment) - triple diamond rank only
                    $amount = $point * 0.0093;

                    //triple diamante rank only , id = 10
                    if($value->range_id >= 10){
                        //insert commission
                        $param = array(
                            'customer_id' => $value->id,
                            'level' => $key,
                            'invoice_id' => $invoice_id,
                            'bonus_id' => 5,
                            'arrive_id' => $customer_id,
                            'date' => date("Y-m-d H:i:s"),
                            'amount' => $amount,
                            'active' => '1',
                            'created_at' => date("Y-m-d H:i:s")
                        );
                        $Commissions->insertar($param);
                    }
                break;
                case 10: //earn 1% -> 0.93% (real payment) - only diamond ambassador rank
                    $amount = $point * 0.0093;

                    //DE rank only , id = 11
                    if($value->range_id >= 11){
                        //insert commission
                        $param = array(
                            'customer_id' => $value->id,
                            'level' => $key,
                            'invoice_id' => $invoice_id,
                            'bonus_id' => 5,
                            'arrive_id' => $customer_id,
                            'date' => date("Y-m-d H:i:s"),
                            'amount' => $amount,
                            'active' => '1',
                            'created_at' => date("Y-m-d H:i:s")
                        );
                        $Commissions->insertar($param);
                    }
                break;
            }
        }
    }

    //add points for ranges
    public function add_points_unilevel($point, $customer_id, $invoice_id, $node)
    {
        $Points = new PointsModel();
        //delete first caracter
        $node = substr($node, 1);  // sponsonship nodes
        $array = explode(",", $node); 
        //select customers
        foreach ($array as $key => $id) {
            //insert table point binary
            if ($id != 0 || $id != "") {
                //INSERT POINTS TABLE
                $param = array(
                    'customer_id' => $id,
                    'invoice_id' => $invoice_id,
                    'departure_id' => $customer_id,
                    'points' => $point,
                    'date' => date("Y-m-d"),
                    'active' => '1'
                );
                $points_id = $Points->insertar($param);
            }
        }
    }
    
    //all point and active user
    public function active_customer($customer_id, $point, $membership_id, $phone)
    {

        $db = \Config\Database::connect();
        //load model commission
        $Invoices = new InvoicesModel();
        $Customer = new CustomerModel();

        $obj_customer = $db->query("SELECT id, membership_id FROM customers WHERE id = $customer_id")->getRow();
        $customer_membership = $obj_customer->membership_id;

        if ($membership_id == 2 || $membership_id == 3 || $membership_id == 4) {  //Pack 400, PACK 800, PACK 1500
            if ($membership_id > $customer_membership) {
                $param = array(
                    'membership_id' => $membership_id,
                    'phone' => $phone,
                    'active' => '1',
                );
            } else {
                $param = array(
                    'phone' => $phone,
                    'active' => '1',
                );
            }
            $Customer->update($customer_id, $param);
        } else {
            //get fortnightly period
            $period = period();
            $total_points = $Invoices->get_sum_shop($customer_id, $period['first_month_day'], $period['last_month_day']);
            
            $num1 = floatval(str_replace(',', '', $total_points->points)); // Convierte a número válido
            $num2 = floatval(str_replace(',', '', $point)); // Convierte a número válido
            //set total poits
            $point = $num1 + $num2;
            //550 pts for active (5 product)
            if ($point >= 500) {
                if ($membership_id) {
                    if ($membership_id > $customer_membership) {
                        $param = array(
                            'membership_id' => $membership_id,
                            'phone' => $phone,
                            'active' => '1',
                        );
                    } else {
                        $param = array(
                            'phone' => $phone,
                            'active' => '1',
                        );
                    }
                    $Customer->update($customer_id, $param);
                }
            }
        }
    }

    public function unilevel_dynamic_compression($customer_id, $point)
    {
        $Commissions = new CommissionsModel;
        $Customer = new CustomerModel;
        $Invoices = new InvoicesModel;
        //get fortnightly period
        //get fortnightly period
        $period = period();
        $total_points = $Invoices->get_sum_shop($customer_id, $period['first_month_day'], $period['last_month_day']);
        //set point

        $num1 = floatval(str_replace(',', '', $total_points->points)); // Convierte a número válido
        $num2 = floatval(str_replace(',', '', $point)); // Convierte a número válido
        //set total poits
        $point = $num1 + $num2;

        //500 pts for active
        if ($point >= 500) {
            //Check if I have stagnant commissions
            $obj_comisions_standby = $Commissions->get_comissions_standby($customer_id, $period['first_month_day'], $period['last_month_day']);
            foreach ($obj_comisions_standby as $value) {
                //update comissions, original sponsor
                $param = array(
                    'customer_id' => $customer_id,
                    'customer_standby' => null
                );
                $Commissions->update($value->id, $param);
            }
        }
    }

    public function check_ranges($node)
    {
        $Customer = new CustomerModel();
        $Commissions = new CommissionsModel();
        $Unilevels = new UnilevelsModel();
        $Range_customer = new Range_customerModel();
        //get current period
        $period = period();

        //delete coma, first caracter
        $node = delete_first_caracter($node);
        //set variable
        $range_id = 1;
        $bronze = 2;
        $silver = 3;
        $gold = 4;
        $emeral = 5;
        $zafiro = 6;
        $rubi = 7;
        $diamond = 8;
        $ddiamond = 9;
        $tdiamond = 10;
        $ediamond = 11;

        //get active users by id
        $obj_customer = $Customer->get_customer_data_unilevel_in_id($node);

        foreach($obj_customer as $key => $value){

                $Invoices = new InvoicesModel();
                // active directs, must have a repurchase of 500 points
                $obj_invoices = $Invoices->get_monthly_shopping_points($value->id, $period['first_month_day'], $period['last_month_day']);
            
                if($obj_invoices){
                    //set personal point    
                    $personal_points = $obj_invoices->amount; //points

                    //Range Bronce 
                    //3 active lines + 600 personal points. + 3,000 group points
                    if($obj_invoices->group_points >= 3000){

                        if($personal_points >= 600 && $obj_invoices->total_referred >= 3){    
                            //set bronce
                            $range_id = 2;
                        }
                    }

                    //Range Silver 
                    //4 active lines + 800 personal points. + 7,000 group points
                    if($obj_invoices->group_points >= 7000){
                        if($personal_points >= 800 && $obj_invoices->total_referred >= 4){    
                            //set silver
                            $range_id = 3;
                        }
                    }

                    //Range Gold
                    //5 active lines + 1200 personal points. + 12,000 group points
                    if($obj_invoices->group_points >= 12000){
                        if($personal_points >= 1200 && $obj_invoices->total_referred >= 5){    
                            //set gold
                            $range_id = 4;
                        }
                    }

                    //Range Emerald
                    //6 active lines + 1,500 personal points + 35,000 group points + 1 Bronze, 2 Silver and 1 Gold on your team   
                    if($obj_invoices->group_points >= 35000){
                        if($personal_points >= 1500 && $obj_invoices->total_referred >= 6){    

                            //obtain team rank structure
                            $obj_total =  $Unilevels->get_count_downline_by_ranges($value->id, $bronze, $silver, $gold); //send id by range

                            //1 Bronze, 2 Silver and 1 Gold
                            if($obj_total->total_one >= 1 && $obj_total->total_two >= 2 && $obj_total->total_three >= 1){

                                //set emeral
                                $range_id = 5;
                            }
                            
                        }
                    }

                    //Range Zafiro
                    //+ 7 líneas activas + 2,000 puntos personales + 50,000 puntos grupales + 1 Plata, 2 Orosy 1 Esmeralda en tu equipo
                    if($obj_invoices->group_points >= 50000){
                        if($personal_points >= 2000 && $obj_invoices->total_referred >= 7){    

                            //obtain team rank structure
                            $obj_total =  $Unilevels->get_count_downline_by_ranges($value->id, $silver, $gold, $emeral); //send id by range

                            //+ 1 Oro, 2 Esmeraldas y 1 Zafiro en tu equipo
                            if($obj_total->total_one >= 1 && $obj_total->total_two >= 2 && $obj_total->total_three >= 1){

                                //set Rubí
                                $range_id = 6;
                            }
                            
                        }
                    }

                    //Range Rubí
                    // 8 líneas activas + 2,000 puntos personales + 80,000 puntos grupales 
                    if($obj_invoices->group_points >= 80000){
                        if($personal_points >= 2000 && $obj_invoices->total_referred >= 8){    

                            //obtain team rank structure
                            $obj_total =  $Unilevels->get_count_downline_by_ranges($value->id, $gold, $emeral, $zafiro); //send id by range

                            //+ 1 Oro, 2 Esmeraldas y 1 Zafiro en tu equipo
                            if($obj_total->total_one >= 1 && $obj_total->total_two >= 2 && $obj_total->total_three >= 1){

                                //set rubi
                                $range_id = 7;
                            }
                            
                        }
                    }

                    //Range Diamante
                    // + 9 líneas activas + 2,000 puntos personales + 200,000 puntos grupales 
                    if($obj_invoices->group_points >= 200000){
                        if($personal_points >= 2000 && $obj_invoices->total_referred >= 9){    

                            //obtain team rank structure
                            $obj_total =  $Unilevels->get_count_downline_by_ranges($value->id, $emeral, $zafiro, $rubi); //send id by range

                            //+ 1 Esmeralda, 2 Zafiros y 1 Rubí en tu equipo
                            if($obj_total->total_one >= 1 && $obj_total->total_two >= 2 && $obj_total->total_three >= 1){

                                //set diamond
                                $range_id = 8;
                            }
                            
                        }
                    }

                    //Range Doble Diamante
                    // + 10 líneas activas + 2,000 puntos personales + 500,000 puntos grupales
                    if($obj_invoices->group_points >= 500000){
                        if($personal_points >= 2000 && $obj_invoices->total_referred >= 10){    

                            //obtain team rank structure
                            $obj_total =  $Unilevels->get_count_downline_by_ranges($value->id, $zafiro, $rubi, $diamond); //send id by range

                            //+ 1 Zafiro, 2 Rubíes y 1 Diamante en tu equipo
                            if($obj_total->total_one >= 1 && $obj_total->total_two >= 2 && $obj_total->total_three >= 1){

                                //set doble diamond
                                $range_id = 9;
                            }
                            
                        }
                    }

                    //Range Triple Diamante
                    //+ 10 líneas activas + 2,000 puntos personales + 1,200,000 puntos grupales
                    if($obj_invoices->group_points >= 1200000){
                        if($personal_points >= 2000 && $obj_invoices->total_referred >= 10){    

                            //obtain team rank structure
                            $obj_total =  $Unilevels->get_count_downline_by_ranges($value->id, $rubi, $diamond, $ddiamond); //send id by range

                            // + 1 Rubí, 2 Diamantes y 1 Diamante Doble en tu equipo
                            if($obj_total->total_one >= 1 && $obj_total->total_two >= 2 && $obj_total->total_three >= 1){

                                //set triple diamond
                                $range_id = 10;
                            }
                            
                        }
                    }

                    //Range Diamante Embajador
                    //+ 10 líneas activas + 2,500 puntos personales + 3,000,000 puntos grupales
                    if($obj_invoices->group_points >= 3000000){
                        if($personal_points >= 2500 && $obj_invoices->total_referred >= 10){    

                            //obtain team rank structure
                            $obj_total =  $Unilevels->get_count_downline_by_ranges($value->id, $diamond, $ddiamond, $tdiamond); //send id by range

                            //1 Diamante, 2 Doble Diamantes y 1 Triple Diamante en tu equipo
                            if($obj_total->total_one >= 1 && $obj_total->total_two >= 2 && $obj_total->total_three >= 1){

                                //set embassador diamond
                                $range_id = 11;
                            }
                            
                        }
                    }
                }

                //update range table customers
                if($range_id > $value->range_id){

                    /////////////////////////
                    //pay bonus lidership
                    $this->pay_liderazgo($value->id, $range_id);
                    /////////////////////////

                    //Check if there is any range for that period and update it.
                    $obj_range_customer =  $Range_customer->get_data_by_periodo($value->id, $period['first_month_day'], $period['last_month_day']);
                    //verify
                    if($obj_range_customer){
                        if($range_id > $obj_range_customer->range_id){
                            //update last range calification
                            $param = array(
                                'range_id' => $range_id,
                                'points' => $obj_invoices->group_points,
                                'date' => date("Y-m-d")
                            ); 
                            $Range_customer->update($obj_range_customer->id, $param);   
                        }
                    }else{
                        $param = array(
                            'customer_id' => $value->id,
                            'range_id' => $range_id,
                            'points' => $obj_invoices->group_points,
                            'date' => date("Y-m-d")
                        ); 
                        $Range_customer->insertar($param);
                    }
                    //update range customer table
                    $param = array(
                        'range_id' => $range_id
                    ); 
                    $Customer->update($value->id, $param);       
                }
            
            //reset range
            $range_id = 1;

            
        }
        //respose
        
    }

    public function pay_liderazgo($customer_id, $new_range_id)
    {
        switch ($new_range_id) {
                //bronce
            case 2:
                $amount = 500;
                break;
                //plata
            case 3:
                $amount = 700;
                break;
                //oro
            case 4:
                $amount = 1000;
                break;
                //emerald
            case 5:
                $amount = 0;
                break;
                //zafiro
            case 6:
                $amount = 0;
                break;
                //rubi
            case 7:
                $amount = 0;
                break;
                //diamante
            case 8:
                $amount = 0;
                break;
                //doble diamante
            case 9:
                $amount = 0;
                break;
                //Triple Diamante
            case 10:
                $amount = 0;
                break;
                //Diamante Embajador
            case 11:
                $amount = 0;
                break;
            default:
                $amount = 0;
                break;
        }
        $date =  date('Y-m-d H:i:s');

        $Commissions = new CommissionsModel();

        //verify single commission for the range (by amount)
        $obj_bonus_lidership = $Commissions->get_comissions_bonus_lidership($customer_id, $amount);

        if ($amount > 0) {
            if ($obj_bonus_lidership == 0) {

                //insert table commission
                $param = array(
                    'customer_id' => $customer_id,
                    'bonus_id' => 7,
                    'arrive_id' => 0,
                    'amount' => $amount,
                    'date' => $date,
                    'active' => '1',
                    'created_at' => $date
                );
                $Commissions->insertar($param);
                
            }
        }
    }
    //End plan
   
}