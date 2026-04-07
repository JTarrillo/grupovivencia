<?php echo view("admin/head"); ?>

<body data-new-gr-c-s-check-loaded="14.1042.0" data-gr-ext-installed="">
    <?php echo view("admin/header"); ?>
    
    <section class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="page-header">
                        <div class="page-block">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <div class="page-header-title">
                                        <h5 class="m-b-10">Clasificar Compra</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="<?= site_url('dashboard/clasificacion') ?>">Clasificación</a></li>
                                        <li class="breadcrumb-item active">Clasificar</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="row">
                                <div class="col-md-8">
                                    <!-- Card información de compra -->
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <h5><i class="fa fa-receipt"></i> Detalles de la Compra</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="text-muted small">Número Comprobante</label>
                                                    <div class="fw-bold fs-6"><?= $compra['numero_comprobante'] ?></div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="text-muted small">Tipo Comprobante</label>
                                                    <div class="fw-bold fs-6"><?= $compra['tipo_comprobante'] ?></div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="text-muted small">Fecha Compra</label>
                                                    <div class="fw-bold fs-6"><?= date('d/m/Y', strtotime($compra['fecha_compra'])) ?></div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="text-muted small">Total</label>
                                                    <div class="fw-bold fs-6" style="color: #28a745;">S/ <?= number_format($compra['total'], 2) ?></div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="text-muted small">Descripción</label>
                                                    <div><?= $compra['descripcion'] ?? '-' ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Formulario clasificación -->
                                    <div class="card">
                                        <div class="card-header">
                                            <h5><i class="fa fa-tag"></i> Clasificación de Gasto</h5>
                                        </div>
                                        <div class="card-body">
                                <form id="formClasificacion" method="POST" action="<?= site_url('dashboard/clasificacion/guardarClasificacion') ?>">
                                    <input type="hidden" name="compra_id" value="<?= $compra['id'] ?>">
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Tipo de Gasto <span class="text-danger">*</span></label>
                                        <select name="gasto_tipo_id" id="gastoTipoId" class="form-control" required>
                                            <option value="">-- Seleccionar tipo --</option>
                                            <?php foreach ($tipos as $tipo): ?>
                                                <option value="<?= $tipo['id'] ?>" 
                                                    <?php if ($clasificacion && $clasificacion['gasto_tipo_id'] == $tipo['id']) echo 'selected'; ?>>
                                                    <i class="fa <?= $tipo['icono'] ?>"></i> <?= $tipo['nombre'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Subcategoría <span class="text-danger">*</span></label>
                                        <select name="gasto_subcategoria_id" id="subcategoriaId" class="form-control" required>
                                            <option value="">-- Primero seleccionar tipo --</option>
                                            <?php if ($clasificacion): ?>
                                                <?php 
                                                // Cargar subcategorías de la clasificación actual
                                                $model = new \App\Models\GastoSubcategoriaModel();
                                                $subs = $model->getPorTipo($clasificacion['gasto_tipo_id']);
                                                foreach ($subs as $sub):
                                                ?>
                                                    <option value="<?= $sub['id'] ?>" 
                                                        <?php if ($clasificacion['gasto_subcategoria_id'] == $sub['id']) echo 'selected'; ?>>
                                                        <?= $sub['nombre'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Proyecto (Opcional)</label>
                                        <select name="proyecto_id" class="form-control">
                                            <option value="">-- Ninguno --</option>
                                            <?php foreach ($proyectos as $proyecto): ?>
                                                <option value="<?= $proyecto['id'] ?>"
                                                    <?php if ($clasificacion && $clasificacion['proyecto_id'] == $proyecto['id']) echo 'selected'; ?>>
                                                    <?= $proyecto['name'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Contrato (Opcional)</label>
                                        <select name="contrato_id" class="form-control">
                                            <option value="">-- Ninguno --</option>
                                            <?php foreach ($contratos as $contrato): ?>
                                                <option value="<?= $contrato['id'] ?>"
                                                    <?php if ($clasificacion && $clasificacion['contrato_id'] == $contrato['id']) echo 'selected'; ?>>
                                                    <?= $contrato['contract_number'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Observaciones</label>
                                        <textarea name="observaciones" class="form-control" rows="3" placeholder="Notas adicionales..."><?php if ($clasificacion) echo $clasificacion['observaciones']; ?></textarea>
                                    </div>

                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <a href="<?= site_url('dashboard/clasificacion') ?>" class="btn btn-secondary">
                                            <i class="fa fa-times"></i> Cancelar
                                        </a>
                                        <button type="submit" class="btn btn-success">
                                            <i class="fa fa-save"></i> Guardar Clasificación
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                                    <div class="col-md-4">
                                        <!-- Card documentos -->
                                        <div class="card">
                                            <div class="card-header">
                                                <h5><i class="fa fa-file"></i> Documentos Adjuntos</h5>
                                            </div>
                                            <div class="card-body">
                                                <div id="documentosList">
                                                    <?php if (empty($documentos)): ?>
                                                        <div class="text-center text-muted py-4">
                                                            <i class="fa fa-inbox fa-2x mb-2"></i>
                                                            <p>Sin documentos adjuntos</p>
                                                        </div>
                                                    <?php else: ?>
                                                        <?php foreach ($documentos as $doc): ?>
                                                            <div class="document-item mb-2 p-2 border rounded" id="doc-<?= $doc['id'] ?>">
                                                                <div class="d-flex justify-content-between align-items-start">
                                                                    <div class="flex-grow-1">
                                                                        <small class="badge"><?= $doc['tipo_documento'] ?></small>
                                                                        <div class="small fw-bold mt-1"><?= $doc['nombre_original'] ?></div>
                                                                        <small class="text-muted"><?= number_format($doc['tamanio'] / 1024, 1) ?> KB</small>
                                                                    </div>
                                                                    <button type="button" class="btn btn-xs btn-danger" onclick="eliminarDocumento(<?= $doc['id'] ?>)">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </div>

                                                <hr>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label small fw-bold">Subir Documento</label>
                                                    <div class="mb-2">
                                                        <select id="tipoDocumento" class="form-select form-select-sm" required>
                                                            <option value="">-- Tipo de documento --</option>
                                                            <option value="factura">Factura</option>
                                                            <option value="recibo">Recibo</option>
                                                            <option value="foto">Fotografía</option>
                                                            <option value="otro">Otro</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <input type="file" id="archivoDocumento" class="form-control form-control-sm" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" required>
                                                        <small class="text-muted">PDF, JPG, PNG, DOC (max 10MB)</small>
                                                    </div>
                                                    <button type="button" class="btn btn-sm btn-primary w-100" onclick="subirDocumento(<?= $compra['id'] ?>)">
                                                        <i class="fa fa-upload"></i> Subir
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php echo view("admin/footer"); ?>
</body>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Al cambiar tipo de gasto, cargar subcategorías
    document.getElementById('gastoTipoId').addEventListener('change', function() {
        const tipoId = this.value;
        if (!tipoId) {
            document.getElementById('subcategoriaId').innerHTML = '<option value="">-- Primero seleccionar tipo --</option>';
            return;
        }

        fetch('<?= site_url('dashboard/clasificacion/subcategoriasPorTipo') ?>/' + tipoId)
            .then(r => r.json())
            .then(data => {
                let html = '<option value="">-- Seleccionar subcategoría --</option>';
                data.forEach(sub => {
                    html += `<option value="${sub.id}">${sub.nombre}</option>`;
                });
                document.getElementById('subcategoriaId').innerHTML = html;
            });
    });

    // Guardar clasificación
    document.getElementById('formClasificacion').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('<?= site_url('dashboard/clasificacion/guardarClasificacion') ?>', {
            method: 'POST',
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: data.message,
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = '<?= site_url('dashboard/clasificacion') ?>';
                });
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        });
    });
});

function subirDocumento(compraId) {
    const tipo = document.getElementById('tipoDocumento').value;
    const archivo = document.getElementById('archivoDocumento').files[0];
    
    if (!tipo || !archivo) {
        Swal.fire('Error', 'Selecciona tipo y archivo', 'error');
        return;
    }

    const formData = new FormData();
    formData.append('archivo', archivo);
    formData.append('tipo_documento', tipo);

    fetch(`<?= site_url('dashboard/clasificacion/subirDocumento') ?>/${compraId}`, {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            Swal.fire('Éxito', data.message, 'success');
            document.getElementById('tipoDocumento').value = '';
            document.getElementById('archivoDocumento').value = '';
            // Recargar documentos
            location.reload();
        } else {
            Swal.fire('Error', data.message, 'error');
        }
    });
}

function eliminarDocumento(docId) {
    Swal.fire({
        title: '¿Eliminar documento?',
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar'
    }).then(result => {
        if (result.isConfirmed) {
            fetch(`<?= site_url('dashboard/clasificacion/eliminarDocumento') ?>/${docId}`, {
                method: 'POST'
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('doc-' + docId).remove();
                    Swal.fire('Eliminado', data.message, 'success');
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            });
        }
    });
}
</script>
</html>
