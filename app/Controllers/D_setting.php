<?php

namespace App\Controllers;
use App\Models\SettingModel;

class D_setting extends BaseController
{   
    public function index()
    {
        $session = session();
        $db = \Config\Database::connect();
        //get data session
        $id = $session->get('id');
        $session_name = $session->get('first_name')." ".$session->get('last_name');
        //get data bonus
        $Setting = new SettingModel();
        //get % payout
        $obj_setting_payout = $Setting->get_all_by_id(1);
        //get % transfer
        $obj_setting_tranfer = $Setting->get_all_by_id(2);
        //send
        $data = array(
            'obj_setting_payout' => $obj_setting_payout,
            'obj_setting_tranfer' => $obj_setting_tranfer,
            'session_name' => $session_name
        );
        return view('backoffice/admin/setting/setting', $data);
    }
    
    public function validacion(){
        //ACTIVE CUSTOMER NORMALY
        if ($this->request->isAJAX()) {
            $session = session();
            $db = \Config\Database::connect();
            $id = $session->get('id');
            //get data bonus
            $Setting = new SettingModel();
            date_default_timezone_set('America/Lima');
            $res = service('request')->getPost();
            $payout = $res['payout'];
            $transfer = $res['transfer'];
            //update table setting - payout
            $param = array(
                'percent' => $payout,
            );       
            $Setting->update(1, $param);   
            //update table setting - transfer
            $param = array(
                'percent' => $transfer,
            );       
            $result = $Setting->update(2, $param);   
            if(!is_null($result)){
                $data['status'] = true;
            }else{
                $data['status'] = false;
            }     
            echo json_encode($data); 
            exit();
            }
    }
}
