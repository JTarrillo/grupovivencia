<!doctype html>
<html lang="es-PE">
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
                                        <h5 class="m-b-10">Penalidades</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="/dashboard/panel">Panel</a></li>
                                        <li class="breadcrumb-item"><a>Penalidades</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h5>Listado de Penalidades</h5>
                                            <form method="post" action="/dashboard/penalties/applyPenalties" style="margin:0;">
                                                <button type="submit" class="btn btn-outline-primary btn-sm">
                                                    <i class="fa fa-refresh"></i> Actualizar penalidades
                                                </button>
                                            </form>
                                        </div>
                                        <div class="card-block">
                                            <div class="table-responsive">
                                                <table class="display table nowrap table-striped table-hover dataTable"
                                                    style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Contrato</th>
                                                            <th>Usuario</th>
                                                            <th>Tipo</th>
                                                            <th>Monto</th>
                                                            <th>Notas</th>
                                                            <th>Estado</th>
                                                            <th>Fecha</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if (!empty($penalties)): ?>
                                                        <?php foreach ($penalties as $penalty): ?>
                                                        <tr>
                                                            <td><?php echo $penalty['id']; ?></td>
                                                            <td><span
                                                                    class="badge badge-info">#<?php echo $penalty['contract_id']; ?></span>
                                                            </td>
                                                            <td><?php echo $penalty['user_id'] ?? '-'; ?></td>
                                                            <td><span
                                                                    class="badge badge-warning"><?php echo ucfirst($penalty['type']); ?></span>
                                                            </td>
                                                            <td><b class="text-primary">S/
                                                                    <?php echo number_format($penalty['amount'], 2); ?></b>
                                                            </td>
                                                            <td><?php echo $penalty['notes']; ?></td>
                                                            <td>
                                                                <?php 
                                                                    $valor = $penalty['status'] ?? 'pendiente';
                                                                    $stilo = 'label label-secondary';
                                                                    if ($valor == 'pagada') {
                                                                        $stilo = 'label label-success';
                                                                    } elseif ($valor == 'pendiente') {
                                                                        $stilo = 'label label-warning';
                                                                    }
                                                                    ?>
                                                                <span
                                                                    class="<?php echo $stilo; ?>"><?php echo ucfirst($valor); ?></span>
                                                            </td>
                                                            <td><?php echo $penalty['created_at'] ?? '-'; ?></td>
                                                            <td>
                                                                <div class="operation">
                                                                    <div class="btn-group">
                                                                        <a href="/dashboard/penalties/view/<?php echo $penalty['id']; ?>"
                                                                            class="btn btn-icon btn-info"
                                                                            title="Ver Detalle"><i
                                                                                class="fa fa-list"></i></a>
                                                                        <?php if (($penalty['status'] ?? 'pendiente') !== 'pagada'): ?>
                                                                        <form method="post"
                                                                            action="/dashboard/penalties/mark_paid"
                                                                            style="display:inline;">
                                                                            <input type="hidden" name="id"
                                                                                value="<?php echo $penalty['id']; ?>">
                                                                            <button type="submit"
                                                                                class="btn btn-icon btn-success"
                                                                                title="Marcar como pagada"><i
                                                                                    class="fa fa-check"></i></button>
                                                                        </form>
                                                                        <?php endif; ?>
                                                                        <form method="post"
                                                                            action="/dashboard/penalties/delete"
                                                                            style="display:inline;"
                                                                            onsubmit="return confirm('¿Eliminar penalidad?');">
                                                                            <input type="hidden" name="id"
                                                                                value="<?php echo $penalty['id']; ?>">
                                                                            <button type="submit"
                                                                                class="btn btn-icon btn-danger"
                                                                                title="Eliminar"><i
                                                                                    class="fa fa-trash"></i></button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php endforeach; ?>
                                                        <?php else: ?>
                                                        <tr>
                                                            <td colspan="9" class="text-center text-muted">No hay
                                                                penalidades registradas.</td>
                                                        </tr>
                                                        <?php endif; ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Contrato</th>
                                                            <th>Usuario</th>
                                                            <th>Tipo</th>
                                                            <th>Monto</th>
                                                            <th>Notas</th>
                                                            <th>Estado</th>
                                                            <th>Fecha</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
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

</html>