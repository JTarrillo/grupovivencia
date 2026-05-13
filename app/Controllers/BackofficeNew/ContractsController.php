<?php
namespace App\Controllers\BackofficeNew;

use App\Controllers\BaseController;
use App\Models\ContractModel;
use App\Models\PaymentScheduleModel;
use App\Models\LotModel;
use App\Models\ProjectModel;

class ContractsController extends BaseController
{
    /**
     * Lista todos los contratos del cliente logueado
     */
    public function index()
    {
        $contractModel = new ContractModel();
        $lotModel = new LotModel();
        $projectModel = new ProjectModel();
        
        $customer_id = session()->get('id');
        
        // Obtener contratos del cliente
        $contractsRaw = $contractModel->where('customer_id', $customer_id)->findAll();
        
        $contracts = [];
        foreach ($contractsRaw as $c) {
            $lot = $lotModel->find($c['lot_id']);
            $project = $lot ? $projectModel->find($lot['project_id']) : null;
            
            $contracts[] = [
                'id' => $c['id'],
                'code' => $c['contract_number'] ?? 'GV-' . $c['id'],
                'type' => $c['contract_type'] ?? 'arras',
                'project_name' => $project['name'] ?? 'Proyecto',
                'lot_code' => $lot['lot_number'] ?? '',
                'lot_area' => ($lot['area_sqm'] ?? 0) . ' m²',
                'amount' => $c['total_amount'] ?? 0,
                'initial' => $c['down_payment'] ?? 0,  // ✅ Usar down_payment
                'monthly' => $c['monthly_payment'] ?? 0,
                'installments' => ($c['financing_months'] ?? 12) . ' cuotas',
                'status' => $c['status'] ?? 'activo',
                'signed_date' => $c['contract_date'] ?? '',
                'start_date' => $c['start_date'] ?? $c['contract_date'] ?? '',
                'created_at' => $c['created_at'] ?? '',
                'progress' => $this->calculateProgress($c['id']),
                'contract_type' => $c['contract_type'] ?? 'arras',
                'reservation_amount' => $c['reservation_amount'] ?? 0
            ];
        }
        
        return view('backoffice_new/contracts', ['contracts' => $contracts]);
    }
    
    /**
     * Calcula el progreso de pagos de un contrato
     */
    private function calculateProgress($contractId)
    {
        $paymentScheduleModel = new PaymentScheduleModel();
        $total = $paymentScheduleModel->where('contract_id', $contractId)->countAllResults(false);
        $paid = $paymentScheduleModel->where('contract_id', $contractId)
                                     ->whereIn('status', ['paid', 'pagado'])
                                     ->countAllResults();
        
        return $total > 0 ? round(($paid / $total) * 100) : 0;
    }
    
    /**
     * Muestra el detalle de un contrato
     */
    public function detail($id)
    {
        $contractModel = new ContractModel();
        $lotModel = new LotModel();
        $projectModel = new ProjectModel();
        
        $c = $contractModel->find($id);
        if (!$c) {
            return redirect()->to('/backoffice_new/contracts')->with('error', 'Contrato no encontrado');
        }
        
        $lot = $lotModel->find($c['lot_id']);
        $project = $lot ? $projectModel->find($lot['project_id']) : null;
        
        $contract = [
            'id' => $c['id'],
            'code' => $c['contract_number'] ?? 'GV-' . $c['id'],
            'type' => $c['contract_type'] ?? 'arras',
            'project_name' => $project['name'] ?? 'Proyecto',
            'lot_code' => $lot['lot_number'] ?? '',
            'lot_area' => ($lot['area_sqm'] ?? 0) . ' m²',
            'amount' => $c['total_amount'] ?? 0,
            'initial' => $c['down_payment'] ?? 0,  // ✅ Usar down_payment
            'financed' => $c['financed_amount'] ?? 0,
            'monthly' => $c['monthly_payment'] ?? 0,
            'installments' => ($c['financing_months'] ?? 12) . ' cuotas',
            'financing_months' => $c['financing_months'] ?? 12,
            'status' => $c['status'] ?? 'activo',
            'signed_date' => $c['contract_date'] ?? '',
            'start_date' => $c['start_date'] ?? $c['contract_date'] ?? '',
            'end_date' => $c['end_date'] ?? '',
            'progress' => $this->calculateProgress($c['id']),
            'contract_type' => $c['contract_type'] ?? 'arras',
            'reservation_amount' => $c['reservation_amount'] ?? 0,
            'voucher_url' => $c['voucher_url'] ?? ''
        ];
        
        return view('backoffice_new/contract_detail', ['contract' => $contract]);
    }

