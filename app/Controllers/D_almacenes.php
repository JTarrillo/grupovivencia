<?php

namespace App\Controllers;
use App\Models\StoreModel;

class D_almacenes extends BaseController
{   
    public function index()
    {
        //get data session
        $session_name = $_SESSION['first_name']." ".$_SESSION['last_name'];
        //get data bonus
        $Store = new StoreModel();
        $obj_store = $Store->get_all();
        //send
        $data = array(
            'obj_store' => $obj_store,
            'session_name' => $session_name
        );
        return view('admin/almacen/list', $data);
    }
    
    public function load($id=false){
        //get data session
        $session_name = $_SESSION['first_name']." ".$_SESSION['last_name'];
        //set var
        $obj_store = null;
        //verify
        if ($id != false){
            //get data bonus by bonus
            $Store = new StoreModel();
            $obj_store = $Store->get_by_id($id);
          }
        //send
        $data = array(
            'obj_store' => $obj_store,
            'session_name' => $session_name
        );
        return view('admin/almacen/load', $data);
    }

    public function validacion(){
        //ACTIVE CUSTOMER NORMALY
        if ($this->request->isAJAX()) {
            $id = $_SESSION['id'];
            $Store = new StoreModel();
            //get data post
            $res = service('request')->getPost();
            $id = $res['id'];
            $name = $res['name'];
            $active = $res['active'];
            //verify                     
            if($id != ""){
                //update tabla bonus
                $param = array(
                    'id' => $id,
                    'name' => $name,
                    'active' => $active,
                    'updated_at' => date("Y-m-d H:i:s")
                );       
                $result = $Store->update($id, $param);   
            }else{
                //UPDATE DATA
                $param = array(
                    'name' => $name,
                    'active' => $active,
                    'created_at' => date("Y-m-d H:i:s")
                );       
               $result = $Store->insertar($param);  
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
            $Store = new StoreModel();
            //get data post
            $res = service('request')->getPost();
            $id = $res['id'];
            //verify                     
            if($id != null){
                $result = $Store->eliminar($id);
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
