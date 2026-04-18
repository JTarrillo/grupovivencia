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
                                        <h5 class="m-b-10">Informe de Gastos por Período</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="<?= site_url('dashboard/clasificacion') ?>">Clasificación</a></li>
                                        <li class="breadcrumb-item"><a>Informe</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main-body">
                        <div class="page-wrapper">

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fa fa-file-invoice"></i>
                        Informe de Gastos por Período
                    </h4>
                </div>

                <div class="card-body">
                    <!-- Filtro de Fechas -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <form method="get" class="form-inline" id="formFiltro">
                                <div class="form-group mr-2">
                                    <label for="fecha_inicio" class="mr-2">Desde:</label>
                                    <input type="date" id="fecha_inicio" name="fecha_inicio" 
                                           class="form-control" value="<?php echo $fecha_inicio; ?>" required>
                                </div>
                                <div class="form-group mr-2">
                                    <label for="fecha_fin" class="mr-2">Hasta:</label>
                                    <input type="date" id="fecha_fin" name="fecha_fin" 
                                           class="form-control" value="<?php echo $fecha_fin; ?>" required>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search"></i> Filtrar
                                </button>
                                <button type="button" class="btn btn-success ml-2" onclick="exportarPDF()">
                                    <i class="fa fa-file-pdf"></i> Descargar PDF
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Información del Período -->
                    <div class="alert alert-info">
                        <p class="mb-0">
                            <strong>Período:</strong> 
                            <?php echo date('d/m/Y', strtotime($fecha_inicio)); ?> 
                            al 
                            <?php echo date('d/m/Y', strtotime($fecha_fin)); ?>
                            <span class="badge badge-primary ml-3"><?php echo $cantidadRegistros; ?> registros</span>
                        </p>
                    </div>

                    <!-- Tabla de Gastos por Concepto -->
                    <?php if (!empty($gastos)): ?>
                        <div class="table-responsive mb-4">
                            <table class="table table-hover table-sm" id="tablaGastos">
                                <thead class="bg-light">
                                    <tr>
                                        <th width="12%">Fecha</th>
                                        <th width="15%">Factura/Comprobante</th>
                                        <th width="30%">Concepto</th>
                                        <th width="20%">Tipo de Gasto</th>
                                        <th width="15%" class="text-right">Monto (S/.)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($gastos as $gasto): ?>
                                        <tr>
                                            <td><?php echo date('d/m/Y', strtotime($gasto['fecha_compra'])); ?></td>
                                            <td>
                                                <strong><?php echo $gasto['numero_comprobante']; ?></strong>
                                            </td>
                                            <td>
                                                <?php echo $gasto['observaciones'] ?? 'Sin observaciones'; ?>
                                            </td>
                                            <td>
                                                <span class="badge" style="background-color: <?php echo $gasto['color']; ?>; color: white;">
                                                    <?php echo $gasto['tipo_nombre'] ?? 'N/A'; ?>
                                                </span>
                                            </td>
                                            <td class="text-right">
                                                <strong><?php echo number_format($gasto['monto_compra'], 2, '.', ','); ?></strong>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Resumen por Concepto -->
                        <div class="card mt-4">
                            <div class="card-header bg-secondary text-white">
                                <h5 class="mb-0">Resumen por Concepto de Gasto</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-borderless table-sm">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>Concepto</th>
                                                <th class="text-center">Cantidad</th>
                                                <th class="text-right">Total (S/.)</th>
                                                <th class="text-right">% del Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($totalesPorTipo as $tipo => $datos): ?>
                                                <tr>
                                                    <td>
                                                        <span class="badge" style="background-color: <?php echo $datos['color']; ?>; color: white; padding: 8px 12px;">
                                                            <?php echo $tipo; ?>
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <strong><?php echo $datos['cantidad']; ?></strong>
                                                    </td>
                                                    <td class="text-right">
                                                        <strong>S/. <?php echo number_format($datos['total'], 2, '.', ','); ?></strong>
                                                    </td>
                                                    <td class="text-right">
                                                        <?php 
                                                            $porcentaje = ($totalGeneral > 0) ? ($datos['total'] / $totalGeneral) * 100 : 0;
                                                            echo number_format($porcentaje, 1, '.', ',') . '%';
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot class="bg-light">
                                            <tr>
                                                <th>TOTAL GENERAL</th>
                                                <th class="text-center">
                                                    <strong><?php echo array_sum(array_column($totalesPorTipo, 'cantidad')); ?></strong>
                                                </th>
                                                <th class="text-right">
                                                    <strong style="font-size: 1.1em; color: #28a745;">
                                                        S/. <?php echo number_format($totalGeneral, 2, '.', ','); ?>
                                                    </strong>
                                                </th>
                                                <th class="text-right">
                                                    <strong>100%</strong>
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                    <?php else: ?>
                        <div class="alert alert-warning">
                            <i class="fas fa-info-circle"></i>
                            No hay registros de gastos en el período seleccionado.
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
function exportarPDF() {
    const fecha_inicio = document.getElementById('fecha_inicio').value;
    const fecha_fin = document.getElementById('fecha_fin').value;
    
    if (!fecha_inicio || !fecha_fin) {
        Swal.fire({
            icon: 'warning',
            title: 'Campos requeridos',
            text: 'Por favor selecciona las fechas de inicio y fin.'
        });
        return;
    }
    
    // Redirigir a la descarga del PDF
    window.location.href = '<?php echo site_url('dashboard/clasificacion/descargar-informe-pdf'); ?>?fecha_inicio=' + fecha_inicio + '&fecha_fin=' + fecha_fin;
}

// Al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar DataTables si está disponible
    if (typeof $.fn.dataTable !== 'undefined') {
        $('#tablaGastos').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json'
            },
            pageLength: 25,
            order: [[0, 'asc']],
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    }
});
</script>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php echo view("admin/footer"); ?>
</body>
</html>
