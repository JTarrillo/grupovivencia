<?php

namespace App\Models;

use CodeIgniter\Model;

class GastoReporteModel extends Model
{
    protected $table = 'gasto_reportes';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'nombre',
        'fecha_inicio',
        'fecha_fin',
        'proyecto_id',
        'contrato_id',
        'tipo_gasto_id',
        'contenido_html',
        'contenido_pdf',
        'total_gasto',
        'cantidad_compras',
        'estado',
        'usuario_creador',
        'usuario_contable',
        'fecha_envio',
        'observaciones'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'nombre' => 'required|min_length[5]|max_length[255]',
        'fecha_inicio' => 'required|valid_date',
        'fecha_fin' => 'required|valid_date',
        'usuario_creador' => 'required|numeric',
    ];

    /**
     * Obtener reportes actuales/borradores
     */
    public function reportesActivos()
    {
        return $this->whereIn('estado', ['borrador', 'completado'])
                    ->orderBy('fecha_inicio', 'DESC')
                    ->findAll();
    }

    /**
     * Obtener reportes enviados a contabilidad
     */
    public function reportesEnviados()
    {
        return $this->where('estado', 'enviado')
                    ->orderBy('fecha_envio', 'DESC')
                    ->findAll();
    }

    /**
     * Obtener reporte con detalles de gastos
     */
    public function conDetalles($id)
    {
        $reporte = $this->find($id);
        if (!$reporte) return null;

        // Obtener gastos asociados al reporte
        $compraGastoModel = new CompraGastoModel();
        $reporte['gastos'] = $compraGastoModel->select('
            compra_gastos.*,
            gasto_tipos.nombre as tipo_nombre,
            gasto_tipos.color,
            gasto_subcategorias.nombre as subcategoria_nombre,
            compras.numero_comprobante,
            compras.total,
            compras.fecha_compra,
            suppliers.name as proveedor_nombre
        ')
            ->join('compras', 'compras.id = compra_gastos.compra_id', 'left')
            ->join('gasto_tipos', 'gasto_tipos.id = compra_gastos.gasto_tipo_id', 'left')
            ->join('gasto_subcategorias', 'gasto_subcategorias.id = compra_gastos.gasto_subcategoria_id', 'left')
            ->join('suppliers', 'suppliers.id = compras.proveedor_id', 'left')
            ->where('DATE(compras.fecha_compra) >=', $reporte['fecha_inicio'])
            ->where('DATE(compras.fecha_compra) <=', $reporte['fecha_fin']);

        if ($reporte['proyecto_id']) {
            $reporte['gastos'] = $reporte['gastos']->where('compra_gastos.proyecto_id', $reporte['proyecto_id']);
        }

        if ($reporte['contrato_id']) {
            $reporte['gastos'] = $reporte['gastos']->where('compra_gastos.contrato_id', $reporte['contrato_id']);
        }

        if ($reporte['tipo_gasto_id']) {
            $reporte['gastos'] = $reporte['gastos']->where('compra_gastos.gasto_tipo_id', $reporte['tipo_gasto_id']);
        }

        $reporte['gastos'] = $reporte['gastos']->findAll();
        return $reporte;
    }

    /**
     * Cambiar estado a enviado
     */
    public function enviarAContabilidad($id, $usuarioContable)
    {
        return $this->update($id, [
            'estado' => 'enviado',
            'usuario_contable' => $usuarioContable,
            'fecha_envio' => date('Y-m-d H:i:s')
        ]);
    }
}
