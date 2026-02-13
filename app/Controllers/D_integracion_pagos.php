<?php

namespace App\Controllers;
use App\Models\CustomerModel;
use App\Models\CommissionsModel;
use App\Models\BonusesModel;
use App\Models\Points_binaryModel;


class D_integracion_pagos extends BaseController
{   
    public function index()
    {
        //get data session
        $session_name = $_SESSION['first_name']." ".$_SESSION['last_name'];
        //get data comission by system
        $Customer = new CustomerModel();
        $obj_comissions = $Customer->comisiones_by_system();

        //send view
        $data = array(
            'obj_comissions' => $obj_comissions,
            'session_name' => $session_name
        );
        return view('admin/integracion/integracion_pago', $data);
    }
    
    public function load($id=false)
    {
        //get data session
        $session_name = $_SESSION['first_name']." ".$_SESSION['last_name'];
        $Customer = new CustomerModel();
        $Bonus = new BonusesModel();
        //set var
        $obj_comissions = null;
        //verify id
        if ($id != false){
            //get data comission by system by id
            $obj_comissions = $Customer->comisiones_by_system_id($id);
          }
        //get bonus sistema
        $obj_bonus = $Bonus->get_all_by_name("Sistema");
        $bonus_id = $obj_bonus->id;
        //send data
        $data = array(
            'obj_comissions' => $obj_comissions,
            'bonus_id' => $bonus_id,
            'session_name' => $session_name
        );
        return view('admin/integracion/load',$data);
    }

    public function active(){
        //ACTIVE CUSTOMER NORMALY
        if ($this->request->isAJAX()) {
            $session = session();
            $id = $session->get('id');
            $Commissions = new CommissionsModel();
            //get data post
            $res = service('request')->getPost();
            $commissions_id = $res['commissions_id'];
            $customer_id = $res['customer_id'];
            $bonus_id = $res['bonus_id'];
            $amount = $res['amount'];
            //verify
            if($commissions_id != ""){
                //insert data on sell table
                $param = array(
                    'customer_id' => $customer_id,
                    'bonus_id' => $bonus_id,
                    'amount' => $amount,
                );
                $result = $Commissions->update($commissions_id, $param);   
            }else{
                //insert data on sell table
                $param = array(
                    'customer_id' => $customer_id,
                    'bonus_id' => $bonus_id,
                    'system_discount' => 1,
                    'amount' => $amount,
                    'date' => date("Y-m-d H:i:s"),
                    'active' => '1'
                );
                $result = $Commissions->insertar($param);   
            }
            //verify
            if(!is_null($result)){
                $data['status'] = true;
                $data['message'] = SAVED;
            }else{
                $data['status'] = false;
                $data['message'] = ERROR;
            }     
            echo json_encode($data); 
            exit();
            }
    }

