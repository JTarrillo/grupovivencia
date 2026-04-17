<?php

namespace App\Controllers;

use App\Models\VivelandRegistroModel;

class VivelandController extends BaseController
{
    /**
     * Mostrar página VIVELAND con formulario
     */
    public function index()
    {
        return view('landing/viveland_new');
    }

    /**
     * Guardar registro de participante
     */
    public function guardar_registro()
    {
        // Solo acepta POST
        if ($this->request->getMethod() !== 'post') {
            return $this->response->setStatusCode(405)->setJSON(['error' => 'Método no permitido']);
        }

        // Validar CSRF
        if (!$this->validate([
            'nombre' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|max_length[120]',
            'telefono' => 'permit_empty|max_length[20]',
            'ciudad' => 'permit_empty|max_length[80]',
            'interes' => 'permit_empty|max_length[100]',
            'mensaje' => 'permit_empty|max_length[1000]'
        ])) {
            return $this->response->setStatusCode(422)->setJSON([
                'error' => 'Validación fallida',
                'errors' => $this->validator->getErrors()
            ]);
        }

        try {
            // Obtener datos del formulario
            $data = [
                'nombre' => $this->request->getPost('nombre'),
                'email' => $this->request->getPost('email'),
                'telefono' => $this->request->getPost('telefono'),
                'ciudad' => $this->request->getPost('ciudad'),
                'interes' => $this->request->getPost('interes'),
                'mensaje' => $this->request->getPost('mensaje'),
                'estado' => 'pendiente'
            ];

            // Guardar en BD
            $registroModel = new VivelandRegistroModel();
            $id = $registroModel->insert($data);

            if ($id) {
                // Enviar email de confirmación (opcional)
                // $this->enviar_email_confirmacion($data['email'], $data['nombre']);

                return $this->response->setJSON([
                    'success' => true,
                    'message' => '¡Registro exitoso! Pronto nos pondremos en contacto.',
                    'id' => $id
                ]);
            } else {
                return $this->response->setStatusCode(500)->setJSON([
                    'error' => 'Error al guardar el registro. Intenta más tarde.'
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error en VivelandController::guardar_registro - ' . $e->getMessage());
            
            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'Error interno del servidor'
            ]);
        }
    }

    /**
     * Obtener registros (si es admin/dashboard)
     */
    public function obtener_registros()
    {
        // Solo para usuarios autenticados (agregar filter si es necesario)
        $registroModel = new VivelandRegistroModel();
        $registros = $registroModel->findAll();

        return $this->response->setJSON([
            'success' => true,
            'data' => $registros,
            'total' => count($registros)
        ]);
    }
}
