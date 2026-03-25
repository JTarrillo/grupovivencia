<?php

namespace App\Models;

use CodeIgniter\Model;

class CompraModel extends Model
{
    protected $table = 'compras';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['proveedor_id', 'numero_comprobante', 'tipo_comprobante', 'fecha_compra', 'subtotal', 'igv', 'total', 'descripcion', 'clasificacion', 'estado'];
    protected $useTimestamps = false;
}
