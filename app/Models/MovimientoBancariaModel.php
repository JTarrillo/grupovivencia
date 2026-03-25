<?php

namespace App\Models;

use CodeIgniter\Model;

class MovimientoBancariaModel extends Model
{
    protected $table = 'movimientos_bancarios';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['cuenta_bancaria_id', 'tipo', 'monto', 'saldo_anterior', 'saldo_nuevo', 'fecha', 'descripcion', 'referencia'];
    protected $useTimestamps = false;
}
