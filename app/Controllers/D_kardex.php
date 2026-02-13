<?php

namespace App\Controllers;

use App\Models\IncomingModel;
use App\Models\MembershipsModel;
use App\Models\StoreModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class D_kardex extends BaseController
{
    public function index()
    {
        $Incoming = new IncomingModel();
        $Memberships = new MembershipsModel();
        $style = "disabled";
        //get data session
        $session_name = $_SESSION['first_name'] . " " . $_SESSION['last_name'];
        $first_day = date('Y-m-01');
        $last_day = date('Y-m-t');
        //plus +1 day
        $last_day = strtotime('+1 day', strtotime($last_day));
        $last_day = date('Y-m-d', $last_day);
        $membership_id = null;
        $where_membership_id = null;
        if($_POST){
            $res = service('request')->getPost();
            $daterange = $res['daterange'];
            $membership_id = $res['membership_id'];
            //make query date
            $explode_ragen = explode(' - ', $daterange);
            $first_day = $explode_ragen[0];
            $last_day = $explode_ragen[1];
            $last_day = strtotime('+1 day', strtotime($last_day));
            $last_day = date('Y-m-d', $last_day);
            //set var
            //make query
            $where = "date >= '$first_day' and date < '$last_day'";
            if($membership_id){
                $where_membership_id = " and membership_id = $membership_id";
            }
            $where = "$where"."$where_membership_id";
            //get data customer by filters
            $obj_kardex = $Incoming->get_kardex_by_export($where);
            //style boton export
            $style = "";
        }else{
            //get data incoming
            $Incoming = new IncomingModel();
            $obj_kardex = $Incoming->get_kardex($first_day, $last_day);
        }
        //get all product
        $obj_membership = $Memberships->get_all_countable();
        //send
        $data = array(
            'obj_kardex' => $obj_kardex,
            'obj_membership' => $obj_membership,
            'style' => $style,
            'first_day' => $first_day,
            'last_day' => $last_day,
            'membership_id' => $membership_id,
            'session_name' => $session_name
        );
        return view('admin/entradas/kardex', $data);
    }

    public function inventario()
    {
        $Incoming = new IncomingModel();
        $Memberships = new MembershipsModel();
        $Store = new StoreModel();
        $style = "disabled";
        //get data session
        $session_name = $_SESSION['first_name'] . " " . $_SESSION['last_name'];
        $first_day = date('Y-m-01');
        $last_day = date('Y-m-t');
        //plus +1 day
        $last_day = strtotime('+1 day', strtotime($last_day));
        $last_day = date('Y-m-d', $last_day);
        $store_id = null;
        $where = null;
        if($_POST){
            $res = service('request')->getPost();
            $store_id = $res['store_id'];
            if($store_id){
                $where = " and store_id = $store_id";
            }
            //get data customer by filters
            $obj_stock = $Memberships->get_all_product_stock_export($where);
            //style boton export
            $style = "";
        }else{
            //get data incoming
            $obj_stock = $Memberships->get_all_product_stock();
        }
        //get store active
        $obj_store = $Store->get_all_active();
        
        $data = array(
            'obj_stock' => $obj_stock,
            'obj_store' => $obj_store,
            'style' => $style,
            'first_day' => $first_day,
            'last_day' => $last_day,
            'store_id' => $store_id,
            'session_name' => $session_name
        );
        return view('admin/entradas/inventario', $data);
    }

    

    public function export()
    {
        $Incoming = new IncomingModel();
        //get data post
        $res = service('request')->getPost();
        $daterange = $res['daterange'];
        $membership_id = $res['membership_id'];
        //make query date
        $explode_ragen = explode(' - ', $daterange);
        $date_begin = $explode_ragen[0];
        $date_end1 = $explode_ragen[1];
        $date_end = strtotime('+1 day', strtotime($date_end1));
        $date_end = date('Y-m-d', $date_end);
        $where_membership_id = null;
        //make query
        $where = "date >= '$date_begin' and date < '$date_end'";
        if($membership_id){
            $where_membership_id = " and membership_id = $membership_id";
        }
        $where = "$where"."$where_membership_id";
        //get data customer by filters
        $obj_incoming = $Incoming->get_kardex_by_export($where);
        $file = "Kardex_".$date_begin."_".$date_end1;
        $fileName = $file.'.xlsx';  
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Referencia');
        $sheet->setCellValue('B1', 'Fecha');
        $sheet->setCellValue('C1', 'Concepto');
        $sheet->setCellValue('D1', 'Producto');
        $sheet->setCellValue('E1', 'Locación');
        $sheet->setCellValue('F1', 'Cantidad');
        $sheet->setCellValue('G1', 'Costo Unitario');
        $sheet->setCellValue('H1', 'Costo Total');
        $rows = 2;
        foreach ($obj_incoming as $value): 
             $sheet->setCellValue('A' . $rows, $value->id);
             $sheet->setCellValue('B' . $rows, $value->date);
             $sheet->setCellValue('C' . $rows, $value->concept);
             $sheet->setCellValue('D' . $rows, $value->membership);
             $sheet->setCellValue('E' . $rows, $value->store);
             $sheet->setCellValue('F' . $rows, $value->qty);
             $sheet->setCellValue('G' . $rows, $value->unit_cost);
             $sheet->setCellValue('H' . $rows, $value->total_cost);
             $rows++;
            endforeach;
        $url = "upload/".$fileName;  
        $writer = new Xlsx($spreadsheet);
        $writer->save($url);
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename=' . $fileName);
        readfile( $url );
    }

    public function inventario_export()
    {
        $Memberships = new MembershipsModel();
        //get data post
        $res = service('request')->getPost();
        $store_id = $res['store_id'];
        if($store_id == 1){
            $name = "Almacen-general";
        }elseif($store_id == 2){
            $name = "Oficina-olivos";
        }else{
            $name = "Todos-almacenes";
        }
        //make query date
        //make query
        $where = null;
        if($store_id){
            $where = " and store_id = $store_id";
        }
        //get data customer by filters
        $obj_stock = $Memberships->get_all_product_stock_export($where);
        $file = "Inventario".$name;
        $fileName = $file.'.xlsx';  
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Descripcion');
        $sheet->setCellValue('C1', 'Ingresos');
        $sheet->setCellValue('D1', 'Salidas');
        $sheet->setCellValue('E1', 'Disponible');
        $rows = 2;
        foreach ($obj_stock as $value): 
             $sheet->setCellValue('A' . $rows, $value->id_2);
             $sheet->setCellValue('B' . $rows, $value->name);
             $sheet->setCellValue('C' . $rows, $value->total_incoming);
             $sheet->setCellValue('D' . $rows, $value->total_outgoing);
             $sheet->setCellValue('E' . $rows, $value->balance);
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
