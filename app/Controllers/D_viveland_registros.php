<?php

namespace App\Controllers;

use App\Models\VivelandRegistroModel;

class D_viveland_registros extends BaseController
{
    protected $registroModel;

    public function __construct()
    {
        $this->registroModel = new VivelandRegistroModel();
    }

    // Listar todos los registros
    public function index()
    {
        try {
            // Verificar sesión
            $id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
            
            if (isset($_SESSION['first_name']) && isset($_SESSION['last_name'])) {
                $session_name = $_SESSION['first_name'] . " " . $_SESSION['last_name'];
            } elseif (isset($_SESSION['name'])) {
                $session_name = $_SESSION['name'];
            } else {
                $session_name = 'Usuario';
            }

            // Obtener filtros de búsqueda
            $filters = [
                'estado' => $this->request->getGet('estado') ?? '',
                'search' => $this->request->getGet('search') ?? ''
            ];

            // Validar que el modelo tenga métodos requeridos
            if (!method_exists($this->registroModel, 'get_all')) {
                throw new \Exception('Método get_all no existe en VivelandRegistroModel');
            }

            if (!method_exists($this->registroModel, 'get_stats')) {
                throw new \Exception('Método get_stats no existe en VivelandRegistroModel');
            }

            // Obtener registros
            $registros = $this->registroModel->get_all($filters);
            
            // Obtener estadísticas
            $stats = $this->registroModel->get_stats();

            // Preparar datos para la vista
            $data = [
                'registros' => $registros,
                'stats' => $stats,
                'session_name' => $session_name,
                'filtros' => $filters
            ];

            return view('admin/viveland_registros/list', $data);
        } catch (\Throwable $e) {
            // Log del error
            log_message('error', 'D_viveland_registros::index ERROR: ' . $e->getMessage());
            log_message('error', 'Stack trace: ' . $e->getTraceAsString());
            
            // Retornar error más descriptivo
            $errorMsg = 'Error al cargar registros VIVELAND: ' . $e->getMessage();
            return view('errors/html', ['message' => $errorMsg, 'exception' => $e], ['status_code' => 500]);
        }
    }

    // Ver detalle de un registro
    public function view($id)
    {
        try {
            if (!$id || !is_numeric($id)) {
                throw new \Exception('ID de registro inválido');
            }

            $registro = $this->registroModel->get_by_id($id);

            if (!$registro) {
                return redirect()->to('admin/viveland_registros')->with('error', 'Registro no encontrado');
            }

            if (isset($_SESSION['first_name']) && isset($_SESSION['last_name'])) {
                $session_name = $_SESSION['first_name'] . " " . $_SESSION['last_name'];
            } elseif (isset($_SESSION['name'])) {
                $session_name = $_SESSION['name'];
            } else {
                $session_name = 'Usuario';
            }

            $data = [
                'registro' => $registro,
                'session_name' => $session_name
            ];

            return view('admin/viveland_registros/view', $data);
        } catch (\Throwable $e) {
            log_message('error', 'D_viveland_registros::view ERROR: ' . $e->getMessage());
            return view('errors/html', ['message' => 'Error al cargar el registro: ' . $e->getMessage(), 'exception' => $e], ['status_code' => 500]);
        }
    }

    // Confirmar registro
    public function confirmar($id)
    {
        $registro = $this->registroModel->get_by_id($id);

        if (!$registro) {
            return $this->response->setJSON(['success' => false, 'message' => 'Registro no encontrado']);
        }

        $this->registroModel->confirmar_registro($id);

        return $this->response->setJSON(['success' => true, 'message' => 'Registro confirmado correctamente']);
    }

    // Cambiar estado de registro
    public function cambiar_estado($id, $estado)
    {
        $estados_permitidos = ['pendiente', 'confirmado', 'cancelado'];

        if (!in_array($estado, $estados_permitidos)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Estado no válido']);
        }

        $registro = $this->registroModel->get_by_id($id);

        if (!$registro) {
            return $this->response->setJSON(['success' => false, 'message' => 'Registro no encontrado']);
        }

        $this->registroModel->update_estado($id, $estado);

        return $this->response->setJSON(['success' => true, 'message' => 'Estado actualizado correctamente']);
    }

    // Eliminar registro
    public function eliminar($id)
    {
        $registro = $this->registroModel->get_by_id($id);

        if (!$registro) {
            return $this->response->setJSON(['success' => false, 'message' => 'Registro no encontrado']);
        }

        $deleted = $this->registroModel->eliminar_registro($id);

        if (!$deleted) {
            return $this->response->setJSON(['success' => false, 'message' => 'No se pudo eliminar el registro']);
        }

        return $this->response->setJSON(['success' => true, 'message' => 'Registro eliminado correctamente']);
    }

    // Exportar registros a CSV
    public function exportar()
    {
        $registros = $this->registroModel->get_all();

        // Crear CSV
        $filename = 'viveland_registros_' . date('Y-m-d_H-i-s') . '.csv';
        $delimiter = ',';

        header('Content-Description: File Transfer');
        header('Content-Type: application/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        $output = fopen('php://output', 'w');

        // Encabezados
        fputcsv($output, [
            'ID',
            'Nombre',
            'Email',
            'Teléfono',
            'Ciudad',
            'Interés',
            'Mensaje',
            'Estado',
            'Fecha Registro',
            'Fecha Confirmación'
        ], $delimiter);

        // Datos
        foreach ($registros as $row) {
            fputcsv($output, [
                $row['id'],
                $row['nombre'],
                $row['email'],
                $row['telefono'],
                $row['ciudad'],
                $row['interes'],
                $row['mensaje'],
                $row['estado'],
                $row['fecha_registro'],
                $row['fecha_confirmacion']
            ], $delimiter);
        }

        fclose($output);
        exit;
    }
}