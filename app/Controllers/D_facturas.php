<?php

namespace App\Controllers;
use App\Models\InvoicesModel;
use App\Models\MembershipsModel;
use App\Models\CustomerModel;
use App\Libraries\Sunat;

class D_facturas extends BaseController
   
{

     public function emitirDesdeContrato($id)
    {
        // Obtener datos del contrato usando el ID
    $contrato = model('ContractModel')->find($id);
        // Puedes obtener también el cliente y el inmueble si lo necesitas
        // $cliente = model('CustomersModel')->find($contrato['customer_id']);
        // $inmueble = model('LotsModel')->find($contrato['lot_id']);

        // Pasar los datos a la vista de emisión
        return view('admin/facturas/emitir_desde_contrato', [
            'contrato' => $contrato,
            // 'cliente' => $cliente,
            // 'inmueble' => $inmueble,
        ]);
    }
    public function facturasContratos()
    {
        if (isset($_SESSION['first_name']) && isset($_SESSION['last_name'])) {
            $session_name = $_SESSION['first_name'] . " " . $_SESSION['last_name'];
        } elseif (isset($_SESSION['name'])) {
            $session_name = $_SESSION['name'];
        } else {
            $session_name = 'Usuario';
        }
        $Invoices = new InvoicesModel();
        // Obtener facturas asociadas a contratos inmobiliarios
        $facturas_contratos = $Invoices->get_facturas_contratos();
        $data = array(
            'facturas_contratos' => $facturas_contratos,
            'session_name' => $session_name
        );
        return view('admin/facturas/facturas_contratos', $data);
    }
    public function index()
    {
        // Mostrar listado de facturas de contratos inmobiliarios
        $session_name = $_SESSION['first_name'] . " " . $_SESSION['last_name'];
        $Invoices = new InvoicesModel();
        // Obtener facturas asociadas a contratos inmobiliarios
        $facturas_contratos = $Invoices->get_facturas_contratos();
        $data = array(
            'facturas_contratos' => $facturas_contratos,
            'session_name' => $session_name
        );
        return view('admin/facturas/facturas_contratos', $data);
    }
    
    public function load($id = false)
    {
        //get data session
        $session_name = $_SESSION['first_name']." ".$_SESSION['last_name'];
        $Invoices = new InvoicesModel();
        $Membership = new MembershipsModel();
        //isset id
        if ($id != false){
            $obj_invoices = $Invoices->get_data_customer_kit($id);
        }
        //get kit
        $obj_kit = $Membership->get_all();
        //send data
        $data = array(
            'obj_invoices' => $obj_invoices,
            'obj_kit' => $obj_kit,
            'session_name' => $session_name,
        );
        return view('admin/facturas/load',$data);
    }

