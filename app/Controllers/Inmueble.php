<?php
namespace App\Controllers;
use App\Models\InmuebleModel;
use App\Models\ProjectModel;
use App\Models\LotModel;
use App\Models\PaymentPlanModel;
use App\Models\ContractModel;
use App\Helpers\DownPaymentHelper;
class Inmueble extends BaseController {
    // ...existing code...

  
    
    protected $inmuebleModel;
    protected $projectModel;
    protected $lotModel;
    protected $paymentPlanModel;
    protected $contractModel;


    public function __construct()
    {
        $this->inmuebleModel = new InmuebleModel();
        $this->projectModel = new ProjectModel();
        $this->lotModel = new LotModel();
        $this->paymentPlanModel = new PaymentPlanModel();
        $this->contractModel = new ContractModel();
        // No usar session_start(); CodeIgniter gestiona la sesión automáticamente
    }


     /**
    * Cambia el estado de un contrato a 'rejected'
    */
    public function rejectContract()
    {
    $id = $this->request->getPost('id');
    $contractModel = new \App\Models\ContractModel();
    $updated = $contractModel->update($id, ['status' => 'rejected']);
    return $this->response->setJSON(['success' => (bool)$updated]);
    }
    /**
    * Nuevo método para el botón "Aprobar Mejor"
    */
    public function aprobarMejor()
    {
        $request = service('request');
        $contract_id = $request->getPost('contract_id');
        $ContractModel = new \App\Models\ContractModel();
        $ComisionModel = new \App\Models\ComisionesInmobiliariasModel();
        $contract = $ContractModel->find($contract_id);
        if (!$contract) {
            return $this->response->setJSON(['success' => false, 'message' => 'Contrato no encontrado']);
        }
        $comisiones_creadas = [];
        // Si el contrato es de reserva
        if ($contract['contract_type'] === 'arras' || $contract['is_reserved']) {
            // Solo S/ 300 por reserva (sin 5%)
            $bono_data = [
                'venta_id' => $contract_id,
                'beneficiario_id' => $contract['sponsor_id'],
                'tipo_comision' => 'bono_reserva',
                'monto' => 300,
                'porcentaje' => null,
                'estado' => 'aprobada',
                'fecha_generada' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $ComisionModel->insert($bono_data);
            $comisiones_creadas[] = $bono_data;
        } else if ($contract['contract_type'] === 'contado') {
            // Pago al contado: comisión 5%
            $monto_comision = round(floatval($contract['total_amount']) * 0.05, 2);
            $comision_data = [
                'venta_id' => $contract_id,
                'beneficiario_id' => $contract['sponsor_id'],
                'tipo_comision' => 'venta_base',
                'monto' => $monto_comision,
                'porcentaje' => 5,
                'estado' => 'aprobada',
                'fecha_generada' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $ComisionModel->insert($comision_data);
            $comisiones_creadas[] = $comision_data;
        }
        return $this->response->setJSON(['success' => true, 'message' => 'Comisiones generadas', 'comisiones' => $comisiones_creadas]);
    }
     public function mostrarComprobante($filename)
    {
        $path = WRITEPATH . 'uploads/comprobantes/' . $filename;
        if (is_file($path)) {
            // Detectar el tipo de contenido basado en la extensión
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            $contentTypes = [
                'jpg' => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
                'webp' => 'image/webp',
                'pdf' => 'application/pdf'
            ];
            
            $contentType = $contentTypes[$ext] ?? 'application/octet-stream';
            header('Content-Type: ' . $contentType);
            header('Cache-Control: public, max-age=3600');
            readfile($path);
            exit;
        } else {
            // Imagen de reemplazo si no existe el comprobante
            $noImage = FCPATH . 'assets/img/no-image.png';
            if (is_file($noImage)) {
                header('Content-Type: image/png');
                readfile($noImage);
                exit;
            } else {
                header('Content-Type: text/plain');
                echo 'Imagen no encontrada';
                exit;
            }
        }
    }
 /**
    * Valida/aprueba un contrato y genera la comisión solo si está aprobado
    */
    public function aprobarContrato()
    {
        $request = service('request');
        $contract_id = $request->getPost('contract_id');
        $ContractModel = new \App\Models\ContractModel();
        $ComisionModel = new \App\Models\ComisionesInmobiliariasModel();
        $UnilevelModel = new \App\Models\UnilevelsModel();
        $contract = $ContractModel->find($contract_id);
        $bonus_aplicado = false;
        $log = [
            'datetime' => date('Y-m-d H:i:s'),
            'accion' => 'aprobarContrato',
            'contract_id' => $contract_id,
            'contract_data' => $contract
        ];
        // Si el contrato no tiene sponsor_id, buscarlo en unilevels usando el método correcto
        if (!empty($contract) && empty($contract['sponsor_id']) && !empty($contract['customer_id'])) {
            $sponsor_id = $UnilevelModel->get_sponsor_level_1($contract['customer_id']);
            if ($sponsor_id) {
                $contract['sponsor_id'] = $sponsor_id;
                if (!empty($sponsor_id) && (!isset($contract['sponsor_id']) || $contract['sponsor_id'] != $sponsor_id)) {
                    $ContractModel->update($contract_id, ['sponsor_id' => $sponsor_id]);
                }
                $log['sponsor_id_asignado'] = $sponsor_id;
            } else {
                $log['sponsor_id_asignado'] = null;
            }
        }
        if (!$contract) {
            $log['error'] = 'Contrato no encontrado';
            file_put_contents(WRITEPATH . 'logs/aprobarContrato_' . date('Ymd_His') . '.log', json_encode($log, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            return $this->response->setJSON(['success' => false, 'message' => 'Contrato no encontrado']);
        }
        if (empty($contract['voucher_url'])) {
            $log['error'] = 'No hay voucher adjunto';
            file_put_contents(WRITEPATH . 'logs/aprobarContrato_' . date('Ymd_His') . '.log', json_encode($log, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            return $this->response->setJSON(['success' => false, 'message' => 'No hay voucher adjunto']);
        }
        $ContractModel->update($contract_id, ['status' => 'aprobado']);
        $comisiones_existentes = $ComisionModel->where('venta_id', $contract_id)->findAll();
        $log['comisiones_existentes'] = $comisiones_existentes;
        $comision_creada = null;
        $monto_comision = 0;
        $comisiones_count = count($comisiones_existentes);
        
        // Si ya existen comisiones (fueron creadas al momento de la acción: reservar/inicial/contado)
        if ($comisiones_count > 0) {
            // Solo cambiar estado a aprobadas si están pendientes
            foreach ($comisiones_existentes as $comision) {
                if ($comision['estado'] !== 'aprobada') {
                    $ComisionModel->update($comision['id'], ['estado' => 'aprobada']);
                }
            }
            $monto_comision = array_sum(array_column($comisiones_existentes, 'monto'));
            $log['resultado'] = 'Comisiones ya existían, solo se marcaron como aprobadas. Monto total: S/ ' . $monto_comision;
            $msg = 'Contrato aprobado. Comisiones ya generadas: S/ ' . number_format($monto_comision, 2);
        } else if (!empty($contract['sponsor_id'])) {
            // Si no existen comisiones, crearlas ahora (fallback para contratos sin comisión inicial)
            
            // Si es reserva, solo S/ 300
            if ((isset($contract['contract_type']) && strtolower($contract['contract_type']) === 'reservation') || (isset($contract['is_reserved']) && $contract['is_reserved'])) {
                $bono_data = [
                    'venta_id' => $contract_id,
                    'beneficiario_id' => $contract['sponsor_id'],
                    'tipo_comision' => 'bono_reserva',
                    'monto' => 300,
                    'porcentaje' => null,
                    'estado' => 'aprobada',
                    'fecha_generada' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                $ComisionModel->insert($bono_data);
                $monto_comision = 300;
                $bonus_aplicado = true;
                $log['resultado'] = 'Contrato aprobado, comisión fija generada: S/ 300 (reserva)';
                $msg = 'Contrato aprobado: comisión fija de S/ 300 generada.';
                $comision_creada = $bono_data;
            } else {
                // Para contado/inicial: 5% del monto total
                $monto_comision = round(floatval($contract['total_amount']) * 0.05, 2);
                $comision_data = [
                    'venta_id' => $contract_id,
                    'beneficiario_id' => $contract['sponsor_id'],
                    'tipo_comision' => 'venta_base',
                    'monto' => $monto_comision,
                    'porcentaje' => 5,
                    'estado' => 'aprobada',
                    'fecha_generada' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                $ComisionModel->insert($comision_data);
                $log['resultado'] = 'Contrato aprobado, comisión 5% generada (no existía)';
                $msg = 'Contrato aprobado y comisión generada: S/ ' . number_format($monto_comision, 2);
                $comision_creada = $comision_data;
            }
        }
        
        $log['comision_creada'] = $comision_creada;
        $log['bonus_aplicado'] = $bonus_aplicado;
        file_put_contents(WRITEPATH . 'logs/aprobarContrato_' . date('Ymd_His') . '.log', json_encode($log, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        return $this->response->setJSON(['success' => true, 'message' => $msg, 'total_comision' => number_format($monto_comision, 2)]);
    }

    /**
     * Rechazar un contrato y actualizar su estado
     */
    public function approve_contract()
    {
        $request = service('request');
        $contract_id = $request->getPost('contract_id');
        $ContractModel = new \App\Models\ContractModel();
        $ComisionModel = new \App\Models\ComisionesInmobiliariasModel();
        
        $contract = $ContractModel->find($contract_id);
        if (!$contract) {
            return $this->response->setJSON(['success' => false, 'message' => 'Contrato no encontrado']);
        }
        
        // Cambiar estado del contrato a 'active' y marcar como aprobado
        $ContractModel->update($contract_id, [
            'status' => 'active',
            'is_approved' => 1,
            'is_rejected' => 0
        ]);
        
        // Generar comisión según el tipo de contrato
        $comisiones_creadas = [];
        $total_comision = 0;
        
        if (!empty($contract['sponsor_id'])) {
            $fecha = date('Y-m-d H:i:s');
            $totalAmount = $contract['total_amount'] ?? 0;
            
            // Determinar tipo de comisión según contract_type e is_reserved
            if (!empty($contract['is_reserved']) && $contract['is_reserved'] == 1) {
                // RESERVA: S/ 300 fijo
                $monto_comision = 300;
                $tipo_comision = 'bono_reserva';
                $porcentaje_comision = null;
                $total_comision = 300;
            } else {
                // INICIAL o CONTADO: 5% del monto total
                $monto_comision = round($totalAmount * 0.05, 2);
                $tipo_comision = 'venta_base';
                $porcentaje_comision = 5;
                $total_comision = $monto_comision;
            }
            
            $comision_data = [
                'venta_id' => $contract_id,
                'beneficiario_id' => $contract['sponsor_id'],
                'tipo_comision' => $tipo_comision,
                'monto' => $monto_comision,
                'porcentaje' => $porcentaje_comision,
                'estado' => 'aprobada',
                'fecha_generada' => $fecha,
                'created_at' => $fecha,
                'updated_at' => $fecha
            ];
            
            $com_insert_result = $ComisionModel->insert($comision_data);
            log_message('debug', '[approve_contract] Comisión insertada. com_insert_result=' . json_encode($com_insert_result) . ' comision_data=' . json_encode($comision_data));
            
            $comisiones_creadas[] = [
                'beneficiario_id' => $contract['sponsor_id'],
                'tipo' => $tipo_comision,
                'monto' => $monto_comision,
                'porcentaje' => $porcentaje_comision
            ];
        }
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Contrato aprobado correctamente. Comisión generada.',
            'total_comision' => $total_comision,
            'comisiones' => $comisiones_creadas
        ]);
    }
    
    public function reject_contract()
    {
        $request = service('request');
        $contract_id = $request->getPost('contract_id');
        $ContractModel = new \App\Models\ContractModel();
        $contract = $ContractModel->find($contract_id);
        if (!$contract) {
            return $this->response->setJSON(['success' => false, 'message' => 'Contrato no encontrado']);
        }
        // Cambiar estado a rechazado y marcar como rechazado
        $ContractModel->update($contract_id, [
            'status' => 'rejected',
            'is_rejected' => 1,
            'is_approved' => 0
        ]);
        // Eliminar comisiones asociadas a este contrato
        $ComisionModel = new \App\Models\ComisionesInmobiliariasModel();
        $comisiones = $ComisionModel->where('venta_id', $contract_id)->findAll();
        $eliminadas = 0;
        foreach ($comisiones as $comision) {
            $ComisionModel->delete($comision['id']);
            $eliminadas++;
        }
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Contrato rechazado correctamente. Se eliminaron ' . $eliminadas . ' comisiones asociadas.'
        ]);
    }
    /**
     * Generate a short unique code for a project.
     * Strategy: slugified name (first letters) + timestamp/hash suffix. Retry if collision.
     */
    protected function generateUniqueCode($name = '')
    {
        $base = preg_replace('/[^A-Za-z0-9]/', '', strtoupper(substr($name, 0, 4)));
        if (empty($base)) $base = 'PRJ';
        $tries = 0;
        $maxTries = 10;
        do {
            $suffix = strtoupper(substr(sha1(uniqid((string)mt_rand(), true)), 0, 4));
            $code = $base . '-' . $suffix;
            $exists = $this->projectModel->where('code', $code)->countAllResults();
            $tries++;
        } while ($exists && $tries < $maxTries);
        // if collision persisted (extremely unlikely), append timestamp
        if ($exists) {
            $code = $base . '-' . time();
        }
        return $code;
    }

    // --- Solicitud de retiro con reglas de retención y días permitidos ---
    public function solicitarRetiro()
    {
    $dia = date('j');
    if ($dia != 1 && $dia != 2) {
    return $this->response->setJSON([
    'success' => false,
    'message' => 'Solo puedes solicitar retiros el 1 y 2 de cada mes.'
    ]);
    }

    $customer_id = $this->request->getPost('customer_id');
    $monto = $this->request->getPost('amount');
    $factura = $this->request->getFile('factura');

    // Validar factura requerida
    if (!$factura || !$factura->isValid()) {
    return $this->response->setJSON([
    'success' => false,
    'message' => 'Debes subir la factura.'
    ]);
    }

    // Obtener datos del cliente
    $customer = model('CustomerModel')->find($customer_id);
    if (!$customer) {
    return $this->response->setJSON([
    'success' => false,
    'message' => 'Cliente no encontrado.'
    ]);
    }

    // Calcular retención
    $retencion = 0;
    if ($monto >= 700 && isset($customer['retencion']) && $customer['retencion'] == 1) {
    $retencion = round($monto * 0.12, 2);
    }
    $monto_neto = $monto - $retencion;

    // Guardar factura
    $facturaName = $factura->getRandomName();
    $factura->move(WRITEPATH . 'facturas/', $facturaName);

    // Guardar retiro (ajusta el modelo y tabla según tu estructura)
    $retiroModel = model('RetiroModel');
    $retiroModel->insert([
    'customer_id' => $customer_id,
    'monto' => $monto,
    'retencion' => $retencion,
    'monto_neto' => $monto_neto,
    'factura' => $facturaName,
    'fecha' => date('Y-m-d H:i:s'),
    ]);

    return $this->response->setJSON([
    'success' => true,
    'message' => 'Solicitud de retiro registrada correctamente.',
    'retencion' => $retencion,
    'monto_neto' => $monto_neto
    ]);
    }
// ...existing use statements...
// ...la clase ya está declarada arriba, eliminar duplicados...
    // Editar proyecto inmobiliario (AJAX)
    public function edit_project($id)
    {
        if (strtolower($this->request->getMethod()) === 'post') {
            $data = [
                'name' => $this->request->getPost('name'),
                'code' => $this->request->getPost('code'),
                'description' => $this->request->getPost('description'),
                'base_price_per_sqm' => $this->request->getPost('base_price_per_sqm'),
                'base_interest_rate' => $this->request->getPost('base_interest_rate'),
                'status' => $this->request->getPost('status') ?: 'planning',
                'payment_plan_id' => $this->request->getPost('payment_plan_id'),
                'department_id' => $this->request->getPost('department_id'),
                'province_id' => $this->request->getPost('province_id'),
                'district_id' => $this->request->getPost('district_id'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Validación básica
              if (empty($data['name'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Completa los campos obligatorios: nombre.'
                ]);
            }

            // Validar payment_plan_id
            if (empty($data['payment_plan_id'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Debe seleccionar un plan de pago.'
                ]);
            }

            // Verificar que el plan de pago exista
            $paymentPlanModel = new \App\Models\PaymentPlanModel();
            if (!$paymentPlanModel->find($data['payment_plan_id'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'El plan de pago seleccionado no existe.'
                ]);
            }

            // Validar tasa de interés (0% - 6%)
            if ($data['base_interest_rate'] < 0 || $data['base_interest_rate'] > 6) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'La tasa de interés debe estar entre 0% y 6% (0% para proyectos sin interés).'
                ]);
            }

            // Validar precio por m²
            if ($data['base_price_per_sqm'] <= 0) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'El precio por m² debe ser mayor a 0.'
                ]);
            }

            // Procesar imagen si se envía
            $imageFile = $this->request->getFile('image');
            if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
                $newName = uniqid('project_') . '.' . $imageFile->getExtension();
                $uploadPath = FCPATH . 'assets/project_images/'; // Ruta pública
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                $imageFile->move($uploadPath, $newName);
                $data['image'] = 'assets/project_images/' . $newName;
            }

            // Actualizar el proyecto
            $result = $this->projectModel->update($id, $data);

            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Proyecto actualizado exitosamente'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'No se pudo actualizar el proyecto'
                ]);
            }
        }
        // Si no es POST, retornar error
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Método no permitido'
        ]);
    }

        // Enviar recordatorio por email para cuotas vencidas de un cliente
    public function enviar_recordatorio_cuotas_vencidas($customer_id)
    {
    $db = \Config\Database::connect();
    $email = \Config\Services::email();

    // Buscar cuotas vencidas (status = 'overdue') para el cliente
    $result = $db->table('payment_schedules')
    ->select('payment_schedules.*, contracts.customer_id')
    ->join('contracts', 'contracts.id = payment_schedules.contract_id')
    ->where('payment_schedules.status', 'overdue')
    ->where('contracts.customer_id', $customer_id)
    ->get();

    $cuotas = $result ? $result->getResultArray() : [];
    $enviados = 0;

    foreach ($cuotas as $cuota) {
    $customer = $db->table('customers')->where('id', $cuota['customer_id'])->get()->getRowArray();
    if (!empty($customer['email'])) {
    $email->setTo($customer['email']);
    $email->setSubject('Recordatorio de cuota vencida');
    $email->setMessage("Estimado {$customer['name']},\n\nTiene una cuota vencida el {$cuota['due_date']} por S/
    {$cuota['amount']}.\nPor favor regularice su pago para evitar penalidades.\n\nGracias.");
    if ($email->send()) {
    $enviados++;
    }
    }
    }

    if ($enviados > 0) {
    $msg = "Recordatorio enviado a cliente ID $customer_id: $enviados";
    } else {
    $msg = "No hay cuotas vencidas para el cliente ID $customer_id.";
    }
    return $this->response->setJSON([
    'success' => true,
    'message' => $msg
    ]);
    }
 // Consulta si un cliente tiene cuotas vencidas por nombre
    public function consultar_cuotas_vencidas_por_nombre($nombre)
    {
    $db = \Config\Database::connect();
    // Buscar cliente por nombre (puede ser nombre parcial)
    $cliente = $db->table('customers')->like('name', $nombre)->get()->getRowArray();
    if (!$cliente) {
    return $this->response->setJSON([
    'success' => false,
    'message' => "No se encontró el cliente '$nombre'."
    ]);
    }
    // Buscar contratos del cliente
    $contratos = $db->table('contracts')->where('customer_id', $cliente['id'])->get()->getResultArray();
    if (empty($contratos)) {
    return $this->response->setJSON([
    'success' => false,
    'message' => "El cliente '$nombre' no tiene contratos."
    ]);
    }
    // Buscar cuotas vencidas
    $cuotasVencidas = [];
    foreach ($contratos as $contrato) {
    $cuotas = $db->table('payment_schedules')
    ->where('contract_id', $contrato['id'])
    ->where('status', 'pending')
    ->where('due_date <', date('Y-m-d')) ->get()->getResultArray();
        foreach ($cuotas as $cuota) {
        $cuotasVencidas[] = [
        'contrato_id' => $contrato['id'],
        'cuota_id' => $cuota['id'],
        'due_date' => $cuota['due_date'],
        'amount' => $cuota['amount']
        ];
        }
        }
        if (empty($cuotasVencidas)) {
        return $this->response->setJSON([
        'success' => true,
        'message' => "El cliente '$nombre' no tiene cuotas vencidas."
        ]);
        } else {
        return $this->response->setJSON([
        'success' => true,
        'message' => "El cliente '$nombre' tiene cuotas vencidas.",
        'cuotas_vencidas' => $cuotasVencidas
        ]);
        }
        }
 // Aplica penalidades y notifica al cliente por email
    public function applyPenalties()
    {
    $penaltyModel = new \App\Models\PenaltyModel();
    $paymentScheduleModel = new \App\Models\PaymentScheduleModel();
    $contractModel = new \App\Models\ContractModel();

    // Penalidad por mora (cuotas vencidas > 30 días)
    $overduePayments = $paymentScheduleModel
    ->where('status', 'pending')
    ->where('due_date <', date('Y-m-d', strtotime('-30 days'))) ->findAll();

        foreach ($overduePayments as $payment) {
        $exists = $penaltyModel
        ->where('payment_schedule_id', $payment['id'])
        ->where('type', 'mora')
        ->first();
        if (!$exists) {
        $penaltyModel->insert([
        'contract_id' => $payment['contract_id'],
        'payment_schedule_id' => $payment['id'],
        'type' => 'mora',
        'amount' => 20.00,
        'notes' => 'Penalidad por mora (más de 30 días sin pago)'
        ]);
        // Enviar email al cliente
        $contract = $contractModel->find($payment['contract_id']);
        $customer = model('CustomerModel')->find($contract['customer_id']);
        if (!empty($customer['email'])) {
        $email = \Config\Services::email();
        $email->setTo($customer['email']);
        $email->setSubject('Penalidad aplicada por mora');
        $email->setMessage("Estimado {$customer['name']},\n\nSe ha aplicado una penalidad de S/20 por mora en su cuota
        vencida.\nPor favor regularice su pago para evitar nuevas penalidades o suspensión.");
        $email->send();
        }
        }
        }

        // Suspensión por 3 cuotas consecutivas en mora
        $contracts = $contractModel->findAll();
        foreach ($contracts as $contract) {
        $moras = $paymentScheduleModel
        ->where('contract_id', $contract['id'])
        ->where('status', 'pending')
        ->where('due_date <', date('Y-m-d', strtotime('-30 days'))) ->orderBy('due_date', 'desc')
            ->findAll();

            if (count($moras) >= 3) {
            $exists = $penaltyModel
            ->where('contract_id', $contract['id'])
            ->where('type', 'suspension')
            ->first();
            if (!$exists) {
            $penaltyModel->insert([
            'contract_id' => $contract['id'],
            'type' => 'suspension',
            'amount' => 10000.00,
            'notes' => 'Suspensión automática por 3 cuotas en mora'
            ]);
            $contractModel->update($contract['id'], ['status' => 'suspended']);
            // Enviar email al cliente por suspensión
            $customer = model('CustomerModel')->find($contract['customer_id']);
            if (!empty($customer['email'])) {
            $email = \Config\Services::email();
            $email->setTo($customer['email']);
            $email->setSubject('Suspensión de contrato por mora');
            $email->setMessage("Estimado {$customer['name']},\n\nSu contrato ha sido suspendido automáticamente por
            tener 3 cuotas en mora. Se ha aplicado una penalidad de S/10,000. Por favor comuníquese para regularizar su
            situación.");
            $email->send();
            }
            }
            }
            }

            return $this->response->setJSON([
            'success' => true,
            'message' => 'Penalidades aplicadas y notificaciones enviadas.'
            ]);
            }
      /**
     * Enviar recordatorios de vencimiento por email a clientes con cuotas próximas a vencer (7 días antes)
     */

    public function getDepartments()
    {
    $db = \Config\Database::connect();
    $departments = $db->table('departments')->get()->getResultArray();
    return $this->response->setJSON($departments);
    }

    // Endpoint para obtener provincias por departamento
    public function getProvinces($department_id)
    {
    $db = \Config\Database::connect();
    $provinces = $db->table('provinces')->where('department_id', $department_id)->get()->getResultArray();
    return $this->response->setJSON($provinces);
    }

    // Endpoint para obtener distritos por provincia
    public function getDistricts($province_id)
    {
    $db = \Config\Database::connect();
    $districts = $db->table('districts')->where('province_id', $province_id)->get()->getResultArray();
    return $this->response->setJSON($districts);
    }

    // Endpoint para obtener planes de pago disponibles
    public function getPaymentPlans()
    {
    $paymentPlans = $this->paymentPlanModel->where('active', 1)->orderBy('is_default', 'DESC')->orderBy('name', 'ASC')->findAll();
    return $this->response->setJSON($paymentPlans);
    }

    /**
    * Enviar recordatorios de vencimiento por email a clientes con cuotas próximas a vencer (7 días antes)
 
    * Devengar intereses mensuales en cuotas pendientes
    */
    public function devengar_intereses()
    {
    $paymentScheduleModel = model('PaymentScheduleModel');
    $contractModel = model('ContractModel');

    // Busca todas las cuotas pendientes y no pagadas
    $cuotas = $paymentScheduleModel
    ->where('status', 'pending')
    ->findAll();

    foreach ($cuotas as $cuota) {
    // Si la cuota ya tiene devengo registrado este mes, omitir
    if (!empty($cuota['interest_accrued_date']) && substr($cuota['interest_accrued_date'], 0, 7) == date('Y-m'))
    continue;

    // Calcula el interés mensual según la tasa del contrato
    $contrato = $contractModel->find($cuota['contract_id']);
    $tasa = $contrato['interest_rate'] ?? 3.5; // Por defecto 3.5%
    $saldo = $cuota['balance'] ?? $contrato['financed_amount'] ?? 0;
    $interes = round($saldo * ($tasa / 100) / 12, 2);

    // Marca el devengo en la cuota
    $paymentScheduleModel->update($cuota['id'], [
    'interest_accrued' => $interes,
    'interest_accrued_date' => date('Y-m-d')
    ]);
    }

    return $this->response->setJSON(['success' => true, 'message' => 'Intereses devengados correctamente']);
    }
    


    /**
    * Muestra el detalle de un contrato específico
    */
    public function view_contract($id)
    {
        // Obtener el contrato por ID
        $contract = $this->contractModel->find($id);
        if (!$contract) {
            return redirect()->to('/dashboard/inmueble/contracts/contracts')->with('error', 'Contrato no encontrado');
        }


        // Obtener datos relacionados
        $customerModel = model('CustomerModel');
        $lotModel = model('LotModel');
        $projectModel = model('ProjectModel');
        $paymentScheduleModel = model('PaymentScheduleModel');
        $paymentPlanModel = model('PaymentPlanModel');

        $customer = $customerModel->find($contract['customer_id'] ?? 0);
        $lot = $lotModel->find($contract['lot_id'] ?? 0);
        $project = $projectModel->find($lot['project_id'] ?? 0);
        $paymentPlan = $paymentPlanModel->find($contract['payment_plan_id'] ?? 0);

        // Obtener cuotas del contrato
        $cuotas = $paymentScheduleModel
            ->where('contract_id', $id)
            ->findAll();

        // Contadores para resumen de pagos
        $cuotasPagadas = 0;
        $cuotasPendientes = 0;
        $cuotasVencidas = 0;
        foreach ($cuotas as $cuota) {
            if ($cuota['status'] === 'paid') $cuotasPagadas++;
            elseif ($cuota['status'] === 'pending') $cuotasPendientes++;
            elseif ($cuota['status'] === 'overdue') $cuotasVencidas++;
        }
        $avance = count($cuotas) > 0 ? round(($cuotasPagadas / count($cuotas)) * 100) : 0;

        // Renderizar la vista de detalle con todos los datos
        return view('admin/inmueble/contracts/contract_detail', [
            'contract' => $contract,
            'customer' => $customer,
            'lot' => $lot,
            'project' => $project,
            'paymentPlan' => $paymentPlan,
            'cuotas' => $cuotas,
            'cuotasPagadas' => $cuotasPagadas,
            'cuotasPendientes' => $cuotasPendientes,
            'cuotasVencidas' => $cuotasVencidas,
            'avance' => $avance
        ]);
    }
   

    
    /**
    * Registrar el pago de una cuota y emitir el comprobante electrónico.
    * Llama a emitirYGuardarComprobante después de registrar el pago.
    */
    public function registrar_pago_cuota()
    {
    log_message('debug', 'registrar_pago_cuota método: ' . $this->request->getMethod());
    if (strtolower($this->request->getMethod()) !== 'post') {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Método no permitido'
        ]);
    }

    $cuotaId = $this->request->getPost('cuota_id');
    $montoPagado = $this->request->getPost('monto');
    $contratoId = $this->request->getPost('contrato_id');

    // Validaciones básicas
    if (empty($cuotaId) || empty($montoPagado) || empty($contratoId)) {
    return $this->response->setJSON([
    'success' => false,
    'message' => 'Faltan datos para registrar el pago.'
    ]);
    }

    // Obtener datos de cuota, contrato y cliente
    $paymentScheduleModel = model('PaymentScheduleModel');
    $contractModel = model('ContractModel');
    $customerModel = model('CustomerModel');

    $cuota = $paymentScheduleModel->find($cuotaId);
    $contrato = $contractModel->find($contratoId);
    $cliente = $customerModel->find($contrato['customer_id']);

    // Registrar el pago (actualiza estado y monto pagado)
    $paymentScheduleModel->update($cuotaId, [
    'status' => 'paid',
    'paid_amount' => $montoPagado,
    'paid_date' => date('Y-m-d H:i:s')
    ]);

    // Emitir comprobante y guardar enlaces PDF/XML
    $respuesta = $this->emitirYGuardarComprobante($cliente, $cuota, $contrato, $cuotaId);

    // Obtener el ID de la factura generada (ajusta la clave si es diferente)
    $facturaId = $respuesta['data']['factura_id'] ?? null;
    if ($facturaId) {
        $paymentScheduleModel->update($cuotaId, ['invoice_id' => $facturaId]);
        $cuota = $paymentScheduleModel->find($cuotaId); // Recarga la cuota con el invoice_id
    }
    $invoice_id = isset($cuota['invoice_id']) ? $cuota['invoice_id'] : null;

    if ($respuesta['status'] === true) {
        // --- COMISIONES AUTOMÁTICAS ---
        $comisionesInmobiliariasModel = new \App\Models\ComisionesInmobiliariasModel();
        $unilevelModel = new \App\Models\UnilevelsModel();
        $tipo_agente = $cliente['tipo_agente'] ?? 'externo';
        $vendedor_id = $contrato['seller_id'] ?? null;
        $customer_id = $contrato['customer_id'];
        $monto_compra = $montoPagado;
        $fecha = date('Y-m-d H:i:s');

        // Comisión de Venta Base (para el vendedor/agente, NO el comprador)
        if ($vendedor_id) {
            $porcentaje_base = ($tipo_agente === 'externo') ? 0.05 : 0.02;
            $monto_comision = $monto_compra * $porcentaje_base;
            log_message('debug', 'Creando comisión inmobiliaria para vendedor/agente: vendedor_id=' . $vendedor_id . ', monto=' . $monto_comision . ', contrato_id=' . $contractId);
            $insert_id_base = $comisionesInmobiliariasModel->insert([
                'venta_id' => $contractId,
                'beneficiario_id' => $vendedor_id,
                'tipo_comision' => 'venta_base',
                'monto' => $monto_comision,
                'porcentaje' => $porcentaje_base * 100,
                'estado' => 'aprobada',
                'fecha_generada' => $fecha,
                'created_at' => $fecha,
                'updated_at' => $fecha
            ]);
            log_message('debug', 'Comisión venta_base creada: venta_id=' . $contractId . ', beneficiario_id=' . $vendedor_id . ', insert_id=' . $insert_id_base);
        } else {
            log_message('error', 'No se encontró seller_id en el contrato para venta_base. Contrato ID: ' . $contractId);
        }

        // Comisión Nivel 1 (Patrocinador directo)
        $sponsor_id_nivel1 = $unilevelModel->get_sponsor_level_1($customer_id);
        if ($sponsor_id_nivel1) {
            $monto_comision_n1 = $monto_compra * 0.04;
            log_message('debug', 'Creando comisión inmobiliaria para patrocinador directo: sponsor_id_nivel1=' . $sponsor_id_nivel1 . ', monto=' . $monto_comision_n1 . ', contrato_id=' . $contractId);
            $insert_id_n1 = $comisionesInmobiliariasModel->insert([
                'venta_id' => $contractId,
                'beneficiario_id' => $sponsor_id_nivel1,
                'tipo_comision' => 'nivel_1',
                'monto' => $monto_comision_n1,
                'porcentaje' => 4,
                'estado' => 'aprobada',
                'fecha_generada' => $fecha,
                'created_at' => $fecha,
                'updated_at' => $fecha
            ]);
            log_message('debug', 'Comisión nivel_1 creada: venta_id=' . $contractId . ', beneficiario_id=' . $sponsor_id_nivel1 . ', insert_id=' . $insert_id_n1);
        } else {
            log_message('error', 'No se encontró patrocinador directo (nivel_1) para el cliente ' . $customer_id . ' en contrato ' . $contractId);
        }

        // Comisión Nivel 1 (Patrocinador directo)
        $sponsor_id_nivel1 = $unilevelModel->get_sponsor_level_1($customer_id);
        if ($sponsor_id_nivel1) {
            $monto_comision_n1 = $monto_compra * 0.04;
            log_message('debug', 'Creando comisión inmobiliaria para patrocinador directo: sponsor_id_nivel1=' . $sponsor_id_nivel1 . ', monto=' . $monto_comision_n1 . ', contrato_id=' . $contractId);
            $insert_id = $comisionesInmobiliariasModel->insert([
                'venta_id' => $contractId,
                'beneficiario_id' => $sponsor_id_nivel1,
                'tipo_comision' => 'nivel_1',
                'monto' => $monto_comision_n1,
                'porcentaje' => 4,
                'estado' => 'aprobada',
                'fecha_generada' => $fecha,
                'created_at' => $fecha,
                'updated_at' => $fecha
            ]);
            log_message('debug', 'Comisión nivel_1 creada: venta_id=' . $contractId . ', beneficiario_id=' . $sponsor_id_nivel1 . ', insert_id=' . $insert_id);
        }

        // Comisión Nivel 2 (Patrocinador del patrocinador)
        $sponsor_id_nivel2 = $unilevelModel->get_sponsor_level_2($customer_id);
        if ($sponsor_id_nivel2) {
            $monto_comision_n2 = $monto_compra * 0.01;
            log_message('debug', 'Creando comisión inmobiliaria para patrocinador del patrocinador: sponsor_id_nivel2=' . $sponsor_id_nivel2 . ', monto=' . $monto_comision_n2 . ', contrato_id=' . $contractId);
            $comisionesInmobiliariasModel->insert([
                'venta_id' => $contractId,
                'beneficiario_id' => $sponsor_id_nivel2,
                'tipo_comision' => 'nivel_2',
                'monto' => $monto_comision_n2,
                'porcentaje' => 1,
                'estado' => 'aprobada',
                'fecha_generada' => $fecha,
                'created_at' => $fecha,
                'updated_at' => $fecha
            ]);
        }

        // --- FIN COMISIONES AUTOMÁTICAS ---
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Pago registrado y comprobante emitido correctamente.',
            'pdf_url' => $respuesta['data']['enlace_del_pdf'] ?? null,
            'xml_url' => $respuesta['data']['enlace_del_xml'] ?? null
        ]);
    } else {
    return $this->response->setJSON([
    'success' => false,
    'message' => 'Pago registrado, pero hubo un error al emitir el comprobante.',
    'error' => $respuesta['message'] ?? 'Error desconocido'
    ]);
    }
    }
    /**
     * Automatiza la emisión de comprobante y guarda los enlaces PDF/XML en la base de datos de cuotas/pagos.
     * Llamar este método después de registrar el pago/cuota.
     */
   
 // API: Obtener lotes disponibles para contratos
    public function get_available_lots()
    {
        // Solo lotes disponibles y proyectos activos o en planificación
        $lots = $this->lotModel
            ->select('lots.*, projects.name as project_name, projects.status as project_status, projects.department_id as project_department_id, projects.province_id as project_province_id, projects.district_id as project_district_id, projects.base_interest_rate, payment_plans.down_payment_type, payment_plans.min_down_payment_percentage, payment_plans.min_amount, payment_plans.duration_months')
            ->join('projects', 'projects.id = lots.project_id')
            ->join('payment_plans', 'payment_plans.id = projects.payment_plan_id', 'left')
            ->where('lots.status', 'available')
            ->whereIn('projects.status', ['active', 'planning'])
            ->findAll();

        // Formatear respuesta para frontend
        $responseLots = array_map(function($lot) {
            return [
                'id' => $lot['id'],
                'project_id' => $lot['project_id'],
                'project_name' => $lot['project_name'],
                'project_status' => $lot['project_status'],
                'lot_number' => $lot['lot_number'],
                'block' => $lot['block'],
                'area_sqm' => $lot['area_sqm'],
                'current_price' => $lot['current_price'],
                'status' => $lot['status'],
                'department_id' => $lot['project_department_id'] ?? ($lot['department_id'] ?? null),
                'province_id' => $lot['project_province_id'] ?? ($lot['province_id'] ?? null),
                'district_id' => $lot['project_district_id'] ?? ($lot['district_id'] ?? null),
                'down_payment_type' => $lot['down_payment_type'] ?? null,
                'min_down_payment_percentage' => $lot['min_down_payment_percentage'] ?? null,
                'min_down_payment_fixed' => $lot['min_amount'] ?? null,
                'base_interest_rate' => $lot['base_interest_rate'] ?? null,
                'duration_months' => $lot['duration_months'] ?? null
            ];
        }, $lots);

        return $this->response->setJSON([
            'success' => true,
            'lots' => $responseLots
        ]);
    }
    // Actualiza los contadores de lotes en el proyecto
    

        // Reservar lote y registrar abono
    public function reserve_lot()
    {
    log_message('debug', 'reserve_lot método: ' . $this->request->getMethod());
    if (strtolower($this->request->getMethod()) !== 'post') {
    return $this->response->setJSON([
    'success' => false,
    'message' => 'Método no permitido'
    ]);
    }

    $lot_id = $this->request->getPost('lot_id');
    $amount = $this->request->getPost('amount');
    $customer_id = $this->request->getPost('customer_id');

    // Validaciones básicas
    if (empty($lot_id) || empty($amount) || empty($customer_id)) {
    return $this->response->setJSON([
    'success' => false,
    'message' => 'Faltan datos para la reserva.'
    ]);
    }

    $lot = $this->lotModel->find($lot_id);
    if (!$lot) {
    return $this->response->setJSON([
    'success' => false,
    'message' => 'Lote no encontrado.'
    ]);
    }
    if ($lot['status'] !== 'available') {
    return $this->response->setJSON([
    'success' => false,
    'message' => 'El lote no está disponible para reservar.'
    ]);
    }

    // Cambiar estado del lote a 'reservado' y asociar cliente
    $updateData = [
    'status' => 'reserved',
    'customer_id' => $customer_id,
    'reservation_date' => date('Y-m-d H:i:s'),
    'reservation_amount' => $amount
    ];
    $result = $this->lotModel->update($lot_id, $updateData);

    if ($result) {
        // Opcional: registrar movimiento de abono en tabla de pagos si existe
        if (isset($this->paymentModel)) {
            $this->paymentModel->insert([
                'lot_id' => $lot_id,
                'customer_id' => $customer_id,
                'amount' => $amount,
                'type' => 'reservation',
                'date' => date('Y-m-d H:i:s'),
                'status' => 'completed'
            ]);
        }

        // BONO DE RESERVA: Si la reserva es de S/1000 o más, asignar bono de S/300 al patrocinador directo
        if ($amount >= 1000) {
            $commissionsModel = new \App\Models\CommissionsModel();
            $unilevelModel = new \App\Models\UnilevelsModel();
            $nivel1 = $unilevelModel->where('customer_id', $customer_id)->first();
            $sponsor_id = $nivel1 ? $nivel1['sponsor_id'] : null;

            if ($sponsor_id) {
                $commissionsModel->insert([
                    'customer_id' => $sponsor_id,
                    'amount' => 300,
                    'type' => 'bono_reserva',
                    'status' => 'pendiente',
                    'created_at' => date('Y-m-d H:i:s'),
                    'notes' => 'Bono de reserva por cliente ID ' . $customer_id
                ]);
            }
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Lote reservado exitosamente.'
        ]);
    } else {
    return $this->response->setJSON([
    'success' => false,
    'message' => 'Error al reservar el lote.'
    ]);
    }
    }

    private function updateProjectLotCounters($project_id)
    {
        $total = $this->lotModel->where('project_id', $project_id)->countAllResults();
        $available = $this->lotModel->where('project_id', $project_id)->where('status', 'available')->countAllResults();
        $this->projectModel->update($project_id, [
            'total_lots' => $total,
            'available_lots' => $available
        ]);
    }
    
        // Actualizar estado de contrato (suspender, cancelar, etc.)
    public function update_contract_status()
    {
    $request = $this->request;
    if (strtolower($request->getMethod()) === 'post') {
        // Soportar tanto JSON como form-data
        $data = $request->getPost();
        if (empty($data) && strpos($request->getHeaderLine('Content-Type'), 'application/json') !== false) {
            $json = $request->getJSON(true);
            if (is_array($json)) {
                $data = $json;
            }
        }
    log_message('debug', 'update_contract_status datos: ' . json_encode($data, JSON_UNESCAPED_UNICODE));
    $contract_id = $data['contract_id'] ?? null;
    $status = $data['status'] ?? null;
        if (!$contract_id || !$status) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Datos incompletos',
                'debug' => $data
            ]);
        }
        $contract = $this->contractModel->find($contract_id);
        if (!$contract) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Contrato no encontrado',
                'debug' => [ 'contract_id' => $contract_id ]
            ]);
        }
        $result = $this->contractModel->update($contract_id, ['status' => $status]);
        $errors = $this->contractModel->errors();
        if ($result) {
            return $this->response->setJSON(['success' => true]);
        } else {
            $errorMsg = 'Error al actualizar el estado';
            if (!empty($errors)) {
                $errorMsg .= ': ' . json_encode($errors, JSON_UNESCAPED_UNICODE);
            }
            return $this->response->setJSON([
                'success' => false,
                'message' => $errorMsg,
                'debug' => $data,
                'errors' => $errors
            ]);
        }
    }
    // Si no es POST, devolver error
    return $this->response->setJSON(['success' => false, 'message' => 'Método no permitido']);
    }
    
      public function delete_contract()
    {
    $request = $this->request;
    if ($request->getMethod() !== 'post') {
        return $this->response->setJSON(['success' => false, 'message' => 'Método no permitido']);
    }
    $contract_id = $request->getJSON(true)['contract_id'] ?? null;
    if (!$contract_id) {
        return $this->response->setJSON(['success' => false, 'message' => 'ID de contrato requerido']);
    }
    $contract = $this->contractModel->find($contract_id);
    if (!$contract) {
        return $this->response->setJSON(['success' => false, 'message' => 'Contrato no encontrado']);
    }

    // If contract type is 'arras', update lot status to 'available' and clear customer_id
    if (isset($contract['contract_type']) && $contract['contract_type'] === 'arras' && isset($contract['lot_id'])) {
        $lot = $this->lotModel->find($contract['lot_id']);
        if ($lot) {
            $this->lotModel->update($contract['lot_id'], [
                'status' => 'available',
                'customer_id' => null
            ]);
        }
    }

    if ($this->contractModel->delete($contract_id)) {
        return $this->response->setJSON(['success' => true]);
    } else {
        return $this->response->setJSON(['success' => false, 'message' => 'No se pudo eliminar el contrato']);
    }
    }
    
    
    // Alias para la edición de contrato compatible con la ruta edit_contract
    public function edit_contract($contract_id)
    {
        // Si es POST/AJAX, delega a editContract
        if ($this->request->isAJAX() && strtolower($this->request->getMethod()) === 'post') {
            return $this->editContract($contract_id);
        }
        // Si es GET, muestra la vista de edición
        $contract = $this->contractModel->find($contract_id);
        if (!$contract) {
            return redirect()->to('/dashboard/inmueble/contracts/contracts')->with('error', 'Contrato no encontrado');
        }
        $customerModel = model('CustomerModel');
        $lotModel = model('LotModel');
        $contract['customer_name'] = '';
        $contract['lot_number'] = '';
        if ($contract['customer_id']) {
            $customer = $customerModel->find($contract['customer_id']);
            if ($customer) {
                $contract['customer_name'] = $customer['name'] . ' ' . ($customer['lastname'] ?? '');
            }
        }
        if ($contract['lot_id']) {
            $lot = $lotModel->find($contract['lot_id']);
            if ($lot) {
                $contract['lot_number'] = $lot['lot_number'];
            }
        }
        // Obtener agentes patrocinadores activos
        $agents = $customerModel->getActiveSponsors();
        // LOG después de obtener los datos necesarios
        $logData = [
            'datetime' => date('Y-m-d H:i:s'),
            'contract_id' => $contract_id,
            'agents' => $agents,
            'contract' => $contract
        ];
        $logFile = WRITEPATH . 'logs/edit_contract_' . date('Ymd_His') . '.log';
        file_put_contents($logFile, json_encode($logData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        return view('admin/inmueble/contracts/edit_contract', ['contract' => $contract, 'agents' => $agents]);
    }

    // Crear proyecto inmobiliario (AJAX)
    public function create_project()
    {
    if (strtolower($this->request->getMethod()) === 'post') {
                log_message('debug', 'Entró a create_project POST');
            $data = [
                'name' => $this->request->getPost('name'),
                'code' => $this->request->getPost('code'),
                'description' => $this->request->getPost('description'),
                'base_price_per_sqm' => $this->request->getPost('base_price_per_sqm'),
                'base_interest_rate' => $this->request->getPost('base_interest_rate'),
                'status' => $this->request->getPost('status') ?: 'planning',
                'payment_plan_id' => $this->request->getPost('payment_plan_id'),
                'total_lots' => 0,
                'available_lots' => 0,
                'department_id' => $this->request->getPost('department_id'),
                'province_id' => $this->request->getPost('province_id'),
                'district_id' => $this->request->getPost('district_id'),
            ];

            // Crear log de auditoría del proyecto
            $logFile = WRITEPATH . 'logs/project_create_' . date('Ymd_His') . '.log';
            file_put_contents($logFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            // Procesar imagen si se envía
            $imageFile = $this->request->getFile('image');
            if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
                $newName = uniqid('project_') . '.' . $imageFile->getExtension();
                $uploadPath = FCPATH . 'assets/project_images/';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                $imageFile->move($uploadPath, $newName);
                $data['image'] = 'assets/project_images/' . $newName;
            } else {
                $data['image'] = null;
            }

            // Validaciones básicas: solo nombre es obligatorio; el código puede generarse server-side
            if (empty($data['name'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Completa los campos obligatorios: nombre.'
                ]);
            }

            // Validar payment_plan_id
            if (empty($data['payment_plan_id'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Debe seleccionar un plan de pago.'
                ]);
            }

            // Verificar que el plan de pago exista
            $paymentPlanModel = new \App\Models\PaymentPlanModel();
            if (!$paymentPlanModel->find($data['payment_plan_id'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'El plan de pago seleccionado no existe.'
                ]);
            }

            // Permitir 0% - 6% para todos los proyectos (0% = sin interés)
            if ($data['base_interest_rate'] < 0 || $data['base_interest_rate'] > 6) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'La tasa de interés debe estar entre 0% y 6% (0% para proyectos sin interés).'
                ]);
            }
            if ($data['base_price_per_sqm'] <= 0) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'El precio por m² debe ser mayor a 0.'
                ]);
            }

            // Verificar código único
            // If code is empty or duplicated, generate a unique code server-side
            $providedCode = trim((string)$this->request->getPost('code'));
            if (empty($providedCode) || $this->projectModel->where('code', $providedCode)->countAllResults() > 0) {
                $generatedCode = $this->generateUniqueCode($data['name']);
                $data['code'] = $generatedCode;
                $usedGeneratedCode = true;
            } else {
                $usedGeneratedCode = false;
                $data['code'] = $providedCode;
            }

            $result = $this->projectModel->insert($data);
            $errors = $this->projectModel->errors();
            // Crear log de resultado de inserción
            $logFileResult = WRITEPATH . 'logs/project_create_result_' . date('Ymd_His') . '.log';
            $logContent = [
                'data' => $data,
                'result' => $result,
                'errors' => $errors,
                'usedGeneratedCode' => $usedGeneratedCode
            ];
            file_put_contents($logFileResult, json_encode($logContent, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Proyecto creado exitosamente.',
                    'id' => $result,
                    'code' => $data['code'],
                    'generated_code' => $usedGeneratedCode
                ]);
            } else {
                $errorMsg = 'Error al crear el proyecto';
                if (!empty($errors)) {
                    $errorMsg .= ': ' . json_encode($errors, JSON_UNESCAPED_UNICODE);
                }
                return $this->response->setJSON([
                    'success' => false,
                    'message' => $errorMsg
                ]);
            }
            // Si llega aquí, es un error inesperado
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error inesperado al crear el proyecto.'
            ]);
        }
        // Si no es POST, responder JSON si es AJAX
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Método no permitido',
                'debug' => [
                    'method' => $this->request->getMethod(),
                    'is_ajax' => $this->request->isAJAX(),
                    'headers' => $this->request->getServer(),
                    'post_data' => $this->request->getPost(),
                ]
            ]);
        }
        // Si no es AJAX, redirigir
        return redirect()->to('/dashboard/inmueble/projects');
    }

    public function index()
    {
        // Redirigir a VIVELAND Registros si el usuario tiene ese privilegio
        $session = session();
        $session_privilege = $session->get('privilegio') ?? $session->get('privilege') ?? null;
        if ($session_privilege == 'viveland_registros') {
            return redirect()->to('/admin/viveland_registros');
        }
        
        $data = [
            'title' => 'Gestión Inmobiliaria',
            'projects' => $this->projectModel->findAll(),
            'total_lots' => $this->lotModel->countAll(),
            'available_lots' => $this->lotModel->where('status', 'available')->countAllResults(),
            'active_contracts' => $this->contractModel->where('status', 'active')->countAllResults(),
            'session_name' => $_SESSION['name'] ?? 'Usuario'
        ];
        
        // --- LOG CRONOGRAMA ---
        if (isset($contracts) && is_array($contracts)) {
            $cronogramas = [];
            foreach ($contracts as $contract) {
                $schedule = [];
                $monthly = isset($contract['monthly_payment']) ? $contract['monthly_payment'] : 0;
                $installments = isset($contract['financing_months']) ? (int)$contract['financing_months'] : 0;
                $start_date = isset($contract['start_date']) ? $contract['start_date'] : date('Y-m-d');
                $date = new \DateTime($start_date);
                for ($i = 1; $i <= $installments; $i++) {
                    $schedule[] = [
                        'num' => $i,
                        'due_date' => $date->format('Y-m-d'),
                        'amount' => $monthly
                    ];
                    $date->modify('+1 month');
                }
                $cronogramas[] = [
                    'contract_id' => $contract['id'] ?? null,
                    'contract_number' => $contract['contract_number'] ?? '',
                    'schedule' => $schedule
                ];
            }
            $logData = [
                'fecha' => date('Y-m-d H:i:s'),
                'cronogramas' => $cronogramas
            ];
            $logFile = WRITEPATH . 'logs/contract_cronograma_' . date('Ymd_His') . '.log';
            file_put_contents($logFile, json_encode($logData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }
        return view('admin/inmueble/contracts/index', $data);
    }

    // Projects Management
    public function projects() {
        $db = \Config\Database::connect();
        // Obtener todos los departamentos
        $departamentos = [];
        foreach ($db->table('departments')->get()->getResultArray() as $dep) {
            $departamentos[$dep['id']] = $dep['name'];
        }
        // Obtener todas las provincias
        $provincias = [];
        foreach ($db->table('provinces')->get()->getResultArray() as $prov) {
            $provincias[$prov['id']] = $prov['name'];
        }
        // Obtener todos los distritos
        $distritos = [];
        foreach ($db->table('districts')->get()->getResultArray() as $dist) {
            $distritos[$dist['id']] = $dist['name'];
        }

        $data = [
            'title' => 'Proyectos Inmobiliarios',
            'projects' => $this->projectModel->findAll(),
            'departamentos' => $departamentos,
            'provincias' => $provincias,
            'distritos' => $distritos,
            'session_name' => $_SESSION['name'] ?? 'Usuario'
        ];
        // Registrar acceso en TXT
        $txtMsg = date('Y-m-d H:i:s') . "\n";
        $txtMsg .= "Acceso a projects()\n";
        $txtMsg .= "Datos enviados a la vista: " . json_encode($data, JSON_UNESCAPED_UNICODE) . "\n";
        $txtMsg .= str_repeat('-', 40) . "\n";
        file_put_contents(FCPATH . 'prueba_modal_mensaje.txt', $txtMsg, FILE_APPEND);
        return view('admin/inmueble/projects/projects', $data);
    }

    
    public function get_project($project_id)
    {
        $project = $this->projectModel->find($project_id);
        $db = \Config\Database::connect();
        $departamentos = [];
        foreach ($db->table('departments')->get()->getResultArray() as $dep) {
            $departamentos[$dep['id']] = $dep['name'];
        }
        $provincias = [];
        foreach ($db->table('provinces')->get()->getResultArray() as $prov) {
            $provincias[$prov['id']] = $prov['name'];
        }
        $distritos = [];
        foreach ($db->table('districts')->get()->getResultArray() as $dist) {
            $distritos[$dist['id']] = $dist['name'];
        }
        if ($project) {
            return $this->response->setJSON([
                'success' => true,
                'project' => $project,
                'departamentos' => $departamentos,
                'provincias' => $provincias,
                'distritos' => $distritos
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Proyecto no encontrado'
            ]);
        }
    }

    

    public function delete_project($project_id)
    {
        $project = $this->projectModel->find($project_id);
        if ($this->request->isAJAX()) {
            if (!$project) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Proyecto no encontrado'
                ]);
                exit();
            }
            $lotsCount = $this->lotModel->where('project_id', $project_id)->countAllResults();
            if ($lotsCount > 0) {
                echo json_encode([
                    'success' => false,
                    'message' => 'No se puede eliminar el proyecto porque tiene ' . $lotsCount . ' lotes asociados'
                ]);
                exit();
            }
            $result = $this->projectModel->delete($project_id);
            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Proyecto eliminado exitosamente'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Error al eliminar el proyecto'
                ]);
            }
            exit();
        } else {
            if (!$project) {
                return redirect()->to('/dashboard/inmueble/projects')->with('error', 'Proyecto no encontrado');
            }
            $lotsCount = $this->lotModel->where('project_id', $project_id)->countAllResults();
            if ($lotsCount > 0) {
                return redirect()->to('/dashboard/inmueble/projects')->with('error', 'No se puede eliminar el proyecto porque tiene ' + $lotsCount + ' lotes asociados');
            }
            if ($this->projectModel->delete($project_id)) {
                return redirect()->to('/dashboard/inmueble/projects')->with('success', 'Proyecto eliminado exitosamente');
            } else {
                return redirect()->to('/dashboard/inmueble/projects')->with('error', 'Error al eliminar el proyecto');
            }
        }
    }

    // Lots Management
    public function lots($project_id = null) {
        // Consulta JOIN para obtener lotes con info de proyecto, cliente y contrato
        $db = \Config\Database::connect();
        $builder = $db->table('lots');
    $builder->select('lots.id, lots.project_id, lots.lot_number, lots.block, lots.cadastral_unit, lots.registry_number, lots.area_sqm, lots.base_price, lots.current_price, lots.status, lots.customer_id, lots.sale_date, projects.name AS project_name, projects.payment_plan_id, customers.name AS customer_name, contracts.is_reserved, contracts.reservation_amount AS contract_reservation_amount, contracts.reservation_date AS contract_reservation_date, contracts.status AS contract_status, payment_plans.down_payment_type, payment_plans.min_down_payment_percentage, payment_plans.min_amount, payment_plans.duration_months, payment_plans.base_interest_rate as plan_interest_rate');
        $builder->join('projects', 'projects.id = lots.project_id', 'left');
        $builder->join('payment_plans', 'payment_plans.id = projects.payment_plan_id', 'left');
        $builder->join('customers', 'customers.id = lots.customer_id', 'left');
        $builder->join('contracts', 'contracts.lot_id = lots.id', 'left');
        if ($project_id) {
            $builder->where('lots.project_id', $project_id);
        }
        $builder->orderBy('lots.id', 'DESC');
        $lots = $builder->get()->getResultArray();

        $data = [
            'title' => 'Gestión de Lotes',
            'lots' => $lots,
            'projects' => $this->projectModel->findAll(),
            'selected_project' => $project_id,
            'session_name' => $_SESSION['name'] ?? 'Usuario'
        ];
        return view('admin/inmueble/lots/lots', $data);
    }
    public function create_lot()
    {
        if (strtolower($this->request->getMethod()) === 'post') {
            $data = [
                'project_id' => $this->request->getPost('project_id'),
                'lot_number' => $this->request->getPost('lot_number'),
                'block' => $this->request->getPost('block'),
                'cadastral_unit' => $this->request->getPost('cadastral_unit'),
                'registry_number' => $this->request->getPost('registry_number'),
                'area_sqm' => $this->request->getPost('area_sqm'),
                'base_price' => $this->request->getPost('base_price'),
                'current_price' => $this->request->getPost('base_price'),
                'status' => 'available'
            ];

            // Validaciones básicas
            if (empty($data['project_id']) || empty($data['lot_number']) || empty($data['area_sqm']) || empty($data['base_price'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Completa todos los campos obligatorios.'
                ]);
            }
            if ($data['area_sqm'] < 50) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'El área mínima debe ser de 50 m².'
                ]);
            }
            if ($data['base_price'] <= 0) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'El precio del lote debe ser mayor a 0.'
                ]);
            }

            // Verificar número de lote único en el proyecto
            $projectId = $data['project_id'];
            $lotNumber = $data['lot_number'];
            $count = $this->lotModel->where('project_id', $projectId)->where('lot_number', $lotNumber)->countAllResults();
            log_message('debug', 'Validando lote duplicado: project_id=' . var_export($projectId, true) . ', lot_number=' . var_export($lotNumber, true) . ', count=' . $count);
            if ($count > 0) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'El número de lote ya existe en el proyecto seleccionado.',
                    'debug' => [
                        'project_id' => $projectId,
                        'lot_number' => $lotNumber,
                        'count' => $count
                    ]
                ]);
            }


                // Obtener datos del proyecto asociado
                $project = $this->projectModel->find($data['project_id']);

                // Crear log en writable/logs
                $logData = [
                    'timestamp' => date('Y-m-d H:i:s'),
                    'action' => 'create_lot',
                    'lot_data' => $data,
                    'project_data' => $project
                ];
                $logFile = WRITEPATH . 'logs/lot_create_' . date('Ymd_His') . '.log';
                file_put_contents($logFile, json_encode($logData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

                $result = $this->lotModel->insert($data);
                $errors = $this->lotModel->errors();
                if ($result) {
                    $this->updateProjectLotCounters($data['project_id']);
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Lote creado exitosamente.'
                    ]);
                } else {
                    $errorMsg = 'Error al crear el lote';
                    if (!empty($errors)) {
                        $errorMsg .= ': ' . json_encode($errors, JSON_UNESCAPED_UNICODE);
                    }
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => $errorMsg
                    ]);
                }
        }
        // Si no es POST, responder JSON si es AJAX
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Método no permitido',
                'debug' => [
                    'method' => $this->request->getMethod(),
                    'is_ajax' => $this->request->isAJAX(),
                    'headers' => $this->request->getServer(),
                    'post_data' => $this->request->getPost(),
                ]
            ]);
        }
        // Si no es AJAX, redirigir
        $data = [
            'title' => 'Nuevo Lote',
            'projects' => $this->projectModel->findAll(),
            'session_name' => $_SESSION['name'] ?? 'Usuario'
        ];
        return view('admin/inmueble/lots/create_lot', $data);
    }

    /**
     * Crear múltiples lotes en una sola operación
     */
    public function create_lots_bulk()
    {
        $this->response->setContentType('application/json');

        if (strtolower($this->request->getMethod()) !== 'post') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Método no permitido'
            ]);
        }

        $projectId = $this->request->getJSON()->project_id;
        $lotsData = $this->request->getJSON()->lots ?? [];

        // Validaciones básicas
        if (!$projectId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'El proyecto es requerido'
            ]);
        }

        if (empty($lotsData) || !is_array($lotsData)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Datos de lotes inválidos'
            ]);
        }

        // Verificar que el proyecto existe
        $project = $this->projectModel->find($projectId);
        if (!$project) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Proyecto no encontrado'
            ]);
        }

        $createdCount = 0;
        $errorsList = [];

        foreach ($lotsData as $index => $lot) {
            $rowNum = $index + 1;

            // Validaciones de campos requeridos
            if (empty($lot['lot_number'])) {
                $errorsList[] = "Fila {$rowNum}: Número de lote requerido";
                continue;
            }

            if (empty($lot['area_sqm'])) {
                $errorsList[] = "Fila {$rowNum}: Área requerida";
                continue;
            }

            if (empty($lot['base_price'])) {
                $errorsList[] = "Fila {$rowNum}: Precio requerido";
                continue;
            }

            // Validaciones de valores
            $area = floatval($lot['area_sqm']);
            if ($area < 50) {
                $errorsList[] = "Lote {$lot['lot_number']}: Área mínima 50 m²";
                continue;
            }

            $price = floatval($lot['base_price']);
            if ($price <= 0) {
                $errorsList[] = "Lote {$lot['lot_number']}: Precio debe ser mayor a 0";
                continue;
            }

            // Verificar duplicado
            $existingCount = $this->lotModel
                ->where('project_id', $projectId)
                ->where('lot_number', $lot['lot_number'])
                ->countAllResults();

            if ($existingCount > 0) {
                $errorsList[] = "Lote {$lot['lot_number']}: Ya existe en este proyecto";
                continue;
            }

            // Preparar datos del lote
            $lotData = [
                'project_id' => $projectId,
                'lot_number' => trim($lot['lot_number']),
                'block' => $lot['block'] ?? '',
                'area_sqm' => $area,
                'base_price' => $price,
                'current_price' => $price,
                'status' => $lot['status'] ?? 'available',
                'cadastral_unit' => $lot['cadastral_unit'] ?? '',
                'registry_number' => $lot['registry_number'] ?? '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Intentar crear el lote
            try {
                $result = $this->lotModel->insert($lotData);
                if ($result) {
                    $createdCount++;
                } else {
                    $errors = $this->lotModel->errors();
                    $errorMsg = "Lote {$lot['lot_number']}: Error al guardar";
                    if (!empty($errors)) {
                        $errorMsg .= ' - ' . json_encode($errors);
                    }
                    $errorsList[] = $errorMsg;
                }
            } catch (\Exception $e) {
                $errorsList[] = "Lote {$lot['lot_number']}: " . $e->getMessage();
            }
        }

        // Actualizar contadores del proyecto si se crearon lotes
        if ($createdCount > 0) {
            $this->updateProjectLotCounters($projectId);
        }

        // Log de operación
        $logData = [
            'timestamp' => date('Y-m-d H:i:s'),
            'action' => 'create_lots_bulk',
            'project_id' => $projectId,
            'attempted' => count($lotsData),
            'created' => $createdCount,
            'errors' => count($errorsList)
        ];
        $logFile = WRITEPATH . 'logs/lots_bulk_' . date('Ymd_His') . '.log';
        file_put_contents($logFile, json_encode($logData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        return $this->response->setJSON([
            'success' => true,
            'created_count' => $createdCount,
            'total_attempted' => count($lotsData),
            'errors' => $errorsList,
            'message' => "Se crearon {$createdCount} de " . count($lotsData) . " lote(s)"
        ]);
    }

    public function get_lot($lot_id)
    {
        $lot = $this->lotModel->find($lot_id);
        
        if ($lot) {
            return $this->response->setJSON([
                'success' => true,
                'lot' => $lot
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Lote no encontrado'
            ]);
        }
    }

    public function edit_lot($lot_id)
    {
        if (strtolower($this->request->getMethod()) === 'post') {
            $lot = $this->lotModel->find($lot_id);
            if (!$lot) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Lote no encontrado',
                    'debug' => [ 'lot_id' => $lot_id ]
                ]);
            }
            $res = $this->request->getPost();
            // Si el cuerpo es JSON, decodificarlo
            if (empty($res) && $this->request->getHeaderLine('Content-Type') === 'application/json') {
                $json = $this->request->getJSON(true);
                if (is_array($json)) {
                    $res = $json;
                }
            }
            // Validaciones básicas
            if (empty($res['project_id']) || empty($res['area_sqm']) || empty($res['base_price'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Faltan campos obligatorios',
                    'debug' => $res
                ]);
            }
            if ($res['area_sqm'] < 50) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'El área mínima debe ser de 50 m².',
                    'debug' => $res
                ]);
            }
            if ($res['base_price'] <= 0) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'El precio del lote debe ser mayor a 0.',
                    'debug' => $res
                ]);
            }
            $data = [
                'project_id' => $res['project_id'] ?? '',
                'block' => $res['block'] ?? '',
                'cadastral_unit' => $res['cadastral_unit'] ?? '',
                'registry_number' => $res['registry_number'] ?? '',
                'area_sqm' => $res['area_sqm'] ?? '',
                'base_price' => $res['base_price'] ?? '',
                'current_price' => $res['current_price'] ?? '',
                'status' => $res['status'] ?? ''
            ];
            $result = $this->lotModel->update($lot_id, $data);
            $errors = $this->lotModel->errors();
            if ($result) {
                $this->updateProjectLotCounters($data['project_id']);
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Lote actualizado exitosamente'
                ]);
            } else {
                $errorMsg = 'Error al actualizar el lote';
                if (!empty($errors)) {
                    $errorMsg .= ': ' . json_encode($errors, JSON_UNESCAPED_UNICODE);
                }
                return $this->response->setJSON([
                    'success' => false,
                    'message' => $errorMsg,
                    'debug' => $res
                ]);
            }
        }
        // Si no es POST, responder JSON si es AJAX
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Método no permitido',
                'debug' => [
                    'method' => $this->request->getMethod(),
                    'is_ajax' => $this->request->isAJAX(),
                    'headers' => $this->request->getServer(),
                    'post_data' => $this->request->getPost(),
                ]
            ]);
        }
        // Si no es AJAX, redirigir
        return redirect()->to('/dashboard/inmueble/lots/lots');
    }

    public function delete_lot($lot_id)
    {
        if (strtolower($this->request->getMethod()) === 'get') {
            $lot = $this->lotModel->find($lot_id);
            if (!$lot) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Lote no encontrado',
                    'debug' => [ 'lot_id' => $lot_id ]
                ]);
            }
            $contractsCount = $this->contractModel->where('lot_id', $lot_id)->countAllResults();
            if ($contractsCount > 0) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'No se puede eliminar el lote porque tiene contratos asociados',
                    'debug' => [ 'contractsCount' => $contractsCount ]
                ]);
            }
            $project_id = $lot['project_id'];
            $result = $this->lotModel->delete($lot_id);
            if ($result) {
                $this->updateProjectLotCounters($project_id);
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Lote eliminado exitosamente'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error al eliminar el lote'
                ]);
            }
        }
        // Si no es GET, responder JSON si es AJAX
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Método no permitido',
                'debug' => [
                    'method' => $this->request->getMethod(),
                    'is_ajax' => $this->request->isAJAX(),
                    'headers' => $this->request->getServer(),
                    'get_data' => $this->request->getGet(),
                ]
            ]);
        }
        // Si no es AJAX, redirigir
        return redirect()->to('/dashboard/inmueble/lots/lots');
    }

    // Payment Plans Management
    public function payment_plans() {
        $data = [
            'title' => 'Planes de Pago',
            'payment_plans' => $this->paymentPlanModel->findAll(),
            'session_name' => $_SESSION['name'] ?? 'Usuario'
        ];
        
        return view('admin/inmueble/payment_plans/payment_plans', $data);
    }

    public function create_payment_plan()
    {
        if (strtolower($this->request->getMethod()) === 'post') {
            // Soportar tanto JSON como form-data
            $res = $this->request->getPost();
            if (empty($res) && strpos($this->request->getHeaderLine('Content-Type'), 'application/json') !== false) {
                $json = $this->request->getJSON(true);
                if (is_array($json)) {
                    $res = $json;
                }
            }
            
            // Mapear ubicación a ubicación estándar (compatibilidad)
            $location = $res['location'] ?? '';
            
            $data = [
                'name' => $res['name'] ?? '',
                'code' => $res['code'] ?? '',
                'location' => $location,
                'duration_months' => $res['duration_months'] ?? '',
                'down_payment_type' => $res['down_payment_type'] ?? 'percentage',
                'min_down_payment_percentage' => $res['min_down_payment_percentage'] ?? '',
                'min_amount' => $res['min_amount'] ?? '',
                'base_interest_rate' => $res['base_interest_rate'] ?? '',
                'is_default' => !empty($res['is_default']) ? 1 : 0,
                'active' => !empty($res['active']) ? 1 : 0
            ];
            
            // Validaciones robustas
            if (empty($data['name']) || empty($data['code']) || empty($data['location']) || empty($data['duration_months']) || empty($data['base_interest_rate'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Completa todos los campos obligatorios.'
                ]);
            }
            
            // Validar duración: permite 12, 24, 36, 48 meses
            if (!in_array($data['duration_months'], [12, 24, 36, 48])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'La duración debe ser 12, 24, 36 o 48 meses.'
                ]);
            }
            
            // Validar tasa de interés: 0% - 6% para todos
            if ($data['base_interest_rate'] < 0 || $data['base_interest_rate'] > 6) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'La tasa de interés debe estar entre 0% y 6% (0% = sin interés).'
                ]);
            }
            
            // Validar campos según tipo de cuota inicial
            if ($data['down_payment_type'] === 'percentage') {
                if (empty($data['min_down_payment_percentage'])) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Ingresa el porcentaje de cuota inicial.'
                    ]);
                }
                if ($data['min_down_payment_percentage'] < 1 || $data['min_down_payment_percentage'] > 100) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'El porcentaje debe estar entre 1% y 100%.'
                    ]);
                }
            } else {
                if (empty($data['min_amount'])) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Ingresa el monto fijo de cuota inicial.'
                    ]);
                }
                if ($data['min_amount'] <= 0) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'El monto debe ser mayor a 0.'
                    ]);
                }
            }
            
            // Verificar código único
            if ($this->paymentPlanModel->where('code', $data['code'])->countAllResults() > 0) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'El código ya existe, ingresa uno diferente.'
                ]);
            }
            
            // Si es plan por defecto, desactivar otros planes por defecto de la misma ubicación
            if ($data['is_default']) {
                $this->paymentPlanModel
                    ->where('location', $data['location'])
                    ->set(['is_default' => 0])
                    ->update();
            }
            
            $result = $this->paymentPlanModel->insert($data);
            $errors = $this->paymentPlanModel->errors();
            
            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Plan de pago creado exitosamente'
                ]);
            } else {
                $errorMsg = 'Error al crear el plan de pago';
                if (!empty($errors)) {
                    $errorMsg .= ': ' . json_encode($errors, JSON_UNESCAPED_UNICODE);
                }
                return $this->response->setJSON([
                    'success' => false,
                    'message' => $errorMsg,
                    'debug' => $res
                ]);
            }
        }
        // Si no es POST, responder JSON si es AJAX
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Método no permitido',
                'debug' => [
                    'method' => $this->request->getMethod(),
                    'is_ajax' => $this->request->isAJAX(),
                    'headers' => $this->request->getServer(),
                    'post_data' => $this->request->getPost(),
                ]
            ]);
        }
        // Si no es AJAX, redirigir
        $data = [
            'title' => 'Nuevo Plan de Pago',
            'session_name' => $_SESSION['name'] ?? 'Usuario'
        ];
        return view('admin/inmueble/payment_plans/create_payment_plan', $data);
    }

    // Contracts Management
    public function contracts() {
        $customerModel = new \App\Models\CustomerModel();
        $agents = $customerModel->getActiveSponsors();
        $contractsArray = $this->getContractsWithDetails();
        log_message('debug', 'Array de contratos: ' . print_r($contractsArray, true));
        $data = [
            'title' => 'Contratos',
            'contracts' => $contractsArray,
            'session_name' => $_SESSION['name'] ?? 'Usuario',
            'agents' => $agents
        ];
        return view('admin/inmueble/contracts/contracts', $data);
    }
    public function getContractsWithDetails() {
    $db = \Config\Database::connect();
    return $db->table('contracts')
        ->select('
            contracts.*,
            customers.name as customer_name,
            customers.lastname as customer_lastname,
            customers.dni as customer_dni,
            customers.email as customer_email,
            customers.phone as customer_phone,
            customers.address as customer_address,
            customers.created_at as customer_created_at,
            customers.kyc as customer_kyc,
            customers.ruc as customer_ruc,
            customers.company_name as customer_company_name,
            lots.lot_number as lot_number,
            lots.block as lot_block,
            lots.area_sqm as lot_area,
            lots.current_price as lot_price,
            lots.status as lot_status,
            projects.name as project_name,
            comisiones_inmobiliarias.estado as comision_estado,
            comisiones_inmobiliarias.monto as comision_monto,
            comisiones_inmobiliarias.porcentaje as comision_porcentaje,
            comisiones_inmobiliarias.tipo_comision as comision_tipo
        ')
        ->join('customers', 'customers.id = contracts.customer_id')
        ->join('lots', 'lots.id = contracts.lot_id')
        ->join('projects', 'projects.id = lots.project_id')
        ->join('comisiones_inmobiliarias', 'comisiones_inmobiliarias.venta_id = contracts.id', 'left')
        ->get()
        ->getResultArray();
}
    // API endpoints for AJAX calls
    public function get_project_lots($project_id)
    {
        $lots = $this->lotModel->where('project_id', $project_id)->where('status', 'available')->findAll();
        return $this->response->setJSON($lots);
    }

    public function update_lot_status()
    {
        $lot_id = $this->request->getPost('lot_id');
        $status = $this->request->getPost('status');
        
        if ($this->lotModel->update($lot_id, ['status' => $status])) {
            return $this->response->setJSON(['success' => true]);
        }
        
        return $this->response->setJSON(['success' => false]);
    }

    public function get_lot_details($lot_id)
    {
        $lot = $this->lotModel->find($lot_id);
        
        if (!$lot) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Lote no encontrado'
            ]);
        }
        
        // Get project information
        $project = $this->projectModel->find($lot['project_id']);
        
        // Get customer information if lot is sold/reserved
        $customer = null;
        $contract = null;
        
        if ($lot['customer_id']) {
            // Assuming there's a customer model - adjust according to your structure
            $customerModel = new \App\Models\CustomerModel();
            $customer = $customerModel->find($lot['customer_id']);
            
            // Get contract information
            $contract = $this->contractModel->where('lot_id', $lot_id)->first();
        }
        
        return $this->response->setJSON([
            'success' => true,
            'lot' => $lot,
            'project' => $project,
            'customer' => $customer,
            'contract' => $contract
        ]);
    }

    // API endpoints for the new contract modal
    public function search_customers()
    {
    log_message('debug', 'search_customers método: ' . $this->request->getMethod());
    if (strtolower($this->request->getMethod()) !== 'post') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Método no permitido'
            ]);
        }
        $json = $this->request->getJSON();
        $searchTerm = $json->search ?? '';
        if (strlen($searchTerm) < 3) {
            return $this->response->setJSON(['customers' => []]);
        }
        $customerModel = new \App\Models\CustomerModel();
        $customers = $customerModel
            ->groupStart()
                ->like('name', $searchTerm)
                ->orLike('lastname', $searchTerm)
                ->orLike('dni', $searchTerm)
                ->orLike('code', $searchTerm)
                ->orLike('email', $searchTerm)
            ->groupEnd()
            ->limit(10)
            ->findAll();
        return $this->response->setJSON(['customers' => $customers]);
    }
    
    
    public function get_payment_plans_api()
    {
        $plans = $this->paymentPlanModel
            ->where('active', 1)
            ->findAll();
        
        return $this->response->setJSON(['plans' => $plans]);
    }

    public function enviar_recordatorios_vencimiento()
{
    $db = \Config\Database::connect();
    $today = date('Y-m-d');
    $sevenDays = date('Y-m-d', strtotime('+7 days'));
    $email = \Config\Services::email();

    // Buscar todos los clientes con contratos activos
    $clientes = $db->table('customers')
        ->select('customers.id, customers.name, customers.email')
        ->join('contracts', 'contracts.customer_id = customers.id')
        ->where('contracts.status', 'active')
        ->groupBy('customers.id')
        ->get()->getResultArray();

    $resultados = [];

    foreach ($clientes as $cliente) {
        $enviados = 0;
        $detalle = [];

        // Cuotas próximas a vencer (pending, vencen en <= 7 días)
        $cuotas_proximas = $db->table('payment_schedules')
            ->select('payment_schedules.*, contracts.customer_id')
            ->join('contracts', 'contracts.id = payment_schedules.contract_id')
            ->where('payment_schedules.status', 'pending')
            ->where('payment_schedules.due_date <=', $sevenDays)
            ->where('payment_schedules.due_date >=', $today)
            ->where('contracts.customer_id', $cliente['id'])
            ->get()->getResultArray();

        // Cuotas vencidas (overdue, sin importar fecha)
        $cuotas_vencidas = $db->table('payment_schedules')
            ->select('payment_schedules.*, contracts.customer_id')
            ->join('contracts', 'contracts.id = payment_schedules.contract_id')
            ->where('payment_schedules.status', 'overdue')
            ->where('contracts.customer_id', $cliente['id'])
            ->get()->getResultArray();

        foreach ($cuotas_proximas as $cuota) {
            $detalle[] = "Próxima cuota: {$cuota['due_date']} - S/ {$cuota['amount']}";
            if (!empty($cliente['email'])) {
                $email->setTo($cliente['email']);
                $email->setSubject('Recordatorio de vencimiento de cuota');
                $email->setMessage("Estimado {$cliente['name']},\n\nLe recordamos que tiene una cuota próxima a vencer el {$cuota['due_date']} por S/ {$cuota['amount']}.\n\nPor favor, realice el pago oportunamente para evitar intereses o penalidades.\n\nGracias.");
                if ($email->send()) {
                    $enviados++;
                }
            }
        }
        foreach ($cuotas_vencidas as $cuota) {
            $detalle[] = "Cuota vencida: {$cuota['due_date']} - S/ {$cuota['amount']}";
            if (!empty($cliente['email'])) {
                $email->clear(); // Limpiar destinatario y asunto previos
                $email->setTo($cliente['email']);
                $email->setSubject('Recordatorio de cuota vencida');
                $email->setMessage("Estimado {$cliente['name']},\n\nTiene una cuota vencida el {$cuota['due_date']} por S/ {$cuota['amount']}.\nPor favor regularice su pago para evitar penalidades.\n\nGracias.");
                if ($email->send()) {
                    $enviados++;
                }
            }
        }

        if (!empty($detalle)) {
            $resultados[] = "Cliente {$cliente['name']} (ID {$cliente['id']}): " . implode(' | ', $detalle) . " - Recordatorios enviados: $enviados.";
        } else {
            $resultados[] = "Cliente {$cliente['name']} (ID {$cliente['id']}): No hay cuotas próximas a vencer ni vencidas.";
        }
    }

    return $this->response->setJSON([
        'success' => true,
        'resultados' => $resultados
    ]);
}
    
    public function create_contract()
    {
    log_message('debug', 'Método recibido en create_contract: ' . $this->request->getMethod());
    $log_prefix = '[create_contract] ';
    if (strtolower($this->request->getMethod()) === 'post') {
        log_message('debug', $log_prefix . 'POST data: ' . json_encode($this->request->getPost()));
            // Generate contract number
            // Generar número de contrato único usando el último ID
            $last_contract = $this->contractModel->select('id')->orderBy('id', 'DESC')->first();
            $next_id = $last_contract ? ($last_contract['id'] + 1) : 1;
            $contractNumber = 'GV-' . date('Y') . '-' . str_pad($next_id, 3, '0', STR_PAD_LEFT);

            $customerId = $this->request->getPost('customer_id');
            $lotId = $this->request->getPost('lot_id');
            $paymentPlanId = $this->request->getPost('payment_plan_id');
            $downPayment = $this->request->getPost('down_payment');
            $financingMonths = $this->request->getPost('financing_months');
            $interestRate = $this->request->getPost('interest_rate');
            $contractDate = $this->request->getPost('contract_date');
            $reservationAmount = $this->request->getPost('reservation_amount');
            $reservationDate = $this->request->getPost('reservation_date');
            $isReserved = $this->request->getPost('is_reserved');
            $contractType = $this->request->getPost('contract_type');

            // Validar plan de pago solo si NO es venta futura
            if ($contractType !== 'futura') {
                $paymentPlan = $this->paymentPlanModel->find($paymentPlanId);
                log_message('debug', $log_prefix . 'paymentPlan: ' . json_encode($paymentPlan));
                if (!$paymentPlan) {
                    log_message('error', $log_prefix . 'El plan de pagos seleccionado no existe. paymentPlanId=' . $paymentPlanId);
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'El plan de pagos seleccionado no existe. Por favor, crea o selecciona un plan válido.'
                    ]);
                }
            } else {
                // Para venta futura, no hay plan de pago ni financiamiento
                $paymentPlanId = null;
                $lot = $this->lotModel->find($lotId);
                log_message('debug', $log_prefix . 'Venta futura, lot: ' . json_encode($lot));
                $downPayment = $lot['current_price'];
                $financingMonths = 0;
                $interestRate = 0;
            }

            // Get lot information
            $lot = $this->lotModel->find($lotId);
            log_message('debug', $log_prefix . 'lot: ' . json_encode($lot));
            if (!$lot || $lot['status'] !== 'available') {
                log_message('error', $log_prefix . 'El lote no está disponible. lotId=' . $lotId . ' lot=' . json_encode($lot));
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'El lote no está disponible'
                ]);
            }

            // Determinar department_id de forma segura: preferir valor enviado por POST,
            // luego el del plan de pagos, y como último recurso obtenerlo desde el proyecto del lote.
            $departmentId = $this->request->getPost('department_id') ?? ($paymentPlan['department_id'] ?? null);
            log_message('debug', $log_prefix . 'departmentId: ' . json_encode($departmentId));
            if (empty($departmentId) && !empty($lot['project_id'])) {
                $project = $this->projectModel->find($lot['project_id']);
                log_message('debug', $log_prefix . 'project: ' . json_encode($project));
                $departmentId = $project['department_id'] ?? null;
            }

            // Si department_id quedó sin determinar, no logueamos (project ya contiene la info por diseño)


            // Calcular valores del contrato
            $totalAmount = $lot['current_price'];
            // Si hay reserva, la cuota inicial incluye el monto de reserva
            if (!empty($isReserved) && $isReserved == 1 && !empty($reservationAmount)) {
                $downPayment = $downPayment + $reservationAmount;
            }
            // Obtener reglas de cuota inicial desde el proyecto (no solo el plan)
            $project = $this->projectModel->find($lot['project_id']);
            // SIEMPRE usar monto fijo como inicial mínima
            $minDownPaymentFixed = $project['min_down_payment_fixed'] ?? 0;
            $minDownPayment = round($minDownPaymentFixed, 2);
            if (!\App\Helpers\DownPaymentHelper::isValidDownPayment($downPayment, $minDownPayment)) {
                log_message('error', $log_prefix . 'Cuota inicial menor al mínimo (proyecto, monto fijo). downPayment=' . $downPayment . ', minDownPayment=' . $minDownPayment);
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'La cuota inicial es menor al mínimo permitido por el proyecto (monto fijo): S/ ' . number_format($minDownPayment, 2)
                ]);
            }
            $financedAmount = $totalAmount - $downPayment;
            $monthlyRate = $interestRate / 100 / 12;
            if ($contractType === 'futura') {
                $monthlyPayment = 0;
            } else {
                $monthlyPayment = ($financedAmount > 0 && $monthlyRate > 0 && $financingMonths > 0)
                    ? $financedAmount * ($monthlyRate * pow(1 + $monthlyRate, $financingMonths)) / (pow(1 + $monthlyRate, $financingMonths) - 1)
                    : 0;
            }
            log_message('debug', $log_prefix . 'Valores calculados: totalAmount=' . $totalAmount . ', downPayment=' . $downPayment . ', financedAmount=' . $financedAmount . ', monthlyRate=' . $monthlyRate . ', monthlyPayment=' . $monthlyPayment);

            // Calcular fechas
            $startDate = date('Y-m-d', strtotime($contractDate . ' +1 month'));
            $endDate = date('Y-m-d', strtotime($startDate . ' +' . $financingMonths . ' months'));
            log_message('debug', $log_prefix . 'Fechas: startDate=' . $startDate . ', endDate=' . $endDate);

            // Guardar comprobante de voucher si se subió
            $voucher_url = null;
            $contract_file = null;
            $comprobante = $this->request->getFile('comprobante');
            if ($comprobante && $comprobante->isValid() && !$comprobante->hasMoved()) {
                $comprobante_name = $comprobante->getRandomName();
                $voucher_url = 'uploads/comprobantes/' . $comprobante_name;
                $contract_file = $voucher_url;
                $writablePath = ROOTPATH . 'writable/uploads/comprobantes/' . $comprobante_name;
                $publicPath = ROOTPATH . 'public/upload/comprobantes/' . $comprobante_name;
                $comprobante->move(ROOTPATH . 'writable/uploads/comprobantes', $comprobante_name);
                // Copia el archivo a la carpeta pública
                if (file_exists($writablePath)) {
                    @copy($writablePath, $publicPath);
                }
            }
            // Crear contrato
            $contractData = [
                'lot_id' => $lotId,
                'customer_id' => $customerId,
                'sponsor_id' => $this->request->getPost('sponsor_id'),
                'payment_plan_id' => $paymentPlanId,
                'contract_number' => $contractNumber,
                'total_amount' => $totalAmount,
                'down_payment' => $downPayment,
                'financed_amount' => $financedAmount,
                'monthly_payment' => round($monthlyPayment, 2),
                'interest_rate' => $interestRate,
                'contract_date' => $contractDate,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'financing_months' => $financingMonths,
                'status' => 'active',
                'reservation_amount' => $reservationAmount,
                'reservation_date' => $reservationDate,
                'is_reserved' => $isReserved,
                'contract_type' => $contractType,
                'voucher_url' => $voucher_url,
                'contract_file' => $contract_file
            ];
            
            // Validar reglas del plan solo si NO es venta futura
            if ($contractType !== 'futura') {
                $planRuleCheck = $this->validate_payment_plan_rules([
                    'department_id' => $departmentId,
                    'duration_months' => $financingMonths,
                    'base_interest_rate' => $interestRate
                ]);
                log_message('debug', $log_prefix . 'planRuleCheck: ' . json_encode($planRuleCheck));
                if (isset($planRuleCheck['valid']) && $planRuleCheck['valid'] === false) {
                    log_message('error', $log_prefix . 'Regla de plan de pago no válida: ' . $planRuleCheck['message']);
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => $planRuleCheck['message']
                    ]);
                }
            }
            // Validar cuota inicial mínima por ubicación (Cusco = dept_id 8)
            $minInitial = (intval($departmentId) === 8) ? 10000 : 5000;
            if (($downPayment ?? 0) < $minInitial) {
                log_message('error', $log_prefix . 'Cuota inicial menor al mínimo. downPayment=' . $downPayment . ', minInitial=' . $minInitial);
                return $this->response->setJSON([
                    'success' => false,
                    'message' => "La cuota inicial mínima para este plan/ubicación es S/{$minInitial}."
                ]);
            }

            $db = \Config\Database::connect();
            $db->transStart();
            log_message('debug', $log_prefix . 'Iniciando transacción para crear contrato');
            try {
                // Insert contract
                $contractId = $this->contractModel->insert($contractData);
                log_message('debug', $log_prefix . 'Contrato insertado. contractId=' . $contractId . ' contractData=' . json_encode($contractData));

                // Update lot status and customer
                if (!empty($isReserved) && $isReserved == 1 && !empty($reservationAmount)) {
                    $this->lotModel->update($lotId, [
                        'status' => 'reserved',
                        'customer_id' => $customerId,
                        'sale_date' => null
                    ]);
                    log_message('debug', $log_prefix . 'Lote actualizado a reservado. lotId=' . $lotId);
                } else {
                    $this->lotModel->update($lotId, [
                        'status' => 'sold',
                        'customer_id' => $customerId,
                        'sale_date' => date('Y-m-d H:i:s')
                    ]);
                    log_message('debug', $log_prefix . 'Lote actualizado a vendido. lotId=' . $lotId);
                }

                // Solo generar cronograma si no es venta futura
                if ($contractType !== 'futura') {
                    $this->generatePaymentSchedule($contractId, $lotId, $paymentPlanId, $startDate, $financingMonths, $monthlyPayment, $financedAmount, $monthlyRate, $downPayment, $contractDate, $voucher_url);
                    log_message('debug', $log_prefix . 'Cronograma de pagos generado. contractId=' . $contractId);
                }

                // --- Insertar comisión en tiempo real al crear contrato ---
                $comisionesInmobiliariasModel = new \App\Models\ComisionesInmobiliariasModel();
                $fecha = date('Y-m-d H:i:s');
                
                // Usar sponsor_id enviado por POST, si existe, si no usar el de sesión
                $patrocinadorId = $this->request->getPost('sponsor_id') ?? ($_SESSION['id'] ?? null);
                
                // Calcular comisión según el tipo de contrato
                if (!empty($isReserved) && $isReserved == 1) {
                    // Para RESERVA: comisión fija de S/ 300
                    $monto_comision = 300;
                    $tipo_comision = 'bono_reserva';
                    $porcentaje_comision = null;
                } else {
                    // Para CONTADO/INICIAL: 5% del total
                    $monto_comision = $totalAmount * 0.05;
                    $tipo_comision = 'venta_base';
                    $porcentaje_comision = 5;
                }
                
                $comision_data = [
                    'venta_id' => $contractId,
                    'beneficiario_id' => $patrocinadorId,
                    'tipo_comision' => $tipo_comision,
                    'monto' => $monto_comision,
                    'porcentaje' => $porcentaje_comision,
                    'estado' => 'pendiente',
                    'fecha_generada' => $fecha,
                    'created_at' => $fecha,
                    'updated_at' => $fecha
                ];
                $com_insert_result = $comisionesInmobiliariasModel->insert($comision_data);
                log_message('debug', $log_prefix . 'Comisión insertada. com_insert_result=' . json_encode($com_insert_result) . ' comision_data=' . json_encode($comision_data));

                // --- Log personalizado en archivo ---
                $customLog = [
                    'datetime' => date('Y-m-d H:i:s'),
                    'contract_id' => $contractId,
                    'contract_data' => $contractData,
                    'comision_data' => $comision_data,
                    'com_insert_result' => $com_insert_result
                ];
                $logFile = WRITEPATH . 'logs/contract_debug_' . date('Ymd_His') . '.log';
                file_put_contents($logFile, json_encode($customLog, JSON_PRETTY_PRINT));
                // --- Fin log personalizado ---

                // --- Fin comisión en tiempo real ---

                $db->transComplete();
                log_message('debug', $log_prefix . 'Transacción completada. transStatus=' . json_encode($db->transStatus()));

                if ($db->transStatus() === FALSE) {
                    log_message('error', $log_prefix . 'Error al crear el contrato. transStatus=FALSE');
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Error al crear el contrato'
                    ]);
                }

                // --- Enviar email de confirmación ---
                try {
                    // Obtener datos del cliente
                    $customer = model('CustomerModel')->find($customerId);
                    if ($customer) {
                        $customerEmail = $customer['email'] ?? null;
                        $customerName = $customer['nombre_completo'] ?? $customer['primer_nombre'] ?? 'Cliente';
                        $customerDni = $customer['dni'] ?? '';
                        
                        // Obtener información del lote
                        $lotData = $this->lotModel->find($lotId);
                        $loteName = $lotData['nombre'] ?? 'Lote N/A';
                        $manzana = $lotData['manzana'] ?? 'N/A';
                        $totalPrice = $lotData['current_price'] ?? 0;
                        
                        // Determinar tipo de acción basado en contract_type
                        $accion = 'arras'; // default
                        if ($contractType === 'futura') {
                            $accion = 'futura';
                        }
                        
                        if ($customerEmail) {
                            $emailService = \Config\Services::email();
                            $emailService->setFrom('jtarrillochuquiruna@gmail.com', 'Grupo Vivencia');
                            $emailService->setTo($customerEmail);
                            $emailService->setBCC('jtarrillochuquiruna@gmail.com');
                            $emailService->setSubject('Confirmación de Contrato - Grupo Vivencia');
                            
                            // Generar HTML del email con template profesional
                            $emailBody = view('emails/contract_confirmation', [
                                'nombre' => $customerName,
                                'contract_number' => $contractNumber,
                                'lote_nombre' => $loteName,
                                'manzana' => $manzana,
                                'precio' => $totalPrice,
                                'accion' => $accion,
                                'dni' => $customerDni,
                                'email' => $customerEmail
                            ]);
                            
                            $emailService->setMessage($emailBody);
                            $emailService->send();
                            log_message('debug', $log_prefix . 'Email de confirmación enviado a: ' . $customerEmail);
                        }
                    }
                } catch (\Exception $e) {
                    log_message('error', $log_prefix . 'Error al enviar email de confirmación: ' . $e->getMessage());
                    // El email no es crítico, continuamos aunque falle
                }
                // --- Fin envío de email ---

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Contrato creado exitosamente',
                    'contract_id' => $contractId,
                    'contract_number' => $contractNumber
                ]);

            } catch (\Exception $e) {
                $db->transRollback();
                log_message('error', $log_prefix . 'Excepción: ' . $e->getMessage());
                // Log de excepción en archivo
                $customLog = [
                    'datetime' => date('Y-m-d H:i:s'),
                    'exception' => $e->getMessage(),
                    'contract_data' => $contractData ?? null
                ];
                $logFile = WRITEPATH . 'logs/contract_debug_' . date('Ymd_His') . '_error.log';
                file_put_contents($logFile, json_encode($customLog, JSON_PRETTY_PRINT));
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ]);
            }
        }
        
        log_message('error', $log_prefix . 'Método no permitido: ' . $this->request->getMethod());
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Método no permitido'
        ]);
    }
    
    private function generatePaymentSchedule($contractId, $lotId, $paymentPlanId, $startDate, $months, $monthlyPayment, $financedAmount, $monthlyRate, $downPayment = 0, $contractDate = null, $voucherUrl = null)
    {
        // Usar el método centralizado del Model
        $scheduleModel = new \App\Models\PaymentScheduleModel();
        return $scheduleModel->generatePaymentSchedule(
            $contractId, 
            $lotId, 
            $paymentPlanId, 
            $startDate, 
            $months, 
            $monthlyPayment, 
            $financedAmount, 
            $monthlyRate,
            $downPayment,
            $contractDate,
            $voucherUrl
        );
    }

    public function get_projects_api()
    {
        $projects = $this->projectModel
            ->where('status !=', 'suspended')
            ->findAll();
        
        return $this->response->setJSON(['projects' => $projects]);
    }

    public function get_payment_plan_api($plan_id)
    {
        $plan = $this->paymentPlanModel->find($plan_id);
        
        if ($plan) {
            return $this->response->setJSON([
                'success' => true,
                'plan' => $plan
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Plan de pago no encontrado'
            ]);
        }
    }

    public function update_payment_plan($plan_id)
    {
        if (strtolower($this->request->getMethod()) === 'post') {
            $plan = $this->paymentPlanModel->find($plan_id);
            if (!$plan) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Plan de pago no encontrado',
                    'debug' => [ 'plan_id' => $plan_id ]
                ]);
            }
            $res = $this->request->getPost();
            // Si el cuerpo es JSON, decodificarlo
            if (empty($res) && $this->request->getHeaderLine('Content-Type') === 'application/json') {
                $json = $this->request->getJSON(true);
                if (is_array($json)) {
                    $res = $json;
                }
            }
            $data = [
                'name' => $res['name'] ?? '',
                'code' => $res['code'] ?? '',
                'department_id' => $res['department_id'] ?? null,
                'province_id' => $res['province_id'] ?? null,
                'district_id' => $res['district_id'] ?? null,
                'duration_months' => $res['duration_months'] ?? '',
                'min_down_payment_percentage' => $res['min_down_payment_percentage'] ?? '',
                'base_interest_rate' => $res['base_interest_rate'] ?? '',
                'is_default' => !empty($res['is_default']) ? 1 : 0,
                'active' => !empty($res['active']) ? 1 : 0
            ];
            // Si es plan por defecto, desactivar otros planes por defecto de la misma ubicación
            if ($data['is_default']) {
                $this->paymentPlanModel
                    ->where('department_id', $data['department_id'])
                    ->where('province_id', $data['province_id'])
                    ->where('district_id', $data['district_id'])
                    ->where('id !=', $plan_id)
                    ->set(['is_default' => 0])
                    ->update();
            }
            if ($this->paymentPlanModel->update($plan_id, $data)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Plan de pago actualizado exitosamente'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error al actualizar el plan de pago',
                    'debug' => $res
                ]);
            }
        }
        // Si no es POST, responder JSON si es AJAX
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Método no permitido',
                'debug' => [
                    'method' => $this->request->getMethod(),
                    'is_ajax' => $this->request->isAJAX(),
                    'headers' => $this->request->getServer(),
                    'post_data' => $this->request->getPost(),
                ]
            ]);
        }
        // Si no es AJAX, redirigir
        return redirect()->to('/dashboard/inmueble/payment_plans/payment_plans');
    }

    public function get_plan_contract_stats($plan_id)
    {
        $contracts = $this->contractModel
            ->select('COUNT(*) as total_contracts, SUM(total_amount) as total_amount, SUM(monthly_payment) as monthly_revenue')
            ->where('payment_plan_id', $plan_id)
            ->where('status', 'active')
            ->first();
        
        return $this->response->setJSON([
            'success' => true,
            'stats' => [
                'total_contracts' => $contracts['total_contracts'] ?? 0,
                'total_amount' => $contracts['total_amount'] ?? 0,
                'monthly_revenue' => $contracts['monthly_revenue'] ?? 0
            ]
        ]);
    }





    // Método específico para actualizar precios dinámicos según tus reglas de negocio
    public function update_dynamic_prices()
    {
        // Implementa exactamente lo que describes: "afectando solo a tierras ventas"
        $db = 
            \Config\Database::connect();
        $builder = $db->table('lots');
        $builder->select('lots.*, projects.base_interest_rate, price_settings.monthly_increase_percentage AS ps_monthly_increase');
        $builder->join('projects', 'projects.id = lots.project_id', 'left');
        $builder->join('price_settings', 'price_settings.project_id = projects.id', 'left');
        $builder->where('lots.status', 'available'); // Solo tierras no vendidas
        $lots = $builder->get()->getResultArray();

        foreach ($lots as $lot) {
            $monthsElapsed = $this->calculateMonthsElapsed($lot['price_last_updated'] ?? $lot['created_at'] ?? null);
            $increaseRate = $lot['monthly_increase_percentage'] ?? $lot['ps_monthly_increase'] ?? 2.00; // Default 2%

            if ($monthsElapsed > 0) {
                $newPrice = $lot['current_price'] * pow(1 + ($increaseRate / 100), $monthsElapsed);

                // Guardar historial (si la tabla existe)
                try {
                    $db->table('price_history')->insert([
                        'lot_id' => $lot['id'],
                        'old_price' => $lot['current_price'],
                        'new_price' => round($newPrice, 2),
                        'months_elapsed' => $monthsElapsed,
                        'applied_at' => date('Y-m-d H:i:s')
                    ]);
                } catch (\Exception $e) {
                    // Evitar fallo si la tabla no existe; registrar en logs
                    log_message('error', 'price_history insert failed: ' . $e->getMessage());
                }

                $this->lotModel->update($lot['id'], [
                    'current_price' => round($newPrice, 2),
                    'price_last_updated' => date('Y-m-d H:i:s')
                ]);
            }
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Precios actualizados según reglas de negocio'
        ]);
    }

    // Helper: calcula meses completos transcurridos desde una fecha dada
    private function calculateMonthsElapsed($datetime)
    {
        if (empty($datetime)) return 0;
        try {
            $last = new \DateTime($datetime);
            $now = new \DateTime();
            $diff = $now->diff($last);
            return ($diff->y * 12) + $diff->m;
        } catch (\Exception $e) {
            return 0;
        }
    }

    // Validación específica para planes de pago según ubicación
    public function validate_payment_plan_rules($planData)
    {
        $rules = [
            'Cusco' => [
                'duration_months' => 24,
                'min_down_payment' => 10000, // S/10,000 para Cusco
            ],
            'General' => [
                'duration_months' => 36,
                'min_down_payment' => 5000, // S/5,000 general
                'max_interest_rate' => 6.0
            ]
        ];
        
        // Usar department_id (ID 8 = Cusco) para la validación
        if (
            isset($planData['department_id']) && intval($planData['department_id']) === 8
        ) {
            $locationRules = $rules['Cusco'];
        } else {
            $locationRules = $rules['General'];
        }
        
        // Validar que cumple con tus especificaciones exactas
        if ($planData['duration_months'] != $locationRules['duration_months']) {
            return [
                'valid' => false,
                'message' => "La duración debe ser {$locationRules['duration_months']} meses"
            ];
        }
        
        if ($planData['base_interest_rate'] < 2.0 || $planData['base_interest_rate'] > 6.0) {
            // Permitir 0% solo para Cusco (ID 8)
            if (isset($planData['department_id']) && intval($planData['department_id']) === 8) {
                if ($planData['base_interest_rate'] < 0.0 || $planData['base_interest_rate'] > 6.0) {
                    return [
                        'valid' => false,
                        'message' => 'La tasa de interés para Cusco debe estar entre 0% y 6%'
                    ];
                }
            } else {
                return [
                    'valid' => false,
                    'message' => 'La tasa de interés debe estar entre 2% y 6%'
                ];
            }
        }
        
        return ['valid' => true];
    }

    // Cálculo exacto según tu fórmula: Precio Lote - Inicial + Intereses
    public function calculate_payment_schedule_exact($contractData)
    {
        $lotPrice = $contractData['total_amount'];
        $downPayment = $contractData['down_payment'];
        $financedAmount = $lotPrice - $downPayment; // Precio Lote - Inicial
        $annualRate = $contractData['interest_rate'] / 100;
        $monthlyRate = $annualRate / 12;
        $months = $contractData['financing_months'];
        
        // Fórmula exacta de amortización francesa
        $monthlyPayment = $financedAmount * 
            ($monthlyRate * pow(1 + $monthlyRate, $months)) / 
            (pow(1 + $monthlyRate, $months) - 1);
        
        $schedule = [];
        $balance = $financedAmount;
        
        for ($i = 1; $i <= $months; $i++) {
            $interestPayment = $balance * $monthlyRate; // + Intereses
            $principalPayment = $monthlyPayment - $interestPayment;
            $balance -= $principalPayment;
            
            $schedule[] = [
                'installment_number' => $i,
                'due_date' => date('Y-m-d', strtotime($contractData['start_date'] . " +". ($i-1) ." months")),
                'amount' => round($monthlyPayment, 2),
                'capital' => round($principalPayment, 2),
                'interest' => round($interestPayment, 2),
                'balance' => round(max(0, $balance), 2),
                'status' => 'pending'
            ];
        }
        
        return $schedule;
    }
    // Eliminar plan de pago (AJAX robusto)
    public function delete_payment_plan($plan_id)
    {
        // Validar método DELETE
        if (strtolower($this->request->getMethod()) !== 'delete') {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Método no permitido',
                    'debug' => [
                        'method' => $this->request->getMethod(),
                        'is_ajax' => $this->request->isAJAX(),
                        'headers' => $this->request->getServer(),
                        'plan_id' => $plan_id
                    ]
                ]);
            }
            return redirect()->to('/dashboard/inmueble/payment_plans/payment_plans');
        }

        $plan = $this->paymentPlanModel->find($plan_id);
        if (!$plan) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Plan de pago no encontrado',
                'debug' => [ 'plan_id' => $plan_id ]
            ]);
        }
        // Validar que no tenga contratos activos asociados
        $contractsCount = $this->contractModel->where('payment_plan_id', $plan_id)->where('status', 'active')->countAllResults();
        if ($contractsCount > 0) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'No se puede eliminar el plan porque tiene contratos activos asociados',
                'debug' => [ 'contractsCount' => $contractsCount ]
            ]);
        }
        $result = $this->paymentPlanModel->delete($plan_id);
        if ($result) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Plan de pago eliminado exitosamente'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error al eliminar el plan de pago'
            ]);
        }
    }
}