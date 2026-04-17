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
        'ciudad',
        'interes',
        'mensaje',
        'estado',
        'fecha_confirmacion'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'fecha_registro';
    protected $updatedField = null;
    protected $deletedField = null;

    // Validaciones
    protected $validationRules = [
        'nombre' => 'required|min_length[3]|max_length[100]',
        'email' => 'required|valid_email|max_length[120]',
        'telefono' => 'permit_empty|max_length[20]',
        'ciudad' => 'permit_empty|max_length[80]',
        'interes' => 'permit_empty|max_length[100]',
        'mensaje' => 'permit_empty|max_length[1000]'
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
     * Obtener registros por ciudad
     */
    public function getByCiudad($ciudad)
    {
        return $this->where('ciudad', $ciudad)->findAll();
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
                    ->orLike('ciudad', $filters['search'])
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
}
