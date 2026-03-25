<?php

namespace App\Models;

use CodeIgniter\Model;

class ClasificacionCompraModel extends Model
{
    protected $table = 'clasificaciones_compra';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['nombre', 'descripcion', 'codigo'];
    protected $useTimestamps = false;
}
