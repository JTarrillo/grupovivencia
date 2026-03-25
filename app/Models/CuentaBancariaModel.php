<?php

namespace App\Models;

use CodeIgniter\Model;

class CuentaBancariaModel extends Model
{
    protected $table = 'cuentas_bancarias';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['banco', 'numero_cuenta', 'tipo_cuenta', 'saldo', 'moneda', 'estado', 'fecha_creacion'];
    protected $useTimestamps = false;
}
