<?php
$selectedSponsorId = isset($obj_sponsor->customer_id) ? (int) $obj_sponsor->customer_id : 0;
?>
<form name="form-customer" id="form-customer" enctype="multipart/form-data" method="post" action="javascript:void(0);" onsubmit="submitCustomerForm();" autocomplete="off">
    <?php if(isset($obj_customer) && $obj_customer): ?>
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="customer_id" id="customer_id" value="<?php echo $obj_customer->id; ?>">
    <?php else: ?>
        <input type="hidden" name="action" value="create">
    <?php endif; ?>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label>Código</label>
            <input class="form-control" type="text" id="code_preview"
                value="<?php echo isset($obj_customer->code) && $obj_customer->code ? $obj_customer->code : 'Se genera automáticamente al guardar'; ?>"
                <?php echo isset($obj_customer) && $obj_customer ? '' : 'readonly'; ?>>
            <small class="form-text text-muted">
                <?php echo isset($obj_customer) && $obj_customer ? 'Puedes ajustarlo manualmente si fuera necesario.' : 'Se genera usando país, ID e iniciales.'; ?>
            </small>
        </div>
        <div class="form-group col-md-6">
            <label>Contraseña <?php echo isset($obj_customer) && $obj_customer ? '' : '<span class="text-danger">*</span>'; ?></label>
            <input class="form-control" type="password" id="password" name="password"
                placeholder="<?php echo isset($obj_customer) && $obj_customer ? 'Solo si deseas cambiarla' : 'Contraseña de acceso'; ?>"
                autocomplete="new-password" <?php echo isset($obj_customer) && $obj_customer ? '' : 'required'; ?>>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label>Nombre <span class="text-danger">*</span></label>
            <input class="form-control" type="text" id="name" name="name" placeholder="Nombre" 
                value="<?php echo isset($obj_customer->name) ? $obj_customer->name : ''; ?>" required>
        </div>
        <div class="form-group col-md-6">
            <label>Apellido Paterno <span class="text-danger">*</span></label>
            <input class="form-control" type="text" id="lastname" name="lastname" placeholder="Apellido Paterno"
                value="<?php echo isset($obj_customer->lastname) ? $obj_customer->lastname : ''; ?>" required>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label>Apellido Materno</label>
            <input class="form-control" type="text" id="mother_last" name="mother_last" placeholder="Apellido Materno"
                value="<?php echo isset($obj_customer->mother_last) ? $obj_customer->mother_last : ''; ?>">
        </div>
        <div class="form-group col-md-6">
            <label>Tipo de Documento <span class="text-danger">*</span></label>
            <select class="form-control" id="document_type" name="document_type" required>
                <option value="dni" <?php echo !isset($obj_customer->ruc) || empty($obj_customer->ruc) ? 'selected' : ''; ?>>DNI</option>
                <option value="ruc" <?php echo isset($obj_customer->ruc) && !empty($obj_customer->ruc) ? 'selected' : ''; ?>>RUC</option>
            </select>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label id="document_number_label">Documento <span class="text-danger">*</span></label>
            <input class="form-control" type="text" id="document_number_display" placeholder="Ingrese documento"
                value="<?php echo isset($obj_customer->ruc) && !empty($obj_customer->ruc) ? $obj_customer->ruc : (isset($obj_customer->dni) ? $obj_customer->dni : ''); ?>"
                inputmode="numeric" required>
            <small class="form-text text-muted" id="document_number_help">Ingresa el número del documento.</small>
            <input type="hidden" id="dni" name="dni"
                value="<?php echo isset($obj_customer->dni) ? $obj_customer->dni : ''; ?>">
            <input type="hidden" id="ruc" name="ruc"
                value="<?php echo isset($obj_customer->ruc) ? $obj_customer->ruc : ''; ?>">
        </div>
        <div class="form-group col-md-6">
            <label>Email <span class="text-danger">*</span></label>
            <input class="form-control" type="email" id="email" name="email" placeholder="Email"
                value="<?php echo isset($obj_customer->email) ? $obj_customer->email : ''; ?>" required>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label>Estado Civil</label>
            <select class="form-control" id="civil_status" name="civil_status">
                <option value="">Seleccionar</option>
                <option value="Soltero" <?php echo isset($obj_customer->civil_status) && $obj_customer->civil_status == 'Soltero' ? 'selected' : ''; ?>>Soltero</option>
                <option value="Casado" <?php echo isset($obj_customer->civil_status) && $obj_customer->civil_status == 'Casado' ? 'selected' : ''; ?>>Casado</option>
                <option value="Divorciado" <?php echo isset($obj_customer->civil_status) && $obj_customer->civil_status == 'Divorciado' ? 'selected' : ''; ?>>Divorciado</option>
                <option value="Viudo" <?php echo isset($obj_customer->civil_status) && $obj_customer->civil_status == 'Viudo' ? 'selected' : ''; ?>>Viudo</option>
                <option value="Unión libre" <?php echo isset($obj_customer->civil_status) && $obj_customer->civil_status == 'Unión libre' ? 'selected' : ''; ?>>Unión libre</option>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label>Teléfono</label>
            <input class="form-control" type="text" id="phone" name="phone" placeholder="Teléfono"
                value="<?php echo isset($obj_customer->phone) ? $obj_customer->phone : ''; ?>">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label>Tipo de Agente</label>
            <select class="form-control" id="tipo_agente" name="tipo_agente">
                <option value="">Seleccionar</option>
                <option value="Interno" <?php echo isset($obj_customer->tipo_agente) && $obj_customer->tipo_agente == 'Interno' ? 'selected' : ''; ?>>Interno</option>
                <option value="Externo" <?php echo isset($obj_customer->tipo_agente) && $obj_customer->tipo_agente == 'Externo' ? 'selected' : ''; ?>>Externo</option>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label>País <span class="text-danger">*</span></label>
            <select class="form-control" id="country_id" name="country_id" required>
                <option value="">Seleccionar País</option>
                <?php if(isset($obj_paises)): ?>
                    <?php foreach($obj_paises as $pais): ?>
                        <option value="<?php echo $pais->id; ?>" 
                            <?php echo isset($obj_customer->country_id) && $obj_customer->country_id == $pais->id ? 'selected' : ''; ?>>
                            <?php echo $pais->nombre; ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
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
                        <option value="<?php echo $sponsorId; ?>" <?php echo $selectedSponsorId === $sponsorId ? 'selected' : ''; ?>>
                            <?php echo trim($sponsorCode . ' - ' . $sponsorName . ($sponsorDocument !== '' ? ' (' . $sponsorDocument . ')' : '')); ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <small class="form-text text-muted">Se usara como patrocinador del cliente dentro de la red y para comisiones.</small>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label>Dirección</label>
            <input class="form-control" type="text" id="address" name="address" placeholder="Dirección"
                value="<?php echo isset($obj_customer->address) ? $obj_customer->address : ''; ?>">
        </div>
        <div class="form-group col-md-6">
            <label>Estado</label>
            <select class="form-control" id="active" name="active">
                <option value="1" <?php echo isset($obj_customer->active) && $obj_customer->active == '1' ? 'selected' : ''; ?>>Activo</option>
                <option value="0" <?php echo isset($obj_customer->active) && $obj_customer->active == '0' ? 'selected' : ''; ?>>No Activo</option>
            </select>
        </div>
    </div>
</form>
<script>
    (function() {
        const actionInput = document.querySelector('#form-customer input[name="action"]');
        const codePreview = document.getElementById('code_preview');
        const nameInput = document.getElementById('name');
        const lastNameInput = document.getElementById('lastname');
        const motherLastInput = document.getElementById('mother_last');
        const countrySelect = document.getElementById('country_id');

        if (!actionInput || actionInput.value !== 'create' || !codePreview || !nameInput || !lastNameInput || !motherLastInput || !countrySelect) {
            return;
        }

        function getInitial(value, fallback) {
            const normalized = (value || '').trim();
            return normalized ? normalized.charAt(0).toUpperCase() : fallback;
        }

        function updateCodePreview() {
            const selectedOption = countrySelect.options[countrySelect.selectedIndex];
            const countryCode = selectedOption && selectedOption.value ? String(selectedOption.value).padStart(2, '0') : 'PA';
            codePreview.value = countryCode + '00ID'
                + getInitial(lastNameInput.value, 'X')
                + getInitial(motherLastInput.value, 'X')
                + getInitial(nameInput.value, 'X')
                + ' (referencial)';
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
