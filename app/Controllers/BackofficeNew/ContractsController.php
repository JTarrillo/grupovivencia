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

        $contract = $contractModel->find($id);
        $cronograma = $paymentScheduleModel->where('contract_id', $id)->findAll();
        
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
        $request = service('request');
        $id_cuota = $request->getPost('id_cuota');
        $comprobante = $request->getFile('comprobante');
        
        $paymentScheduleModel = new PaymentScheduleModel();
        $cuota = $paymentScheduleModel->find($id_cuota);
        
        if (!$cuota) {
            return $this->response->setJSON(['success' => false, 'message' => 'Cuota no encontrada']);
        }
        
        $updateData = [
            'status' => 'registered',
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        // Guardar comprobante si se subió
        if ($comprobante && $comprobante->isValid() && !$comprobante->hasMoved()) {
            $comprobante_name = $comprobante->getRandomName();
            // Guardar en writable/uploads/comprobantes (misma ubicación que cuota inicial)
            $uploadPath = ROOTPATH . 'writable/uploads/comprobantes';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $comprobante->move($uploadPath, $comprobante_name);
            $updateData['voucher_url'] = 'uploads/comprobantes/' . $comprobante_name;
        }
        
        $paymentScheduleModel->update($id_cuota, $updateData);
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Pago registrado. Será validado por el administrador.'
        ]);
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
