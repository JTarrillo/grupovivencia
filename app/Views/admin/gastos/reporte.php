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
                                        <h5 class="m-b-10">Reporte de Gastos</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="/dashboard/">Panel</a></li>
                                        <li class="breadcrumb-item"><a href="/dashboard/gastos">Gastos</a></li>
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
                                            <h5>Resumen General</h5>
                                        </div>
                                        <div class="card-block">
                                            <div class="row text-center">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label text-muted">Total Gastos</label>
                                                        <p class="mb-0">
                                                            <strong style="font-size: 1.3em; color: #d32f2f;">
                                                                S/. <?php 
                                                                    $total = 0;
                                                                    foreach ($gastos ?? [] as $g) {
                                                                        $total += $g['total'] ?? 0;
                                                                    }
                                                                    echo number_format($total, 2);
                                                                ?>
                                                            </strong>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label text-muted">Cantidad Registros</label>
                                                        <p class="mb-0">
                                                            <strong style="font-size: 1.3em; color: #1976d2;">
                                                                <?php echo count($gastos ?? []); ?>
                                                            </strong>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label text-muted">Promedio por Gasto</label>
                                                        <p class="mb-0">
                                                            <strong style="font-size: 1.3em; color: #388e3c;">
                                                                S/. <?php 
                                                                    $promedio = count($gastos ?? []) > 0 ? $total / count($gastos ?? []) : 0;
                                                                    echo number_format($promedio, 2);
                                                                ?>
                                                            </strong>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Detalle de Gastos</h5>
                                        </div>
                                        <div class="card-block">
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Comprobante</th>
                                                            <th>Fecha</th>
                                                            <th>Proveedor</th>
                                                            <th>Clasificación</th>
                                                            <th>Subtotal</th>
                                                            <th>IGV</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if (!empty($gastos)): ?>
                                                            <?php foreach ($gastos as $gasto): ?>
                                                                <tr>
                                                                    <td><?php echo $gasto['numero_comprobante']; ?></td>
                                                                    <td><?php echo date('d/m/Y', strtotime($gasto['fecha_compra'] ?? date('Y-m-d'))); ?></td>
                                                                    <td><?php echo $gasto['proveedor_nombre'] ?? 'N/A'; ?></td>
                                                                    <td>
                                                                        <?php 
                                                                            $clasificaciones = [
                                                                                '1' => 'Materiales',
                                                                                '2' => 'Servicios',
                                                                                '3' => 'Activos',
                                                                                '4' => 'Suministros',
                                                                                '5' => 'Otros'
                                                                            ];
                                                                            echo $clasificaciones[$gasto['clasificacion']] ?? 'N/A';
                                                                        ?>
                                                                    </td>
                                                                    <td class="text-end">S/. <?php echo number_format($gasto['subtotal'] ?? 0, 2); ?></td>
                                                                    <td class="text-end">S/. <?php echo number_format($gasto['igv'] ?? 0, 2); ?></td>
                                                                    <td class="text-end"><strong>S/. <?php echo number_format($gasto['total'] ?? 0, 2); ?></strong></td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <tr>
                                                                <td colspan="7" class="text-center p-4">
                                                                    <p class="text-muted">No hay gastos en este período</p>
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
                                    <a href="<?php echo base_url('dashboard/gastos'); ?>" class="btn btn-secondary">
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
