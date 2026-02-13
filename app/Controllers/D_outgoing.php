<?php

namespace App\Controllers;

use App\Models\OutgoingModel;
use App\Models\SuppliersModel;
use App\Models\MembershipsModel;
use App\Models\StoreModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class D_outgoing extends BaseController
{
    public function index()
    {
        $Outgoing = new OutgoingModel();
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
            $where_date = "outgoing.date >= '$first_day' and outgoing.date < '$last_day'";
            if($store_id){
                $where_store_id = " and outgoing.store_id = '$store_id'";
            }
            $where = "$where_date"."$where_store_id";
            //get data customer by filters
            $obj_outgoing = $Outgoing->get_data_by_export($where);
            //style boton export
            $style = "";
        }else{
            //get data incoming
            $obj_outgoing = $Outgoing->get_all($first_day, $last_day);
        }
        //get store active
        $StoreModel = new StoreModel();
        $obj_store = $StoreModel->get_all_active();
        //send
        $data = array(
            'obj_outgoing' => $obj_outgoing,
            'obj_store' => $obj_store,
            'style' => $style,
            'first_day' => $first_day,
            'last_day' => $last_day,
            'store_id' => $store_id,
            'session_name' => $session_name
        );
        return view('admin/salidas/list', $data);
    }

    public function load($id = false)
    {
        //get data session
        $session_name = $_SESSION['first_name'] . " " . $_SESSION['last_name'];
        //set var
        $obj_outgoing = null;
        //verify
        if ($id != false) {
            //get data bonus by bonus
            $Outgoing = new OutgoingModel();
            $obj_outgoing = $Outgoing->get_by_id($id);
        }
        //get product active and accounting
        $Memberships = new MembershipsModel();
        $obj_memberships = $Memberships->get_all_countable();
        //get store active
        $StoreModel = new StoreModel();
        $obj_store = $StoreModel->get_all_active();
        //send
        $data = array(
            'obj_outgoing' => $obj_outgoing,
            'obj_memberships' => $obj_memberships,
            'obj_store' => $obj_store,
            'session_name' => $session_name
        );
        return view('admin/salidas/load', $data);
    }

    public function validacion()
    {
        //ACTIVE CUSTOMER NORMALY
        if ($this->request->isAJAX()) {
            $id = $_SESSION['id'];
            $Outgoing = new OutgoingModel();
            //get data post
            $res = service('request')->getPost();
            $outgoing_id = $res['outgoing_id'];
            $total_cost = $res['unit_cost'] * $res['qty'];
            //verify                     
            if ($outgoing_id != "") {
                //update tabla bonus
                $param = array(
                    'membership_id' => $res['membership_id'],
                    'store_id' => $res['store_id'],
                    'qty' => $res['qty'],
                    'unit_cost' => $res['unit_cost'],
                    'total_cost' => $total_cost,
                    'updated_at' => date("Y-m-d H:i:s")
                );
                $result = $Outgoing->update($outgoing_id, $param);
            } else {
                //UPDATE DATA
                $param = array(
                    'membership_id' => $res['membership_id'],
                    'store_id' => $res['store_id'],
                    'unit_cost' => $res['unit_cost'],
                    'user_id' => $id,
                    'qty' => $res['qty'],
                    'date' => date("Y-m-d H:i:s"),
                    'total_cost' => $total_cost,
                    'active' => '2',
                    'created_at' => date("Y-m-d H:i:s"),
                );
                $result = $Outgoing->insertar($param);
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
            $Outgoing = new OutgoingModel();
            //get data post
            $res = service('request')->getPost();
            $outgoing_id = $res['outgoing_id'];
            //verify                     
            if ($outgoing_id != null) {
                $result = $Outgoing->eliminar($outgoing_id);
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

    public function export()
    {
        $Outgoing = new OutgoingModel();
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
        $where_date = "outgoing.date >= '$date_begin' and outgoing.date < '$date_end'";
        if($store_id){
            $where_store_id = " and outgoing.store_id = '$store_id'";
        }
        $where = "$where_date"."$where_store_id";
        //get data customer by filters
        $obj_outgoing = $Outgoing->get_data_by_export($where);
        $file = "Salidas_".$date_begin."_".$date_end1;
        $fileName = $file.'.xlsx';  
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'Concepto');
        $sheet->setCellValue('C1', 'Producto');
        $sheet->setCellValue('D1', 'Cantidad');
        $sheet->setCellValue('E1', 'De Almacen');
        $sheet->setCellValue('F1', 'Fecha');

        $rows = 2;
        foreach ($obj_outgoing as $value): 
             $sheet->setCellValue('A' . $rows, $value->id);
             $sheet->setCellValue('B' . $rows, "Salida");
             $sheet->setCellValue('C' . $rows, $value->membership);
             $sheet->setCellValue('D' . $rows, $value->qty);
             $sheet->setCellValue('E' . $rows, $value->store);
             $sheet->setCellValue('F' . $rows, $value->date);
             $rows++;
            endforeach;
        $url = "upload/".$fileName;  
        $writer = new Xlsx($spreadsheet);
        $writer->save($url);
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename=' . $fileName);
        readfile( $url );
    }
}
