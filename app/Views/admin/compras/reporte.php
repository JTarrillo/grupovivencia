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
                                        <h5 class="m-b-10">Reporte de Compras</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="/dashboard/">Panel</a></li>
                                        <li class="breadcrumb-item"><a href="/dashboard/compras">Compras</a></li>
                                        <li class="breadcrumb-item"><a>Reporte</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Filtros</h5>
                                        </div>
                                        <div class="card-block">
                                            <form method="GET" class="row g-3">
                                                <div class="col-md-3">
                                                    <label class="form-label">Fecha Inicio</label>
                                                    <input type="date" name="fecha_inicio" class="form-control" value="<?php echo $fecha_inicio ?? date('Y-m-01'); ?>">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">Fecha Fin</label>
                                                    <input type="date" name="fecha_fin" class="form-control" value="<?php echo $fecha_fin ?? date('Y-m-d'); ?>">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">Clasificación</label>
                                                    <select name="clasificacion" class="form-control">
                                                        <option value="">Todas</option>
                                                        <option value="1">Materiales</option>
                                                        <option value="2">Servicios</option>
                                                        <option value="3">Activos</option>
                                                        <option value="4">Suministros</option>
                                                        <option value="5">Otros</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3 d-flex align-items-end">
                                                    <button type="submit" class="btn btn-primary w-100">
                                                        <i class="fa fa-search"></i> Filtrar
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Detalle de Compras</h5>
                                        </div>
                                        <div class="card-block">
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Comprobante</th>
                                                            <th>Fecha</th>
                                                            <th>Proveedor</th>
                                                            <th>Subtotal</th>
                                                            <th>IGV</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            $totalGeneral = 0;
                                                            $igvGeneral = 0;
                                                        ?>
                                                        <?php if (!empty($compras)): ?>
                                                            <?php foreach ($compras as $compra): ?>
                                                                <tr>
                                                                    <td><?php echo $compra['numero_comprobante']; ?></td>
                                                                    <td><?php echo date('d/m/Y', strtotime($compra['fecha_compra'] ?? date('Y-m-d'))); ?></td>
                                                                    <td><?php echo $compra['proveedor_nombre'] ?? 'N/A'; ?></td>
                                                                    <td class="text-end">S/. <?php echo number_format($compra['subtotal'] ?? 0, 2); ?></td>
                                                                    <td class="text-end">S/. <?php echo number_format($compra['igv'] ?? 0, 2); ?></td>
                                                                    <td class="text-end"><strong>S/. <?php echo number_format($compra['total'] ?? 0, 2); ?></strong></td>
                                                                </tr>
                                                                <?php $totalGeneral += $compra['total'] ?? 0; ?>
                                                                <?php $igvGeneral += $compra['igv'] ?? 0; ?>
                                                            <?php endforeach; ?>
                                                            <tr style="background-color: #f1f1f1;">
                                                                <td colspan="3" class="text-end"><strong>TOTAL:</strong></td>
                                                                <td class="text-end"><strong>-</strong></td>
                                                                <td class="text-end"><strong>S/. <?php echo number_format($igvGeneral, 2); ?></strong></td>
                                                                <td class="text-end"><strong>S/. <?php echo number_format($totalGeneral, 2); ?></strong></td>
                                                            </tr>
                                                        <?php else: ?>
                                                            <tr>
                                                                <td colspan="6" class="text-center p-4">
                                                                    <p class="text-muted">No hay compras en este período</p>
                                                                </td>
                                                            </tr>
                                                        <?php endif; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <a href="<?php echo base_url('dashboard/compras'); ?>" class="btn btn-secondary">
                                        <i class="fa fa-arrow-left"></i> Volver
                                    </a>
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
