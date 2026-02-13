<html>
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
                                        <h5 class="m-b-10">Mantenimientos de Clientes</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="/dashboard/">Panel</a></li>
                                        <li class="breadcrumb-item"><a>Clientes</a></li>
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
                                        <div class="card-header">
                                            <div class="col-12 mb-3">
                                                <h5>Listado de Clientes</h5>
                                            </div>
                                            <div class="col-12">
                                                <button class="btn btn-primary" id="btn-export">
                                                    Exportar
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-block">
                                            <div class="table-responsive">
                                                <div id="zero-configuration_wrapper"
                                                    class="dataTables_wrapper dt-bootstrap4">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div id="zero-configuration_wrapper"
                                                                class="dataTables_wrapper dt-bootstrap4">
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <table id="zero-configuration"
                                                                            class="display table nowrap table-striped table-hover dataTable"
                                                                            style="width: 100%;" role="grid"
                                                                            aria-describedby="zero-configuration_info">
                                                                            <thead>
                                                                                <tr role="row">
                                                                                    <th>ID</th>
                                                                                    <th>Cliente</th>
                                                                                    <th>DNI</th>
                                                                                    <th>RUC</th>
                                                                                    <th>E-mail</th>
                                                                                    <th>Estado Civil</th>
                                                                                    <th>Tipo de Agente</th>
                                                                                    <!-- <th>Rango</th> -->
                                                                                    <th>País</th>
                                                                                    <th>Estado</th>
                                                                                    <th>Acciones</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php foreach ($obj_customer as $value) : ?>
                                                                                <tr>
                                                                                    <th><?php echo $value->id; ?></th>
                                                                                    <!-- Código eliminado -->
                                                                                    <td><?php echo $value->name . " " . $value->lastname . (isset($value->mother_last) && $value->mother_last ? " " . $value->mother_last : ""); ?>
                                                                                    </td>
                                                                                    <td><?php echo $value->dni; ?></td>
                                                                                    <td><?php echo $value->ruc; ?></td>
                                                                                    <td><?php echo $value->email; ?>
                                                                                    </td>
                                                                                    <td><?php echo isset($value->civil_status) ? $value->civil_status : ''; ?>
                                                                                    </td>
                                                                                    <td>
                                                                                        <?php
                                                                                        if (isset($value->tipo_agente) && !empty($value->tipo_agente)) {
                                                                                            if (strtolower($value->tipo_agente) == 'externo') {
                                                                                                // Externo: celeste claro
                                                                                                echo '<span style="background:#e0f7fa;color:#0277bd;padding:4px 10px;border-radius:5px;font-weight:bold;display:inline-block;">Externo</span>';
                                                                                            } else {
                                                                                                // Interno: igual que antes (gris oscuro)
                                                                                                echo '<span style="background:#ececec;color:#333;padding:4px 10px;border-radius:5px;font-weight:bold;display:inline-block;">Interno</span>';
                                                                                            }
                                                                                        }
                                                                                        ?>
                                                                                    </td>
                                                                                    <td>
                                                                                        <img src="<?php echo site_url() . 'assets/metronic8/media/flags/' . $value->img; ?>"
                                                                                            width="20"
                                                                                            style="border-radius:5px;">
                                                                                    </td>
                                                                                    <td>
                                                                                        <?php if ($value->active == 0) {
                                                                        $valor = "No Activo";
                                                                        $stilo = "label label-danger";
                                                                     } else {
                                                                        $valor = "Activo";
                                                                        $stilo = "label label-success";
                                                                     } ?>
                                                                                        <span
                                                                                            class="<?php echo $stilo; ?>"><?php echo $valor; ?></span>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="operation">
                                                                                            <div class="btn-group">
                                                                                                <button type="button"
                                                                                                    class="btn btn-icon btn-info"
                                                                                                    title="Editar"
                                                                                                    onclick="edit_customer('<?php echo $value->id; ?>');"><i
                                                                                                        class="fa fa-edit"></i></button>
                                                                                                <button type="button"
                                                                                                    class="btn btn-icon btn-warning"
                                                                                                    title="<?php echo $value->active == 1 ? 'Desactivar' : 'Activar'; ?>"
                                                                                                    onclick="toggleCliente('<?php echo $value->id; ?>', <?php echo $value->active; ?>);">
                                                                                                    <i
                                                                                                        class="fa <?php echo $value->active == 1 ? 'fa-user-slash' : 'fa-user-check'; ?>"></i>
                                                                                                </button>
                                                                                                <button type="button"
                                                                                                    class="btn btn-icon btn-danger"
                                                                                                    title="Eliminar"
                                                                                                    onclick="eliminar('<?php echo $value->id; ?>');"><i
                                                                                                        class="fa fa-trash"></i></button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <?php endforeach; ?>
                                                                            </tbody>
                                                                            <tfoot>
                                                                                <tr>
                                                                                    <th>ID</th>
                                                                                    <th>Cliente</th>
                                                                                    <th>DNI</th>
                                                                                    <th>RUC</th>
                                                                                    <th>E-mail</th>
                                                                                    <th>Estado Civil</th>
                                                                                    <th>Tipo de Agente</th>
                                                                                    <th>País</th>
                                                                                    <th>Estado</th>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
    function toggleCliente(id, estado) {
        const accion = estado == 1 ? 'desactivar' : 'activar';
        if (confirm('¿Seguro que deseas ' + accion + ' este cliente?')) {
            // Enviar como formulario clásico
            const params = new URLSearchParams();
            params.append('id', id);
            params.append('active', estado == 1 ? "0" : "1");
            fetch('/dashboard/clientes/validacion', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: params.toString()
                })
                .then(r => {
                    console.log('Raw response:', r);
                    return r.json();
                })
                .then(data => {
                    console.log('Parsed response:', data);
                    if (data.success) {
                        alert('Cliente actualizado correctamente');
                        location.reload();
                    } else {
                        alert('Error al actualizar el cliente');
                    }
                })
                .catch((err) => {
                    console.log('Fetch error:', err);
                    alert('Error de conexión');
                });
        }
    }

    // Función para eliminar cliente con SweetAlert y fetch
    function eliminar(id) {
        if (typeof Swal === 'undefined') {
            // Fallback si no está SweetAlert
            if (confirm('¿Estás seguro de eliminar este cliente?')) {
                fetch('/dashboard/clientes/eliminar', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'id=' + encodeURIComponent(id)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Eliminado correctamente');
                            location.reload();
                        } else {
                            alert('No se pudo eliminar el cliente.');
                        }
                    })
                    .catch(() => {
                        alert('Error de conexión.');
                    });
            }
            return;
        }
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('/dashboard/clientes/eliminar', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'id=' + encodeURIComponent(id)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Eliminado', 'El cliente ha sido eliminado.', 'success')
                                .then(() => location.reload());
                        } else {
                            Swal.fire('Error', 'No se pudo eliminar el cliente.', 'error');
                        }
                    })
                    .catch(() => {
                        Swal.fire('Error', 'Error de conexión.', 'error');
                    });
            }
        });
    }
    </script>

    <script>
    const btnExport = document.getElementById("btn-export");
    const data = <?php echo json_encode($obj_customer); ?>;
    console.log('obj_customer:', data);
    btnExport.addEventListener("click", () => {
        exportToExcel(data)
    })
    </script>
    <script lang="javascript" src="https://cdn.sheetjs.com/xlsx-0.20.0/package/dist/xlsx.full.min.js"></script>
    <script src="<?php echo base_url('assets/admin/js/script/customer.js?2025'); ?>"></script>
    <?php echo view("admin/footer"); ?>