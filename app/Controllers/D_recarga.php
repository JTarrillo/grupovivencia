<?php

namespace App\Controllers;
use App\Models\RechargeModel;
use App\Models\CommissionsModel;

class D_recarga extends BaseController
{   
    public function index()
    {
        //get data session
        $session_name = $_SESSION['first_name']." ".$_SESSION['last_name'];
        //get data invoices by customer
        $Recharge = new RechargeModel();
        $obj_recharge = $Recharge->get_data_pending();
        //send
        $data = array(
            'obj_recharge' => $obj_recharge,
            'session_name' => $session_name
        );
        return view('admin/recarga/pending', $data);
    }

    public function completed()
    {
        //get data session
        $session_name = $_SESSION['first_name']." ".$_SESSION['last_name'];
        //get data invoices by customer
        $Recharge = new RechargeModel();
        $obj_recharge = $Recharge->get_data_completed();
        //send
        $data = array(
            'obj_recharge' => $obj_recharge,
            'session_name' => $session_name
        );
        return view('admin/recarga/completed', $data);
    }

    public function load($id = false)
    {
        //get data session
        $session_name = $_SESSION['first_name']." ".$_SESSION['last_name'];
        //isset id
        if ($id != false){
            $Recharge = new RechargeModel();
            $obj_recharge = $Recharge->get_data_by_id($id);
        }
        //send data
        $data = array(
            'obj_recharge' => $obj_recharge,
            'session_name' => $session_name,
        );
        return view('admin/recarga/load',$data);
    }

    public function validacion(){
        //ACTIVE CUSTOMER NORMALY
        if ($this->request->isAJAX()) {
            $Recharge = new RechargeModel();
            //get data post
            $res = service('request')->getPost();
            $id = $res['id'];
            $amount = $res['amount'];
            $active = $res['active'];
            //verify                     
            if($id != ""){
                //update tabla bonus
                $param = array(
                    'id' => $id,
                    'amount' => $amount,
                    'active' => $active
                );       
                $result = $Recharge->update($id, $param);   
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
            $Recharge = new RechargeModel();
            $Commissions = new CommissionsModel();
            //get data post
            $res = service('request')->getPost();
            $id = $res['id'];
            $customer_id = $res['customer_id'];
            $amount = $res['amount'];
            $name = $res['name'];
            $email = $res['email'];
            //insert table commission
            $param = array(
                'customer_id' => $customer_id,
                'recarge_id' => $id,
                'amount' => $amount,
                'bonus_id' => 3,
                'active' => '1',
                'date' => date("Y-m-d H:i:s"),
            ); 
            $commissions_id = $Commissions->insertar($param);
            //verify
            if($commissions_id != null){
                //update recarge table
                $param = array(
                    'active' => '2'
                ); 
                $result = $Recharge->update($id, $param);
                //send message success
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
            $Recharge = new RechargeModel();
            //get data post
            $res = service('request')->getPost();
            $id = $res['id'];
            $name = $res['name'];
            $email = $res['email'];
            //verify
            if($id != null){
                $param = array(
                    'active' => '3'
                ); 
                $result = $Recharge->update($id, $param);
                //send message success
                $this->message_cancel($name, $email);       
                //send data
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

    public function eliminar(){
        //ACTIVE CUSTOMER NORMALY
        if ($this->request->isAJAX()) {
            $Recharge = new RechargeModel();
            //get data post
            $res = service('request')->getPost();
            $id = $res['id'];
            //verify                     
            if($id != null){
                $result = $Recharge->eliminar($id);
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
                            Your recharge was successfully processed
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
        $email->setSubject("[BCA CAPITAL] Recharge successfully $date");
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
                        Your recharge request was rejected, check the amount, the TxID (transfer identifier) and try again.
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
    $email->setSubject("[BCA CAPITAL] Recharge denied $date");
    $email->setMessage($mensaje);
    $email->send();
    return true;
}
    
}