    public function cronograma($id)
    {
        $contractModel = new ContractModel();
        $paymentScheduleModel = new PaymentScheduleModel();
        $lotModel = new LotModel();
        $projectModel = new ProjectModel();

        $c = $contractModel->find($id);
        if (!$c) {
            return redirect()->to('/backoffice_new/contracts')->with('error', 'Contrato no encontrado');
        }

        $lot = $lotModel->find($c['lot_id']);
        $project = $lot ? $projectModel->find($lot['project_id']) : null;

        // Mapear los campos para que la vista los encuentre con los nombres esperados
        $contract = [
            'id' => $c['id'],
            'code' => $c['contract_number'] ?? 'GV-' . $c['id'],
            'total' => $c['total_amount'] ?? 0,
            'total_amount' => $c['total_amount'] ?? 0,
            'cuota_mensual' => $c['monthly_payment'] ?? 0,
            'monthly_payment' => $c['monthly_payment'] ?? 0,
            'down_payment' => $c['down_payment'] ?? 0,
            'status' => $c['status'] ?? 'activo',
            'start_date' => $c['start_date'] ?? '',
            'end_date' => $c['end_date'] ?? '',
            'project_name' => $project['name'] ?? 'Proyecto',
            'lot_code' => $lot['lot_number'] ?? '',
            'lot_area' => ($lot['area_m2'] ?? 0) . ' m²'
        ];

        $cronograma = $paymentScheduleModel->where('contract_id', $id)->findAll();
        
        // Obtener comprobantes para esta contrato
        $db = \Config\Database::connect();
        $comprobantes = $db->table('comprobantes_emitidos')
            ->where('contract_id', $id)
            ->get()
            ->getResultArray();
        
        // Ordenar cronograma de forma ASCENDENTE (cuota 1, 2, 3... - fecha más cercana primero)
        usort($cronograma, function($a, $b) {
            return strtotime($a['fecha_vencimiento'] ?? $a['due_date']) - strtotime($b['fecha_vencimiento'] ?? $b['due_date']);
        });

        // Calcular totales y progreso
        $pagos_realizados = 0;
        $pagos_pendientes = 0;
        $monto_realizado = 0;
        $monto_pendiente = 0;
        $total_pagos = count($cronograma);

        foreach ($cronograma as $pago) {
            if ($pago['status'] == 'Pagado') {
                $pagos_realizados++;
                $monto_realizado += $pago['amount'];
            } else {
                $pagos_pendientes++;
                $monto_pendiente += $pago['amount'];
            }
        }

        // --- LOG CRONOGRAMA ---
        $logData = [
            'contractId' => $id,
            'contract' => $contract,
            'cronograma' => $cronograma,
            'comprobantes' => $comprobantes,
            'pagos_realizados' => $pagos_realizados,
            'pagos_pendientes' => $pagos_pendientes,
            'monto_realizado' => $monto_realizado,
            'monto_pendiente' => $monto_pendiente,
            'total_pagos' => $total_pagos,
            'timestamp' => date('Y-m-d H:i:s')
        ];
        $logFile = WRITEPATH . 'logs/cronograma_backoffice_' . $id . '_' . date('Ymd_His') . '.log';
        file_put_contents($logFile, print_r($logData, true));

        return view('backoffice_new/cronograma', [
            'contract' => $contract,
            'cronograma' => $cronograma,
            'comprobantes' => $comprobantes,
            'pagos_realizados' => $pagos_realizados,
            'pagos_pendientes' => $pagos_pendientes,
            'monto_realizado' => $monto_realizado,
            'monto_pendiente' => $monto_pendiente,
            'total_pagos' => $total_pagos
        ]);
    }
    
    /**
     * Registra el pago de una cuota
     */
    public function registrarPagoCuota()
    {
        $timestamp = date('Y-m-d H:i:s');
        $logFile = WRITEPATH . 'logs/pago_cuota_' . date('YmdHis') . '_' . uniqid() . '.log';
        
        // Helper para escribir logs directamente
        $writeLog = function($message) use ($logFile) {
            file_put_contents($logFile, $message . "\n", FILE_APPEND);
        };
        
        $writeLog("=== INICIO REGISTRO PAGO CUOTA - $timestamp ===");
        $writeLog("PID: " . getmypid() . " | IP: " . $_SERVER['REMOTE_ADDR']);
        
        try {
            $request = service('request');
            $writeLog("[1] Request obtenido");
            
            $id_cuota = $request->getPost('id_cuota');
            $writeLog("[2] ID Cuota: $id_cuota");
            
            // Revisar todos los POST variables
            $postVars = $request->getPost();
            $writeLog("[3] POST vars: " . json_encode($postVars));
            
            // Revisar archivos
            $files = $request->getFiles();
            $writeLog("[4] FILES recibidos: " . json_encode(array_keys($files)));
            
            $comprobante = $request->getFile('comprobante');
            $writeLog("[5] Archivo 'comprobante': " . ($comprobante ? 'SÍ RECIBIDO' : 'NO RECIBIDO'));
            
            if ($comprobante) {
                $writeLog("[5.1] Nombre cliente: " . $comprobante->getClientName());
                $writeLog("[5.2] Mime Type: " . $comprobante->getClientMimeType());
                $writeLog("[5.3] Tamaño: " . ($comprobante->getSize() / 1024) . " KB");
                $writeLog("[5.4] Nombre temporal: " . $comprobante->getTempName());
                $writeLog("[5.5] Es válido: " . ($comprobante->isValid() ? 'SÍ' : 'NO'));
                $writeLog("[5.6] Ya fue movido: " . ($comprobante->hasMoved() ? 'SÍ' : 'NO'));
            }
            
            $paymentScheduleModel = new PaymentScheduleModel();
            $cuota = $paymentScheduleModel->find($id_cuota);
            $writeLog("[6] Cuota encontrada: " . ($cuota ? 'SÍ' : 'NO'));
            
            if (!$cuota) {
                $writeLog("[ERROR] Cuota no encontrada: ID=$id_cuota");
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Cuota no encontrada',
                    'error' => 'ID Cuota inválido'
                ]);
            }
            
