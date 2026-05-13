<?php

namespace App\Controllers;

use App\Models\ContractModel;
use App\Models\LotModel;
use App\Models\PaymentPlanModel;
use App\Models\ProjectModel;
use CodeIgniter\Controller;

class ContractController extends BaseController {
    protected $contractModel;
    protected $lotModel;
    protected $paymentPlanModel;
    protected $projectModel;

    public function __construct()
    {
        $this->contractModel = new ContractModel();
        $this->lotModel = new LotModel();
        $this->paymentPlanModel = new PaymentPlanModel();
        $this->projectModel = new ProjectModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Contratos',
            'contracts' => $this->contractModel->findAll(),
            'session_name' => $_SESSION['name'] ?? 'Usuario'
        ];
        return view('admin/inmueble/contracts', $data);
    }

    public function create()
    {
    log_message('debug', 'Método recibido en create_contract: ' . $this->request->getMethod());
        if (strtolower($this->request->getMethod()) === 'post') {
            $contractNumber = 'GV-' . date('Y') . '-' . str_pad($this->contractModel->countAll() + 1, 3, '0', STR_PAD_LEFT);
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
            $lot = $this->lotModel->find($lotId);
            if (!$lot || $lot['status'] !== 'available') {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'El lote no está disponible'
                ]);
            }

            // Validar que el lote pertenece al proyecto seleccionado
            $selectedProjectId = $this->request->getPost('project_id');
            if ($selectedProjectId && isset($lot['project_id']) && $lot['project_id'] != $selectedProjectId) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'El lote seleccionado no pertenece al proyecto elegido.'
                ]);
            }
            $totalAmount = $lot['current_price'];
            // Si hay reserva, la cuota inicial incluye el monto de reserva
            if (!empty($isReserved) && $isReserved == 1 && !empty($reservationAmount)) {
                $downPayment = $downPayment + $reservationAmount;
            }
            $financedAmount = $totalAmount - $downPayment;
            $monthlyRate = $interestRate / 100 / 12;
            $monthlyPayment = $financedAmount * ($monthlyRate * pow(1 + $monthlyRate, $financingMonths)) / (pow(1 + $monthlyRate, $financingMonths) - 1);
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
                'financed_amount' => $financedAmount,
                'monthly_payment' => round($monthlyPayment, 2),
                'interest_rate' => $interestRate,
                'contract_date' => $contractDate,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => 'active',
                'reservation_amount' => $reservationAmount,
                'reservation_date' => $reservationDate,
                'is_reserved' => $isReserved,
                'voucher_url' => $voucher_url,
                'contract_file' => $contract_file
            ];
            $db = \Config\Database::connect();
            $db->transStart();
            try {
                $contractId = $this->contractModel->insert($contractData);
                $this->lotModel->update($lotId, [
                    'status' => 'sold',
                    'customer_id' => $customerId,
                    'sale_date' => date('Y-m-d H:i:s')
                ]);
                $this->generatePaymentSchedule($contractId, $lotId, $paymentPlanId, $startDate, $financingMonths, $monthlyPayment, $financedAmount, $monthlyRate);
                $db->transComplete();
                if ($db->transStatus() === FALSE) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Error al crear el contrato'
                    ]);
                }
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Contrato creado exitosamente',
                    'contract_id' => $contractId,
                    'contract_number' => $contractNumber
                ]);
            } catch (\Exception $e) {
                $db->transRollback();
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ]);
            }
        }
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Método no permitido'
        ]);
    }

    public function registrarPagoCuota()
    {
        try {
            if (strtolower($this->request->getMethod()) !== 'post') {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Método no permitido'
                ]);
            }

            $idCuota = $this->request->getPost('id_cuota');
            $comprobante = $this->request->getFile('comprobante');

            if (!$idCuota) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'ID de cuota no recibido'
                ]);
            }

            $scheduleModel = new \App\Models\PaymentScheduleModel();
            $cuota = $scheduleModel->find($idCuota);
            if (!$cuota) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Cuota no encontrada'
                ]);
            }

            // Procesar comprobante si existe
            $comprobanteUrl = null;
            if ($comprobante && $comprobante->isValid() && !$comprobante->hasMoved()) {
                // Crear directorio en carpeta pública si no existe
                $uploadPath = FCPATH . 'uploads/comprobantes';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                $newName = $comprobante->getRandomName();
                $comprobante->move($uploadPath, $newName);
                $comprobanteUrl = 'uploads/comprobantes/' . $newName;
            }

            // Validación: Si se subió comprobante, DEBE guardarse la URL
            if ($comprobante && !$comprobanteUrl) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error al procesar el comprobante. Por favor intenta de nuevo.',
                    'error' => 'El archivo se subió pero no se pudo procesar'
                ]);
            }

            $updateData = [
                'status' => 'registered',
                'paid_date' => date('Y-m-d H:i:s'),
                'paid_amount' => $cuota['amount']
            ];

            // Agregar comprobante URL si existe
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
            
            $params[] = $idCuota;
            
            $query = "UPDATE `payment_schedules` SET " . implode(', ', $setClause) . " WHERE `id` = ?";
            $update = $db->query($query, $params);
            
            if ($db->affectedRows() > 0) {
                // Validar que se guardó correctamente en BD
                $scheduleModel = new \App\Models\PaymentScheduleModel();
                $registroActualizado = $scheduleModel->find($idCuota);
                
                // DEBUG detallado
                log_message('debug', '====== VALIDACIÓN COMPROBANTE ======');
                log_message('debug', 'Comprobante URL enviado: ' . var_export($comprobanteUrl, true));
                log_message('debug', 'Comprobante URL en BD: ' . var_export($registroActualizado['comprobante_url'] ?? 'NULL', true));
                log_message('debug', 'Estado en BD: ' . var_export($registroActualizado['status'], true));
                log_message('debug', 'Registro completo: ' . json_encode($registroActualizado));
                
                // Si se subió comprobante, validar que se guardó la URL
                if ($comprobanteUrl && (empty($registroActualizado['comprobante_url']) || is_null($registroActualizado['comprobante_url']))) {
                    log_message('debug', 'ERROR: Comprobante no se guardó en BD');
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Error: El comprobante no se guardó en la base de datos. Verifica los permisos de la carpeta writable/uploads/comprobantes',
                        'debug' => [
                            'comprobante_url_enviado' => $comprobanteUrl,
                            'comprobante_url_guardado' => $registroActualizado['comprobante_url'] ?? 'NULL',
                            'status_guardado' => $registroActualizado['status']
                        ]
                    ]);
                }
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Pago registrado correctamente',
                    'comprobante_url' => $registroActualizado['comprobante_url'],
                    'estado' => $registroActualizado['status']
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'No se pudo registrar el pago en la base de datos'
                ]);
            }
        } catch (\Throwable $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error interno',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function searchCustomers()
    {
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

    public function validatePaymentPlanRules($planData)
    {
        $rules = [
            'Cusco' => [
                'duration_months' => 24,
                'min_down_payment' => 10000,
                'max_interest_rate' => 6.0
            ],
            'General' => [
                'duration_months' => 36,
                'min_down_payment' => 5000,
                'max_interest_rate' => 6.0
            ]
        ];
        $locationRules = $rules[$planData['location']] ?? $rules['General'];
        if ($planData['duration_months'] != $locationRules['duration_months']) {
            return [
                'valid' => false,
                'message' => "Para {$planData['location']} la duración debe ser {$locationRules['duration_months']} meses"
            ];
        }
        if ($planData['base_interest_rate'] < 2.0 || $planData['base_interest_rate'] > 6.0) {
            return [
                'valid' => false,
                'message' => 'La tasa de interés debe estar entre 2% y 6%'
            ];
        }
        return ['valid' => true];
    }

    public function calculatePaymentScheduleExact($contractData)
    {
        $lotPrice = $contractData['total_amount'];
        $downPayment = $contractData['down_payment'];
        $financedAmount = $lotPrice - $downPayment;
        $annualRate = $contractData['interest_rate'] / 100;
        $monthlyRate = $annualRate / 12;
        $months = $contractData['financing_months'];
        $monthlyPayment = $financedAmount * 
            ($monthlyRate * pow(1 + $monthlyRate, $months)) / 
            (pow(1 + $monthlyRate, $months) - 1);
        $schedule = [];
        $balance = $financedAmount;
        for ($i = 1; $i <= $months; $i++) {
            $interestPayment = $balance * $monthlyRate;
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
    private function generatePaymentSchedule($contractId, $lotId, $paymentPlanId, $startDate, $months, $monthlyPayment, $financedAmount, $monthlyRate)
    {
        // Delegate to centralized Model method
        $scheduleModel = new \App\Models\PaymentScheduleModel();
        $scheduleModel->generatePaymentSchedule(
            $contractId,
            $lotId,
            $paymentPlanId,
            $startDate,
            $months,
            $monthlyPayment,
            $financedAmount,
            $monthlyRate
        );
    }

   
}