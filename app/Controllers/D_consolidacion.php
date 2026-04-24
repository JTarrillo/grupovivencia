<?php

namespace App\Controllers;

use Config\Database;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class D_consolidacion extends BaseController
{
    private array $debugSources = [
        'ventas_local' => 0,
        'compras' => 0,
        'ventas_api' => 0,
        'total_fuentes' => 0,
    ];

    private array $debugApiBoletas = [
        'token_present' => false,
        'http_code' => null,
        'curl_error' => '',
        'response_success' => null,
        'raw_items' => 0,
        'rows_after_filter' => 0,
        'first_item_preview' => null,
    ];

    public function index()
    {
        $session = session();

        if (!$session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        $month = (int) ($this->request->getGet('month') ?? date('m'));
        $year = (int) ($this->request->getGet('year') ?? date('Y'));
        $saldoAnterior = (float) ($this->request->getGet('saldo_anterior') ?? 0);
        $descCuenta = trim((string) ($this->request->getGet('desc_cuenta') ?? 'TRANSF.BCO.BBVA'));

        if ($month < 1 || $month > 12) {
            $month = (int) date('m');
        }

        if ($year < 2000 || $year > 2100) {
            $year = (int) date('Y');
        }

        if ($descCuenta === '') {
            $descCuenta = 'TRANSF.BCO.BBVA';
        }

        $fechaInicio = sprintf('%04d-%02d-01', $year, $month);
        $fechaFin = date('Y-m-t', strtotime($fechaInicio));

        $movimientos = $this->getMovimientos($fechaInicio, $fechaFin, $descCuenta);
        $resumen = $this->buildResumen($movimientos, $saldoAnterior);

        $data = [
            'session_id' => $session->get('id'),
            'session_name' => trim(($session->get('name') ?? '') . ' ' . ($session->get('lastname') ?? '')),
            'title' => 'Modulo de Conciliacion',
            'month' => $month,
            'year' => $year,
            'saldo_anterior' => $saldoAnterior,
            'desc_cuenta' => $descCuenta,
            'movimientos' => $movimientos,
            'resumen' => $resumen,
            'debug_info' => [
                'filtros' => [
                    'month' => $month,
                    'year' => $year,
                    'fecha_inicio' => $fechaInicio,
                    'fecha_fin' => $fechaFin,
                    'saldo_anterior' => $saldoAnterior,
                    'desc_cuenta' => $descCuenta,
                ],
                'fuentes' => $this->debugSources,
                'api_boletas' => $this->debugApiBoletas,
                'resumen' => $resumen,
                'muestra_movimientos' => array_slice($movimientos, 0, 15),
                'generated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        return view('admin/consolidacion/index', $data);
    }

    public function exportar()
    {
        $session = session();

        if (!$session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        $month = (int) ($this->request->getGet('month') ?? date('m'));
        $year = (int) ($this->request->getGet('year') ?? date('Y'));
        $saldoAnterior = (float) ($this->request->getGet('saldo_anterior') ?? 0);
        $descCuenta = trim((string) ($this->request->getGet('desc_cuenta') ?? 'TRANSF.BCO.BBVA'));

        if ($month < 1 || $month > 12) {
            $month = (int) date('m');
        }

        if ($year < 2000 || $year > 2100) {
            $year = (int) date('Y');
        }

        if ($descCuenta === '') {
            $descCuenta = 'TRANSF.BCO.BBVA';
        }

        $fechaInicio = sprintf('%04d-%02d-01', $year, $month);
        $fechaFin = date('Y-m-t', strtotime($fechaInicio));

        $movimientos = $this->getMovimientos($fechaInicio, $fechaFin, $descCuenta);
        $resumen = $this->buildResumen($movimientos, $saldoAnterior);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Conciliacion');

        $sheet->setCellValue('A1', 'FECHA DE OPERACION');
        $sheet->setCellValue('B1', 'NUMERO CORRELATIVO DEL REGISTRO');
        $sheet->setCellValue('C1', 'TIPO DE OPERACION');
        $sheet->setCellValue('D1', 'NRO DE LA OPERACION');
        $sheet->setCellValue('E1', 'DESCRIPCION DE LA EE.CC');
        $sheet->setCellValue('F1', 'DESCRIPCION DE LA OPERACION');
        $sheet->setCellValue('G1', 'DATOS DEL DOCUMENTO DE REFERENCIA');
        $sheet->setCellValue('I1', 'DATOS DE CLIENTE/PROVEEDOR/TRABAJADOR/OTROS');
        $sheet->setCellValue('K1', 'SALDOS Y MOVIMIENTOS');

        $sheet->setCellValue('G2', 'TIPO (FACTURA, BOLETA, ENTRE OTROS)');
        $sheet->setCellValue('H2', 'SERIE-NUMERO');
        $sheet->setCellValue('I2', 'RUC/DNI');
        $sheet->setCellValue('J2', 'RAZON SOCIAL Y/O APELLIDOS Y NOMBRES');
        $sheet->setCellValue('K2', 'INGRESO');
        $sheet->setCellValue('L2', 'EGRESO');

        $sheet->mergeCells('A1:A2');
        $sheet->mergeCells('B1:B2');
        $sheet->mergeCells('C1:C2');
        $sheet->mergeCells('D1:D2');
        $sheet->mergeCells('E1:E2');
        $sheet->mergeCells('F1:F2');
        $sheet->mergeCells('G1:H1');
        $sheet->mergeCells('I1:J1');
        $sheet->mergeCells('K1:L1');

        $sheet->mergeCells('A3:J3');
        $sheet->setCellValue('A3', 'SALDO ANTERIOR');
        if ($saldoAnterior >= 0) {
            $sheet->setCellValue('K3', $saldoAnterior);
        } else {
            $sheet->setCellValue('L3', abs($saldoAnterior));
        }

        $row = 4;
        foreach ($movimientos as $mov) {
            $sheet->setCellValue('A' . $row, $mov['fecha_operacion']);
            $sheet->setCellValue('B' . $row, $mov['correlativo']);
            $sheet->setCellValue('C' . $row, $mov['tipo_operacion']);
            $sheet->setCellValue('D' . $row, $mov['nro_operacion']);
            $sheet->setCellValue('E' . $row, $mov['desc_eecc']);
            $sheet->setCellValue('F' . $row, $mov['desc_operacion']);
            $sheet->setCellValue('G' . $row, $mov['tipo_documento']);
            $sheet->setCellValue('H' . $row, $mov['serie_numero']);
            $sheet->setCellValue('I' . $row, $mov['ruc_dni']);
            $sheet->setCellValue('J' . $row, $mov['razon_social']);
            $sheet->setCellValue('K' . $row, $mov['ingreso']);
            $sheet->setCellValue('L' . $row, $mov['egreso']);
            $row++;
        }

        $sheet->setCellValue('J' . $row, 'TOTAL MES');
        $sheet->setCellValue('K' . $row, $resumen['total_ingreso']);
        $sheet->setCellValue('L' . $row, $resumen['total_egreso']);
        $row++;

        $sheet->setCellValue('J' . $row, 'SALDO FINAL');
        if ($resumen['saldo_final'] >= 0) {
            $sheet->setCellValue('K' . $row, $resumen['saldo_final']);
            $sheet->setCellValue('L' . $row, 0);
        } else {
            $sheet->setCellValue('K' . $row, 0);
            $sheet->setCellValue('L' . $row, abs($resumen['saldo_final']));
        }

        $sheet->getStyle('A1:L2')->getFont()->setBold(true);
        $sheet->getStyle('A1:L2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:L2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:L2')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:L2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFE2E3E5');
        $sheet->getStyle('A1:L' . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        $sheet->getStyle('K3:L' . $row)->getNumberFormat()->setFormatCode('"S/" #,##0.00');
        $sheet->getStyle('A3:J3')->getFont()->setBold(true);
        $sheet->getStyle('J' . ($row - 1) . ':L' . $row)->getFont()->setBold(true);

        $sheet->getColumnDimension('A')->setWidth(14);
        $sheet->getColumnDimension('B')->setWidth(14);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(14);
        $sheet->getColumnDimension('E')->setWidth(22);
        $sheet->getColumnDimension('F')->setWidth(52);
        $sheet->getColumnDimension('G')->setWidth(22);
        $sheet->getColumnDimension('H')->setWidth(16);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(38);
        $sheet->getColumnDimension('K')->setWidth(14);
        $sheet->getColumnDimension('L')->setWidth(14);

        $fileName = 'conciliacion_' . $year . '_' . str_pad((string) $month, 2, '0', STR_PAD_LEFT) . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    private function getMovimientos(string $fechaInicio, string $fechaFin, string $descCuenta): array
    {
        $db = Database::connect();
        $sqlVentas = "
            SELECT
                DATE(invoices.date) AS fecha_operacion,
                CASE
                    WHEN UPPER(COALESCE(invoices.details, '')) LIKE '%ITF%' THEN 'ITF'
                    ELSE 'VENTA'
                END AS tipo_operacion,
                invoices.id AS nro_operacion,
                COALESCE(NULLIF(TRIM(invoices.details), ''), 'INGRESO REGISTRADO POR VENTA') AS desc_operacion,
                UPPER(COALESCE(NULLIF(TRIM(invoices.invoice_type), ''), 'OTROS')) AS tipo_documento,
                TRIM(CONCAT(
                    COALESCE(NULLIF(TRIM(invoices.serie), ''), ''),
                    CASE
                        WHEN COALESCE(invoices.numero, '') <> '' THEN CONCAT('-', COALESCE(invoices.numero, ''))
                        ELSE ''
                    END
                )) AS serie_numero,
                COALESCE(NULLIF(TRIM(customers.ruc), ''), NULLIF(TRIM(customers.dni), ''), '') AS ruc_dni,
                UPPER(TRIM(COALESCE(
                    NULLIF(TRIM(customers.co_name), ''),
                    NULLIF(TRIM(CONCAT(COALESCE(customers.name, ''), ' ', COALESCE(customers.lastname, ''))), ''),
                    'CLIENTE SISTEMA'
                ))) AS razon_social,
                CAST(COALESCE(invoices.total, invoices.amount, 0) AS DECIMAL(15,2)) AS ingreso,
                CAST(0 AS DECIMAL(15,2)) AS egreso
            FROM invoices
            LEFT JOIN customers ON customers.id = invoices.customer_id
            WHERE DATE(invoices.date) >= ?
              AND DATE(invoices.date) <= ?
              AND COALESCE(invoices.total, invoices.amount, 0) > 0
        ";

        $sqlCompras = "
            SELECT
                DATE(compras.fecha_compra) AS fecha_operacion,
                CASE
                    WHEN UPPER(COALESCE(compras.descripcion, '')) LIKE '%ITF%' THEN 'ITF'
                    ELSE 'COMPRA'
                END AS tipo_operacion,
                compras.id AS nro_operacion,
                COALESCE(NULLIF(TRIM(compras.descripcion), ''), 'GASTO REGISTRADO POR COMPRA') AS desc_operacion,
                UPPER(COALESCE(NULLIF(TRIM(compras.tipo_comprobante), ''), 'OTROS')) AS tipo_documento,
                TRIM(COALESCE(NULLIF(TRIM(compras.numero_comprobante), ''), '')) AS serie_numero,
                COALESCE(NULLIF(TRIM(suppliers.ruc), ''), '') AS ruc_dni,
                UPPER(TRIM(COALESCE(NULLIF(TRIM(suppliers.name), ''), 'PROVEEDOR SISTEMA'))) AS razon_social,
                CAST(0 AS DECIMAL(15,2)) AS ingreso,
                CAST(COALESCE(compras.total, 0) AS DECIMAL(15,2)) AS egreso
            FROM compras
            LEFT JOIN suppliers ON suppliers.id = compras.proveedor_id
            WHERE DATE(compras.fecha_compra) >= ?
              AND DATE(compras.fecha_compra) <= ?
              AND COALESCE(compras.total, 0) > 0
        ";

        $queryVentas = $db->query($sqlVentas, [$fechaInicio, $fechaFin]);
        $queryCompras = $db->query($sqlCompras, [$fechaInicio, $fechaFin]);

        if ($queryVentas === false || $queryCompras === false) {
            $dbError = $db->error();
            log_message('error', 'Error en conciliacion SQL: ' . json_encode($dbError));
            $this->debugSources = [
                'ventas_local' => 0,
                'compras' => 0,
                'ventas_api' => 0,
                'total_fuentes' => 0,
                'sql_error' => $dbError,
            ];
            return [];
        }

        $ventasRows = $queryVentas->getResultArray();
        $comprasRows = $queryCompras->getResultArray();
        $apiRows = $this->getApiBoletasMovimientos($fechaInicio, $fechaFin);

        $this->debugSources = [
            'ventas_local' => count($ventasRows),
            'compras' => count($comprasRows),
            'ventas_api' => count($apiRows),
            'total_fuentes' => count($ventasRows) + count($comprasRows) + count($apiRows),
        ];

        $result = array_merge(
            $ventasRows,
            $comprasRows,
            $apiRows
        );

        usort($result, static function ($a, $b) {
            $fechaA = strtotime((string) ($a['fecha_operacion'] ?? ''));
            $fechaB = strtotime((string) ($b['fecha_operacion'] ?? ''));

            if ($fechaA === $fechaB) {
                return ((int) ($a['nro_operacion'] ?? 0)) <=> ((int) ($b['nro_operacion'] ?? 0));
            }

            return $fechaA <=> $fechaB;
        });

        $movimientos = [];
        $correlativo = 1;

        foreach ($result as $row) {
            $movimientos[] = [
                'fecha_operacion' => $this->formatFechaCorta($row['fecha_operacion'] ?? ''),
                'correlativo' => str_pad((string) $correlativo, 3, '0', STR_PAD_LEFT),
                'tipo_operacion' => (string) ($row['tipo_operacion'] ?? ''),
                'nro_operacion' => (string) ($row['nro_operacion'] ?? ''),
                'desc_eecc' => $descCuenta,
                'desc_operacion' => (string) ($row['desc_operacion'] ?? ''),
                'tipo_documento' => (string) ($row['tipo_documento'] ?? ''),
                'serie_numero' => trim((string) ($row['serie_numero'] ?? '')),
                'ruc_dni' => trim((string) ($row['ruc_dni'] ?? '')),
                'razon_social' => trim((string) ($row['razon_social'] ?? '')),
                'ingreso' => (float) ($row['ingreso'] ?? 0),
                'egreso' => (float) ($row['egreso'] ?? 0),
            ];
            $correlativo++;
        }

        return $movimientos;
    }

    private function getApiBoletasMovimientos(string $fechaInicio, string $fechaFin): array
    {
        $session = session();
        $token = $session->get('api_access_token');
        $tokenType = $session->get('api_token_type') ?? 'Bearer';

        $this->debugApiBoletas = [
            'token_present' => !empty($token),
            'http_code' => null,
            'curl_error' => '',
            'response_success' => null,
            'raw_items' => 0,
            'rows_after_filter' => 0,
            'first_item_preview' => null,
        ];

        if (!$token) {
            return [];
        }

        $url = 'https://apifacturacion.groupdispensersac.com/api/v1/boletas?company_id=1&branch_id=1&per_page=200';

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: ' . $tokenType . ' ' . $token,
                'Accept: application/json',
                'Content-Type: application/json',
            ],
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_TIMEOUT => 20,
        ]);

        $response = curl_exec($ch);
        $httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        $this->debugApiBoletas['http_code'] = $httpCode;
        $this->debugApiBoletas['curl_error'] = $curlError;

        if ($curlError !== '' || $httpCode < 200 || $httpCode >= 300 || !$response) {
            if ($curlError !== '') {
                log_message('error', 'Conciliacion API boletas CURL error: ' . $curlError);
            }
            return [];
        }

        $payload = json_decode($response, true);
        $this->debugApiBoletas['response_success'] = is_array($payload) ? ($payload['success'] ?? null) : null;

        if (!is_array($payload) || !($payload['success'] ?? false)) {
            return [];
        }

        $data = $payload['data'] ?? [];
        if (!is_array($data)) {
            return [];
        }

        $this->debugApiBoletas['raw_items'] = count($data);
        if (!empty($data[0]) && is_array($data[0])) {
            $this->debugApiBoletas['first_item_preview'] = [
                'id' => $data[0]['id'] ?? null,
                'numero_completo' => $data[0]['numero_completo'] ?? null,
                'fecha_emision' => $data[0]['fecha_emision'] ?? null,
                'mto_imp_venta' => $data[0]['mto_imp_venta'] ?? null,
            ];
        }

        $rows = [];
        $inicio = strtotime($fechaInicio . ' 00:00:00');
        $fin = strtotime($fechaFin . ' 23:59:59');

        foreach ($data as $item) {
            $fechaRaw = (string) ($item['fecha_emision'] ?? ($item['fecha_de_emision'] ?? ($item['date_of_issue'] ?? '')));
            if ($fechaRaw === '') {
                continue;
            }

            $fechaTs = $this->parseApiFecha($fechaRaw);
            if ($fechaTs === false || $fechaTs < $inicio || $fechaTs > $fin) {
                continue;
            }

            $numeroCompleto = (string) ($item['numero_completo'] ?? '');
            $idOperacion = (string) ($item['id'] ?? $numeroCompleto);
            $docNumero = (string) ($item['client']['numero_documento'] ?? '');
            $cliente = (string) ($item['client']['razon_social'] ?? 'CLIENTE API');
            $estadoSunat = strtoupper((string) ($item['estado_sunat'] ?? ''));
            $monto = (float) ($item['mto_imp_venta'] ?? ($item['total'] ?? ($item['mto_importe_total'] ?? 0)));

            if ($monto <= 0) {
                continue;
            }

            $rows[] = [
                'fecha_operacion' => date('Y-m-d', $fechaTs),
                'tipo_operacion' => 'VENTA',
                'nro_operacion' => $idOperacion,
                'desc_operacion' => 'VENTA BOLETA ELECTRONICA' . ($estadoSunat !== '' ? ' (' . $estadoSunat . ')' : ''),
                'tipo_documento' => 'BOLETA',
                'serie_numero' => $numeroCompleto,
                'ruc_dni' => $docNumero,
                'razon_social' => strtoupper(trim($cliente)),
                'ingreso' => $monto,
                'egreso' => 0,
            ];
        }

        $this->debugApiBoletas['rows_after_filter'] = count($rows);

        return $rows;
    }

    private function parseApiFecha(string $fechaRaw)
    {
        $fechaRaw = trim($fechaRaw);
        if ($fechaRaw === '') {
            return false;
        }

        $candidate = substr($fechaRaw, 0, 10);

        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $candidate)) {
            return strtotime($candidate . ' 00:00:00');
        }

        if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $candidate)) {
            [$d, $m, $y] = explode('/', $candidate);
            return strtotime($y . '-' . $m . '-' . $d . ' 00:00:00');
        }

        return strtotime(str_replace('T', ' ', $fechaRaw));
    }

    private function buildResumen(array $movimientos, float $saldoAnterior): array
    {
        $totalIngreso = 0.0;
        $totalEgreso = 0.0;

        foreach ($movimientos as $mov) {
            $totalIngreso += (float) ($mov['ingreso'] ?? 0);
            $totalEgreso += (float) ($mov['egreso'] ?? 0);
        }

        return [
            'total_ingreso' => $totalIngreso,
            'total_egreso' => $totalEgreso,
            'saldo_final' => ($saldoAnterior + $totalIngreso) - $totalEgreso,
            'cantidad' => count($movimientos),
        ];
    }

    private function formatFechaCorta(string $fecha): string
    {
        if ($fecha === '') {
            return '';
        }

        try {
            return date('y/m/d', strtotime($fecha));
        } catch (\Throwable $e) {
            return $fecha;
        }
    }
}