            $writeLog("[7] Estado actual cuota: " . $cuota['status']);
            
            $updateData = [
                'status' => 'registered',
                'paid_date' => $timestamp,
                'updated_at' => $timestamp
            ];
            
            // Guardar comprobante si se subió
            $uploadPath = FCPATH . 'uploads/comprobantes';
            if ($comprobante && $comprobante->isValid() && !$comprobante->hasMoved()) {
                $writeLog("[8] Preparando para guardar archivo...");
                
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                    $writeLog("[8.1] Directorio creado: $uploadPath");
                } else {
                    $writeLog("[8.1] Directorio ya existe: $uploadPath");
                }
                
                $comprobante_name = $comprobante->getRandomName();
                $writeLog("[8.2] Nombre aleatorio generado: $comprobante_name");
                
                $fullPath = $uploadPath . DIRECTORY_SEPARATOR . $comprobante_name;
                $writeLog("[8.3] Ruta completa: $fullPath");
                
                $moveResult = $comprobante->move($uploadPath, $comprobante_name);
                $writeLog("[8.4] Resultado move(): " . ($moveResult ? 'EXITOSO' : 'FALLIDO'));
                
                if ($moveResult) {
                    $voucherUrl = 'uploads/comprobantes/' . $comprobante_name;
                    $updateData['voucher_url'] = $voucherUrl;
                    $writeLog("[8.5] URL guardada en BD: $voucherUrl");
                    
                    // Verificar que el archivo existe
                    $fileExists = file_exists($fullPath);
                    $fileSize = filesize($fullPath);
                    $writeLog("[8.6] Archivo en servidor: " . ($fileExists ? "SÍ ($fileSize bytes)" : "NO"));
                }
            } else {
                if (!$comprobante) {
                    $writeLog("[8] ADVERTENCIA: No se adjuntó comprobante");
                } else {
                    $writeLog("[8] ADVERTENCIA: Comprobante inválido o ya fue movido");
                }
            }
            
            $writeLog("[9] Actualizando base de datos...");
            $updateResult = $paymentScheduleModel->update($id_cuota, $updateData);
            $writeLog("[10] Resultado update BD: " . ($updateResult ? 'EXITOSO' : 'FALLIDO'));
            
            $writeLog("=== FIN EXITOSO - " . date('Y-m-d H:i:s') . " ===");
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Pago registrado. Será validado por el administrador.',
                'voucher_saved' => isset($voucherUrl),
                'log_file' => basename($logFile)
            ]);
            
        } catch (\Exception $e) {
            $writeLog("[ERROR EXCEPCIÓN] " . $e->getMessage());
            $writeLog("[ERROR STACK] " . $e->getTraceAsString());
            $writeLog("=== FIN ERROR - " . date('Y-m-d H:i:s') . " ===");
            
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error al registrar pago',
                'error' => $e->getMessage()
            ]);
        }
    }
    
    /**
     * Elimina un contrato
     */
    public function delete($id)
    {
        $contractModel = new ContractModel();
        $paymentScheduleModel = new PaymentScheduleModel();
        $lotModel = new LotModel();
        
        $contract = $contractModel->find($id);
        if (!$contract) {
            return redirect()->to('/backoffice_new/contracts')->with('error', 'Contrato no encontrado');
        }
        
        // Liberar el lote
        if (!empty($contract['lot_id'])) {
            $lotModel->update($contract['lot_id'], [
                'status' => 'available',
                'customer_id' => null,
                'sale_date' => null
            ]);
        }
        
        // Eliminar cronograma de pagos
        $paymentScheduleModel->where('contract_id', $id)->delete();
        
        // Eliminar contrato
        $contractModel->delete($id);
        
        return redirect()->to('/backoffice_new/contracts')->with('success', 'Contrato eliminado correctamente');
    }
}
