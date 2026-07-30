<?php
$peruCountryId = 89;
$peruCountryCode = '51';

if (isset($obj_paises) && is_iterable($obj_paises)) {
    foreach ($obj_paises as $pais) {
        $paisId = is_array($pais) ? ($pais['id'] ?? null) : ($pais->id ?? null);
        $paisNombre = trim((string) (is_array($pais) ? ($pais['nombre'] ?? '') : ($pais->nombre ?? '')));
        $paisWsp = trim((string) (is_array($pais) ? ($pais['id_wsp'] ?? '') : ($pais->id_wsp ?? '')));

        if ($paisWsp === '51' || stripos($paisNombre, 'Peru') !== false || stripos($paisNombre, 'Perú') !== false) {
            $peruCountryId = (int) $paisId;
            if ($paisWsp !== '') {
                $peruCountryCode = preg_replace('/\D+/', '', $paisWsp) ?: '51';
            }
            break;
        }
    }
}
?>
<!doctype html>
<html lang="es-PE">
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
                                        <h5 class="m-b-10">Formulario de Socio</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a
                                                href="<?php echo site_url() . "dashboard/panel"; ?>">Panel</a></li>
                                        <li class="breadcrumb-item"><a>Nuevo Socio</a></li>
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
                                            <h5>Nuevo Socio</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="alert alert-info mb-4" style="font-size: 1rem;">
                                                <strong>Nota:</strong> Todo usuario creado desde este formulario sera
                                                registrado como <span class="badge badge-primary">Agente Externo</span>
                                                automaticamente.
                                            </div>
                                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1">Registro guiado en modal</h6>
                                                    <p class="text-muted mb-0">Abre el formulario solo cuando lo
                                                        necesites y usa la tabla de abajo para revisar patrocinadores
                                                        activos.</p>
                                                </div>
                                                <button type="button" class="btn btn-primary mt-3 mt-md-0"
                                                    id="btnOpenNuevoSocioModal">
                                                    <i class="fa fa-plus-circle" aria-hidden="true"></i> Nuevo Socio
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Patrocinadores Activos</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered"
                                                    id="tablaSponsorsDisponibles">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Codigo</th>
                                                            <th>Nombre</th>
                                                            <th>Documento</th>
                                                            <th>Email</th>
                                                            <th>Accion</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if (isset($obj_sponsors) && is_array($obj_sponsors)): ?>
                                                        <?php foreach ($obj_sponsors as $sponsor): ?>
                                                        <?php
                                                                $sponsorId = (int) ($sponsor['id'] ?? 0);
                                                                $sponsorCode = trim((string) ($sponsor['code'] ?? ''));
                                                                $sponsorName = trim(($sponsor['name'] ?? '') . ' ' . ($sponsor['lastname'] ?? '') . ' ' . ($sponsor['mother_last'] ?? ''));
                                                                $sponsorDocument = trim((string) (($sponsor['dni'] ?? '') ?: ($sponsor['ruc'] ?? '')));
                                                                $sponsorEmail = trim((string) ($sponsor['email'] ?? ''));
                                                                $displayLabel = trim($sponsorCode . ' - ' . $sponsorName . ($sponsorDocument !== '' ? ' (' . $sponsorDocument . ')' : ''));
                                                                ?>
                                                        <tr>
                                                            <td><?php echo $sponsorId; ?></td>
                                                            <td><?php echo esc($sponsorCode); ?></td>
                                                            <td><?php echo esc($sponsorName); ?></td>
                                                            <td><?php echo esc($sponsorDocument); ?></td>
                                                            <td><?php echo esc($sponsorEmail); ?></td>
                                                            <td>
                                                                <button type="button"
                                                                    class="btn btn-sm btn-outline-primary btn-open-form-with-sponsor"
                                                                    data-sponsor-id="<?php echo $sponsorId; ?>"
                                                                    data-sponsor-label="<?php echo esc($displayLabel, 'attr'); ?>">
                                                                    Usar
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
            </div>
        </div>
    </section>
    <div class="modal fade" id="nuevoSocioModal" tabindex="-1" role="dialog" aria-labelledby="nuevoSocioModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevoSocioModalLabel">Registrar Nuevo Socio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height: 75vh; overflow-y: auto;">
                    <form name="form" action="javascript:void(0);" onsubmit="validate();" class="wpcf7-form"
                        method="post" enctype="multipart/form-data" autocomplete="off">
                        <input type="hidden" name="tipo_agente" value="externo" />
                        <input type="hidden" name="country_id" id="country_id"
                            data-default-country-id="<?php echo esc((string) $peruCountryId); ?>"
                            value="<?php echo esc((string) $peruCountryId); ?>" />
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <div class="form-group">
                                    <label>Patrocinador</label>
                                    <input type="hidden" name="sponsor_id" id="sponsor_id" required>
                                    <div class="input-group">
                                        <input type="text" id="sponsor_display" class="form-control"
                                            placeholder="Seleccione un patrocinador activo" readonly>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-info" id="btnOpenSponsorModal">
                                                Buscar
                                            </button>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">Solo se muestran patrocinadores activos.</small>
                                </div>
                                <div class="form-group">
                                    <label>DNI o cedula</label>
                                    <div class="input-group">
                                        <input type="text" placeholder="Ingrese DNI" name="dni" id="dni"
                                            autocomplete="new-password" minlength="8" class="form-control" required />
                                        <button type="button" class="btn btn-info" id="btnBuscarDni"
                                            title="Buscar datos por DNI">
                                            <i class="fa fa-search"></i> Buscar DNI
                                        </button>
                                    </div>
                                    <small id="dniSunatMsg" class="form-text text-muted"></small>
                                </div>
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input type="text" placeholder="Ingrese Nombre" name="name" autocomplete="off"
                                        class="form-control" required />
                                </div>
                                <div class="form-group">
                                    <label>Apellido Paterno</label>
                                    <input type="text" placeholder="Ingrese Apellido Paterno" name="lastname"
                                        autocomplete="off" class="form-control" required />
                                </div>
                                <div class="form-group">
                                    <label>Apellido Materno</label>
                                    <input type="text" placeholder="Ingrese Apellido Materno" name="motherLast"
                                        autocomplete="off" class="form-control" required />
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" placeholder="Ingrese Email" name="email" autocomplete="off"
                                        autocapitalize="off" autocorrect="off" spellcheck="false" class="form-control"
                                        required />
                                </div>
                                <div class="form-group">
                                    <label>Telefono</label>
                                    <input type="text" placeholder="Ingrese telefono" name="phone" autocomplete="off"
                                        class="form-control" required />
                                </div>
                                <div class="form-group">
                                    <label>Direccion</label>
                                    <input type="text" placeholder="Ingrese direccion" name="address" autocomplete="off"
                                        class="form-control" required />
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="form-group">
                                    <label>Estado civil</label>
                                    <select name="civil_status" class="form-control" required>
                                        <option value="">Seleccionar estado civil</option>
                                        <option value="Soltero">Soltero</option>
                                        <option value="Casado">Casado</option>
                                        <option value="Divorciado">Divorciado</option>
                                        <option value="Viudo">Viudo</option>
                                        <option value="Conviviente">Conviviente</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Pais</label>
                                    <div
                                        style="background: #e3f2fd; border-radius: 6px; padding: 12px 18px; display: flex; align-items: center; box-shadow: 0 1px 4px rgba(0,0,0,0.07);">
                                        <img src="https://flagcdn.com/48x36/pe.png" alt="Peru"
                                            style="width:32px;height:24px;margin-right:12px;border-radius:3px;box-shadow:0 0 2px #aaa;">
                                        <span style="font-weight:600; font-size: 17px; color:#1a237e;">Pais: Peru
                                            <span
                                                style="color:#1976d2;font-weight:400;">(+<?php echo esc($peruCountryCode); ?>)</span></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Contrasena</label>
                                    <input type="password" placeholder="Ingrese Contrasena" minlength="5"
                                        name="password" id="password" autocomplete="new-password" data-lpignore="true"
                                        class="form-control" required />
                                </div>
                                <div class="form-group">
                                    <label>Confirme contrasena</label>
                                    <input type="password" placeholder="Confirme Contrasena" minlength="5"
                                        name="confirm_password" id="confirm_password" onkeyup="validate_pass()"
                                        autocomplete="new-password" data-lpignore="true" class="form-control"
                                        required />
                                    <div class="alert-1"></div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" id="submit" class="btn btn-primary"><i class="fa fa-cloud"
                                aria-hidden="true"></i> Registrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="sponsorModal" tabindex="-1" role="dialog" aria-labelledby="sponsorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sponsorModalLabel">Seleccionar patrocinador</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="tablaPatrocinadoresModal">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Codigo</th>
                                    <th>Nombre</th>
                                    <th>Documento</th>
                                    <th>Email</th>
                                    <th>Accion</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($obj_sponsors) && is_array($obj_sponsors)): ?>
                                <?php foreach ($obj_sponsors as $sponsor): ?>
                                <?php
                                        $sponsorId = (int) ($sponsor['id'] ?? 0);
                                        $sponsorCode = trim((string) ($sponsor['code'] ?? ''));
                                        $sponsorName = trim(($sponsor['name'] ?? '') . ' ' . ($sponsor['lastname'] ?? '') . ' ' . ($sponsor['mother_last'] ?? ''));
                                        $sponsorDocument = trim((string) (($sponsor['dni'] ?? '') ?: ($sponsor['ruc'] ?? '')));
                                        $sponsorEmail = trim((string) ($sponsor['email'] ?? ''));
                                        $displayLabel = trim($sponsorCode . ' - ' . $sponsorName . ($sponsorDocument !== '' ? ' (' . $sponsorDocument . ')' : ''));
                                        ?>
                                <tr>
                                    <td><?php echo $sponsorId; ?></td>
                                    <td><?php echo esc($sponsorCode); ?></td>
                                    <td><?php echo esc($sponsorName); ?></td>
                                    <td><?php echo esc($sponsorDocument); ?></td>
                                    <td><?php echo esc($sponsorEmail); ?></td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary btn-select-sponsor"
                                            data-sponsor-id="<?php echo $sponsorId; ?>"
                                            data-sponsor-label="<?php echo esc($displayLabel, 'attr'); ?>">
                                            Elegir
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

    <style>
    .swal2-container {
        z-index: 20000 !important;
    }

    .swal2-popup {
        z-index: 20001 !important;
    }
    </style>

    <script
        src="<?php echo site_url() . "assets/admin/js/script/new_customer.js?v=" . @filemtime(FCPATH . "assets/admin/js/script/new_customer.js"); ?>">
    </script>

    <script>
    function consultarDniNuevoSocio() {
        var dni = document.getElementById('dni').value;
        var msg = document.getElementById('dniSunatMsg');
        msg.textContent = '';
        if (dni.length !== 8 || isNaN(dni)) {
            msg.textContent = 'Ingrese un DNI valido de 8 digitos.';
            return;
        }

        msg.textContent = 'Consultando SUNAT...';
        fetch('<?php echo site_url('api/consulta_dni'); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    dni: dni
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data && data.success) {
                    document.querySelector('input[name="name"]').value = data.nombres;
                    document.querySelector('input[name="lastname"]').value = data.apellidoPaterno;
                    document.querySelector('input[name="motherLast"]').value = data.apellidoMaterno;
                    msg.textContent = 'Datos encontrados y completados.';
                } else {
                    document.querySelector('input[name="name"]').value = '';
                    document.querySelector('input[name="lastname"]').value = '';
                    document.querySelector('input[name="motherLast"]').value = '';
                    msg.textContent = data.message || 'No se encontraron datos para el DNI ingresado.';
                }
            })
            .catch(() => {
                document.querySelector('input[name="name"]').value = '';
                document.querySelector('input[name="lastname"]').value = '';
                document.querySelector('input[name="motherLast"]').value = '';
                msg.textContent = 'Error al consultar el DNI.';
            });
    }

    function limpiarFormularioNuevoSocio() {
        var form = document.querySelector('form[name="form"]');
        if (!form) {
            return;
        }

        form.reset();

        var inputs = form.querySelectorAll('input');
        inputs.forEach(function(input) {
            if (input.type === 'hidden' || input.type === 'password') return;
            input.value = '';
            input.setAttribute('value', '');
        });

        var selects = form.querySelectorAll('select');
        selects.forEach(function(select) {
            select.selectedIndex = 0;
        });

        var sponsorInput = document.getElementById('sponsor_id');
        var sponsorDisplay = document.getElementById('sponsor_display');
        var countryInput = document.getElementById('country_id');
        var dniMsg = document.getElementById('dniSunatMsg');
        var passwordInput = document.getElementById('password');
        var confirmPasswordInput = document.getElementById('confirm_password');
        if (sponsorInput) sponsorInput.value = '';
        if (sponsorDisplay) sponsorDisplay.value = '';
        if (countryInput) {
            var defaultCountryId = countryInput.getAttribute('data-default-country-id') || countryInput.value ||
                '<?php echo esc((string) $peruCountryId); ?>';
            countryInput.value = String(defaultCountryId);
            countryInput.setAttribute('value', String(defaultCountryId));
        }
        if (dniMsg) dniMsg.textContent = '';
        if (passwordInput) {
            passwordInput.value = '';
            passwordInput.setAttribute('value', '');
            passwordInput.setAttribute('autocomplete', 'new-password');
        }
        if (confirmPasswordInput) {
            confirmPasswordInput.value = '';
            confirmPasswordInput.setAttribute('value', '');
            confirmPasswordInput.setAttribute('autocomplete', 'new-password');
        }

        inputs.forEach(function(input) {
            if (input.type !== 'hidden') {
                input.removeAttribute('value');
            }
            if (input.name === 'dni') {
                input.setAttribute('autocomplete', 'new-password');
            } else if (input.type === 'password') {
                input.setAttribute('autocomplete', 'new-password');
            } else {
                input.setAttribute('autocomplete', 'off');
            }
        });
    }

    window.addEventListener('DOMContentLoaded', function() {
        limpiarFormularioNuevoSocio();

        if (window.jQuery) {
            $('#btnOpenNuevoSocioModal').on('click', function() {
                console.log('[new_customer] click en btnOpenNuevoSocioModal', {
                    modalId: 'nuevoSocioModal',
                    source: 'boton_principal_nuevo_socio'
                });
                limpiarFormularioNuevoSocio();
                $('#nuevoSocioModal').modal('show');
            });

            $('#btnBuscarDni').on('click', consultarDniNuevoSocio);

            $('#btnOpenSponsorModal').on('click', function() {
                $('#sponsorModal').modal('show');
            });

            $(document).on('click', '.btn-open-form-with-sponsor', function() {
                var sponsorId = $(this).data('sponsor-id') || '';
                var sponsorLabel = $(this).data('sponsor-label') || '';
                console.log('[new_customer] apertura de modal con patrocinador', {
                    modalId: 'nuevoSocioModal',
                    sponsorId: sponsorId,
                    sponsorLabel: sponsorLabel,
                    source: 'tabla_patrocinadores'
                });
                limpiarFormularioNuevoSocio();
                $('#sponsor_id').val(String(sponsorId));
                $('#sponsor_display').val(String(sponsorLabel));
                $('#nuevoSocioModal').modal('show');
            });

            $('#nuevoSocioModal').on('show.bs.modal', function() {
                console.log('[new_customer] show.bs.modal disparado', {
                    modalId: 'nuevoSocioModal'
                });
            });

            $(document).on('click', '.btn-select-sponsor', function() {
                var sponsorId = $(this).data('sponsor-id') || '';
                var sponsorLabel = $(this).data('sponsor-label') || '';
                $('#sponsor_id').val(String(sponsorId));
                $('#sponsor_display').val(String(sponsorLabel));
                $('#sponsorModal').modal('hide');
            });

            if ($.fn.DataTable) {
                $('#tablaPatrocinadoresModal').DataTable({
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'
                    },
                    pageLength: 10,
                    order: [
                        [2, 'asc']
                    ]
                });

                $('#tablaSponsorsDisponibles').DataTable({
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'
                    },
                    pageLength: 10,
                    order: [
                        [2, 'asc']
                    ]
                });
            }
        }
    });

    var originalValidate = window.validate;
    window.validate = function() {
        var sponsorId = document.getElementById('sponsor_id');
        if (!sponsorId || !sponsorId.value) {
            if (typeof window.fireNewCustomerSwal === 'function') {
                window.fireNewCustomerSwal({
                    icon: 'info',
                    title: 'Seleccione un patrocinador activo',
                    confirmButtonText: 'Aceptar'
                });
            } else if (typeof Swal !== 'undefined' && Swal.fire) {
                Swal.fire({
                    icon: 'info',
                    title: 'Seleccione un patrocinador activo',
                    confirmButtonText: 'Aceptar'
                });
            }
            return;
        }

        if (typeof originalValidate === 'function') {
            originalValidate();
        }
    };
    </script>

    <link rel="stylesheet" href="">
    <?php echo view("admin/footer"); ?>