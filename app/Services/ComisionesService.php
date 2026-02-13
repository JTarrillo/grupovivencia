<?php
namespace App\Services;

use App\Models\CommissionsModel;
use App\Models\UnilevelsModel;
use App\Models\CustomerModel;

class ComisionesService
{
    /**
     * Calcula y registra las comisiones multinivel para una venta/contrato.
     * @param int $customer_id El ID del afiliado que realizó la compra/contrato
     * @param float $monto_compra El monto de la compra/contrato
     * @param string $tipo_agente 'interno' o 'externo'
     * @param int|null $contrato_id ID del contrato (opcional)
     */
    public function asignarComisiones($customer_id, $monto_compra, $tipo_agente, $contrato_id = null)
    {
        $unilevelModel = new UnilevelsModel();
        $commissionsModel = new CommissionsModel();
        $customerModel = new CustomerModel();

        // Comisión de Venta Base
        $porcentaje_base = $tipo_agente === 'externo' ? 0.05 : 0.02;
        $commissionsModel->insert([
            'customer_id' => $customer_id,
            'amount' => $monto_compra * $porcentaje_base,
            'type' => 'venta_base',
            'status' => 'pendiente',
            'contrato_id' => $contrato_id,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        // Nivel 1
        $nivel1 = $unilevelModel->where('customer_id', $customer_id)->first();
        $sponsor_id_nivel1 = $nivel1 ? $nivel1['sponsor_id'] : null;
        if ($sponsor_id_nivel1) {
            $patrocinador = $customerModel->find($sponsor_id_nivel1);
            if ($patrocinador && ($patrocinador['estado_renovacion'] === 'vigente' || $patrocinador['tipo_agente'] === 'interno')) {
                $commissionsModel->insert([
                    'customer_id' => $sponsor_id_nivel1,
                    'amount' => $monto_compra * 0.04,
                    'type' => 'nivel1',
                    'status' => 'pendiente',
                    'contrato_id' => $contrato_id,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
        }

        // Nivel 2
        $sponsor_id_nivel2 = null;
        if ($sponsor_id_nivel1) {
            $nivel2 = $unilevelModel->where('customer_id', $sponsor_id_nivel1)->first();
            $sponsor_id_nivel2 = $nivel2 ? $nivel2['sponsor_id'] : null;
            if ($sponsor_id_nivel2) {
                $patrocinador2 = $customerModel->find($sponsor_id_nivel2);
                if ($patrocinador2 && ($patrocinador2['estado_renovacion'] === 'vigente' || $patrocinador2['tipo_agente'] === 'interno')) {
                    $commissionsModel->insert([
                        'customer_id' => $sponsor_id_nivel2,
                        'amount' => $monto_compra * 0.01,
                        'type' => 'nivel2',
                        'status' => 'pendiente',
                        'contrato_id' => $contrato_id,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }
        }
    }
}