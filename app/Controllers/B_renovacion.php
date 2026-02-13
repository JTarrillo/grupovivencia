<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\CustomerModel;

class B_renovacion extends Controller
{
    public function index()
    {
        // Obtener el usuario logueado desde la sesión
        $id = $_SESSION['id'];
        $model = new CustomerModel();
        $user = $model->find($id);
        $obj_customer = $model->get_search_by_id($id);
        // Forzar tipo_agente a 'interno' si está vacío o null
        $tipo_agente = isset($user['tipo_agente']) && !empty($user['tipo_agente']) ? $user['tipo_agente'] : 'interno';
        $data = [
            'estado_renovacion' => $user['estado_renovacion'],
            'fecha_renovacion' => $user['fecha_renovacion'],
            'tipo_agente' => $tipo_agente,
            'obj_customer' => $obj_customer,
        ];
        return view('backoffice_new/renovacion', $data);
    }

    public function pagar()
    {
        // Obtener el usuario logueado desde la sesión
        $id = $_SESSION['id'];
        $model = new CustomerModel();
        $user = $model->find($id);

        // Validar solo estado vencido
        if ($user['estado_renovacion'] !== 'vencido') {
            return $this->response->setJSON(['status' => 'error', 'msg' => 'No autorizado']);
        }

        // Aquí iría la lógica de cobro (integración con pasarela, etc)
        // Si el pago es exitoso:
        $model->update($id, [
            'fecha_renovacion' => date('Y-m-d'),
            'estado_renovacion' => 'vigente',
        ]);
        return $this->response->setJSON(['status' => 'ok', 'msg' => 'Renovación exitosa']);
    }
}