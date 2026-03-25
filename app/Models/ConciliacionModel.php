<?php

namespace App\Models;

use CodeIgniter\Model;

class ConciliacionModel extends Model
{
    protected $table = 'conciliaciones_bancarias';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['cuenta_bancaria_id', 'saldo_sistema', 'saldo_banco', 'diferencia', 'fecha_conciliacion', 'observaciones', 'estado'];
    protected $useTimestamps = false;
}
