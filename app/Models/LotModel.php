<?php

namespace App\Models;

use CodeIgniter\Model;

class LotModel extends Model
    /**
     * Cuenta los lotes asignados que tienen contrato para un cliente específico
     */
   
{
    protected $table = 'lots';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'project_id',
        'customer_id',
        'lot_number',
        'cadastral_unit',
        'registry_number',
        'block',
        'area_sqm',
        'base_price',
        'current_price',
        'status',
        'reserved_until',
        'sale_date',
        'price_last_updated'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'project_id' => 'required|integer',
        'lot_number' => 'required|max_length[50]',
        'cadastral_unit' => 'permit_empty|max_length[50]',
        'registry_number' => 'permit_empty|max_length[50]',
        'area_sqm' => 'required|decimal|greater_than[0]',
        'base_price' => 'required|decimal|greater_than[0]',
        'status' => 'required|in_list[available,reserved,sold,blocked]'
    ];

    public function getLotsWithProject()
    {
        return $this->select('lots.*, projects.name as project_name, projects.location')
                   ->join('projects', 'projects.id = lots.project_id')
                   ->findAll();
    }
    public function countLotsWithContract($customer_id)
    {
        return $this->db->table('lots l')
            ->join('contracts c', 'c.lot_id = l.id')
            ->where('c.customer_id', $customer_id)
            ->countAllResults();
    }
    public function getAvailableLotsByProject($project_id)
    {
        return $this->where('project_id', $project_id)
                   ->where('status', 'available')
                   ->findAll();
    }
}