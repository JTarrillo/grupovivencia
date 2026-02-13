<?php
namespace App\Libraries;

use App\Models\CommissionsModel;
use App\Models\CustomerModel;
use App\Models\UnilevelsModel;

class Comision
{
    protected $commissionsModel;
    protected $customerModel;
    protected $unilevelsModel;

    public function __construct()
    {
        $this->commissionsModel = new CommissionsModel();
        $this->customerModel = new CustomerModel();
        $this->unilevelsModel = new UnilevelsModel();
    }

    /**
     * Obtiene todas las comisiones con datos de agente y tipo de comisión para la vista
     */
    public function getComisionesInmobiliarias()
    {
        $comisiones = $this->commissionsModel->orderBy('created_at', 'DESC')->findAll();
        $resultado = [];
        foreach ($comisiones as $c) {
            $agente = $this->customerModel->find($c['customer_id']);
            $item = [
                'id' => $c['id'],
                'created_at' => $c['created_at'],
                'amount' => $c['amount'],
                'type' => $c['type'],
                'status' => $c['status'],
                'contrato_id' => $c['contrato_id'] ?? null,
                'lote_id' => $c['lote_id'] ?? null,
                'agente_nombre' => $agente['name'] . ' ' . ($agente['lastname'] ?? ''),
                'agente_email' => $agente['email'] ?? '',
                'tipo_agente' => $agente['tipo_agente'] ?? '',
                'inscripcion_vigencia' => $agente['inscripcion_vigencia'] ?? null
            ];
            $resultado[] = $item;
        }
        return $resultado;
    }
}
