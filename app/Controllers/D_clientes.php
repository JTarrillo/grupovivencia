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
        if (isset($_SESSION['first_name']) && isset($_SESSION['last_name'])) {
            $session_name = $_SESSION['first_name'] . " " . $_SESSION['last_name'];
        } elseif (isset($_SESSION['name'])) {
            $session_name = $_SESSION['name'];
        } else {
            $session_name = 'Usuario';
        }
        //get data customers con JOIN LEFT para traer clientes sin rango o país asignado
        $Customer = new CustomerModel();
        $obj_customer = $Customer->db->query("
            SELECT DISTINCT
                `customers`.`id`, 
                `customers`.`dni`, 
                `customers`.`code`, 
                `customers`.`ruc`,  
                `customers`.`name`, 
                `customers`.`lastname`,
                `customers`.`mother_last`,
                `customers`.`email`, 
                `customers`.`active`, 
                `customers`.`civil_status`, 
                `customers`.`tipo_agente`, 
                COALESCE(countries.img, 'pe.png') as img, 
                COALESCE(ranges.name, 'Sin asignar') as `range`
            FROM `customers` 
            LEFT JOIN ranges ON customers.range_id = ranges.id
            LEFT JOIN countries ON customers.country_id = countries.id
            ORDER BY customers.id DESC
        ")->getResult();

        //send
        $data = array(
            'obj_customer' => $obj_customer,
            'session_name' => $session_name
        );
        return view('admin/clientes/list', $data);
    }

    /**
     * Mostrar formulario para crear nuevo cliente
     */
    public function create()
    {
        $Paises = new CountriesModel();
        $obj_paises = $Paises->get_data();

        $data = array(
            'obj_paises' => $obj_paises,
        );
        return view('admin/clientes/create', $data);
    }

    /**
     * Guardar nuevo cliente (función separada)
     */
    public function store()
    {
        if (strtoupper($this->request->getMethod()) !== 'POST') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Método no permitido'
            ]);
        }

        $Customer = new CustomerModel();
        $res = $this->request->getVar();

        // Validar datos requeridos
        if (empty($res['name']) || empty($res['lastname']) || empty($res['dni']) || empty($res['email'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Faltan campos requeridos (nombre, apellido, DNI, email)'
            ]);
        }

        $session = session();

        // 1. Preparar datos para tu base de datos local
        $param = array(
            'name'         => $res['name'],
            'lastname'     => $res['lastname'],
            'mother_last'  => isset($res['mother_last']) ? $res['mother_last'] : '',
            'dni'          => $res['dni'],
            'ruc'          => isset($res['ruc']) ? $res['ruc'] : '',
            'email'        => $res['email'],
            'civil_status' => isset($res['civil_status']) ? $res['civil_status'] : '',
            'tipo_agente'  => isset($res['tipo_agente']) ? $res['tipo_agente'] : '',
            'phone'        => isset($res['phone']) ? $res['phone'] : '',
            'country_id'   => isset($res['country_id']) ? $res['country_id'] : 0,
            'address'      => isset($res['address']) ? $res['address'] : '',
            'active'       => isset($res['active']) ? $res['active'] : 1,
            'date'         => date('Y-m-d H:i:s'),
        );

        // 2. Intentar insertar localmente
        if ($Customer->insert($param)) {
            $customer_id = $Customer->getInsertID();

            // --- INICIO INTEGRACIÓN API FACTURACIÓN ---
            $client = \Config\Services::curlrequest();
            $token = $session->get('api_access_token');
            $tokenType = $session->get('api_token_type') ?? 'Bearer';

            // Lógica de tipo de documento para la API
            $tipoDoc = "1"; // DNI por defecto
            $numDoc  = $param['dni'];
            if (!empty($param['ruc'])) {
                $tipoDoc = "6"; // Si hay RUC, mandamos 6
                $numDoc  = $param['ruc'];
            }

            // El array especial que pediste
            $jsonApi = [
                "company_id"       => 1,
                "tipo_documento"   => $tipoDoc,
                "numero_documento" => $numDoc,
                "razon_social"     => trim($param['name'] . ' ' . $param['lastname'] . ' ' . $param['mother_last']),
                "direccion"        => !empty($param['address']) ? $param['address'] : "Lima",
                "ubigeo"           => "150101",
                "distrito"         => "Lima",
                "provincia"        => "Lima",
                "departamento"     => "Lima",
                "telefono"         => !empty($param['phone']) ? $param['phone'] : "999999999",
                "email"            => $param['email']
            ];

            // Consumir API si tenemos token
            $apiMessage = "API no ejecutada (sin token)";
            if ($token) {
                try {
                    $response = $client->post('https://apifacturacion.groupdispensersac.com/api/v1/clients', [
                        'headers' => [
                            'Authorization' => $tokenType . ' ' . $token,
                            'Accept'        => 'application/json',
                        ],
                        'json' => $jsonApi,
                        'http_errors' => false
                    ]);
                    $apiResult = json_decode($response->getBody(), true);
                    $apiMessage = "API ejecutada";
                } catch (\Exception $e) {
                    $apiMessage = "Error API: " . $e->getMessage();
                }
            }
            // --- FIN INTEGRACIÓN API FACTURACIÓN ---

            return $this->response->setJSON([
                'success'     => true,
                'message'     => 'Cliente creado correctamente',
                'customer_id' => $customer_id,
                'api_status'  => $apiMessage,
                'api_debug'   => $jsonApi // Opcional: para ver qué se mandó
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error al crear el cliente'
            ]);
        }
    }

    /**
     * Actualizar cliente (función separada)
     */
    public function update()
    {
        if (strtoupper($this->request->getMethod()) !== 'POST') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Método no permitido'
            ]);
        }

        $Customer = new CustomerModel();
        $res = $this->request->getVar();

        if (empty($res['customer_id'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID de cliente no válido'
            ]);
        }

        $customer_id = $res['customer_id'];

        // Preparar datos para actualizar
        $param = array(
            'name' => isset($res['name']) ? $res['name'] : '',
            'lastname' => isset($res['lastname']) ? $res['lastname'] : '',
            'mother_last' => isset($res['mother_last']) ? $res['mother_last'] : '',
            'dni' => isset($res['dni']) ? $res['dni'] : '',
            'ruc' => isset($res['ruc']) ? $res['ruc'] : '',
            'email' => isset($res['email']) ? $res['email'] : '',
            'civil_status' => isset($res['civil_status']) ? $res['civil_status'] : '',
            'tipo_agente' => isset($res['tipo_agente']) ? $res['tipo_agente'] : '',
            'phone' => isset($res['phone']) ? $res['phone'] : '',
            'country_id' => isset($res['country_id']) ? $res['country_id'] : 0,
            'address' => isset($res['address']) ? $res['address'] : '',
            'active' => isset($res['active']) ? $res['active'] : 1,
        );

        // Manejar cambio de contraseña si se proporciona
        if (isset($res['password']) && !empty($res['password'])) {
            $param['password'] = password_hash($res['password'], PASSWORD_DEFAULT);
        }

        // Intentar actualizar
        if ($Customer->update($customer_id, $param)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Cliente actualizado correctamente'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error al actualizar el cliente'
            ]);
        }
    }

    public function load($id = false)
    {
        //get data session
        if (isset($_SESSION['first_name']) && isset($_SESSION['last_name'])) {
            $session_name = $_SESSION['first_name'] . " " . $_SESSION['last_name'];
        } elseif (isset($_SESSION['name'])) {
            $session_name = $_SESSION['name'];
        } else {
            $session_name = 'Usuario';
        }
        //isset id
        $obj_sponsor = null;
        if ($id != "") {
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
        return view('admin/clientes/load', $data);
    }

    public function form_modal($id = false)
    {
        $obj_customer = null;
        if ($id != false) {
            $Customer = new CustomerModel();
            $obj_customer = $Customer->get_data_customer($id);
        }
        //get paises
        $Paises = new CountriesModel();
        $obj_paises = $Paises->get_data();
        //send data
        $data = array(
            'obj_customer' => $obj_customer,
            'obj_paises' => $obj_paises,
        );
        return view('admin/clientes/form_modal', $data);
    }

    public function validacion()
    {
        // Permite activar/desactivar cliente con solo id y active, o actualizar datos completos
        if (strtolower($this->request->getMethod()) !== 'post') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Método no permitido'
            ]);
        }
        $Customer = new CustomerModel();
        // Log siempre que sea POST
        $res = $this->request->getVar();
        log_message('debug', 'POST data recibido en validacion: ' . print_r($res, true));

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
                'mother_last' => $res['mother_last'],
                'code' => $res['code'],
                'range_id' => $res['range_id'],
                'email' => $res['email'],
                'membership_id' => $res['membership_id'],
                'dni' => $res['dni'],
                'pay' => $res['pay'],
                'phone' => $res['phone'],
                'country_id' => $country,
                'civil_status' => $res['civil_status'],
                'tipo_agente' => $res['tipo_agente'],
                'active' => $res['active'],
            );
            $Customer->update($customer_id, $param);
            if ($password) {
                $param = array(
                    'password' => password_hash($password, PASSWORD_DEFAULT)
                );
                $Customer->update($customer_id, $param);
            }
            if ($customer_bank_id) {
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
            if (!is_null($result)) {
                $data['status'] = true;
                $data['message'] = 'Guardado correctamente';
            } else {
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
        if ($password) {
            $param = array(
                'password' => password_hash($password, PASSWORD_DEFAULT)
            );
            $Customer->update($customer_id, $param);
        }
        if ($customer_bank_id) {
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
        if (!is_null($result)) {
            $data['status'] = true;
            $data['message'] = SAVED;
        } else {
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
        $clientes = $Customer->select('id, code, name, lastname, dni')->findAll();
        return view('admin/clientes/asignar_patocinador', [
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
