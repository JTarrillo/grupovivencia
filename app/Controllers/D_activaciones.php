<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\InvoicesModel;
use App\Models\Invoice_detail_membershipModel;
use App\Models\CommissionsModel;
use App\Models\UnilevelsModel;
use App\Models\PointsModel;
use App\Models\MembershipsModel;


use function PHPSTORM_META\map;

class D_activaciones extends BaseController
{
    public function index()
    {
        $Invoices = new InvoicesModel();
        //get all of today's sales
        $obj_invoices = $Invoices->get_sales_pending_delivery();
        //get data session
        $session_name = $_SESSION['first_name'] . " " . $_SESSION['last_name'];
        //send
        $data = array(
            'obj_invoices' => $obj_invoices,
            'session_name' => $session_name
        );
        return view('admin/recojo/list', $data);
    }

    public function load($id = false)
    {
        //get data session
        $session_name = $_SESSION['first_name'] . " " . $_SESSION['last_name'];
        //isset id
        if ($id != "") {
            //get data invoice
            $Invoices = new InvoicesModel();
            $obj_invoices = $Invoices->get_data_pay_tienda_id($id);
            //get data invoice_detail
            $invoice_detail_membership = new Invoice_detail_membershipModel();
            $obj_invoice_detail = $invoice_detail_membership->get_invoices_by_id($id);

            $obj_membership = null;
            $membership_id = null;
            if (isset($obj_invoices->temporal_membership)) {
                $membership_id = $obj_invoices->temporal_membership;
            } elseif (isset($obj_invoices->membership_id)) {
                $membership_id = $obj_invoices->membership_id;
            }
            
            if (isset($membership_id)) {
                //get membership+
                $Membership = new MembershipsModel();
                //set var membership
                $obj_membership = $Membership->get_membership_by_id($membership_id);
            }
        }
        //send data
        $data = array(
            'obj_invoices' => $obj_invoices,
            'obj_invoice_detail' => $obj_invoice_detail,
            'session_name' => $session_name,
            'obj_membership' => $obj_membership
        );
        return view('admin/recojo/load', $data);
    }

    public function verificadas()
    {
        //get data session
        $session_name = $_SESSION['first_name'] . " " . $_SESSION['last_name'];
        $Invoices = new InvoicesModel();
        //get data invoices by customer
        $obj_invoices = $Invoices->get_data_kit_by_customer_completed();
        //send
        $data = array(
            'obj_invoices' => $obj_invoices,
            'session_name' => $session_name
        );
        return view('admin/recojo/list_verificada', $data);
    }

    public function active_delivery()
    {
        //ACTIVE CUSTOMER NORMALY
        if ($this->request->isAJAX()) {
            $Invoices = new InvoicesModel();
            $Customer = new CustomerModel();
            //get data session
            $id = $_SESSION['id'];
            //get data post
            $res = service('request')->getPost();
            $invoice_id = $res['id'];
            //calculate real point
            if ($invoice_id) {
                $param = array(
                    'delivery' => '0',
                    'delivery_date' => date("Y-m-s H:i:s")
                );
                $result = $Invoices->update($invoice_id, $param);
                $data['status'] = true;
            } else {
                $data['status'] = false;
            }
            echo json_encode($data);
            exit();
        }
    }

    public function cancel()
    {
        //ACTIVE CUSTOMER NORMALY
        if ($this->request->isAJAX()) {
            $Invoices = new InvoicesModel();
            $res = service('request')->getPost();
            $invoice_id = $res['invoice_id'];
            $param = array(
                'active' => '3'
            );
            $result = $Invoices->update($invoice_id, $param);
            //validate
            if (!is_null($result)) {
                $data['status'] = true;
            } else {
                $data['status'] = false;
            }
            echo json_encode($data);
            exit();
        }
    }
}
