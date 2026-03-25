<?php

namespace App\Models;

use CodeIgniter\Model;

class VentaModel extends Model
{
    protected $table = 'ventas';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['cliente_id', 'numero_comprobante', 'tipo_comprobante', 'fecha_venta', 'subtotal', 'igv', 'total', 'descripcion', 'estado'];
    protected $useTimestamps = false;
}
