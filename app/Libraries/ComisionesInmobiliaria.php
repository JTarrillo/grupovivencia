<?php
namespace App\Libraries;

use App\Models\CommissionsModel;
use App\Models\UnilevelsModel;
use App\Models\CustomerModel;

class ComisionesInmobiliaria
{
    protected $commissionsModel;
    protected $unilevelsModel;
    protected $customerModel;

    public function __construct()
    {
        $this->commissionsModel = new CommissionsModel();
        $this->unilevelsModel = new UnilevelsModel();
        $this->customerModel = new CustomerModel();
    }

    /**
     * Bono de Reserva: S/300 al patrocinador directo si la reserva es >= S/1000
     */
    public function bonoReserva($customer_id, $monto_reserva)
    {
        if ($monto_reserva >= 1000) {
            $nivel1 = $this->unilevelsModel->where('customer_id', $customer_id)->first();
            $sponsor_id = $nivel1 ? $nivel1['sponsor_id'] : null;
            if ($sponsor_id) {
                $this->commissionsModel->insert([
                    'customer_id' => $sponsor_id,
                    'amount' => 300,
                    'type' => 'bono_reserva',
                    'status' => 'pendiente',
                    'created_at' => date('Y-m-d H:i:s'),
                    'notes' => 'Bono de reserva por cliente ID ' . $customer_id
                ]);
            }
        }
    }

    /**
     * Comisión Base de Venta: 5% (externo) o 2% (interno) al agente que vende
     */
    public function comisionBaseVenta($vendedor_id, $monto, $tipo_agente, $contrato_id = null)
    {
        $porcentaje = ($tipo_agente === 'externo') ? 0.05 : 0.02;
        $this->commissionsModel->insert([
            'customer_id' => $vendedor_id,
            'amount' => $monto * $porcentaje,
            'type' => 'venta_base',
            'status' => 'pendiente',
            'contrato_id' => $contrato_id,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Comisión Multinivel: 4% al patrocinador directo, 1% al patrocinador del patrocinador
     */
    public function comisionesMultinivel($customer_id, $monto, $contrato_id = null)
    {
        // Nivel 1
        $nivel1 = $this->unilevelsModel->where('customer_id', $customer_id)->first();
        $sponsor_id_nivel1 = $nivel1 ? $nivel1['sponsor_id'] : null;
        if ($sponsor_id_nivel1) {
            $this->commissionsModel->insert([
                'customer_id' => $sponsor_id_nivel1,
                'amount' => $monto * 0.04,
                'type' => 'comision_nivel_1',
                'status' => 'pendiente',
                'contrato_id' => $contrato_id,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
        // Nivel 2
        $nivel2 = $sponsor_id_nivel1 ? $this->unilevelsModel->where('customer_id', $sponsor_id_nivel1)->first() : null;
        $sponsor_id_nivel2 = $nivel2 ? $nivel2['sponsor_id'] : null;
        if ($sponsor_id_nivel2) {
            $this->commissionsModel->insert([
                'customer_id' => $sponsor_id_nivel2,
                'amount' => $monto * 0.01,
                'type' => 'comision_nivel_2',
                'status' => 'pendiente',
                'contrato_id' => $contrato_id,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
    }

    /**
     * Verifica si el agente externo tiene inscripción anual vigente
     */
    public function agenteExternoVigente($agente_id)
    {
        $agente = $this->customerModel->find($agente_id);
        if ($agente && $agente['tipo_agente'] === 'externo') {
            $fecha_vencimiento = $agente['inscripcion_vigencia'] ?? null;
            if ($fecha_vencimiento && strtotime($fecha_vencimiento) >= strtotime(date('Y-m-d'))) {
                return true;
            }
            return false;
        }
        return true; // Si es interno, siempre vigente
    }
}
