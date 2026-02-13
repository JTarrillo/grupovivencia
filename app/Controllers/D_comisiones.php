<?php

namespace App\Controllers;

use App\Models\ComisionesInmobiliariasModel;
use App\Models\BonusesModel;

class D_comisiones extends BaseController
{
    public function index()
    {
        //get data session
        if (isset($_SESSION['first_name']) && isset($_SESSION['last_name'])) {
            $session_name = $_SESSION['first_name'] . " " . $_SESSION['last_name'];
        } elseif (isset($_SESSION['name'])) {
            $session_name = $_SESSION['name'];
        } else {
            $session_name = 'Usuario';
        }
        //get date
        $year = date("Y");
        $month = date("m");
        $date_start = "$year-$month-01";
        $date_end = last_month_day($month, $year); 

        if ($_POST) {
            $res = service('request')->getPost();
            $daterange = $res['daterange'];
            //make query date
            $explode_ragen = explode(' - ', $daterange);
            $date_start = $explode_ragen[0];
            $date_end = $explode_ragen[1];
        }

        //get data de comisiones inmobiliarias con nombre de cliente
        $ComisionesInmobiliarias = new ComisionesInmobiliariasModel();
        $obj_commissions = $ComisionesInmobiliarias->getComisionesConCliente();

        //send
        $data = array(
            'obj_commissions' => $obj_commissions,
            'session_name' => $session_name,
            'date_start' => $date_start,
            'date_end' => $date_end
        );
        return view('admin/comisiones/list', $data);
    }

    public function load($id = false)
    {
        $Commissions = new CommissionsModel();
        $Bonus = new BonusesModel();
        //get data session
        $session_name = $_SESSION['first_name'] . " " . $_SESSION['last_name'];
        //isset id
        if ($id != false) {
            $obj_commissions = $Commissions->get_comssions_by_customer($id);
        }
        //get all bonus
        $obj_bonus = $Bonus->get_all();
        //send data
        $data = array(
            'obj_commissions' => $obj_commissions,
            'obj_bonus' => $obj_bonus,
            'session_name' => $session_name,
        );
        return view('admin/comisiones/load', $data);
    }

    public function validacion()
    {
        //ACTIVE CUSTOMER NORMALY
        if ($this->request->isAJAX()) {
            //get data session
            $session = session();
            $id = $session->get('id');
            $Commissions = new CommissionsModel();
            $res = service('request')->getPost();
            $commissions_id = $res['commissions_id'];
            //update table commissions
            $param = array(
                'amount' => $res['amount'],
                'bonus_id' => $res['bonus_id'],
                'active' => $res['active'],
                'updated_at' => date("Y-m-d H:i:s"),
                'updated_by' => $id
            );
            $result = $Commissions->update($commissions_id, $param);
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
            $Commissions = new CommissionsModel();
            //get data post
            $res = service('request')->getPost();
            $id = $res['id'];
            //verify                     
            if ($id != null) {
                $result = $Commissions->eliminar($id);
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
