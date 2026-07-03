<?php

namespace App\Controllers;

use App\Models\MovimientoDescripcionModel;

class D_mov_descripcion extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new MovimientoDescripcionModel();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        return view('admin/mov_descripcion/index', [
            'descripciones' => $this->model->orderBy('nombre', 'ASC')->findAll(),
        ]);
    }

    public function store()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'error' => 'Petición inválida.']);
        }

        $nombre = trim((string) $this->request->getPost('nombre'));
        if ($nombre === '') {
            return $this->response->setJSON(['success' => false, 'error' => 'El nombre es obligatorio.']);
        }

        $this->model->insert([
            'nombre'      => $nombre,
            'descripcion' => trim((string) $this->request->getPost('descripcion')),
            'activo'      => 1,
        ]);

        return $this->response->setJSON(['success' => true, 'message' => 'Descripción creada.']);
    }

    public function update($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'error' => 'Petición inválida.']);
        }

        $doc = $this->model->find($id);
        if (!$doc) {
            return $this->response->setJSON(['success' => false, 'error' => 'No encontrado.']);
        }

        $nombre = trim((string) $this->request->getPost('nombre'));
        if ($nombre === '') {
            return $this->response->setJSON(['success' => false, 'error' => 'El nombre es obligatorio.']);
        }

        $this->model->update($id, [
            'nombre'      => $nombre,
            'descripcion' => trim((string) $this->request->getPost('descripcion')),
            'activo'      => $this->request->getPost('activo') !== null ? (int) $this->request->getPost('activo') : 1,
        ]);

        return $this->response->setJSON(['success' => true, 'message' => 'Descripción actualizada.']);
    }

    public function delete($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'error' => 'Petición inválida.']);
        }

        if (!$this->model->find($id)) {
            return $this->response->setJSON(['success' => false, 'error' => 'No encontrado.']);
        }

        $this->model->delete($id);
        return $this->response->setJSON(['success' => true]);
    }
}
