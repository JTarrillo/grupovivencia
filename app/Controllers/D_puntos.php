<?php



namespace App\Controllers;

use App\Models\CustomerModel;

use App\Models\Points_binaryModel;



class D_puntos extends BaseController

{   

    public function index()

    {

        $session = session();

        $db = \Config\Database::connect();

        //get data session

        $id = $session->get('id');

        $session_name = $session->get('first_name')." ".$session->get('last_name');

        //get month

        $year = date("Y");

        $month = date("m");

        $date_start = "$year-$month-01";

        $date_end = "$year-$month-31";

        //get data point binary

        $Points_binary = new Points_binaryModel();

        $obj_points = $Points_binary->get_all_by_customer($date_start, $date_end);

        //send

        $data = array(

            'obj_points' => $obj_points,

            'session_name' => $session_name

        );

        return view('backoffice/admin/puntos/puntos', $data);

    }

    

    public function load($id=false){

        //get session

        $session = session();

        $session_name = $session->get('first_name')." ".$session->get('last_name');

        $Points_binary = new Points_binaryModel();

        $obj_points_binary = null;

        //verify id

        if ($id != false){

            //get data bonus by bonus

            $obj_points_binary = $Points_binary->get_all_by_customer_by_id($id);

          }

        //send

        $data = array(

            'obj_points_binary' => $obj_points_binary,

            'session_name' => $session_name

        );

        return view('backoffice/admin/puntos/load', $data);

    }



    public function validacion(){

        //ACTIVE CUSTOMER NORMALY

        if ($this->request->isAJAX()) {

            $session = session();

            $db = \Config\Database::connect();

            $id = $session->get('id');

            $Points_binary = new Points_binaryModel();

            //get data post

            $request = \Config\Services::request();

            $id = $request->getPostGet('id');

            $left = $request->getPostGet('left');

            $right = $request->getPostGet('right');

            $status = $request->getPostGet('status');

            //verify ID

            if($id != ""){

                //update table point_binary  

                $param = array(

                    'left' => $left,

                    'right' => $right,

                    'status' => $status

                    );          

                $result = $Points_binary->update($id, $param);

                //verify 

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



    public function eliminar(){

        //ACTIVE CUSTOMER NORMALY

        if ($this->request->isAJAX()) {

            $session = session();

            $db = \Config\Database::connect();

            $Points_binary = new Points_binaryModel();

            //get data post

            $res = service('request')->getPost();

            $id = $res['id'];

            //verify                     

            if($id != null){

                $result = $Points_binary->eliminar($id);

                if(!is_null($result)){

                    $data['status'] = true;

                }else{

                    $data['status'] = false;

                }     

            }else{

                $data['status'] = false;

            }

            echo json_encode($data); 

            exit();

        }

    }

}

