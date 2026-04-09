<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\UnilevelsModel;
use App\Models\CalificationModel;
use App\Models\InvoicesModel;
use App\Models\StoreModel;
use App\Models\CountriesModel;
use App\Models\Invoice_detail_membershipModel;
use App\Models\MembershipsModel;
use App\Controllers\B_home;


class D_panel extends BaseController
{
    public function index()
    {
        //get data session
        $id = $_SESSION['admin_id'];
        $session_name = $_SESSION['admin_name'] . " " . $_SESSION['admin_lastname'];
        //get data invoices by customer
        $Customer = new CustomerModel();
        //get year
        $today = date("Y-m-d");
        $month = date("m");
        $year = date("Y");
        $new_year = date('Y', strtotime('+1 year', strtotime($year)));
        $first_month = first_month_day($month, $year);
        
        $ene = last_month_day('01', $year);
        $feb = last_month_day('02', $year);
        $mar = last_month_day('03', $year);
        $abr = last_month_day('04', $year);
        $may = last_month_day('05', $year);
        $jun = last_month_day('06', $year);
        $jul = last_month_day('07', $year);
        $ago = last_month_day('08', $year);
        $set = last_month_day('09', $year);
        $oct = last_month_day('10', $year);
        $nov = last_month_day('11', $year);
        $dic = last_month_day('12', $year);

        $obj_pending = $Customer->get_all_panel($year, $first_month, $today, $ene, $feb, $mar, $abr ,$may, $jun, $jul, $ago, $set, $oct, $nov, $dic);
        //get data
        $data = array(
            'obj_pending' => $obj_pending,
            'session_name' => $session_name
        );
        return view('admin/panel', $data);
    }

