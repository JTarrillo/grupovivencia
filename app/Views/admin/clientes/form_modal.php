<form name="form-customer" id="form-customer" enctype="multipart/form-data" method="post" action="javascript:void(0);" onsubmit="submitCustomerForm();">
    <?php if(isset($obj_customer) && $obj_customer): ?>
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="customer_id" id="customer_id" value="<?php echo $obj_customer->id; ?>">
    <?php else: ?>
        <input type="hidden" name="action" value="create">
    <?php endif; ?>

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
            <label>DNI <span class="text-danger">*</span></label>
            <input class="form-control" type="text" id="dni" name="dni" placeholder="DNI"
                value="<?php echo isset($obj_customer->dni) ? $obj_customer->dni : ''; ?>" required>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label>RUC</label>
            <input class="form-control" type="text" id="ruc" name="ruc" placeholder="RUC"
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
