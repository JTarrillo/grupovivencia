<?php

namespace App\Controllers;



use App\Models\MembershipsModel;

use App\Models\CustomerModel;

use App\Models\InvoicesModel;

use App\Models\CommissionsModel;

use App\Models\StoreModel;

use App\Models\Invoice_detail_membershipModel;

use App\Models\OutgoingModel;

use App\Models\PeriodModel;

use App\Libraries\Evox;

use Fluent\ShoppingCart\Facades\Cart;



class B_plan extends BaseController

{

    public function index()

    {

        
        //cart destroy

        Cart::destroy();

        //delete session cart


        //get count product shopping cart

        $cart_count = Cart::count();

        //get data session

        $id = $_SESSION['id'];

        //get data customer

        $Customer = new CustomerModel();


        $obj_customer = $Customer->get_customer_by_membership_id($id);

        $membership_id = $obj_customer->membership_id;

        //get data planes

        $Memberships = new MembershipsModel();

        $obj_membership = $Memberships->get_all_product_stock();

        //get data total    

        $Commissions = new CommissionsModel();

        $obj_commission_total = $Commissions->get_total_commission($id);

        //get data store

        $Store = new StoreModel();

        $obj_store = $Store->get_all();

        //set title

        $title = "Productos";

        //send

        $data = array(

            'title' => $title,

            'total_disponible' => $obj_commission_total->total_disponible,

            'obj_customer' => $obj_customer,

            'obj_store' => $obj_store,

            'membership_id' => $membership_id,

            'customer_id' => $id,

            'obj_membership' => $obj_membership,

            'cart_count' => $cart_count

        );

        return view('backoffice_new/plan', $data);

    }

    public function planes()
    {
        // Gestión inmobiliaria: mostrar proyectos
        //get data session
        $id = $_SESSION['id'] ?? null;
        //get data customer
        $Customer = new CustomerModel();
        $params = array(
            "select" => "customers.id, customers.code, customers.phone, customers.avatar as img, customers.dni, customers.wallet, customers.pay, customers.kyc, customers.name, customers.email, customers.avatar, customers.lastname, customers.membership_id, customers.created_at, customers.active, countries.nombre as pais, countries.img,
                        (select sponsor_id from unilevels WHERE customer_id = $id) as sponsor_id ",
            "join" => array(
                'countries, countries.id = customers.country_id'
            ),
            "where" => "customers.id = $id AND countries.id_idioma = 7",
        );
        $obj_customer = $Customer->get_search_row($params);

        // Obtener proyectos inmobiliarios
        $ProjectModel = new \App\Models\ProjectModel();
        $projects = $ProjectModel->findAll();

        // Obtener cantidad de productos en el carrito (si aplica)
        $cart_count = 0;
        if (class_exists('Fluent\ShoppingCart\Facades\Cart')) {
            $cart_count = \Fluent\ShoppingCart\Facades\Cart::count();
        }

        //set title
        $title = "Proyectos Inmobiliarios";
        //send
        $data = array(
            'title' => $title,
            'obj_customer' => $obj_customer,
            'customer_id' => $id,
            'projects' => $projects,
            'cart_count' => $cart_count,
        );

        return view('backoffice_new/planes', $data);
    }



    public function cart()

