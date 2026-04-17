<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class VivelandRestrictFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not alter the request or response,
     * but they can if needed.
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Solo aplicar filtro a rutas de admin/dashboard
        $currentPath = $request->getPath();
        if (strpos($currentPath, 'dashboard') === false && strpos($currentPath, 'admin') === false) {
            return null; // No aplicar filtro a otros paths
        }
        
        $session = \Config\Services::session();
        $session_privilege = $session->get('privilage') ?? $session->get('privilegio');
        
        // Si el usuario es VIVELAND (privilage = 5)
        if ($session_privilege == 5) {
            $vivelandPath = 'admin/viveland_registros';
            
            // Si NO está ya en la página autorizada, redirigir
            if (strpos($currentPath, $vivelandPath) === false) {
                return redirect()->to(base_url($vivelandPath));
            }
        }
        
        return null;
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not need to change
     * the response and simply returns it as-is, either before
     * or after additonal processing.
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No hacer nada en el after
    }
}
