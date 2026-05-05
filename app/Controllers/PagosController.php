<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class PagosController extends BaseController
{
    /**
     * Vista completa de cronograma con validación de pagos
     */
    public function cronograma_completo($contractId = null)
    {
        if (!$contractId) {
            return redirect()->to('/dashboard/inmueble/contracts')->with('error', 'Contrato no especificado');
        }

        $contractModel = new \App\Models\ContractModel();
        $paymentScheduleModel = new \App\Models\PaymentScheduleModel();

        // Obtener contrato con detalles
        $allContracts = $contractModel->getContractsWithDetails();
        $contract = null;
        foreach ($allContracts as $c) {
            if ($c['id'] == $contractId) {
                $contract = $c;
                break;
            }
        }

        if (!$contract) {
            return redirect()->to('/dashboard/inmueble/contracts')->with('error', 'Contrato no encontrado');
        }

        // Obtener pagos ordenados (ASC - cronológicamente)
        $payments = $paymentScheduleModel->where('contract_id', $contractId)
            ->orderBy('installment_number', 'ASC')
            ->findAll();

        // Calcular estadísticas
        $stats = [
            'pagados_count' => 0,
            'pagados_monto' => 0,
            'registrados_count' => 0,
            'registrados_monto' => 0,
            'pendientes_count' => 0,
            'pendientes_monto' => 0,
            'total_count' => count($payments),
            'total_monto' => 0
        ];

        foreach ($payments as $pago) {
            $estado = strtolower($pago['status'] ?? 'pending');
            $monto = $pago['amount'] ?? 0;
            $stats['total_monto'] += $monto;

            $validado = ($estado === 'paid' || $estado === 'pagado');
            $registrado = !empty($pago['paid_date']);

            if ($validado) {
                $stats['pagados_count']++;
                $stats['pagados_monto'] += $monto;
            } elseif ($registrado) {
                $stats['registrados_count']++;
                $stats['registrados_monto'] += $monto;
            } else {
                $stats['pendientes_count']++;
                $stats['pendientes_monto'] += $monto;
            }
        }

        $data = [
            'title' => 'Cronograma de Pagos - Validación',
            'contract' => $contract,
            'payments' => $payments,
            'stats' => $stats
        ];

        return view('admin/inmueble/cronograma_completo', $data);
    }

    /**
     * Validar pago y marcar como aprobado
     */
    public function validar_pago()
    {
        try {
            if (strtolower($this->request->getMethod()) !== 'post') {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Método no permitido'
                ]);
            }

            $idPago = $this->request->getPost('id_pago');
            $notas = $this->request->getPost('notas');
            $comprobante = $this->request->getFile('comprobante');

            if (!$idPago) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'ID de pago no recibido'
                ]);
            }

            $scheduleModel = new \App\Models\PaymentScheduleModel();
            $pago = $scheduleModel->find($idPago);

            if (!$pago) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Pago no encontrado'
                ]);
            }

            // Procesar comprobante si existe (admin sube uno)
            $comprobanteUrl = null;
            if ($comprobante && $comprobante->isValid() && !$comprobante->hasMoved()) {
                // Crear directorio si no existe
                $uploadPath = FCPATH . 'uploads/comprobantes';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                $newName = $comprobante->getRandomName();
                $comprobante->move($uploadPath, $newName);
                $comprobanteUrl = 'uploads/comprobantes/' . $newName;
            }

            // Verificar si el cliente ya subió voucher o el admin lo sube ahora
            $tieneVoucher = !empty($pago['voucher_url']) || $comprobanteUrl;

            if (!$tieneVoucher) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Debe proporcionar un comprobante para validar el pago'
                ]);
            }

            // Actualizar estado a 'paid' (validado)
            $updateData = [
                'status' => 'paid',
                'paid_date' => date('Y-m-d H:i:s'),
                'paid_amount' => $pago['amount'],
                'validado_notas' => $notas,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Agregar voucher si el admin lo subió (sobreescribe si ya existe)
            if ($comprobanteUrl) {
                $updateData['voucher_url'] = $comprobanteUrl;
            }

            $scheduleModel->update($idPago, $updateData);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Pago validado correctamente'
            ]);
        } catch (\Throwable $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error interno: ' . $e->getMessage()
            ]);
        }
    }


    public function generar_factura_cuota1()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Petición inválida.']);
        }

        // 1. Recibir JSON del Front
        $json = $this->request->getJSON();
        $pago_id = $json->pago_id ?? null;
        $contract_id = $json->contract_id ?? null;
        $monto_cuota = $json->monto ?? null;
        $payment_schedule_id = $json->payment_schedule_id ?? null;

        if (!$contract_id || !$monto_cuota) {
            return $this->response->setJSON(['success' => false, 'message' => 'Faltan datos (Contrato o Monto).']);
        }

        // 2. Obtener datos del contrato
        $contrato = model('ContractModel')->find($contract_id);
        if (!$contrato) {
            return $this->response->setJSON(['success' => false, 'message' => 'Contrato no encontrado.']);
        }

        // 3. Obtener datos del cliente
        $cliente = model('CustomerModel')->find($contrato['customer_id']);
        if (!$cliente) {
            return $this->response->setJSON(['success' => false, 'message' => 'Cliente no encontrado.']);
        }

        // 3.5. Obtener lote y proyecto para descripción
        $lote = model('LotModel')->find($contrato['lot_id']);
        $proyecto = $lote ? model('ProjectModel')->find($lote['project_id']) : null;
        
        // Obtener la cuota ESPECÍFICA (usando payment_schedule_id)
        $paymentSchedule = null;
        if ($payment_schedule_id) {
            $paymentSchedule = model('PaymentScheduleModel')->find($payment_schedule_id);
        }
        
        $installment_number = $paymentSchedule['installment_number'] ?? 1;
        $lot_number = $lote['lot_number'] ?? 'N/A';
        $project_name = $proyecto['name'] ?? 'N/A';

        // 4. Configuración de montos (Usando el monto de la cuota enviado)
        $total = (float) $monto_cuota;
        $mto_valor_unitario = round($total, 2);

        // 5. Lógica de comprobante (DNI vs RUC)
        $esRuc  = !empty($cliente['ruc']);
        $tipo_doc = $esRuc ? "6" : "1";
        $serie    = $esRuc ? "F001" : "B001";
        $num_doc  = $esRuc ? $cliente['ruc'] : $cliente['dni'];

        // 6. Armado de la estructura para la API
        $data_facturacion = [
            "scenario"        => $esRuc ? "Factura Inafecta" : "Boleta Inafecta",
            "company_id"      => 1,
            "branch_id"       => 1,
            "serie"           => $serie,
            "fecha_emision"   => date('Y-m-d'),
            "moneda"          => "PEN",
            "tipo_operacion"  => "0101",
            "metodo_envio"    => "individual",
            "forma_pago_tipo" => "Contado",
            "client" => [
                "tipo_documento"   => $tipo_doc,
                "numero_documento" => $num_doc,
                "razon_social"     => trim(($cliente['name'] ?? '') . ' ' . ($cliente['lastname'] ?? '')),
                "direccion"        => $cliente['address'] ?: "Lima, Perú",
                "telefono"         => $cliente['phone'] ?? '',
                "email"            => $cliente['email'] ?? ''
            ],
            "detalles" => [
                [
                    "codigo"             => $contrato['contract_number'],
                    "descripcion"        => "POR EL PAGO DE CUOTA " . $installment_number . " DEL LOTE " . $lot_number . " PROYECTO " . $project_name,
                    "unidad"             => "NIU",
                    "cantidad"           => 1,
                    "mto_valor_unitario" => $mto_valor_unitario,
                    "porcentaje_igv"     => 0,
                    "tip_afe_igv"        => "30" // INAFECTO
                ]
            ],
            "usuario_creacion" => session()->get('user_name') ?? "vendedor_sistema"
        ];

        // 7. Llamar a la función de envío (La que ya tienes implementada)
        $respuestaApi = $this->enviarFacturaSunat($data_facturacion);

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



    public function generar_factura_cuota()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Petición inválida.']);
        }

        $json        = $this->request->getJSON();
        $pago_id     = $json->pago_id ?? null;
        $contract_id = $json->contract_id ?? null;
        $monto_cuota = $json->monto ?? null;
        $payment_schedule_id = $json->payment_schedule_id ?? null;

        if (!$contract_id || !$monto_cuota) {
            return $this->response->setJSON(['success' => false, 'message' => 'Faltan datos (Contrato o Monto).']);
        }

        $contrato = model('ContractModel')->find($contract_id);
        if (!$contrato) {
            return $this->response->setJSON(['success' => false, 'message' => 'Contrato no encontrado.']);
        }

        $cliente = model('CustomerModel')->find($contrato['customer_id']);
        if (!$cliente) {
            return $this->response->setJSON(['success' => false, 'message' => 'Cliente no encontrado.']);
        }

        // Obtener lote y proyecto para descripción
        $lote = model('LotModel')->find($contrato['lot_id']);
        $proyecto = $lote ? model('ProjectModel')->find($lote['project_id']) : null;
        
        // Obtener la cuota ESPECÍFICA (usando payment_schedule_id)
        $paymentSchedule = null;
        if ($payment_schedule_id) {
            $paymentSchedule = model('PaymentScheduleModel')->find($payment_schedule_id);
        }
        
        $installment_number = $paymentSchedule['installment_number'] ?? 1;
        $lot_number = $lote['lot_number'] ?? 'N/A';
        $project_name = $proyecto['name'] ?? 'N/A';

        $total    = (float) $monto_cuota;
        $esRuc    = !empty($cliente['ruc']);
        $tipo_doc = $esRuc ? "6" : "1";
        $num_doc  = $esRuc ? $cliente['ruc'] : $cliente['dni'];
        $nombre   = trim(($cliente['name'] ?? '') . ' ' . ($cliente['lastname'] ?? ''));

        // Estructura para tu nueva API Laravel
        $payload = [
            "tipo_documento" => $esRuc ? "01" : "03", // 01=Factura, 03=Boleta
            "cabecera" => [
                "FECHA_EMISION"            => date('Y-m-d'),
                "CLIENTE_NRO_DOCUMENTO"    => $num_doc,
                "CLIENTE_TIPO_IDENTIDAD"   => $tipo_doc,
                "CLIENTE_NOMBRE"           => $nombre,
                "CODIGO_MONEDA"            => "PEN",
                "TOTAL_INAFECTAS"          => number_format($total, 2, '.', ''),
                "TOTAL_GRAVADAS"           => "0.00",
                "TOTAL_TRIBUTO_IGV"        => "0.00",
                "TOTAL_VENTA"              => number_format($total, 2, '.', ''),
            ],
            "detalles" => [
                [
                    "CODIGO"          => $contrato['contract_number'],
                    "CANTIDAD"        => "1",
                    "DESCRIPCION"     => "POR EL PAGO DE CUOTA " . $installment_number . " DEL LOTE " . $lot_number . " PROYECTO " . $project_name,
                    "UNIDAD_MEDIDA"   => "NIU",
                    "PRECIO_VALOR"    => number_format($total, 2, '.', ''),
                    "TIPO_TRIBUTO_IGV" => "30", // 30 = Inafecto
                ]
            ]
        ];

        $respuesta = $this->enviarAMiApiLaravel($payload);

        // Guardar pago_id si la emisión fue exitosa
        if (!empty($respuesta['success'])) {
            $xmlData = $respuesta['xml_data'] ?? [];
            $sunat   = $respuesta['sunat_response'] ?? [];
            $pdf     = $respuesta['pdf'] ?? [];

            $numero = '';
            if (preg_match('/([A-Z]\d{3}-\d+)/', $xmlData['MENSAJE'] ?? '', $matches)) {
                $numero = $matches[1];
            }
            $partes = explode('-', $numero);

            try {
                $db = \Config\Database::connect();
                $insertado = $db->table('comprobantes_emitidos')->insert([
                    'contract_id'     => $contract_id,
                    'pago_id'         => $pago_id,
                    'tipo_documento'  => $payload['tipo_documento'],
                    'serie'           => $partes[0] ?? '',
                    'correlativo'     => $partes[1] ?? '',
                    'numero_completo' => $numero,
                    'cliente_nombre'  => $nombre,
                    'cliente_num_doc' => $num_doc,
                    'monto_total'     => $total,
                    'moneda'          => 'PEN',
                    'fecha_emision'   => date('Y-m-d'),
                    'estado'          => isset($sunat['CODIGO']) && $sunat['CODIGO'] == 0 ? 'Aceptado' : 'Pendiente',
                    'sunat_codigo'    => $sunat['CODIGO'] ?? null,
                    'sunat_mensaje'   => $sunat['MENSAJE'] ?? null,
                    'hash_cpe'        => $xmlData['HASH_CPE'] ?? null,
                    'xml_filename'    => $pdf['filename'] ?? null,
                    'pdf_url'         => $pdf['download_url'] ?? null,
                    'created_at'      => date('Y-m-d H:i:s'),
                    'updated_at'      => date('Y-m-d H:i:s'),
                ]);

                // Log del resultado del insert
                $logPath = WRITEPATH . 'logs/facturacion_' . date('Y-m-d') . '.log';
                file_put_contents($logPath, "INSERT resultado: " . ($insertado ? 'OK' : 'FALLO') . " | numero: $numero | error: " . $db->error()['message'] . "\n", FILE_APPEND);
            } catch (\Throwable $e) {
                $logPath = WRITEPATH . 'logs/facturacion_' . date('Y-m-d') . '.log';
                file_put_contents($logPath, "INSERT EXCEPTION: " . $e->getMessage() . "\n", FILE_APPEND);
                // No detenemos el flujo — la factura ya se emitió
            }
        }

        return $this->response->setJSON($respuesta);
        return $this->response->setJSON($respuesta);
    }

    private function enviarAMiApiLaravel(array $payload): array
    {
        $url = 'https://apifacturacion.cleaningli.com/api/emitir';

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => json_encode($payload),
            CURLOPT_HTTPHEADER     => [
                'Accept: application/json',
                'Content-Type: application/json',
                // Sin Authorization — esta API no requiere token
            ],
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT        => 60,
        ]);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err      = curl_error($curl);
        curl_close($curl);

        // Log
        $logPath  = WRITEPATH . 'logs/facturacion_' . date('Y-m-d') . '.log';
        $logData  = "HORA: " . date('H:i:s') . " | HTTP: $httpCode\n";
        $logData .= "ENVIO: " . json_encode($payload) . "\n";
        $logData .= "RESPUESTA: " . ($err ? "ERROR CURL: $err" : $response) . "\n";
        $logData .= str_repeat('-', 60) . "\n";
        file_put_contents($logPath, $logData, FILE_APPEND);

        if ($err) {
            return ['success' => false, 'message' => 'Error de conexión: ' . $err];
        }

        $data = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return ['success' => false, 'message' => 'Respuesta inválida', 'raw' => $response];
        }

        return $data;
    }
}