    {
        //get data session

        $id = $_SESSION['id'];

        //get data customer

        $Customer = new CustomerModel();

        //get data customer 

        $params = array(

            "select" => "customers.id, customers.code, customers.phone, customers.avatar as img, customers.dni, customers.wallet, customers.pay, customers.kyc, customers.name, customers.email, customers.avatar, customers.lastname, customers.membership_id, customers.created_at, customers.active, countries.nombre as pais, countries.img as pais_img,

                        (select sponsor_id from unilevels WHERE customer_id = $id) as sponsor_id ",

            "join" => array(

                'countries, countries.id = customers.country_id'

            ),

            "where" => "customers.id = $id AND countries.id_idioma = 7",

        );

        $obj_customer = $Customer->get_search_row($params);

        //get membership+

        $Membership = new MembershipsModel();

        //set var membership

        $obj_membership = $Membership->get_data_countable_mayor($obj_customer->membership_id);

        //Membresia

        //get count product shopping cart

        $cart_count = Cart::count();

        //get data shoppint cart

        $content = Cart::content();

        $sub_total = Cart::subtotal();

        $total = Cart::total();

        //get data store

        $Store = new StoreModel();

        $obj_store = $Store->get_all();

        //set title

        $title = "Carrito";

        //get data session
        $id = $_SESSION['id'];
        //get data customer
        $Customer = new CustomerModel();
        //get data customer 
        $params = array(
            "select" => "customers.id, customers.code, customers.phone, customers.avatar as img, customers.dni, customers.wallet, customers.pay, customers.kyc, customers.name, customers.email, customers.avatar, customers.lastname, customers.membership_id, customers.created_at, customers.active, countries.nombre as pais, countries.img as pais_img,
                        (select sponsor_id from unilevels WHERE customer_id = $id) as sponsor_id ",
            "join" => array(
                'countries, countries.id = customers.country_id'
            ),
            "where" => "customers.id = $id AND countries.id_idioma = 7",
        );
        $obj_customer = $Customer->get_search_row($params);
        //get membership+
        $Membership = new MembershipsModel();
        //set var membership
        $obj_membership = $Membership->get_data_countable_mayor($obj_customer->membership_id);
        //get count product shopping cart
        $cart_count = Cart::count();
        //get data shoppint cart
        $content = Cart::content();
        $sub_total = Cart::subtotal();
        $total = Cart::total();
        //get data store
        $Store = new StoreModel();
        $obj_store = $Store->get_all();
        //get available lots for each project in cart
        $lotes = [];
        $proyectos = [];
        if (!empty($content)) {
            $ProjectModel = new \App\Models\ProjectModel();
            $LotModel = new \App\Models\LotModel();
            $proyectos = $ProjectModel->findAll();
            foreach ($content as $item) {
                // project_id must be present in cart item
                $project_id = isset($item->options['project_id']) ? $item->options['project_id'] : null;
                if ($project_id) {
                    // Query available lots for this project
                    $lots = $LotModel->where('project_id', $project_id)
                        ->where('status', 'available')
                        ->findAll();
                    $lotes[$project_id] = $lots;
                }
            }
        } else {
            // Si el carrito está vacío, igual carga todos los proyectos
            $ProjectModel = new \App\Models\ProjectModel();
            $proyectos = $ProjectModel->findAll();
        }
        //set title
        $title = "Carrito";
        // DEBUG: Mostrar contenido de carrito y lotes en el log
        error_log("DEBUG - CONTENIDO DEL CARRITO: " . print_r($content, true));
        error_log("DEBUG - LOTES DISPONIBLES: " . print_r($lotes, true));
        //send
        $data = array(
            'title' => $title,
            'obj_customer' => $obj_customer,
            'obj_store' => $obj_store,
            'customer_id' => $id,
            'content' => $content,
            'sub_total' => $sub_total,
            'total' => $total,
            'cart_count' => $cart_count,
            'obj_membership' => $obj_membership,
            'lotes' => $lotes,
            'proyectos' => $proyectos
        );
        return view('backoffice_new/cart', $data);
        $res = service('request')->getPost();

        $store_id = $res['store_id'];

        $phone = $res['phone'];

        $membership_id = isset($res['membership_id']) ? $res['membership_id'] : 0;

        //update option shoppint cart

        $content = Cart::content();

        //get membership

        $Membership = new MembershipsModel();

        $obj_membership = null;

        $total = 0;

        //set var membership

        if ($membership_id) {


            $obj_membership = $Membership->get_membership_by_id($membership_id);

            //check if there is a record

            foreach ($content as $key => $row) {

                if ($row->id == $obj_membership->id) {

                    $total = 1;

                }

            }

        }



        $points_format = Cart::point();

        $points = str_replace(",", "", "$points_format");

        $sub_total = Cart::subtotal();

        // $total = Cart::total();

        $total = str_replace(",", "", "$sub_total");

        $sub_total = $total / 1.18;

        $igv = $sub_total * 0.18;

        //update session

        $ses_data = [

            'id' => $id,

            'name' => $_SESSION['name'],

            'price' => $total,

            'phone' => $phone,

            'store_id' => $store_id,

            'name' => $_SESSION['name'],

            'membership_id' => $membership_id,

            'points' => $points,
            
            'active' => 1,

            'email' => $_SESSION['email'],

            'username' => $_SESSION['code'],

            'isLoggedIn' => TRUE

        ];

        $session->set($ses_data);

        //get data customer

        $Customer = new CustomerModel();

        $obj_customer = $Customer->get_customer_by_membership_id($id);



        //call library Evox

        $evox = new Evox();

        //call Evox Library , get data Commissions by period

        $result = $evox->get_commission_by_period();

        //set varibale

        $total_disponible = $result->total_disponible;



        //get data store

        $Store = new StoreModel();

        $obj_store = $Store->get_by_id($store_id);

        // DATA FOR PAYU

        //set title

        $title = "Checkout";

        //send

        $data = array(

            'title' => $title,

            'store_id' => $store_id,

            'phone' => $phone,

            'membership_id' => $membership_id,

            'obj_customer' => $obj_customer,

            'total_disponible' => $total_disponible,

            'obj_store' => $obj_store,

            'customer_id' => $id,

            'content' => $content,

            'igv' => $igv,

            'sub_total' => $sub_total,

            'total' => $total,

            'points' => $points,

            'cart_count' => $cart_count,

            'obj_membership' => $obj_membership,
        );

        return view('backoffice_new/checkout', $data);

    }



    public function pay()

    {

        // Obtén los datos del formulario (monto, nombre, etc.)

        $amount = 0;

        $customerName = "Rolando Contreras";

        // ... otros campos



        // Calcula el hash de seguridad

        $hash = hash('sha512', $amount . $customerName . config('PayU')['salt']);



        // Redirige al cliente a la página de pago de PayU

        return redirect()->to('https://sandbox.payu.in/_payment')

            ->with('amount', $amount)

            ->with('customer_name', $customerName)

            ->with('hash', $hash);

    }



    public function add_cart()

    {

        if ($this->request->isAJAX()) {

            //get data post

            $res = service('request')->getPost();

            $id = $res['id'];

            $name = $res['name'];

            $price = $res['price'];

            $qty = $res['qty'];

            $contable = $res['contable'];

            $point = $res['point'];

            //add cart

            $cart = Cart::add([

                'id' => $id,

                'name' => $name,

                'qty' => $qty,

                'contable' => $contable,

                'price' => $price,

                'options' => [

                    'contable' => $contable,

                    'details' => "",

                    'point' => $point,

                ]

            ]);

            if ($cart) {

                $data['status'] = true;

            } else {

                $data['status'] = false;

            }

            echo json_encode($data);

            exit();

        }

    }



    public function add_cart_product()

