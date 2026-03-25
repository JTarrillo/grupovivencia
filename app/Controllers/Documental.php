<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ArchivoDigitalModel;
use App\Models\RequerimientoModel;
use App\Models\DocumentoModel;

class Documental extends BaseController
{
    protected $archivoDigitalModel;
    protected $requerimientoModel;
    protected $documentoModel;

    public function __construct()
    {
        $this->archivoDigitalModel = new ArchivoDigitalModel();
        $this->requerimientoModel = new RequerimientoModel();
        $this->documentoModel = new DocumentoModel();
    }

    public function archivos()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->route('dashboard/panel');
        }

        $archivos = $this->archivoDigitalModel
            ->orderBy('fecha_subida', 'DESC')
            ->findAll();

        return view('admin/documental/archivos', [
            'archivos' => $archivos
        ]);
    }

    public function subir_archivo()
    {
        $request = \Config\Services::request();

        if ($request->getMethod() === 'post') {
            $file = $request->getFile('archivo');

            if ($file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(WRITEPATH . 'uploads/documentos', $newName);

                $data = [
                    'nombre_original' => $file->getClientName(),
                    'nombre_almacenado' => $newName,
                    'tipo_documento' => $request->getPost('tipo_documento'),
                    'tamaño' => $file->getSize(),
                    'ruta_archivo' => WRITEPATH . 'uploads/documentos/' . $newName,
                    'contrato_id' => $request->getPost('contrato_id'),
                    'cliente_id' => $request->getPost('cliente_id'),
                    'descripcion' => $request->getPost('descripcion'),
                    'fecha_subida' => date('Y-m-d H:i:s'),
                    'usuario_id' => session()->get('id'),
                    'estado' => 'activo'
                ];

                $this->archivoDigitalModel->insert($data);
                return redirect()->to('/admin/documental/archivos')->with('success', 'Archivo subido correctamente');
            }
        }

        return view('admin/documental/subir_archivo');
    }

    /**
     * Descargar archivo
     */
    public function descargar_archivo($id)
    {
        $archivo = $this->archivoDigitalModel->find($id);

        if (!$archivo || !file_exists($archivo['ruta_archivo'])) {
            return redirect()->to('/admin/documental/archivos')->with('error', 'Archivo no encontrado');
        }

        return $this->response->download($archivo['ruta_archivo'], $archivo['nombre_original']);
    }

    /**
     * Eliminar archivo
     */
    public function eliminar_archivo($id)
    {
        $archivo = $this->archivoDigitalModel->find($id);

        if ($archivo && file_exists($archivo['ruta_archivo'])) {
            unlink($archivo['ruta_archivo']);
        }

        $this->archivoDigitalModel->delete($id);
        return redirect()->to('/admin/documental/archivos')->with('success', 'Archivo eliminado correctamente');
    }

    /**
     * Gestión de requerimientos
     */
    public function requerimientos()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->route('dashboard/panel');
        }

        $requerimientos = $this->requerimientoModel
            ->orderBy('fecha_creacion', 'DESC')
            ->findAll();

        return view('admin/documental/requerimientos', [
            'requerimientos' => $requerimientos
        ]);
    }

    /**
     * Crear nuevo requerimiento
     */
    public function crear_requerimiento()
    {
        $request = \Config\Services::request();

        if ($request->getMethod() === 'post') {
            $data = [
                'cliente_id' => $request->getPost('cliente_id'),
                'contrato_id' => $request->getPost('contrato_id'),
                'tipo_requerimiento' => $request->getPost('tipo_requerimiento'),
                'descripcion' => $request->getPost('descripcion'),
                'documento_requerido' => $request->getPost('documento_requerido'),
                'fecha_vencimiento' => $request->getPost('fecha_vencimiento'),
                'estado' => 'pendiente',
                'fecha_creacion' => date('Y-m-d H:i:s'),
                'usuario_id' => session()->get('id')
            ];

            $this->requerimientoModel->insert($data);
            return redirect()->to('/admin/documental/requerimientos')->with('success', 'Requerimiento creado correctamente');
        }

        return view('admin/documental/crear_requerimiento');
    }

    /**
     * Actualizar estado del requerimiento
     */
    public function actualizar_requerimiento($id)
    {
        $request = \Config\Services::request();
        $requerimiento = $this->requerimientoModel->find($id);

        if (!$requerimiento) {
            return redirect()->to('/admin/documental/requerimientos')->with('error', 'Requerimiento no encontrado');
        }

        if ($request->getMethod() === 'post') {
            $data = [
                'estado' => $request->getPost('estado'),
                'observaciones' => $request->getPost('observaciones')
            ];

            $this->requerimientoModel->update($id, $data);
            return redirect()->to('/admin/documental/requerimientos')->with('success', 'Requerimiento actualizado correctamente');
        }

        return view('admin/documental/actualizar_requerimiento', ['requerimiento' => $requerimiento]);
    }

    /**
     * Gestión de documentos
     */
    public function documentos()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->route('dashboard/panel');
        }

        $documentos = $this->documentoModel
            ->orderBy('fecha_creacion', 'DESC')
            ->findAll();

        return view('admin/documental/documentos', [
            'documentos' => $documentos
        ]);
    }

    /**
     * Crear nuevo documento
     */
    public function crear_documento()
    {
        $request = \Config\Services::request();

        if ($request->getMethod() === 'post') {
            $data = [
                'nombre' => $request->getPost('nombre'),
                'tipo_documento' => $request->getPost('tipo_documento'),
                'descripcion' => $request->getPost('descripcion'),
                'contenido' => $request->getPost('contenido'),
                'version' => 1,
                'fecha_creacion' => date('Y-m-d H:i:s'),
                'usuario_creador_id' => session()->get('id'),
                'estado' => 'activo'
            ];

            $this->documentoModel->insert($data);
            return redirect()->to('/admin/documental/documentos')->with('success', 'Documento creado correctamente');
        }

        return view('admin/documental/crear_documento');
    }
}
