<html>
<?php echo view("admin/head"); ?>

<body>
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
                                        <h5 class="m-b-10">Detalles de Compra</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="/dashboard/">Panel</a></li>
                                        <li class="breadcrumb-item"><a href="/dashboard/compras">Compras</a></li>
                                        <li class="breadcrumb-item"><a>Ver</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Información de Compra <?php echo $compra['numero_comprobante'] ?? 'N/A'; ?></h5>
                                        </div>
                                        <div class="card-block">
                                            <div class="row mb-4">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label text-muted">Proveedor</label>
                                                        <p class="mb-0"><strong><?php echo $compra['proveedor_nombre'] ?? 'N/A'; ?></strong></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label text-muted">Comprobante</label>
                                                        <p class="mb-0"><strong><?php echo $compra['numero_comprobante'] ?? 'N/A'; ?></strong></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mb-4">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label text-muted">Tipo</label>
                                                        <p class="mb-0"><strong><?php echo $compra['tipo_comprobante'] ?? 'N/A'; ?></strong></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label text-muted">Fecha</label>
                                                        <p class="mb-0"><strong><?php echo date('d/m/Y', strtotime($compra['fecha_compra'] ?? date('Y-m-d'))); ?></strong></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row mb-4">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label text-muted">Subtotal</label>
                                                        <p class="mb-0"><strong>S/. <?php echo number_format($compra['subtotal'] ?? 0, 2); ?></strong></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label text-muted">IGV</label>
                                                        <p class="mb-0"><strong>S/. <?php echo number_format($compra['igv'] ?? 0, 2); ?></strong></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label text-muted">Total</label>
                                                        <p class="mb-0"><strong class="text-success" style="font-size: 1.2em;">S/. <?php echo number_format($compra['total'] ?? 0, 2); ?></strong></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="form-label text-muted">Descripción</label>
                                                <p class="mb-0"><?php echo $compra['descripcion'] ?? 'N/A'; ?></p>
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label text-muted">Estado</label>
                                                <p class="mb-0">
                                                    <span class="badge badge-<?php echo match($compra['estado']) { 'registrado' => 'warning', 'clasificado' => 'info', 'aprobado' => 'success', default => 'secondary' }; ?>">
                                                        <?php echo ucfirst($compra['estado']); ?>
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Acciones</h5>
                                        </div>
                                        <div class="card-block">
                                            <a href="<?php echo base_url('dashboard/compras'); ?>" class="btn btn-secondary w-100 mb-2">
                                                <i class="fa fa-arrow-left"></i> Volver
                                            </a>
                                            <?php if ($compra['pdf_url']): ?>
                                                <a href="<?php echo base_url('dashboard/compras/descargarComprobante/' . $compra['id']); ?>" class="btn btn-primary w-100 mb-2">
                                                    <i class="fa fa-download"></i> Descargar PDF
                                                </a>
                                            <?php endif; ?>
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
</html>
