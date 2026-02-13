<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\MembershipsModel;


class Forget extends BaseController
{

  public function index()
  {
    //get contable product
    $Memberships = new MembershipsModel();
    //get products footer
    $params = array(
      "select" => "*",
      "where" => "`contable` = '1' and `active` = '1'",
      "order" => "price ASC",
      "limit" => "12",
    );
    $obj_products = $Memberships->search($params);
    //send
    $data = [
      "obj_products" => $obj_products
    ];

    /// view forget page
    return view('recover_pass', $data);
  }

  public function validate_captcha()
  {
    define("SECRET_KEY", '6LequQIqAAAAAHHTMpgKlN2d2qKlZICveTw7YYb2');
    $token = $_POST['token'];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => SECRET_KEY, 'response' => $token)));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    $arrResponse = json_decode($response, true);

    if ($arrResponse["success"] == '1' && $arrResponse["score"] >= 0.5) {
      $data = array("success" => 1, "message" => "Token reCAPTCHA válido.");
    } else {
      $data = array("success" => 0, "message" => "Error en la verificación del reCAPTCHA.");
    }

    header('Content-Type: application/json');
    echo json_encode($data);
  }

  public function validacion()
  {
    $Customer = new CustomerModel();
    //get data post
    $res = service('request')->getPost();
    $username = $res['username'];
    $obj_customer = $Customer->get_search_by_username($username);
    //verify            
    if (!empty($obj_customer)) {
      //send message
      $url = "https://alelifeglobal.com/password/$username";
      //send message
      $this->message($obj_customer->name, $obj_customer->email, $url);
      //send json
      $data['status'] = true;
      $data['message'] = SEND;
    } else {
      $data['message'] = USER_NO_EXIT;
      $data['status'] = false;
    }
    echo json_encode($data);
    exit();
  }

  public function recover($username = false)
  {
    //get customer_id encrypt
    $Customer = new CustomerModel();
    //get data post
    $obj_customer = $Customer->get_search_by_username($username);
    //get contable product
    $Memberships = new MembershipsModel();
    //get products footer
    $params = array(
      "select" => "*",
      "where" => "`contable` = '1' and `active` = '1'",
      "order" => "price ASC",
      "limit" => "12",
    );
    $obj_products = $Memberships->search($params);
    //send data
    $data = array(
      'obj_customer' => $obj_customer,
      "obj_products" => $obj_products
    );
    /// view
    return view('change_pass', $data);
  }

  public function validate_recover()
  {
    $Customer = new CustomerModel();
    //get data post
    $res = service('request')->getPost();
    $customer_id = $res['customer_id'];
    $pass = $res['pass'];
    //SET PARAMETER
    if (!empty($customer_id)) {
      //update table customer
      $data_customer = array(
        'password' => password_hash($pass, PASSWORD_DEFAULT),
      );
      $Customer->update($customer_id, $data_customer);
      //send json
      $data['status'] = true;
      $data['message'] = PASS_CHANGE;
    } else {
      $data['status'] = false;
      $data['message'] = ERROR;
    }
    echo json_encode($data);
    exit();
  }

  public function recover_pin($username = false)
  {
    //get customer_id encrypt
    $Customer = new CustomerModel();
    //get data post
    $obj_customer = $Customer->get_search_by_username($username);

    var_dump($obj_customer);
    die();

    //send data
    $data = array(
      'obj_customer' => $obj_customer,
    );
    /// view
    return view('change_pin', $data);
  }

  public function validate_pin()
  {
    if ($this->request->isAJAX()) {
      $Customer = new CustomerModel();
      //get data post
      $res = service('request')->getPost();
      $customer_id = $res['customer_id'];
      $pin = $res['pin'];
      //SET PARAMETER
      if (!empty($customer_id)) {
        //update table customer
        $data_customer = array(
          'pin' => $pin,
        );
        $Customer->update($customer_id, $data_customer);
        //send json
        $data['status'] = true;
      } else {
        $data['status'] = false;
      }
      echo json_encode($data);
      exit();
    }
  }

  public function message($name, $email_customer, $url)
  {
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
                              <img border='0' style='display:inline-block' src='https://alelifeglobal.com/assets/front/img/logo/logo.png' width='90' class='CToWUd'>
                            </td>
                              </tr>
                        </tbody>
                      </table>
                    </td>
                    </tr>
                    <tr>
                      <td style='font:20px Arial;padding:0 0 11px;color:#485360;text-align:center'>
                            Hola, $name                                 
                      </td>
                    </tr>
                    <tr>
                      <td style='color:#485360;font:400 28px/28px Arial;padding:0 7%;text-align:center'>
                        Haga clic en el siguiente enlace para crear una nueva contraseña.
                      </td>
                    </tr>
                    <tr>
                      <td style='color:#485360;font:600 16px Arial;letter-spacing:-1px;padding:30px 0 22px;text-align:center'>
                        <p>
                          <a href='$url' target='_blank'>
                            Click Aquí
                          </a>
                        </p>
                      </td>
                    </tr>
        </tbody></table>
                    .</html>", 70, "\n", true);

    //set data to send email
    $email = \Config\Services::email();
    $email->setFrom("system@alelifeglobal.com", "Alelife Global");
    $email->setTo($email_customer);
    $email->setSubject("Recuperar Password - [Alelife Global]");
    $email->setMessage($mensaje);
    $email->send();
    return true;
  }
}
