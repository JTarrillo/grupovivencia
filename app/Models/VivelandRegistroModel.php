<?php

namespace App\Models;

use CodeIgniter\Model;

class VivelandRegistroModel extends Model
{
    protected $table = 'viveland_registros';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'nombre',
        'email',
        'telefono',
        'zona',
        'interes',
        'estado',
        'fecha_confirmacion'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'fecha_registro';
    protected $updatedField = null;
    protected $deletedField = null;
    protected $skipValidation = false;
    protected $validateBeforeInsert = false;
    protected $validateBeforeUpdate = false;

    // Validaciones
    protected $validationRules = [
        'nombre' => 'required|min_length[3]|max_length[100]',
        'email' => 'required|valid_email|max_length[120]',
        'telefono' => 'required|max_length[20]',
        'zona' => 'required|in_list[Zona Viveland,Zona VIP,Zona Platinum,Zona General]',
        'interes' => 'required|max_length[100]'
    ];

    protected $validationMessages = [
        'nombre' => [
            'required' => 'El nombre es requerido',
            'min_length' => 'El nombre debe tener al menos 3 caracteres'
        ],
        'email' => [
            'required' => 'El email es requerido',
            'valid_email' => 'Ingresa un email válido'
        ]
    ];

    /**
     * Obtener registros por estado
     */
    public function getByEstado($estado)
    {
        return $this->where('estado', $estado)->findAll();
    }

    /**
     * Obtener registros por zona
     */
    public function getByZona($zona)
    {
        return $this->where('zona', $zona)->findAll();
    }

    /**
     * Obtener total de registros
     */
    public function getTotalRegistros()
    {
        return $this->countAllResults();
    }

    /**
     * Confirmar registro
     */
    public function confirmarRegistro($id)
    {
        return $this->update($id, [
            'estado' => 'confirmado',
            'fecha_confirmacion' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Obtener todos los registros con búsqueda y filtros
     */
    public function get_all($filters = [])
    {
        $builder = $this->builder();

        // Filtrar por estado
        if (isset($filters['estado']) && $filters['estado'] != '') {
            $builder->where('estado', $filters['estado']);
        }

        // Búsqueda por nombre
        if (isset($filters['search']) && $filters['search'] != '') {
            $builder->groupStart()
                    ->like('nombre', $filters['search'])
                    ->orLike('email', $filters['search'])
                    ->orLike('zona', $filters['search'])
                    ->groupEnd();
        }

        // Ordenar por fecha más reciente
        $builder->orderBy('fecha_registro', 'DESC');

        return $builder->get()->getResultArray();
    }

    /**
     * Obtener un registro específico
     */
    public function get_by_id($id)
    {
        return $this->find($id);
    }

    /**
     * Contar registros por estado
     */
    public function count_by_estado($estado)
    {
        return $this->where('estado', $estado)->countAllResults();
    }

    /**
     * Obtener estadísticas
     */
    public function get_stats()
    {
        return [
            'total' => $this->countAllResults(),
            'pendiente' => $this->count_by_estado('pendiente'),
            'confirmado' => $this->count_by_estado('confirmado'),
            'cancelado' => $this->count_by_estado('cancelado')
        ];
    }

    /**
     * Actualizar estado de registro
     */
    public function update_estado($id, $estado)
    {
        return $this->update($id, ['estado' => $estado]);
    }

    /**
     * Actualizar fecha de confirmación
     */
    public function confirmar_registro($id)
    {
        return $this->update($id, [
            'estado' => 'confirmado',
            'fecha_confirmacion' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Eliminar registro
     */
    public function eliminar_registro($id)
    {
        return $this->delete($id);
    }
}
