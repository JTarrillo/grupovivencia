<?php
namespace App\Controllers;

use App\Models\PenaltyModel;
use App\Models\PaymentScheduleModel;
use App\Models\ContractModel;

class Penalties extends BaseController
{
    public function applyPenalties()
    {
        $penaltyModel = new PenaltyModel();
        $paymentScheduleModel = new PaymentScheduleModel();
        $contractModel = new ContractModel();

        // Penalidad por mora (cuotas vencidas > 30 días)
        $overduePayments = $paymentScheduleModel
            ->where('status', 'pending')
            ->where('due_date <', date('Y-m-d', strtotime('-30 days')))
            ->findAll();

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
            }
        }

        // Suspensión por 3 cuotas consecutivas en mora
        $contracts = $contractModel->findAll();
        foreach ($contracts as $contract) {
            $moras = $paymentScheduleModel
                ->where('contract_id', $contract['id'])
                ->where('status', 'pending')
                ->where('due_date <', date('Y-m-d', strtotime('-30 days')))
                ->orderBy('due_date', 'desc')
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
                }
            }
        }

        return 'Penalidades aplicadas correctamente.';
    }
    public function index()
    {
        $penaltyModel = new \App\Models\PenaltyModel();
        $penalties = $penaltyModel->findAll();
        return view('admin/penalties/index', ['penalties' => $penalties]);
    }

    public function view($id)
    {
        $penaltyModel = new \App\Models\PenaltyModel();
        $penalty = $penaltyModel->find($id);
        return view('admin/penalties/view', ['penalty' => $penalty]);
    }

    public function markPaid()
    {
        $id = $this->request->getPost('id');
        $penaltyModel = new \App\Models\PenaltyModel();
        $penaltyModel->update($id, ['status' => 'pagada']);
        return redirect()->to('/dashboard/penalties');
    }

    public function delete()
    {
        $id = $this->request->getPost('id');
        $penaltyModel = new \App\Models\PenaltyModel();
        $penaltyModel->delete($id);
        return redirect()->to('/dashboard/penalties');
    }
}
