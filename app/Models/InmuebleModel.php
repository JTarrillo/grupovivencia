<?php

namespace App\Models;

use CodeIgniter\Model;

class InmuebleModel extends Model
{
    protected $table = 'projects';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['name', 'code', 'location', 'description', 'total_lots', 'available_lots', 'base_price_per_sqm', 'min_down_payment_percentage', 'max_financing_months', 'base_interest_rate', 'status'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[255]',
        'code' => 'required|min_length[3]|max_length[50]|is_unique[projects.code]',
        'location' => 'required|min_length[3]|max_length[255]',
        'total_lots' => 'required|integer|greater_than[0]',
        'base_price_per_sqm' => 'required|decimal|greater_than[0]',
        'status' => 'required|in_list[planning,active,sold_out,suspended]'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'El nombre del proyecto es obligatorio',
            'min_length' => 'El nombre debe tener al menos 3 caracteres'
        ],
        'code' => [
            'required' => 'El código del proyecto es obligatorio',
            'is_unique' => 'Este código ya existe'
        ]
    ];

    public function getDashboardStats()
    {
        return [
            'total_projects' => $this->countAll(),
            'active_projects' => $this->where('status', 'active')->countAllResults(),
            'planning_projects' => $this->where('status', 'planning')->countAllResults(),
            'sold_out_projects' => $this->where('status', 'sold_out')->countAllResults()
        ];
    }

    public function getProjectsByLocation($location = null)
    {
        if ($location) {
            return $this->where('location', $location)->findAll();
        }
        return $this->findAll();
    }
}
