<?php

namespace App\Controllers;

use App\Models\CommentsModel;

class D_comentarios extends BaseController
{

    public function index()
    {
        $session = session();
        //get data session
        $session_name = $session->get('first_name') . " " . $session->get('last_name');
        //get data invoices by customer
        $Comments = new CommentsModel();
        //get comments
        $params = array(
            "select" => "*",
            "order" => "id DESC",
            "limit" => "12",
        );
        $obj_comments = $Comments->search($params);
        //send
        $data = array(
            'obj_comments' => $obj_comments,
            'session_name' => $session_name
        );

        return view('admin/comentarios/comentarios', $data);
    }

    public function change_status()
    {

        //UPDATE DATA ORDERS

        if ($this->request->isAJAX()) {

            $Comments = new CommentsModel();

            $session = session();

            //get data session

            $id = $session->get('id');

            //get data post

            $res = service('request')->getPost();

            $comment_id = $res['comment_id'];

            //verify

            if ($comment_id != null) {

                $param = array(

                    'active' => 0,

                    'updated_at' => date("Y-m-d H:i:s"),

                    'updated_by' => $id,

                );

                $result = $Comments->update($comment_id, $param);

                if (!is_null($result)) {

                    $data["status"] = true;
                } else {

                    $data["status"] = false;
                }
            } else {

                $data["status"] = false;
            }

            echo json_encode($data);

            exit();
        }
    }

    public function load($id = false)
    {
        //load model 
        $Comments = new CommentsModel();
        //get data session
        $session_name = $_SESSION['first_name'] . " " . $_SESSION['last_name'];
        //set var
        $obj_comments = null;
        //verify
        if ($id != false) {
            //get comments
            $param = array(
                "select" => "*",
                "where" => "id = $id"
            );
            $obj_comments = $Comments->get_search_row($param);
        }
        //send
        $data = array(
            'obj_comments' => $obj_comments,
            'session_name' => $session_name
        );
        return view('admin/comentarios/load', $data);
    }

    public function validacion()
    {
        if ($this->request->isAJAX()) {
            //load model 
            $Comments = new CommentsModel();
            //get data post
            $res = service('request')->getPost();
            $id = $res['id'];
            $active = $res['active'];
            //verify                     
            if ($id != "") {
                //update tabla bonus
                $param = array(
                    'active' => $active
                );
                $result = $Comments->update($id, $param);
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
        if ($this->request->isAJAX()) {
            //load model 
            $Comments = new CommentsModel();
            //get data post
            $res = service('request')->getPost();
            $id = $res['id'];
            //verify                     
            if ($id != null) {
                $result = $Comments->eliminar($id);
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