    {

        if ($this->request->isAJAX()) {

            //get data post

            $res = service('request')->getPost();

            $id = $res['id'];

            $name = $res['name'];

            $price = $res['price'];

            $qty = $res['qty'];

            $points = $res['point'];

            $img = $res['img'];

            $project_id = isset($res['project_id']) ? $res['project_id'] : null;



            //add cart

            $cart = Cart::add([

                'id' => $id,

                'name' => $name,

                'qty' => $qty,

                'price' => $price,

                'options' => [

                    'point' => $points,

                    'img' => $img,

                    'project_id' => $project_id

                ]

            ]);



            if ($cart) {

                $data['message'] = "Agregado";

                $data['status'] = true;

            } else {

                $data['status'] = false;

            }

            echo json_encode($data);

            exit();

        }

    }



    public function carrito_edit()

    {

        if ($this->request->isAJAX()) {

            //get data post

            $res = service('request')->getPost();

            $row_id = $res['row_id'];

            $qty = $res['qty'];

            if ($row_id) {

                //remuve product

                Cart::update($row_id, ['qty' => $qty]);

                $data['status'] = true;

            } else {

                $data['status'] = false;

            }

            echo json_encode($data);

            exit();

        }

    }



    public function delete_cart()

    { 

        if ($this->request->isAJAX()) {

            //get data post

            $res = service('request')->getPost();

            $id_db = $res['row_id'];

            $content = Cart::content();

            $verify = null;



            // foreach ($content as $key => $row) {

            //     $id_cart = $row->id;

            //     if ($id_db == $id_cart) {

            //         $verify = $row->rowId;

            //     }

            // }

            // var_dump($verify);
            // die();


            if ($id_db) {

                //remove product

                Cart::remove($id_db);

                $data['status'] = true;

            } else {

                $data['status'] = false;

            }

            echo json_encode($data);
            exit();

        }

    }

    //begin affiliation kit

    public function kit()

    {
        //cart destroy

        Cart::destroy();

        //get data session

        $id = $_SESSION['id'];

        //call customer model

        $Customer = new CustomerModel();

        //get data customer 

        $params = array(

            "select" => "customers.id, customers.phone, customers.code, customers.avatar as img, customers.dni, customers.pay, customers.name, customers.email, customers.avatar, customers.lastname, customers.membership_id, customers.created_at, customers.active, countries.nombre as pais, countries.img,

                        (select sponsor_id from unilevels WHERE customer_id = $id) as sponsor_id ",

            "join" => array(

                'countries, countries.id = customers.country_id'

            ),

            "where" => "customers.id = $id AND countries.id_idioma = 7",

        );

        $obj_customer = $Customer->get_search_row($params);

        //call membership model

        $Memberships = new MembershipsModel();

        //get data planes

        $params = array(

            "select" => "*",

            "where" => "contable = '0' and active = '1' and price > 0",

            "order" => "price DESC",

        );

        $obj_membership = $Memberships->search($params);

        //call evox model
        $evox = new Evox();
        //call Evox Library , get data Commissions by period
        $result = $evox->get_commission_by_period();
        //set var
        $obj_earn_disponible = $result->total_disponible;

        //get count product shopping cart

        $cart_count = Cart::count();

        //set title

        $title = "Productos";

        //send

        $data = array(

            'title' => $title,

            'total_disponible' => $obj_earn_disponible,

            'obj_customer' => $obj_customer,

            'customer_id' => $id,

            'obj_membership' => $obj_membership,

            'cart_count' => $cart_count,

        );

        return view('backoffice_new/kit', $data);

    }



    public function cart_kit()

    {

        //call session library

        $session = \Config\Services::session();

        //get data session

        $id = $_SESSION['id'];

        //call models

        $Customer = new CustomerModel();

        $Membership = new MembershipsModel();

        $Store = new StoreModel();

        //get data customer 

        $params = array(

            "select" => "customers.id, customers.code, customers.phone, customers.avatar as img, customers.dni, customers.wallet, customers.pay, customers.kyc, customers.name, customers.email, customers.avatar, customers.lastname, customers.membership_id, customers.created_at, customers.active, countries.nombre as pais, countries.img as pais_img,

                        (select sponsor_id from unilevels WHERE customer_id = $id) as sponsor_id ",

            "join" => array(

                'countries, countries.id = customers.country_id'

            ),

            "where" => "customers.id = $id AND countries.id_idioma = 7",

        );

        $obj_customer = $Customer->get_search_row($params);



        //get products 

        $params = array(

            "select" => "id, name, img, price, point, contable, description",

            "where" => "contable = '1' AND active = '1'",

            "order" => "price ASC",

        );

        $obj_products = $Membership->search($params);



        //get store

        $params = array(

            "select" => "*",

            "where" => "active = '1'"

        );

        $obj_store = $Store->search($params);



        //set data cart session

        $cart = $session->get('cart');

        //set var

        $membership_id = 1;

        $price = 0;

        $name = null;

        $point = 0;

        $qty_product = 0;



        if (isset($cart)) {

            $membership_id = $cart['id'];

            $name = $cart['name'];

            $price = $cart['price'];

            $point = $cart['point'];

            $cart_count = 1;

            //set number of products
            if($membership_id == 3){ //Pack 800
                $qty_product = 5;
            }elseif($membership_id == 4){ //PACK 1500 
                $qty_product = 12;
            }else{  // Pack 400
                $qty_product = 3;
            }

        }

        //get total points from shopping cart
        $content = Cart::content();
        $cart_total = Cart::count();

        //set title
        $title = "Carrito";

        //send
        $data = array(

            'title' => $title,

            'membership_id' => $membership_id,

            'content' => $content,

            'qty_product' => $qty_product,

            'obj_store' => $obj_store,

            'obj_customer' => $obj_customer,

            'customer_id' => $id,

            'name' => $name,

            'price' => $price,

            'point' => $point,

            'cart_count' => $cart_count,

            'cart_total' => $cart_total,

            'obj_products' => $obj_products,

        );

        return view('backoffice_new/kit_cart', $data);

    }



