<?php

namespace App\Controllers;
use App\Models\CustomerModel;
use App\Models\Customer_bankModel;
use App\Models\CountriesModel;
use App\Models\RangesModel;
use App\Models\BankModel;
use App\Models\MembershipsModel;
use App\Models\UnilevelsModel;

class D_clientes extends BaseController
{   
    public function index()
    {
        //get data session
        $session_name = $_SESSION['admin_name']." ".$_SESSION['admin_lastname'];
        //get data invoices by customer
        $Customer = new CustomerModel();
        $obj_customer = $Customer->get_customer_by_kit();

        //send
        $data = array(
            'obj_customer' => $obj_customer,
            'session_name' => $session_name
        );
        return view('admin/clientes/list', $data);
    }
    






public function updateCustomer()
    {
        if ($this->request->getMethod() === 'post') {
            $Customer = new CustomerModel();
            $Customer_bank = new Customer_bankModel();

            $customer_id = $this->request->getPost('customer_id');
            $tipo_agente = $this->request->getPost('tipo_agente'); // Nuevo campo
            // Otros campos
            $param = [
                'name' => $this->request->getPost('name'),
                'lastname' => $this->request->getPost('lastname'),
                'code' => $this->request->getPost('code'),
                'email' => $this->request->getPost('email'),
                'dni' => $this->request->getPost('dni'),
                'phone' => $this->request->getPost('phone'),
                'country_id' => $this->request->getPost('country_id'),
                'civil_status' => $this->request->getPost('civil_status'),
                'active' => $this->request->getPost('active'),
                'tipo_agente' => $tipo_agente, // Guardar tipo de agente
            ];
            $Customer->update($customer_id, $param);

            // Actualizar contraseña si se ingresó una nueva
            $password = $this->request->getPost('password');
            if ($password) {
                $Customer->update($customer_id, [
                    'password' => password_hash($password, PASSWORD_DEFAULT)
                ]);
            }

            // Actualizar datos bancarios si corresponde
            $customer_bank_id = $this->request->getPost('customer_bank_id');
            if ($customer_bank_id) {
                $Customer_bank->update($customer_bank_id, [
                    'bank_id' => $this->request->getPost('bank_id'),
                    'number' => $this->request->getPost('number'),
                    'cci' => $this->request->getPost('cci')
                ]);
            }

            // Actualizar patrocinador en unilevels si corresponde
            $Unilevels = new UnilevelsModel();
            $unilevel_id = $this->request->getPost('unilevel_id');
            $sponsor_id = $this->request->getPost('sponsor_id');
            if ($unilevel_id && $sponsor_id) {
                $Unilevels->update($unilevel_id, [
                    'sponsor_id' => $sponsor_id
                ]);
            }

            // Redireccionar o mostrar mensaje
            return redirect()->to('/dashboard/clientes')->with('message', 'Cliente actualizado correctamente');
        }

        // Si no es POST, mostrar error
        return redirect()->back()->with('error', 'Método no permitido');
    }



    
    public function load($id = false)
    {
        //get data session
        $session_name = $_SESSION['admin_name']." ".$_SESSION['admin_lastname'];
        //isset id
        $obj_sponsor = null;
        if ($id != ""){
            //get data customer
            $Customer = new CustomerModel();
            $obj_customer = $Customer->get_data_customer($id);
            //get data sponsor
            $obj_sponsor = $Customer->get_data_customer_sponsor($id);
        }
        //get paises
        $Paises = new CountriesModel();
        $obj_paises = $Paises->get_data();
        //get ranges
        $Ranges = new RangesModel();
        $obj_ranges = $Ranges->get_all_data();
        //get bank
        $Bank = new BankModel();
        $obj_bank = $Bank->get_all_active();
        //get membership
        $Memberships = new MembershipsModel();
        $obj_memberships = $Memberships->get_data_countable_adm('0');
        //send data
        $data = array(
            'obj_customer' => $obj_customer,
            'obj_sponsor' => $obj_sponsor,
            'obj_paises' => $obj_paises,
            'obj_bank' => $obj_bank,
            'obj_memberships' => $obj_memberships,
            'obj_ranges' => $obj_ranges,
            'session_name' => $session_name,
        );
        return view('admin/clientes/load',$data);
    }

