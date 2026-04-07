<?php

namespace App\Models;

use CodeIgniter\Model;

class GastosModel extends Model
{
    protected $table = 'compras';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'proveedor_id', 'numero_comprobante', 'tipo_comprobante', 'fecha_compra',
        'subtotal', 'igv', 'total', 'descripcion', 'clasificacion', 'estado',
        'proyecto_id', 'contrato_id', 'pdf_url', 'xml_url',
        'created_by', 'approved_by'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Obtener todos los gastos (compras clasificadas) con detalles
     */
    public function getGastosWithDetails()
    {
        $db = db_connect();
        $query = $db->query("
            SELECT 
                c.id, c.numero_comprobante, c.tipo_comprobante, c.fecha_compra,
                c.subtotal, c.igv, c.total, c.estado, c.clasificacion,
                s.name as proveedor_nombre, s.ruc
            FROM compras c
            LEFT JOIN suppliers s ON s.id = c.proveedor_id
            WHERE c.estado != 'registrado'
            ORDER BY c.fecha_compra DESC
        ");
        return $query->getResultArray();
    }

    /**
     * Obtener gastos por período (para reportes contables)
     */
    public function getGastosPorPeriodo($fecha_inicio, $fecha_fin)
    {
        $db = db_connect();
        $query = $db->query("
            SELECT 
                c.id, c.numero_comprobante, c.tipo_comprobante, c.fecha_compra,
                c.subtotal, c.igv, c.total, c.estado, c.clasificacion,
                s.name as proveedor_nombre
            FROM compras c
            LEFT JOIN suppliers s ON s.id = c.proveedor_id
            WHERE DATE(c.fecha_compra) >= ? AND DATE(c.fecha_compra) <= ?
            AND c.estado != 'registrado'
            ORDER BY c.fecha_compra DESC
        ", [$fecha_inicio, $fecha_fin]);
        return $query->getResultArray();
    }

    /**
     * Obtener gastos por clasificación
     */
    public function getGastosPorClasificacion()
    {
        $db = db_connect();
        $query = $db->query("
            SELECT 
                clasificacion, 
                COUNT(id) as cantidad, 
                SUM(total) as total_gasto
            FROM compras
            WHERE estado != 'registrado'
            GROUP BY clasificacion
        ");
        return $query->getResultArray();
    }

    /**
     * Obtener total de gastos por tipo
     */
    public function getTotalGastosPorTipo()
    {
        $db = db_connect();
        $query = $db->query("
            SELECT 
                clasificacion, 
                COUNT(id) as cantidad, 
                SUM(total) as monto
            FROM compras
            WHERE estado != 'registrado'
            GROUP BY clasificacion
        ");
        return $query->getResultArray();
    }

    /**
     * Obtener estadísticas de gastos
     */
    public function getEstadisticasGastos()
    {
        $db = db_connect();
        $query = $db->query("
            SELECT 
                COUNT(id) as total_compras,
                SUM(total) as total_gasto,
                AVG(total) as gasto_promedio,
                MAX(total) as mayor_gasto,
                MIN(total) as menor_gasto
            FROM compras
            WHERE estado != 'registrado'
        ");
        $stats = $query->getRow();
        
        $query2 = $db->query("SELECT COUNT(id) as sin_clasificar FROM compras WHERE estado = 'registrado'");
        $sin_clasificar = $query2->getRow();

        return [
            'total_gasto' => $stats->total_gasto ?? 0,
            'total_compras' => $stats->total_compras ?? 0,
            'compras_sin_clasificar' => $sin_clasificar->sin_clasificar ?? 0,
            'gasto_promedio' => $stats->gasto_promedio ?? 0,
            'mayor_gasto' => $stats->mayor_gasto ?? 0,
            'menor_gasto' => $stats->menor_gasto ?? 0
        ];
    }

    /**
     * Obtener gastos por mes
     */
    public function getGastosPorMes($año = null)
    {
        $año = $año ?? date('Y');
        $db = db_connect();
        $query = $db->query("
            SELECT 
                DATE_FORMAT(fecha_compra, '%m') as mes, 
                SUM(total) as total_mes, 
                COUNT(id) as cantidad
            FROM compras
            WHERE estado != 'registrado' AND YEAR(fecha_compra) = ?
            GROUP BY DATE_FORMAT(fecha_compra, '%m')
            ORDER BY mes ASC
        ", [$año]);
        return $query->getResultArray();
    }

    /**
     * Obtener resumen de gastos para dashboard
     */
    public function getResumenGastos()
    {
        $db = db_connect();
        
        $mes_actual = $db->query("
            SELECT COALESCE(SUM(total), 0) as total FROM compras
            WHERE estado != 'registrado' 
            AND MONTH(fecha_compra) = MONTH(NOW())
            AND YEAR(fecha_compra) = YEAR(NOW())
        ")->getRow();

        $mes_anterior = $db->query("
            SELECT COALESCE(SUM(total), 0) as total FROM compras
            WHERE estado != 'registrado' 
            AND MONTH(fecha_compra) = MONTH(DATE_SUB(NOW(), INTERVAL 1 MONTH))
            AND YEAR(fecha_compra) = YEAR(DATE_SUB(NOW(), INTERVAL 1 MONTH))
        ")->getRow();

        $trimestre_actual = $db->query("
            SELECT COALESCE(SUM(total), 0) as total FROM compras
            WHERE estado != 'registrado' 
            AND QUARTER(fecha_compra) = QUARTER(NOW())
            AND YEAR(fecha_compra) = YEAR(NOW())
        ")->getRow();

        return [
            'mes_actual' => $mes_actual->total ?? 0,
            'mes_anterior' => $mes_anterior->total ?? 0,
            'trimestre_actual' => $trimestre_actual->total ?? 0
        ];
    }
}

