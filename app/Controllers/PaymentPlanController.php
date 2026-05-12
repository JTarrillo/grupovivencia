<?php

namespace App\Controllers;

use App\Models\PaymentPlanModel;
use App\Models\ContractModel;
use CodeIgniter\Controller;

class PaymentPlanController extends BaseController {
    protected $paymentPlanModel;
    protected $contractModel;

    public function __construct()
    {
        $this->paymentPlanModel = new PaymentPlanModel();
        $this->contractModel = new ContractModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Planes de Pago',
            'payment_plans' => $this->paymentPlanModel->findAll(),
            'session_name' => $_SESSION['name'] ?? 'Usuario'
        ];
        return view('admin/inmueble/payment_plans', $data);
    }

    public function create()
    {
        if (strtolower($this->request->getMethod()) === 'post') {
            $res = $this->request->getPost();
            if (empty($res) && strpos($this->request->getHeaderLine('Content-Type'), 'application/json') !== false) {
                $json = $this->request->getJSON(true);
                if (is_array($json)) {
                    $res = $json;
                }
            }
            $data = [
                'name' => $res['name'] ?? '',
                'code' => $res['code'] ?? '',
                'location' => $res['location'] ?? '',
                'duration_months' => $res['duration_months'] ?? '',
                'base_interest_rate' => $res['base_interest_rate'] ?? '',
                'is_default' => !empty($res['is_default']) ? 1 : 0,
                'active' => !empty($res['active']) ? 1 : 0
            ];
            if (empty($data['name']) || empty($data['code']) || empty($data['location']) || empty($data['duration_months']) || empty($data['base_interest_rate'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Completa todos los campos obligatorios.'
                ]);
            }
            if ($data['base_interest_rate'] < 2 || $data['base_interest_rate'] > 6) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'La tasa de interés debe estar entre 2% y 6%.'
                ]);
            }
            if ($data['duration_months'] != 24 && $data['duration_months'] != 36 && $data['duration_months'] != 48) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'La duración debe ser 24, 36 o 48 meses.'
                ]);
            }
            if ($this->paymentPlanModel->where('code', $data['code'])->countAllResults() > 0) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'El código ya existe, ingresa uno diferente.'
                ]);
            }
            if ($data['is_default']) {
                $this->paymentPlanModel->where('location', $data['location'])
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
        $data = [
            'title' => 'Nuevo Plan de Pago',
            'session_name' => $_SESSION['name'] ?? 'Usuario'
        ];
        return view('admin/inmueble/create_payment_plan', $data);
    }

    public function get($plan_id)
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

    public function update($plan_id)
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
            if (empty($res) && $this->request->getHeaderLine('Content-Type') === 'application/json') {
                $json = $this->request->getJSON(true);
                if (is_array($json)) {
                    $res = $json;
                }
            }
            $data = [
                'name' => $res['name'] ?? '',
                'code' => $res['code'] ?? '',
                'location' => $res['location'] ?? '',
                'duration_months' => $res['duration_months'] ?? '',
                'base_interest_rate' => $res['base_interest_rate'] ?? '',
                'is_default' => !empty($res['is_default']) ? 1 : 0,
                'active' => !empty($res['active']) ? 1 : 0
            ];
            if ($data['is_default']) {
                $this->paymentPlanModel->where('location', $data['location'])
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
        return redirect()->to('/dashboard/inmueble/payment_plans');
    }

    public function delete($plan_id)
    {
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
            return redirect()->to('/dashboard/inmueble/payment_plans');
        }
        $plan = $this->paymentPlanModel->find($plan_id);
        if (!$plan) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Plan de pago no encontrado',
                'debug' => [ 'plan_id' => $plan_id ]
            ]);
        }
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

    public function stats($plan_id)
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

    public function api()
    {
        $plans = $this->paymentPlanModel
            ->where('active', 1)
            ->findAll();
        return $this->response->setJSON(['plans' => $plans]);
    }
}