    public function validacion(){
        // Permite activar/desactivar cliente con solo id y active, o actualizar datos completos
        if (strtolower($this->request->getMethod()) !== 'post') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Método no permitido'
            ]);
        }

        // Log siempre que sea POST
        $res = $this->request->getVar();
        log_message('error', 'POST data recibido en validacion: ' . print_r($res, true));

        // 1. Activar/desactivar rápido (solo si NO viene customer_id)
        if (isset($res['id']) && isset($res['active']) && !isset($res['customer_id'])) {
            $customer_id = (int)$res['id'];
            $active = (string)$res['active'];
            $db = \Config\Database::connect();
            $builder = $db->table('customers');
            $builder->where('id', $customer_id);
            $updateResult = $builder->update(['active' => $active]);
            $dbError = $db->error();
            $data['datos_recibidos'] = $res;
            $data['resultado_update'] = $updateResult;
            $data['db_error'] = $dbError;
            if ($updateResult) {
                $data['success'] = true;
                $data['message'] = 'Estado actualizado correctamente';
            } else {
                $data['success'] = false;
                $data['message'] = 'Error al actualizar estado';
            }
            return $this->response->setJSON($data);
        }

        // 2. Edición completa (guardar formulario)
        if (isset($res['customer_id'])) {
            $Customer = new CustomerModel();
            $Customer_bank = new Customer_bankModel();
            $customer_id = $res['customer_id']; 
            $country = $res['country_id'];
            $unilevel_id = $res['unilevel_id'];
            $sponsor_id = $res['sponsor_id'];
            $password = $res['password'];
            $customer_bank_id = $res['customer_bank_id'];
            $param = array(
                'name' => $res['name'],
                'lastname' => $res['lastname'],
                'code' => $res['code'],
                'range_id' => $res['range_id'],
                'email' => $res['email'],
                'membership_id' => $res['membership_id'],
                'dni' => $res['dni'],  
                'pay' => $res['pay'],  
                'phone' => $res['phone'],
                'country_id' => $country,
                'civil_status' => $res['civil_status'],
                'active' => $res['active'],
            );  
            $Customer->update($customer_id, $param);    
            if($password){
                $param = array(
                    'password'=> password_hash($password, PASSWORD_DEFAULT)
                );  
                $Customer->update($customer_id, $param);    
            }
            if($customer_bank_id){
                $param = array(
                    'bank_id' => $res['bank_id'],
                    'number' => $res['number'],
                    'cci' => $res['cci']
                );  
                $Customer_bank->update($customer_bank_id, $param);    
            }
            $Unilevels = new UnilevelsModel();
            $param = array(
                'sponsor_id' => $sponsor_id
            );  
            $result = $Unilevels->update($unilevel_id, $param);    
            if(!is_null($result)){
                $data['status'] = true;
                $data['message'] = 'Guardado correctamente';
            }else{
                $data['status'] = false;
                $data['message'] = 'Error al guardar';
            }     
            return $this->response->setJSON($data);
        }
            // ...actualización completa de datos (formulario)
            $session = session();
            $id = $session->get('id');
            $Customer_bank = new Customer_bankModel();
            $customer_id = $res['customer_id']; 
            $country = $res['country_id'];
            $unilevel_id = $res['unilevel_id'];
            $sponsor_id = $res['sponsor_id'];
            $password = $res['password'];
            $customer_bank_id = $res['customer_bank_id'];
            $param = array(
                'name' => $res['name'],
                'lastname' => $res['lastname'],
                'code' => $res['code'],
                'range_id' => $res['range_id'],
                'email' => $res['email'],
                'membership_id' => $res['membership_id'],
                'dni' => $res['dni'],  
                'pay' => $res['pay'],  
                'phone' => $res['phone'],
                'country_id' => $country,
                'civil_status' => $res['civil_status'],
                'pay' => $res['pay'],
                'active' => $res['active'],
            );  
            $Customer->update($customer_id, $param);    
            if($password){
                $param = array(
                    'password'=> password_hash($password, PASSWORD_DEFAULT)
                );  
                $Customer->update($customer_id, $param);    
            }
            if($customer_bank_id){
                $param = array(
                    'bank_id' => $res['bank_id'],
                    'number' => $res['number'],
                    'cci' => $res['cci']
                );  
                $Customer_bank->update($customer_bank_id, $param);    
            }
            $Unilevels = new UnilevelsModel();
            $param = array(
                'sponsor_id' => $sponsor_id
            );  
            $result = $Unilevels->update($unilevel_id, $param);    
            if(!is_null($result)){
                $data['status'] = true;
                $data['message'] = SAVED;
            }else{
                $data['status'] = false;
                $data['message'] = ERROR;
            }     
            return $this->response->setJSON($data);
        

        // Si no se procesó la petición, devolver respuesta JSON por defecto
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Petición inválida o datos incompletos'
        ]);
    }

    public function asignar_patocinador()
    {
        $Customer = new CustomerModel();
        $Unilevels = new UnilevelsModel();
        $msg = null;
        // Procesar formulario POST
        if ($this->request->getMethod() === 'post') {
            $customer_id = $this->request->getPost('customer_id');
            $sponsor_id = $this->request->getPost('sponsor_id');
            // Buscar registro en unilevels
            $unilevel = $Unilevels->where('customer_id', $customer_id)->first();
            if ($unilevel) {
                $Unilevels->update($unilevel['id'], ['sponsor_id' => $sponsor_id]);
                $msg = 'Patrocinador actualizado correctamente.';
            } else {
                // Si no existe, crear registro
                $Unilevels->insert(['customer_id' => $customer_id, 'sponsor_id' => $sponsor_id, 'active' => 1, 'created_at' => date('Y-m-d H:i:s')]);
                $msg = 'Patrocinador asignado correctamente.';
            }
        }
        // Obtener lista de clientes para los selects
$clientes = $Customer->select('id, code, name, lastname, dni')->findAll();        return view('admin/clientes/asignar_patocinador', [
            'clientes' => $clientes,
            'msg' => $msg
        ]);
    }
    public function eliminar()
    {
        //ACTIVE CUSTOMER NORMALY
        if ($this->request->isAJAX()) {
            $Customer = new CustomerModel();
            //get data post
            $res = service('request')->getPost();
            $id = $res['id'];
            //verify                     
            if ($id != null) {
                $result = $Customer->eliminar($id);
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