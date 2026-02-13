<?php

namespace App\Controllers;

use App\Models\TransferModel;
use App\Models\IncomingModel;
use App\Models\SuppliersModel;
use App\Models\MembershipsModel;
use App\Models\StoreModel;


class D_transfer extends BaseController
{
    public function index()
    {
        //get data session
        $session_name = $_SESSION['first_name'] . " " . $_SESSION['last_name'];
        //get data bonus
        $Transfer = new TransferModel();
        $obj_transfer = $Transfer->get_all();

        // var_dump($obj_transfer);
        // die();

        //send
        $data = array(
            'obj_transfer' => $obj_transfer,
            'session_name' => $session_name
        );
        return view('admin/traspaso/list', $data);
    }

    public function load($id = false)
    {
        //get data session
        $session_name = $_SESSION['first_name'] . " " . $_SESSION['last_name'];
        //set var
        $obj_transfer = null;
        //verify
        if ($id != false) {
            //get data bonus by bonus
            $Tranfer = new TransferModel();
            $obj_transfer = $Tranfer->get_by_id($id);
        }
        //get supplier active
        $Suppliers = new SuppliersModel();
        $obj_supplier = $Suppliers->get_data_active();
        //get product active and accounting
        $Memberships = new MembershipsModel();
        $obj_memberships = $Memberships->get_all_countable();
        //get store active
        $StoreModel = new StoreModel();
        $obj_store = $StoreModel->get_all_active();
        //send
        $data = array(
            'obj_transfer' => $obj_transfer,
            'obj_supplier' => $obj_supplier,
            'obj_memberships' => $obj_memberships,
            'obj_store' => $obj_store,
            'session_name' => $session_name
        );
        return view('admin/traspaso/load', $data);
    }

    public function validacion()
    {
        //ACTIVE CUSTOMER NORMALY
        if ($this->request->isAJAX()) {
            $id = $_SESSION['id'];
            $Incoming = new IncomingModel();
            $Transfer = new TransferModel();
            //get data post
            $res = service('request')->getPost();
            //set var
            $qty = $res['qty'];
            $qty = intval($qty);
            $unit_cost = $res['unit_cost'];
            $unit_cost = floatval($unit_cost);
            $total_cost = $unit_cost * $qty;
            //verify                     
            if ($qty > 0) {
                //subtract product incoming
                $param = array(
                    'membership_id' => $res['membership_id'],
                    'store_id' => $res['leave_store_id'],
                    'user_id' => $id,
                    'qty' => -$qty,
                    'date' => date("Y-m-d H:i:s"),
                    'unit_cost' => $res['unit_cost'],
                    'total_cost' => $total_cost,
                    'active' => '0',
                    'created_at' => date("Y-m-d H:i:s"),
                );
                $incoming_id_leave = $Incoming->insertar($param);
                //$incoming_id_leave = 60;
                $param_transfer = array(
                    'store_leave_id' => $incoming_id_leave,
                    'qty' => $qty,
                    'unit_cost' => $res['unit_cost'],
                    'total_costo' => $total_cost,
                    'date' => date("Y-m-d H:i:s"),
                    'user_id' => $id,
                    'created_at' => date("Y-m-d H:i:s")
                );
                $transfer_id = $Transfer->insertar($param_transfer);  
                //adding product incoming
                $param = array(
                    'membership_id' => $res['membership_id'],
                    'store_id' => $res['arrive_store_id'],
                    'user_id' => $id,
                    'qty' => $qty,
                    'date' => date("Y-m-d H:i:s"),
                    'unit_cost' => $res['unit_cost'],
                    'total_cost' => $total_cost,
                    'active' => '0',
                    'created_at' => date("Y-m-d H:i:s"),
                );
                $incoming_id_arrive = $Incoming->insertar($param);
                //update store_arrive_id on tranfer table
                $param_transfer = array(
                    'store_arrive_id' => $incoming_id_arrive,
                );
                $result = $Transfer->update($transfer_id, $param_transfer);  
            }
            if (!is_null($result)) {
                $data['status'] = true;
                $data['message'] = SAVED;
            } else {
                $data['status'] = false;
                $data['message'] = ERROR;
            }
            echo json_encode($data);
            exit();
        }
    }

    public function eliminar()
    {
        //ACTIVE CUSTOMER NORMALY
        if ($this->request->isAJAX()) {
            $Incoming = new IncomingModel();
            //get data post
            $res = service('request')->getPost();
            $incoming_id = $res['incoming_id'];
            //verify                     
            if ($incoming_id != null) {
                $result = $Incoming->eliminar($incoming_id);
                if (!is_null($result)) {
                    $data['status'] = true;
                    $data['message'] = DELETED;
                } else {
                    $data['status'] = false;
                    $data['message'] = ERROR;
                }
            } else {
                $data['status'] = false;
                $data['message'] = ERROR;
            }
            echo json_encode($data);
            exit();
        }
    }
    
    public function get_max_product()
    {
        //ACTIVE CUSTOMER NORMALY
        if ($this->request->isAJAX()) {
            $Incoming = new IncomingModel();
            $balance = 0;
            $unit_cost = 0;
            //get data post
            $res = service('request')->getPost();
            $membership_id = $res['selectedOption'];
            $store_id = $res['selectLeave_id'];
            //verify                     
            if ($membership_id && $store_id) {
                $obj_incoming = $Incoming->get_max_membership_store($membership_id, $store_id);
                if($obj_incoming){
                    $balance = $obj_incoming->total_incoming - $obj_incoming->total_ourgoing;
                    $unit_cost = $obj_incoming->unit_cost;
                }
                if($balance < 0){
                    $balance = 0;
                }
                $data['status'] = true;
                $data['balance'] = $balance;
                $data['unit_cost'] = floatval($unit_cost);
            } else {
                $data['status'] = false;
                $data['balance'] = 0;
                $data['unit_cost'] = 0;
            }
            echo json_encode($data);
            exit();
        }
    }
}
