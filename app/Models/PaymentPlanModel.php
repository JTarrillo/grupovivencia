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
        'name', 'code', 'duration_months', 
        'base_interest_rate', 'is_default', 'active'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getActivePlans() {
        return $this->where('active', 1)->findAll();
    }

    public function getDefaultPlan() {
        return $this->where('is_default', 1)
                   ->where('active', 1)
                   ->first();
    }

    public function seed_default_plans() {
        $plans = [
            [
                'name' => 'Plan Básico',
                'code' => 'BASIC',
                'duration_months' => 24,
                'base_interest_rate' => 8.5,
                'is_default' => 1,
                'active' => 1
            ],
            [
                'name' => 'Plan Extendido',
                'code' => 'EXTENDED',
                'duration_months' => 36,
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