      // POST: Actualizar cliente existente
    public function updateCustomer()
    {
    $request = service('request');
    if ($request->getMethod() === 'post') {
    $data = $request->getPost();
    $Customer = new CustomerModel();
    if (!empty($data['customer_id'])) {
    $updateData = [
    'name' => $data['name'] ?? null,
    'lastname' => $data['lastname'] ?? null,
    'dni' => $data['dni'] ?? null,
    'email' => $data['email'] ?? null,
    'phone' => $data['phone'] ?? null,
    'address' => $data['address'] ?? null,
    'country_id' => $data['country_id'] ?? null,
    'civil_status' => $data['civil_status'] ?? null,
    'tipo_agente' => $data['tipo_agente'] ?? null,
    'active' => $data['active'] ?? null,
    ];
    // Solo actualizar contraseña si se proporciona
    if (!empty($data['password'])) {
    $updateData['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    }
    $Customer->update($data['customer_id'], $updateData);
    return redirect()->to('/dashboard/clientes')->with('msg', 'Cliente actualizado correctamente.');
    } else {
    return redirect()->back()->with('msg', 'ID de cliente no proporcionado.');
    }
    }
    return redirect()->back();
    }
    // ...otros métodos...

    // POST: Registrar nuevo agente/afiliado para gestión inmobiliaria
    public function postNewCustomer()
    {
        $request = service('request');
        if ($request->getMethod() === 'post') {
            $data = $request->getPost();
            $Customer = new CustomerModel();
            $Unilevels = new UnilevelsModel();
            // Validar que el patrocinador no sea el mismo (por seguridad)
            if (!empty($data['sponsor_id']) && !empty($data['dni'])) {
                // Verificar si ya existe un cliente con ese DNI
                $existing = $Customer->where('dni', $data['dni'])->first();
                if ($existing) {
                    return redirect()->back()->with('msg', 'Ya existe un cliente con ese DNI.');
                }
                // Crear nuevo cliente
                $customerData = [
                    'name' => $data['name'],
                    'lastname' => $data['lastname'],
                    'mother_last' => $data['motherLast'],
                    'dni' => $data['dni'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'address' => $data['address'],
                    'country_id' => $data['country_id'],
                    'password' => password_hash($data['password'], PASSWORD_DEFAULT),
                    'tipo_agente' => 'externo', // O ajusta según lógica
                    'active' => '1',
                ];
                $customer_id = $Customer->insert($customerData, true);
                // No permitir que el patrocinador sea el mismo
                if ($customer_id && $customer_id != $data['sponsor_id']) {
                    // Crear relación en unilevels
                    $Unilevels->insert([
                        'customer_id' => $customer_id,
                        'sponsor_id' => $data['sponsor_id'],
                        'active' => '1',
                    ]);
                    return redirect()->to('/dashboard/clientes')->with('msg', 'Agente registrado correctamente.');
                } else {
                    // Si el patrocinador es el mismo
                    $Customer->delete($customer_id);
                    return redirect()->back()->with('msg', 'El patrocinador no puede ser el mismo nuevo agente.');
                }
            } else {
                return redirect()->back()->with('msg', 'Datos incompletos.');
            }
        }
        return redirect()->back();
    }
    // ...otros métodos...

    public function estructura($id = null)
    {
        // ...existing code...
    {
        //verify method post
        $res = service('request')->getPost();
        if ($res) {
            $search = $res['search'];
            $search_explo = explode(" (", $search);
            $code = $search_explo[0];

            //get data by username
            $Customer = new CustomerModel();
            $obj_customer = $Customer->get_data_code($code);

            if ($obj_customer) {
                $id = $obj_customer->id;
            } else {
                $id = 1;
            }
        } else {
            if (is_null($id)) {
                $id = 1;
            }
        }

        //get data session
        $session_name = '';
        if (isset($_SESSION['admin_name']) && isset($_SESSION['admin_lastname'])) {
            $session_name = $_SESSION['admin_name'] . " " . $_SESSION['admin_lastname'];
        } elseif (isset($_SESSION['admin_name'])) {
            $session_name = $_SESSION['admin_name'];
        } else {
            $session_name = 'Usuario';
        }
        //set var
        $customer_id_n2 = "";
        $customer_id_n3 = "";
        $obj_customer_n3 = "";
        $obj_customer_n4 = "";
        //get dat 1 -31
        $day = date("j");
        $year = date("Y");
        $month = date("m");

        //get period
        $period = period();
        $Unilevel = new UnilevelsModel();
        $Customer = new CustomerModel();

        // Get root customer (level 1) con datos completos (incluye range_img, range_name, etc)
        $period = period();
        $obj_customer = $Customer->get_data_customer_range($id, $period['first_month_day'], $period['last_month_day']);
        if ($obj_customer) {
            $full_customer = $Customer->get_data_by_id($id);
            $obj_customer->tipo_agente = $full_customer->tipo_agente ?? null;
            $obj_customer->inscripcion_vigente = $Customer->isInscripcionVigente($obj_customer->id);
            $obj_customer->active = $full_customer->active ?? null;
            $obj_customer->point_personal = $full_customer->point_personal ?? 0;
            $obj_customer->point_grupal = $full_customer->point_grupal ?? 0;
            $obj_customer->pais_img = $full_customer->pais_img ?? null;
            // Asegurar que la propiedad dni esté presente
            $obj_customer->dni = $full_customer->dni ?? null;
            // Refuerzo: si falta range_img, lo consultamos directo
            if (!isset($obj_customer->range_img) || empty($obj_customer->range_img)) {
                $range = $Customer->db->query('SELECT img FROM ranges WHERE id = ?', [$obj_customer->range_id])->getRow();
                $obj_customer->range_img = $range ? $range->img : null;
            }
        }

        //get partner level 2 (direct referrals)
        // Forzar sponsor_id 28 para depuración
        $obj_customer_n2 = $Unilevel->get_partners_by_level(28, $period['first_month_day'], $period['last_month_day']);
        // Enrich each level 2 agent with tipo_agente and inscripcion_vigente
        if ($obj_customer_n2) {
            foreach ($obj_customer_n2 as $key => $value) {
                $full_customer = $Customer->get_data_by_id($value->customer_id2);
                $value->tipo_agente = $full_customer->tipo_agente ?? null;
                $value->inscripcion_vigente = $Customer->isInscripcionVigente($value->customer_id2);
                $customer_id_n2 .= $value->customer_id2 . ",";
            }
            //DELETE LAST CARACTER ON STRING
            $customer_id_n2 = substr($customer_id_n2, 0, strlen($customer_id_n2) - 1);
            if ($customer_id_n2) {
                //get data level 3
                $obj_customer_n3 = $Unilevel->get_partners_in_level($customer_id_n2, $period['first_month_day'], $period['last_month_day']);
                // Enrich each level 3 agent if needed (optional, for future use)
                if ($obj_customer_n3) {
                    foreach ($obj_customer_n3 as $key => $value) {
                        $full_customer = $Customer->get_data_by_id($value->customer_id2);
                        $value->tipo_agente = $full_customer->tipo_agente ?? null;
                        $value->inscripcion_vigente = $Customer->isInscripcionVigente($value->customer_id2);
                        $customer_id_n3 .= $value->customer_id2 . ",";
                    }
                    //DELETE LAST CARACTER ON STRING
                    $customer_id_n3 = substr($customer_id_n3, 0, strlen($customer_id_n3) - 1);
                    //get data level 4
                    $obj_customer_n4 = $Unilevel->get_partners_in_level($customer_id_n3, $period['first_month_day'], $period['last_month_day']);
                }
            }
        }

        //get data customer active
        $obj_customer_button_search = $Customer->get_data_button_search();

        //send
        $data = array(
            'session_name' => $session_name,
            'obj_customer' => $obj_customer,
            'obj_customer_n2' => $obj_customer_n2,
            'obj_customer_n3' => $obj_customer_n3,
            'obj_customer_n4' => $obj_customer_n4,
            'id' => $id,
            'obj_customer_button_search' => $obj_customer_button_search,
        );
        return view('admin/structure', $data);
    }
    }
    public function nuevo_socio($id = null)
    {
        $Paises = new CountriesModel();
        //get data session
        $session_name = '';
        if (isset($_SESSION['admin_name']) && isset($_SESSION['admin_lastname'])) {
            $session_name = $_SESSION['admin_name'] . " " . $_SESSION['admin_lastname'];
        } elseif (isset($_SESSION['admin_name'])) {
            $session_name = $_SESSION['admin_name'];
        } else {
            $session_name = 'Usuario';
        }
        //get patrocinador correcto
        $Customer = new CustomerModel();
        if ($id) {
            $obj_customer = $Customer->get_data_by_id($id);
        } else if (isset($_SESSION['admin_id'])) {
            $obj_customer = $Customer->get_data_by_id($_SESSION['admin_id']);
        } else {
            $obj_customer = null;
        }
        //get all paises
        $obj_paises = $Paises->get_data();
        //get all sponsors (clientes activos) como objetos
        $obj_sponsors = $Customer->where('active', 1)->asObject()->findAll();

        //set var
        $data = array(
            'session_name' => $session_name,
            'obj_customer' => $obj_customer,
            'obj_paises' => $obj_paises,
            'obj_sponsors' => $obj_sponsors
        );
        return view('admin/new_customer', $data);
    }

    public function ventas()
    {
        $Invoices = new InvoicesModel();
        $Store = new StoreModel();
        $obj_invoices = null;
        $store_id = null;
        $payment = null;
        $active = null;
        $today = date('Y-m-d');
        $first_day = date('Y-m-01');
        $last_day = date('Y-m-t');
        $where_store_id = "";
        $where_payment = "";
        $date_id = '1';

        $year = date("Y");
        $month = date("m");
        $date_start = "$year-$month-01";
        $date_end = "$year-$month-31";

        //verify method post
        if ($_POST) {
            $res = service('request')->getPost();
            $date_id = $res['date'];

            $daterange = $res['daterange'];
            $explode_ragen = explode(' - ', $daterange);
            $date_start = $explode_ragen[0];
            $date_end = $explode_ragen[1];

            if ($date_id == '1') {
                //today
                $date = date('Y-m-d');
                //make where
                $where_date = "invoices.date >= '$date_start 00:00:00' and invoices.date < '$date_end 23:59:59' and invoices.active = '2'";
            } elseif ($date_id == '2') {
                //yesterday
                $date = date('Y-m-d', strtotime("-1 days"));
                $where_date = "invoices.date >= '$date 00:00:00' and invoices.active = '2'";
            } elseif ($date_id == '3') {
                //week actualy
                $begin_day = first_week_actual();
                $end_day = last_week_actual();
                $where_date = "invoices.date >= '$begin_day 00:00:00' and invoices.date < '$end_day 23:59:59' and invoices.active = '2'";
            }
            $store_id = $res['store_id'];
            $payment = $res['payment'];
            //validate 
            if ($store_id) {
                $where_store_id = " and invoices.store_id = '$store_id'";
            }
            if ($payment) {
                $where_payment = " and invoices.payment = '$payment'";
            }
            $where = $where_date . $where_store_id . $where_payment;
            //get data customer by filters
            $obj_invoices = $Invoices->get_all_sales_today_where($where);
        } else {
            //get all of today's sales
            $obj_invoices = $Invoices->get_all_sales_today($today);
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
            'store_id' => $store_id,
            'payment' => $payment,
            'date_id' => $date_id,
            'date_start' => $date_start,
            'date_end' => $date_end
        );
        return view('admin/sales', $data);
    }

    public function load($id = false)
    {
        //get data session
        $session_name = $_SESSION['admin_name'] . " " . $_SESSION['admin_lastname'];
        $Customer = new CustomerModel();
        $Countries = new CountriesModel();
        $Memberships = new MembershipsModel();
        $Ranges = model('RangesModel');
        $Banks = model('BankModel');
        $obj_customer = null;
        $obj_sponsor = null;
        $obj_paises = $Countries->get_data();
        $obj_memberships = $Memberships->get_all();
        $obj_ranges = $Ranges->get_all();
        $obj_bank = $Banks->get_all();
        if ($id != "") {
            $obj_customer = $Customer->get_data_by_id($id);
            // Si el cliente tiene sponsor, obtenerlo
            if (isset($obj_customer->id)) {
                $obj_sponsor = $Customer->get_data_customer_sponsor($obj_customer->id);
            }
        }
        $data = array(
            'session_name' => $session_name,
            'obj_customer' => $obj_customer,
            'obj_sponsor' => $obj_sponsor,
            'obj_paises' => $obj_paises,
            'obj_memberships' => $obj_memberships,
            'obj_ranges' => $obj_ranges,
            'obj_bank' => $obj_bank
        );
        return view('admin/clientes/load', $data);
    }

    public function export_pdf($invoice_id = null)
    {
        //get data session
        $id = $_SESSION['admin_id'];
        //get data planes
        $Invoices = new InvoicesModel();
        //get total comissions
        $obj_invoices = $Invoices->invoices_id($invoice_id);
        //get product detail
        $Invoice_detail_membership = new Invoice_detail_membershipModel();
        $obj_product_detail = $Invoice_detail_membership->get_invoices_by_id($invoice_id);
        $dompdf = new \Dompdf\Dompdf();
        $options = $dompdf->getOptions();
        $options->setDefaultFont('Courier');
        $dompdf->setOptions($options);
        //send data
        $data = [
            'obj_invoices' => $obj_invoices,
            'obj_product_detail' => $obj_product_detail
        ];
        $dompdf->loadHTML(
            view("admin/pdf_view", $data)
        );

        // Configurar el tamaño del papel (ancho y alto en puntos; 1 punto = 1/72 pulgadas)
        $customPaper = array(0, 0, 285, 800); // Ajusta el alto según la longitud del ticket

        // Establecer el tamaño del papel personalizado
        $dompdf->setPaper($customPaper);

        //$dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream("ticket.pdf");
    }

    public function qualified()
    {
        //get data session
        $session_name = $_SESSION['admin_name'] . " " . $_SESSION['admin_lastname'];
        //set var
        $Calification = new CalificationModel();
        //obtain all the qualifiers of the current period
        $year = date("Y");
        $month = date("m");
        if ($month >= '1' && $month <= '6') {
            //set variable value
            $begin_period = "$year-01-01";
            $end_period = "$year-06-31";
        } else {
            //set variable value
            $begin_period = "$year-07-01";
            $end_period = "$year-12-31";
        }

        if ($_POST) {
            $res = service('request')->getPost();
            $daterange = $res['daterange'];
            //make query date
            $explode_ragen = explode(' - ', $daterange);
            $begin_period = $explode_ragen[0];
            $end_period = $explode_ragen[1];
        }

        $obj_calification = $Calification->get_all_calification_by_period($begin_period, $end_period);
        //send
        $data = array(
            'session_name' => $session_name,
            'obj_calification' => $obj_calification,
            'begin_period' => $begin_period,
            'end_period' => $end_period,
        );
        return view('admin/calification/calification', $data);
    }

    public function view_qualified($id = false)
    {
        $B_home = new B_home;
        //get data session
        $session_name = $_SESSION['admin_name'] . " " . $_SESSION['admin_lastname'];
        $Calification = new CalificationModel();
        //obtain all the qualifiers of the current period
        $date = begin_end_periodo();
        $num_period_calification = $B_home->get_calificacion_travel($id);
        $obj_calification = "";
        if ($id) {
            $obj_calification = $Calification->get_calification_by_period_id($id, $date['begin'], $date['end']);
        }
        //send data
        $data = array(
            'obj_calification' => $obj_calification,
            'num_period_calification' => $num_period_calification,
            'session_name' => $session_name,
        );
        return view('admin/calification/view_detail', $data);
    }

    public function estructura_up()
    {
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
            if ($obj_unilevel) {
                $sponsor_id = $obj_unilevel->sponsor_id;
            }
            //verify
            if (!is_null($sponsor_id) && $sponsor_id != 0 && $sponsor_id != 1) {
                $data['status'] = true;
                $data['url'] = site_url() . "dashboard/estructura/$sponsor_id";
            } else {
                $data['status'] = false;
            }
            echo json_encode($data);
            exit();
        }
    }
}