    public function checkout_kit()
    {

        $session = session();

        //call library Evox

        $evox = new Evox();

        //call models

        $Membership = new MembershipsModel();

        $Store = new StoreModel();

        //get data session

        $id = $_SESSION['id'];

        $res = service('request')->getPost();

        $phone = $res['phone'];

        $store_id = $res['store_id'];

        //get membership kit price
        $total = $res['price'];

        $point = $res['point'];

        $membership_id = isset($res['membership_id']) ? $res['membership_id'] : 1;

        //get total points from shopping cart
        $content = Cart::content();

        //set igv and subtotal

        $sub_total = $total / 1.18;
        $igv = $sub_total * 0.18;

        $ses_data = [

            'id' => $id,

            'name' => $_SESSION['name'],

            'price' => $total,

            'point' => $point,

            'phone' => $phone,

            'store_id' => $store_id,

            'membership_id' => $membership_id,

            'active' => 1,

            'email' => $_SESSION['email'],

            'code' => $_SESSION['code'],

            'isLoggedIn' => TRUE

        ];

        $session->set($ses_data);

        //available_balance

        //call library Evox

        $evox = new Evox();

        //call Evox Library , get data Commissions by period

        $result = $evox->get_commission_by_period();

        //set varibale

        $total_disponible = $result->total_disponible;

        //get data customer

        $Customer = new CustomerModel();

        $obj_customer = $Customer->get_customer_by_membership_id($id);

        //get data store by id

        $params = array(

            "select" => "*",

            "where" => "id = $store_id and active = '1'"

        );

        $obj_store = $Store->get_search_row($params);

        //set title

        $title = "Checkout";

        //send

        $data = array(

            'title' => $title,

            'phone' => $phone,

            'membership_id' => $membership_id,

            'obj_customer' => $obj_customer,

            'total_disponible' => $total_disponible,

            'customer_id' => $id,

            'content' => $content,

            'total' => $total,

            'igv' => $igv,

            'sub_total' => $sub_total,

            //'preference' => $preference,

            'store_id' => $store_id,

            'obj_store' => $obj_store,

            'cart_count' => 1,

            'point' => $point,

        );

        return view('backoffice_new/kit_checkout', $data);

    }



    public function add_cart_plan()

    {

        if ($this->request->isAJAX()) {

            //call session library

            $session = \Config\Services::session();

            //destroy session cart

            unset($_SESSION["cart"]);

            //destroy shopping cart

            Cart::destroy();

            //get data post

            $res = service('request')->getPost();

            $id = $res['id'];

            $name = $res['name'];

            $price = $res['price'];

            $point = $res['point'];

            //save cart session

            $cart = array(

                'id' => $id,

                'name' => $name,

                'price' => $price,

                'point' => $point,

                'qty' => 1,

            );

            $session->set('cart', $cart);

            //session verify

            $cart = $session->get('cart') ?? [];

            if (isset($cart)) {

                $data['status'] = true;

            } else {

                $data['status'] = false;

            }

            echo json_encode($data);

            exit();

        }

    }

    //ARMA TU KIT monedero
    public function activar_monedero()

