<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class B_contratos extends Controller
   
{
    public function detail($id)
    {
        $contractModel = model('ContractModel');
        $contract = $contractModel->find($id);
        if (!$contract) {
            return redirect()->to('/backoffice_new/contracts')->with('error', 'Contrato no encontrado');
        }

        // Puedes ajustar los nombres de los campos para que coincidan con la vista
        $contractData = [
            'id' => $contract['id'],
            'code' => $contract['contract_number'] ?? '',
            'type' => $contract['contract_type'] ?? '',
            'project_name' => $contract['project_name'] ?? '',
            'lot_code' => $contract['lot_id'] ?? '',
            'lot_area' => $contract['lot_area'] ?? '',
            'amount' => $contract['total_amount'] ?? 0,
            'initial' => $contract['down_payment'] ?? 0,
            'monthly' => $contract['monthly_payment'] ?? 0,
            'installments' => $contract['financing_months'] ?? '',
            'status' => $contract['status'] ?? '',
            'signed_date' => $contract['contract_date'] ?? '',
            'start_date' => $contract['start_date'] ?? '',
            'progress' => 0, // Puedes calcular el progreso si tienes pagos realizados
            'reservation_amount' => $contract['reservation_amount'] ?? 0,
            'contract_type' => $contract['contract_type'] ?? '',
        ];
        return view('backoffice_new/contract_detail', ['contract' => $contractData]);
    }

     public function create()
    {
        if (strtolower($this->request->getMethod()) === 'post') {
            $contractModel = model('ContractModel');
            $contractNumber = 'GV-' . date('Y') . '-' . str_pad($contractModel->countAll() + 1, 3, '0', STR_PAD_LEFT);
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
            $totalAmount = $this->request->getPost('total_amount');
            $startDate = date('Y-m-d', strtotime($contractDate . ' +1 month'));
            $endDate = date('Y-m-d', strtotime($startDate . ' +' . $financingMonths . ' months'));
            // Guardar comprobante de voucher si se subió
            $voucher_url = null;
            $contract_file = null;
            $comprobante = $this->request->getFile('comprobante');
            if ($comprobante && $comprobante->isValid() && !$comprobante->hasMoved()) {
                $comprobante_name = $comprobante->getRandomName();
                $voucher_url = 'uploads/comprobantes/' . $comprobante_name;
                $contract_file = $voucher_url;
                $comprobante->move(ROOTPATH . 'writable/uploads/comprobantes', $comprobante_name);
            }
            $contractData = [
                'lot_id' => $lotId,
                'customer_id' => $customerId,
                'payment_plan_id' => $paymentPlanId,
                'contract_number' => $contractNumber,
                'total_amount' => $totalAmount,
                'down_payment' => $downPayment,
                'financed_amount' => $totalAmount - $downPayment,
                'monthly_payment' => round((($totalAmount - $downPayment) * ($interestRate / 100 / 12) * pow(1 + ($interestRate / 100 / 12), $financingMonths)) / (pow(1 + ($interestRate / 100 / 12), $financingMonths) - 1), 2),
                'interest_rate' => $interestRate,
                'contract_date' => $contractDate,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => 'active',
                'reservation_amount' => $reservationAmount,
                'reservation_date' => $reservationDate,
                'is_reserved' => $isReserved,
                'contract_type' => $contractType,
                'voucher_url' => $voucher_url,
                'contract_file' => $contract_file
            ];
            $contractId = $contractModel->insert($contractData);
            if ($contractId) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Contrato creado exitosamente',
                    'contract_id' => $contractId,
                    'contract_number' => $contractNumber
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error al crear el contrato'
                ]);
            }
        }
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Método no permitido'
        ]);
    }
    public function schedule($id)
    {
        $contractModel = model('ContractModel');
        $paymentScheduleModel = model('PaymentScheduleModel');
        $session = session();
        $userId = $session->get('id');

        // Verifica que el contrato pertenezca al usuario logueado
        $contract = $contractModel->find($id);
        if (!$contract || $contract['customer_id'] != $userId) {
            return redirect()->to('/backoffice_new/contracts')->with('error', 'Contrato no encontrado o acceso denegado');
        }

        // Obtiene el cronograma de pagos real
        $cuotas = $paymentScheduleModel->where('contract_id', $id)->orderBy('due_date', 'asc')->findAll();

        // Calcula estadísticas
        $pagosRealizados = 0;
        $pagosPendientes = 0;
        $totalPagado = 0;
        $totalPendiente = 0;
        $totalCuotas = count($cuotas);
        foreach ($cuotas as $i => $cuota) {
            if ($cuota['status'] === 'paid') {
                $pagosRealizados++;
                $totalPagado += $cuota['amount'];
            } else {
                $pagosPendientes++;
                $totalPendiente += $cuota['amount'];
            }
        }
        $progreso = $totalCuotas > 0 ? round(($pagosRealizados / $totalCuotas) * 100) : 0;

        // Prepara datos para la vista
        $schedule = [];
        foreach ($cuotas as $i => $cuota) {
            $schedule[] = [
                'num' => $cuota['installment_number'] == 0 ? 'INICIAL' : str_pad($cuota['installment_number'], 2, '0', STR_PAD_LEFT),
                'type' => $cuota['installment_number'] == 0 ? 'Inicial' : 'Cuota',
                'due_date' => date('d/m/Y', strtotime($cuota['due_date'])),
                'amount' => $cuota['amount'],
                'capital' => isset($cuota['capital']) ? $cuota['capital'] : 0,
                'interest' => isset($cuota['interest']) ? $cuota['interest'] : 0,
                'interest_accrued' => isset($cuota['interest_accrued']) ? $cuota['interest_accrued'] : null,
                'interest_accrued_date' => isset($cuota['interest_accrued_date']) ? $cuota['interest_accrued_date'] : null,
                'balance' => $cuota['balance'],
                'status' => $cuota['status'],
                'paid_date' => !empty($cuota['paid_date']) ? $cuota['paid_date'] : null,
                'paid_amount' => isset($cuota['paid_amount']) ? $cuota['paid_amount'] : null,
                'pdf_url' => isset($cuota['pdf_url']) ? $cuota['pdf_url'] : null,
                'xml_url' => isset($cuota['xml_url']) ? $cuota['xml_url'] : null,
                'installment_number' => $cuota['installment_number'],
            ];
        }

        $data = [
            'schedule' => $schedule,
            'contract_id' => $id,
            'pagosRealizados' => $pagosRealizados,
            'pagosPendientes' => $pagosPendientes,
            'totalPagado' => $totalPagado,
            'totalPendiente' => $totalPendiente,
            'progreso' => $progreso,
            'totalCuotas' => $totalCuotas,
               // Agregar total de pagos para la vista
               'total_pagos' => is_array($schedule) ? count($schedule) : 0,
            'title' => 'Cronograma de Pagos',
            'cart_count' => 0
        ];
        // Crear log al acceder a la vista de cronograma
        $logData = [
            'datetime' => date('Y-m-d H:i:s'),
            'contract_id' => $id,
            'schedule' => $schedule,
            'pagosRealizados' => $pagosRealizados,
            'pagosPendientes' => $pagosPendientes,
            'totalPagado' => $totalPagado,
            'totalPendiente' => $totalPendiente,
            'progreso' => $progreso,
            'totalCuotas' => $totalCuotas
        ];
        $logFile = WRITEPATH . 'logs/cronogramatest_' . $id . '_' . date('Ymd_His') . '.log';
        file_put_contents($logFile, json_encode($logData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        return view('backoffice_new/cronograma', $data);
    }

    public function printSchedule($id)
    {
        // Puedes reutilizar la lógica de schedule o generar PDF
        return $this->schedule($id); // Por ahora muestra la misma vista
    }

   public function index()
    {
        $session = session();
        $userId = $session->get('client_id');
        $contractModel = model('ContractModel');
        // Obtiene los contratos del usuario logueado
        $contracts = $contractModel->where('customer_id', $userId)->findAll();

        // Puedes ajustar los nombres de los campos para la vista
        $contractsData = [];
        foreach ($contracts as $contract) {
            $contractsData[] = [
                'id' => $contract['id'],
                'code' => $contract['contract_number'] ?? '',
                'type' => $contract['contract_type'] ?? '',
                'project_name' => $contract['project_name'] ?? '',
                'lot_code' => $contract['lot_id'] ?? '',
                'lot_area' => $contract['lot_area'] ?? '',
                'amount' => $contract['total_amount'] ?? 0,
                'initial' => $contract['down_payment'] ?? 0,
                'monthly' => $contract['monthly_payment'] ?? 0,
                'installments' => $contract['financing_months'] ?? '',
                'status' => $contract['status'] ?? '',
                'signed_date' => $contract['contract_date'] ?? '',
                'start_date' => $contract['start_date'] ?? '',
                'progress' => 0 // Puedes calcular el progreso si tienes pagos realizados
            ];
        }

        $data = [
            'contracts' => $contractsData,
            'title' => 'Mis Contratos',
            'cart_count' => 0
        ];
        return view('backoffice_new/contracts', $data);
    }
    public function load($id)
    {
        // Ejemplo de método para cargar contrato por ID
        // return $this->response->setJSON([...]);
    }

    public function validacion()
    {
        // Ejemplo de método para validación
        // return $this->response->setJSON([...]);
    }

    public function delete($id)
    {
        $contractModel = model('ContractModel');
        $contract = $contractModel->find($id);
        if (!$contract) {
            return redirect()->to('/backoffice_new/contracts')->with('error', 'Contrato no encontrado');
        }
        $contractModel->delete($id);
        return redirect()->to('/backoffice_new/contracts')->with('success', 'Contrato eliminado correctamente');
    }

        public function activate($id)
        {
            $contractModel = model('ContractModel');
            $commissionModel = model('CommissionModel');
            $contract = $contractModel->find($id);
            if (!$contract) {
                return redirect()->to('/backoffice_new/contracts')->with('error', 'Contrato no encontrado');
            }
            // Cambia el estado a 'activo' y guarda
            $contract['status'] = 'activo';
            $contractModel->update($id, $contract);

            // Genera la comisión solo si no existe para este contrato
            $existingCommission = $commissionModel->where('contract_id', $id)->first();
            if (!$existingCommission) {
                $commissionData = [
                    'contract_id' => $id,
                    'amount' => isset($contract['commission_amount']) ? $contract['commission_amount'] : 0,
                    'status' => 'pendiente',
                    'created_at' => date('Y-m-d H:i:s'),
                ];
                $commissionModel->insert($commissionData);
            }

            return redirect()->to('/backoffice_new/contracts')->with('success', 'Contrato activado y comisión generada correctamente');
        }

        public function suspend($id)
        {
            $contractModel = model('ContractModel');
            $contract = $contractModel->find($id);
            if (!$contract) {
                return redirect()->to('/backoffice_new/contracts')->with('error', 'Contrato no encontrado');
            }
            // Cambia el estado a 'suspendido' y guarda
            $contract['status'] = 'suspendido';
            $contractModel->update($id, $contract);
            return redirect()->to('/backoffice_new/contracts')->with('success', 'Contrato suspendido correctamente');
        }
}