<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table            = 'customers';
    protected $primaryKey        = 'id';
    protected $useAutoIncrement  = true;
    protected $insertID          = 0;
    protected $returnType        = 'array';
    protected $useSoftDeletes    = false;
    protected $protectFields     = true;
    protected $allowedFields     = [
        'range_id',
        'code',
        'country_id',
        'membership_id',
        'password',
        'name',
        'lastname',
        'mother_last',
        'address',
        'phone',
        'dni',
        'email',
        'active',
        'company_name',
        'account_deductions',
        'address_company'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}