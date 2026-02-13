<?php

namespace App\Controllers;

use App\Models\IncomingModel;
use App\Models\SuppliersModel;
use App\Models\MembershipsModel;
use App\Models\StoreModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class D_incoming extends BaseController
{
    public function index()
    {
        $Incoming = new IncomingModel();
        $style = "disabled";
        $store_id = "";
        //get data session
        $session_name = $_SESSION['first_name'] . " " . $_SESSION['last_name'];
        $first_day = date('Y-m-01');
        $last_day = date('Y-m-t');
        //plus +1 day
        $last_day = strtotime('+1 day', strtotime($last_day));
        $last_day = date('Y-m-d', $last_day);
        if($_POST){
            $res = service('request')->getPost();
            $daterange = $res['daterange'];
            $store_id = $res['store_id'];
            //make query date
            $explode_ragen = explode(' - ', $daterange);
            $first_day = $explode_ragen[0];
            $last_day = $explode_ragen[1];
            $last_day = strtotime('+1 day', strtotime($last_day));
            $last_day = date('Y-m-d', $last_day);
            //set var
            $where_store_id = "";
            //make query
            $where_date = "incoming.date >= '$first_day' and incoming.date < '$last_day'";
            if($store_id){
                $where_store_id = " and incoming.store_id = '$store_id'";
            }
            $where = "$where_date"."$where_store_id";
            //get data customer by filters
            $obj_incoming = $Incoming->get_incoming_by_export($where);
            //style boton export
            $style = "";
        }else{
            //get data incoming
            $Incoming = new IncomingModel();
            $obj_incoming = $Incoming->get_all($first_day, $last_day);
        }
        //get store active
        $StoreModel = new StoreModel();
        $obj_store = $StoreModel->get_all_active();
        //send
        $data = array(
            'obj_incoming' => $obj_incoming,
            'obj_store' => $obj_store,
            'style' => $style,
            'first_day' => $first_day,
            'last_day' => $last_day,
            'store_id' => $store_id,
            'session_name' => $session_name
        );
        return view('admin/entradas/list', $data);
    }

    public function load($id = false)
    {
        //get data session
        $session_name = $_SESSION['first_name'] . " " . $_SESSION['last_name'];
        //set var
        $obj_incoming = null;
        //verify
        if ($id != false) {
            //get data bonus by bonus
            $Incoming = new IncomingModel();
            $obj_incoming = $Incoming->get_by_id($id);
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
            'obj_incoming' => $obj_incoming,
            'obj_supplier' => $obj_supplier,
            'obj_memberships' => $obj_memberships,
            'obj_store' => $obj_store,
            'session_name' => $session_name
        );
        return view('admin/entradas/load', $data);
    }

    public function validacion()
    {
        //ACTIVE CUSTOMER NORMALY
        if ($this->request->isAJAX()) {
            $id = $_SESSION['id'];
            $Incoming = new IncomingModel();
            //get data post
            $res = service('request')->getPost();
            $incoming_id = $res['incoming_id'];
            $total_cost = $res['unit_cost'] * $res['qty'];
            //verify                     
            if ($incoming_id != "") {
                //update tabla bonus
                $param = array(
                    'membership_id' => $res['membership_id'],
                    'supplier_id' => $res['supplier_id'],
                    'store_id' => $res['store_id'],
                    'qty' => $res['qty'],
                    'unit_cost' => $res['unit_cost'],
                    'total_cost' => $total_cost,
                    'updated_at' => date("Y-m-d H:i:s")
                );
                $result = $Incoming->update($incoming_id, $param);
            } else {
                //UPDATE DATA
                $param = array(
                    'membership_id' => $res['membership_id'],
                    'supplier_id' => $res['supplier_id'],
                    'store_id' => $res['store_id'],
                    'user_id' => $id,
                    'qty' => $res['qty'],
                    'date' => date("Y-m-d H:i:s"),
                    'unit_cost' => $res['unit_cost'],
                    'total_cost' => $total_cost,
                    'active' => '1',
                    'created_at' => date("Y-m-d H:i:s"),
                );
                $result = $Incoming->insertar($param);
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

    public function save_csv()
    {
        //ACTIVE CUSTOMER NORMALY
        if ($this->request->isAJAX()) {
            $Incoming = new IncomingModel();
            $Memberships = new MembershipsModel();
            $Suppliers = new SuppliersModel();
            $Store = new StoreModel();
            //get data post by json
            $res = service('request')->getPost();
            $data_json = $res['jsonString'];
            //get data json with json_decode
            $items = json_decode($data_json, true);
            //save data
            foreach ($items as $value) {
                //get membership id by name
                $obj_membership = $Memberships->get_data_by_name($value['membership']);
                if($obj_membership){
                    $membership_id = $obj_membership->id;
                }else{
                    $membership_id = "";
                }
                //get supplier id by name
                $obj_supplier = $Suppliers->get_data_by_name($value['supplier']);
                if($obj_supplier){
                    $obj_supplier_id = $obj_supplier->id;
                }else{
                    $obj_supplier_id = "";
                }
                //get sytore_id by name
                $obj_store = $Store->get_data_by_name($value['store']);
                if($obj_store){
                    $obj_store_id = $obj_store->id;
                }else{
                    $obj_store_id = "";
                }
                //calc
                $unit_cost = $value['unit_cost'];
                $unit_cost = floatval($unit_cost);
                $qty = $value['qty'];
                $qty = (int)$qty;
                $total_cost = $unit_cost * $qty;
                //insert data
                $param = array(
                    'membership_id' => $membership_id,
                    'supplier_id' => $obj_supplier_id,
                    'store_id' => $obj_store_id,
                    'user_id' => $_SESSION['id'],
                    'qty' => $value['qty'],
                    'date' => date("Y-m-d H:i:s"),
                    'unit_cost' => $unit_cost,
                    'total_cost' => $total_cost,
                    'active' => '1',
                    'created_at' => date("Y-m-d H:i:s"),
                );
                $Incoming->insertar($param);
            }
            $data['status'] = true;
            $data['message'] = SAVED;
            echo json_encode($data);
            exit();
        }
    }

    public function export()
    {
        $Incoming = new IncomingModel();
        //get data post
        $res = service('request')->getPost();
        $daterange = $res['daterange'];
        $store_id = $res['store_id'];
        //make query date
        $explode_ragen = explode(' - ', $daterange);
        $date_begin = $explode_ragen[0];
        $date_end1 = $explode_ragen[1];
        $date_end = strtotime('+1 day', strtotime($date_end1));
        $date_end = date('Y-m-d', $date_end);
        //set var
        $where_store_id = "";
        //make query
        $where_date = "incoming.date >= '$date_begin' and incoming.date < '$date_end'";
        if($store_id){
            $where_store_id = " and incoming.store_id = '$store_id'";
        }
        $where = "$where_date"."$where_store_id";
        //get data customer by filters
        $obj_incoming = $Incoming->get_incoming_by_export($where);
        $file = "Entrada_".$date_begin."_".$date_end1;
        $fileName = $file.'.xlsx';  
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'Producto');
        $sheet->setCellValue('C1', 'Proveedor');
        $sheet->setCellValue('D1', 'Cantidad');
        $sheet->setCellValue('E1', 'Almacen');
        $sheet->setCellValue('F1', 'Costo Unitario');
        $sheet->setCellValue('G1', 'Costo Total');
        $sheet->setCellValue('H1', 'Fecha');
        $sheet->setCellValue('I1', 'Ingresado Por');

        $rows = 2;
        foreach ($obj_incoming as $value): 
             $sheet->setCellValue('A' . $rows, $value->id);
             $sheet->setCellValue('B' . $rows, $value->membership);
             $sheet->setCellValue('C' . $rows, $value->supplier);
             $sheet->setCellValue('D' . $rows, $value->qty);
             $sheet->setCellValue('E' . $rows, $value->store);
             $sheet->setCellValue('F' . $rows, $value->unit_cost);
             $sheet->setCellValue('G' . $rows, $value->total_cost);
             $sheet->setCellValue('H' . $rows, $value->date);
             $sheet->setCellValue('I' . $rows, $value->user);
             $rows++;
            endforeach;
        $url = "upload/".$fileName;  
        $writer = new Xlsx($spreadsheet);
        $writer->save($url);
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename=' . $fileName);
        readfile( $url );
    }

    public function get_unit_cost()
    {
        //ACTIVE CUSTOMER NORMALY
        if ($this->request->isAJAX()) {
            $Incoming = new IncomingModel();
            $Memberships = new MembershipsModel();
            //get data post
            $res = service('request')->getPost();
            $membership_id = $res['selectedOption'];
            //verify                     
            if ($membership_id != null) {
                $obj_membership = $Memberships->get_all_by_id($membership_id);
                if (!is_null($obj_membership)) {
                    $data['status'] = true;
                    $data['unit_cost'] = $obj_membership->unit_cost;
                } else {
                    $data['status'] = false;
                    $data['unit_cost'] = 0;
                }
            } else {
                $data['status'] = false;
                $data['message'] = ERROR;
            }
            echo json_encode($data);
            exit();
        }
    }
}
