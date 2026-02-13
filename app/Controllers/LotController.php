<?php

namespace App\Controllers;

use App\Models\LotModel;
use App\Models\ProjectModel;
use App\Models\ContractModel;
use CodeIgniter\Controller;

class LotController extends BaseController {
    protected $lotModel;
    protected $projectModel;
    protected $contractModel;

    public function __construct()
    {
        $this->lotModel = new LotModel();
        $this->projectModel = new ProjectModel();
        $this->contractModel = new ContractModel();
    }

    // Vista principal de lotes enlazada al menú
    public function index()
    {
        $lots = $this->lotModel->findAll();
        return view('backoffice_new/lots', ['lots' => $lots]);
    }

        // Obtener lotes disponibles de un proyecto
        public function get_project_lots($project_id)
        {
            $lots = $this->lotModel->where('project_id', $project_id)->where('status', 'available')->findAll();
            return $this->response->setJSON($lots);
        }

        // Actualizar estado de un lote
        public function update_lot_status()
        {
            $lot_id = $this->request->getPost('lot_id');
            $status = $this->request->getPost('status');
            if ($this->lotModel->update($lot_id, ['status' => $status])) {
                return $this->response->setJSON(['success' => true]);
            }
            return $this->response->setJSON(['success' => false]);
        }

