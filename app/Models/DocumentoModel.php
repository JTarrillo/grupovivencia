<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentoModel extends Model
{
    protected $table      = 'documentos';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'nombre',
        'archivo',
        'descripcion',
        'tipo',
        'tamanio',
        'created_by',
    ];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $columnExistsCache = [];

    public function hasColumn(string $column): bool
    {
        if (!array_key_exists($column, $this->columnExistsCache)) {
            $this->columnExistsCache[$column] = (bool) $this->db->fieldExists($column, $this->table);
        }

        return $this->columnExistsCache[$column];
    }

    public function listar()
    {
        $orderColumn = $this->hasColumn('created_at') ? 'created_at' : $this->primaryKey;
        $rows = $this->orderBy($orderColumn, 'DESC')->findAll();

        if (!$this->hasColumn('created_at')) {
            foreach ($rows as &$row) {
                $row['created_at'] = $row['created_at'] ?? null;
            }
            unset($row);
        }

        return $rows;
    }

    public function insertarDocumento(array $data): bool
    {
        $now = date('Y-m-d H:i:s');

        if ($this->hasColumn('created_at')) {
            $data['created_at'] = $now;
        }

        if ($this->hasColumn('updated_at')) {
            $data['updated_at'] = $now;
        }

        return (bool) $this->insert($data);
    }
}