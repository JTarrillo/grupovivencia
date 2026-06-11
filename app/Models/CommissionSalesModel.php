<?php

namespace App\Models;

use CodeIgniter\Model;

class CommissionSalesModel extends Model
{
    protected $table            = 'commission_sales';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'report_id',
        'project_name',
        'client_name',
        'manzana',
        'lote',
        'payment_type',
        'deposit_number',
        'deposit_amount',
        'percentage',
        'commission_amount'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
