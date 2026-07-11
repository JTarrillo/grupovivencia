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
        'observaciones',
        'clasificado_por',
        'fecha_clasificacion'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Obtener compras con su resumen de clasificacion.
     */
    public function listarComprasParaClasificar($periodoFecha = null)
    {
        $builder = $this->db->table('compras c');
        $builder->select("
            c.id,
            c.numero_comprobante,
            c.tipo_comprobante,
            c.fecha_compra,
            c.total,
            c.estado,
            c.descripcion,
            s.name as proveedor_nombre,
            COUNT(cg.id) as tiene_clasificacion,
            GROUP_CONCAT(DISTINCT gt.nombre ORDER BY gt.nombre SEPARATOR ', ') as tipo_nombre,
            GROUP_CONCAT(DISTINCT gs.nombre ORDER BY gs.nombre SEPARATOR ', ') as subcategoria_nombre
        ", false);
        $builder->join('suppliers s', 's.id = c.proveedor_id', 'left');
        $builder->join('compra_gastos cg', 'cg.compra_id = c.id', 'left');
        $builder->join('gasto_tipos gt', 'gt.id = cg.gasto_tipo_id', 'left');
        $builder->join('gasto_subcategorias gs', 'gs.id = cg.gasto_subcategoria_id', 'left');
        $builder->whereIn('c.estado', ['registrado', 'clasificado']);

        if (!empty($periodoFecha)) {
            $builder->where("DATE(c.fecha_compra) = " . $this->db->escape($periodoFecha), null, false);
        }

        return $builder
            ->groupBy('c.id, c.numero_comprobante, c.tipo_comprobante, c.fecha_compra, c.total, c.estado, c.descripcion, s.name')
            ->orderBy('c.fecha_compra', 'DESC')
            ->orderBy('c.id', 'DESC')
            ->get()
            ->getResultArray();
    }

    /**
     * Obtener clasificacion con detalles completos.
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
            gasto_subcategorias.nombre as subcategoria_nombre
        ')
            ->join('compras', 'compras.id = compra_gastos.compra_id', 'left')
            ->join('suppliers', 'suppliers.id = compras.proveedor_id', 'left')
            ->join('gasto_tipos', 'gasto_tipos.id = compra_gastos.gasto_tipo_id', 'left')
            ->join('gasto_subcategorias', 'gasto_subcategorias.id = compra_gastos.gasto_subcategoria_id', 'left')
            ->where('compra_gastos.id', $id)
            ->first();
    }

    /**
     * Obtener gastos por periodo.
     */
    public function gatosPorPeriodo($fechaInicio, $fechaFin, $gastoTipoId = null)
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
            ->where("DATE(compras.fecha_compra) >= " . $this->db->escape($fechaInicio), null, false)
            ->where("DATE(compras.fecha_compra) <= " . $this->db->escape($fechaFin), null, false);

        if ($gastoTipoId) {
            $query->where('compra_gastos.gasto_tipo_id', $gastoTipoId);
        }

        return $query->groupBy('compra_gastos.gasto_tipo_id, compra_gastos.gasto_subcategoria_id')
                     ->findAll();
    }

    /**
     * Obtener resumen por tipo de gasto.
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
            ->where("DATE(compras.fecha_compra) >= " . $this->db->escape($fechaInicio), null, false)
            ->where("DATE(compras.fecha_compra) <= " . $this->db->escape($fechaFin), null, false)
            ->groupBy('compra_gastos.gasto_tipo_id')
            ->findAll();
    }
}
