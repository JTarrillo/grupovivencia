<?php

namespace App\Models;

use CodeIgniter\Model;

class GastoSubcategoriaModel extends Model
{
    protected $table = 'gasto_subcategorias';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'gasto_tipo_id',
        'nombre',
        'descripcion',
        'activo'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'gasto_tipo_id' => 'required|numeric',
        'nombre' => 'required|min_length[3]|max_length[100]',
    ];

    /**
     * Obtener subcategorías por tipo activas
     */
    public function getPorTipo($gastoTipoId)
    {
        return $this->where('gasto_tipo_id', $gastoTipoId)
                    ->where('activo', 1)
                    ->orderBy('nombre', 'ASC')
                    ->findAll();
    }

    /**
     * Obtener subcategoría con su tipo
     */
    public function conTipo($id)
    {
        $result = $this->select('gasto_subcategorias.*, gasto_tipos.nombre as tipo_nombre, gasto_tipos.icono, gasto_tipos.color')
                       ->join('gasto_tipos', 'gasto_tipos.id = gasto_subcategorias.gasto_tipo_id', 'left')
                       ->where('gasto_subcategorias.id', $id)
                       ->first();
        return $result;
    }
}
