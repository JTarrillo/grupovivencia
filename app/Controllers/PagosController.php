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
}