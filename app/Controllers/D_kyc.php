<?php

namespace App\Controllers;
use App\Models\KycModel;
use App\Models\CustomerModel;

class D_kyc extends BaseController
{   
    public function index()
    {
        //get data session
        $session_name = $_SESSION['first_name']." ".$_SESSION['last_name'];
        //get data invoices by customer
        $Kyc = new KycModel();
        $obj_customer = $Kyc->get_customer_kyc();
        //send
        $data = array(
            'obj_customer' => $obj_customer,
            'session_name' => $session_name
        );
        return view('admin/kyc/kyc_pending', $data);
    }

    public function kyc_verificados()
    {
        //get data session
        $session_name = $_SESSION['first_name']." ".$_SESSION['last_name'];
        //get data invoices by customer
        $Kyc = new KycModel();
        $obj_customer = $Kyc->get_customer_kyc_verify();
        //send
        $data = array(
            'obj_customer' => $obj_customer,
            'session_name' => $session_name
        );
        return view('admin/kyc/kyc_verify', $data);
    }
    
    public function verificado(){
        if ($this->request->isAJAX()) {
            $Customer = new CustomerModel();
            $Kyc = new KycModel();
            //get data post
            $res = service('request')->getPost();
            $customer_id = $res['customer_id'];
            $kyc_id = $res['kyc_id'];
            $name = $res['name'];
            $email = $res['email'];
            //verify
            if($customer_id != null){
                $param = array(
                    'kyc' => '2'
                ); 
                $result = $Customer->update($customer_id, $param);
                //Update table kycs
                $param = array(
                    'active' => '2'
                ); 
                $result = $Kyc->update($kyc_id, $param);
                //message confirm
                $this->message_success($name, $email);       
                if(!is_null($result)){
                    $data["status"] = true;
                    $data['message'] = SAVED;
                }else{
                    $data["status"] = false;
                    $data['message'] = ERROR;
                }
            }else{
                $data["status"] = false;
                $data['message'] = ERROR;
            }
            echo json_encode($data);            
            exit();
        }
    }

    public function rechazado(){
        //UPDATE DATA ORDERS
        if ($this->request->isAJAX()) {
            $Customer = new CustomerModel();
            $Kyc = new KycModel();
            //get data post
            $res = service('request')->getPost();
            $customer_id = $res['customer_id'];
            $kyc_id = $res['kyc_id'];
            $name = $res['name'];
            $email = $res['email'];
            //verify
            if($customer_id != null){
                $param = array(
                    'kyc' => '3'
                ); 
                $result = $Customer->update($customer_id, $param);
                //Update table kycs
                $param = array(
                    'active' => '3'
                ); 
                $result = $Kyc->update($kyc_id, $param);
                //message confirm
                $this->message_cancel($name, $email);       
                if(!is_null($result)){
                    $data["status"] = true;
                    $data['message'] = SAVED;
                }else{
                    $data["status"] = false;
                    $data['message'] = ERROR;
                }
            }else{
                $data["status"] = false;
                $data['message'] = ERROR;
            }
            echo json_encode($data);            
        exit();
        }
    }

    public function message_success($name, $email_customer){  
        $date = date("Y-m-d H:i:s"); 
        $mensaje = wordwrap("<html>
        <table width='750' border='0' align='center' cellpadding='0' cellspacing='0' bgcolor='#f8f6f7' style='padding:15px 75px 15px'>
        <tbody><tr>
          <td align='center'>
            <table width='100%' border='0' align='center' cellpadding='0' cellspacing='0' style='background-color:#fff'>
              <tbody><tr>
                <td style='color:#485360;font:100 10px Arial;padding:0px 0% 10px;text-align:center'>
                  <p>
                        BCA CAPITAL
                    </p>
                </td>
              </tr>
              <tr>
                <td>
                  <table width='600' border='0' align='center' cellpadding='0' cellspacing='0'>
                    <tbody><tr>
                      <td width='100%' style='padding:43px 0 38px;text-align:center'>
                        <table align='center' bgcolor='#ffffff' border='0' cellpadding='0' cellspacing='0'>
                          <tbody><tr style='text-align:center'>
                            <td height='26'>
                            <img border='0' style='display:inline-block' src='https://bca-capital.com/assets/images/logo/logo_negro.png' width='90' class='CToWUd'>
                            </td>
                              </tr>
                        </tbody>
                      </table>
                    </td>
                    </tr>
                    <tr>
                      <td style='font:20px Arial;padding:0 0 11px;color:#485360;text-align:center'>
                        Hello, $name                                                             
                      </td>
                    </tr>
                    <tr>
                        <td style='font:20px Arial;padding:0 0 11px;color:#485360;text-align:center'>
                            Your KYC document was successfully approved.
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td style='font:12px Arial;padding:0 0 11px;color:#485360;text-align:center'>
                          <a href='https://bca-capital.com/backoffice_new/kyc' target='_blank'>
                            enter the virtual office.
                          </a>
                        </td>
                      </tr>
      </tbody></table>
                    .</html>", 70, "\n", true);

        //set data to send email
        $email = \Config\Services::email();
        $email->setFrom("system@bca-capital.com", "BCA CAPITAL");
        $email->setTo($email_customer);
        $email->setSubject("[BCA CAPITAL] KYC approved $date");
        $email->setMessage($mensaje);
        $email->send();
        return true;
    }

    public function message_cancel($name, $email_customer){  
        $date = date("Y-m-d H:i:s"); 
        $mensaje = wordwrap("<html>
        <table width='750' border='0' align='center' cellpadding='0' cellspacing='0' bgcolor='#f8f6f7' style='padding:15px 75px 15px'>
        <tbody><tr>
          <td align='center'>
            <table width='100%' border='0' align='center' cellpadding='0' cellspacing='0' style='background-color:#fff'>
              <tbody><tr>
                <td style='color:#485360;font:100 10px Arial;padding:0px 0% 10px;text-align:center'>
                  <p>
                        BCA CAPITAL
                    </p>
                </td>
              </tr>
              <tr>
                <td>
                  <table width='600' border='0' align='center' cellpadding='0' cellspacing='0'>
                    <tbody><tr>
                      <td width='100%' style='padding:43px 0 38px;text-align:center'>
                        <table align='center' bgcolor='#ffffff' border='0' cellpadding='0' cellspacing='0'>
                          <tbody><tr style='text-align:center'>
                            <td height='26'>
                            <img border='0' style='display:inline-block' src='https://bca-capital.com/assets/images/logo/logo_negro.png' width='90' class='CToWUd'>
                            </td>
                              </tr>
                        </tbody>
                      </table>
                    </td>
                    </tr>
                    <tr>
                      <td style='font:20px Arial;padding:0 0 11px;color:#485360;text-align:center'>
                        Hello, $name                                                             
                      </td>
                    </tr>
                    <tr>
                        <td style='font:20px Arial;padding:0 0 11px;color:#485360;text-align:center'>
                            Your KYC verification has been rejected, please check the recommendations we give in the back office.
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td style='font:12px Arial;padding:0 0 11px;color:#485360;text-align:center'>
                          <a href='https://bca-capital.com/configuracion' target='_blank'>
                            enter the virtual office.
                          </a>
                        </td>
                      </tr>
                    </tbody></table>
                      .</html>", 70, "\n", true);
    
          //set data to send email
          $email = \Config\Services::email();
          $email->setFrom("system@bca-capital.com", "BCA CAPITAL");
          $email->setTo($email_customer);
          $email->setSubject("[BCA CAPITAL] KYC rejected $date");
          $email->setMessage($mensaje);
          $email->send();
          return true;
      }
}
