<?php

namespace App\Controllers;

class D_consolidacion extends BaseController
{
    public function index()
    {
        $session = session();

        if (!$session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'session_id' => $session->get('id'),
            'session_name' => trim(($session->get('name') ?? '') . ' ' . ($session->get('lastname') ?? '')),
            'title' => 'Modulo de Consolidacion'
        ];

        return view('admin/consolidacion/index', $data);
    }
}