    public function validacion(){
        if ($this->request->isAJAX()) {
            $Invoices = new InvoicesModel();
            //get data session
            $session = session();
            $id = $session->get('id');
            //get data post
            $res = service('request')->getPost();
            $invoice_id = $res['invoice_id'];
            $active =  $res['active'];
            //update table invoices
            $param = array(
                'active' => $active
                );   
            //update table invoices
            $result = $Invoices->update($invoice_id, $param);
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

    public function eliminar()
    {
        //ACTIVE CUSTOMER NORMALY
        if ($this->request->isAJAX()) {
            $Invoices = new InvoicesModel();
            //get data post
            $res = service('request')->getPost();
            $id = $res['id'];
            //verify                     
            if ($id != null) {
                $result = $Invoices->eliminar($id);
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

    public function emitirFactura()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->to('/dashboard/facturasContratos');
        }

        // DEBUG: Ver datos recibidos
        $debugData = $this->request->getPost();
        log_message('debug', 'emitirFactura POST: ' . print_r($debugData, true));

        $Invoices = new InvoicesModel();
        $contract_id = $this->request->getPost('contract_id');

        // Obtener contrato
        $contrato = model('ContractModel')->find($contract_id);
        if (!$contrato) {
            return $this->response->setJSON(['success' => false, 'error' => 'Contrato no encontrado.']);
        }

        // Obtener cliente
        $cliente = model('CustomerModel')->find($contrato['customer_id']);
        if (!$cliente) {
            return $this->response->setJSON(['success' => false, 'error' => 'Cliente no encontrado.']);
        }

        // Validar DNI
        if (!isset($cliente['dni']) || strlen($cliente['dni']) !== 8) {
            return $this->response->setJSON([
                'success' => false,
                'error' => 'El cliente no tiene un DNI válido (8 dígitos).'
            ]);
        }

        // Obtener la última factura para calcular el número
        $serie = 'B001';
        $ultimo = $Invoices->orderBy('numero', 'DESC')->where('serie', $serie)->first();
        $numero = $ultimo && isset($ultimo['numero']) ? $ultimo['numero'] + 1 : 1;

        // Guardar factura en base de datos
        $data = [
            'customer_id' => $contrato['customer_id'],
            'contract_id' => $contrato['id'],
            'membership_id' => null,
            'qty' => 1,
            'amount' => $contrato['total_amount'],
            'address' => $cliente['address'] ?? '',
            'phone' => $cliente['phone'] ?? '',
            'details' => 'Factura generada desde contrato',
            'store_id' => 1,
            'period_id' => null,
            'temporal_membership' => null,
            'sub_total' => $contrato['total_amount'],
            'payment' => '',
            'igv' => '0.00',
            'total' => $contrato['total_amount'],
            'points' => 0,
            'delivery' => '0',
            'delivery_date' => null,
            'img' => '',
            'date' => date('Y-m-d H:i:s'),
            'cash' => '0.00',
            'yape' => '0.00',
            'card' => '0.00',
            'active' => '1',
            'serie' => $serie,
            'numero' => $numero
        ];

        try {
            $invoice_id = $Invoices->insertar($data);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'error' => 'Error al crear factura: ' . $e->getMessage()
            ]);
        }

        if (!$invoice_id || !is_numeric($invoice_id)) {
            $db = \Config\Database::connect();
            $error = $db->error();
            $errorMsg = isset($error['message']) ? $error['message'] : 'No se pudo emitir la factura.';
            return $this->response->setJSON(['success' => false, 'error' => $errorMsg]);
        }

        // Preparar datos del comprobante para SUNAT (según estructura exacta)
        $datosComprobante = [
            "scenario" => "Boleta Gravada",
            "company_id" => env('SUNAT_COMPANY_ID', 1),
            "branch_id" => 1,
            "serie" => $serie,
            "fecha_emision" => date('Y-m-d'),
            "moneda" => "PEN",
            "tipo_operacion" => "0101",
            "metodo_envio" => "resumen_diario",
            "forma_pago_tipo" => "Contado",
            "client" => [
                "tipo_documento" => "1",
                "numero_documento" => $cliente['dni'],
                "razon_social" => $cliente['name'] . ' ' . $cliente['lastname'],
                "direccion" => $cliente['address'] ?? 'No especificada',
                "telefono" => $cliente['phone'] ?? '',
                "email" => $cliente['email'] ?? ''
            ],
            "detalles" => [
                [
                    "codigo" => "LOTE-CONTRATO-{$contrato['id']}",
                    "descripcion" => "Lote de terreno inmobiliario - Contrato {$contrato['id']}",
                    "unidad" => "NIU",
                    "cantidad" => 1,
                    "mto_valor_unitario" => $contrato['total_amount'],
                    "porcentaje_igv" => 18,
                    "tip_afe_igv" => "10",
                    "codigo_producto_sunat" => "95121601"
                ]
            ],
            "usuario_creacion" => $_SESSION['id'] ?? 'sistema'
        ];

        // Emitir comprobante con SUNAT
        $sunat = new Sunat();
        $respuesta = $sunat->emitirComprobante($datosComprobante);

        // LOG de la respuesta completa
        log_message('info', 'SUNAT Response Type: ' . gettype($respuesta));
        log_message('info', 'SUNAT Response completa: ' . print_r($respuesta, true));

        // Procesar respuesta de SUNAT
        // Verificar si la respuesta tiene alguno de estos formatos:
        if (is_array($respuesta) && (isset($respuesta['success']) || isset($respuesta['data']))) {
            // Éxito - SUNAT devuelve en formato {success: true, data: {...}}
            $data = $respuesta['data'] ?? $respuesta;
            $urlComprobante = $data['enlace'] ?? $data['url'] ?? $data['enlace_del_pdf'] ?? null;
            
            $Invoices->update($invoice_id, [
                'details' => 'SUNAT: Comprobante emitido',
                'api_response' => json_encode($respuesta),
                'status' => 'emitido',
                'serie' => $data['serie'] ?? $serie,
                'numero' => $data['numero'] ?? $numero,
            ]);

            return $this->response->setJSON([
                'success' => true,
                'urlComprobante' => $urlComprobante,
                'sunat_response' => $respuesta,
                'numero_comprobante' => ($data['serie'] ?? $serie) . '-' . ($data['numero'] ?? $numero)
            ]);

        } else {
            // Error en SUNAT, pero la factura ya se creó en BD
            $errorMsg = '';
            if (is_array($respuesta)) {
                $errorMsg = $respuesta['message'] ?? $respuesta['error'] ?? 'Error desconocido en SUNAT';
            } elseif (is_object($respuesta)) {
                $errorMsg = $respuesta->message ?? $respuesta->error ?? 'Error desconocido en SUNAT';
            } else {
                $errorMsg = 'No se pudo generar el comprobante electrónico.';
            }

            log_message('error', 'Error SUNAT: ' . print_r($respuesta, true));

            $Invoices->update($invoice_id, [
                'details' => 'Factura creada. Pendiente SUNAT: ' . $errorMsg,
                'api_response' => json_encode($respuesta),
                'status' => 'pendiente'
            ]);

            // Devolver factura aunque SUNAT falle
            $factura_creada = $Invoices->find($invoice_id);
            
            return $this->response->setJSON([
                'success' => true,
                'warning' => 'Factura creada pero pendiente de SUNAT: ' . $errorMsg,
                'numero_comprobante' => $factura_creada['serie'] . '-' . $factura_creada['numero'],
                'urlComprobante' => null, // SUNAT aún no disponible
                'data' => [
                    'id' => $invoice_id,
                    'numero' => $factura_creada['numero'],
                    'serie' => $factura_creada['serie'],
                    'customer_name' => $cliente['name'] . ' ' . $cliente['lastname'],
                    'total' => $factura_creada['total'],
                    'fecha' => $factura_creada['date'],
                    'status' => 'pendiente'
                ],
                'sunat_response' => $respuesta
            ]);
        }
    }
    public function detalle($id)
    {
        $Invoices = new InvoicesModel();
        $factura = $Invoices->find($id);
        if (!$factura) {
            return $this->response->setJSON(['success' => false, 'error' => 'Factura no encontrada']);
        }
        // Obtener datos de cliente
        $Customers = new CustomerModel();
        $customer = $Customers->find($factura['customer_id'] ?? null);
        
        // Construir respuesta con todos los detalles de la factura
        return $this->response->setJSON([
            'success' => true,
            'factura' => [
                'id' => $factura['id'],
                'numero' => $factura['numero'],
                'serie' => $factura['serie'],
                'total' => $factura['total'],
                'subtotal' => $factura['subtotal'] ?? 0,
                'igv' => $factura['igv'] ?? 0,
                'status' => $factura['status'],
                'created_at' => $factura['created_at'],
                'detalles' => $factura['detalles'] ?? '',
                'customer_name' => ($customer['name'] ?? '') . ' ' . ($customer['lastname'] ?? ''),
                'customer_dni' => $customer['dni'] ?? '',
                'customer_email' => $customer['email'] ?? '',
                'customer_address' => $customer['address'] ?? '',
                'urlComprobante' => $factura['urlComprobante'] ?? null,
                'details' => $factura['details'] ?? ''
            ],
            'customer' => $customer ?? []
        ]);
    }
    public function generarFactura()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'error' => 'Petición inválida.']);
        }
        $contract_id = $this->request->getPost('contract_id');
        $contrato = model('ContractModel')->find($contract_id);
        if (!$contrato) {
            return $this->response->setJSON(['success' => false, 'error' => 'Contrato no encontrado.']);
        }
        $cliente = model('CustomerModel')->find($contrato['customer_id']);
        if (!$cliente) {
            return $this->response->setJSON(['success' => false, 'error' => 'Cliente no encontrado.']);
        }
        $Invoices = new \App\Models\InvoicesModel();
        // Validar que no exista ya una factura para este contrato
        $existe = $Invoices->where('contract_id', $contract_id)->first();
        if ($existe) {
            return $this->response->setJSON(['success' => false, 'error' => 'Ya existe una factura asociada a este contrato.']);
        }
        $data = [
            'customer_id' => $contrato['customer_id'],
            'contract_id' => $contrato['id'],
            'amount' => $contrato['total_amount'],
            'date' => date('Y-m-d H:i:s'),
            'active' => '1',
            'store_id' => 1, // ID válido de la tienda
            // Puedes agregar más campos si lo necesitas
        ];
        $invoice_id = $Invoices->insertar($data);
        if ($invoice_id) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false, 'error' => 'No se pudo crear la factura.']);
        }
    }

    /**
     * Método de DEBUG para verificar la configuración y conectividad con SUNAT
     */
    public function debugSunat()
    {
        // Verificar permisos (solo admin)
        if (!isset($_SESSION['id'])) {
            return $this->response->setJSON(['error' => 'No autenticado']);
        }

        $debug = [
            'timestamp' => date('Y-m-d H:i:s'),
            'environment' => ENVIRONMENT,
            'php_version' => phpversion(),
            'curl_enabled' => extension_loaded('curl'),
            'sunat_config' => [
                'api_url' => env('SUNAT_API_URL'),
                'token_prefix' => substr(env('SUNAT_TOKEN', ''), 0, 20) . '...',
                'company_id' => env('SUNAT_COMPANY_ID', 'NO CONFIGURADO'),
            ],
            'test_curl' => [],
            'database_check' => []
        ];

        // Test 1: Verificar conexión a la API SUNAT
        $apiUrl = env('SUNAT_API_URL');
        $token = env('SUNAT_TOKEN');

        if (!$apiUrl || !$token) {
            return $this->response->setJSON([
                'error' => 'Configuración incompleta',
                'debug' => $debug,
                'missing' => [
                    'api_url' => empty($apiUrl),
                    'token' => empty($token)
                ]
            ]);
        }

        // Test CURL
        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json'
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        $debug['test_curl'] = [
            'url' => $apiUrl,
            'http_code' => $httpCode,
            'curl_error' => $curlError ?: 'Sin errores',
            'response_length' => strlen($response),
            'response_preview' => substr($response, 0, 500)
        ];

        // Test 2: Verificar base de datos
        $db = \Config\Database::connect();
        try {
            $result = $db->query('SELECT 1')->getResult();
            $debug['database_check'] = [
                'status' => 'Conectada',
                'connection' => $db->getDatabase()
            ];
        } catch (\Exception $e) {
            $debug['database_check'] = [
                'status' => 'Error',
                'error' => $e->getMessage()
            ];
        }

        return $this->response->setJSON([
            'success' => true,
            'debug' => $debug
        ]);
    }

    /**
     * Test de emisión con datos de prueba
     */
    public function testEmitirFactura()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['error' => 'Solo AJAX']);
        }

        log_message('info', '=== INICIANDO TEST EMISIÓN FACTURA ===');

        // Datos de prueba
        $datosComprobante = [
            "scenario" => "Boleta Gravada",
            "company_id" => env('SUNAT_COMPANY_ID', 1),
            "branch_id" => 1,
            "serie" => "B001",
            "numero" => 1,
            "fecha_emision" => date('Y-m-d'),
            "moneda" => "PEN",
            "tipo_operacion" => "0101",
            "metodo_envio" => "resumen_diario",
            "forma_pago_tipo" => "Contado",
            "client" => [
                "tipo_documento" => "1",
                "numero_documento" => "12345678",
                "razon_social" => "Cliente Test",
                "direccion" => "Dirección Test",
                "telefono" => "999999999",
                "email" => "test@test.com"
            ],
            "detalles" => [
                [
                    "codigo" => "TEST-001",
                    "descripcion" => "Producto Test",
                    "unidad" => "NIU",
                    "cantidad" => 1,
                    "mto_valor_unitario" => 100.00,
                    "porcentaje_igv" => 18,
                    "tip_afe_igv" => "10",
                    "codigo_producto_sunat" => "95121601"
                ]
            ],
            "usuario_creacion" => $_SESSION['id'] ?? 'test'
        ];

        log_message('info', 'Datos de prueba: ' . json_encode($datosComprobante, JSON_PRETTY_PRINT));

        $sunat = new Sunat();
        $respuesta = $sunat->emitirComprobante($datosComprobante);

        log_message('info', 'Respuesta SUNAT: ' . json_encode($respuesta, JSON_PRETTY_PRINT));
        log_message('info', '=== FIN TEST EMISIÓN FACTURA ===');

        return $this->response->setJSON([
            'success' => true,
            'datos_enviados' => $datosComprobante,
            'respuesta_sunat' => $respuesta,
            'logs_path' => WRITEPATH . 'logs/'
        ]);
    }

}