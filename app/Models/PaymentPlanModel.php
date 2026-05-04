<?php
namespace App\Models;
use CodeIgniter\Model;

class PaymentPlanModel extends Model {
    protected $table = 'payment_plans';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'name', 'code', 'location', 'duration_months', 
        'down_payment_type', 'min_down_payment_percentage', 
        'min_amount', 'base_interest_rate', 
        'is_default', 'active'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getActivePlans($location = null) {
        $builder = $this->where('active', 1);
        
        if ($location) {
            $builder->where('location', $location);
        }
        
        return $builder->findAll();
    }

    public function getDefaultPlan($location = 'General') {
        return $this->where('is_default', 1)
                   ->where('location', $location)
                   ->where('active', 1)
                   ->first();
    }

    public function calculate_payment_simulation($plan_id, $lot_price, $down_payment) {
        $plan = $this->find($plan_id);
        if (!$plan) {
            return ['error' => 'Plan no encontrado'];
        }

        $min_down_payment = $lot_price * ($plan['min_down_payment_percentage'] / 100);
        if ($down_payment < $min_down_payment) {
            return [
                'error' => "Cuota inicial mínima requerida: S/ " . number_format($min_down_payment, 2)
            ];
        }

        $amount_to_finance = $lot_price - $down_payment;
        $monthly_rate = $plan['base_interest_rate'] / 100 / 12;
        $num_payments = $plan['duration_months'];

        if ($monthly_rate > 0) {
            $monthly_payment = $amount_to_finance * 
                ($monthly_rate * pow(1 + $monthly_rate, $num_payments)) / 
                (pow(1 + $monthly_rate, $num_payments) - 1);
        } else {
            $monthly_payment = $amount_to_finance / $num_payments;
        }

        $total_to_pay = $down_payment + ($monthly_payment * $num_payments);
        $total_interest = $total_to_pay - $lot_price;

        return [
            'plan_name' => $plan['name'],
            'initial_payment' => $down_payment,
            'amount_to_finance' => $amount_to_finance,
            'monthly_payment' => round($monthly_payment, 2),
            'duration_months' => $num_payments,
            'interest_rate' => $plan['base_interest_rate'],
            'total_to_pay' => round($total_to_pay, 2),
            'total_interest' => round($total_interest, 2)
        ];
    }

    public function seed_default_plans() {
        $plans = [
            [
                'name' => 'Plan Básico',
                'code' => 'BASIC',
                'location' => 'General',
                'duration_months' => 24,
                'min_down_payment_percentage' => 20,
                'base_interest_rate' => 8.5,
                'is_default' => 1,
                'active' => 1
            ],
            [
                'name' => 'Plan Extendido',
                'code' => 'EXTENDED',
                'location' => 'General',
                'duration_months' => 36,
                'min_down_payment_percentage' => 15,
                'base_interest_rate' => 9.0,
                'is_default' => 0,
                'active' => 1
            ]
        ];

        foreach ($plans as $plan) {
            $this->insert($plan);
        }
    }
}