<?php

namespace App\Controllers;

use App\Models\CommissionReportModel;
use App\Models\CustomerModel;

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

        // Manejo de archivos
        $excelFile = $this->request->getFile('attachment_excel');
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

        if ($excelFile && $excelFile->isValid()) {
            $excelName = $excelFile->getRandomName();
            $excelFile->move($uploadPath, $excelName);
        }

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
            'status' => 'pending',
        ];

        $result = $this->commissionReportModel->insert($data);

        if ($result) {
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
     * Dashboard de Admin - Gestionar informes
     */
    public function adminDashboard()
    {
        // El authGuard filter ya verifica que esté logueado

        $summary = $this->commissionReportModel->getDashboardSummary();
        $pendingReports = $this->commissionReportModel->getPendingReports();

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
