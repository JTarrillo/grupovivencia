<!doctype html>
<html lang="es-PE">

<?php echo view("admin/head"); ?>

<body>
    <?php echo view("admin/header"); ?>
    
    <section class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Documentos Internos</h5>
                                                <a href="/dashboard/documental/crear_documento" class="btn btn-primary btn-sm float-right">
                                                    <i class="feather icon-plus"></i> Nuevo Documento
                                                </a>
                                                <span class="d-block m-t-5">Registro de documentos internos de la empresa</span>
                                            </div>
                                            <div class="card-block">
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>Título</th>
                                                                <th>Tipo</th>
                                                                <th>Estado</th>
                                                                <th>Responsable</th>
                                                                <th>Fecha Creación</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if (!empty($documentos)): ?>
                                                                <?php foreach ($documentos as $doc): ?>
                                                                    <tr>
                                                                        <td><strong><?php echo $doc['titulo']; ?></strong></td>
                                                                        <td><span class="label label-warning"><?php echo $doc['tipo_documento']; ?></span></td>
                                                                        <td>
                                                                            <?php 
                                                                            $estado = strtolower($doc['estado']);
                                                                            $class = ($estado == 'completado') ? 'label-success' : (($estado == 'borrador') ? 'label-danger' : 'label-info');
                                                                            ?>
                                                                            <span class="label <?php echo $class; ?>"><?php echo $doc['estado']; ?></span>
                                                                        </td>
                                                                        <td><?php echo $doc['usuario_responsable']; ?></td>
                                                                        <td><?php echo date('d/m/Y', strtotime($doc['fecha_creacion'])); ?></td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            <?php else: ?>
                                                                <tr><td colspan="5" class="text-center text-muted">No hay documentos registrados</td></tr>
                                                            <?php endif; ?>
                                                        </tbody>
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
        </div>
    </section>

    <?php echo view("admin/footer"); ?>
</body>
</html>