    {

        if ($this->request->isAJAX()) {



            $Invoices = new InvoicesModel();

            $Outgoing = new OutgoingModel();

            $Invoice_detail_membershipModel = new Invoice_detail_membershipModel();

            $Commissions = new CommissionsModel();

            $Memberships = new MembershipsModel();

            $Period = new PeriodModel();

            $Customer = new CustomerModel();

            $content = Cart::content();

            //get data session

            $session = session();

            $id = $_SESSION['id'];

            //get data post

            $res = service('request')->getPost();

            //set var            

            $total_disponible = $res['total_disponible'];

            $point = $res['point'];

            $total = $res['total'];

            $sub_total = $total / 1.18;

            $igv = $sub_total * 0.18;

            $membership_id = $res['membership_id'] == 0 ? 1 : $res['membership_id'];



            //check available balance

            if ($total > $total_disponible) {

                $data['status'] = false;

                $data['message'] = "Balance Insuficiente";

            } else {

                //get period

                $obj_period = $Period->get_last();

                //create invoice , active 1 (pending)

                $param = array(

                    'customer_id' => $id,

                    'store_id' => $res['store_id'],

                    'period_id' => $obj_period->id,

                    'membership_id' => $membership_id,

                    'amount' => $total,

                    'phone' => $res['phone'],

                    'sub_total' => $sub_total,

                    'igv' => $igv,

                    'points' => $point,

                    'payment' => '1',

                    'delivery' => '1',

                    'date' => date("Y-m-d H:i:s"),

                    'created_at' => date("Y-m-d H:i:s"),

                    'active' => '2'

                );

                $invoice_id = $Invoices->insertar($param);

                //view products

                $row = 0;

                foreach ($content as $row) {

                    $param = array(

                        'invoice_id' => $invoice_id,

                        'membership_id' => $row->id,

                        'qty' => $row->qty,

                        'price' => $row->price,

                        'sub_total' => $row->subtotal,

                        'detail' => "",

                        'created_at' => date("Y-m-d h:i:s")

                    );

                    $Invoice_detail_membershipModel->insertar($param);

                    //add row outgoing table //out product

                    //get unit_cost by product

                    $obj_product =  $Memberships->get_all_by_id($row->id);

                    if ($obj_product) {

                        $unit_cost = $obj_product->unit_cost;

                        $total_cost = $row->qty * $unit_cost;

                    } else {

                        $unit_cost = 0;

                        $total_cost = 0;

                    }

                    $param = array(

                        'membership_id' => $row->id,

                        'invoice_id' => $invoice_id,

                        'store_id' => $res['store_id'],

                        'qty' => $row->qty,

                        'unit_cost' => $unit_cost,

                        'total_cost' => $total_cost,

                        'date' => date("Y-m-d H:i:s"),

                        'active' => '1',

                        'created_at' => date("Y-m-d H:i:s"),

                    );

                    $Outgoing->insertar($param);

                }

                //call library Evox

                $evox = new Evox();

                //COMPENSATION PLAN

                $db = \Config\Database::connect();

                $obj_tree = $db->query("SELECT unilevels.sponsor_id,unilevels.node, customers.active FROM unilevels  JOIN customers ON unilevels.sponsor_id = customers.id WHERE customer_id = $id")->getRow();

                $node = $obj_tree->node;

                $sponsor = $obj_tree->sponsor_id;

                if ($obj_tree) {

                    //add points range

                    $evox->add_points_unilevel($point, $id, $invoice_id, $obj_tree->node);

                    //Verify that it is not a regular purchase    

                    if($membership_id != 1){

                        //pay directo

                        $evox->pay_directo($id, $invoice_id, $obj_tree->sponsor_id, $obj_tree->active, $membership_id, $obj_tree->range_id, $obj_tree->node);

                    }

                    //regular purchase products

                    if ($membership_id == 1) {

                        // pay unilevel

                        $evox->pay_unilevel($id, $obj_tree->node, $invoice_id, $point);

                        //pay propio consumo

                        $evox->pay_propio_consumo($id, $invoice_id);

                    }

                }

                //Check if I have stagnant commissions

                $evox->unilevel_dynamic_compression($id, $point);

                //obtain all points per fortnight and activate user

                $evox->active_customer($id, 0, $membership_id, $res['phone']);

                $obj_customer_range = $db->query("SELECT range_id FROM customers WHERE id = $sponsor")->getRow();

                //validate new range

                $Customer->validate_new_range($sponsor, $obj_customer_range->range_id, $id, $invoice_id, 1, $membership_id, $node);

                //Check if I have stagnant commissions

                // $evox->unilevel_dynamic_compression($id, $point);

                //get current period

                $period = period();

                $first_month_day = $period['first_month_day'];

                //- 1 day (that the discount be in the previous period (set date of previous period))

                $date_period = restar_dias_date_con_fecha(1, $first_month_day);

                //discount balance customer

                $param = array(

                    'customer_id' => $id,

                    'invoice_id' => $invoice_id,

                    'bonus_id' => 4,

                    'amount' => -$total,

                    'arrive_id' => $id,

                    'date' => $date_period,

                    'date_shop' => date("Y-m-d H:i:s"),

                    'active' => '2',

                );

                $Commissions->insertar($param);

                //get total count product

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

                //cart destroy

                Cart::destroy();

                //send message

                $this->message($_SESSION['name'], $_SESSION['email'], $total, $qty, $membership_id, "", $res['store_id']);

                //update session

                $ses_data = [

                    'id' => $id,

                    'name' => $_SESSION['name'],

                    'active' => 1,

                    'email' => $_SESSION['email'],

                    'username' => $_SESSION['username'],

                    'isLoggedIn' => TRUE

                ];

                $session->set($ses_data);

                $data['status'] = true;

                $data['message'] = "Compra con éxito";

            }

            echo json_encode($data);

            exit();

        }

    }

    /** cambios **/

    public function activar_tienda()
    {
        if ($this->request->isAJAX()) {
            $Invoices = new InvoicesModel();
            $Customer = new CustomerModel();
            $Invoice_detail_membershipModel = new Invoice_detail_membershipModel();
            $id = $_SESSION['id'];
            //get data post
            $res = service('request')->getPost();
            $content = Cart::content();
            $membership_id = $res['membership_id'] == 0 ? 1 : $res['membership_id'];
            $amount = $res['total'];
            $point = $res['point'];

            $sub_total = $amount / 1.18;
            $igv = $sub_total * 0.18;

            //get current period
            $Period = new PeriodModel();
            $obj_period = $Period->get_last();

            //create invoice , active 1 (pending)
            $param = array(
                'customer_id' => $id,
                'store_id' => $res['store_id'],
                'period_id' => $obj_period->id,
                'membership_id' => $membership_id,
                'amount' => $amount,
                'phone' => $res['phone'],
                'sub_total' => $sub_total,
                'igv' => $igv,
                'points' => $point,
                'payment' => '3',
                'delivery' => '1',
                'temporal_membership' => $membership_id,
                'date' => date("Y-m-d H:i:s"),
                'created_at' => date("Y-m-d H:i:s"),
                'active' => '1'
            );
            $invoice_id = $Invoices->insertar($param);

            foreach ($content as $row) {
                $param = array(
                    'invoice_id' => $invoice_id,
                    'membership_id' => $row->id,
                    'qty' => $row->qty,
                    'price' => $row->price,
                    'sub_total' => $row->subtotal,
                    'detail' => "",
                    'created_at' => date("Y-m-d h:i:s")
                );
                $Invoice_detail_membershipModel->insertar($param);
            }

            //cart destroy
            Cart::destroy();
            //send message
            $data['status'] = true;
            $data['message'] = "Compra con éxito";
            echo json_encode($data);
            exit();
        }

    }

    /** cambios **/

    public function activar_tienda_product()

