<?php

namespace App\Controllers;
use App\Models\TicketsModel;
use App\Models\Concept_ticketsModel;
use App\Models\CustomerModel;
use CodeIgniter\Files\File;
use Fluent\ShoppingCart\Facades\Cart;

class B_ticket extends BaseController
{   
    public function index()
    {
        //get count product shopping cart
        $cart_count = Cart::count();
        //get data session
        $id = $_SESSION['id'];
        //get data planes
        $Ticket = new TicketsModel();
        $obj_ticket = $Ticket->get_ticket_all_customer($id);
        //get data customer
        $Customer = new CustomerModel();
        $obj_customer = $Customer->get_customer_by_membership_id($id);
        //get concept tikect
        $Concept_ticket = new Concept_ticketsModel();
        $obj_concepto_ticket = $Concept_ticket->get_all();
        //set title
        $title = lang('Global.soporte');
        //render
        $data = array(
            'title' => $title,
            'obj_ticket' => $obj_ticket,
            'obj_customer' => $obj_customer,
            'obj_concepto_ticket' => $obj_concepto_ticket,
            'id' => $id,
            'cart_count' => $cart_count
        );
        return view('backoffice_new/ticket', $data);
    }

    public function send_ticket()
    {
        if ($this->request->isAJAX()) {
            $Ticket = new TicketsModel();
            //get data post
            $res = service('request')->getPost();
            $customer_id = $_SESSION['id'];
            $subject = $res['subject'];
            $content = $res['content'];
            $newName = null;
            //get data file
            $img = $this->request->getFile('image_file');
            //verify
            if(!is_null($customer_id)){
                //inset table ticket
                $data_ticket = array(
                    'customer_id' => $customer_id,
                    'concept_ticket_id' => $subject,
                    'content' => $content,
                    'date' => date("Y-m-d H:i:s"),
                    'active' => '1',
                );
                $ticket_id = $Ticket->insertar($data_ticket);
                //set path
                $estructura = './ticket/'.$ticket_id;
                //create file
                if(!is_dir($estructura)){
                    mkdir($estructura, 0777, true);
                }
                //upload imagen 1
                //validation
                $validationRule = [
                    'image_file' => [
                        'label' => 'Image File',
                        'rules' => 'uploaded[userfile]'
                            . '|is_image[userfile]'
                            . '|mime_in[userfile,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                            . '|max_size[userfile,100]'
                            . '|max_dims[userfile,1024,768]',
                    ],
                ];
                
                if (! $this->validate($validationRule)) {
                    $data['status'] = false;
                }
        
                if ($img->isValid() && ! $img->hasMoved()) {
                    $newName = $img->getRandomName();
                    $img->move('./ticket/' . $ticket_id , $newName);
                }

                $name = $img->getName();
                //update ticket image
                $param = array(
                    'img' => $newName,
                );
                $result = $Ticket->update($ticket_id, $param);
                //send respose
                if(!is_null($result)){
                    $data['status'] = true;
                    $data['message'] = SEND_TICKET;
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

    public function description($ticket_id=null)
    {
        //get count product shopping cart
        $cart_count = Cart::count();
        //get data session
        $id = $_SESSION['id'];
        //get data planes
        $Ticket = new TicketsModel();
        $obj_ticket = $Ticket->get_data_by_id($ticket_id);
        //get data customer
        $Customer = new CustomerModel();
        $obj_customer = $Customer->get_customer_by_membership_id($id);
        //get concept tikect
        $Concept_ticket = new Concept_ticketsModel();
        $obj_concepto_ticket = $Concept_ticket->get_all();
        //set title
        $title = lang('Global.soporte');
        //render
        $data = array(
            'title' => $title,
            'obj_ticket' => $obj_ticket,
            'obj_customer' => $obj_customer,
            'obj_concepto_ticket' => $obj_concepto_ticket,
            'id' => $id,
            'cart_count' => $cart_count
        );
        return view('backoffice_new/ticket_description', $data);
    }
}
