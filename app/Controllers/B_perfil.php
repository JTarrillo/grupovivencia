<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\CommissionsModel;
use App\Models\CountriesModel;
use App\Models\BankModel;
use App\Models\KycModel;
use App\Models\Customer_bankModel;
use CodeIgniter\Files\File;
use Fluent\ShoppingCart\Facades\Cart;

class B_perfil extends BaseController
{
  public function index()
  {
    //get count product shopping cart
    $cart_count = Cart::count();
    //get data session
    $id = $_SESSION['client_id'];
    $Customer = new CustomerModel();
    //get all row
    $obj_customer = $Customer->get_data_customer_perfil($id);
    //get total commissions
    $Commissions = new CommissionsModel();
    $obj_commission_total = $Commissions->get_total_commission($id);
    //get customer bank
    $Customer_bank = new Customer_bankModel();
    $obj_customer_bank = $Customer_bank->get_total_by_customer_id($id);
    //set title
    $title = lang('Global.perfil');
    //send
    $data = array(
      'title' => $title,
      'obj_customer_bank' => $obj_customer_bank,
      'obj_customer' => $obj_customer,
      'cart_count' => $cart_count,
    );
    return view('backoffice_new/perfil', $data);
  }

  public function setting()
  {
    //get count product shopping cart
    $cart_count = Cart::count();
    //get data session
    $id = $_SESSION['client_id'];
    //get data acustomer
    $Customer = new CustomerModel();
    $obj_customer = $Customer->get_data_customer_perfil($id);
    //get bank
    $Bank = new BankModel();
    $obj_bank = $Bank->get_all_active();
    //get customer bank
    $Customer_bank = new Customer_bankModel();
    $obj_customer_bank = $Customer_bank->get_by_customer_id($id);
    //get data acustomer
    $Paises = new CountriesModel();
    $obj_paises = $Paises->get_data();
    //get data total
    $Commissions = new CommissionsModel();
    $obj_commission_total = $Commissions->get_total_commission($id);
    //set title
    $title = lang('Global.configuracion');
    //send data
    $data = array(
      'title' => $title,
      'obj_bank' => $obj_bank,
      'obj_customer_bank' => $obj_customer_bank,
      'obj_paises' => $obj_paises,
      'obj_customer' => $obj_customer,
      'cart_count' => $cart_count
    );
    return view('backoffice_new/setting', $data);
  }

