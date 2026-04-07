<?php

namespace App\Models;

use CodeIgniter\Model;

class CompraGastoModel extends Model
{
    protected $table = 'compra_gastos';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'compra_id',
        'gasto_tipo_id',
        'gasto_subcategoria_id',
        'proyecto_id',
        'contrato_id',
        'observaciones',
        'clasificado_por',
        'fecha_clasificacion'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Obtener clasificación con detalles completos
     */
    public function conDetalles($id)
    {
        return $this->select('
            compra_gastos.*,
            compras.numero_comprobante,
            compras.total,
            compras.fecha_compra,
            suppliers.name as proveedor_nombre,
            gasto_tipos.nombre as tipo_nombre,
            gasto_tipos.icono,
            gasto_tipos.color,
            gasto_subcategorias.nombre as subcategoria_nombre,
            projects.name as proyecto_nombre,
            contracts.contract_number
        ')
            ->join('compras', 'compras.id = compra_gastos.compra_id', 'left')
            ->join('suppliers', 'suppliers.id = compras.proveedor_id', 'left')
            ->join('gasto_tipos', 'gasto_tipos.id = compra_gastos.gasto_tipo_id', 'left')
            ->join('gasto_subcategorias', 'gasto_subcategorias.id = compra_gastos.gasto_subcategoria_id', 'left')
            ->join('projects', 'projects.id = compra_gastos.proyecto_id', 'left')
            ->join('contracts', 'contracts.id = compra_gastos.contrato_id', 'left')
            ->where('compra_gastos.id', $id)
            ->first();
    }

    /**
     * Obtener gastos por período
     */
    public function gatosPorPeriodo($fechaInicio, $fechaFin, $gastoTipoId = null, $proyectoId = null)
    {
        $query = $this->select('
            gasto_tipos.nombre as tipo,
            gasto_subcategorias.nombre as subcategoria,
            SUM(compras.total) as total_gasto,
            COUNT(compra_gastos.id) as cantidad
        ')
            ->join('compras', 'compras.id = compra_gastos.compra_id', 'left')
            ->join('gasto_tipos', 'gasto_tipos.id = compra_gastos.gasto_tipo_id', 'left')
            ->join('gasto_subcategorias', 'gasto_subcategorias.id = compra_gastos.gasto_subcategoria_id', 'left')
            ->where('DATE(compras.fecha_compra) >=', $fechaInicio)
            ->where('DATE(compras.fecha_compra) <=', $fechaFin);

        if ($gastoTipoId) {
            $query->where('compra_gastos.gasto_tipo_id', $gastoTipoId);
        }

        if ($proyectoId) {
            $query->where('compra_gastos.proyecto_id', $proyectoId);
        }

        return $query->groupBy('compra_gastos.gasto_tipo_id, compra_gastos.gasto_subcategoria_id')
                     ->findAll();
    }

    /**
     * Obtener resumen por tipo de gasto
     */
    public function resumenPorTipo($fechaInicio, $fechaFin)
    {
        return $this->select('
            gasto_tipos.id,
            gasto_tipos.nombre,
            gasto_tipos.color,
            gasto_tipos.icono,
            SUM(compras.total) as total,
            COUNT(compra_gastos.id) as cantidad
        ')
            ->join('compras', 'compras.id = compra_gastos.compra_id', 'left')
            ->join('gasto_tipos', 'gasto_tipos.id = compra_gastos.gasto_tipo_id', 'left')
            ->where('DATE(compras.fecha_compra) >=', $fechaInicio)
            ->where('DATE(compras.fecha_compra) <=', $fechaFin)
            ->groupBy('compra_gastos.gasto_tipo_id')
            ->findAll();
    }
}
