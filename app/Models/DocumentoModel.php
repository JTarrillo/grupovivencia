<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentoModel extends Model
{
    protected $table = 'documentos';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['nombre', 'tipo_documento', 'descripcion', 'contenido', 'version', 'fecha_creacion', 'usuario_creador_id', 'estado'];
    protected $useTimestamps = false;
}
