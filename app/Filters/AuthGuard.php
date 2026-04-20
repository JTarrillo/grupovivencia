<?php 



namespace App\Filters;



use CodeIgniter\HTTP\RequestInterface;

use CodeIgniter\HTTP\ResponseInterface;

use CodeIgniter\Filters\FilterInterface;





class AuthGuard implements FilterInterface

{

    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('isLoggedIn'))
        {
            // Detectar si es petición AJAX de múltiples formas
            $isAjax = $request->isAJAX() || 
                      $request->getHeader('X-Requested-With')?->getValue() === 'XMLHttpRequest' ||
                      strpos($request->getHeader('Accept')?->getValue() ?? '', 'application/json') !== false ||
                      strpos($request->getHeader('Content-Type')?->getValue() ?? '', 'application/json') !== false;
            
            // Si es una petición AJAX, devolver JSON
            if ($isAjax) {
                return service('response')
                    ->setContentType('application/json; charset=UTF-8')
                    ->setStatusCode(401)
                    ->setJSON([
                        'success' => false,
                        'error' => true,
                        'message' => 'No autorizado. Por favor inicia sesión.'
                    ]);
            }
            
            // Si no es AJAX, redirigir al login
            return redirect()->to('/login');
        }
    }

    

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)

    {

        

    }

}