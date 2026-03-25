<?php

namespace App\Models;

use CodeIgniter\Model;

class ArchivoDigitalModel extends Model
{
    protected $table = 'archivos_digitales';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['nombre_original', 'nombre_almacenado', 'tipo_documento', 'tamaño', 'ruta_archivo', 'contrato_id', 'cliente_id', 'descripcion', 'fecha_subida', 'usuario_id', 'estado'];
    protected $useTimestamps = false;
}
