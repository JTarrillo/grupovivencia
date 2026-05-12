<?php

namespace App\Controllers;
use App\Models\CommissionsModel;
use App\Models\Pay_commissionModel;
use App\Models\PaysModel;


class D_activar_pagos extends BaseController
{   
    public function index()
    {
        //get data session
        $session_name = $_SESSION['name']." ".$_SESSION['lastname'];
        //get data pay
        $Pay = new PaysModel();
        $obj_pay = $Pay->get_crud_pay();

        //get pending pay
        $obj_total = $Pay->get_pending_pay();
        //send
        $data = array(
            'obj_pay' => $obj_pay,
            'obj_total' => $obj_total,
            'session_name' => $session_name
        );
        return view('admin/activar_pagos/list', $data);
    }
    
    public function load($id=false){
        //get session
        $session = session();
        $session_name = $session->get('name')." ".$session->get('lastname');
        $obj_pay = null;
        $Pay = new PaysModel();
        //verify
        if ($id != ""){
            //get data customer and pay
            $obj_pay = $Pay->get_data_by_customer_id($id);
          }
        //send
        $data = array(
            'obj_pay' => $obj_pay,
            'session_name' => $session_name
        );
        return view('admin/activar_pagos/load', $data);
    }

    public function pagado(){
        if ($this->request->isAJAX()) {
            $session = session();
            //get data session
            $id = $session->get('id');
            $Pay = new PaysModel();
            ///get data post
            $res = service('request')->getPost();
            $pay_id = $res['id'];
            $amount = $res['amount'];
            $discount = $res['discount'];
            $total = $res['total'];
            $email = $res['email'];
            $first_name = $res['name'];
            //update table pay
            $param = array(
                        'active' => '2',
                        'date_pay' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s")
                    ); 
            $result = $Pay->update($pay_id, $param);   
            //send message email
            $this->message($first_name, $email, $amount, $discount, $total);
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

    public function devolver(){
        if ($this->request->isAJAX()) {
            $session = session();
            //get data session
            $id = $session->get('id');
            $Commissions = new CommissionsModel();
            $Pay = new PaysModel();
            $Pay_commission = new Pay_commissionModel();
            //get data post
            $res = service('request')->getPost();
            $pay_id = $res['id'];
            //update table pay
            $param = array(
                        'active' => '3',
                        'updated_at' => date("Y-m-d H:i:s")
                    ); 
            $Pay->update($pay_id, $param);   
             //get commission id       
            $obj_pays = $Pay_commission->get_commission_id($pay_id);          
            $commissions_id = $obj_pays->commissions_id;
            //update table comissions
            $param = array(
                    'amount' => 0,
                    'updated_at' => date("Y-m-d H:i:s")
            );          
            $result = $Commissions->update($commissions_id, $param);   
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

    public function validacion(){
        //ACTIVE CUSTOMER NORMALY
        if ($this->request->isAJAX()) {
            //get session
            $session = session();
            $id = $session->get('id');
            $Pay = new PaysModel();
            //get data
            $res = service('request')->getPost();
            $pay_id = $res['id'];
            $amount = $res['amount'];
            $discount = $res['discount'];
            $total = $res['total'];
            $hash_id = $res['hash_id'];
            $active = $res['active'];
            if(!is_null($pay_id)){
                //update table pay
                $param = array(
                    'amount' => $amount,
                    'discount' => $discount,
                    'total' => $total,
                    'hash_id' => $hash_id,
                    'active' => $active
                ); 
                $result = $Pay->update($pay_id, $param);   
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
            $Pay = new PaysModel();
            //get data post
            $res = service('request')->getPost();
            $id = $res['id'];
            //verify                     
            if($id != null){
                $result = $Pay->eliminar($id);
                if(!is_null($result)){
                    $data['status'] = true;
                    $data['message'] = DELETED;
                }else{
                    $data['status'] = false;
                    $data['message'] = ERROR;
                }     
            }else{
                $data['status'] = false;
            }
            echo json_encode($data); 
            exit();
        }
    }

    public function message($name, $email_customer, $amount, $discount, $amount_total){  
        $date = date("Y-m-d H:i:s");
        $mensaje = wordwrap("<html>
        <table width='750' border='0' align='center' cellpadding='0' cellspacing='0' bgcolor='#f8f6f7' style='padding:15px 75px 15px'>
        <tbody><tr>
          <td align='center'>
            <table width='100%' border='0' align='center' cellpadding='0' cellspacing='0' style='background-color:#fff'>
              <tbody>
              <tr>
                <td>
                  <table width='600' border='0' align='center' cellpadding='0' cellspacing='0'>
                    <tbody><tr>
                      <td width='100%' style='padding:43px 0 38px;text-align:center'>
                        <table align='center' bgcolor='#ffffff' border='0' cellpadding='0' cellspacing='0'>
                          <tbody><tr style='text-align:center'>
                            <td height='26'>
                                <img border='0' style='display:inline-block' src='https://alelifeglobal.com/assets/front/img/logo/logo.png?1' width='90' class='CToWUd'>
                            </td>
                              </tr>
                        </tbody>
                      </table>
                    </td>
                    </tr>
                    <tr>
                      <td style='font:20px Arial;padding:0 0 11px;color:#485360;text-align:center'>
                            Felicidades, $name                                
                      </td>
                    </tr>
                    <tr>
                      <td style='color:#485360;font:400 28px/28px Arial;padding:0 7%;text-align:center'>
                         Su solicitud de cobro por <strong>s/.$amount</strong> ha sido procesada con éxito. .
                      </td>
                    </tr>
                    <tr>
                  <td bgcolor='#ffffff' style='text-align:center;padding:10px 0 0 0'>
                    <table style='display:inline-block' border='0' cellspacing='0' cellpadding='0'>
                        <tbody>
                    <tr>
                        <td style='padding:32px;background-color:#ffffff'><table bgcolor='#FFFFFF' border='0' cellspacing='0' cellpadding='0' align='center' style='display:inline-block'>
                        <tbody><tr>
                            <td><table align='center' width='100%' border='0' cellpadding='0' cellspacing='0' style='min-width:230px'>
                            <tbody><tr>
                                <td style='color:#3d3d3d;font:700 15px Arial;letter-spacing:-1px;text-align:left'>
                                    Pago por banco.       
                                </td>
                            </tr>
                            <tr>
                                <td height='3' style='padding:5px 0 10px'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                <tbody><tr>
                                    <td bgcolor='#8e8f8f' height='3'></td>
                                </tr>
                                </tbody></table></td>
                            </tr>
                            <tr>
                                <td><table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                <tbody><tr>
                                    <td style='color:#111519;font:400 12px Arial;padding-bottom:4px' align='left'>
                                    Importe
                                    </td>
                                    <td style='color:#111519;font:700 12px Arial' align='right'>
                                        S/.$amount
                                    </td>
                                </tr>
                                </tbody></table></td>
                            </tr>
                            <tr>
                                <td><table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                <tbody><tr>
                                    <td style='color:#111519;font:400 12px Arial;padding-bottom:4px' align='left'>
                                    Descuento
                                    </td>
                                    <td style='color:#111519;font:700 12px Arial' align='right'>
                                        S/.$discount
                                    </td>
                                </tr>
                                </tbody>
                                </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table width='100%' border='0' cellspacing='0' cellpadding='0'></table>
                                </td>
                            </tr>
                            <tr>
                                <td height='1' style='padding:12px 0 12px'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                <tbody><tr>
                                    <td bgcolor='#8e8f8f' height='1'></td>
                                </tr>
                                </tbody></table>
                                </td>
                            </tr>
                            <tr>
                                <td><table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                <tbody><tr>
                                    <td style='color:#111519;font:400 12px Arial' align='left'>
                                        Importe Final
                                    </td>
                                    <td style='color:#111519;font:700 18px Arial' align='right'>
                                        S/.$amount_total               
                                    </td>
                                </tr>
                                </tbody></table></td>
                            </tr>
                            </tbody></table></td>
                        </tr>
                        </tbody></table></td>
                    </tr>
                    </tbody></table>
                    </td>
                </tr>
                </tbody>
                </table>
                .</html>", 70, "\n", true);

            //set data to send email
        $email = \Config\Services::email();
        $email->setFrom("system@alelifeglobal.com", "Deposito ALELIFE");
        $email->setTo($email_customer);
        $email->setSubject("Deposito Confirmado $date");
        $email->setMessage($mensaje);
        $email->send();
        return true;
    }
}
