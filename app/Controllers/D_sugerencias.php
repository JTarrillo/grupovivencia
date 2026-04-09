<?php

namespace App\Controllers;

use App\Models\SuggestionsModel;


class D_sugerencias extends BaseController
{

    public function index()
    {
        $session = session();
        //get data session
        $session_name = $session->get('first_name') . " " . $session->get('last_name');
        //get data invoices by customer
        $Suggestions = new SuggestionsModel();
        //get suggestions
        $params = array(
            "select" => "suggestions.*, customers.name, customers.code, customers.lastname, concept_tickets.title",
            "join" => array(
                'customers, customers.id = suggestions.customer_id',
                'concept_tickets, concept_tickets.id = suggestions.concept_ticket_id'
            ),
            "order" => "id DESC",
        );
        $obj_suggestions = $Suggestions->search($params);
        //send
        $data = array(
            'obj_suggestions' => $obj_suggestions,
            'session_name' => $session_name
        );

        return view('admin/sugerencias/list', $data);
    }

    public function load($id = false)
    {
        //load model 
        $Suggestions = new SuggestionsModel();
        //get data session
        $session_name = $_SESSION['admin_name'] . " " . $_SESSION['admin_lastname'];
        //set var
        $obj_suggestions = null;
        //verify
        if ($id != false) {
            //get suggestions
            $params = array(
                "select" => "suggestions.*, customers.username, customers.name, customers.lastname, concept_tickets.title",
                "join" => array(
                    'customers, customers.id = suggestions.customer_id',
                    'concept_tickets, concept_tickets.id = suggestions.concept_ticket_id'
                ),
                "where" => "suggestions.id = $id"
            );
            $obj_suggestions = $Suggestions->get_search_row($params);
        }
        //send
        $data = array(
            'obj_suggestions' => $obj_suggestions,
            'session_name' => $session_name
        );
        return view('admin/sugerencias/load', $data);
    }

    public function eliminar()
    {
        if ($this->request->isAJAX()) {
            //load model 
            $Suggestions = new SuggestionsModel();
            //get data post
            $res = service('request')->getPost();
            $id = $res['id'];
            //verify                     
            if ($id != null) {
                $result = $Suggestions->eliminar($id);
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