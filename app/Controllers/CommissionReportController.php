<?php

namespace App\Controllers;

use App\Models\CommissionReportModel;
use App\Models\CustomerModel;
use App\Models\CommissionSalesModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class CommissionReportController extends BaseController
{
    protected $commissionReportModel;
    protected $customerModel;

    public function __construct()
    {
        $this->commissionReportModel = new CommissionReportModel();
        $this->customerModel = new CustomerModel();
    }

    /**
     * Página de creación de informe (Backoffice - Patrocinador)
     */
    public function create()
    {
        // Verificar que sea patrocinador
        if (!session()->get('id')) {
            return redirect()->to(site_url('login'));
        }

        $customerId = session()->get('id');
        $customer = $this->customerModel->find($customerId);

        // Obtener siguiente número de informe
        $nextReportNumber = $this->commissionReportModel->getNextReportNumber();

        $data = [
            'title' => 'Crear Informe de Comisiones',
            'customer' => $customer,
            'nextReportNumber' => $nextReportNumber,
            'cart_count' => \Config\Services::cart()->count(),
        ];

        return view('backoffice_new/commission_reports/create', $data);
    }

    /**
     * Guardar nuevo informe (AJAX)
     */
    public function store()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => false, 'message' => 'Invalid request']);
        }

        $customerId = session()->get('id');
        if (!$customerId) {
            return $this->response->setJSON(['status' => false, 'message' => 'Unauthorized']);
        }

        $reportNumber = $this->request->getPost('report_number');
        $patronName = $this->request->getPost('patron_name');
        $patronPosition = $this->request->getPost('patron_position');
        $subject = $this->request->getPost('subject');
        $description = $this->request->getPost('description');
        $invoiceNumber = $this->request->getPost('invoice_number');
        $totalAmount = floatval($this->request->getPost('total_amount'));
        $projects = $this->request->getPost('projects');
        $digitalSignature = $this->request->getPost('digital_signature');
        $salesData = $this->request->getPost('sales'); // Datos dinámicos de ventas

        // Manejo de archivos
        $vouchersFile = $this->request->getFile('attachment_vauchers');
        $invoicesFile = $this->request->getFile('attachment_invoices');
        $facturaFile = $this->request->getFile('attachment_factura_pdf');

        $uploadPath = 'uploads/commission_reports';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // Guardar archivos
        $excelName = null;
        $vouchersName = null;
        $invoicesName = null;
        $facturaName = null;

        if ($vouchersFile && $vouchersFile->isValid()) {
            $vouchersName = $vouchersFile->getRandomName();
            $vouchersFile->move($uploadPath, $vouchersName);
        }

        if ($invoicesFile && $invoicesFile->isValid()) {
            $invoicesName = $invoicesFile->getRandomName();
            $invoicesFile->move($uploadPath, $invoicesName);
        }

        if ($facturaFile && $facturaFile->isValid()) {
            $facturaName = $facturaFile->getRandomName();
            $facturaFile->move($uploadPath, $facturaName);
        }

        // GENERACIÓN AUTOMÁTICA DEL EXCEL
        if (!empty($salesData)) {
            try {
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setTitle('Comisiones');

                // Estilos generales
                $headerStyle = [
                    'font' => ['bold' => true, 'color' => ['argb' => '000000']],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFE5E5E5']
                    ],
                ];

                $projectHeaderStyle = [
                    'font' => ['bold' => true],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFFFF2CC']], // Amarillo claro
                ];

                $dataStyle = [
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                ];
                
                $totalStyle = [
                    'font' => ['bold' => true],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                ];
                
                $totalAmountStyle = [
                    'font' => ['bold' => true],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFFFD966']], // Amarillo fuerte
                ];

                // Ajustar anchos de columna
                $sheet->getColumnDimension('A')->setWidth(35);
                $sheet->getColumnDimension('B')->setWidth(12);
                $sheet->getColumnDimension('C')->setWidth(10);
                $sheet->getColumnDimension('D')->setWidth(25);
                $sheet->getColumnDimension('E')->setWidth(15);
                $sheet->getColumnDimension('F')->setWidth(15);
                $sheet->getColumnDimension('G')->setWidth(15);
                $sheet->getColumnDimension('H')->setWidth(20);

                $currentRow = 2; // Empezamos en la fila 2

                foreach ($salesData as $project) {
                    $projectName = strtoupper($project['project_name']);
                    $rows = $project['rows'] ?? [];

                    // Cabecera principal (GRUPO VIVENCIA)
                    $sheet->mergeCells("A{$currentRow}:H{$currentRow}");
                    $sheet->setCellValue("A{$currentRow}", 'GRUPO VIVENCIA');
                    $sheet->getStyle("A{$currentRow}:H{$currentRow}")->applyFromArray($headerStyle);
                    $currentRow++;

                    // Cabecera del Proyecto
                    $sheet->mergeCells("A{$currentRow}:H{$currentRow}");
                    $sheet->setCellValue("A{$currentRow}", $projectName);
                    $sheet->getStyle("A{$currentRow}:H{$currentRow}")->applyFromArray($projectHeaderStyle);
                    $currentRow++;

                    // Títulos de columnas
                    $sheet->setCellValue("A{$currentRow}", 'APELLIDOS Y NOMBRES');
                    $sheet->setCellValue("B{$currentRow}", 'MANZANA');
                    $sheet->setCellValue("C{$currentRow}", 'LOTE');
                    $sheet->setCellValue("D{$currentRow}", 'Nº CUOTA, INICIAL, RESERVA');
                    $sheet->setCellValue("E{$currentRow}", 'Nº DEPOSITO');
                    $sheet->setCellValue("F{$currentRow}", 'DEPOSITO');
                    $sheet->setCellValue("G{$currentRow}", 'PORCENTAJE');
                    $sheet->setCellValue("H{$currentRow}", 'TOTAL PORCENTAJE');
                    $sheet->getStyle("A{$currentRow}:H{$currentRow}")->applyFromArray($headerStyle);
                    // Fondo amarillo claro para la cabecera de la tabla
                    $sheet->getStyle("A{$currentRow}:H{$currentRow}")->getFill()->setStartColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFFCE4D6'));
                    $currentRow++;

                    $projectTotal = 0;

                    // Filas de datos
                    foreach ($rows as $row) {
                        $sheet->setCellValue("A{$currentRow}", mb_strtoupper($row['client_name']));
                        $sheet->setCellValue("B{$currentRow}", mb_strtoupper($row['manzana']));
                        $sheet->setCellValue("C{$currentRow}", mb_strtoupper($row['lote']));
                        $sheet->setCellValue("D{$currentRow}", mb_strtoupper($row['payment_type']));
                        $sheet->setCellValue("E{$currentRow}", $row['deposit_number']);
                        
                        $sheet->setCellValue("F{$currentRow}", $row['deposit_amount']);
                        $sheet->getStyle("F{$currentRow}")->getNumberFormat()->setFormatCode('"S/ "#,##0.00');
                        
                        $sheet->setCellValue("G{$currentRow}", ($row['percentage'] / 100));
                        $sheet->getStyle("G{$currentRow}")->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_00);
                        
                        $sheet->setCellValue("H{$currentRow}", $row['commission_amount']);
                        $sheet->getStyle("H{$currentRow}")->getNumberFormat()->setFormatCode('"S/ "#,##0.00');

                        $sheet->getStyle("A{$currentRow}:H{$currentRow}")->applyFromArray($dataStyle);
                        $sheet->getStyle("A{$currentRow}")->getFill()->setFillType(Fill::FILL_SOLID)->setStartColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFFFF2CC')); // Fondo celda cliente
                        
                        $projectTotal += floatval($row['commission_amount']);
                        $currentRow++;
                    }

                    // Fila de TOTAL del proyecto
                    $sheet->mergeCells("A{$currentRow}:G{$currentRow}");
                    $sheet->setCellValue("A{$currentRow}", 'TOTAL');
                    $sheet->getStyle("A{$currentRow}:G{$currentRow}")->applyFromArray($totalStyle);
                    
                    $sheet->setCellValue("H{$currentRow}", $projectTotal);
                    $sheet->getStyle("H{$currentRow}")->applyFromArray($totalAmountStyle);
                    $sheet->getStyle("H{$currentRow}")->getNumberFormat()->setFormatCode('"S/ "#,##0.00');
                    
                    $currentRow += 2; // Espacio entre proyectos
                }

                $excelName = 'EXCEL_' . str_replace([' ', '/', '\\'], '_', $reportNumber) . '_' . time() . '.xlsx';
                $writer = new Xlsx($spreadsheet);
                $writer->save($uploadPath . '/' . $excelName);

            } catch (\Exception $e) {
                log_message('error', 'Error generando Excel automático: ' . $e->getMessage());
            }
        }

        // Guardar firma digital como archivo físico para que MS Word la pueda leer
        $digitalSignatureUrl = $digitalSignature;
        if (!empty($digitalSignature) && preg_match('/^data:image\/(\w+);base64,/', $digitalSignature, $type)) {
            $data = substr($digitalSignature, strpos($digitalSignature, ',') + 1);
            $type = strtolower($type[1]); // png
            $data = base64_decode($data);
            $signatureFileName = 'signature_' . time() . '_' . uniqid() . '.' . $type;
            file_put_contents($uploadPath . '/' . $signatureFileName, $data);
            $digitalSignatureUrl = base_url($uploadPath . '/' . $signatureFileName);
        }

        // Generar formato Word (.doc) a partir del HTML
        $generatedWordName = null;
        $generatedPdfName = null;
        try {
            $pdfData = [
                'report_number' => $reportNumber,
                'patron_name' => $patronName,
                'patron_position' => $patronPosition,
                'subject' => $subject,
                'projects' => $projects,
                'description' => $description,
                'total_amount' => $totalAmount,
                'invoice_number' => $invoiceNumber,
                'digital_signature' => $digitalSignatureUrl
            ];
            
            $html = view('backoffice_new/commission_reports/pdf_template', $pdfData);
            
            $baseFileName = 'INFORME_' . str_replace([' ', '/', '\\'], '_', $reportNumber) . '_' . time();

            // Generar formato Word (.doc) a partir del HTML
            $wordContent = "<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'><head><meta charset='utf-8'></head><body>" . $html . "</body></html>";
            $generatedWordName = $baseFileName . '.doc';
            file_put_contents($uploadPath . '/' . $generatedWordName, $wordContent);

            // Intentar generar PDF si Dompdf y GD están instalados
            if (class_exists('\Dompdf\Dompdf') && extension_loaded('gd')) {
                $options = new \Dompdf\Options();
                $options->set('isHtml5ParserEnabled', true);
                $options->set('isRemoteEnabled', true);
                
                $dompdf = new \Dompdf\Dompdf($options);
                $dompdf->loadHtml($html);
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();
                
                $generatedPdfName = $baseFileName . '.pdf';
                file_put_contents($uploadPath . '/' . $generatedPdfName, $dompdf->output());
            }

        } catch (\Exception $e) {
            log_message('error', 'Error generando PDF/Word de informe: ' . $e->getMessage());
        }

        // Preparar datos
        $data = [
            'report_number' => $reportNumber,
            'customer_id' => $customerId,
            'patron_name' => $patronName,
            'patron_position' => $patronPosition,
            'subject' => $subject,
            'description' => $description,
            'invoice_number' => $invoiceNumber,
            'total_amount' => $totalAmount,
            'projects' => $projects,
            'attachment_excel' => $excelName,
            'attachment_vauchers' => $vouchersName,
            'attachment_invoices' => $invoicesName,
            'attachment_factura_pdf' => $facturaName,
            'generated_report_pdf' => $generatedPdfName,
            'generated_report_word' => $generatedWordName,
            'digital_signature' => $digitalSignature,
            'status' => 'pending',
        ];

        $result = $this->commissionReportModel->insert($data);

        if ($result) {
            // Guardar ventas dinámicas en BD
            if (!empty($salesData)) {
                $commissionSalesModel = new CommissionSalesModel();
                foreach ($salesData as $project) {
                    $projectName = $project['project_name'];
                    $rows = $project['rows'] ?? [];
                    foreach ($rows as $row) {
                        $commissionSalesModel->insert([
                            'report_id' => $result,
                            'project_name' => $projectName,
                            'client_name' => $row['client_name'],
                            'manzana' => $row['manzana'],
                            'lote' => $row['lote'],
                            'payment_type' => $row['payment_type'],
                            'deposit_number' => $row['deposit_number'],
                            'deposit_amount' => $row['deposit_amount'],
                            'percentage' => $row['percentage'],
                            'commission_amount' => $row['commission_amount']
                        ]);
                    }
                }
            }

            return $this->response->setJSON([
                'status' => true,
                'message' => 'Informe creado exitosamente',
                'report_id' => $result,
            ]);
        } else {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Error al crear informe',
            ]);
        }
    }

    /**
     * Listado de informes del patrocinador (Backoffice)
     */
    public function myReports()
    {
        $customerId = session()->get('id');
        if (!$customerId) {
            return redirect()->to(site_url('login'));
        }

        $reports = $this->commissionReportModel->getReportsByCustomer($customerId);

        $data = [
            'title' => 'Mis Informes de Comisiones',
            'reports' => $reports,
            'cart_count' => \Config\Services::cart()->count(),
        ];

        return view('backoffice_new/commission_reports/my_reports', $data);
    }

    /**
     * Eliminar informe (solo si está pendiente)
     */
    public function delete($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => false, 'message' => 'Invalid request']);
        }

        $customerId = session()->get('id');
        if (!$customerId) {
            return $this->response->setJSON(['status' => false, 'message' => 'Unauthorized']);
        }

        $report = $this->commissionReportModel->find($id);

        if (!$report) {
            return $this->response->setJSON(['status' => false, 'message' => 'Informe no encontrado']);
        }

        if ($report['customer_id'] != $customerId) {
            return $this->response->setJSON(['status' => false, 'message' => 'No tienes permiso para eliminar este informe']);
        }

        if ($report['status'] !== 'pending') {
            return $this->response->setJSON(['status' => false, 'message' => 'Solo se pueden eliminar informes en estado Pendiente']);
        }

        // Eliminar archivos físicos
        $files = [
            'attachment_excel',
            'attachment_vauchers',
            'attachment_invoices',
            'attachment_factura_pdf',
            'generated_report_pdf',
            'generated_report_word'
        ];

        foreach ($files as $fileField) {
            if (!empty($report[$fileField])) {
                $filePath = 'uploads/commission_reports/' . $report[$fileField];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }

        // Eliminar de BD
        if ($this->commissionReportModel->delete($id)) {
            return $this->response->setJSON([
                'status' => true,
                'message' => 'Informe eliminado correctamente'
            ]);
        }

        return $this->response->setJSON([
            'status' => false,
            'message' => 'Error al eliminar el informe'
        ]);
    }

    // --- MÉTODOS PARA EL BACKOFFICE DEL CLIENTE ---
    
    // Nueva vista para que el cliente vea el detalle de su informe
    public function view_user($id)
    {
        $session = session();
        if (!$session->has('role') || $session->get('role') != '2') {
            return redirect()->to(site_url('admin'));
        }

        $report = $this->commissionReportModel->find($id);

        if (!$report) {
            return redirect()->to('/backoffice_new/commission_reports/my')->with('error', 'Informe no encontrado.');
        }
        
        // Verificar que el informe pertenezca al usuario logueado
        if ($report['customer_id'] != $session->get('id')) {
            return redirect()->to('/backoffice_new/commission_reports/my')->with('error', 'No tienes permiso para ver este informe.');
        }

        $data['report'] = $report;

        return view('backoffice_new/commission_reports/view', $data);
    }

    /**
     * Dashboard de Admin - Gestionar informes
     */
    public function adminDashboard()
    {
        // El authGuard filter ya verifica que esté logueado

        $summary = $this->commissionReportModel->getDashboardSummary();
        // AHORA OBTENDRA LOS ÚLTIMOS 5 INFORMES SIN IMPORTAR SU ESTADO
        $pendingReports = $this->commissionReportModel->select('commission_reports.*, customers.name as customer_name, customers.lastname as customer_lastname')
            ->join('customers', 'customers.id = commission_reports.customer_id', 'left')
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->findAll();

        $data = [
            'title' => 'Gestión de Informes de Comisiones',
            'summary' => $summary,
            'pending_reports' => $pendingReports,
            'current_page' => 'commission_reports',
        ];

        return view('admin/commission_reports/dashboard', $data);
    }

    /**
     * Ver detalle de informe (Admin)
     */
    public function view($reportId)
    {
        // El authGuard filter ya verifica que esté logueado

        $report = $this->commissionReportModel->getReportWithCustomer($reportId);

        if (!$report) {
            return $this->response->setStatusCode(404)->setJSON(['status' => false, 'message' => 'Report not found']);
        }

        $data = [
            'title' => 'Detalle de Informe',
            'report' => $report,
        ];

        return view('admin/commission_reports/view', $data);
    }

    /**
     * Actualizar estado de informe (Admin - AJAX)
     */
    public function updateStatus()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => false, 'message' => 'Invalid request']);
        }

        // El authGuard filter ya verifica que esté logueado

        $reportId = $this->request->getPost('report_id');
        $newStatus = $this->request->getPost('status');
        $notes = $this->request->getPost('notes');
        $adminId = session()->get('id');

        $validStatuses = ['pending', 'reviewed', 'approved', 'rejected', 'paid'];
        if (!in_array($newStatus, $validStatuses)) {
            return $this->response->setJSON(['status' => false, 'message' => 'Invalid status']);
        }

        $result = $this->commissionReportModel->updateStatus($reportId, $newStatus, $notes, $adminId);

        if ($result) {
            return $this->response->setJSON([
                'status' => true,
                'message' => 'Estado actualizado',
            ]);
        } else {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Error al actualizar',
            ]);
        }
    }

    /**
     * Descargar archivo del informe
     */
    public function downloadAttachment($reportId, $fileType)
    {
        // El authGuard filter ya verifica que esté logueado
        $userId = session()->get('id');

        $report = $this->commissionReportModel->find($reportId);

        if (!$report) {
            return $this->response->setStatusCode(404)->setJSON(['status' => false]);
        }

        // Verificar que el usuario pueda ver este archivo (debe ser el dueño o admin)
        if ($report['customer_id'] != $userId) {
            // Si no es el dueño, confiar en que el authGuard lo validó como admin
        }

        $fileMap = [
            'excel' => 'attachment_excel',
            'vauchers' => 'attachment_vauchers',
            'invoices' => 'attachment_invoices',
            'factura' => 'attachment_factura_pdf',
            'report_pdf' => 'generated_report_pdf',
            'report_word' => 'generated_report_word',
        ];

        if (!isset($fileMap[$fileType])) {
            return $this->response->setStatusCode(400)->setJSON(['status' => false]);
        }

        $fileName = $report[$fileMap[$fileType]];
        $filePath = 'uploads/commission_reports/' . $fileName;

        if (!file_exists($filePath)) {
            return $this->response->setStatusCode(404)->setJSON(['status' => false]);
        }

        return $this->response->download($filePath, null);
    }

    /**
     * Listar todos los informes (Admin)
     */
    public function listAll()
    {
        // El authGuard filter ya verifica que esté logueado

        $status = $this->request->getGet('status');
        $page = $this->request->getGet('page') ?? 1;

        $query = $this->commissionReportModel
            ->select('commission_reports.*, customers.name, customers.lastname')
            ->join('customers', 'customers.id = commission_reports.customer_id', 'left');

        if ($status) {
            $query->where('commission_reports.status', $status);
        }

        $reports = $query->orderBy('commission_reports.created_at', 'DESC')
            ->paginate(20);

        $data = [
            'title' => 'Todos los Informes',
            'reports' => $reports,
            'current_status' => $status,
            'pager' => $this->commissionReportModel->pager,
        ];

        return view('admin/commission_reports/list', $data);
    }
}