        // Obtener detalles de un lote
        public function get_lot_details($lot_id)
        {
            $lot = $this->lotModel->find($lot_id);
            if (!$lot) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Lote no encontrado'
                ]);
            }
            $project = $this->projectModel->find($lot['project_id']);
            $customer = null;
            $contract = null;
            if ($lot['customer_id']) {
                $customerModel = new \App\Models\CustomerModel();
                $customer = $customerModel->find($lot['customer_id']);
                $contract = $this->contractModel->where('lot_id', $lot_id)->first();
            }
            return $this->response->setJSON([
                'success' => true,
                'lot' => $lot,
                'project' => $project,
                'customer' => $customer,
                'contract' => $contract
            ]);
        }

        // Obtener todos los lotes disponibles
        public function get_available_lots()
        {
            $lots = $this->lotModel
                ->select('lots.*, projects.name as project_name, projects.location')
                ->join('projects', 'projects.id = lots.project_id')
                ->where('lots.status', 'available')
                ->where('projects.status', 'active')
                ->findAll();
            return $this->response->setJSON(['lots' => $lots]);
        }
    

    public function create()
    {
        if (strtolower($this->request->getMethod()) === 'post') {
            $data = [
                'project_id' => $this->request->getPost('project_id'),
                'lot_number' => $this->request->getPost('lot_number'),
                'block' => $this->request->getPost('block'),
                'area_sqm' => $this->request->getPost('area_sqm'),
                'base_price' => $this->request->getPost('base_price'),
                'current_price' => $this->request->getPost('base_price'),
                'status' => 'available'
            ];
            if (empty($data['project_id']) || empty($data['lot_number']) || empty($data['area_sqm']) || empty($data['base_price'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Completa todos los campos obligatorios.'
                ]);
            }
            if ($data['area_sqm'] < 50) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'El área mínima debe ser de 50 m².'
                ]);
            }
            if ($data['base_price'] <= 0) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'El precio del lote debe ser mayor a 0.'
                ]);
            }
            if ($this->lotModel->where('project_id', $data['project_id'])->where('lot_number', $data['lot_number'])->countAllResults() > 0) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'El número de lote ya existe en el proyecto seleccionado.'
                ]);
            }
            $result = $this->lotModel->insert($data);
            $errors = $this->lotModel->errors();
            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Lote creado exitosamente.'
                ]);
            } else {
                $errorMsg = 'Error al crear el lote';
                if (!empty($errors)) {
                    $errorMsg .= ': ' . json_encode($errors, JSON_UNESCAPED_UNICODE);
                }
                return $this->response->setJSON([
                    'success' => false,
                    'message' => $errorMsg
                ]);
            }
        }
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Método no permitido',
                'debug' => [
                    'method' => $this->request->getMethod(),
                    'is_ajax' => $this->request->isAJAX(),
                    'headers' => $this->request->getServer(),
                    'post_data' => $this->request->getPost(),
                ]
            ]);
        }
        $data = [
            'title' => 'Nuevo Lote',
            'projects' => $this->projectModel->findAll(),
            'session_name' => $_SESSION['name'] ?? 'Usuario'
        ];
        return view('admin/inmueble/create_lot', $data);
    }

    public function get($lot_id)
    {
        $lot = $this->lotModel->find($lot_id);
        if ($lot) {
            return $this->response->setJSON([
                'success' => true,
                'lot' => $lot
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Lote no encontrado'
            ]);
        }
    }

    public function edit($lot_id)
    {
        if (strtolower($this->request->getMethod()) === 'post') {
            $lot = $this->lotModel->find($lot_id);
            if (!$lot) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Lote no encontrado',
                    'debug' => [ 'lot_id' => $lot_id ]
                ]);
            }
            $res = $this->request->getPost();
            if (empty($res) && $this->request->getHeaderLine('Content-Type') === 'application/json') {
                $json = $this->request->getJSON(true);
                if (is_array($json)) {
                    $res = $json;
                }
            }
            if (empty($res['project_id']) || empty($res['area_sqm']) || empty($res['base_price'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Faltan campos obligatorios',
                    'debug' => $res
                ]);
            }
            if ($res['area_sqm'] < 50) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'El área mínima debe ser de 50 m².',
                    'debug' => $res
                ]);
            }
            if ($res['base_price'] <= 0) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'El precio del lote debe ser mayor a 0.',
                    'debug' => $res
                ]);
            }
            $data = [
                'project_id' => $res['project_id'] ?? '',
                'block' => $res['block'] ?? '',
                'area_sqm' => $res['area_sqm'] ?? '',
                'base_price' => $res['base_price'] ?? '',
                'current_price' => $res['current_price'] ?? '',
                'status' => $res['status'] ?? ''
            ];
            $result = $this->lotModel->update($lot_id, $data);
            $errors = $this->lotModel->errors();
            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Lote actualizado exitosamente'
                ]);
            } else {
                $errorMsg = 'Error al actualizar el lote';
                if (!empty($errors)) {
                    $errorMsg .= ': ' . json_encode($errors, JSON_UNESCAPED_UNICODE);
                }
                return $this->response->setJSON([
                    'success' => false,
                    'message' => $errorMsg,
                    'debug' => $res
                ]);
            }
        }
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Método no permitido',
                'debug' => [
                    'method' => $this->request->getMethod(),
                    'is_ajax' => $this->request->isAJAX(),
                    'headers' => $this->request->getServer(),
                    'post_data' => $this->request->getPost(),
                ]
            ]);
        }
        return redirect()->to('/dashboard/inmueble/lots');
    }

    public function delete($lot_id)
    {
        if (strtolower($this->request->getMethod()) === 'get') {
            $lot = $this->lotModel->find($lot_id);
            if (!$lot) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Lote no encontrado',
                    'debug' => [ 'lot_id' => $lot_id ]
                ]);
            }
            $contractsCount = $this->contractModel->where('lot_id', $lot_id)->countAllResults();
            if ($contractsCount > 0) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'No se puede eliminar el lote porque tiene contratos asociados',
                    'debug' => [ 'contractsCount' => $contractsCount ]
                ]);
            }
            $result = $this->lotModel->delete($lot_id);
            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Lote eliminado exitosamente'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error al eliminar el lote'
                ]);
            }
        }
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Método no permitido',
                'debug' => [
                    'method' => $this->request->getMethod(),
                    'is_ajax' => $this->request->isAJAX(),
                    'headers' => $this->request->getServer(),
                    'get_data' => $this->request->getGet(),
                ]
            ]);
        }
        return redirect()->to('/dashboard/inmueble/lots');
    }

    public function updateStatus()
    {
        // ...método update_lot_status de Inmueble.php...
    }

    public function details($lot_id)
    {
        // ...método get_lot_details de Inmueble.php...
    }

    public function available()
    {
        // ...método get_available_lots de Inmueble.php...
    }
}