    public function eliminar(){
        //ACTIVE CUSTOMER NORMALY
        if ($this->request->isAJAX()) {
            $session = session();
            $Commissions = new CommissionsModel();
            //get data post
            $res = service('request')->getPost();
            $id = $res['id'];
            if(!is_null($id)){
                //delete row
                $result = $Commissions->eliminar($id);
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

    //puntos binario
    public function puntos(){ 
        //get data session
        $session_name = $_SESSION['first_name']." ".$_SESSION['last_name'];
        //get data comission by system
        $Customer = new CustomerModel();
        $obj_points_binary = $Customer->get_point_binary_by_customer();
        //send view
        $data = array(
            'obj_points_binary' => $obj_points_binary,
            'session_name' => $session_name
        );
        // view
        return view('admin/integracion/puntos_binario', $data);
    }
    
    public function puntos_load($id=false)
    {
        //get data session
        $session_name = $_SESSION['first_name']." ".$_SESSION['last_name'];
        $Customer = new CustomerModel();
        //set var
        $obj_point_binary = null;
        //verify id
        if ($id != false){
            //get data comission by system by id
            $obj_point_binary = $Customer->get_point_binary_by_customer_by_id($id);
        }
        //send data
        $data = array(
            'obj_point_binary' => $obj_point_binary,
            'session_name' => $session_name
        );
        return view('admin/integracion/puntos_binario_load',$data);
    }

    public function validate_user() {
        if ($this->request->isAJAX()) {
            $db = \Config\Database::connect();
            //get data post
            $res = service('request')->getPost();
            $code = $res['username'];
            //get data customer
            $customer = $db->query("SELECT id, name, lastname, dni FROM customers where code = '$code'")->getResult();
            if (count($customer) > 0) {
                $data['message'] = true;
                $data['name'] = $customer[0]->name . " " . $customer[0]->lastname;
                $data['customer_id'] = $customer[0]->id;
                $data['dni'] = $customer[0]->dni;
                $data['print'] = "Cliente Encontrado!";
            } else {
                $data['message'] = false;
                $data['print'] = "Cliente no existe!";
            }
            echo json_encode($data);
            exit();
        }
    }

    public function active_puntos(){
        //ACTIVE CUSTOMER NORMALY
        if ($this->request->isAJAX()) {
            $session = session();
            $id = $session->get('id');
            $Points_binary = new Points_binaryModel();
            //get data post
            $res = service('request')->getPost();
            $point_binary_id = $res['points_binary_id'];
            $customer_id = $res['customer_id'];
            $left = $res['left'];
            $right = $res['right'];
            $active = $res['active'];
            //verify
            if($point_binary_id != ""){
                //insert data on sell table
                $param = array(
                    'customer_id' => $customer_id,
                    'left' => $left,
                    'right' => $right,
                    'active' => $active,
                );
                $result = $Points_binary->update($point_binary_id, $param);   
            }else{
                //insert data on sell table
                $param = array(
                    'customer_id' => $customer_id,
                    'left' => $left,
                    'right' => $right,
                    'date' => date("Y-m-d"),
                    'active' => $active,
                    'system' => '1',
                );
                $result = $Points_binary->insertar($param);   
            }
            //verify
            if(!is_null($result)){
                $data['status'] = true;
            }else{
                $data['status'] = false;
            }     
            echo json_encode($data); 
            exit();
        }
    }

    public function eliminar_point_binary(){
        //ACTIVE CUSTOMER NORMALY
        if ($this->request->isAJAX()) {
            $session = session();
            $Points_binary = new Points_binaryModel();
            //get data post
            $res = service('request')->getPost();
            $id = $res['id'];
            if(!is_null($id)){
                //delete row
                $result = $Points_binary->eliminar($id);
                if(!is_null($result)){
                    $data['status'] = true;
                }else{
                    $data['status'] = false;
                }   
            }else{
                $data['status'] = false;
            }
            echo json_encode($data); 
            exit();
        }
    }

    //puntos rango
    public function rangos(){
        //get data session
        $session_name = $_SESSION['first_name']." ".$_SESSION['last_name'];
        //get data comission by system
        $Customer = new CustomerModel();
        $obj_points_ranges = $Customer->get_point_binary_ranges_by_customer();
        //send view
        $data = array(
            'obj_points_ranges' => $obj_points_ranges,
            'session_name' => $session_name
        );
        // view
        return view('admin/integracion/puntos_rangos', $data);
    }
    
    public function rangos_load($id=false)
    {
        //get data session
        $session_name = $_SESSION['first_name']." ".$_SESSION['last_name'];
        $Customer = new CustomerModel();
        //set var
        $obj_points_ranges = null;
        //verify id
        if ($id != false){
            //get data comission by system by id
            $obj_points_ranges = $Customer->get_point_ranges_by_customer_by_id($id);
        }
        //send data
        $data = array(
            'obj_points_ranges' => $obj_points_ranges,
            'session_name' => $session_name
        );
        return view('admin/integracion/puntos_rangos_load',$data);
    }

    public function active_puntos_rangos(){
        //ACTIVE CUSTOMER NORMALY
        if ($this->request->isAJAX()) {
            $session = session();
            $id = $session->get('id');
            $Points_binary = new Points_binaryModel();
            //get data post
            $res = service('request')->getPost();
            $point_binary_id = $res['points_binary_id'];
            $customer_id = $res['customer_id'];
            $left = $res['left'];
            $right = $res['right'];
            $active = $res['active'];
            //verify
            if($point_binary_id != ""){
                //insert data on sell table
                $param = array(
                    'customer_id' => $customer_id,
                    'left' => $left,
                    'right' => $right,
                    'range' => '1',
                    'active' => $active,
                );
                $result = $Points_binary->update($point_binary_id, $param);   
            }else{
                //insert data on sell table
                $param = array(
                    'customer_id' => $customer_id,
                    'left' => $left,
                    'right' => $right,
                    'date' => date("Y-m-d"),
                    'active' => $active,
                    'range' => '1',
                    'system' => '1',
                );
                $result = $Points_binary->insertar($param);   
            }
            //verify
            if(!is_null($result)){
                $data['status'] = true;
            }else{
                $data['status'] = false;
            }     
            echo json_encode($data); 
            exit();
        }
    }

    public function eliminar_point_rangos(){
        //ACTIVE CUSTOMER NORMALY
        if ($this->request->isAJAX()) {
            $session = session();
            $Points_binary = new Points_binaryModel();
            //get data post
            $res = service('request')->getPost();
            $id = $res['id'];
            if(!is_null($id)){
                //delete row
                $result = $Points_binary->eliminar($id);
                if(!is_null($result)){
                    $data['status'] = true;
                }else{
                    $data['status'] = false;
                }   
            }else{
                $data['status'] = false;
            }
            echo json_encode($data); 
            exit();
        }
    }
}
