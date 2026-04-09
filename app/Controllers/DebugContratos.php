<?php
namespace App\Controllers;

class DebugContratos extends BaseController
{
    public function index()
    {
        echo "<pre>";
        echo "=== DEBUG SESIÓN ===\n";
        $session = session();
        echo "client_id: " . $session->get('client_id') . "\n";
        echo "client_name: " . $session->get('client_name') . "\n";
        echo "client_dni: " . $session->get('client_dni') . "\n";
        echo "client_isLoggedIn: " . $session->get('client_isLoggedIn') . "\n";
        
        $id = $session->get('client_id');
        echo "\n=== BÚSQUEDA DE CONTRATOS ===\n";
        echo "Buscando contratos donde customer_id = $id\n\n";
        
        $db = \Config\Database::connect();
        
        // Query directa
        $result = $db->query("SELECT id, contract_number, customer_id, sponsor_id, status FROM contracts WHERE customer_id = $id");
        $contracts = $result->getResultArray();
        
        echo "Resultados encontrados: " . count($contracts) . "\n";
        foreach ($contracts as $contract) {
            echo "- ID: " . $contract['id'];
            echo " | Number: " . $contract['contract_number'];
            echo " | Customer: " . $contract['customer_id'];
            echo " | Sponsor: " . $contract['sponsor_id'];
            echo " | Status: " . $contract['status'];
            echo "\n";
        }
        
        echo "\n=== CONTRATO ESPECÍFICO ===\n";
        $specific = $db->query("SELECT * FROM contracts WHERE id = 200")->getRow();
        if ($specific) {
            echo "Contrato 200 encontrado:\n";
            echo "- customer_id: " . $specific->customer_id . "\n";
            echo "- status: " . $specific->status . "\n";
            echo "- contract_number: " . $specific->contract_number . "\n";
        }
        
        echo "</pre>";
    }
}
?>
