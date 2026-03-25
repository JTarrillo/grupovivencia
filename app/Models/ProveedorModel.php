<?php

namespace App\Models;

use CodeIgniter\Model;

class ProveedorModel extends Model
{
    protected $table = 'proveedores';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['razon_social', 'ruc', 'contacto', 'telefono', 'email', 'direccion', 'tipo_proveedor', 'estado', 'fecha_registro'];
    protected $useTimestamps = false;
}
