<?php
namespace App\Controllers;

use App\Models\CommissionsModel;
use CodeIgniter\Controller;

class ComisionesController extends Controller
{
    public function historial()
    {
        $session = session();
        $user_id = $session->get('id');
        $commissionsModel = new CommissionsModel();
        // Solo comisiones inmobiliarias (relacionadas con lotes vendidos)
        $comisiones = $commissionsModel->get_inmobiliaria_commissions($user_id);

        // Obtener datos del usuario actual para el header
        $customerModel = new \App\Models\CustomerModel();
        $obj_customer = $customerModel->where('id', $user_id)->first();

        // Título para la toolbar
        $title = 'Historial de Comisiones';
        // Contador de carrito (si aplica, por defecto 0)
        $cart_count = 0;
        if ($session->has('cart_count')) {
            $cart_count = $session->get('cart_count');
        }
        return view('backoffice_new/historial_comisiones', [
            'comisiones' => $comisiones,
            'obj_customer' => (object)$obj_customer,
            'title' => $title,
            'cart_count' => $cart_count
        ]);
    }

    // Mejor práctica: Usar modelo dedicado para comisiones inmobiliarias
    public function inmobiliaria()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('comisiones_inmobiliarias');
        $builder->select('comisiones_inmobiliarias.*, 
                         beneficiario.name as beneficiario_nombre,
                         cliente.name as customer_name');
        $builder->join('customers as beneficiario', 'beneficiario.id = comisiones_inmobiliarias.beneficiario_id', 'left');
        $builder->join('contracts', 'contracts.id = comisiones_inmobiliarias.venta_id', 'left');
        $builder->join('customers as cliente', 'cliente.id = contracts.customer_id', 'left');
        $builder->orderBy('comisiones_inmobiliarias.fecha_generada', 'DESC');
        $comisiones = $builder->get()->getResultArray();
        return view('admin/comisiones/list', [
            'comisiones' => $comisiones
        ]);
    }
    
    public function cambiar_estado()
    {
        $id = $this->request->getPost('id');
        $estado = $this->request->getPost('estado');
        
        if ($id && $estado) {
            // Validar que el estado sea válido
            $estadosValidos = ['pendiente', 'aprobada', 'pagada', 'rechazada'];
            if (!in_array($estado, $estadosValidos)) {
                return redirect()->to(site_url('admin/comisiones/inmobiliaria'))->with('error', 'Estado no válido');
            }
            
            $db = \Config\Database::connect();
            $db->table('comisiones_inmobiliarias')
                ->where('id', $id)
                ->update(['estado' => $estado]);
            
            $mensajes = [
                'pendiente' => '¡Comisión marcada como Pendiente!',
                'aprobada' => '¡Comisión marcada como Aprobada!',
                'pagada' => '¡Comisión marcada como Pagada!',
                'rechazada' => '¡Comisión marcada como Rechazada!'
            ];
            
            session()->setFlashdata('success', $mensajes[$estado]);
            return redirect()->to(site_url('admin/comisiones/inmobiliaria'));
        }
        return redirect()->to(site_url('admin/comisiones/inmobiliaria'))->with('error', 'No se pudo actualizar la comisión');
    }
    
    public function eliminar()
    {
        $id = $this->request->getPost('id');
        if ($id) {
            $db = \Config\Database::connect();
            // Eliminar completamente de la base de datos
            $db->table('comisiones_inmobiliarias')->where('id', $id)->delete();
            session()->setFlashdata('success', '¡Comisión eliminada permanentemente!');
            return redirect()->to(site_url('admin/comisiones/inmobiliaria'));
        }
        return redirect()->to(site_url('admin/comisiones/inmobiliaria'))->with('error', 'No se pudo eliminar la comisión');
    }
}