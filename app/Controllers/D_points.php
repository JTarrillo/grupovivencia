<?php



namespace App\Controllers;

use App\Models\CustomerModel;

use App\Models\PointsModel;



class D_points extends BaseController

{   

    public function index()

    {

        //get data session

        $session_name = $_SESSION['admin_name']." ".$_SESSION['admin_lastname'];

        //get data invoices by customer

        $Points = new PointsModel();

        //set paramether for query
        $param = array(
            "select" => "points.id, 
                        customers.name, 
                        customers.lastname, 
                        customers.code, 
                        points.invoice_id, 
		                points.points, 
                        points.system, 
                        points.date, 
                        period.code as period",
            "join" => array(
                'customers , customers.id = points.customer_id',
                'invoices , invoices.id = points.invoice_id',
                'period , period.id = invoices.period_id'
            ),
            "order" => "points.id DESC",
            "limit" => "300",
        );

        $pointsData = $Points->search($param);

        //send

        $data = array(

            'pointsData' => $pointsData,

            'session_name' => $session_name

        );

        return view('admin/puntos/list', $data);

    }

    public function load($id = false)

    {

        //get data session

        $session_name = $_SESSION['admin_name']." ".$_SESSION['admin_lastname'];

        //isset id

        if ($id != false){

            $Points = new PointsModel();

            $param = array(
                "select" => "points.id, 
                            customers.id as customer_id, 
                            customers.name, 
                            customers.lastname, 
                            customers.code, 
                            points.invoice_id, 
                            points.points, 
                            points.system, 
                            points.date, 
                            period.code as period",
                "join" => array(
                    'customers , customers.id = points.customer_id',
                    'invoices , invoices.id = points.invoice_id',
                    'period , period.id = invoices.period_id'
                ),
                "where" => "points.id = $id"
            );

            $pointsData = $Points->get_search_row($param);

        }

        //send data

        $data = array(

            'pointsData' => $pointsData,
            'session_name' => $session_name,

        );

        return view('admin/pagos/load',$data);

    }

    public function validacion(){

        if ($this->request->isAJAX()) {

            $Points = new PointsModel();

            //get data post

            $res = service('request')->getPost();

            $id = $res['id'];

            $points = $res['points'];

            //update table points

            if($id != ""){

                $param = array(

                    'points' => $points

                    );   

                //update table invoices

                $result = $Points->update($id, $param);

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

            $Points = new PointsModel();

            //get data post

            $res = service('request')->getPost();

            $id = $res['id'];

            //verify                     

            if($id != null){

                $result = $Points->eliminar($id);

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

