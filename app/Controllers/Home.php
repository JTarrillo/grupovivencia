<?php

namespace App\Controllers;

use App\Models\MembershipsModel;
use App\Models\CommentsModel;

class Home extends BaseController
{
    public function index()
    {
        //get contable product
        $Memberships = new MembershipsModel();
        //get products
        $params = array(
            "select" => "*",
            "where" => "`contable` = '1' and `active` = '1'",
            "order" => "price ASC",
            "limit" => "12",
        );
        $obj_products = $Memberships->search($params);
        // --- AGREGAR CONSULTA DE COMISIONES INMOBILIARIAS ---
        // --- AGREGAR OBJ_CUSTOMER PARA LA VISTA HEADER ---
    $session = session();
    $id = $session->get('id');
    error_log('HOME PANEL: Usuario logueado con id=' . ($id ?? 'NO SETEADO'));
        $obj_customer = null;
        if ($id) {
            $CustomerModel = new \App\Models\CustomerModel();
            // Usamos get_all_data para obtener todos los datos relevantes del usuario
            $obj_customer = $CustomerModel->get_all_data($id);
            // Si no existe, inicializamos vacío
            if (!$obj_customer) {
                $obj_customer = (object)[
                    'code' => '',
                    'avatar' => '',
                    'id' => $id,
                    'active' => '1',
                    'dni' => '',
                    'total_team' => 0,
                    'total_referred' => 0
                ];
            }
        } else {
            $obj_customer = (object)[
                'code' => '',
                'avatar' => '',
                'id' => 0,
                'active' => '1',
                'dni' => '',
                'total_team' => 0,
                'total_referred' => 0
            ];
        }
        $total_periodo = 0;
        $total_disponible = 0;
        $obj_commissions = [];
        if ($id) {
            $db = \Config\Database::connect();
            // Total de comisiones aprobadas o pagadas
            $total_periodo = $db->table('comisiones_inmobiliarias')
                ->selectSum('monto')
                ->where('beneficiario_id', $id)
                ->whereIn('estado', ['aprobada', 'pagada'])
                ->get()->getRow()->monto ?? 0;

            // Total disponible (ajusta según lógica de retiros si aplica)
            // Para el nuevo sistema, usamos el balance de los informes aprobados:
            $CommissionReport = new \App\Models\CommissionReportModel();
            $total_disponible = $CommissionReport->getApprovedBalanceByCustomer($id);

            // Historial de comisiones solo con venta_id
            $builder = $db->table('comisiones_inmobiliarias');
            $builder->select('*');
            $builder->where('beneficiario_id', $id);
            $builder->orderBy('id', 'DESC');
            $obj_commissions = $builder->get()->getResult();

            // Log para depuración
            error_log('HOME DEBUG: id=' . $id . ' total_periodo=' . $total_periodo . ' total_disponible=' . $total_disponible . ' comisiones=' . count($obj_commissions));
            if (!empty($obj_commissions)) {
                error_log('HOME DEBUG: Primer registro=' . print_r($obj_commissions[0], true));
            }
        }
        // --- FIN CONSULTA DE COMISIONES ---
        // --- CONSULTA DE LOTES ASIGNADOS Y LOTES CON CONTRATO ---
        $total_lotes_asignados = 0;
        $total_lotes_contrato = 0;
        if ($id) {
            $LotModel = new \App\Models\LotModel();
            $total_lotes_asignados = $LotModel
                ->where('customer_id', $id)
                ->countAllResults();
            // Lotes con contrato
            if (method_exists($LotModel, 'countLotsWithContract')) {
                $total_lotes_contrato = $LotModel->countLotsWithContract($id);
            }

            $db = \Config\Database::connect();
            $obj_contracts = $db->table('contracts')
                ->select('contracts.*, lots.lot_number as lot_name, lots.block as block_name, projects.name as project_name')
                ->join('lots', 'lots.id = contracts.lot_id', 'left')
                ->join('projects', 'projects.id = lots.project_id', 'left')
                ->where('contracts.customer_id', $id)
                ->orderBy('contracts.id', 'DESC')
                ->limit(5)
                ->get()
                ->getResultArray();
        } else {
            $obj_contracts = [];
        }

        //send
        $cart_count = 0; // Puedes cambiar la lógica según tu sistema de carrito
        $code_period = ""; // Puedes cambiar la lógica según tu sistema de periodos
        $total_team_active = 0; // Puedes cambiar la lógica según tu sistema
        $dataPeriod = (object)[
            'begin' => date('Y-m-01'),
            'end' => date('Y-m-t')
        ];
        $data = [
            "obj_products" => $obj_products,
            "total_periodo" => $total_periodo,
            "total_disponible" => $total_disponible,
            "obj_commissions" => $obj_commissions,
            "obj_customer" => $obj_customer,
            "title" => "Panel principal",
            "cart_count" => $cart_count,
            "code_period" => $code_period,
            "total_team_active" => $total_team_active,
            "dataPeriod" => $dataPeriod,
            "total_lotes_asignados" => $total_lotes_asignados,
            "total_lotes_contrato" => $total_lotes_contrato,
            "obj_contracts" => $obj_contracts
        ];
        // Crear log de datos enviados al home
        $logData = [
            'datetime' => date('Y-m-d H:i:s'),
            'customer_id' => $id,
            'data' => $data
        ];
        $logFile = WRITEPATH . 'logs/home_' . $id . '_' . date('Ymd_His') . '.log';
        file_put_contents($logFile, json_encode($logData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        //view
        return view('backoffice_new/home', $data);
    }

    public function about()
    {
        //get contable product
        $Memberships = new MembershipsModel();
        //get products footer
        $params = array(
            "select" => "*",
            "where" => "`contable` = '1' and `active` = '1'",
            "order" => "price ASC",
            "limit" => "12",
        );
        $obj_products = $Memberships->search($params);
        //send
        $data = [
            "obj_products" => $obj_products
        ];

        return view('about', $data);
    }

    public function products()
    {   
        //get contable products
        $Memberships = new MembershipsModel();
        //Check if a search exists
        $search = $this->request->getGet('search');

        if ($search !== null) {
            $params = array(
                "select" => "*",
                "where" => "name like '%$search%' and `active` = '1' and `contable` = '1'",
                "order" => "id DESC",
            );
            $obj_products = $Memberships->search($params);
        } else {
            $params = array(
                "select" => "*",
                "where" => "`active` = '1' and `contable` = '1'",
                "order" => "id DESC",
            );
            $obj_products = $Memberships->search($params);
        }

        $data = [
            "obj_products" => $obj_products,
            "search" => $search
        ];
        //view
        return view('product', $data);
    }

    public function product_detail($slug = null)
    {
        //get data Membership
        $Memberships = new MembershipsModel();
        //get product detail
        $params = array(
            "select" => "*",
            "where" => "slug = '$slug'",
        );
        $obj_product = $Memberships->get_search_row($params);
        //get product related
        $params = array(
            "select" => "*",
            "where" => "slug <> '$slug' and active = '1' and `contable` = '1'",
        );
        $data_related_products = $Memberships->search($params);
        //send
        $data = [
            "obj_product" => $obj_product,
            "data_related_products" => $data_related_products
        ];
        //view
        return view('product_detail', $data);
    }

    public function contact()
    {
        //get contable product
        $Memberships = new MembershipsModel();
        //get products footer
        $params = array(
            "select" => "*",
            "where" => "`contable` = '1' and `active` = '1'",
            "order" => "price ASC",
            "limit" => "12",
        );
        $obj_products = $Memberships->search($params);
        //send
        $data = [
            "obj_products" => $obj_products
        ];

        return view('contact', $data);
    }

    /**
     * Método para mostrar landing page de VIVELAND
     */
    public function viveland()
    {
        return view('landing/viveland_new');
    }

    /**
     * Método para mostrar página "Sobre el Evento"
     */
    public function about_evento()
    {
        return view('landing/about-evento');
    }

    public function validate_captcha()
    {
        define("SECRET_KEY", '6Lcq3ZspAAAAAFiqoPbo368dc_XxMz6971uKQY_C');
        $token = $_POST['token'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => SECRET_KEY, 'response' => $token)));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $arrResponse = json_decode($response, true);

        if ($arrResponse["success"] == '1' && $arrResponse["score"] >= 0.5) {
            $data = array("success" => 1, "message" => "Token reCAPTCHA válido.");
        } else {
            $data = array("success" => 0, "message" => "Error en la verificación del reCAPTCHA.");
        }

        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function send_messages()
    {
        $Comments = new CommentsModel();
        //get data post
        $obj_comments = service('request')->getPost();
        //set param
        $param = [
            "name" => $obj_comments['name'],
            "email" => $obj_comments['email'],
            "phone" => $obj_comments['phone'],
            "subject" => $obj_comments['subject'],
            "comment" => $obj_comments['comment'],
            "date" => date("Y-m-d H:i:s"),
            "active" => '1',
            "created_at" => date("Y-m-d H:i:s")
        ];
        $result = $Comments->insertar($param);
        //verify
        if (!is_null($result)) {
            $data['status'] = true;
        } else {
            $data['status'] = false;
        }
        echo json_encode($data);
    }

    public function otras()
    {
        //get contable product
        $Memberships = new MembershipsModel();
        //get products footer
        $params = array(
            "select" => "*",
            "where" => "`contable` = '1' and `active` = '1'",
            "order" => "price ASC",
            "limit" => "12",
        );
        $obj_products = $Memberships->search($params);
        //send
        $data = [
            "obj_products" => $obj_products
        ];

        return view('404', $data);
    }

    public function validate_username()
    {
        if ($this->request->isAJAX()) {
            //SELECT ID FROM CUSTOMER
            $res = service('request')->getPost();
            $username = $res['username'];
            //search username
            $db = \Config\Database::connect();
            $customer = $db->query("SELECT count(customer_id) as total_customer FROM (`customer`) WHERE username = '$username'")->getResult();
            $result = $customer[0]->total_customer;
            if ($result > 0) {
                $data['message'] = "true";
                $data['print'] = "No esta disponible! <i class='fa fa-times-circle-o' aria-hidden='true'></i>";
            } else {
                $data['message'] = "false";
                $data['print'] = "Usuario Disponible! <i class='fa fa-check-square-o' aria-hidden='true'></i>";
            }
            echo json_encode($data);
            exit();
        }
    }

    public function terminos()
    {
        return view('term');
    }

    public function policy()
    {
        return view('policy');
    }
    public function faq()
    {
        return view('faq');
    }

    public function logout()
    {
        $session = session();
        //$session->sess_destroy();
        $ses_data = [
            'id' => '',
            'name' => '',
            'email' => '',
            'username' => '',
            'isLoggedIn' => FALSE
        ];
        $session->set($ses_data);
        return redirect()->to('/');
    }

    public function adm_logout()
    {
        $session = session();
        //$session->sess_destroy();
        $ses_data = [
            'id' => '',
            'name' => '',
            'email' => '',
            'username' => '',
            'isLoggedIn' => FALSE
        ];
        $session->set($ses_data);
        return redirect()->to('/admin');
    }
}