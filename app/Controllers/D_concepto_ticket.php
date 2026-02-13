<?php

namespace App\Controllers;
use App\Models\Concept_ticketsModel;

class D_concepto_ticket extends BaseController
{   
    public function index()
    {
        $session = session();
        $db = \Config\Database::connect();
        //get data session
        $id = $session->get('id');
        $session_name = $session->get('first_name')." ".$session->get('last_name');
        //get data bonus
        $Concepto_ticket = new Concept_ticketsModel();
        $obj_concepto_ticket = $Concepto_ticket->get_all_data();
        //send
        $data = array(
            'obj_concepto_ticket' => $obj_concepto_ticket,
            'session_name' => $session_name
        );
        return view('admin/concepto_ticket/list', $data);
    }
    
    public function load($id=false){
        $session = session();
        $session_name = $session->get('first_name')." ".$session->get('last_name');
        $obj_concepto_ticket = null;
        //verify id
        if ($id != false){
            //get data bonus
            $Concepto_ticket = new Concept_ticketsModel();
            $obj_concepto_ticket = $Concepto_ticket->get_all_data_by_id($id);
          }
        //send
        $data = array(
            'obj_concepto_ticket' => $obj_concepto_ticket,
            'session_name' => $session_name
        );
        return view('admin/concepto_ticket/load', $data);
    }

    public function validacion(){
        //ACTIVE CUSTOMER NORMALY
        if ($this->request->isAJAX()) {
            $Concepto_ticket = new Concept_ticketsModel();
            //ger data post
            $res = service('request')->getPost();
            $concept_id = $res['id'];
            //verify                     
            if($concept_id != ""){
                //update tabla concept_ticket
                $param = array(
                    'title' => $res['title'],
                    'active' => $res['active'],
                );       
                $result = $Concepto_ticket->update($concept_id, $param);  
            }else{
                //insert tabla concept_ticket
                $param = array(
                    'title' => $res['title'],
                    'date' => date("Y-m-d"),
                    'active' => $res['active']
                );       
               $result = $Concepto_ticket->insertar($param); 
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
            $Concepto_ticket = new Concept_ticketsModel();
            //get data post
            $res = service('request')->getPost();
            $id = $res['id'];
            //verify                     
            if($id != null){
                $result = $Concepto_ticket->eliminar($id);
                if(!is_null($result)){
                    $data['status'] = true;
                    $data['message'] = SAVED;
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
