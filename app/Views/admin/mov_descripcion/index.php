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
                                        <h5 class="m-b-10">Descripciones de Movimiento</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="/dashboard/">Panel</a></li>
                                        <li class="breadcrumb-item"><a>Descripciones de Movimiento</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="main-body">
                        <div class="page-wrapper">

                            <!-- Formulario -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0"><i class="fa fa-plus-circle mr-2"></i><span id="formTitulo">Nueva Descripción</span></h5>
                                </div>
                                <div class="card-body">
                                    <form id="formDesc">
                                        <input type="hidden" id="descId" value="">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Nombre <span class="text-danger">*</span></label>
                                                    <input type="text" id="nombre" class="form-control" placeholder="Ej: Transferencias Bancarias" required>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Descripción (opcional)</label>
                                                    <input type="text" id="descripcion" class="form-control" placeholder="Detalle o nota">
                                                </div>
                                            </div>
                                            <div class="col-md-3 d-flex align-items-end">
                                                <button type="submit" class="btn btn-primary btn-block" id="btnGuardar">
                                                    <i class="fa fa-save mr-1"></i> Guardar
                                                </button>
                                                <button type="button" class="btn btn-secondary btn-block ml-2 mt-0" id="btnCancelar" style="display:none;">
                                                    Cancelar
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <div id="alerta" class="mt-2" style="display:none;"></div>
                                </div>
                            </div>

                            <!-- Listado -->
                            <div class="card">
                                <div class="card-header"><h5 class="mb-0"><i class="fa fa-list mr-2"></i>Listado</h5></div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nombre</th>
                                                    <th>Descripción</th>
                                                    <th>Estado</th>
                                                    <th class="text-right">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (empty($descripciones)): ?>
                                                    <tr><td colspan="5" class="text-center text-muted py-4">No hay descripciones aún.</td></tr>
                                                <?php else: ?>
                                                    <?php foreach ($descripciones as $i => $d): ?>
                                                    <tr>
                                                        <td><?= $i + 1 ?></td>
                                                        <td><strong><?= esc($d['nombre']) ?></strong></td>
                                                        <td><?= esc($d['descripcion'] ?: '—') ?></td>
                                                        <td>
                                                            <?php if ($d['activo']): ?>
                                                                <span class="badge badge-success">Activo</span>
                                                            <?php else: ?>
                                                                <span class="badge badge-secondary">Inactivo</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="text-right">
                                                            <button class="btn btn-sm btn-warning btn-editar"
                                                                data-id="<?= $d['id'] ?>"
                                                                data-nombre="<?= esc($d['nombre'], 'attr') ?>"
                                                                data-descripcion="<?= esc($d['descripcion'] ?? '', 'attr') ?>"
                                                                data-activo="<?= $d['activo'] ?>">
                                                                <i class="fa fa-edit"></i>
                                                            </button>
                                                            <button class="btn btn-sm btn-danger btn-eliminar" data-id="<?= $d['id'] ?>">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; ?>
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
    </section>

    <?php echo view("admin/footer"); ?>

<script>
const URL_STORE  = '<?= site_url('dashboard/mov_descripcion/store') ?>';
const URL_UPDATE = '<?= site_url('dashboard/mov_descripcion/update/') ?>';
const URL_DELETE = '<?= site_url('dashboard/mov_descripcion/delete/') ?>';

function resetForm() {
    $('#descId').val('');
    $('#nombre').val('');
    $('#descripcion').val('');
    $('#formTitulo').text('Nueva Descripción');
    $('#btnCancelar').hide();
}

$('#btnCancelar').on('click', resetForm);

$('#formDesc').on('submit', function(e) {
    e.preventDefault();
    const id = $('#descId').val();
    const data = {
        nombre:      $('#nombre').val(),
        descripcion: $('#descripcion').val(),
        activo:      1,
    };
    const url = id ? (URL_UPDATE + id) : URL_STORE;

    $('#btnGuardar').prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-1"></i>Guardando...');

    $.ajax({
        url, method: 'POST', data,
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        success(res) {
            if (res.success) {
                $('#alerta').html('<div class="alert alert-success">' + res.message + '</div>').show();
                setTimeout(() => location.reload(), 800);
            } else {
                $('#alerta').html('<div class="alert alert-danger">' + (res.error || 'Error') + '</div>').show();
            }
        },
        error() { $('#alerta').html('<div class="alert alert-danger">Error de conexión.</div>').show(); },
        complete() { $('#btnGuardar').prop('disabled', false).html('<i class="fa fa-save mr-1"></i>Guardar'); }
    });
});

$('.btn-editar').on('click', function() {
    $('#descId').val($(this).data('id'));
    $('#nombre').val($(this).data('nombre'));
    $('#descripcion').val($(this).data('descripcion'));
    $('#formTitulo').text('Editar Descripción');
    $('#btnCancelar').show();
    $('html, body').animate({ scrollTop: 0 }, 300);
});

$('.btn-eliminar').on('click', function() {
    if (!confirm('¿Eliminar esta descripción?')) return;
    $.ajax({
        url: URL_DELETE + $(this).data('id'),
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        success(res) { if (res.success) location.reload(); else alert(res.error || 'Error'); },
        error() { alert('Error de conexión.'); }
    });
});
</script>
</body>
</html>
