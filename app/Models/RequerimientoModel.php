<?php

namespace App\Models;

use CodeIgniter\Model;

class RequerimientoModel extends Model
{
    protected $table = 'requerimientos';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['cliente_id', 'contrato_id', 'tipo_requerimiento', 'descripcion', 'documento_requerido', 'fecha_vencimiento', 'estado', 'fecha_creacion', 'usuario_id', 'observaciones'];
    protected $useTimestamps = false;
}
