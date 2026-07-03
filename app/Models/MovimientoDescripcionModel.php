<?php

namespace App\Models;

use CodeIgniter\Model;

class MovimientoDescripcionModel extends Model
{
    protected $table      = 'movimiento_descripciones';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'nombre',
        'descripcion',
        'activo',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'nombre' => 'required|min_length[2]|max_length[120]',
    ];

    public function getActivas()
    {
        return $this->where('activo', 1)->orderBy('nombre', 'ASC')->findAll();
    }
}
