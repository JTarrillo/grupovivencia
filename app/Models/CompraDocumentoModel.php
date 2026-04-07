<?php

namespace App\Models;

use CodeIgniter\Model;

class CompraDocumentoModel extends Model
{
    protected $table = 'compra_documentos';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'compra_id',
        'tipo_documento',
        'nombre_original',
        'ruta_archivo',
        'tipo_mime',
        'tamanio',
        'hash_archivo',
        'cargado_por',
        'descripcion'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';

    /**
     * Obtener documentos de una compra
     */
    public function porCompra($compraId)
    {
        return $this->where('compra_id', $compraId)
                    ->orderBy('tipo_documento', 'ASC')
                    ->orderBy('fecha_carga', 'DESC')
                    ->findAll();
    }

    /**
     * Obtener documentos por tipo
     */
    public function porTipo($compraId, $tipo)
    {
        return $this->where('compra_id', $compraId)
                    ->where('tipo_documento', $tipo)
                    ->orderBy('fecha_carga', 'DESC')
                    ->findAll();
    }

    /**
     * Eliminar documento físico y del BD
     */
    public function borrarDocumento($id)
    {
        $documento = $this->find($id);
        if (!$documento) return false;

        // Eliminar archivo físico
        if (file_exists(ROOTPATH . $documento['ruta_archivo'])) {
            @unlink(ROOTPATH . $documento['ruta_archivo']);
        }

        // Eliminar registro
        return $this->delete($id);
    }

    /**
     * Verificar integridad del archivo
     */
    public function verificarIntegridad($id)
    {
        $documento = $this->find($id);
        if (!$documento) return false;

        $ruta = ROOTPATH . $documento['ruta_archivo'];
        if (!file_exists($ruta)) return false;

        $hashActual = hash_file('sha256', $ruta);
        return $hashActual === $documento['hash_archivo'];
    }
}
