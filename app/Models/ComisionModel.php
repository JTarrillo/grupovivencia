<?php

namespace App\Models;

use CodeIgniter\Model;

class ComisionModel extends Model
{
    protected $table = 'comisiones';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['contrato_id', 'agente_id', 'porcentaje', 'monto_total', 'monto_comision', 'estado', 'fecha_creacion'];
    protected $useTimestamps = false;
}
