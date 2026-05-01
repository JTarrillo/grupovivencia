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

        try {
            // LOGUEAR TODO LO QUE LLEGA
            $contentType = $this->request->getHeaderLine('Content-Type');
            log_message('info', '=== VIVELAND GUARDAR_REGISTRO ===');
            log_message('info', 'Content-Type: ' . $contentType);
            log_message('info', 'Method: ' . $this->request->getMethod());
            
            // Detectar si es JSON o FormData
            if (strpos($contentType, 'application/json') !== false) {
                // Datos JSON (desde formulario rápido)
                $json = $this->request->getJSON(true);
                log_message('info', 'JSON recibido: ' . json_encode($json));
                $rawData = [
                    'nombre' => $json['nombre'] ?? null,
                    'email' => $json['email'] ?? null,
                    'telefono' => $json['telefono'] ?? null,
                    'zona' => $json['zona'] ?? null,
                    'interes' => $json['interes'] ?? null
                ];
            } else {
                // FormData (desde formulario principal)
                log_message('info', 'FormData recibido');
                $rawData = [
                    'nombre' => $this->request->getPost('nombre'),
                    'email' => $this->request->getPost('email'),
                    'telefono' => $this->request->getPost('telefono'),
                    'zona' => $this->request->getPost('zona'),
                    'interes' => $this->request->getPost('interes')
                ];
            }
            
            log_message('info', 'Datos crudos: ' . json_encode($rawData));

            // Validar datos
            if (!$this->validate([
                'nombre' => 'required|min_length[3]|max_length[100]',
                'email' => 'required|valid_email|max_length[120]',
                'telefono' => 'required|max_length[20]',
                'zona' => 'required|in_list[Zona Viveland,Zona VIP,Zona Platinum,Zona General]',
                'interes' => 'required|max_length[100]'
            ], $rawData)) {
                $errors = $this->validator->getErrors();
                log_message('error', 'Validación fallida: ' . json_encode($errors));
                return $this->response->setStatusCode(422)->setJSON([
                    'error' => 'Validación fallida',
                    'errors' => $errors
                ]);
            }

            // Preparar datos para inserción
            $data = [
                'nombre' => trim($rawData['nombre']),
                'email' => trim($rawData['email']),
                'telefono' => trim($rawData['telefono']),
                'zona' => trim($rawData['zona']),
                'interes' => trim($rawData['interes']),
                'estado' => 'pendiente'
            ];

            log_message('info', '✅ Validación OK - Datos a guardar: ' . json_encode($data));

            // Guardar en BD
            $registroModel = new VivelandRegistroModel();
            $id = $registroModel->insert($data);

            if ($id) {
                log_message('info', '✅ Registro guardado con ID: ' . $id . ' - Datos: ' . json_encode($data));

                return $this->response->setJSON([
                    'success' => true,
                    'message' => '¡Registro exitoso! Pronto nos pondremos en contacto.',
                    'id' => $id
                ]);
            } else {
                $error = $registroModel->errors();
                log_message('error', 'Error en insert - Errors: ' . json_encode($error) . ' - rawData: ' . json_encode($data));
                
                return $this->response->setStatusCode(500)->setJSON([
                    'success' => false,
                    'error' => 'Error al guardar el registro',
                    'details' => $error
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', '❌ EXCEPCIÓN en VivelandController::guardar_registro - ' . $e->getMessage() . ' - Stack: ' . $e->getTraceAsString());
            
            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'Error interno del servidor: ' . $e->getMessage()
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
