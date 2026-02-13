<?php

namespace App\Controllers;

use App\Models\ProjectModel;
use App\Models\LotModel;
use App\Models\ContractModel;
use CodeIgniter\Controller;

class ProjectController extends BaseController {
    // Vista principal de proyectos enlazada al menú
    protected $projectModel;
    protected $lotModel;
    protected $contractModel;

    public function __construct()
    {
        $this->projectModel = new ProjectModel();
        $this->lotModel = new LotModel();
        $this->contractModel = new ContractModel();
    }

    public function create()
    {
        if (strtolower($this->request->getMethod()) === 'post') {
            log_message('error', 'DEBUG: Entró a create_project POST');
            $data = [
                'name' => $this->request->getPost('name'),
                'code' => $this->request->getPost('code'),
                'location' => $this->request->getPost('location'),
                'description' => $this->request->getPost('description'),
                'base_price_per_sqm' => $this->request->getPost('base_price_per_sqm'),
                'min_down_payment_percentage' => $this->request->getPost('min_down_payment_percentage') ?: 15.00,
                'max_financing_months' => $this->request->getPost('max_financing_months') ?: 36,
                'base_interest_rate' => $this->request->getPost('base_interest_rate'),
                'status' => $this->request->getPost('status') ?: 'planning',
                'total_lots' => 0,
                'available_lots' => 0
            ];
            if (empty($data['name']) || empty($data['code']) || empty($data['location'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Completa los campos obligatorios.'
                ]);
            }
            if ($data['base_interest_rate'] < 2 || $data['base_interest_rate'] > 6) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'La tasa de interés debe estar entre 2% y 6%.'
                ]);
            }
            if ($data['base_price_per_sqm'] <= 0) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'El precio por m² debe ser mayor a 0.'
                ]);
            }
            if ($this->projectModel->where('code', $data['code'])->countAllResults() > 0) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'El código ya existe, ingresa uno diferente.'
                ]);
            }
            $result = $this->projectModel->insert($data);
            $errors = $this->projectModel->errors();
            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Proyecto creado exitosamente.'
                ]);
            } else {
                $errorMsg = 'Error al crear el proyecto';
                if (!empty($errors)) {
                    $errorMsg .= ': ' . json_encode($errors, JSON_UNESCAPED_UNICODE);
                }
                return $this->response->setJSON([
                    'success' => false,
                    'message' => $errorMsg
                ]);
            }
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error inesperado al crear el proyecto.'
            ]);
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
    return redirect()->to('/dashboard/project');
    }

    public function index()
    {
        $data = [
            'title' => 'Proyectos Inmobiliarios',
            'projects' => $this->projectModel->findAll(),
            'session_name' => $_SESSION['name'] ?? 'Usuario'
        ];
        $txtMsg = date('Y-m-d H:i:s') . "\n";
        $txtMsg .= "Acceso a projects()\n";
        $txtMsg .= "Datos enviados a la vista: " . json_encode($data, JSON_UNESCAPED_UNICODE) . "\n";
        $txtMsg .= str_repeat('-', 40) . "\n";
        file_put_contents(FCPATH . 'prueba_modal_mensaje.txt', $txtMsg, FILE_APPEND);
    return view('admin/proyectos/projects', $data);
    }

    public function get($project_id)
    {
        $project = $this->projectModel->find($project_id);
        if ($project) {
            return $this->response->setJSON([
                'success' => true,
                'project' => $project
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Proyecto no encontrado'
            ]);
        }
    }

    public function edit($project_id)
    {
        if ($this->request->isAJAX()) {
            $project = $this->projectModel->find($project_id);
            if (!$project) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Proyecto no encontrado'
                ]);
                exit();
            }
            $res = service('request')->getPost();
            $data = [
                'name' => $res['name'] ?? '',
                'code' => $res['code'] ?? '',
                'location' => $res['location'] ?? '',
                'description' => $res['description'] ?? '',
                'base_price_per_sqm' => $res['base_price_per_sqm'] ?? '',
                'min_down_payment_percentage' => $res['min_down_payment_percentage'] ?? '',
                'max_financing_months' => $res['max_financing_months'] ?? '',
                'base_interest_rate' => $res['base_interest_rate'] ?? '',
                'status' => $res['status'] ?? ''
            ];
            log_message('debug', 'Datos recibidos en edit_project: ' . json_encode($data, JSON_UNESCAPED_UNICODE));
            $result = $this->projectModel->update($project_id, $data);
            $errors = $this->projectModel->errors();
            log_message('debug', 'Errores del modelo en edit_project: ' . json_encode($errors, JSON_UNESCAPED_UNICODE));
            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Proyecto actualizado exitosamente'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Error al actualizar el proyecto',
                    'errors' => $errors
                ]);
            }
            exit();
        } else {
            return redirect()->to('/dashboard/project');
        }
    }

    public function delete($project_id)
    {
        $project = $this->projectModel->find($project_id);
        if ($this->request->isAJAX()) {
            if (!$project) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Proyecto no encontrado'
                ]);
                exit();
            }
            $lotsCount = $this->lotModel->where('project_id', $project_id)->countAllResults();
            if ($lotsCount > 0) {
                echo json_encode([
                    'success' => false,
                    'message' => 'No se puede eliminar el proyecto porque tiene ' . $lotsCount . ' lotes asociados'
                ]);
                exit();
            }
            $result = $this->projectModel->delete($project_id);
            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Proyecto eliminado exitosamente'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Error al eliminar el proyecto'
                ]);
            }
            exit();
        } else {
            if (!$project) {
                return redirect()->to('/dashboard/project')->with('error', 'Proyecto no encontrado');
            }
            $lotsCount = $this->lotModel->where('project_id', $project_id)->countAllResults();
            if ($lotsCount > 0) {
                return redirect()->to('/dashboard/project')->with('error', 'No se puede eliminar el proyecto porque tiene ' . $lotsCount . ' lotes asociados');
            }
            if ($this->projectModel->delete($project_id)) {
                return redirect()->to('/dashboard/project')->with('success', 'Proyecto eliminado exitosamente');
            } else {
                return redirect()->to('/dashboard/project')->with('error', 'Error al eliminar el proyecto');
            }
        }
    }

    public function api()
    {
        $projects = $this->projectModel
            ->where('status !=', 'suspended')
            ->findAll();
        return $this->response->setJSON(['projects' => $projects]);
    }
}