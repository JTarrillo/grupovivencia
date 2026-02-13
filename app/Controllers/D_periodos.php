<?php

namespace App\Controllers;

use App\Models\PeriodModel;

class D_periodos extends BaseController
{
    public function index()
    {
        //get data session
        $session_name = $_SESSION['first_name'] . " " . $_SESSION['last_name'];
        //get data bonus
        $Period = new PeriodModel();
        //get all data
        $param = array(
            'select' => '*',
            'order' => 'id DESC',
        );
        $obj_period = $Period->search($param);
        //send
        $data = array(
            'obj_period' => $obj_period,
            'session_name' => $session_name
        );
        return view('admin/periodos/list', $data);
    }

    public function load($id = false)
    {
        //get data session
        $session_name = $_SESSION['first_name'] . " " . $_SESSION['last_name'];
        //set var
        $obj_period = null;
        //verify
        if ($id != false) {
            //get data bonus by bonus
            $Period = new PeriodModel();

            //get data by id
            $param = array(
                "select" => "*",
                "where" => "id = $id",
            );
            $obj_period = $Period->get_search_row($param);
        }
        //send
        $data = array(
            'obj_period' => $obj_period,
            'session_name' => $session_name
        );
        return view('admin/periodos/load', $data);
    }

    public function validacion()
    {
        //ACTIVE CUSTOMER NORMALY
        if ($this->request->isAJAX()) {
            $id = $_SESSION['id'];
            $Period = new PeriodModel();
            //get data post
            $res = service('request')->getPost();
            $id = $res['id'];
            $code = $res['code'];
            $dateBegin = $res['dateBegin'];
            $dateEnd = $res['dateEnd'];
            //verify                     
            if ($id != "") {
                //update tabla bonus
                $param = array(
                    'code' => $code,
                    'begin' => $dateBegin,
                    'end' => $dateEnd
                );
                $result = $Period->update($id, $param);
            } else {
                //UPDATE DATA
                $param = array(
                    'code' => $code,
                    'begin' => $dateBegin,
                    'end' => $dateEnd,
                    'created_at' => date("Y-m-d H:i:s")
                );
                $result = $Period->insertar($param);
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
            $Store = new StoreModel();
            //get data post
            $res = service('request')->getPost();
            $id = $res['id'];
            //verify                     
            if ($id != null) {
                $result = $Store->eliminar($id);
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
