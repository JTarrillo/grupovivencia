<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsersModel;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;

class B_admin extends BaseController
{


    public function admin()

    {

        $session = session();

        $id = $session->get('id');



        if(is_null($session)){

            return redirect()->route('dashboard/panel');

        }



        return view('admin');

    }
    public function contrato_pdf($id = null)
    {
        // Inicializa el modelo correctamente
        $contractModel = new \App\Models\ContractModel();
        if ($id !== null) {
            // Si se pasa un id, busca solo ese contrato con detalles
            $contracts = [];
            $allContracts = $contractModel->getContractsWithDetails();
            foreach ($allContracts as $c) {
                if ($c['id'] == $id) {
                    $contracts[] = $c;
                    break;
                }
            }
        } else {
            // Si no se pasa id, muestra todos los contratos con detalles
            $contracts = $contractModel->getContractsWithDetails();
        }

        // Incrusta el logo como base64 para que PDF lo muestre correctamente
        $logoPath = FCPATH . 'public/assets/front/img/logo/Recursovivencia.png';
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $type = pathinfo($logoPath, PATHINFO_EXTENSION);
            $dataImg = file_get_contents($logoPath);
            $logoBase64 = 'data:image/' . $type . ';base64,' . base64_encode($dataImg);
        }

        $data = [
            'title' => 'Contrato',
            'contracts' => $contracts,
            'logoBase64' => $logoBase64,
        ];

        // Determina la plantilla según el tipo de contrato
        $contractType = $contracts[0]['contract_type'] ?? 'arras';
        if ($contractType === 'futura') {
            $viewName = 'admin/inmueble/contracts/contrato_venta_futura';
        } else {
            $viewName = 'admin/inmueble/contracts/contracts_report';
        }