  public function save_profile()
  {
    if ($this->request->isAJAX()) {
      $id = $_SESSION['client_id'];
      $Customer = new CustomerModel();
      $request = \Config\Services::request();
      //get data post
      $name = $request->getPostGet('name');
      $last_name = $request->getPostGet('last_name');
      $co_name = $request->getPostGet('co_name');
      //$dni = $request->getPostGet('dni');
      $phone = $request->getPostGet('phone');
      $address = $request->getPostGet('address');
      //$country = $request->getPostGet('country');
      $img = $this->request->getFile('avatar');
      //set path
      $estructura = './avatar/' . $id;
      //create file
      if (!is_dir($estructura)) {
        mkdir($estructura, 0777, true);
      }
      //upload imagen 1
      //validation
      $validationRule = [
        'avatar' => [
          'label' => 'Image File',
          'rules' => 'uploaded[userfile]'
            . '|is_image[userfile]'
            . '|mime_in[userfile,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
            . '|max_size[userfile,100]'
            . '|max_dims[userfile,1024,768]',
        ],
      ];
      if (!$this->validate($validationRule)) {
        $data['status'] = false;
      }
      if ($img->isValid() && !$img->hasMoved()) {
        $newName = $img->getRandomName();
        $image = \Config\Services::image()
          ->withFile($img)
          ->resize(200, 200, true, 'height')
          ->save(FCPATH . "/avatar/$id/" . $newName);
        $img->move(WRITEPATH . "/avatar/$id");
        //get name
        $img = $newName;
      } else {
        $img = null;
      }
      //UPDATE DATA EN CUSTOMER TABLE
      $param = array(
        'name' => $name,
        'lastname' => $last_name,
        //'dni' => $dni,
        'avatar' => $img,
        'phone' => $phone,
        'co_name' => $co_name,
        'address' => $address,
        //'country_id' => $country,
      );

      $result = $Customer->update($id, $param);
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

  public function kyc()
  {
    //get count product shopping cart
    $cart_count = Cart::count();
    //get data session
    $id = $_SESSION['client_id'];
    //get data acustomer
    $Customer = new CustomerModel();
    $obj_customer = $Customer->get_data_customer_perfil($id);
    //get data acustomer
    $Paises = new CountriesModel();
    $obj_paises = $Paises->get_data();
    //get data total
    $Commissions = new CommissionsModel();
    $obj_commission_total = $Commissions->get_total_commission($id);
    //set var total & available
    $obj_earn_total = $obj_commission_total->total_comissions;
    $obj_earn_disponible = $obj_commission_total->total_disponible;
    //set title
    $title = KYC;
    //send data
    $data = array(
      'title' => $title,
      'obj_paises' => $obj_paises,
      'obj_earn_total' => $obj_earn_total,
      'obj_earn_disponible' => $obj_earn_disponible,
      'obj_customer' => $obj_customer,
      'cart_count' => $cart_count,
    );
    return view('backoffice_new/kyc', $data);
  }

  public function kyc_validate()
  {
    if ($this->request->isAJAX()) {
      $id = $_SESSION['client_id'];
      $Customer = new CustomerModel();
      $Kyc = new KycModel();
      //get data file
      $img = $this->request->getFile('img');
      $img2 = $this->request->getFile('img2');
      //set path
      $estructura = './kyc/' . $id;
      //create file
      if (!is_dir($estructura)) {
        mkdir($estructura, 0777, true);
      }
      //upload imagen 1
      //validation
      $validationRule = [
        'img' => [
          'label' => 'Image File',
          'rules' => 'uploaded[userfile]'
            . '|is_image[userfile]'
            . '|mime_in[userfile,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
            . '|max_size[userfile,100]'
            . '|max_dims[userfile,1024,768]',
        ],
      ];

      if (!$this->validate($validationRule)) {
        $data['status'] = false;
      }

      if ($img->isValid() && !$img->hasMoved()) {
        $newName = $img->getRandomName();
        $img->move('./kyc/' . $id, $newName);
      }

      if ($img2->isValid() && !$img2->hasMoved()) {
        $newName2 = $img2->getRandomName();
        $img2->move('./kyc/' . $id, $newName2);
      }

      //update table customer
      $param = array(
        'kyc' => '1',
      );
      $Customer->update($id, $param);
      //set var image
      $anverso = $img->getName();
      $reverso = $img2->getName();
      //insert or update table KYC
      //verify si existe
      $kyc_id = $Kyc->verify_customer_id_kyc($id);
      //verify
      if ($kyc_id == "") {
        //insert
        $param_kyc = array(
          'customer_id' => $id,
          'date' => date("Y-m-d H:i:s"),
          'anverso' => $anverso,
          'reverso' => $reverso
        );
        $result = $Kyc->insertar($param_kyc);
      } else {
        //update data
        $param_kyc = array(
          'date' => date("Y-m-d"),
          'anverso' => $anverso,
          'reverso' => $reverso
        );
        $result = $Kyc->update($id, $param_kyc);
      }
      if (!is_null($result)) {
        $data['status'] = true;
        $data['message'] = SAVED;
      } else {
        $data['status'] = false;
        $data['message'] = ERROR;
      }
      //respose
      echo json_encode($data);
      exit();
    }
  }

  public function pin()
  {
    //get data session
    $id = $_SESSION['client_id'];
    //get data acustomer
    $Customer = new CustomerModel();
    $obj_customer = $Customer->get_data_customer_perfil($id);
    //set founter
    $founder = $obj_customer[0]->founder;
    //Verify the percentage of customization
    $percent_cust = $this->percentageofcustomization($obj_customer);
    //get data acustomer
    $Paises = new PaisesModel();
    $obj_paises = $Paises->get_data();
    //get data total
    $Commissions = new CommissionsModel();
    $obj_commission_total = $Commissions->get_total_commission($id);
    //set var total & available
    $obj_earn_total = $obj_commission_total[0]->total_comissions;
    $obj_earn_disponible = $obj_commission_total[0]->total_disponible;
    //set title
    $title = PIN;
    //send data
    $data = array(
      'title' => $title,
      'founder' => $founder,
      'percent_cust' => $percent_cust,
      'obj_paises' => $obj_paises,
      'obj_earn_total' => $obj_earn_total,
      'obj_earn_disponible' => $obj_earn_disponible,
      'obj_customer' => $obj_customer,
    );
    return view('backoffice_new/pin', $data);
  }

  public function save_pin()
  {
    if ($this->request->isAJAX()) {
      $id = $_SESSION['client_id'];
      $Customer = new CustomerModel();
      $request = \Config\Services::request();
      //get data post
      $code_1 = $request->getPostGet('code_1');
      $code_2 = $request->getPostGet('code_2');
      $code_3 = $request->getPostGet('code_3');
      $code_4 = $request->getPostGet('code_4');
      $code_5 = $request->getPostGet('code_5');
      $code_6 = $request->getPostGet('code_6');
      //set pin
      $pin = $code_1 . $code_2 . $code_3 . $code_4 . $code_5 . $code_6;
      //update pin
      $param = array(
        'pin' => $pin,
      );
      $result = $Customer->update($id, $param);

      if (!is_null($result)) {
        $data['status'] = true;
      } else {
        $data['status'] = false;
      }
      //respose
      echo json_encode($data);
      exit();
    }
  }

  public function recover_pin()
  {
    if ($this->request->isAJAX()) {
      $name = $_SESSION['client_name'];
      $username = $_SESSION['username'];
      $email = $_SESSION['client_email'];
      //send email recover
      $url = "https://genexlatam.com/recover-pin/$username";
      $this->message($name, $email, $url);
      $data['status'] = true;
      //respose
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
              <tbody><tr>
                <td style='color:#485360;font:100 10px Arial;padding:0px 0% 10px;text-align:center'>
                  <p>
                      GENEX LATAM CORPORATION
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
                              <img border='0' style='display:inline-block' src='https://genexlatam.com/assets/images/logo/logo.png' width='90' class='CToWUd'>
                            </td>
                              </tr>
                        </tbody>
                      </table>
                    </td>
                    </tr>
                    <tr>
                      <td style='font:20px Arial;padding:0 0 11px;color:#485360;text-align:center'>
                            Saludos, $name                                 
                      </td>
                    </tr>
                    <tr>
                      <td style='color:#485360;font:400 28px/28px Arial;padding:0 7%;text-align:center'>
                        Da clic en el siguiente enlace para que puedas modificar su pin de seguridad.
                      </td>
                    </tr>
                    <tr>
                      <td style='color:#485360;font:600 16px Arial;letter-spacing:-1px;padding:30px 0 22px;text-align:center'>
                        <p>
                          <a href='$url' target='_blank'>
                                Clic Aquí
                          </a>
                        </p>
                      </td>
                    </tr>
                    <tr>
                        <td style='background-color:#1577ab;color:#ffffff;font:800 15px Arial;padding:3%' align='center'>
                        Accede a tu oficina virtual a través del siguiente enlance
                          <table style='margin:1% auto'>
                            <tbody>
                            <tr>
                              <td style='background-color:#f7952f;color:#ffffff' align='center'>
                              <a href='https://genexlatam.com/' target='_blank'>
                                www.genexlatam.com                         
                              </a>
                              </td>
                            </tr>
                          </tbody>
                          </table>
                        </td>
                      </tr>
      </tbody></table>
                    .</html>", 70, "\n", true);

    //set data to send email
    $email = \Config\Services::email();
    $email->setFrom("soporte@genexlatam.com", "Genex Latam");
    $email->setTo($email_customer);
    $email->setSubject("Recuperar PIN - [GENEX LATAM]");
    $email->setMessage($mensaje);
    $email->send();
    return true;
  }

  public function save_pass()
  {
    if ($this->request->isAJAX()) {
      //get session
      $db = \Config\Database::connect();
      $id = $_SESSION['client_id'];
      $Customer = new CustomerModel();
      //get post
      $request = \Config\Services::request();
      $currentpass = $request->getPostGet('currentpass');
      $newpass = $request->getPostGet('newpass');
      $confirmpass = $request->getPostGet('confirmpass');
      //verify pass            
      if ("$newpass" == "$confirmpass") {
        //get pass by customer_id
        $user_password = $db->query('select password from customers where id = ' . $id . '')->getRow();
        $authenticatePassword = password_verify($currentpass, $user_password->password);
        //verify
        if ($authenticatePassword) {
          //set param update
          $update_data = array(
            'password' => password_hash($newpass, PASSWORD_DEFAULT)
          );
          $result = $Customer->update($id, $update_data);
          $data['status'] = true;
          $data['message'] = SAVED;
        } else {
          $data['status'] = false;
          $data['message'] = WRONG_PASSWORD;
        }
      } else {
        $data['status'] = false;
        $data['message'] = PASS_NO_EQUAL;
      }
      echo json_encode($data);
      exit();
    }
  }

  public function save_bank()
  {
    if ($this->request->isAJAX()) {
      //get session data
      $customer_id = $_SESSION['client_id'];
      $Customer_bank = new Customer_bankModel();
      //get data post
      $res = service('request')->getPost();
      $id = $res['id'];
      $bank_id = $res['bank_id'];
      $number = $res['number'];
      $cci = $res['cci'];
      //insert table customer bank
      if ($id != "") {
        //update
        $param = array(
          'bank_id' => $bank_id,
          'number' => $number,
          'cci' => $cci,
          'active' => '1',
          'updated_at' => date("Y-m-d H:i:s")
        );
        $result = $Customer_bank->update($id, $param);
      } else {
        //insert
        $param = array(
          'customer_id' => $customer_id,
          'bank_id' => $bank_id,
          'number' => $number,
          'cci' => $cci,
          'active' => '1',
          'created_at' => date("Y-m-d H:i:s")
        );
        $result = $Customer_bank->insert($param);
      }

      //verify
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

  public function percentageofcustomization($obj_customer)
  {
    //set var        
    $kyc = $obj_customer->kyc;
    $avatar = $obj_customer->avatar;
    //calculate
    $kyc = $kyc >= 1 ? 50 : 0;
    $avatar = $avatar <> null ? 50 : 0;
    return $percent = $kyc + $avatar;
  }

  public function message_wallet($name, $email_customer)
  {
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
                        Your wallet was successfully modified. 
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
                            It wasn't you, <a href='https://bca-capital.com/configuracion' target='_blank'>
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
    $email->setSubject("[BCA CAPITAL] Wallet changed $date");
    $email->setMessage($mensaje);
    $email->send();
    return true;
  }

  public function save_billing()
  {
    if ($this->request->isAJAX()) {
      $id = $_SESSION['client_id'];
      $Customer = new CustomerModel();
      $res = service('request')->getPost();
      //get data post
      $ruc = $res['ruc'];
      $type_payment = $res['type_payment'];

      $param = array(
        'ruc' => $ruc,
        'tipo_comprobante' => $type_payment
      );

      $result = $Customer->update($id, $param);
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
}