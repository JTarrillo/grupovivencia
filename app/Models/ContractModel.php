<?php

namespace App\Models;

use CodeIgniter\Model;

class ContractModel extends Model
{
    protected $table = 'contracts';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'lot_id',
        'customer_id',
        'payment_plan_id',
        'contract_number',
        'total_amount',
        'down_payment',
        'financed_amount',
        'monthly_payment',
        'interest_rate',
        'contract_date',
        'start_date',
        'end_date',
        'status',
        'contract_file',
        'notes',
        'financing_months',
        'is_reserved',
        'reservation_amount',
        'reservation_date',
        'contract_type',
        'voucher_url',
        'api_factura_id',
        'factura_serie_correlativo',
        'factura_emitida' 
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getContractsWithDetails()
    {
        return $this->select('contracts.*, lots.lot_number, lots.block, lots.cadastral_unit, lots.registry_number, lots.area_sqm, projects.name as project_name, customers.name as customer_name, customers.dni, customers.ruc, customers.address, customers.civil_status, departments.name as department, provinces.name as province, districts.name as district')
            ->join('lots', 'lots.id = contracts.lot_id')
            ->join('projects', 'projects.id = lots.project_id')
            ->join('customers', 'customers.id = contracts.customer_id')
            ->join('departments', 'departments.id = projects.department_id', 'left')
            ->join('provinces', 'provinces.id = projects.province_id', 'left')
            ->join('districts', 'districts.id = projects.district_id', 'left')
            ->findAll();
    }

    public function generateContractNumber()
    {
        $year = date('Y');
        $lastContract = $this->select('contract_number')
            ->like('contract_number', "CON-{$year}-", 'after')
            ->orderBy('id', 'DESC')
            ->first();

        if ($lastContract) {
            $lastNumber = (int) substr($lastContract['contract_number'], -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return "CON-{$year}-" . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
}
