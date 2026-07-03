<?php

namespace App\Models;

use CodeIgniter\Model;

class ConciliacionMovimientoModel extends Model
{
    protected $table      = 'conciliacion_movimientos';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'documento_id',
        'banco',
        'cuenta',
        'periodo',
        'fecha',
        'movimiento',
        'detalle',
        'monto',
        'tipo',
        'saldo',
        'categoria_id',
        'created_by',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
