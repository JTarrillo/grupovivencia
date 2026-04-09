<?php

namespace App\Controllers;

use App\Libraries\Evox;
use App\Models\CustomerModel;
use App\Models\CommissionsModel;
use App\Models\Pay_commissionModel;
use App\Models\RangesModel;
use App\Models\StoreModel;
use App\Models\InvoicesModel;
use App\Models\PaysModel;
use App\Models\PeriodModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class D_report extends BaseController
{
    public function index()
    {
        $obj_customer = null;
        $range_id = null;
        $active = null;
        $style = "disabled";
        $first_day = date('Y-m-01');
        $last_day = date('Y-m-t');
        //verify method post
        if ($_POST) {
            $res = service('request')->getPost();
            $daterange = $res['daterange'];
            $range_id = $res['range_id'];
            $active = $res['active'];
            $explode_ragen = explode(' - ', $daterange);
            $first_day = $explode_ragen[0];
            $last_day = $explode_ragen[1];
            //set var
            $where_range_id = "";
            $where_active = "";
            //make query
            $where_date = " and customers.date >= '$first_day' and customers.date <= '$last_day'";
            if ($range_id) {
                $where_range_id = " and customers.range_id = '$range_id'";
            }
            if ($active || $active == '0') {
                $where_active = " and customers.active = '$active'";
            }
            $where = "countries.id_idioma = 7" . $where_date . $where_range_id . $where_active . "";
            //get data customer by filters
            $Customer = new CustomerModel();
            $obj_customer = $Customer->get_customer_by_export($where);
            //style boton export
            $style = "";
        }
        //get data session
        $session_name = $_SESSION['admin_name'] . " " . $_SESSION['admin_lastname'];
        //get all range
        $Ranges = new RangesModel();
        $obj_ranges = $Ranges->get_all_crud();
        //send
        $data = array(
            'obj_customer' => $obj_customer,
            'obj_ranges' => $obj_ranges,
            'session_name' => $session_name,
            'first_day' => $first_day,
            'last_day' => $last_day,
            'style' => $style,
            'range_id' => $range_id,
            'active' => $active,
        );
        return view('admin/reportes/clientes', $data);
    }

    public function export_clientes()
    {
        //get data post
        $res = service('request')->getPost();
        $daterange = $res['daterange'];
        $range_id = $res['range_id'];
        $active = $res['active'];
        //make query date
        $explode_ragen = explode(' - ', $daterange);
        $date_begin = $explode_ragen[0];
        $date_end = $explode_ragen[1];
        //set var
        $where_range_id = "";
        $where_active = "";
        //make query
        $where_date = " and customers.date >= '$date_begin' and customers.date <= '$date_end'";
        if ($range_id) {
            $where_range_id = " and customers.range_id = '$range_id'";
        }
        if ($active || $active == '0') {
            $where_active = " and customers.active = '$active'";
        }
        $where = "countries.id_idioma = 7" . $where_date . $where_range_id . $where_active . "";
        //get data customer by filters
        $Customer = new CustomerModel();
        $obj_customer = $Customer->get_customer_by_export($where);
        $file = "Clientes_" . $date_begin . "_" . $date_end;
        $fileName = $file . '.xlsx';
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'Nombres');
        $sheet->setCellValue('C1', 'Apellidos');
        $sheet->setCellValue('D1', 'Usuario');
        $sheet->setCellValue('E1', 'DNI');
        $sheet->setCellValue('F1', 'E-mail');
        $sheet->setCellValue('G1', 'Rango');
        $sheet->setCellValue('H1', 'País');
        $sheet->setCellValue('I1', 'Patrocinador');
        $sheet->setCellValue('J1', 'Estado');
        $rows = 2;
        foreach ($obj_customer as $value) :
            if ($value->active == '1') {
                $val = "activo";
            } else {
                $val = "inactivo";
            }
            $sheet->setCellValue('A' . $rows, $value->id_customer);
            $sheet->setCellValue('B' . $rows, $value->name);
            $sheet->setCellValue('C' . $rows, $value->lastname);
            $sheet->setCellValue('D' . $rows, $value->code);
            $sheet->setCellValue('E' . $rows, $value->dni);
            $sheet->setCellValue('F' . $rows, $value->email);
            $sheet->setCellValue('G' . $rows, $value->range_name);
            $sheet->setCellValue('H' . $rows, replace_euacutes_vocales($value->nombre));
            $sheet->setCellValue('I' . $rows, $value->sponsor_name);
            $sheet->setCellValue('J' . $rows, $val);
            $rows++;
        endforeach;
        $url = "upload/" . $fileName;
        $writer = new Xlsx($spreadsheet);
        $writer->save($url);
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename=' . $fileName);
        readfile($url);
    }

    public function ventas()
    {
        $obj_invoices = null;
        $store_id = null;
        $payment = null;
        $active = null;
        $style = "disabled";
        $first_day = date('Y-m-01');
        $last_day = date('Y-m-t');
        //verify method post
        if ($_POST) {
            $res = service('request')->getPost();
            $daterange = $res['daterange'];
            $store_id = $res['store_id'];
            $payment = $res['payment'];
            $active = $res['active'];
            //make query date
            $explode_ragen = explode(' - ', $daterange);
            $first_day = $explode_ragen[0];
            $last_day = $explode_ragen[1];
            //sumo 1 día
            $last_day = date("Y-m-d", strtotime($last_day . "+ 1 days"));
            //set var
            $where_store_id = "";
            $where_payment = "";
            $where_active = "";
            //make query
            $where_date = "invoices.date >= '$first_day' and invoices.date < '$last_day'";
            if ($store_id) {
                $where_store_id = " and invoices.store_id = '$store_id'";
            }
            if ($payment) {
                $where_payment = " and invoices.payment = '$payment'";
            }
            if ($active) {
                $where_active = " and invoices.active = '$active'";
            }
            $where = $where_date . $where_store_id . $where_payment . $where_active;
            //get data customer by filters
            $Invoices = new InvoicesModel();
            $obj_invoices = $Invoices->get_data_by_export($where);
            //style boton export
            $style = "";
        }

        //get data session
        $session_name = $_SESSION['admin_name'] . " " . $_SESSION['admin_lastname'];
        //get all range
        $Store = new StoreModel();
        $obj_store = $Store->get_all();
        //send
        $data = array(
            'obj_invoices' => $obj_invoices,
            'obj_store' => $obj_store,
            'session_name' => $session_name,
            'first_day' => $first_day,
            'last_day' => $last_day,
            'style' => $style,
            'store_id' => $store_id,
            'payment' => $payment,
            'active' => $active,
        );
        return view('admin/reportes/ventas', $data);
    }

    public function export_ventas()
    {
        //get data post
        $res = service('request')->getPost();
        $daterange = $res['daterange'];
        $store_id = $res['store_id'];
        $payment = $res['payment'];
        $active = $res['active'];
        //make query date
        $explode_ragen = explode(' - ', $daterange);
        $date_begin = $explode_ragen[0];
        $date_end = $explode_ragen[1];
        //sumo 1 día
        $date_end = date("Y-m-d", strtotime($date_end . "+ 1 days"));
        //set var
        $where_store_id = "";
        $where_payment = "";
        $where_active = "";
        //make query
        $where_date = "invoices.date >= '$date_begin' and invoices.date < '$date_end'";
        if ($store_id) {
            $where_store_id = " and invoices.store_id = '$store_id'";
        }
        if ($payment) {
            $where_payment = " and invoices.payment = '$payment'";
        }
        if ($active) {
            $where_active = " and invoices.active = '$active'";
        }
        $where = $where_date . $where_store_id . $where_payment . $where_active;
        //get data customer by filters
        $Invoices = new InvoicesModel();
        $obj_invoices = $Invoices->get_data_by_export($where);
        $file = "Ventas_" . $date_begin . "_" . $date_end;
        $fileName = $file . '.xlsx';
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'Periodo');
        $sheet->setCellValue('C1', 'Cliente');
        $sheet->setCellValue('D1', 'Usuario');
        $sheet->setCellValue('E1', 'Tipo de Pago');
        $sheet->setCellValue('F1', 'Detalle');
        $sheet->setCellValue('G1', 'Importe');
        $sheet->setCellValue('H1', 'Recojo');
        $sheet->setCellValue('I1', 'Fecha');
        $sheet->setCellValue('J1', 'Estado');
        $rows = 2;
        foreach ($obj_invoices as $value) :
            //payment
            if ($value->payment == '1') {
                $valor = "Monedero";
            } elseif ($value->payment == '2') {
                $valor = "Tarjeta";
            } else {
                $valor = "En Tienda";
            }
            //store
            if ($value->store_name == "Almacén general") {
                $store = $value->store_name;
            } else {
                $store = $value->store_name;
            }

            if ($value->active == '1') {
                $val = "Por Pagar";
            } elseif ($value->active == '2') {
                $val = "Pagado";
            } else {
                $val = "Cancelado";
            }

            $sheet->setCellValue('A' . $rows, $value->id);
            $sheet->setCellValue('B' . $rows, $value->code);
            $sheet->setCellValue('C' . $rows, $value->name . " " . $value->lastname);
            $sheet->setCellValue('D' . $rows, $value->code);
            $sheet->setCellValue('E' . $rows, $valor);
            $sheet->setCellValue('F' . $rows, $value->payment_options);
            $sheet->setCellValue('G' . $rows, $value->amount);
            $sheet->setCellValue('H' . $rows, $store);
            $sheet->setCellValue('I' . $rows, $value->date);
            $sheet->setCellValue('J' . $rows, $val);
            $rows++;
        endforeach;
        $url = "upload/" . $fileName;
        $writer = new Xlsx($spreadsheet);
        $writer->save($url);
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename=' . $fileName);
        readfile($url);
    }

    public function pagos()
    {
        $obj_pagos = null;
        $store_id = null;
        $payment = null;
        $active = null;
        $style = "disabled";
        $first_day = date('Y-m-01');
        $last_day = date('Y-m-t');
        //verify method post
        if ($_POST) {
            $res = service('request')->getPost();
            $daterange = $res['daterange'];
            $active = $res['active'];
            //make query date
            $explode_ragen = explode(' - ', $daterange);
            $first_day = $explode_ragen[0];
            $last_day = $explode_ragen[1];
            //sumo 1 día
            $last_day = date("Y-m-d", strtotime($last_day . "+ 1 days"));
            //set var
            $where_active = "";
            //make query
            $where_date = "`countries`.`id_idioma` = 7 and pays.date >= '$first_day' and pays.date < '$last_day'";
            if ($active) {
                $where_active = " and pays.active = '$active'";
            }
            $where = $where_date . $where_active;
            //get data customer by filters
            $Pays = new PaysModel();
            $obj_pagos = $Pays->get_data_by_export($where);
            //style boton export
            $style = "";
        }
        //get data session
        $session_name = $_SESSION['admin_name'] . " " . $_SESSION['admin_lastname'];
        //send
        $data = array(
            'obj_pagos' => $obj_pagos,
            'session_name' => $session_name,
            'first_day' => $first_day,
            'last_day' => $last_day,
            'style' => $style,
            'active' => $active,
        );
        return view('admin/reportes/pagos', $data);
    }

    public function export_pagos()
    {
        //get data post
        $res = service('request')->getPost();
        $daterange = $res['daterange'];
        $active = $res['active'];
        //make query date
        $explode_ragen = explode(' - ', $daterange);
        $date_begin = $explode_ragen[0];
        $date_end = $explode_ragen[1];
        //sumo 1 día
        $date_end = date("Y-m-d", strtotime($date_end . "+ 1 days"));
        //set var
        $where_active = "";
        //make query
        $where_date = "`countries`.`id_idioma` = 7 and pays.date >= '$date_begin' and pays.date < '$date_end'";
        if ($active) {
            $where_active = " and pays.active = '$active'";
        }
        $where = $where_date . $where_active;
        //get data customer by filters
        $Pays = new PaysModel();
        $obj_pagos = $Pays->get_data_by_export($where);

        $file = "Pagos_" . $date_begin . "_" . $date_end;
        $fileName = $file . '.xlsx';
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'Fecha');
        $sheet->setCellValue('C1', 'Nombres');
        $sheet->setCellValue('D1', 'Apellidos');
        $sheet->setCellValue('E1', 'Usuario');
        $sheet->setCellValue('F1', 'Banco');
        $sheet->setCellValue('G1', 'N Cuenta');
        $sheet->setCellValue('H1', 'CCI');
        $sheet->setCellValue('I1', 'Importe');
        $sheet->setCellValue('J1', 'País');
        $sheet->setCellValue('K1', 'Estado');
        $rows = 2;
        foreach ($obj_pagos as $value) :
            if ($value->active == '1') {
                $val = "En espera";
            } elseif ($value->active == '2') {
                $val = "Procesado";
            } else {
                $val = "Cancelado";
            }
            $sheet->setCellValue('A' . $rows, $value->id);
            $sheet->setCellValue('B' . $rows, $value->date);
            $sheet->setCellValue('C' . $rows, $value->name);
            $sheet->setCellValue('D' . $rows, $value->lastname);
            $sheet->setCellValue('E' . $rows, $value->code);
            $sheet->setCellValue('F' . $rows, $value->bank);
            $sheet->setCellValue('G' . $rows, $value->number);
            $sheet->setCellValue('H' . $rows, $value->cci);
            $sheet->setCellValue('I' . $rows, $value->amount);
            $sheet->setCellValue('J' . $rows, replace_euacutes_vocales($value->pais));
            $sheet->setCellValue('K' . $rows, $val);
            $rows++;
        endforeach;
        $url = "upload/" . $fileName;
        $writer = new Xlsx($spreadsheet);
        $writer->save($url);
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename=' . $fileName);
        readfile($url);
    }

    public function ganancias(){
        $customerModel = new CustomerModel();
        $commissionsModel = new CommissionsModel();
        $Period = new PeriodModel();
        $obj_customer = null;
        $range_id = null;
        $style = null;
        $first_day = date('Y-m-01');
        $last_day = date('Y-m-t');
        $total_commissions = 0;
        $total_commissions_period = 0;
        $total_disponible = 0;
        $buttonStyle = "disabled";

        // Verificar si se envió una solicitud POST
        if ($_POST) {
            $res = service('request')->getPost();
            //get data by post
            $search_type = $res['search_type']; //search type
            $search_term = $res['search_term']; // value search

            if (!empty($search_term) && in_array($search_type, ['dni', 'code'])) {
                // Realizar la búsqueda en el modelo CustomerModel según el tipo de búsqueda
                switch ($search_type) {
                    case 'dni':
                        // Remove the line that calls the get_data_by_dni method
                        $obj_customer = $customerModel->get_search_by_dni($search_term);
                        break;
                    case 'code':
                        $obj_customer = $customerModel->get_search_by_username($search_term);
                        break;
                }

                // Verificar si se encontró un cliente
                if ($obj_customer) {

                    //$total_commissions = $commissionsModel->commission_by_period($obj_customer->id, $begin, $end);

                    $evox = new Evox();
                    //call Evox Library , get data Commissions by period
                    $result = $evox->get_commission_by_period_id($obj_customer->id);


                    $total_disponible = $result->total_disponible;

                    $total_commissions = $result->total_comissions;

                    $style = "";

                    $buttonStyle = "";

                }
            }

        }

        //get all period
        $param = array(
             "select" => "id , begin, end, code",
             "order" => "id DESC"
        );
        $periodData = $Period->search($param);
    
        // Obtener datos de sesión
        $session_name = $_SESSION['admin_name'] . " " . $_SESSION['admin_lastname'];
        $data = array(
            'obj_customer' => $obj_customer,
            'period_id' => $period_id ?? null,
            'buttonStyle' => $buttonStyle,
            'search_type' => $search_type ?? null,
            'search_term' => $search_term ?? null,
            'periodData' => $periodData,
            'session_name' => $session_name,
            'first_day' => $first_day,
            'last_day' => $last_day,
            'style' => $style,
            'range_id' => $range_id,
            'total_commissions' => $total_commissions,
            'total_disponible' => $total_disponible,
            'total_commissions_period' => $total_commissions_period,
        );
        // Cargar la vista correspondiente con los datos preparados
        return view('admin/reportes/ganancias', $data);
    }

    public function ganancias_discount()
    {
        // Lógica para la función ganancias_discount
        if ($this->request->isAJAX()) {

            //get data post

            $res = service('request')->getPost();

            $id = $res['id'];
            $amount = $res['amount'];

            //verify ID
            if (!empty($id) && is_numeric($amount) && $amount > 0) {

                $Pay = new PaysModel();
                //insert table pay
                $param = array(
                    'customer_id' => $id,
                    'amount' => $amount,
                    'discount' => 0,
                    'bank' => "",
                    'number' => "",
                    'cci' => "",
                    'total' => $amount,
                    'active' => '2',
                    'date' => date("Y-m-d H:i:s")
                );
                $pay_id = $Pay->insertar($param);

                $evox = new Evox();
                //call Evox Library , get data Commissions by period
                $period = $evox->get_period();
                //get current period
                $first_month_day = $period->begin;
                //- 1 day (that the discount be in the previous period (set date of previous period))
                $date_period = restar_dias_date_con_fecha(1, $first_month_day);
                //insert commission table
                $Commissions = new CommissionsModel();
                $param2 = array(
                    'customer_id' => $id,
                    'bonus_id' => 8, //withdrawal
                    'amount' => -$amount,
                    'date' => $date_period,
                    'date_shop' => date("Y-m-d H:i:s"),
                    'active' => '2',
                );
                $commissions_id = $Commissions->insertar($param2);
                //insert table pay comission
                $Pay_commission = new Pay_commissionModel();
                $param_commissions = array(
                    'pay_id' => $pay_id,
                    'commissions_id' => $commissions_id,
                    'date' => date("Y-m-d"),
                    'active' => '1'
                );
                $result = $Pay_commission->insertar($param_commissions);
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

    public function export_ganancias()
    {
        // Obtener datos del formulario
        $res = service('request')->getPost();
        $daterange = $res['daterange'];
        $range_id = $res['range_id'];
        $active = $res['active'];
    
        // Dividir el rango de fechas en dos partes
        $explode_ragen = explode(' - ', $daterange);
        $date_begin = $explode_ragen[0];
        $date_end = $explode_ragen[1];
    
        // Variables para las condiciones de la consulta
        $where_range_id = "";
        $where_active = "";
    
        // Construir la parte de la consulta relacionada con las fechas
        $where_date = " and pays.date >= '$date_begin' and pays.date <= '$date_end'";
    
        // Agregar condiciones adicionales según los filtros seleccionados
        if ($range_id) {
            $where_range_id = " and customers.range_id = '$range_id'";
        }
        if ($active || $active == '0') {
            $where_active = " and pays.active = '$active'";
        }
    
        // Combinar todas las condiciones WHERE
        $where = "countries.id_idioma = 7" . $where_date . $where_range_id . $where_active;
    
        // Obtener los datos de los pagos filtrados
        $Pays = new PaysModel();
        $obj_pagos = $Pays->get_data_by_export($where);
    
        // Crear nombre de archivo
        $file = "Ganancias_" . $date_begin . "_" . $date_end;
        $fileName = $file . '.xlsx';
    
        // Crear nuevo archivo de Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Fecha');
        $sheet->setCellValue('C1', 'Usuario');
        $sheet->setCellValue('D1', 'Banco');
        $sheet->setCellValue('E1', 'N° de Cuenta');
        $sheet->setCellValue('F1', 'CCI');
        $sheet->setCellValue('G1', 'Importe');
        $sheet->setCellValue('H1', 'País');
        $sheet->setCellValue('I1', 'Estado');
    
        // Llenar el archivo Excel con los datos de los pagos
        $rows = 2;
        foreach ($obj_pagos as $value) {
            $sheet->setCellValue('A' . $rows, $value->id);
            $sheet->setCellValue('B' . $rows, $value->date);
            $sheet->setCellValue('C' . $rows, $value->code);
            $sheet->setCellValue('D' . $rows, $value->bank);
            $sheet->setCellValue('E' . $rows, $value->number);
            $sheet->setCellValue('F' . $rows, $value->cci);
            $sheet->setCellValue('G' . $rows, $value->amount);
            $sheet->setCellValue('H' . $rows, $value->pais);
            $sheet->setCellValue('I' . $rows, $value->active == '1' ? 'En espera' : ($value->active == '2' ? 'Pagado' : 'Cancelado'));
            $rows++;
        }
    
        // Guardar el archivo Excel en el servidor
        $url = "upload/" . $fileName;
        $writer = new Xlsx($spreadsheet);
        $writer->save($url);
    
        // Descargar el archivo Excel
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename=' . $fileName);
        readfile($url);
    }     
}
