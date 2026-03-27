<?php

namespace App\Controllers;

use App\Models\InvoicesModel;
use App\Models\MembershipsModel;
use App\Libraries\Nubefact;

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
        $session_name = $_SESSION['first_name'] . " " . $_SESSION['last_name'];
        $Invoices = new InvoicesModel();
        $Membership = new MembershipsModel();
        //isset id
        if ($id != false) {
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
        return view('admin/facturas/load', $data);
    }

    public function validacion()
    {
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

    public function emitirFactura1()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->to('/dashboard/facturasContratos');
        }
        // DEBUG: Ver datos recibidos
        $debugData = $this->request->getPost();
        log_message('debug', 'emitirFactura POST: ' . print_r($debugData, true));
        $Invoices = new InvoicesModel();
        $contract_id = $this->request->getPost('contract_id');
        $contrato = model('ContractModel')->find($contract_id);
        if (!$contrato) {
            return $this->response->setJSON(['success' => false, 'error' => 'Contrato no encontrado.']);
        }
        // CORRECCIÓN: Usar el modelo correcto
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
        $serie = 'BBB1'; // Puedes cambiar la lógica de serie si lo necesitas
        $ultimo = $Invoices->orderBy('numero', 'DESC')->where('serie', $serie)->first();
        $numero = $ultimo && isset($ultimo['numero']) ? $ultimo['numero'] + 1 : 1;

        $data = [
            'customer_id' => $contrato['customer_id'],
            'contract_id' => $contrato['id'],
            'membership_id' => null,
            'qty' => 1,
            'amount' => $contrato['total_amount'],
            'address' => '',
            'phone' => '',
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
        $invoice_id = $Invoices->insertar($data);
        if (!$invoice_id || !is_numeric($invoice_id)) {
            $db = \Config\Database::connect();
            $error = $db->error();
            $errorMsg = isset($error['message']) ? $error['message'] : 'No se pudo emitir la factura.';
            return $this->response->setJSON(['success' => false, 'error' => $errorMsg]);
        }
        $factura = $Invoices->find($invoice_id);
        if ($factura === false || $factura === null) {
            return $this->response->setJSON(['success' => false, 'error' => 'No se pudo encontrar la factura emitida.']);
        }
        // Preparar datos del comprobante antes de emitir
        $datosComprobante = [
            "operacion" => "generar_comprobante",
            "tipo_de_comprobante" => "2",
            "serie" => $serie,
            // ...agrega aquí el resto de los datos necesarios...
        ];
        // Emitir comprobante con Nubefact y guardar respuesta
        $nubefact = new \App\Libraries\Nubefact();
        $respuesta = $nubefact->emitirComprobante($datosComprobante);

        if (is_array($respuesta) && isset($respuesta['enlace'])) {
            $Invoices->update($invoice_id, [
                'details' => 'Nubefact: ' . ($respuesta['enlace'] ?? null),
                'pdf_url' => $respuesta['pdf_zip_base64'] ?? null,
                'xml_url' => $respuesta['xml_zip_base64'] ?? null,
                'api_response' => json_encode($respuesta),
                'status' => 'emitido',
                'serie' => $respuesta['serie'] ?? $serie,
                'numero' => $respuesta['numero'] ?? $numero,
                'codigo_hash' => $respuesta['codigo_hash'] ?? null,
                'cadena_para_codigo_qr' => $respuesta['cadena_para_codigo_qr'] ?? null,
                'codigo_de_barras' => $respuesta['codigo_de_barras'] ?? null,
                'key' => $respuesta['key'] ?? null,
                'digest_value' => $respuesta['digest_value'] ?? null,
                'enlace_del_pdf' => $respuesta['enlace_del_pdf'] ?? null,
                'enlace_del_xml' => $respuesta['enlace_del_xml'] ?? null,
                'enlace_del_cdr' => $respuesta['enlace_del_cdr'] ?? null
            ]);
        } elseif (is_object($respuesta) && isset($respuesta->enlace)) {
            $Invoices->update($invoice_id, [
                'details' => 'Nubefact: ' . ($respuesta->enlace ?? null),
                'pdf_url' => $respuesta->pdf_zip_base64 ?? null,
                'xml_url' => $respuesta->xml_zip_base64 ?? null,
                'api_response' => json_encode($respuesta),
                'status' => 'emitido',
                'serie' => $respuesta->serie ?? $serie,
                'numero' => $respuesta->numero ?? $numero,
                'codigo_hash' => $respuesta->codigo_hash ?? null,
                'cadena_para_codigo_qr' => $respuesta->cadena_para_codigo_qr ?? null,
                'codigo_de_barras' => $respuesta->codigo_de_barras ?? null,
                'key' => $respuesta->key ?? null,
                'digest_value' => $respuesta->digest_value ?? null,
                'enlace_del_pdf' => $respuesta->enlace_del_pdf ?? null,
                'enlace_del_xml' => $respuesta->enlace_del_xml ?? null,
                'enlace_del_cdr' => $respuesta->enlace_del_cdr ?? null
            ]);
        } else {
            // Error de conexión o respuesta inesperada
            log_message('error', 'Error de conexión o respuesta inesperada Nubefact: ' . print_r($respuesta, true));
            $Invoices->update($invoice_id, [
                'details' => 'Error de conexión o respuesta inesperada Nubefact',
                'api_response' => json_encode($respuesta),
                'status' => 'error'
            ]);
        }
        $datosComprobante = [
            "operacion" => "generar_comprobante",
            "tipo_de_comprobante" => "2",
            "serie" => $serie,
            "numero" => $numero,
            "fecha_de_emision" => date('Y-m-d'),
            "moneda" => "1",
            "cliente_tipo_de_documento" => "1",
            "cliente_numero_de_documento" => $cliente['dni'],
            "cliente_denominacion" => $cliente['name'] . ' ' . $cliente['lastname'],
            "total" => $contrato['total_amount'],
            "total_igv" => "0.00",
            "total_gratuita" => $contrato['total_amount'],
            "items" => [
                [
                    "unidad_de_medida" => "NIU",
                    "codigo" => "CONTRATO-{$contrato['id']}",
                    "descripcion" => "Factura de contrato inmobiliario",
                    "cantidad" => 1,
                    "valor_unitario" => $contrato['total_amount'],
                    "precio_unitario" => $contrato['total_amount'],
                    "subtotal" => $contrato['total_amount'],
                    "tipo_de_igv" => "7",
                    "igv" => "0.00",
                    "total" => $contrato['total_amount']
                ]
            ]
        ];
        $nubefact = new \App\Libraries\Nubefact();
        $respuesta = $nubefact->emitirComprobante($datosComprobante);
        $urlComprobante = '';
        if (is_array($respuesta) && isset($respuesta['enlace'])) {
            $urlComprobante = $respuesta['enlace'];
        } elseif (is_object($respuesta) && isset($respuesta->enlace)) {
            $urlComprobante = $respuesta->enlace;
        }
        if ($urlComprobante) {
            return $this->response->setJSON([
                'success' => true,
                'urlComprobante' => $urlComprobante,
                'nubefact_response' => $respuesta
            ]);
        }
        // Si Nubefact devuelve error, mostrar mensaje
        $errorMsg = '';
        if (is_array($respuesta) && isset($respuesta['error'])) {
            $errorMsg = $respuesta['error'];
        } elseif (is_object($respuesta) && isset($respuesta->error)) {
            $errorMsg = $respuesta->error;
        } elseif (is_array($respuesta) && isset($respuesta['errors'])) {
            $errorMsg = is_array($respuesta['errors']) ? implode(' ', $respuesta['errors']) : $respuesta['errors'];
        } elseif (is_object($respuesta) && isset($respuesta->errors)) {
            $errorMsg = is_array($respuesta->errors) ? implode(' ', $respuesta->errors) : $respuesta->errors;
        } elseif (is_array($respuesta) && isset($respuesta['message'])) {
            $errorMsg = $respuesta['message'];
        } elseif (is_object($respuesta) && isset($respuesta->message)) {
            $errorMsg = $respuesta->message;
        }
        if (!$errorMsg) {
            $errorMsg = 'No se pudo generar el comprobante electrónico.';
        }
        // Construir manualmente la URL del comprobante Nubefact
        $serie = isset($datosComprobante['serie']) ? $datosComprobante['serie'] : 'BBB1';
        $numero = isset($datosComprobante['numero']) ? $datosComprobante['numero'] : $invoice_id;
        $urlManual = "https://www.nubefact.com/see/{$serie}-{$numero}";
        return $this->response->setJSON([
            'success' => false,
            'error' => $errorMsg,
            'nubefact_response' => $respuesta
        ]);
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
        $contrato = model('ContractModel')->find($contract_id);
        if (!$contrato) {
            return $this->response->setJSON(['success' => false, 'error' => 'Contrato no encontrado.']);
        }
        // CORRECCIÓN: Usar el modelo correcto
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
        $serie = 'BBB1'; // Puedes cambiar la lógica de serie si lo necesitas
        $ultimo = $Invoices->orderBy('numero', 'DESC')->where('serie', $serie)->first();
        $numero = $ultimo && isset($ultimo['numero']) ? $ultimo['numero'] + 1 : 1;

        $data = [
            'customer_id' => $contrato['customer_id'],
            'contract_id' => $contrato['id'],
            'membership_id' => null,
            'qty' => 1,
            'amount' => $contrato['total_amount'],
            'address' => '',
            'phone' => '',
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

        print_r($data);
    }


    public function detalle($id)
    {
        $Invoices = new InvoicesModel();
        $factura = $Invoices->find($id);
        if (!$factura) {
            return $this->response->setJSON(['success' => false, 'error' => 'Factura no encontrada']);
        }
        // Si existe comprobante Nubefact, devolverlo
        $urlComprobante = isset($factura['urlComprobante']) ? $factura['urlComprobante'] : null;
        return $this->response->setJSON([
            'success' => true,
            'factura' => $factura,
            'urlComprobante' => $urlComprobante
        ]);
    }


    public function generarFactura()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'error' => 'Petición inválida.']);
        }

        $contract_id = $this->request->getPost('contract_id');

        // 1. Obtener datos del contrato
        $contrato = model('ContractModel')->find($contract_id);
        if (!$contrato) {
            return $this->response->setJSON(['success' => false, 'error' => 'Contrato no encontrado.']);
        }

        // 2. Obtener datos del cliente
        $cliente = model('CustomerModel')->find($contrato['customer_id']);
        if (!$cliente) {
            return $this->response->setJSON(['success' => false, 'error' => 'Cliente no encontrado.']);
        }

        // 3. Cálculos de montos
        $total = (float) $contrato['total_amount'];
        $mto_valor_unitario = round($total / 1.18, 2);

        // 4. Lógica de comprobante (DNI vs RUC)
        $esRuc = !empty($cliente['ruc']);
        $tipo_doc = $esRuc ? "6" : "1";
        $serie = $esRuc ? "F001" : "B001";
        $num_doc = $esRuc ? $cliente['ruc'] : $cliente['dni'];

        // 5. Armado de la estructura
        $data_facturacion = [
            "scenario" => $esRuc ? "Factura Gravada" : "Boleta Gravada",
            "company_id" => 1,
            "branch_id" => 1,
            "serie" => $serie,
            "fecha_emision" => date('Y-m-d'),
            "moneda" => "PEN",
            "tipo_operacion" => "0101",
            "metodo_envio" => "individual",
            "forma_pago_tipo" => "Contado",
            "client" => [
                "tipo_documento" => $tipo_doc,
                "numero_documento" => $num_doc,
                "razon_social" => trim(($cliente['name'] ?? '') . ' ' . ($cliente['lastname'] ?? '')),
                "direccion" => $cliente['address'] ?: "Lima, Perú",
                "telefono" => $cliente['phone'] ?? '',
                "email" => $cliente['email'] ?? ''
            ],
            "detalles" => [
                [
                    "codigo" => $contrato['contract_number'],
                    "descripcion" => "LOTE DE TERRENO - CONTRATO " . $contrato['contract_number'],
                    "unidad" => "NIU",
                    "cantidad" => 1,
                    "mto_valor_unitario" => $mto_valor_unitario,
                    "porcentaje_igv" => 18,
                    "tip_afe_igv" => "10",
                    "codigo_producto_sunat" => "95121601"
                ]
            ],
            "usuario_creacion" => session()->get('user_name') ?? "vendedor_sistema"
        ];

        // Llamar a la función de envío pasando el token de sesión
        $respuestaApi = $this->enviarFacturaSunat($data_facturacion);

        // 4. ACTUALIZACIÓN LOCAL (Aquí es donde podía dar el error 500)
        // Verificamos que la respuesta sea un array y que success sea true
        if (is_array($respuestaApi) && ($respuestaApi['success'] ?? false) === true) {
            try {
                $updateData = [
                    'api_factura_id'           => $respuestaApi['data']['id'],
                    'factura_serie_correlativo' => $respuestaApi['data']['numero_completo'],
                    'factura_emitida'          => 1,
                    'updated_at'               => date('Y-m-d H:i:s')
                ];

                // Guardamos en una variable para verificar si falló algo interno
                $dbUpdate = model('ContractModel')->update($contract_id, $updateData);

                if (!$dbUpdate) {
                    log_message('error', 'Fallo al actualizar tabla contracts: ' . json_encode(model('ContractModel')->errors()));
                }
            } catch (\Exception $e) {
                log_message('error', 'Error al actualizar contrato ' . $contract_id . ': ' . $e->getMessage());
            }
        }

        return $this->response->setJSON($respuestaApi);
    }

    private function enviarFacturaSunat($data)
    {
        // --- RECUPERAR TOKEN DE SESIÓN ---
        $session = session();
        $token   = $session->get('api_access_token');
        $type    = $session->get('api_token_type') ?? 'Bearer'; // Por defecto Bearer si no existe

        if (empty($token)) {
            return ['success' => false, 'message' => 'No hay una sesión activa de API o el token expiró.'];
        }

        $url = 'https://apifacturacion.groupdispensersac.com/api/v1/boletas';

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => json_encode($data),
            CURLOPT_HTTPHEADER     => [
                'Accept: application/json',
                'Content-Type: application/json',
                'Authorization: ' . $type . ' ' . $token // Usamos el token dinámico aquí
            ],
            CURLOPT_SSL_VERIFYPEER => false // Importante si tienes problemas de certificados en local
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        // --- SISTEMA DE LOGS ---
        $logPath = WRITEPATH . 'logs/facturacion_' . date('Y-m-d') . '.log';
        $logData = "HORA: " . date('H:i:s') . " | TOKEN: " . substr($token, 0, 10) . "...\n";
        $logData .= "ENVIO: " . json_encode($data) . "\n";
        $logData .= "RESPUESTA: " . ($err ? "ERROR CURL: $err" : $response) . "\n";
        $logData .= "----------------------------------------------------------\n";

        file_put_contents($logPath, $logData, FILE_APPEND);

        return json_decode($response, true);
    }
}
