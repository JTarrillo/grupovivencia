<?php

namespace App\Models;

use CodeIgniter\Model;

class PagoProveedorModel extends Model
{
    protected $table = 'pagos_proveedores';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['proveedor_id', 'monto', 'fecha_pago', 'metodo_pago', 'referencia', 'descripcion', 'estado'];
    protected $useTimestamps = false;
}
