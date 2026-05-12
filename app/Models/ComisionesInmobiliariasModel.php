<?php
namespace App\Models;
use CodeIgniter\Model;

class ComisionesInmobiliariasModel extends Model {
    protected $table = 'comisiones_inmobiliarias';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'venta_id', 'beneficiario_id', 'tipo_comision', 'monto', 'porcentaje', 'estado', 'fecha_generada', 'created_at', 'updated_at'
    ];

    public function getComisionesConCliente() {
        return $this->select('comisiones_inmobiliarias.*, customers.name as customer_name, contracts.customer_id')
            ->join('customers', 'customers.id = comisiones_inmobiliarias.beneficiario_id', 'left')
            ->join('contracts', 'contracts.id = comisiones_inmobiliarias.venta_id', 'left')
            ->orderBy('comisiones_inmobiliarias.id', 'DESC')
            ->findAll();
    }

    public function getGananciaTotalPeriodo($agente_id, $fecha_inicio, $fecha_fin) {
        return $this->selectSum('monto')
            ->where('beneficiario_id', $agente_id)
            ->whereIn('estado', ['aprobada', 'pagada'])
            ->where('fecha_generada >=', $fecha_inicio)
            ->where('fecha_generada <=', $fecha_fin)
            ->first()['monto'] ?? 0;
    }
}
