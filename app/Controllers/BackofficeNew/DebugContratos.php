<?php
namespace App\Controllers\BackofficeNew;

use App\Models\ContractModel;
use App\Models\LotModel;
use App\Models\ProjectModel;
use App\Controllers\BaseController;

class DebugContratos extends BaseController
{
    public function index()
    {
        $contractModel = new ContractModel();
        $lotModel = new LotModel();
        $projectModel = new ProjectModel();
        
        $customer_id = session()->get('client_id');
        
        echo "<pre>";
        echo "=== CONTRATOS CONTROLLER DEBUG ===\n";
        echo "customer_id: $customer_id\n\n";
        
        // Obtener contratos del cliente
        $contractsRaw = $contractModel->where('customer_id', $customer_id)->findAll();
        
        echo "Contratos encontrados: " . count($contractsRaw) . "\n";
        foreach ($contractsRaw as $c) {
            echo "\n--- Contrato ---\n";
            echo "ID: " . $c['id'] . "\n";
            echo "Number: " . $c['contract_number'] . "\n";
            echo "Lot ID: " . $c['lot_id'] . "\n";
            
            $lot = $lotModel->find($c['lot_id']);
            echo "Lot encontrado: " . ($lot ? 'SÍ' : 'NO') . "\n";
            if ($lot) {
                echo "  - lot_number: " . $lot['lot_number'] . "\n";
                echo "  - project_id: " . $lot['project_id'] . "\n";
                
                $project = $projectModel->find($lot['project_id']);
                echo "  - project encontrado: " . ($project ? 'SÍ' : 'NO') . "\n";
                if ($project) {
                    echo "    - project_name: " . $project['name'] . "\n";
                }
            } else {
                echo "ERROR: No se encontró el lote con ID: " . $c['lot_id'] . "\n";
            }
        }
        echo "\n</pre>";
    }
}
?>
