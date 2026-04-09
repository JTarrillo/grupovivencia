<?php



namespace App\Controllers;

use App\Models\TicketsModel;



class D_ticket extends BaseController

{   

    public function index()

    {

        //get data session

        $session_name = $_SESSION['admin_name']." ".$_SESSION['admin_lastname'];

        //get data ticket

        $Ticket = new TicketsModel();

        $obj_ticket = $Ticket->get_data();

        //send

        $data = array(

            'obj_ticket' => $obj_ticket,

            'session_name' => $session_name

        );

        return view('admin/ticket/list', $data);

    }

    

    public function load($id=false){

        //get data session

        $session_name = $_SESSION['admin_name']." ".$_SESSION['admin_lastname'];

        $obj_ticket = null;

        //verify id

        if ($id != false){

            //get data bonus by bonus

            $Ticket = new TicketsModel();

            $obj_ticket = $Ticket->get_data_by_id($id);

          }

        //send

        $data = array(

            'obj_ticket' => $obj_ticket,

            'session_name' => $session_name

        );

        return view('admin/ticket/load', $data);

    }



    public function validacion(){

        //ACTIVE CUSTOMER NORMALY

        if ($this->request->isAJAX()) {

            //get data session

            $session = session();

            $Ticket = new TicketsModel();

            //get data post

            $res = service('request')->getPost();

            $id = $res['id'];

            $active = $res['active'];

            //verify id

            if($id != ""){

                //PARAM DATA

                $param = array(

                    'response' => $res['response'],

                    'active' => $active

                    ); 

                //SAVE DATA IN TABLE  

                $result = $Ticket->update($id, $param);     

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

            $session = session();

            $Ticket = new TicketsModel();

            //get data post

            $res = service('request')->getPost();

            $id = $res['id'];

            //verify                     

            if($id != null){

                $result = $Ticket->eliminar($id);

                if(!is_null($result)){

                    $data['status'] = true;

                    $data['message'] = DELETED;

                }else{

                    $data['status'] = false;

                    $data['message'] = SAVED;

                }     

            }else{

                $data['status'] = false;

            }

            echo json_encode($data); 

            exit();

        }

    }

}

