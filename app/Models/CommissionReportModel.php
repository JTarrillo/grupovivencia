<?php

namespace App\Models;

use CodeIgniter\Model;

class CommissionReportModel extends Model
{
    protected $table            = 'commission_reports';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'report_number',
        'customer_id',
        'patron_name',
        'patron_position',
        'accounting_contact',
        'subject',
        'description',
        'invoice_number',
        'total_amount',
        'projects',
        'attachment_excel',
        'attachment_vauchers',
        'attachment_invoices',
        'attachment_factura_pdf',
        'status',
        'admin_notes',
        'reviewed_at',
        'reviewed_by',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Obtener informe con datos del cliente
     */
    public function getReportWithCustomer($reportId)
    {
        return $this->select('commission_reports.*, customers.name, customers.lastname, customers.email')
            ->join('customers', 'customers.id = commission_reports.customer_id', 'left')
            ->where('commission_reports.id', $reportId)
            ->first();
    }

    /**
     * Obtener informes pendientes
     */
    public function getPendingReports()
    {
        return $this->select('commission_reports.*, customers.name, customers.lastname')
            ->join('customers', 'customers.id = commission_reports.customer_id', 'left')
            ->where('commission_reports.status', 'pending')
            ->orderBy('commission_reports.created_at', 'DESC')
            ->findAll();
    }

    /**
     * Obtener informes por cliente
     */
    public function getReportsByCustomer($customerId)
    {
        return $this->where('customer_id', $customerId)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    /**
     * Obtener siguiente número de informe
     */
    public function getNextReportNumber($year = null)
    {
        if ($year === null) {
            $year = date('Y');
        }

        $lastReport = $this->like('report_number', $year)
            ->orderBy('id', 'DESC')
            ->first();

        $nextNumber = 1;
        if ($lastReport) {
            // Extraer número del último reporte
            $parts = explode('-', $lastReport['report_number']);
            if (!empty($parts[0])) {
                $currentNumber = (int) str_pad(trim($parts[0], 'Nº0'), 3, '0', STR_PAD_LEFT);
                $nextNumber = $currentNumber + 1;
            }
        }

        return str_pad($nextNumber, 3, '0', STR_PAD_LEFT) . '-' . $year;
    }

    /**
     * Actualizar estado de informe
     */
    public function updateStatus($reportId, $status, $notes = null, $reviewedBy = null)
    {
        return $this->update($reportId, [
            'status' => $status,
            'admin_notes' => $notes,
            'reviewed_by' => $reviewedBy,
            'reviewed_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Contar informes por estado
     */
    public function countByStatus($status = null)
    {
        if ($status) {
            return $this->where('status', $status)->countAllResults();
        }
        return $this->countAllResults();
    }

    /**
     * Obtener resumen de informes para dashboard
     */
    public function getDashboardSummary()
    {
        return [
            'pending' => $this->countByStatus('pending'),
            'reviewed' => $this->countByStatus('reviewed'),
            'approved' => $this->countByStatus('approved'),
            'rejected' => $this->countByStatus('rejected'),
            'paid' => $this->countByStatus('paid'),
        ];
    }
}
