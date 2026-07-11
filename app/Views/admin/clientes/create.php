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
                                        <h5 class="m-b-10">Crear Nuevo Cliente</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a
                                                href="<?php echo site_url()."dashboard/panel";?>">Panel</a></li>
                                        <li class="breadcrumb-item"><a
                                                href="<?php echo site_url()."dashboard/clientes";?>">Clientes</a></li>
                                        <li class="breadcrumb-item"><a>Crear</a></li>
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
                                            <h5>Datos del Cliente</h5>
                                        </div>
                                        <div class="card-body">
                                            <form name="form-customer" id="form-customer" enctype="multipart/form-data"
                                                method="post" action="javascript:void(0);" onsubmit="createCustomer();"
                                                autocomplete="off">
                                                <input type="hidden" name="action" value="create">

                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label>Código</label>
                                                        <input class="form-control" type="text" id="code_preview"
                                                            value="Se genera automáticamente al guardar" readonly>
                                                        <small class="form-text text-muted">Se calcula con el país,
                                                            el ID y las iniciales del cliente.</small>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Contraseña <span class="text-danger">*</span></label>
                                                        <input class="form-control" type="password" id="password"
                                                            name="password" placeholder="Contraseña de acceso"
                                                            autocomplete="new-password" required>
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label>Nombre <span class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" id="name" name="name"
                                                            placeholder="Nombre" required>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Apellido Paterno <span
                                                                class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" id="lastname"
                                                            name="lastname" placeholder="Apellido Paterno" required>
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label>Apellido Materno</label>
                                                        <input class="form-control" type="text" id="mother_last"
                                                            name="mother_last" placeholder="Apellido Materno">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Tipo de Documento <span
                                                                class="text-danger">*</span></label>
                                                        <select class="form-control" id="document_type"
                                                            name="document_type" required>
                                                            <option value="dni" selected>DNI</option>
                                                            <option value="ruc">RUC</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label id="document_number_label">Documento <span
                                                                class="text-danger">*</span></label>
                                                        <input class="form-control" type="text"
                                                            id="document_number_display" placeholder="Ingrese documento"
                                                            inputmode="numeric" required>
                                                        <small class="form-text text-muted"
                                                            id="document_number_help">Ingresa el número del
                                                            documento.</small>
                                                        <input type="hidden" id="dni" name="dni" value="">
                                                        <input type="hidden" id="ruc" name="ruc" value="">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Email <span class="text-danger">*</span></label>
                                                        <input class="form-control" type="email" id="email" name="email"
                                                            placeholder="Email" required>
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label>Estado Civil</label>
                                                        <select class="form-control" id="civil_status"
                                                            name="civil_status">
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
                                                        <select class="form-control" id="tipo_agente"
                                                            name="tipo_agente">
                                                            <option value="">Seleccionar</option>
                                                            <option value="Interno">Interno</option>
                                                            <option value="Externo">Externo</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label>Teléfono</label>
                                                        <input class="form-control" type="text" id="phone" name="phone"
                                                            placeholder="Teléfono">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>País <span class="text-danger">*</span></label>
                                                        <select class="form-control" id="country_id" name="country_id"
                                                            required>
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
                                                        <input class="form-control" type="text" id="address"
                                                            name="address" placeholder="Dirección">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Estado</label>
                                                        <select class="form-control" id="active" name="active">
                                                            <option value="1">Activo</option>
                                                            <option value="0">No Activo</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label>Patrocinador</label>
                                                        <select class="form-control" id="sponsor_id" name="sponsor_id">
                                                            <option value="">Sin patrocinador asignado</option>
                                                            <?php if (isset($obj_sponsors) && is_array($obj_sponsors)): ?>
                                                            <?php foreach ($obj_sponsors as $sponsor): ?>
                                                            <?php
                                                                $sponsorId = (int) ($sponsor['id'] ?? 0);
                                                                $sponsorName = trim(($sponsor['name'] ?? '') . ' ' . ($sponsor['lastname'] ?? '') . ' ' . ($sponsor['mother_last'] ?? ''));
                                                                $sponsorCode = trim((string) ($sponsor['code'] ?? ''));
                                                                $sponsorDocument = trim((string) (($sponsor['dni'] ?? '') ?: ($sponsor['ruc'] ?? '')));
                                                            ?>
                                                            <option value="<?php echo $sponsorId; ?>">
                                                                <?php echo trim($sponsorCode . ' - ' . $sponsorName . ($sponsorDocument !== '' ? ' (' . $sponsorDocument . ')' : '')); ?>
                                                            </option>
                                                            <?php endforeach; ?>
                                                            <?php endif; ?>
                                                        </select>
                                                        <small class="form-text text-muted">Opcional. Se usara para
                                                            enlazar al cliente dentro de la red.</small>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary" id="submit">Crear
                                                        Cliente</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        onclick="cancelar_customer();">Cancelar</button>
                                                </div>
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

    <script src="<?php echo base_url('assets/admin/js/script/customer.js?2025'); ?>"></script>
    <script>
    (function() {
        const nameInput = document.getElementById('name');
        const lastNameInput = document.getElementById('lastname');
        const motherLastInput = document.getElementById('mother_last');
        const countrySelect = document.getElementById('country_id');
        const codePreview = document.getElementById('code_preview');

        if (!nameInput || !lastNameInput || !motherLastInput || !countrySelect || !codePreview) {
            return;
        }

        function getInitial(value, fallback) {
            const normalized = (value || '').trim();
            return normalized ? normalized.charAt(0).toUpperCase() : fallback;
        }

        function updateCodePreview() {
            const selectedOption = countrySelect.options[countrySelect.selectedIndex];
            const countryCode = selectedOption && selectedOption.value ? String(selectedOption.value).padStart(2,
                '0') : 'PA';
            const preview = countryCode + '00ID' +
                getInitial(lastNameInput.value, 'X') +
                getInitial(motherLastInput.value, 'X') +
                getInitial(nameInput.value, 'X');

            codePreview.value = preview + ' (referencial)';
        }

        [nameInput, lastNameInput, motherLastInput].forEach((input) => {
            input.addEventListener('input', updateCodePreview);
        });
        countrySelect.addEventListener('change', updateCodePreview);
        updateCodePreview();

        if (typeof initCustomerDocumentSelector === 'function') {
            initCustomerDocumentSelector(document);
        }
    })();
    </script>
    <?php echo view("admin/footer"); ?>
</body>

</html>