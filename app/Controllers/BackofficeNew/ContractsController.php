<?php
namespace App\Controllers\BackofficeNew;

use App\Controllers\BaseController;
use App\Models\ContractModel;
use App\Models\PaymentScheduleModel;

class ContractsController extends BaseController
{
    public function cronograma($id)
    {
        $contractModel = new ContractModel();
        $paymentScheduleModel = new PaymentScheduleModel();

        $contract = $contractModel->find($id);
        $cronograma = $paymentScheduleModel->where('contract_id', $id)->findAll();
        
        // Ordenar cronograma de forma descendente
        usort($cronograma, function($a, $b) {
            return strtotime($b['fecha_vencimiento'] ?? $b['due_date']) - strtotime($a['fecha_vencimiento'] ?? $a['due_date']);
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
}
