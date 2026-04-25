<?php

namespace App\Models;

use CodeIgniter\Model;

class ComprasModel extends Model
{
    protected $table = 'compras';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'proveedor_id',
        'numero_comprobante',
        'tipo_comprobante',
        'fecha_compra',
        'subtotal',
        'igv',
        'total',
        'descripcion',
        'clasificacion',
        'comprobante_archivo',
        'estado',
        'pdf_url',
        'xml_url'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Obtener todas las compras con detalles (JOIN con proveedores)
     */
    public function getComprasWithDetails()
    {
        return $this->select('
            compras.*,
            suppliers.name as proveedor_nombre,
            suppliers.ruc as proveedor_ruc,
            suppliers.phone as proveedor_telefono
        ')
            ->join('suppliers', 'suppliers.id = compras.proveedor_id', 'left')
            ->orderBy('compras.fecha_compra', 'DESC')
            ->findAll();
    }

    /**
     * Obtener compra específica con todos sus detalles
     */
    public function getCompraById($id)
    {
        return $this->select('
            compras.*,
            suppliers.name as proveedor_nombre,
            suppliers.ruc as proveedor_ruc,
            suppliers.phone as proveedor_telefono,
            suppliers.address as proveedor_direccion
        ')
            ->join('suppliers', 'suppliers.id = compras.proveedor_id', 'left')
            ->where('compras.id', $id)
            ->first();
    }

    /**
     * Obtener compras por estado
     */
    public function getComprasPorEstado($estado)
    {
        return $this->where('estado', $estado)
            ->orderBy('fecha_compra', 'DESC')
            ->findAll();
    }

    /**
     * Obtener compras por clasificación
     */
    public function getComprasPorClasificacion($clasificacion_id)
    {
        return $this->select('
            compras.*,
            suppliers.name as proveedor_nombre,
            clasificaciones_compra.nombre as tipo_clasificacion
        ')
            ->join('suppliers', 'suppliers.id = compras.proveedor_id')
            ->join('clasificaciones_compra', 'clasificaciones_compra.id = compras.clasificacion')
            ->where('compras.clasificacion', $clasificacion_id)
            ->orderBy('compras.fecha_compra', 'DESC')
            ->findAll();
    }

    /**
     * Obtener reporte de compras entre fechas
     */
    public function getReportePorFechas($fecha_inicio, $fecha_fin)
    {
        return $this->select('compras.*, suppliers.name as proveedor_nombre')
            ->join('suppliers', 'suppliers.id = compras.proveedor_id', 'left')
            ->where('compras.fecha_compra >=', $fecha_inicio)
            ->where('compras.fecha_compra <=', $fecha_fin)
            ->orderBy('compras.fecha_compra', 'DESC')
            ->findAll();
    }

    /**
     * Obtener estadísticas de compras
     */
    public function getEstadisticas()
    {
        $stats = [
            'total_compras' => $this->countAllResults(),
            'total_monto' => 0,
            'total_igv' => 0,
            'por_estado' => []
        ];

        // Total monto e IGV
        try {
            $db = \Config\Database::connect();
            $result = $db->query('SELECT SUM(total) as total, SUM(igv) as igv FROM compras')->getRow();
            $stats['total_monto'] = $result->total ?? 0;
            $stats['total_igv'] = $result->igv ?? 0;
        } catch (\Exception $e) {
            // Valores por defecto
        }

        // Por estado
        try {
            $estadoQuery = $this->selectCount('*', 'count')
                ->select('estado')
                ->groupBy('estado')
                ->get()
                ->getResultArray();

            foreach ($estadoQuery as $row) {
                $stats['por_estado'][$row['estado']] = $row['count'];
            }
        } catch (\Exception $e) {
            // Sin datos de estado
        }

        return $stats;
    }
}