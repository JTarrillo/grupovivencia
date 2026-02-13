<?php

namespace App\Controllers;
use App\Models\SuggestionsModel;
use App\Models\Concept_ticketsModel;
use App\Models\CustomerModel;
use CodeIgniter\Files\File;
use Fluent\ShoppingCart\Facades\Cart;

class B_suggestion extends BaseController
{   
    public function index()
    {
        //get count product shopping cart
        $cart_count = Cart::count();
        //get data session
        $id = $_SESSION['id'];
        //get data customer
        $Customer = new CustomerModel();
        $obj_customer = $Customer->get_customer_by_membership_id($id);
        //get concept tikect
        $Concept_ticket = new Concept_ticketsModel();
        $obj_concepto_ticket = $Concept_ticket->get_all();
        //set title
        $title = "Sugerencias";
        //render
        $data = array(
            'title' => $title,
            'obj_customer' => $obj_customer,
            'obj_concepto_ticket' => $obj_concepto_ticket,
            'id' => $id,
            'cart_count' => $cart_count
        );
        return view('backoffice_new/suggestion', $data);
    }

    public function send()
    {
        if ($this->request->isAJAX()) {
            $Suggestions = new SuggestionsModel();
            //get data post
            $res = service('request')->getPost();
            $customer_id = $_SESSION['id'];
            $subject = $res['subject'];
            $content = $res['content'];
            //verify
            if(!is_null($customer_id)){
                //inset table ticket
                $param = array(
                    'customer_id' => $customer_id,
                    'concept_ticket_id' => $subject,
                    'content' => $content,
                    'date' => date("Y-m-d H:i:s")
                );
                $id = $Suggestions->insertar($param);
                //send respose
                if(!is_null($id)){
                    $data['status'] = true;
                    $data['message'] = SEND_SUGGEST;
                }else{
                    $data['status'] = false;
                    $data['message'] = ERROR;
                } 
                echo json_encode($data);            
                exit();
            }else{

            }
        }
    }
}