        // Renderiza la vista como HTML
        $html = view($viewName, $data);
        // Carga Dompdf
        require_once(APPPATH . '../vendor/autoload.php');
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Descarga el PDF
        $dompdf->stream("contrato.pdf", ["Attachment" => false]);
    }
    public function login_admin()
    {
        $session = session();
        $request = \Config\Services::request();
        $email = $request->getPostGet('email');
        $password = $request->getPostGet('password');
        $user = new UsersModel();
        $res = $user->get_data_by_email($email);
        //validate
        if ($res) {
            $pass = $res->password;
            $authenticatePassword = password_verify($password, $pass);
            if ($authenticatePassword) {
                $ses_data = [
                    'id' => $res->id,
                    'name' => $res->name,
                    'lastname' => $res->lastname,
                    'email' => $res->email,
                    'privilegio' => isset($res->privilegio) ? $res->privilegio : (isset($res->privilage) ? $res->privilage : 'admin'),
                    'active' => $res->active,
                    'isLoggedIn' => TRUE
                ];
                $session->set($ses_data);
                $data2['status'] = true;
                $data2['message'] = 'Bienvenido al sistema.';
                // LOG: Guardar array del usuario (customer) al iniciar sesión admin
                $logData = [
                    'datetime' => date('Y-m-d H:i:s'),
                    'admin_id' => $res->id,
                    'customer_array' => [
                        'id' => $res->id,
                        'name' => $res->name,
                        'lastname' => $res->lastname,
                        'email' => $res->email,
                        'privilage' => $res->privilage,
                        'active' => $res->active
                    ]
                ];
                $logFile = WRITEPATH . 'logs/admin_login_' . $res->id . '_' . date('Ymd_His') . '.log';
                file_put_contents($logFile, json_encode($logData, JSON_PRETTY_PRINT));
                return json_encode($data2);
            } else {
                $session->setFlashdata('msg', 'Password is incorrect.');
                $data2['status'] = false;
                $data2['message'] = 'Password is incorrect.';
                return json_encode($data2);
            }
        } else {
            $session->setFlashdata('msg', 'Email does not exist.');
            $data2['status'] = false;
            $data2['message'] = 'Email does not exist.';
            return json_encode($data2);
        }
    }

    /**
     * Muestra el cronograma de pagos de un contrato
     */
    public function get_schedule($contractId)
    {
        $paymentScheduleModel = new \App\Models\PaymentScheduleModel();
        $payments = $paymentScheduleModel->where('contract_id', $contractId)
            ->orderBy('due_date', 'DESC')
            ->findAll();

        // --- LOG CRONOGRAMA MODAL ---
        $logData = [
            'contractId' => $contractId,
            'payments' => $payments,
            'timestamp' => date('Y-m-d H:i:s')
        ];
        $logFile = WRITEPATH . 'logs/cronograma_modal_' . $contractId . '_' . date('Ymd_His') . '.log';
        file_put_contents($logFile, print_r($logData, true));

        return view('admin/inmueble/cronograma_modal', ['payments' => $payments]);
    }

       public function contrato_word($id = null)
    {
        $contractModel = new \App\Models\ContractModel();
        if ($id !== null) {
            $contracts = [];
            $allContracts = $contractModel->getContractsWithDetails();
            foreach ($allContracts as $c) {
                if ($c['id'] == $id) {
                    $contracts[] = $c;
                    break;
                }
            }
        } else {
            $contracts = $contractModel->getContractsWithDetails();
        }

        // Incrusta el logo como base64 para que Word lo muestre correctamente
        $logoPath = FCPATH . 'public/assets/front/img/logo/Recursovivencia.png';
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $type = pathinfo($logoPath, PATHINFO_EXTENSION);
            $dataImg = file_get_contents($logoPath);
            $logoBase64 = 'data:image/' . $type . ';base64,' . base64_encode($dataImg);
        }

        $data = [
            'title' => 'Contrato',
            'contracts' => $contracts,
            'logoBase64' => $logoBase64,
        ];

        // Determina la plantilla según el tipo de contrato
        $contractType = $contracts[0]['contract_type'] ?? 'arras';
        if ($contractType === 'futura') {
            $viewName = 'admin/inmueble/contracts/contrato_venta_futura';
        } else {
            $viewName = 'admin/inmueble/contracts/contracts_report';
        }

        // Renderiza la vista como HTML

    $html = view($viewName, $data);

        // Prepara el archivo Word usando HTML (sin dependencias externas)
        $filename = 'contrato_' . ($contracts[0]['contract_number'] ?? $id) . '.doc';
        header("Content-type: application/msword");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo '<html xmlns:o="urn:schemas-microsoft-com:office:office"'
            . ' xmlns:w="urn:schemas-microsoft-com:office:word"'
            . ' xmlns="http://www.w3.org/TR/REC-html40">'
            . '<head><meta charset="utf-8">'
            . '<style>body { font-family: Arial, sans-serif; font-size: 12pt; } table { border-collapse: collapse; } td, th { border: 1px solid #333; padding: 4px; }</style>'
            . '</head><body>'
            . $html
            . '</body></html>';
        exit;
    }
     public function exportWord($id)
    {
        // Asegúrate de tener PHPWord instalado (phpoffice/phpword)
        // Obtén los datos del contrato
        $contract = $this->contractModel->find($id);
        if (!$contract) {
            return $this->response->setStatusCode(404)->setBody('Contrato no encontrado');
        }

        // Puedes obtener más datos relacionados si lo necesitas (cliente, lote, etc.)
        $lot = $this->lotModel->find($contract['lot_id'] ?? null);
        $customerModel = new \App\Models\CustomerModel();
        $customer = $customerModel->find($contract['customer_id'] ?? null);

        // Carga PHPWord
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();

        // Título
        $section->addText('CONTRATO PRIVADO DE PROMESA DE COMPRAVENTA CON ARRAS', ['bold' => true, 'size' => 16], ['align' => 'center']);
        $section->addTextBreak();

        // Datos principales
        $section->addText('N° Contrato: ' . ($contract['contract_number'] ?? '__________'));
        $section->addText('Fecha: ' . ($contract['contract_date'] ?? date('Y-m-d')));
        $section->addTextBreak();

        // Cliente
        $section->addText('Cliente: ' . (($customer['name'] ?? '') . ' ' . ($customer['lastname'] ?? '')));
        $section->addText('DNI: ' . ($customer['dni'] ?? '__________'));
        $section->addText('Dirección: ' . ($customer['address'] ?? '__________'));
        $section->addTextBreak();

        // Lote
        $section->addText('Lote: ' . ($lot['number'] ?? '__________'));
        $section->addText('Manzana: ' . ($lot['block'] ?? '__________'));
        $section->addText('Área: ' . ($lot['area'] ?? '__________') . ' m2');
        $section->addTextBreak();

        // Datos económicos
        $section->addText('Precio total: S/ ' . ($contract['total_amount'] ?? '__________'));
        $section->addText('Cuota inicial: S/ ' . ($contract['down_payment'] ?? '__________'));
        $section->addText('Monto financiado: S/ ' . ($contract['financed_amount'] ?? '__________'));
        $section->addText('N° meses: ' . ($contract['end_date'] && $contract['start_date'] ? ((strtotime($contract['end_date']) - strtotime($contract['start_date'])) / (30*24*60*60)) : '__________'));
        $section->addText('Cuota mensual: S/ ' . ($contract['monthly_payment'] ?? '__________'));
        $section->addText('Tasa interés: ' . ($contract['interest_rate'] ?? '__________') . ' %');
        $section->addTextBreak();

        // Puedes agregar aquí el texto legal del contrato, cláusulas, etc.
        $section->addText('--- Resumen del contrato ---');
        $section->addText('Este documento es un resumen. El contrato completo incluye todas las cláusulas legales.');

        // Descarga el archivo Word
        $filename = 'contrato_' . ($contract['contract_number'] ?? $id) . '.docx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save('php://output');
        exit;
    }

     public function crear_contrato_y_cronograma()
    {
        $request = \Config\Services::request();
        $contractModel = new \App\Models\ContractModel();
        $paymentScheduleModel = new \App\Models\PaymentScheduleModel();

        // Recibe datos del contrato (ajusta según tu formulario)
        $data = [
            'lot_id' => $request->getPost('lot_id'),
            'customer_id' => $request->getPost('customer_id'),
            'payment_plan_id' => $request->getPost('payment_plan_id'),
            'contract_number' => $contractModel->generateContractNumber(),
            'total_amount' => $request->getPost('total_amount'),
            'down_payment' => $request->getPost('down_payment'),
            'financed_amount' => $request->getPost('financed_amount'),
            'monthly_payment' => $request->getPost('monthly_payment'),
            'interest_rate' => $request->getPost('interest_rate'),
            'contract_date' => $request->getPost('contract_date'),
            'start_date' => $request->getPost('start_date'),
            'end_date' => $request->getPost('end_date'),
            'status' => 'activo',
            'notes' => $request->getPost('notes'),
            'financing_months' => $request->getPost('financing_months'),
        ];

        // Guarda el contrato
        $contractId = $contractModel->insert($data);

        // Genera el cronograma de pagos
        $startDate = new \DateTime($data['start_date']);
        $months = (int)$data['financing_months'];
        $monthlyPayment = (float)$data['monthly_payment'];
        $interestRate = (float)$data['interest_rate'];
        $capital = (float)$data['financed_amount'] / $months;
        $balance = (float)$data['financed_amount'];

        for ($i = 1; $i <= $months; $i++) {
            $interest = $balance * ($interestRate / 100 / 12);
            $dueDate = clone $startDate;
            $dueDate->modify('+' . ($i - 1) . ' month');
            $paymentScheduleModel->insert([
                'lot_id' => $data['lot_id'],
                'payment_plan_id' => $data['payment_plan_id'],
                'contract_id' => $contractId,
                'installment_number' => $i,
                'due_date' => $dueDate->format('Y-m-d'),
                'amount' => $monthlyPayment,
                'capital' => $capital,
                'interest' => $interest,
                'balance' => $balance,
                'status' => 'pending',
            ]);
            $balance -= $capital;
        }

        // Puedes agregar la cuota inicial si aplica
        // $paymentScheduleModel->insert([...]);

        return redirect()->to('/backoffice_new/contracts/detail/' . $contractId)->with('success', 'Contrato y cronograma generados correctamente');
    }
}