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
                                            <h5>Datos</h5>
                                        </div>
                                        <div class="card-body">
                                            <!-- AVISO DE TIPO DE AGENTE -->
                                            <div class="alert alert-info" style="font-size: 1rem;">
                                                <strong>Nota:</strong> Todo usuario creado desde este formulario será
                                                registrado como <span class="badge badge-primary">Agente Externo</span>
                                                automáticamente.
                                            </div>
                                            <form name="form" action="javascript:void(0);" onsubmit="validate();"
                                                class="wpcf7-form" method="post" enctype="multipart/form-data">
                                                <input type="hidden" name="tipo_agente" value="externo" />
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <div class="form-group">
                                                            <!-- Campo Estado civil movido más abajo -->
                                                            <label>Patrocinador</label>
                                                            <select name="sponsor_id"
                                                                style="border-radius: 3px 0px 0px 3px;" required
                                                                class="selectpicker form-control"
                                                                data-live-search="true">
                                                                <option value="">Seleccionar patrocinador</option>
                                                                <?php foreach ($obj_sponsors as $value) : ?>
                                                                <option value="<?php echo $value->id; ?>">
                                                                    <?php echo $value->code . "  - (" . $value->name . " " . $value->lastname . ")"; ?>
                                                                </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>DNI o cédula</label>
                                                            <div class="input-group">
                                                                <input type="text" placeholder="Ingrese DNI" name="dni"
                                                                    id="dni" autocomplete="off" minlength="8"
                                                                    class="form-control" required />
                                                                <button type="button" class="btn btn-info"
                                                                    id="btnBuscarDni" title="Buscar datos por DNI">
                                                                    <i class="fa fa-search"></i> Buscar DNI
                                                                </button>
                                                            </div>
                                                            <small id="dniSunatMsg"
                                                                class="form-text text-muted"></small>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>DNI o cédula</label>
                                                            <input type="text" placeholder="Ingrese DNI" name="dni"
                                                                autocomplete="off" minlength="8" class="form-control"
                                                                required />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Contraseña</label>
                                                            <input type="password" placeholder="Ingrese Contraseña"
                                                                minlength="5" name="password" id="password"
                                                                autocomplete="off" class="form-control" required />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Confirme contraseña</label>
                                                            <input type="password" placeholder="Confirme Contraseña"
                                                                minlength="5" name="confirm_password"
                                                                id="confirm_password" onkeyup="validate_pass()"
                                                                autocomplete="off" class="form-control" required />
                                                            <div class="alert-1"></div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Nombre</label>
                                                            <input type="text" placeholder="Ingrese Nombre" name="name"
                                                                autocomplete="off" class="form-control" required />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Apellido Paterno</label>
                                                            <input type="text" placeholder="Ingrese Apellido Paterno"
                                                                name="lastname" autocomplete="off" class="form-control"
                                                                required />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Apellido Materno</label>
                                                            <input type="text" placeholder="Ingrese Apellido Materno"
                                                                name="motherLast" autocomplete="off"
                                                                class="form-control" required />
                                                        </div>
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
                                                            <label>DNI o cédula</label>
                                                            <input type="text" placeholder="Ingrese DNI" name="dni"
                                                                autocomplete="off" minlength="8" class="form-control"
                                                                required />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>DNI o cédula</label>
                                                            <div class="input-group">
                                                                <input type="text" placeholder="Ingrese DNI" name="dni"
                                                                    id="dni" autocomplete="off" minlength="8"
                                                                    class="form-control" required />
                                                                <button type="button" class="btn btn-info"
                                                                    id="btnBuscarDni" title="Buscar datos por DNI">
                                                                    <i class="fa fa-search"></i> Buscar DNI
                                                                </button>
                                                            </div>
                                                            <small id="dniSunatMsg"
                                                                class="form-text text-muted"></small>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <div class="form-group">
                                                            <label>Teléfono</label>
                                                            <input type="text" placeholder="Ingrese teléfono"
                                                                name="phone" autocomplete="off" class="form-control"
                                                                required />
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Dirección</label>
                                                            <input type="text" placeholder="Ingrese dirección"
                                                                name="address" autocomplete="off" class="form-control"
                                                                required />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Email</label>
                                                            <input type="email" placeholder="Ingrese Email" name="email"
                                                                autocomplete="off" class="form-control" required />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>País</label>
                                                            <select name="country_id" id="country_id"
                                                                class="form-control" required>
                                                                <option value="">Seleccionar País...</option>
                                                                <option value="5">Argentina (+54)</option>
                                                                <option value="123">Bolivia (+591)</option>
                                                                <option value="12">Brasil (+55)</option>
                                                                <option value="81">Chile (+56)</option>
                                                                <option value="82">Colombia (+57)</option>
                                                                <option value="36">Costa Rica (+506)</option>
                                                                <option value="113">Cuba (+53)</option>
                                                                <option value="103">Ecuador (+593)</option>
                                                                <option value="51">El Salvador (+503)</option>
                                                                <option value="185">Guatemala (+502)</option>
                                                                <option value="42">México (+52)</option>
                                                                <option value="209">Nicaragua (+505)</option>
                                                                <option value="124">Panamá (+507)</option>
                                                                <option value="89">Perú (+51)</option>
                                                                <option value="246">Puerto Rico (+1)</option>
                                                                <option value="138">República Dominicana (+1809)
                                                                </option>
                                                                <option value="111">Uruguay (+598)</option>
                                                                <option value="95">Venezuela (+58)</option>
                                                            </select>
                                                        </div>
                                                        <script>
                                                        document.getElementById('btnBuscarDni')
                                                            .addEventListener('click', function() {
                                                                var dni = document.getElementById('dni').value;
                                                                var msg = document.getElementById('dniSunatMsg');
                                                                msg.textContent = '';
                                                                if (dni.length !== 8 || isNaN(dni)) {
                                                                    msg.textContent =
                                                                        'Ingrese un DNI válido de 8 dígitos.';
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
                                                                            // Usar name en vez de id
                                                                            document.querySelector(
                                                                                    'input[name="name"]')
                                                                                .value = data.nombres;
                                                                            document.querySelector(
                                                                                    'input[name="lastname"]')
                                                                                .value = data.apellidoPaterno;
                                                                            document.querySelector(
                                                                                    'input[name="motherLast"]')
                                                                                .value = data.apellidoMaterno;
                                                                            msg.textContent =
                                                                                'Datos encontrados y completados.';
                                                                        } else {
                                                                            document.querySelector(
                                                                                    'input[name="name"]')
                                                                                .value = '';
                                                                            document.querySelector(
                                                                                    'input[name="lastname"]')
                                                                                .value = '';
                                                                            document.querySelector(
                                                                                    'input[name="motherLast"]')
                                                                                .value = '';
                                                                            msg.textContent = data.message ||
                                                                                'No se encontraron datos para el DNI ingresado.';
                                                                        }
                                                                    })
                                                                    .catch(() => {
                                                                        document.querySelector(
                                                                            'input[name="name"]').value = '';
                                                                        document.querySelector(
                                                                                'input[name="lastname"]')
                                                                            .value = '';
                                                                        document.querySelector(
                                                                                'input[name="motherLast"]')
                                                                            .value = '';
                                                                        msg.textContent =
                                                                            'Error al consultar el DNI.';
                                                                    });
                                                            });
                                                        </script>
                                                    </div>
                                                </div>
                                                <button type="submit" id="submit" class="btn btn-primary"><i
                                                        class="fa fa-cloud" aria-hidden="true"></i>Registrar</button>
                                            </form>
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
    <script src='<?php echo site_url() . 'assets/js/script/new_registro.js?20232'; ?>'></script>
    <script src="<?php echo site_url() . "assets/admin/js/script/new_customer.js"; ?>"></script>

    <!-- LIVE SEARCH -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

    <script>
    // Limpiar todos los campos del formulario al cargar la página
    window.addEventListener('DOMContentLoaded', function() {
        var form = document.querySelector('form[name="form"]');
        if (form) {
            // Limpiar todos los inputs excepto password y hidden
            var inputs = form.querySelectorAll('input');
            inputs.forEach(function(input) {
                if (input.type === 'hidden' || input.type === 'password') return;
                input.value = '';
            });
            // Limpiar todos los selects
            var selects = form.querySelectorAll('select');
            selects.forEach(function(select) {
                select.selectedIndex = 0;
            });
        }
    });
    </script>

    <link rel="stylesheet" href="">
    <?php echo view("admin/footer"); ?>