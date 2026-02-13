<?php

namespace App\Controllers;
use App\Models\BonusesModel;

class D_bonos extends BaseController
{   
    public function index()
    {
        //get data session
        $session_name = $_SESSION['first_name']." ".$_SESSION['last_name'];
        //get data bonus
        $Bonus = new BonusesModel();
        $obj_bonus = $Bonus->get_all();
        //send
        $data = array(
            'obj_bonus' => $obj_bonus,
            'session_name' => $session_name
        );
        return view('admin/bonos/list', $data);
    }
    
    public function load($id=false){
        //get data session
        $session_name = $_SESSION['first_name']." ".$_SESSION['last_name'];
        //set var
        $obj_bonus = null;
        //verify
        if ($id != false){
            //get data bonus by bonus
            $Bonus = new BonusesModel();
            $obj_bonus = $Bonus->get_all_by_id($id);
          }
        //send
        $data = array(
            'obj_bonus' => $obj_bonus,
            'session_name' => $session_name
        );
        return view('admin/bonos/load', $data);
    }

    public function validacion(){
        //ACTIVE CUSTOMER NORMALY
        if ($this->request->isAJAX()) {
            $id = $_SESSION['id'];
            $Bonus = new BonusesModel();
            //get data post
            $res = service('request')->getPost();
            $bonus_id = $res['bonus_id'];
            $name = $res['name'];
            $percent = $res['percent'];
            $active = $res['active'];
            //verify                     
            if($bonus_id != ""){
                //update tabla bonus
                $param = array(
                    'id' => $bonus_id,
                    'name' => $name,
                    'percent' => $percent,
                    'active' => $active
                );       
                $result = $Bonus->update($bonus_id, $param);   
            }else{
                //UPDATE DATA
                $param = array(
                    'name' => $name,
                    'percent' => $percent,
                    'active' => $active
                );       
               $result = $Bonus->insertar($param);  
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

    public function eliminar(){
        //ACTIVE CUSTOMER NORMALY
        if ($this->request->isAJAX()) {
            $Bonus = new BonusesModel();
            //get data post
            $res = service('request')->getPost();
            $bonus_id = $res['bonus_id'];
            //verify                     
            if($bonus_id != null){
                $result = $Bonus->eliminar($bonus_id);
                if(!is_null($result)){
                    $data['status'] = true;
                    $data['message'] = DELETED;
                }else{
                    $data['status'] = false;
                    $data['message'] = ERROR;
                }     
            }else{
                $data['status'] = false;
                $data['message'] = ERROR;
            }
            echo json_encode($data); 
            exit();
        }
    }
}
