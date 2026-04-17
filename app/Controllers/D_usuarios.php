<?php



namespace App\Controllers;

use App\Models\UsersModel;



class D_usuarios extends BaseController

{   

    public function index()

    {

        //get data session

        $id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

        if (isset($_SESSION['first_name']) && isset($_SESSION['last_name'])) {
            $session_name = $_SESSION['first_name'] . " " . $_SESSION['last_name'];
        } elseif (isset($_SESSION['name'])) {
            $session_name = $_SESSION['name'];
        } else {
            $session_name = 'Usuario';
        }

        //get data bonus

        $Users = new UsersModel();

        $obj_users = $Users->get_all();

        //send

        $data = array(

            'obj_users' => $obj_users,

            'session_name' => $session_name

        );

        return view('admin/usuarios/list', $data);

    }

    

    public function load($id=false){

        if (isset($_SESSION['first_name']) && isset($_SESSION['last_name'])) {
            $session_name = $_SESSION['first_name'] . " " . $_SESSION['last_name'];
        } elseif (isset($_SESSION['name'])) {
            $session_name = $_SESSION['name'];
        } else {
            $session_name = 'Usuario';
        }

        $obj_users = null;

        //verify id

        if ($id != false){

            //get data bonus by bonus

            $Users = new UsersModel();

            $obj_users = $Users->get_all_by_id($id);

          }

        //send

        $data = array(

            'obj_users' => $obj_users,

            'session_name' => $session_name

        );

        return view('admin/usuarios/load', $data);

    }



    public function validacion(){

        //ACTIVE CUSTOMER NORMALY

        if ($this->request->isAJAX()) {

            $Users = new UsersModel();

            //get data post

            $res = service('request')->getPost();

            $user_id = $res['user_id'];

            //set password

            $password = $res['password'];

            //verify

            if($user_id != ""){

                //update table users

                $param = array(

                    'name' => $res['name'],

                    'lastname' => $res['lastname'],

                    'email' => $res['email'],

                    'privilage' => $res['privilage'],

                    'active' => $res['active'],

                );

                $result = $Users->update($user_id, $param);

                if($password != ""){

                    $param = array(

                        'password'=>password_hash($password, PASSWORD_DEFAULT)

                    );

                    $Users->update($user_id, $param);

                }

            }else{

                //insert table users

                $param = array(

                    'name' => $res['name'],

                    'lastname' => $res['lastname'],

                    'email' => $res['email'],

                    'password'=>password_hash($password, PASSWORD_DEFAULT),

                    'privilage' => $res['privilage'],

                    'active' => $res['active']

                );

                $result = $Users->insertar($param);

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

            $Users = new UsersModel();

            //get data post

            $res = service('request')->getPost();

            $user_id = $res['user_id'];

            //verify                     

            if($user_id != null){

                $result = $Users->eliminar($user_id);

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

