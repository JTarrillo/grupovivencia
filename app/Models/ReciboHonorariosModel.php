<?php

namespace App\Models;

use CodeIgniter\Model;

class ReciboHonorariosModel extends Model
{
    protected $table = 'recibos_honorarios';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['beneficiario', 'dni_ruc', 'monto', 'concepto', 'numero_recibo', 'fecha_creacion', 'estado'];
    protected $useTimestamps = false;
}
