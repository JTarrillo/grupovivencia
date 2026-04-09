<?php

namespace App\Models;

use CodeIgniter\Model;

class GastoTipoModel extends Model
{
    protected $table = 'gasto_tipos';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'nombre',
        'icono',
        'descripcion',
        'color',
        'activo'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'nombre' => 'required|min_length[3]|max_length[100]',
        'icono' => 'permit_empty|max_length[50]',
        'color' => 'permit_empty|max_length[20]',
    ];

    /**
     * Obtener todos los tipos de gasto activos
     */
    public function getTiposActivos()
    {
        return $this->where('activo', 1)
                    ->orderBy('nombre', 'ASC')
                    ->findAll();
    }

    /**
     * Obtener tipo con todas sus subcategorías
     */
    public function getTipoConSubcategorias($id)
    {
        $tipo = $this->find($id);
        if (!$tipo) return null;

        $subcategoriaModel = new GastoSubcategoriaModel();
        $tipo['subcategorias'] = $subcategoriaModel->where('gasto_tipo_id', $id)
                                                    ->where('activo', 1)
                                                    ->findAll();
        return $tipo;
    }
}
