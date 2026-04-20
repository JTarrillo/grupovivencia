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
                                        <h5 class="m-b-10">Catalogo de Gastos</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="<?= site_url('dashboard/clasificacion') ?>">Clasificacion</a></li>
                                        <li class="breadcrumb-item"><a>Catalogo</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="row mb-3">
                                <div class="col-sm-12 d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0"><i class="fa fa-tags"></i> Gestion de Tipos y Subcategorias</h5>
                                    <a href="<?= site_url('dashboard/clasificacion') ?>" class="btn btn-secondary btn-sm">
                                        <i class="fa fa-arrow-left"></i> Volver a Clasificacion
                                    </a>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-5">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5><i class="fa fa-plus-circle"></i> Nuevo Tipo de Gasto</h5>
                                        </div>
                                        <div class="card-body">
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalCrearTipo">
                                                <i class="fa fa-plus"></i> Agregar Tipo (Modal)
                                            </button>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header">
                                            <h5><i class="fa fa-list"></i> Tipos de Gasto</h5>
                                        </div>
                                        <div class="card-body table-responsive">
                                            <table class="table table-sm table-striped" id="tablaTipos">
                                                <thead>
                                                    <tr>
                                                        <th>Nombre</th>
                                                        <th>Color</th>
                                                        <th class="text-right">Accion</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbodyTipos">
                                                    <?php if (empty($tipos)): ?>
                                                        <tr id="filaTiposVacia">
                                                            <td colspan="3" class="text-muted text-center">Sin registros</td>
                                                        </tr>
                                                    <?php else: ?>
                                                        <?php foreach ($tipos as $tipo): ?>
                                                            <tr id="tipo-row-<?= (int) $tipo['id'] ?>">
                                                                <td>
                                                                    <span class="badge badge-light"><?= esc($tipo['nombre']) ?></span>
                                                                </td>
                                                                <td>
                                                                    <span class="badge" style="background: <?= esc($tipo['color'] ?: '#6c757d') ?>; color: #fff;">
                                                                        <?= esc($tipo['color'] ?: '#6c757d') ?>
                                                                    </span>
                                                                </td>
                                                                <td class="text-right">
                                                                    <form method="post" action="<?= site_url('dashboard/clasificacion/tipo/eliminar/' . $tipo['id']) ?>" class="d-inline-block js-delete-form" data-row-id="tipo-row-<?= (int) $tipo['id'] ?>" data-item-label="tipo de gasto">
                                                                        <?= csrf_field() ?>
                                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                                            <i class="fa fa-trash"></i>
                                                                        </button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-7">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5><i class="fa fa-plus-circle"></i> Nueva Subcategoria</h5>
                                        </div>
                                        <div class="card-body">
                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalCrearSubcategoria">
                                                <i class="fa fa-plus"></i> Agregar Subcategoria (Modal)
                                            </button>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header">
                                            <h5><i class="fa fa-sitemap"></i> Subcategorias Registradas</h5>
                                        </div>
                                        <div class="card-body table-responsive">
                                            <table class="table table-sm table-striped" id="tablaSubcategorias">
                                                <thead>
                                                    <tr>
                                                        <th>Tipo</th>
                                                        <th>Subcategoria</th>
                                                        <th class="text-right">Accion</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbodySubcategorias">
                                                    <?php if (empty($subcategorias)): ?>
                                                        <tr id="filaSubcategoriasVacia">
                                                            <td colspan="3" class="text-muted text-center">Sin registros</td>
                                                        </tr>
                                                    <?php else: ?>
                                                        <?php foreach ($subcategorias as $subcategoria): ?>
                                                            <tr id="subcategoria-row-<?= (int) $subcategoria['id'] ?>">
                                                                <td><span class="badge badge-info"><?= esc($subcategoria['tipo_nombre'] ?: 'Sin tipo') ?></span></td>
                                                                <td><?= esc($subcategoria['nombre']) ?></td>
                                                                <td class="text-right">
                                                                    <form method="post" action="<?= site_url('dashboard/clasificacion/subcategoria/eliminar/' . $subcategoria['id']) ?>" class="d-inline-block js-delete-form" data-row-id="subcategoria-row-<?= (int) $subcategoria['id'] ?>" data-item-label="subcategoria">
                                                                        <?= csrf_field() ?>
                                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                                            <i class="fa fa-trash"></i>
                                                                        </button>
                                                                    </form>
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
        </div>
    </section>

    <div class="modal fade" id="modalCrearTipo" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nuevo Tipo de Gasto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formCrearTipoModal" method="post" action="<?= site_url('dashboard/clasificacion/tipo/crear') ?>">
                    <div class="modal-body">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label>Nombre <span class="text-danger">*</span></label>
                            <input type="text" name="nombre" class="form-control" maxlength="100" required>
                        </div>
                        <div class="form-group">
                            <label>Icono (Font Awesome)</label>
                            <input type="text" name="icono" class="form-control" placeholder="fa fa-tag" maxlength="50">
                        </div>
                        <div class="form-group">
                            <label>Color (hex)</label>
                            <input type="text" name="color" class="form-control" placeholder="#6c757d" maxlength="20">
                        </div>
                        <div class="form-group mb-0">
                            <label>Descripcion</label>
                            <textarea name="descripcion" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Tipo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCrearSubcategoria" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nueva Subcategoria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formCrearSubcategoriaModal" method="post" action="<?= site_url('dashboard/clasificacion/subcategoria/crear') ?>">
                    <div class="modal-body">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label>Tipo de Gasto <span class="text-danger">*</span></label>
                            <select name="gasto_tipo_id" id="modalSubTipoSelect" class="form-control" required>
                                <option value="">-- Seleccione --</option>
                                <?php foreach ($tipos as $tipo): ?>
                                    <option value="<?= (int) $tipo['id'] ?>"><?= esc($tipo['nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nombre <span class="text-danger">*</span></label>
                            <input type="text" name="nombre" class="form-control" maxlength="100" required>
                        </div>
                        <div class="form-group mb-0">
                            <label>Descripcion</label>
                            <textarea name="descripcion" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Guardar Subcategoria</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php echo view("admin/footer"); ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let csrfName = <?= json_encode(csrf_token()) ?>;
        let csrfHash = <?= json_encode(csrf_hash()) ?>;

        function escapeHtml(str) {
            return String(str || '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function updateCsrf(name, hash) {
            if (!name || !hash) {
                return;
            }
            csrfName = name;
            csrfHash = hash;
            document.querySelectorAll('input[name="' + name + '"]').forEach((input) => {
                input.value = hash;
            });
        }

        async function postFormAjax(form) {
            const formData = new FormData(form);
            if (!formData.has(csrfName)) {
                formData.append(csrfName, csrfHash);
            }

            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            });

            const data = await response.json();
            updateCsrf(data.csrfName, data.csrfHash);

            if (!response.ok || !data.success) {
                throw new Error(data.message || 'Ocurrio un error en la solicitud.');
            }

            return data;
        }

        async function manejarEliminacion(event) {
            event.preventDefault();
            const form = event.currentTarget;
            const rowId = form.dataset.rowId;
            const itemLabel = form.dataset.itemLabel || 'registro';

            const result = await Swal.fire({
                title: 'Confirmar eliminacion',
                text: 'Se eliminara este ' + itemLabel + '. Esta accion no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Si, eliminar',
                cancelButtonText: 'Cancelar'
            });

            if (!result.isConfirmed) {
                return;
            }

            try {
                const data = await postFormAjax(form);
                const row = document.getElementById(rowId);
                if (row) {
                    row.remove();
                }

                if (itemLabel === 'tipo de gasto' && !document.querySelector('#tbodyTipos tr[id^="tipo-row-"]')) {
                    document.getElementById('tbodyTipos').innerHTML = '<tr id="filaTiposVacia"><td colspan="3" class="text-muted text-center">Sin registros</td></tr>';
                }

                if (itemLabel === 'subcategoria' && !document.querySelector('#tbodySubcategorias tr[id^="subcategoria-row-"]')) {
                    document.getElementById('tbodySubcategorias').innerHTML = '<tr id="filaSubcategoriasVacia"><td colspan="3" class="text-muted text-center">Sin registros</td></tr>';
                }

                Swal.fire({
                    icon: 'success',
                    title: 'Exito',
                    text: data.message,
                    timer: 1300,
                    showConfirmButton: false
                });
            } catch (error) {
                Swal.fire('Error', error.message, 'error');
            }
        }

        document.querySelectorAll('.js-delete-form').forEach((form) => {
            form.addEventListener('submit', manejarEliminacion);
        });

        document.getElementById('formCrearTipoModal').addEventListener('submit', async function(event) {
            event.preventDefault();
            const form = event.currentTarget;
            try {
                const data = await postFormAjax(form);

                const filaVacia = document.getElementById('filaTiposVacia');
                if (filaVacia) {
                    filaVacia.remove();
                }

                const tbody = document.getElementById('tbodyTipos');
                const tipo = data.tipo;
                const color = escapeHtml(tipo.color || '#6c757d');
                const nombre = escapeHtml(tipo.nombre || '');
                const eliminarUrl = <?= json_encode(site_url('dashboard/clasificacion/tipo/eliminar/')) ?> + tipo.id;

                const row = document.createElement('tr');
                row.id = 'tipo-row-' + tipo.id;
                row.innerHTML = '' +
                    '<td><span class="badge badge-light">' + nombre + '</span></td>' +
                    '<td><span class="badge" style="background:' + color + '; color:#fff;">' + color + '</span></td>' +
                    '<td class="text-right">' +
                    '  <form method="post" action="' + eliminarUrl + '" class="d-inline-block js-delete-form" data-row-id="tipo-row-' + tipo.id + '" data-item-label="tipo de gasto">' +
                    '    <input type="hidden" name="' + escapeHtml(csrfName) + '" value="' + escapeHtml(csrfHash) + '">' +
                    '    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>' +
                    '  </form>' +
                    '</td>';

                tbody.prepend(row);
                row.querySelector('.js-delete-form').addEventListener('submit', manejarEliminacion);

                const subTipoSelect = document.getElementById('modalSubTipoSelect');
                const option = document.createElement('option');
                option.value = tipo.id;
                option.textContent = tipo.nombre;
                subTipoSelect.appendChild(option);

                form.reset();
                $('#modalCrearTipo').modal('hide');

                Swal.fire({
                    icon: 'success',
                    title: 'Exito',
                    text: data.message,
                    timer: 1400,
                    showConfirmButton: false
                });
            } catch (error) {
                Swal.fire('Error', error.message, 'error');
            }
        });

        document.getElementById('formCrearSubcategoriaModal').addEventListener('submit', async function(event) {
            event.preventDefault();
            const form = event.currentTarget;
            try {
                const data = await postFormAjax(form);

                const filaVacia = document.getElementById('filaSubcategoriasVacia');
                if (filaVacia) {
                    filaVacia.remove();
                }

                const tbody = document.getElementById('tbodySubcategorias');
                const sub = data.subcategoria;
                const tipoNombre = escapeHtml(sub.tipo_nombre || 'Sin tipo');
                const nombre = escapeHtml(sub.nombre || '');
                const eliminarUrl = <?= json_encode(site_url('dashboard/clasificacion/subcategoria/eliminar/')) ?> + sub.id;

                const row = document.createElement('tr');
                row.id = 'subcategoria-row-' + sub.id;
                row.innerHTML = '' +
                    '<td><span class="badge badge-info">' + tipoNombre + '</span></td>' +
                    '<td>' + nombre + '</td>' +
                    '<td class="text-right">' +
                    '  <form method="post" action="' + eliminarUrl + '" class="d-inline-block js-delete-form" data-row-id="subcategoria-row-' + sub.id + '" data-item-label="subcategoria">' +
                    '    <input type="hidden" name="' + escapeHtml(csrfName) + '" value="' + escapeHtml(csrfHash) + '">' +
                    '    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>' +
                    '  </form>' +
                    '</td>';

                tbody.prepend(row);
                row.querySelector('.js-delete-form').addEventListener('submit', manejarEliminacion);

                form.reset();
                $('#modalCrearSubcategoria').modal('hide');

                Swal.fire({
                    icon: 'success',
                    title: 'Exito',
                    text: data.message,
                    timer: 1400,
                    showConfirmButton: false
                });
            } catch (error) {
                Swal.fire('Error', error.message, 'error');
            }
        });

        <?php if (session()->getFlashdata('success')): ?>
        Swal.fire({
            icon: 'success',
            title: 'Exito',
            text: <?= json_encode(session()->getFlashdata('success')) ?>
        });
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: <?= json_encode(session()->getFlashdata('error')) ?>
        });
        <?php endif; ?>
    </script>
</body>

</html>
