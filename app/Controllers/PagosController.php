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

        // Obtener pagos ordenados (DESC - más recientes primero)
        $payments = $paymentScheduleModel->where('contract_id', $contractId)
            ->orderBy('due_date', 'DESC')
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

            // Procesar comprobante si existe
            $comprobanteUrl = null;
            if ($comprobante && $comprobante->isValid() && !$comprobante->hasMoved()) {
                // Crear directorio si no existe
                $uploadPath = ROOTPATH . 'writable/uploads/comprobantes';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                $newName = $comprobante->getRandomName();
                $comprobante->move($uploadPath, $newName);
                $comprobanteUrl = 'uploads/comprobantes/' . $newName;
            }

            // Validación: Si el cliente no subió comprobante, el admin DEBE subir uno
            if (empty($pago['comprobante_url']) && !$comprobanteUrl) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Debe proporcionar un comprobante para validar el pago'
                ]);
            }

            // Actualizar estado a 'paid' (validado)
            $updateData = [
                'status' => 'paid',
                'paid_date' => date('Y-m-d H:i:s'),
                'validado_notas' => $notas,
                'validated_at' => date('Y-m-d H:i:s')
            ];

            // Agregar comprobante si el admin lo subió
            if ($comprobanteUrl) {
                $updateData['comprobante_url'] = $comprobanteUrl;
            }

            // Usar Query Builder directo con SQL
            $db = \Config\Database::connect();
            
            $setClause = [];
            $params = [];
            
            foreach ($updateData as $key => $value) {
                $setClause[] = "`$key` = ?";
                $params[] = $value;
            }
            
            $params[] = $idPago;
            
            $query = "UPDATE `payment_schedules` SET " . implode(', ', $setClause) . " WHERE `id` = ?";
            $update = $db->query($query, $params);
            
            if ($db->affectedRows() > 0) {
                // Validar que se guardó correctamente
                $scheduleModel = new \App\Models\PaymentScheduleModel();
                $registroActualizado = $scheduleModel->find($idPago);
                
                // Verificar que tiene comprobante
                if (empty($registroActualizado['comprobante_url'])) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Error: El comprobante no se guardó correctamente'
                    ]);
                }
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Pago validado correctamente'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'No se pudo validar el pago'
                ]);
            }
        } catch (\Throwable $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error interno: ' . $e->getMessage()
            ]);
        }
    }
}