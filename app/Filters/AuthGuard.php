<?php 



namespace App\Filters;



use CodeIgniter\HTTP\RequestInterface;

use CodeIgniter\HTTP\ResponseInterface;

use CodeIgniter\Filters\FilterInterface;





class AuthGuard implements FilterInterface

{

    public function before(RequestInterface $request, $arguments = null)

    {

        $uri = $request->getUri();
        
        // Verificar si es ruta de admin
        if (strpos($uri, '/dashboard') !== false || strpos($uri, '/admin') !== false) {
            // Validar que sea sesión de admin
            if (!session()->get('admin_isLoggedIn')) {
                return redirect()->to('/admin/login');
            }
        } 
        // Verificar si es ruta de backoffice/cliente
        else if (strpos($uri, '/backoffice') !== false) {
            // Validar que sea sesión de cliente
            if (!session()->get('client_isLoggedIn')) {
                return redirect()->to('/iniciar-sesion');
            }
        }
        // Fallback para otras rutas
        else if (!session()->get('client_isLoggedIn') && !session()->get('admin_isLoggedIn')) {
            return redirect()->to('/login');
        }

    }

    

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)

    {

        

    }

}