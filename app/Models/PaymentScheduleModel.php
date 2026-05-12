<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentScheduleModel extends Model
{
    protected $table            = 'payment_schedules';
    protected $primaryKey        = 'id';
    protected $useAutoIncrement  = true;
    protected $insertID          = 0;
    protected $returnType        = 'array';
    protected $useSoftDeletes    = false;
    protected $protectFields     = true;
    protected $allowedFields     = [
        'lot_id',
        'payment_plan_id', 
        'contract_id',
        'installment_number',
        'due_date',
        'amount',
        'capital',
        'interest',
        'balance',
        'status',
        'paid_date',
        'paid_amount',
        'comprobante_url',
        'voucher_url',
        'validado_notas'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Generar cronograma de pagos centralizado
     * 
     * @param int $contractId ID del contrato
     * @param int $lotId ID del lote
     * @param int|null $paymentPlanId ID del plan de pago
     * @param string $startDate Fecha de inicio (Y-m-d)
     * @param int $months Duración en meses
     * @param float $monthlyPayment Cuota mensual
     * @param float $financedAmount Monto financiado
     * @param float $monthlyRate Tasa mensual (ej: 0.002917 para 3.5% anual)
     * @param float $downPayment Cuota inicial (opcional, default 0)
     * @param string|null $contractDate Fecha del contrato (opcional, para cuota inicial)
     * @param string|null $voucherUrl URL del comprobante/voucher (opcional)
     * @return bool
     */
    public function generatePaymentSchedule($contractId, $lotId, $paymentPlanId, $startDate, $months, $monthlyPayment, $financedAmount, $monthlyRate = 0, $downPayment = 0, $contractDate = null, $voucherUrl = null)
    {
        // Validaciones
        if (empty($contractId) || empty($months) || empty($monthlyPayment)) {
            return false;
        }

        $balance = $financedAmount;
        
        // ✅ CUOTA INICIAL (installment_number = 0) con el monto del down_payment
        if ($downPayment > 0) {
            $initialDate = $contractDate ?? date('Y-m-d');
            // Si hay voucher adjunto, marcar como pagado automáticamente
            $status = !empty($voucherUrl) ? 'paid' : 'pending';
            $paidDate = !empty($voucherUrl) ? date('Y-m-d H:i:s') : null;
            
            $initialPayment = [
                'lot_id' => $lotId,
                'payment_plan_id' => $paymentPlanId,
                'contract_id' => $contractId,
                'installment_number' => 0,
                'due_date' => $initialDate,
                'amount' => round($downPayment, 2),
                'capital' => round($downPayment, 2),
                'interest' => 0,
                'balance' => round($financedAmount, 2),
                'status' => $status,
                'paid_date' => $paidDate
            ];
            
            // 🔧 ASEGURARSE DE GUARDAR voucher_url SIEMPRE QUE EXISTA
            if (!empty($voucherUrl)) {
                $initialPayment['voucher_url'] = $voucherUrl;
            }
            
            $this->insert($initialPayment);
        }
        
        // Cuotas mensuales (1 a N)
        for ($i = 1; $i <= $months; $i++) {
            $dueDate = date('Y-m-d', strtotime($startDate . ' +' . ($i - 1) . ' months'));
            $interestPayment = $balance * $monthlyRate;
            
            // Si es la última cuota, ajustar al saldo exacto para evitar sobrepago
            if ($i == $months && $balance > 0) {
                $principalPayment = $balance;
                $monthlyPaymentAdjusted = $balance + $interestPayment;
                $balance = 0;
            } else {
                $principalPayment = $monthlyPayment - $interestPayment;
                $monthlyPaymentAdjusted = $monthlyPayment;
                $balance -= $principalPayment;
            }
            
            $this->insert([
                'lot_id' => $lotId,
                'payment_plan_id' => $paymentPlanId,
                'contract_id' => $contractId,
                'installment_number' => $i,
                'due_date' => $dueDate,
                'amount' => round($monthlyPaymentAdjusted, 2),
                'capital' => round($principalPayment, 2),
                'interest' => round($interestPayment, 2),
                'balance' => round(max(0, $balance), 2),
                'status' => 'pending'
            ]);
        }
        
        return true;
    }
}

