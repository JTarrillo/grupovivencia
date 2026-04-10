<?php

namespace App\Controllers;
use App\Models\MembershipsModel;
use App\Models\CustomerModel;
use App\Models\StoreModel;
use Fluent\ShoppingCart\Facades\Cart as Cart2;

class Cart extends BaseController
    /**
     * Valida/aprueba un contrato y genera la comisión solo si está aprobado
     */
    
{
    // Vista de carrito de lotes inmobiliarios
    // public cart actions
    public function index()
    {
        // Obtener proyectos
        $ProjectModel = new \App\Models\ProjectModel();
        $proyectos = $ProjectModel->findAll();

        // Obtener lotes
        $LotModel = new \App\Models\LotModel();
        $lotes_db = $LotModel->findAll();

        // Agrupar lotes por manzana y estado
        $lotes_grid = [];
        foreach ($lotes_db as $lote) {
            $block = $lote['block'] ?? 'Sin Manzana';
            $estado = strtolower($lote['status']);
            $lotes_grid[$block][] = [
                'id' => $lote['id'],
                'nombre' => $lote['lot_number'],
                'estado' => $estado,
                'area' => $lote['area_sqm'],
                'precio' => $lote['current_price'],
                'proyecto' => $lote['project_id'],
            ];
        }

        // Obtener cliente actual
        $CustomerModel = new \App\Models\CustomerModel();
        $id = $_SESSION['id'] ?? 0;
        $obj_customer = $CustomerModel->get_search_by_id($id);

        // Obtener contenido del carrito
        $content = [];
        if (class_exists('Fluent\\ShoppingCart\\Facades\\Cart')) {
            $content = \Fluent\ShoppingCart\Facades\Cart::content();
        }

        // Datos de usuario para panel lateral
        $usuario = [
            'nombre' => $obj_customer->name . ' ' . $obj_customer->lastname,
            'dni' => $obj_customer->dni,
            'email' => $obj_customer->email,
        ];

        return view('backoffice_new/cart', [
            'lotes_grid' => $lotes_grid,
            'usuario' => $usuario,
            'content' => $content,
        ]);
    }

      /**
     * Procesa acciones de lote: reservar, inicial, contado
     */
    public function accionLote()
    {
        $request = service('request');
        $accion = $request->getPost('accion');
        $lote_nombre = $request->getPost('lote');
        $manzana = $request->getPost('manzana');
        $precio = $request->getPost('precio');
        $inicial = $request->getPost('inicial');
        $nombre = $request->getPost('nombre');
        $dni = $request->getPost('dni');
        $email = $request->getPost('email');
        $comprobante = $request->getFile('comprobante');

        $LotModel = new \App\Models\LotModel();
        $CustomerModel = new \App\Models\CustomerModel();
        $lote = $LotModel->where('lot_number', $lote_nombre)->where('block', $manzana)->first();
        if (!$lote) {
            return $this->response->setJSON(['success' => false, 'message' => 'Lote no encontrado']);
        }
        $cliente = $CustomerModel->where('dni', $dni)->first();
        if (!$cliente) {
            $cliente_id = $CustomerModel->insert([
                'name' => $nombre,
                'dni' => $dni,
                'email' => $email
            ]);
        } else {
            $cliente_id = $cliente['id'];
        }

        // Validar comprobante
        if ($comprobante && $comprobante->isValid() && !$comprobante->hasMoved()) {
            $allowedTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/webp', 'application/pdf'];
            if (!in_array($comprobante->getMimeType(), $allowedTypes)) {
                return $this->response->setJSON(['success' => false, 'message' => 'Formato de comprobante no permitido. Solo se aceptan PDF, PNG, JPG, JPEG, WEBP.']);
            }
            $comprobante_name = $comprobante->getRandomName();
            $comprobante_url = 'uploads/comprobantes/' . $comprobante_name;
            $comprobante->move(ROOTPATH . 'writable/uploads/comprobantes', $comprobante_name);
        } else {
            $comprobante_url = null;
        }

        // Acciones
        if ($accion === 'reservar') {
            $update_result = $LotModel->update($lote['id'], [
                'status' => 'reserved',
                'customer_id' => $cliente_id
            ]);
            $lote_actualizado = $LotModel->find($lote['id']);
            $ContractModel = new \App\Models\ContractModel();
            $PaymentPlanModel = new \App\Models\PaymentPlanModel();
            $db = \Config\Database::connect();
            $plan_cuotas = $request->getPost('plan_cuotas') ?? 12;
            $monto_reserva = $request->getPost('monto_reserva') ?? 1000;
            $payment_plan = $PaymentPlanModel->where('active', 1)->orderBy('id', 'ASC')->first();
            $payment_plan_id = $payment_plan ? $payment_plan['id'] : null;
            $last_contract = $ContractModel->select('id')->orderBy('id', 'DESC')->first();
            $next_id = $last_contract ? ($last_contract['id'] + 1) : 1;
            $contract_number = 'GV-' . date('Y') . '-' . str_pad($next_id, 3, '0', STR_PAD_LEFT);
            // Buscar patrocinador en unilevels
            $sponsor_id = null;
            $builder = $db->table('unilevels');
            $unilevel = $builder->where('customer_id', $cliente_id)->get()->getRowArray();
            if ($unilevel && !empty($unilevel['sponsor_id'])) {
                $sponsor_id = $unilevel['sponsor_id'];
            }
            $contrato_data = [
                'lot_id' => $lote['id'],
                'customer_id' => $cliente_id,
                'total_amount' => $precio,
                'reservation_amount' => $monto_reserva,
                'reservation_date' => date('Y-m-d'),
                'contract_date' => date('Y-m-d'),
                'status' => 'reservado',
                'contract_file' => $comprobante_url,
                'voucher_url' => $comprobante_url,
                'contract_number' => $contract_number,
                'payment_plan_id' => $payment_plan_id,
                'contract_type' => 'arras',
                'is_reserved' => 1,
                'financing_months' => $plan_cuotas,
                'sponsor_id' => $sponsor_id
            ];
            $contract_id = $ContractModel->insert($contrato_data);
                        // Log voucher URL guardado
                        if (!empty($contrato_data['voucher_url'])) {
                            log_message('info', '[Cart] Voucher guardado en contrato (reservar): ' . $contrato_data['voucher_url']);
                        }
                        // Log voucher URL guardado
                        if (!empty($contrato_data['voucher_url'])) {
                            log_message('info', '[Cart] Voucher guardado en contrato (inicial): ' . $contrato_data['voucher_url']);
                        }
                        // Log voucher URL guardado
                        if (!empty($contrato_data['voucher_url'])) {
                            log_message('info', '[Cart] Voucher guardado en contrato (contado): ' . $contrato_data['voucher_url']);
                        }
            
            // NOTA: La comisión se creará DESPUÉS de que el admin apruebe el contrato
            // (después de validar que el voucher fue enviado correctamente)
            
            // Generar cronograma de pagos para reserva usando método centralizado
            $PaymentScheduleModel = new \App\Models\PaymentScheduleModel();
            $financedAmount = floatval($precio);
            $monthlyPayment = $financedAmount / intval($plan_cuotas);
            $PaymentScheduleModel->generatePaymentSchedule(
                $contract_id,
                $lote['id'],
                $payment_plan_id,
                date('Y-m-d'),
                intval($plan_cuotas),
                $monthlyPayment,
                $financedAmount,
                0  // monthlyRate = 0 (no interest for reservations)
            );
            // Obtener cronograma generado
            $cronograma = $PaymentScheduleModel
                ->where('contract_id', $contract_id)
                ->orderBy('installment_number', 'ASC')
                ->findAll();
            // Log de reserva y cronograma
            $logData = [
                'datetime' => date('Y-m-d H:i:s'),
                'accion' => 'reservar',
                'contrato_data' => $contrato_data,
                'contract_id' => $contract_id,
                'lote_antes' => $lote,
                'lote_despues' => $lote_actualizado,
                'update_result' => $update_result,
                'cliente_id' => $cliente_id,
                'request_post' => $request->getPost(),
                'comprobante_url' => $comprobante_url,
                'cronograma' => $cronograma
            ];
            $logFile = WRITEPATH . 'logs/contrato_reserva_' . date('Ymd_His') . '.log';
            file_put_contents($logFile, json_encode($logData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            // Enviar correo de confirmación
            $emailService = \Config\Services::email();
            $emailService->setFrom('jtarrillochuquiruna@gmail.com', 'Grupo Vivencia');
            $emailService->setTo($email);
            $emailService->setBCC('jtarrillochuquiruna@gmail.com');
            $emailService->setSubject('Confirmación de Contrato - Grupo Vivencia');
            
            // Generar HTML del email con template profesional
            $emailBody = view('emails/contract_confirmation', [
                'nombre' => $nombre,
                'contract_number' => $contract_number,
                'lote_nombre' => $lote_nombre,
                'manzana' => $manzana,
                'precio' => $precio,
                'accion' => $accion,
                'dni' => $dni,
                'email' => $email
            ]);
            
            $emailService->setMessage($emailBody);
            $emailService->send();
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Reserva registrada y contrato + cronograma creado.',
                'contract_id' => $contract_id,
                'contrato_data' => $contrato_data,
                'lote' => $lote_actualizado,
                'debug_log' => $logFile,
                'update_result' => $update_result,
                'cronograma' => $cronograma
            ]);
        } else if ($accion === 'inicial') {
            $LotModel->update($lote['id'], [
                'status' => 'sold',
                'customer_id' => $cliente_id,
                'sale_date' => date('Y-m-d H:i:s')
            ]);
            $ContractModel = new \App\Models\ContractModel();
            $PaymentPlanModel = new \App\Models\PaymentPlanModel();
            $PaymentScheduleModel = new \App\Models\PaymentScheduleModel();
            $db = \Config\Database::connect();
            $plan_cuotas = $request->getPost('plan_cuotas') ?? 12;
            $payment_plan = $PaymentPlanModel->where('active', 1)->orderBy('id', 'ASC')->first();
            $payment_plan_id = $payment_plan ? $payment_plan['id'] : null;
            // Generar número de contrato único usando el último ID
            $last_contract = $ContractModel->select('id')->orderBy('id', 'DESC')->first();
            $next_id = $last_contract ? ($last_contract['id'] + 1) : 1;
            $contract_number = 'GV-' . date('Y') . '-' . str_pad($next_id, 3, '0', STR_PAD_LEFT);
            // Buscar patrocinador en unilevels
            $sponsor_id = null;
            $builder = $db->table('unilevels');
            $unilevel = $builder->where('customer_id', $cliente_id)->get()->getRowArray();
            if ($unilevel && !empty($unilevel['sponsor_id'])) {
                $sponsor_id = $unilevel['sponsor_id'];
            }
            
            // ✅ CORRECCIÓN: Obtener el precio REAL del lote desde la base de datos
            // Si el precio del formulario está vacío, usar current_price del lote
            $precio_lote = floatval($precio);
            if ($precio_lote <= 0) {
                $precio_lote = floatval($lote['current_price'] ?? 0);
            }
            $cuota_inicial = floatval($inicial);        // Lo que pagó el cliente como inicial
            $monto_financiado = $precio_lote - $cuota_inicial;  // Lo que queda por pagar
            $monto_cuota_mensual = $monto_financiado / intval($plan_cuotas);  // Cuota mensual sobre lo financiado
            
            $contrato_data = [
                'lot_id' => $lote['id'],
                'customer_id' => $cliente_id,
                'total_amount' => $precio_lote,                    // ✅ Precio total del lote
                'down_payment' => $cuota_inicial,                  // ✅ Cuota inicial pagada
                'financed_amount' => $monto_financiado,            // ✅ Monto a financiar
                'financing_months' => $plan_cuotas,
                'monthly_payment' => round($monto_cuota_mensual, 2),  // ✅ Cuota mensual correcta
                'contract_date' => date('Y-m-d'),
                'start_date' => date('Y-m-d', strtotime('+1 month')),
                'end_date' => date('Y-m-d', strtotime('+' . $plan_cuotas . ' months')),
                'status' => 'active',
                'contract_file' => $comprobante_url,
                'voucher_url' => $comprobante_url,
                'contract_number' => $contract_number,
                'payment_plan_id' => $payment_plan_id,
                'contract_type' => 'inicial',                      // ✅ Tipo correcto
                'sponsor_id' => $sponsor_id
            ];
            $contract_id = $ContractModel->insert($contrato_data);
            
            // ✅ CUOTA INICIAL (cuota 0) - con el voucher del cliente
            $cuota_inicial_data = [
                'contract_id' => $contract_id,
                'lot_id' => $lote['id'],
                'payment_plan_id' => $payment_plan_id,
                'installment_number' => 0,
                'due_date' => date('Y-m-d'),
                'amount' => round($cuota_inicial, 2),
                'capital' => round($cuota_inicial, 2),
                'interest' => 0,
                'interest_accrued' => null,
                'interest_accrued_date' => null,
                'balance' => round($monto_financiado, 2),
                'status' => 'registered',  // Registrado, esperando validación de HR
                'paid_date' => date('Y-m-d H:i:s'),
                'paid_amount' => round($cuota_inicial, 2),
                'voucher_url' => $comprobante_url,  // ✅ Guardar el voucher del cliente
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'pdf_url' => null,
                'xml_url' => null
            ];
            $PaymentScheduleModel->insert($cuota_inicial_data);
            
            // ✅ Generar cronograma usando método centralizado
            $PaymentScheduleModel = new \App\Models\PaymentScheduleModel();
            $monthlyPayment = $monto_cuota_mensual;
            $PaymentScheduleModel->generatePaymentSchedule(
                $contract_id,
                $lote['id'],
                $payment_plan_id,
                date('Y-m-d', strtotime('+1 month')),
                intval($plan_cuotas),
                $monthlyPayment,
                $monto_financiado,
                0,  // monthlyRate = 0 (no interest)
                $cuota_inicial,  // downPayment already paid upfront
                null,
                $comprobante_url  // voucherUrl
            );
            // Obtener cronograma generado
            $cronograma = $PaymentScheduleModel
                ->where('contract_id', $contract_id)
                ->where('installment_number', '>', 0)  // exclude cuota inicial (0)
                ->orderBy('installment_number', 'ASC')
                ->findAll();
            // NOTA: La comisión se creará DESPUÉS de que el admin apruebe el contrato
            // (después de validar que el voucher fue enviado correctamente)
            
            // Log en archivo
            $logData = [
                'datetime' => date('Y-m-d H:i:s'),
                'contrato_data' => $contrato_data,
                'cronograma' => $cronograma,
                'calculo' => [
                    'precio_lote' => $precio_lote,
                    'cuota_inicial' => $cuota_inicial,
                    'monto_financiado' => $monto_financiado,
                    'monto_cuota_mensual' => $monto_cuota_mensual,
                    'plan_cuotas' => $plan_cuotas
                ]
            ];
            $logFile = WRITEPATH . 'logs/registro_inicial_' . date('Ymd_His') . '.log';
            file_put_contents($logFile, json_encode($logData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            $lote_actualizado = $LotModel->find($lote['id']);
            // Enviar correo de confirmación
            $emailService = \Config\Services::email();
            $emailService->setFrom('jtarrillochuquiruna@gmail.com', 'Grupo Vivencia');
            $emailService->setTo($email);
            $emailService->setBCC('jtarrillochuquiruna@gmail.com');
            $emailService->setSubject('Confirmación de Contrato - Grupo Vivencia');
            
            // Generar HTML del email con template profesional
            $emailBody = view('emails/contract_confirmation', [
                'nombre' => $nombre,
                'contract_number' => $contract_number,
                'lote_nombre' => $lote_nombre,
                'manzana' => $manzana,
                'precio' => $inicial,
                'accion' => $accion,
                'dni' => $dni,
                'email' => $email
            ]);
            
            $emailService->setMessage($emailBody);
            $emailService->send();
            return $this->response->setJSON([
                'success' => true,
                'contract_id' => $contract_id,
                'lote' => $lote_actualizado
            ]);
        } else if ($accion === 'contado') {
            $LotModel->update($lote['id'], [
                'status' => 'sold',
                'customer_id' => $cliente_id,
                'sale_date' => date('Y-m-d H:i:s')
            ]);
            $ContractModel = new \App\Models\ContractModel();
            $PaymentPlanModel = new \App\Models\PaymentPlanModel();
            $db = \Config\Database::connect();
            $payment_plan = $PaymentPlanModel->where('active', 1)->orderBy('id', 'ASC')->first();
            $payment_plan_id = $payment_plan ? $payment_plan['id'] : null;
            // Generar número de contrato único usando el último ID
            $last_contract = $ContractModel->select('id')->orderBy('id', 'DESC')->first();
            $next_id = $last_contract ? ($last_contract['id'] + 1) : 1;
            $contract_number = 'GV-' . date('Y') . '-' . str_pad($next_id, 3, '0', STR_PAD_LEFT);
            // Buscar patrocinador en unilevels
            $sponsor_id = null;
            $builder = $db->table('unilevels');
            $unilevel = $builder->where('customer_id', $cliente_id)->get()->getRowArray();
            if ($unilevel && !empty($unilevel['sponsor_id'])) {
                $sponsor_id = $unilevel['sponsor_id'];
            }
            $contrato_data = [
                'lot_id' => $lote['id'],
                'customer_id' => $cliente_id,
                'total_amount' => $precio,
                'financing_months' => 1,
                'monthly_payment' => floatval($precio),
                'contract_date' => date('Y-m-d'),
                'status' => 'active',
                'contract_file' => $comprobante_url,
                'voucher_url' => $comprobante_url,
                'contract_number' => $contract_number,
                'payment_plan_id' => $payment_plan_id,
                'contract_type' => 'futura',
                'sponsor_id' => $sponsor_id
            ];
            $contract_id = $ContractModel->insert($contrato_data);
            // NOTA: La comisión se creará DESPUÉS de que el admin apruebe el contrato
            // (después de validar que el voucher fue enviado correctamente)
            
            $logData = [
                'datetime' => date('Y-m-d H:i:s'),
                'contrato_data' => $contrato_data
            ];
            $logFile = WRITEPATH . 'logs/registro_contado_' . date('Ymd_His') . '.log';
            file_put_contents($logFile, json_encode($logData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            $lote_actualizado = $LotModel->find($lote['id']);
            // Enviar correo de confirmación
            $emailService = \Config\Services::email();
            $emailService->setFrom('jtarrillochuquiruna@gmail.com', 'Grupo Vivencia');
            $emailService->setTo($email);
            $emailService->setBCC('jtarrillochuquiruna@gmail.com');
            $emailService->setSubject('Confirmación de Contrato - Grupo Vivencia');
            
            // Generar HTML del email con template profesional
            $emailBody = view('emails/contract_confirmation', [
                'nombre' => $nombre,
                'contract_number' => $contract_number,
                'lote_nombre' => $lote_nombre,
                'manzana' => $manzana,
                'precio' => $precio,
                'accion' => $accion,
                'dni' => $dni,
                'email' => $email
            ]);
            
            $emailService->setMessage($emailBody);
            $emailService->send();
            return $this->response->setJSON([
                'success' => true,
                'contract_id' => $contract_id,
                'lote' => $lote_actualizado
            ]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Acción no reconocida']);
        }
    } 
    
    public function add_cart()
    {
        $session = session();
        //get data post
        $res = service('request')->getPost();
        $id = $res['membership_id'];
        $name = $res['name'];
        $price = $res['price'];
        $img = $res['img'];
        $qty = $res['qty'];
        //set array            
        $item = array(
            'id' => $id,
            'name' => $name,
            'photo' => $img,
            'price' => $price,
            'qty' => $qty,
            'options' => [
                'project_id' => $res['project_id'] ?? null
            ]
        );

        if (!$session->has('cart')) {
            $cart = array($item);
            $session->set('cart', serialize($cart));
        } else {
            $index = $this->exists($id);
            $cart = array_values(unserialize($session->get('cart')));
            if ($index == -1) {
                array_push($cart, $item);
                $session->set('cart', serialize($cart));
            } else {
                $cart[$index]['qty']++;
                $session->set('cart', serialize($cart));
            }
        }
        //verify
        $data['status'] = true;
        echo json_encode($data);
    }

    private function exists($id)
    {
        $session = session();
        $cart = array_values(unserialize($session->get('cart')));
        for ($i = 0; $i < count($cart); $i++) {
            if ($cart[$i]['id'] == $id) {
                return $i;
            }
        }
        return -1;
    }

    public function remove($id)
    {
        $index = $this->exists($id);
        $cart = array_values(unserialize($this->session->userdata('cart')));
        unset($cart[$index]);
        $this->session->set_userdata('cart', serialize($cart));
        redirect('cart');
    }

    private function total()
    {
        $items = array_values(unserialize($this->session->userdata('cart')));
        $s = 0;
        foreach ($items as $item) {
            $s += $item['price'] * $item['quantity'];
        }
        return $s;
    }



    public function add_cart_public()
    {
        $session = \Config\Services::session();
        $cart = $session->get('cart') ? unserialize($session->get('cart')) : [];

        $membership_id = $this->request->getPost('membership_id');
        $qty = (int) $this->request->getPost('qty');

        if (!isset($cart[$membership_id])) {
            $cart[$membership_id] = [
                'id' => $membership_id,
                'name' => $this->request->getPost('name'),
                'price' => (float) $this->request->getPost('price'),
                'img' => $this->request->getPost('img'),
                'qty' => $qty,
                'options' => [
                    'project_id' => $this->request->getPost('project_id') ?? null
                ]
            ];
        } else {
            $cart[$membership_id]['qty'] += $qty;
        }

        $session->set('cart', serialize($cart));
        return $this->response->setJSON(['cart' => array_values($cart)]);
    }

    public function update_quantity()
    {
        $session = \Config\Services::session();
        $cart = $session->get('cart') ? unserialize($session->get('cart')) : [];

        $membership_id = $this->request->getPost('membership_id');
        $quantityChange = (int) $this->request->getPost('quantityChange');

        if (isset($cart[$membership_id])) {
            $cart[$membership_id]['qty'] += $quantityChange;
            if ($cart[$membership_id]['qty'] <= 0) {
                unset($cart[$membership_id]);
            }
            $session->set('cart', serialize($cart));
        }

        return $this->response->setJSON(['cart' => array_values($cart)]);
    }

    public function remove_item()
    {
        $session = \Config\Services::session();
        $cart = $session->get('cart') ? unserialize($session->get('cart')) : [];

        $membership_id = $this->request->getPost('membership_id');

        if (isset($cart[$membership_id])) {
            unset($cart[$membership_id]);
            $session->set('cart', serialize($cart));
        }

        return $this->response->setJSON(['cart' => array_values($cart)]);
    }

    public function checkout()
    {
        $session = \Config\Services::session();
        $cart = $session->get('cart') ? array_values(unserialize($session->get('cart'))) : [];

        //get contable product
        $Memberships = new MembershipsModel();
        $Customer = new CustomerModel();
        //get products footer
        $params = array(
            "select" => "*",
            "where" => "`contable` = '1' and `active` = '1'",
            "order" => "price ASC",
            "limit" => "12",
        );
        $obj_products = $Memberships->search($params);

        $id = $_SESSION['id'] ?? 0;
        $obj_customer = $Customer->get_search_by_id($id);
        //get data store
        $Store = new StoreModel();
        $obj_store = $Store->get_all();
        $cart_count = Cart2::count();
        //get data shoppint cart
        $content = Cart2::content();
        $sub_total = Cart2::subtotal();
        $total = Cart2::total();

        //send
        $data = [
            "obj_products" => $obj_products,
            "cart" => $cart,
            "obj_customer" => $obj_customer,
            "obj_store" => $obj_store,
            "cart_count" => $cart_count,
            "content" => $content,
            "sub_total" => $sub_total,
            "total" => $total,
            "id" => $id
        ];

        return view('page_method', $data);
    }

    public function lotes_cart()
    {
        // Obtener proyectos
        $ProjectModel = new \App\Models\ProjectModel();
        $proyectos = $ProjectModel->findAll();

        // Obtener lotes
        $LotModel = new \App\Models\LotModel();
        $lotes_db = $LotModel->findAll();

        // Agrupar lotes por manzana y estado
        $lotes_grid = [];
        foreach ($lotes_db as $lote) {
            $block = $lote['block'] ?? 'Sin Manzana';
            $estado = strtolower($lote['status']);
            $lotes_grid[$block][] = [
                'id' => $lote['id'],
                'nombre' => $lote['lot_number'],
                'estado' => $estado,
                'area' => $lote['area_sqm'],
                'precio' => $lote['current_price'],
                'proyecto' => $lote['project_id'],
            ];
        }

        // Depuración: mostrar el valor de $_SESSION['id']
        echo '<pre style="background:#e6f7ff;border:1px solid #1890ff;padding:10px;">';
        echo '$_SESSION["id"]: ';
        var_dump(isset($_SESSION['id']) ? $_SESSION['id'] : null);
        echo '</pre>';

        // Obtener cliente actual
        $CustomerModel = new \App\Models\CustomerModel();
        $id = $_SESSION['id'] ?? 0;
        $obj_customer = $CustomerModel->get_search_by_id($id);

        // Obtener contenido del carrito
        $content = [];
        if (class_exists('Fluent\\ShoppingCart\\Facades\\Cart')) {
            $content = \Fluent\ShoppingCart\Facades\Cart::content();
        }

        // Datos de usuario para panel lateral
        $usuario = [
            'nombre' => $obj_customer->name . ' ' . $obj_customer->lastname,
            'dni' => $obj_customer->dni,
            'email' => $obj_customer->email,
        ];

        // Depuración: mostrar datos antes de enviar a la vista
        echo '<pre style="background:#fffbe6;border:1px solid #ffd700;padding:10px;">';
        echo 'lotes_grid:'; var_dump($lotes_grid);
        echo '\nusuario:'; var_dump($usuario);
        echo '</pre>';

        return view('backoffice_new/cart', [
            'lotes_grid' => $lotes_grid,
            'usuario' => $usuario,
            'content' => $content,
        ]);
    }

    // Registrar pago y crear contrato + cronograma
    public function registrarPago()
    {
        $request = service('request');
        $cuotas = $request->getPost('cuotas');
        $lote_nombre = $request->getPost('lote');
        $manzana = $request->getPost('manzana');
        $area = $request->getPost('area');
        $precio = $request->getPost('precio');
        $nombre = $request->getPost('nombre');
        $dni = $request->getPost('dni');
        $email = $request->getPost('email');
        $comprobante = $request->getFile('comprobante');

        $LotModel = new \App\Models\LotModel();
        $lote = $LotModel->where('lot_number', $lote_nombre)->where('block', $manzana)->first();
        if (!$lote) {
            return $this->response->setJSON(['success' => false, 'message' => 'Lote no encontrado']);
        }

        $CustomerModel = new \App\Models\CustomerModel();
        $cliente = $CustomerModel->where('dni', $dni)->first();
        if (!$cliente) {
            $cliente_id = $CustomerModel->insert([
                'name' => $nombre,
                'dni' => $dni,
                'email' => $email
            ]);
        } else {
            $cliente_id = $cliente['id'];
        }

        if (!$comprobante || !$comprobante->isValid() || $comprobante->hasMoved()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Debes adjuntar el comprobante de pago (voucher)']);
        }
        $comprobante_name = $comprobante->getRandomName();
        $comprobante_url = 'uploads/comprobantes/' . $comprobante_name;
        $comprobante->move(ROOTPATH . 'writable/uploads/comprobantes', $comprobante_name);

        $ContractModel = new \App\Models\ContractModel();
        $PaymentPlanModel = new \App\Models\PaymentPlanModel();
        $db = \Config\Database::connect();

        // Buscar patrocinador en unilevels
        $sponsor_id = null;
        $builder = $db->table('unilevels');
        $unilevel = $builder->where('customer_id', $cliente_id)->get()->getRowArray();
        if ($unilevel && !empty($unilevel['sponsor_id'])) {
            $sponsor_id = $unilevel['sponsor_id'];
        }

        $payment_plan = $PaymentPlanModel->where('active', 1)->orderBy('id', 'ASC')->first();
        $payment_plan_id = $payment_plan ? $payment_plan['id'] : null;

        $last_contract = $ContractModel->select('id')->orderBy('id', 'DESC')->first();
        $next_id = $last_contract ? ($last_contract['id'] + 1) : 1;
        $contract_number = 'GV-' . date('Y') . '-' . str_pad($next_id, 3, '0', STR_PAD_LEFT);

        $contrato_data = [
            'lot_id' => $lote['id'],
            'customer_id' => $cliente_id,
            'total_amount' => $precio,
            'financing_months' => $cuotas,
            'monthly_payment' => round(floatval($precio) / intval($cuotas), 2),
            'contract_date' => date('Y-m-d'),
            'status' => 'active',
            'contract_file' => $comprobante_url,
            'contract_number' => $contract_number,
            'payment_plan_id' => $payment_plan_id,
            'sponsor_id' => $sponsor_id
        ];
        $contract_id = $ContractModel->insert($contrato_data);

        $LotModel->update($lote['id'], [
            'status' => 'sold',
            'customer_id' => $cliente_id,
            'sale_date' => date('Y-m-d H:i:s')
        ]);

        $PaymentScheduleModel = new \App\Models\PaymentScheduleModel();
        $monthlyPayment = floatval($precio) / intval($cuotas);
        $PaymentScheduleModel->generatePaymentSchedule(
            $contract_id,
            $lote['id'],
            $payment_plan_id,
            date('Y-m-d'),
            intval($cuotas),
            $monthlyPayment,
            floatval($precio),
            0  // monthlyRate = 0 (no interest)
        );
        // Obtener cronograma generado
        $cronograma = $PaymentScheduleModel
            ->where('contract_id', $contract_id)
            ->orderBy('installment_number', 'ASC')
            ->findAll();

        // Si hay patrocinador, crear comisión inmobiliaria
        if ($sponsor_id) {
            $ComisionModel = $db->table('comisiones_inmobiliarias');
            $monto_comision = round(floatval($precio) * 0.05, 2);
            $comision_data = [
                'venta_id' => $contract_id,
                'beneficiario_id' => $sponsor_id,
                'tipo_comision' => 'venta_base',
                'monto' => $monto_comision,
                'porcentaje' => 5,
                'estado' => 'aprobada',
                'fecha_generada' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $ComisionModel->insert($comision_data);
        }

        // Preparar datos de comisión para el log
        $comision_log = null;
        if ($sponsor_id) {
            $comision_log = [
                'beneficiario_id' => $sponsor_id,
                'monto' => round(floatval($precio) * 0.05, 2),
                'porcentaje' => 5,
                'estado' => 'aprobada',
                'fecha_generada' => date('Y-m-d H:i:s')
            ];
        }

        $logData = [
            'datetime' => date('Y-m-d H:i:s'),
            'contrato_data' => $contrato_data,
            'cronograma' => $cronograma,
            'comision_inmobiliaria' => $comision_log
        ];
        $logFile = WRITEPATH . 'logs/registro_pago_' . date('Ymd_His') . '.log';
        file_put_contents($logFile, json_encode($logData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        $lote_actualizado = $LotModel->find($lote['id']);
        return $this->response->setJSON([
            'success' => true,
            'contract_id' => $contract_id,
            'lote' => $lote_actualizado
        ]);
}
        /**
         * Elimina un contrato y si es de tipo contado, pone el lote como disponible
         */
        public function eliminarContrato()
        {
            $request = service('request');
            $contract_id = $request->getPost('contract_id');
            $ContractModel = new \App\Models\ContractModel();
            $LotModel = new \App\Models\LotModel();
            $contrato = $ContractModel->find($contract_id);
            if (!$contrato) {
                return $this->response->setJSON(['success' => false, 'message' => 'Contrato no encontrado']);
            }
            // Guardar el id del lote
            $lot_id = $contrato['lot_id'];
            // Verificar si el contrato es de tipo contado
            if (isset($contrato['contract_type']) && strtolower($contrato['contract_type']) === 'futura') {
                // Actualizar el estado del lote a disponible
                $LotModel->update($lot_id, [
                    'status' => 'available',
                    'customer_id' => null,
                    'sale_date' => null
                ]);
            }
            // Eliminar el contrato
            $ContractModel->delete($contract_id);
            return $this->response->setJSON(['success' => true, 'message' => 'Contrato eliminado correctamente']);
        }
}