    {

        //ACTIVE CUSTOMER NORMALY

        if ($this->request->isAJAX()) {

            $Invoices = new InvoicesModel();

            $Invoice_detail_membershipModel = new Invoice_detail_membershipModel();

            $id = $_SESSION['id'];

            //get data post

            $res = service('request')->getPost();

            $content = Cart::content();

            $membership_id = $res['membership_id'] == 0 ? 1 : $res['membership_id'];

            $amount = $res['point'];

            $point = $res['point'];

            $sub_total = $amount / 1.18;

            $igv = $sub_total * 0.18;



            //get current period

            $Period = new PeriodModel();

            $obj_period = $Period->get_last();

            //create invoice , active 1 (pending)

            $param = array(

                'customer_id' => $id,

                'store_id' => $res['store_id'],

                'period_id' => $obj_period->id,

                'phone' => $res['phone'],

                'membership_id' => $membership_id,

                'amount' => $amount,

                'igv' => $igv,

                'sub_total' => $sub_total,

                'points' => $point,

                'payment' => '3',

                'delivery' => '1',

                'date' => date("Y-m-d H:i:s"),

                'created_at' => date("Y-m-d H:i:s"),

                'active' => '1'

            );

            $invoice_id = $Invoices->insertar($param);

            foreach ($content as $row) {

                $param = array(

                    'invoice_id' => $invoice_id,

                    'membership_id' => $row->id,

                    'qty' => $row->qty,

                    'price' => $row->price,

                    'sub_total' => $row->subtotal,

                    'detail' => "",

                    'created_at' => date("Y-m-d h:i:s")

                );

                $Invoice_detail_membershipModel->insertar($param);

            }

            //cart destroy

            Cart::destroy();

            //send message

            $data['status'] = true;

            $data['message'] = "Compra con éxito";

            echo json_encode($data);

            exit();

        }

    }



    public function success()

    {

        $transaction_id = $_GET['transactionId'] ?? NULL;

        //get count product shopping cart

        $Invoices = new InvoicesModel();

        $Outgoing = new OutgoingModel();

        $Invoice_detail_membershipModel = new Invoice_detail_membershipModel();

        $Memberships = new MembershipsModel();

        //get data session

        $session = session();

        $id = $_SESSION['id'];

        //details product

        $content = Cart::content();

        $total = $_SESSION['price'];

        $igv = $total * 0.18;

        $sub_total = $total - $igv;

        $point = $_SESSION['price'];

        $phone = $_SESSION['phone'];

        $store_id = $_SESSION['store_id'];

        $membership_id = $_SESSION['membership_id'];

        $address = $_SESSION['address'] ?? NULL;

        $delivery_destino = $_SESSION['delivery'] ?? NULL;

        //get current period

        $Period = new PeriodModel();

        $obj_period = $Period->get_last();

        //the price converted into points  (X/1.3)

        //create invoice , active 2 (paid)

        $param = array(

            'customer_id' => $id,

            'phone' => $phone,

            'store_id' => $store_id,

            'period_id' => $obj_period->id,

            'membership_id' => $membership_id,

            'transaction_id' => $transaction_id,

            'amount' => $total,

            'points' => $total,

            'sub_total' => $sub_total,

            'igv' => $igv,

            'payment' => '2',

            'address' => $address,

            'delivery' => '1',

            'delivery_destino' => $delivery_destino,

            'date' => date("Y-m-d H:i:s"),

            'created_at' => date("Y-m-d H:i:s"),

            'active' => '2'

        );

        $invoice_id = $Invoices->insertar($param);

        foreach ($content as $row) {

            $param = array(

                'invoice_id' => $invoice_id,

                'membership_id' => $row->id,

                'qty' => $row->qty,

                'price' => $row->price,

                'sub_total' => $row->subtotal,

                'detail' => "",

                'created_at' => date("Y-m-d h:i:s")

            );

            $Invoice_detail_membershipModel->insertar($param);

            //add row outgoing table //out product

            $obj_product =  $Memberships->get_all_by_id($row->id);

            if ($obj_product) {

                $unit_cost = $obj_product->unit_cost;

                $total_cost = $row->qty * $unit_cost;

            } else {

                $unit_cost = 0;

                $total_cost = 0;

            }

            $param = array(

                'membership_id' => $row->id,

                'invoice_id' => $invoice_id,

                'store_id' => $store_id,

                'qty' => $row->qty,

                'unit_cost' => $unit_cost,

                'total_cost' => $total_cost,

                'date' => date("Y-m-d H:i:s"),

                'active' => '1',

                'created_at' => date("Y-m-d H:i:s"),

            );

            $Outgoing->insertar($param);

        }

        //call library Evox

        $evox = new Evox();

        //COMPENSATION PLAN

        $db = \Config\Database::connect();

        $obj_tree = $db->query("SELECT unilevels.sponsor_id,unilevels.node, customers.active, customers.range_id FROM unilevels  JOIN customers ON unilevels.sponsor_id = customers.id WHERE customer_id = $id")->getRow();

        if ($obj_tree) {

            //Verify that it is not a regular purchase    

            if ($membership_id != 1) {

                //sponsorship bonus

                $evox->pay_directo($id, $invoice_id, $point, $obj_tree->sponsor_id, $obj_tree->active, $membership_id, $obj_tree->range_id);

                // REVISAR

            }

            //regular purchase products

            if ($membership_id == 1) {

                //propio consumo

                // CONSULTAR FUNCION

                // $evox->pay_propio_consumo($id, $invoice_id);

                // //unilevel bonus

                // $evox->pay_unilevel($id, $obj_tree->node, $invoice_id, $point);

                $evox->unilevel_residual($id, $obj_tree->node, $invoice_id, $point);

                $evox->cash_3x3($id, $invoice_id);

            }

            //add points range

            $evox->add_points_unilevel($point, $id, $invoice_id, $obj_tree->node);

        }

        //obtain all points per fortnight and activate user

        $evox->active_customer($id, $point, $membership_id, $phone);

        //Check if I have stagnant commissions

        // $evox->unilevel_dynamic_compression($id, $point);

        //cart destroy

        Cart::destroy();

        //send message

        //$this->message($_SESSION['name'], $_SESSION['email'], $point, $qty, $membership_id, "", $store_id);

        //update session

        $ses_data = [

            'id' => $id,

            'name' => $_SESSION['name'],

            'active' => 1,

            'email' => $_SESSION['email'],

            'username' => $_SESSION['username'],

            'isLoggedIn' => TRUE

        ];

        $session->set($ses_data);

        //redirect

        return redirect()->to('backoffice_new/facturas');

        //return view('backoffice_new/invoice', $data);

    }



