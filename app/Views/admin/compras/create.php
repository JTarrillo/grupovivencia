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
                                        <h5 class="m-b-10">Nueva Compra</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="/dashboard/">Panel</a></li>
                                        <li class="breadcrumb-item"><a href="/dashboard/compras">Compras</a></li>
                                        <li class="breadcrumb-item"><a>Crear</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Registrar Nueva Compra</h5>
                                        </div>
                                        <div class="card-block">
                                            <form id="form-compra" method="POST"
                                                action="<?php echo base_url('dashboard/compras'); ?>"
                                                enctype="multipart/form-data">
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Proveedor <span
                                                            class="text-danger">*</span></label>
                                                    <select name="proveedor_id" class="form-control" required>
                                                        <option value="">-- Seleccionar --</option>
                                                        <?php if (!empty($proveedores)): ?>
                                                        <?php foreach ($proveedores as $prove): ?>
                                                        <option value="<?php echo $prove['id']; ?>">
                                                            <?php echo $prove['name']; ?></option>
                                                        <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label">Número de Comprobante <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="numero_comprobante" class="form-control"
                                                        placeholder="Ej: 001-0001234" required>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label">Tipo de Comprobante <span
                                                            class="text-danger">*</span></label>
                                                    <select name="tipo_comprobante" class="form-control" required>
                                                        <option value="">-- Seleccionar --</option>
                                                        <option value="Factura">Factura</option>
                                                        <option value="Boleta">Boleta</option>
                                                        <option value="Recibo">Recibo</option>
                                                    </select>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label">Fecha de Compra <span
                                                            class="text-danger">*</span></label>
                                                    <input type="date" name="fecha_compra" class="form-control"
                                                        required>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Subtotal <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="number" name="subtotal" id="subtotal"
                                                                class="form-control" placeholder="0.00" step="0.01"
                                                                min="0" required>
                                                            <small class="form-text text-muted">Si ingresas el subtotal,
                                                                calculamos IGV y total automáticamente.</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">IGV <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="number" name="igv" id="igv"
                                                                class="form-control bg-light" placeholder="0.00"
                                                                step="0.01" min="0" readonly required>
                                                            <small class="form-text text-muted">Se calcula
                                                                automáticamente con la tasa del 18%.</small>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label">Total <span
                                                            class="text-danger">*</span></label>
                                                    <input type="number" name="total" id="total" class="form-control"
                                                        placeholder="0.00" step="0.01" min="0" required>
                                                    <small class="form-text text-muted">Si ingresas el total, calculamos
                                                        subtotal e IGV automáticamente.</small>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label">Descripción</label>
                                                    <textarea name="descripcion" class="form-control" rows="3"
                                                        placeholder="Detalles de la compra..."></textarea>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label">Adjuntar Comprobante (PDF)</label>
                                                    <input type="file" name="pdf_comprobante" class="form-control"
                                                        accept=".pdf">
                                                </div>

                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-success me-2">
                                                        <i class="fa fa-save"></i> Guardar Compra
                                                    </button>
                                                    <a href="<?php echo base_url('dashboard/compras'); ?>"
                                                        class="btn btn-secondary">
                                                        <i class="fa fa-times"></i> Cancelar
                                                    </a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card bg-light">
                                        <div class="card-header">
                                            <h5>Información</h5>
                                        </div>
                                        <div class="card-block">
                                            <p class="text-muted">Ingresa los datos del comprobante de compra. Asegúrate
                                                de incluir todos los datos requeridos.</p>
                                            <hr>
                                            <h6 class="text-success">Campos requeridos</h6>
                                            <ul class="list-unstyled">
                                                <li>✓ Proveedor</li>
                                                <li>✓ Número de comprobante</li>
                                                <li>✓ Tipo de comprobante</li>
                                                <li>✓ Fecha</li>
                                                <li>✓ Monto total</li>
                                            </ul>
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
    (function() {
        const formCompra = document.getElementById('form-compra');
        const subtotalInput = document.getElementById('subtotal');
        const igvInput = document.getElementById('igv');
        const totalInput = document.getElementById('total');
        const IGV_RATE = 0.18;

        if (!formCompra || !subtotalInput || !igvInput || !totalInput) {
            return;
        }

        let isUpdating = false;
        let lastManualAmountSource = '';

        function toNumber(value) {
            const parsed = parseFloat(value);
            return Number.isFinite(parsed) ? parsed : 0;
        }

        function roundMoney(value) {
            return Math.round((value + Number.EPSILON) * 100) / 100;
        }

        function writeValue(input, value) {
            input.value = value > 0 ? roundMoney(value).toFixed(2) : '';
        }

        function updateFromSubtotal() {
            if (isUpdating) {
                return;
            }

            if (lastManualAmountSource === 'total' && document.activeElement !== subtotalInput) {
                return;
            }

            const subtotal = toNumber(subtotalInput.value);
            isUpdating = true;

            if (subtotal > 0) {
                const igv = roundMoney(subtotal * IGV_RATE);
                const total = roundMoney(subtotal + igv);
                writeValue(igvInput, igv);
                writeValue(totalInput, total);
            } else {
                igvInput.value = '';
                totalInput.value = '';
            }

            isUpdating = false;
        }

        function updateFromTotal() {
            if (isUpdating) {
                return;
            }

            if (lastManualAmountSource === 'subtotal' && document.activeElement !== totalInput) {
                return;
            }

            const total = toNumber(totalInput.value);
            isUpdating = true;

            if (total > 0) {
                const subtotal = roundMoney(total / (1 + IGV_RATE));
                const igv = roundMoney(total - subtotal);
                writeValue(subtotalInput, subtotal);
                writeValue(igvInput, igv);
            } else {
                subtotalInput.value = '';
                igvInput.value = '';
            }

            isUpdating = false;
        }

        subtotalInput.addEventListener('focus', function() {
            lastManualAmountSource = 'subtotal';
        });

        totalInput.addEventListener('focus', function() {
            lastManualAmountSource = 'total';
        });

        subtotalInput.addEventListener('input', updateFromSubtotal);
        subtotalInput.addEventListener('keyup', updateFromSubtotal);
        subtotalInput.addEventListener('change', updateFromSubtotal);
        totalInput.addEventListener('input', updateFromTotal);
        totalInput.addEventListener('keyup', updateFromTotal);
        totalInput.addEventListener('change', updateFromTotal);

        subtotalInput.addEventListener('blur', updateFromSubtotal);
        totalInput.addEventListener('blur', updateFromTotal);

        formCompra.addEventListener('submit', function() {
            const subtotal = toNumber(subtotalInput.value);
            const total = toNumber(totalInput.value);

            if (lastManualAmountSource === 'total' && total > 0) {
                updateFromTotal();
                return;
            }

            if (subtotal > 0) {
                updateFromSubtotal();
                return;
            }

            if (total > 0) {
                updateFromTotal();
            }
        });

        if (toNumber(subtotalInput.value) > 0) {
            updateFromSubtotal();
        } else if (toNumber(totalInput.value) > 0) {
            updateFromTotal();
        }
    })();
    </script>
    <?php echo view("admin/footer"); ?>
</body>

</html>