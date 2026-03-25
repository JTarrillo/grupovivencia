<?php

namespace App\Models;

use CodeIgniter\Model;

class DeclaracionModel extends Model
{
    protected $table = 'declaraciones_tributarias';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['periodo', 'total_ventas', 'total_compras', 'igv_a_pagar', 'estado', 'fecha_creacion'];
    protected $useTimestamps = false;
}
