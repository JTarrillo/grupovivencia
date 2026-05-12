<?php



namespace App\Controllers;

use App\Models\CustomerModel;

use App\Models\PaysModel;



class D_pagos extends BaseController

   
{   

    public function index()

    {

        //get data session

        $session_name = $_SESSION['first_name']." ".$_SESSION['last_name'];

        //get data invoices by customer

        $Pay = new PaysModel();

        $obj_pay = $Pay->get_crud_pay();

        //send

        $data = array(

            'obj_pay' => $obj_pay,

            'session_name' => $session_name

        );

        return view('admin/pagos/list', $data);

    }

    

    public function load($id = false)

    {

        //get data session

        $session_name = $_SESSION['first_name']." ".$_SESSION['last_name'];

        //isset id

        if ($id != false){

            $Pay = new PaysModel();

            $obj_pays = $Pay->get_data_by_customer_id($id);

        }

        //send data

        $data = array(

            'obj_pays' => $obj_pays,

            'session_name' => $session_name,

        );

        return view('admin/pagos/load',$data);

    }



    public function validacion(){

        if ($this->request->isAJAX()) {

            $Pay = new PaysModel();

            //get data session

            $session = session();

            $id = $session->get('id');

            //get data post

            $res = service('request')->getPost();

            $pay_id = $res['pay_id'];

            $amount = $res['amount'];

            $descount = $res['descount'];

            $amount_total =  $res['amount_total'];

            $active =  $res['active'];

            //update table invoices

            if($pay_id != ""){

                $param = array(

                    'amount' => $amount,

                    'discount' => $descount,

                    'total' => $amount_total,

                    'active' => $active,  

                    );   

                //update table invoices

                $result = $Pay->update($pay_id, $param);

            }

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

    

    // ...existing code...

    public function solicitar_retiro()
    {
        if ($this->request->getMethod() === 'post') {
            $session = session();
            $customer_id = $session->get('id');
            $amount = floatval($this->request->getPost('amount'));
            $pin = $this->request->getPost('pin');
            $factura = $this->request->getFile('factura');

            // REGLA 1: Validar día permitido (solo 1 y 2 de cada mes)
            $dia = date('j');
            if ($dia != 1 && $dia != 2) {
                return $this->response->setJSON(['status' => false, 'message' => 'Solo puedes solicitar retiro el 1 y 2 de cada mes.']);
            }

            // REGLA 2: Validar importe mínimo (S/100)
            if ($amount < 100) {
                return $this->response->setJSON(['status' => false, 'message' => 'El importe mínimo de retiro es de S/100.']);
            }

            // REGLA 4: Validar factura obligatoria para retiros de gestión inmobiliaria
            if (!$factura || !$factura->isValid()) {
                return $this->response->setJSON(['status' => false, 'message' => 'Es obligatorio adjuntar factura para retiros de gestión inmobiliaria.']);
            }

            // Validar extensión de factura
            $allowedTypes = ['pdf', 'jpg', 'jpeg', 'png'];
            if (!in_array($factura->getExtension(), $allowedTypes)) {
                return $this->response->setJSON(['status' => false, 'message' => 'La factura debe ser PDF, JPG o PNG.']);
            }

            // Guardar factura
            $facturaName = $factura->getRandomName();
            $factura->move(WRITEPATH . 'uploads/facturas', $facturaName);

            // REGLA 3: Calcular detracción del 10% si importe >= S/700
            $discount = ($amount >= 700) ? round($amount * 0.10, 2) : 0;
            $total = $amount - $discount;

            // Guardar solicitud en la base de datos
            $Pay = new \App\Models\PaysModel();
            $Pay->insertar([
                'customer_id' => $customer_id,
                'amount' => $amount,
                'discount' => $discount,
                'total' => $total,
                'date' => date('Y-m-d H:i:s'),
                'factura' => $facturaName,
                'active' => 1 // pendiente
            ]);

            return $this->response->setJSON(['status' => true, 'message' => 'Solicitud de retiro enviada correctamente.']);
        }
        return $this->response->setJSON(['status' => false, 'message' => 'Método no permitido.']);
    }

}