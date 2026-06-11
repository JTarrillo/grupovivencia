<?php



namespace App\Controllers;

use App\Models\CustomerModel;

use App\Models\PaysModel;



class D_pagos extends BaseController

   
{   

    public function index()

    {

        //get data session
        $session = session();
        $first_name = $session->get('first_name') ?? $session->get('name') ?? '';
        $last_name = $session->get('last_name') ?? $session->get('lastname') ?? '';
        $session_name = $first_name . " " . $last_name;

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
        $session = session();
        $first_name = $session->get('first_name') ?? $session->get('name') ?? '';
        $last_name = $session->get('last_name') ?? $session->get('lastname') ?? '';
        $session_name = $first_name . " " . $last_name;

        $Pay = new PaysModel();

        $obj_pay = $Pay->get_pay($id);

        $data = array(

            'obj_pay' => $obj_pay,

            'session_name' => $session_name

        );

        return view('admin/pagos/load', $data);

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

    public function status()

    {

        //get data session
        $session = session();

        if ($session->has('role') && $session->get('role') == '1') {

            $id = $this->request->getPost('id');

            $status = $this->request->getPost('status');



            $obj_pays = new PaysModel();



            // Actualizar el estado usando el Query Builder para evitar problemas de compatibilidad

            $db = \Config\Database::connect();

            $builder = $db->table('pays');

            $builder->where('id', $id);

            $result = $builder->update(['active' => $status]);



            if ($result) {
                // Si el pago es aprobado (status == 2), disminuir el balance en los informes de comisión
                if ($status == '2') {
                    $pay = $builder->where('id', $id)->get()->getRowArray();
                    if ($pay) {
                        $customerId = $pay['customer_id'];
                        $amountToDeduct = floatval($pay['amount']);
                        
                        // Buscar informes aprobados del cliente ordenados por fecha
                        $reportsBuilder = $db->table('commission_reports');
                        $reports = $reportsBuilder->where('customer_id', $customerId)
                                                  ->where('status', 'approved')
                                                  ->orderBy('created_at', 'ASC')
                                                  ->get()->getResultArray();
                                                  
                        foreach ($reports as $report) {
                            if ($amountToDeduct <= 0) break;
                            
                            $reportAmount = floatval($report['total_amount']);
                            $reportPaid = floatval($report['paid_amount'] ?? 0);
                            $reportAvailable = $reportAmount - $reportPaid;
                            
                            if ($reportAvailable > 0) {
                                if ($amountToDeduct >= $reportAvailable) {
                                    // Este informe se paga por completo
                                    $reportsBuilder->where('id', $report['id'])
                                                   ->update(['paid_amount' => $reportAmount, 'status' => 'paid']);
                                    $amountToDeduct -= $reportAvailable;
                                } else {
                                    // Este informe se paga parcialmente
                                    $reportsBuilder->where('id', $report['id'])
                                                   ->update(['paid_amount' => $reportPaid + $amountToDeduct]);
                                    $amountToDeduct = 0;
                                }
                            }
                        }
                    }
                }

                echo json_encode(array("status" => true));

            } else {

                echo json_encode(array("status" => false));

            }

        } else {

            return redirect()->to(site_url('admin'));

        }

    }

    public function eliminar(){
        $id = $this->request->getPost('id');
        $Pay = new PaysModel();
        $db = \Config\Database::connect();
        
        // Obtenemos el registro usando builder directo para evitar problemas de deleted_at
        $builder = $db->table('pays');
        $pay_record = $builder->where('id', $id)->get()->getRowArray();
        
        if ($pay_record && !empty($pay_record['factura'])) {
            $file_path = ROOTPATH . 'public/facturas/' . $pay_record['factura'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
        
        // Eliminamos el registro de la base de datos usando query directo
        $result = $builder->where('id', $id)->delete();
        
        if($result) {
            echo json_encode(['status' => true]);
        } else {
            echo json_encode(['status' => false]);
        }
    }

}