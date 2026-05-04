<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectModel extends Model
{
    protected $table = 'projects';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['name', 'code', 'description', 'image', 'total_lots', 'available_lots', 'base_price_per_sqm', 'base_interest_rate', 'status', 'payment_plan_id', 'created_at', 'updated_at', 'department_id', 'province_id', 'district_id'];

    protected $useTimestamps = false;

    public function getProjectWithStats($id)
    {
        $lotModel = new LotModel();
        $project = $this->find($id);
        
        if ($project) {
            $project['sold_lots'] = $lotModel->where('project_id', $id)->where('status', 'sold')->countAllResults();
            $project['reserved_lots'] = $lotModel->where('project_id', $id)->where('status', 'reserved')->countAllResults();
            $project['available_lots'] = $lotModel->where('project_id', $id)->where('status', 'available')->countAllResults();
        }
        
        return $project;
    }
}