<?php

namespace App\Models;

use CodeIgniter\Model;

class GastosModel extends Model
{
    protected $table = 'compras';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'proveedor_id', 'numero_comprobante', 'tipo_comprobante', 'fecha_compra',
        'subtotal', 'igv', 'total', 'descripcion', 'clasificacion', 'estado',
        'proyecto_id', 'contrato_id', 'pdf_url', 'xml_url',
        'created_by', 'approved_by'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [
        'proveedor_id' => 'required|integer',
        'numero_comprobante' => 'required|string|max_length[50]',
        'tipo_comprobante' => 'required|in_list[Factura,Boleta]',
        'fecha_compra' => 'required|valid_date',
        'subtotal' => 'required|numeric',
        'igv' => 'numeric',
        'total' => 'required|numeric',
        'clasificacion' => 'integer'
    ];

    /**
     * Obtener todos los gastos (compras clasificadas) con detalles
     */
    public function getGastosWithDetails()
    {
        return $this->select('compras.*, suppliers.name as proveedor_nombre, suppliers.ruc')
            ->where('compras.estado !=', 'registrado')
            ->join('suppliers', 'suppliers.id = compras.proveedor_id', 'left')
            ->orderBy('compras.fecha_compra', 'DESC')
            ->findAll();
    }

    /**
     * Obtener gastos por período (para reportes contables)
     */
    public function getGastosPorPeriodo($fecha_inicio, $fecha_fin)
    {
        return $this->select('compras.*, suppliers.name as proveedor_nombre')
            ->whereBetween('DATE(compras.fecha_compra)', [$fecha_inicio, $fecha_fin])
            ->where('compras.estado !=', 'registrado')
            ->join('suppliers', 'suppliers.id = compras.proveedor_id', 'left')
            ->orderBy('compras.fecha_compra', 'DESC')
            ->findAll();
    }

    /**
     * Obtener gastos por clasificación
     * Retorna resumen de gastos agrupados por tipo
     */
    public function getGastosPorClasificacion()
    {
        return $this->selectSum('total', 'total_gasto')
            ->selectCount('id', 'cantidad')
            ->where('estado !=', 'registrado')
            ->groupBy('clasificacion')
            ->findAll();
    }

    /**
     * Obtener total de gastos por tipo (Administrativo, Ventas, etc)
     */
    public function getTotalGastosPorTipo()
    {
        $tipos = [
            1 => 'Materiales',
            2 => 'Servicios',
            3 => 'Activos',
            4 => 'Suministros',
            5 => 'Otros'
        ];

        $resultado = [];

        foreach ($tipos as $id => $nombre) {
            $datos = $this->select('COUNT(id) as cantidad, SUM(total) as monto')
                ->where('clasificacion', $id)
                ->where('estado !=', 'registrado')
                ->first();

            $resultado[] = [
                'tipo_id' => $id,
                'tipo_nombre' => $nombre,
                'cantidad' => $datos['cantidad'] ?? 0,
                'monto' => $datos['monto'] ?? 0
            ];
        }

        return $resultado;
    }

    /**
     * Obtener gastos por proyecto
     * Útil para análisis de costos por proyecto
     */
    public function getGastosPorProyecto($proyecto_id)
    {
        return $this->select('compras.*, suppliers.name as proveedor_nombre')
            ->where('compras.proyecto_id', $proyecto_id)
            ->where('compras.estado !=', 'registrado')
            ->join('suppliers', 'suppliers.id = compras.proveedor_id', 'left')
            ->orderBy('compras.fecha_compra', 'DESC')
            ->findAll();
    }

    /**
     * Obtener estadísticas de gastos
     */
    public function getEstadisticasGastos()
    {
        return [
            'total_gasto' => $this->where('estado !=', 'registrado')->selectSum('total')->first()['total'] ?? 0,
            'total_compras' => $this->where('estado !=', 'registrado')->countAllResults(),
            'compras_sin_clasificar' => $this->where('estado', 'registrado')->countAllResults(),
            'gasto_promedio' => $this->where('estado !=', 'registrado')->selectAvg('total')->first()['total'] ?? 0,
            'mayor_gasto' => $this->where('estado !=', 'registrado')->selectMax('total')->first()['total'] ?? 0,
            'menor_gasto' => $this->where('estado !=', 'registrado')->selectMin('total')->first()['total'] ?? 0
        ];
    }

    /**
     * Obtener gastos para estado de resultados
     * Agrupa gastos por mes para análisis de tendencias
     */
    public function getGastosPorMes($año = null)
    {
        $año = $año ?? date('Y');
        
        return $this->selectRaw('DATE_FORMAT(fecha_compra, "%m") as mes, SUM(total) as total_mes, COUNT(id) as cantidad')
            ->where('estado !=', 'registrado')
            ->where('YEAR(fecha_compra)', $año)
            ->groupBy('mes')
            ->orderBy('mes', 'ASC')
            ->findAll();
    }

    /**
     * Obtener gastos pendientes de aprobación
     */
    public function getGastosPendientesAprobacion()
    {
        return $this->select('compras.*, suppliers.name as proveedor_nombre')
            ->where('compras.estado', 'clasificado')
            ->where('compras.approved_by', null)
            ->join('suppliers', 'suppliers.id = compras.proveedor_id', 'left')
            ->orderBy('compras.created_at', 'ASC')
            ->findAll();
    }

    /**
     * Obtener resumen de gastos para dashboard
     */
    public function getResumenGastos()
    {
        return [
            'mes_actual' => $this->where('estado !=', 'registrado')
                ->where('MONTH(fecha_compra)', date('m'))
                ->where('YEAR(fecha_compra)', date('Y'))
                ->selectSum('total')
                ->first()['total'] ?? 0,
            
            'mes_anterior' => $this->where('estado !=', 'registrado')
                ->where('MONTH(fecha_compra)', date('m') - 1)
                ->where('YEAR(fecha_compra)', date('Y'))
                ->selectSum('total')
                ->first()['total'] ?? 0,

            'trimestre_actual' => $this->where('estado !=', 'registrado')
                ->whereBetween('fecha_compra', [
                    date('Y-m-01', strtotime('first day of this quarter')),
                    date('Y-m-t', strtotime('last day of this quarter'))
                ])
                ->selectSum('total')
                ->first()['total'] ?? 0,

            'año_actual' => $this->where('estado !=', 'registrado')
                ->where('YEAR(fecha_compra)', date('Y'))
                ->selectSum('total')
                ->first()['total'] ?? 0,

            'gasto_mayor' => $this->where('estado !=', 'registrado')
                ->orderBy('total', 'DESC')
                ->first()
        ];
    }

    /**
     * Validar gasto antes de clasificar
     */
    public function validarGasto($id)
    {
        $gasto = $this->find($id);

        if (!$gasto) {
            return [
                'valid' => false,
                'message' => 'Gasto no encontrado'
            ];
        }

        if ($gasto['estado'] !== 'registrado') {
            return [
                'valid' => false,
                'message' => 'El gasto ya ha sido clasificado'
            ];
        }

        return [
            'valid' => true,
            'message' => 'Gasto listo para clasificar',
            'gasto' => $gasto
        ];
    }
}
