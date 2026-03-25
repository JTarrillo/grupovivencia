<?php

namespace App\Models;

use CodeIgniter\Model;

class CostoproyectoModel extends Model
{
    protected $table = 'costos_proyecto';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['proyecto_id', 'descripcion', 'monto', 'tipo_costo', 'fecha_registro'];
    protected $useTimestamps = false;
}
