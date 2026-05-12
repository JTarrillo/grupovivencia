<html>
<?php echo view("admin/head"); ?>

<body data-new-gr-c-s-check-loaded="14.1042.0" data-gr-ext-installed="">
    <!-- LOAD CUSTOMER SCRIPT EARLY -->
    <script src="<?php echo base_url('assets/admin/js/script/customer.js?v=' . time()); ?>"></script>
    
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
                                                <button class="btn btn-success" type="button"
                                                    onclick="loadCreateCustomerModal();" title="Crear nuevo cliente">
                                                    <i class="fa fa-plus"></i> Crear Cliente
                                                </button>
                                                <button class="btn btn-primary" id="btn-export">
                                                    Exportar
                                                </button>
                                            </div>
                                        </div>
                                        <!-- Buscador por DNI y Nombre -->
                                        <div class="card-block">
                                            <div class="input-group mb-3" style="max-width: 350px;">
                                                <input type="text" id="searchDNIandNombre" class="form-control" placeholder="Buscar por DNI o Nombre...">
                                                <button class="btn btn-outline-secondary" type="button" onclick="limpiarBusqueda()">
                                                    <i class="fa fa-times"></i> Limpiar
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

    // Función de búsqueda por DNI y Nombre en un solo campo
    function filtrarTabla() {
        const searchText = document.getElementById('searchDNIandNombre').value.toUpperCase();
        const table = document.getElementById('zero-configuration');
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

        let totalVisible = 0;
        for (let i = 0; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td');
            
            // Columna 0: Cliente (Nombre)
            // Columna 1: DNI
            const nombre = cells[0] ? cells[0].textContent.toUpperCase() : '';
            const dni = cells[1] ? cells[1].textContent.toUpperCase() : '';

            // Mostrar fila si el texto coincide con DNI O con Nombre
            const match = searchText === '' || dni.includes(searchText) || nombre.includes(searchText);

            if (match) {
                rows[i].style.display = '';
                totalVisible++;
            } else {
                rows[i].style.display = 'none';
            }
        }
    }

    function limpiarBusqueda() {
        document.getElementById('searchDNIandNombre').value = '';
        filtrarTabla();
    }

    // Event listener para búsqueda en tiempo real
    document.getElementById('searchDNIandNombre').addEventListener('keyup', filtrarTabla);

    // Ocultar elementos por defecto de DataTables con CSS y JavaScript
    const style = document.createElement('style');
    style.textContent = '.dataTables_filter { display: none !important; } .dataTables_length { display: none !important; }';
    document.head.appendChild(style);

    // También intentar ocultarlos directamente después de un pequeño delay
    setTimeout(function() {
        const dataTables_filter = document.querySelector('.dataTables_filter');
        const dataTables_length = document.querySelector('.dataTables_length');
        if (dataTables_filter) {
            dataTables_filter.style.display = 'none';
        }
        if (dataTables_length) {
            dataTables_length.style.display = 'none';
        }
    }, 500);

    // Limpiar formulario cuando se cierre el modal
    const modalCreateCustomer = document.getElementById('modalCreateCustomer');
    if (modalCreateCustomer) {
        modalCreateCustomer.addEventListener('hidden.bs.modal', function() {
            document.getElementById('form-customer').innerHTML = '';
            document.getElementById('modalCreateCustomerLabel').textContent = 'Crear Nuevo Cliente';
            document.querySelector('#modalCreateCustomer .modal-footer .btn-primary').textContent =
                'Crear Cliente';
        });
    }
    </script>
    <script lang="javascript" src="https://cdn.sheetjs.com/xlsx-0.20.0/package/dist/xlsx.full.min.js"></script>

    <!-- Modal Crear Cliente -->
    <div class="modal fade" id="modalCreateCustomer" tabindex="-1" role="dialog"
        aria-labelledby="modalCreateCustomerLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCreateCustomerLabel">Crear Nuevo Cliente</h5>
                    <button type="button" class="close" onclick="$('#modalCreateCustomer').modal('hide');"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form name="form-customer" id="form-customer" enctype="multipart/form-data" method="post"
                        action="javascript:void(0);" onsubmit="submitCustomerForm();">
                        <input type="hidden" name="action" value="create">

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Nombre <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" id="name" name="name" placeholder="Nombre"
                                    required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Apellido Paterno <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" id="lastname" name="lastname"
                                    placeholder="Apellido Paterno" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Apellido Materno</label>
                                <input class="form-control" type="text" id="mother_last" name="mother_last"
                                    placeholder="Apellido Materno">
                            </div>
                            <div class="form-group col-md-6">
                                <label>DNI <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" id="dni" name="dni" placeholder="DNI" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>RUC</label>
                                <input class="form-control" type="text" id="ruc" name="ruc" placeholder="RUC">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Email <span class="text-danger">*</span></label>
                                <input class="form-control" type="email" id="email" name="email" placeholder="Email"
                                    required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Estado Civil</label>
                                <select class="form-control" id="civil_status" name="civil_status">
                                    <option value="">Seleccionar</option>
                                    <option value="Soltero">Soltero</option>
                                    <option value="Casado">Casado</option>
                                    <option value="Divorciado">Divorciado</option>
                                    <option value="Viudo">Viudo</option>
                                    <option value="Unión libre">Unión libre</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Tipo de Agente</label>
                                <select class="form-control" id="tipo_agente" name="tipo_agente">
                                    <option value="">Seleccionar</option>
                                    <option value="Interno">Interno</option>
                                    <option value="Externo">Externo</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>País <span class="text-danger">*</span></label>
                                <select class="form-control" id="country_id" name="country_id" required>
                                    <option value="">Seleccionar País</option>
                                    <?php if(isset($obj_paises)): ?>
                                    <?php foreach($obj_paises as $pais): ?>
                                    <option value="<?php echo $pais->id; ?>">
                                        <?php echo $pais->nombre; ?></option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Dirección</label>
                                <input class="form-control" type="text" id="address" name="address"
                                    placeholder="Dirección">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Estado</label>
                                <select class="form-control" id="active" name="active">
                                    <option value="1">Activo</option>
                                    <option value="0">No Activo</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        onclick="$('#modalCreateCustomer').modal('hide');">Cancelar</button>
                    <button type="button" class="btn btn-primary"
                        onclick="document.getElementById('form-customer').dispatchEvent(new Event('submit'));">Crear
                        Cliente</button>
                </div>
            </div>
        </div>
    </div>

    <?php echo view("admin/footer"); ?>