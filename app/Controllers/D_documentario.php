<?php

namespace App\Controllers;

use App\Models\ContractModel;

class D_documentario extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        $model = new ContractModel();
        // Obtenemos contratos que tengan factura emitida
        $contratosRaw = $model->select('contracts.*, customers.name as customer_name, customers.lastname as customer_lastname')
            ->join('customers', 'customers.id = contracts.customer_id')
            ->where('factura_emitida', 1)
            ->findAll();

        $contratosConArchivos = [];

        foreach ($contratosRaw as $c) {
            $serie = $c['factura_serie_correlativo'];
            // Ruta relativa para la vista y absoluta para verificar existencia
            $folderPath = "comprobantes/{$serie}/";
            $fullPath = FCPATH . $folderPath;

            $c['archivos'] = [
                'pdf' => file_exists($fullPath . "{$serie}_PDF.pdf") ? base_url($folderPath . "{$serie}_PDF.pdf") : null,
                'xml' => file_exists($fullPath . "{$serie}_XML.xml") ? base_url($folderPath . "{$serie}_XML.xml") : null,
                'cdr' => file_exists($fullPath . "{$serie}_CDR.xml") ? base_url($folderPath . "{$serie}_CDR.xml") : null,
            ];

            $contratosConArchivos[] = $c;
        }

        $data = [
            'session_id'   => $session->get('id'),
            'session_name' => $session->get('name') . " " . $session->get('lastname'),
            'title'        => 'Módulo Documentario',
            'contratos'    => $contratosConArchivos
        ];

        return view('admin/documentario/index', $data);
    }

    /**
     * Función para descargar el CDR como ZIP al vuelo
     */
    public function descargarCdrZip($serie)
    {
        $fileName = "{$serie}_CDR.xml";
        $filePath = FCPATH . "comprobantes/{$serie}/" . $fileName;

        if (file_exists($filePath)) {
            $zip = new \ZipArchive();
            $zipFile = WRITEPATH . "temp/{$serie}_CDR.zip";

            if ($zip->open($zipFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
                $zip->addFile($filePath, $fileName);
                $zip->close();

                return $this->response->download($zipFile, null)->setJSON(['success' => true]);
            }
        }
        return redirect()->back()->with('error', 'No se pudo generar el ZIP');
    }
}