    public function update_cart()

    {

        //ACTIVE CUSTOMER NORMALY

        if ($this->request->isAJAX()) {

            $session = session();

            $id = $_SESSION['id'];

            //get data post

            $res = service('request')->getPost();

            $kit_id = $res['kit_id'];

            $price = $res['price'];

            $address = $res['address'];

            $product_name = $res['product_name'];

            $phone = $res['phone'];

            $store_id = $res['store_id'];

            $qty = $res['qty'];

            $contable = $res['contable'];

            //details product

            //make concat

            if ($contable == '1') {

                $details = "";

            } else {

                $belefictely = $res['belefictely'];

                $calm = $res['calm'];

                $belenergy = $res['belenergy'];

                $eden = $res['eden'];

                $shark = $res['shark'];

                $aquabel = $res['aquabel'];

                //concat string

                $details = $belefictely . " Belefictely, " . $calm . " Calm, " . $belenergy . " Belenergy, " . $eden . " Edén, " . $shark . " Shark, " . $aquabel . " Aquabel";

            }

            //start session

            $ses_data = [

                'id' => $id,

                'name' => $_SESSION['name'],

                'kit_id' => $kit_id,

                'product_name' => $product_name,

                'price' => $price,

                'address' => $address,

                'phone' => $phone,

                'store_id' => $store_id,

                'details' => $details,

                'qty' => $qty,

                'name' => $_SESSION['name'],

                'active' => 1,

                'email' => $_SESSION['email'],

                'username' => $_SESSION['username'],

                'isLoggedIn' => TRUE

            ];

            $session->set($ses_data);

            //send data

            $data['status'] = true;

            echo json_encode($data);

            exit();

        }

    }



    public function cart_destroy()

    {

        Cart::destroy();

        echo "<script> alert('Carrito Limpio')</script>";

    }



    public function message($name, $email_customer, $amount, $qty, $membership_id, $details, $store_id)

