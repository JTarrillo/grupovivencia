<?php

namespace App\Controllers;

use App\Models\SuppliersModel;

class D_supplier extends BaseController
{
    private function getSessionName(): string
    {
        $session = session();
        $firstName = $session->get('first_name') ?: $session->get('name') ?: '';
        $lastName = $session->get('last_name') ?: $session->get('lastname') ?: '';
        $fullName = trim($firstName . ' ' . $lastName);

        return $fullName !== '' ? $fullName : 'Usuario';
    }

    public function index()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        //get data session
        $session_name = $this->getSessionName();
        //get data bonus
        $Suppliers = new SuppliersModel();
        $obj_supplier = $Suppliers->get_all();
        //send
        $data = array(
            'obj_supplier' => $obj_supplier,
            'session_name' => $session_name
        );
        return view('admin/proveedores/list', $data);
    }

    public function load($id = false)
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        //get data session
        $session_name = $this->getSessionName();
        //set var
        $obj_supplier = null;
        //verify
        if ($id != false) {
            //get data bonus by bonus
            $Suppliers = new SuppliersModel();
            $obj_supplier = $Suppliers->get_by_id($id);
        }
        //send
        $data = array(
            'obj_supplier' => $obj_supplier,
            'session_name' => $session_name
        );
        return view('admin/proveedores/load', $data);
    }

    public function validacion()
    {
        //ACTIVE CUSTOMER NORMALY
        if ($this->request->isAJAX()) {
            $Suppliers = new SuppliersModel();
            //get data post
            $res = service('request')->getPost();
            $supplier_id = $res['supplier_id'];
            $saved_id = null;
            //verify                     
            if ($supplier_id != "") {
                //update tabla bonus
                $param = array(
                    'name' => $res['name'],
                    'ruc' => $res['ruc'],
                    'phone' => $res['phone'],
                    'address' => $res['address'],
                    'active' => $res['active'],
                    'updated_at' => date("Y-m-d H:i:s")
                );
                $result = $Suppliers->update($supplier_id, $param);
                $saved_id = $supplier_id;
            } else {
                //UPDATE DATA
                $param = array(
                    'name' => $res['name'],
                    'ruc' => $res['ruc'],
                    'phone' => $res['phone'],
                    'address' => $res['address'],
                    'date' => date("Y-m-d"),
                    'active' => $res['active'],
                    'created_at' => date("Y-m-d H:i:s"),
                );
                $result = $Suppliers->insertar($param);
                $saved_id = $result;
            }
            if (!is_null($result)) {
                $data['status'] = true;
                $data['message'] = SAVED;
                $data['supplier_id'] = (int) $saved_id;
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
            $Suppliers = new SuppliersModel();
            //get data post
            $res = service('request')->getPost();
            $supplier_id = $res['supplier_id'];
            //verify                     
            if ($supplier_id != null) {
                $result = $Suppliers->eliminar($supplier_id);
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
}