    {

        //get data 

        $db = \Config\Database::connect();

        $obj_info = $db->query("SELECT name, (SELECT name FROM store WHERE id = $store_id) AS store FROM memberships WHERE id = $membership_id")->getRow();

        $date = date("Y-m-d H:i:s");

        $mensaje = wordwrap("<html>

        <table width='750' border='0' align='center' cellpadding='0' cellspacing='0' bgcolor='#f8f6f7' style='padding:15px 75px 15px'>

        <tbody><tr>

          <td align='center'>

            <table width='100%' border='0' align='center' cellpadding='0' cellspacing='0' style='background-color:#fff'>

              <tbody>

              <tr>

                <td>

                  <table width='600' border='0' align='center' cellpadding='0' cellspacing='0'>

                    <tbody><tr>

                      <td width='100%' style='padding:43px 0 38px;text-align:center'>

                        <table align='center' bgcolor='#ffffff' border='0' cellpadding='0' cellspacing='0'>

                          <tbody><tr style='text-align:center'>

                            <td height='26'>

                                <img border='0' style='display:inline-block' src='https://mundo-network.com/assets/front/img/logo/logo3.png' width='90' class='CToWUd'>

                            </td>

                              </tr>

                        </tbody>

                      </table>

                    </td>

                    </tr>

                    <tr>

                      <td style='font:20px Arial;padding:0 0 11px;color:#485360;text-align:center'>

                            Felicidades, $name                                

                      </td>

                    </tr>

                    <tr>

                        <td style='font:20px Arial;padding:0 0 11px;color:#485360;text-align:center'>

                         su compra ha sido procesada con éxito.

                      </td>

                    </tr>

                    <tr>

                  <td bgcolor='#ffffff' style='text-align:center;padding:10px 0 0 0'>

                    <table style='display:inline-block' border='0' cellspacing='0' cellpadding='0'>

                        <tbody>

                    <tr>

                        <td style='padding:32px;background-color:#ffffff'><table bgcolor='#FFFFFF' border='0' cellspacing='0' cellpadding='0' align='center' style='display:inline-block'>

                        <tbody><tr>

                            <td><table align='center' width='100%' border='0' cellpadding='0' cellspacing='0' style='min-width:230px'>

                            <tbody>

                            <tr>

                                <td height='3' style='padding:5px 0 10px'><table width='100%' border='0' cellspacing='0' cellpadding='0'>

                                <tbody><tr>

                                    <td bgcolor='#8e8f8f' height='3'></td>

                                </tr>

                                </tbody></table></td>

                            </tr>

                            <tr>

                                <td><table width='100%' border='0' cellspacing='0' cellpadding='0'>

                                <tbody><tr>

                                    <td style='color:#111519;font:400 12px Arial;padding-bottom:4px' align='left'>

                                    Producto

                                    </td>

                                    <td style='color:#111519;font:700 12px Arial' align='right'>

                                        $obj_info->name

                                    </td>

                                </tr>

                                </tbody>

                                </table>

                                </td>

                            </tr>

                            <tr>

                                <td><table width='100%' border='0' cellspacing='0' cellpadding='0'>

                                <tbody><tr>

                                    <td style='color:#111519;font:400 12px Arial;padding-bottom:4px' align='left'>

                                    Cantidad

                                    </td>

                                    <td style='color:#111519;font:700 12px Arial' align='right'>

                                        $qty

                                    </td>

                                </tr>

                                </tbody>

                                </table>

                                </td>

                            </tr>

                            <tr>

                                <td><table width='100%' border='0' cellspacing='0' cellpadding='0'>

                                <tbody><tr>

                                    <td style='color:#111519;font:400 12px Arial;padding-bottom:4px' align='left'>

                                    Detalle

                                    </td>

                                    <td style='color:#111519;font:700 12px Arial' align='right'>

                                        $details

                                    </td>

                                </tr>

                                </tbody>

                                </table>

                                </td>

                            </tr>

                            <tr>

                                <td><table width='100%' border='0' cellspacing='0' cellpadding='0'>

                                <tbody><tr>

                                    <td style='color:#111519;font:400 12px Arial;padding-bottom:4px' align='left'>

                                    Dirección de Entrega

                                    </td>

                                    <td style='color:#111519;font:700 12px Arial' align='right'>

                                        $obj_info->store

                                    </td>

                                </tr>

                                </tbody>

                                </table>

                                </td>

                            </tr>

                            <tr>

                                <td><table width='100%' border='0' cellspacing='0' cellpadding='0'>

                                <tbody><tr>

                                    <td style='color:#111519;font:400 12px Arial;padding-bottom:4px' align='left'>

                                    Estado

                                    </td>

                                    <td style='color:#111519;font:700 12px Arial' align='right'>

                                        Pagado

                                    </td>

                                </tr>

                                </tbody>

                                </table>

                                </td>

                            </tr>

                            <tr>

                                <td>

                                    <table width='100%' border='0' cellspacing='0' cellpadding='0'></table>

                                </td>

                            </tr>

                            <tr>

                                <td height='1' style='padding:12px 0 12px'><table width='100%' border='0' cellspacing='0' cellpadding='0'>

                                <tbody><tr>

                                    <td bgcolor='#8e8f8f' height='1'></td>

                                </tr>

                                </tbody></table>

                                </td>

                            </tr>

                            <tr>

                                <td><table width='100%' border='0' cellspacing='0' cellpadding='0'>

                                <tbody><tr>

                                    <td style='color:#111519;font:400 12px Arial' align='left'>

                                        Importe

                                    </td>

                                    <td style='color:#111519;font:700 18px Arial' align='right'>

                                        S/$amount               

                                    </td>

                                </tr>

                                </tbody></table></td>

                            </tr>

                            </tbody></table></td>

                        </tr>

                        </tbody></table></td>

                    </tr>

                    </tbody></table>

                    </td>

                </tr>

                </tbody>

                </table>

                .</html>", 70, "\n", true);



        //set data to send email

        $email = \Config\Services::email();

        $email->setFrom("contactos@mundonetwork.com", "Compra MUNDO NETWORK");

        $email->setTo($email_customer);

        $email->setSubject("Compra Confirmada $date");

        $email->setMessage($mensaje);

        $email->send();

        return true;

    }

    /**
     * Genera pago Openpay (tarjeta y OXXO)
     * POST: amount, name, email, phone, payment_type ('card'|'oxxo')
     * Returns: { status, openpay_url, message }
     */
    public function generar_pago_openpay()
    {
        if ($this->request->isAJAX()) {
            // Cargar config y SDK
            require_once(APPPATH . 'Config/Openpay.php');
            require_once(APPPATH . 'Libraries/Openpay/Openpay.php');

            $res = service('request')->getPost();
            $amount = $res['amount'];
            $name = $res['name'];
            $email = $res['email'];
            $phone = $res['phone'];
            $payment_type = $res['payment_type']; // 'card' or 'oxxo'

            // Usar credenciales falsas (de config)
            $openpay = \Openpay::getInstance(
                \Config\Openpay::$MERCHANT_ID,
                \Config\Openpay::$PRIVATE_KEY
            );
            $openpay->setSandboxMode(true);

            // Crear cliente
            $customerData = array(
                'name' => $name,
                'email' => $email,
                'phone_number' => $phone
            );
            $customer = $openpay->customers->add($customerData);

            // Crear cargo
            $chargeData = array(
                'method' => $payment_type,
                'amount' => floatval($amount),
                'description' => 'Pago membresía',
                'customer' => $customer,
                'currency' => 'MXN',
            );

            try {
                $charge = $openpay->charges->create($chargeData);
                if ($payment_type === 'card') {
                    // Para tarjeta, obtener URL de pago
                    $openpay_url = $charge->payment_method->url ?? null;
                } else if ($payment_type === 'oxxo') {
                    // Para OXXO, obtener referencia
                    $openpay_url = $charge->payment_method->reference ?? null;
                } else {
                    $openpay_url = null;
                }
                $data = [
                    'status' => true,
                    'openpay_url' => $openpay_url,
                    'message' => 'URL de pago generada correctamente.'
                ];
            } catch (Exception $e) {
                $data = [
                    'status' => false,
                    'openpay_url' => null,
                    'message' => 'Error al generar pago: ' . $e->getMessage()
                ];
            }
            echo json_encode($data);
            exit();
        }
    }
}