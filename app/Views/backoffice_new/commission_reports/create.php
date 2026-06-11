<?php echo view("backoffice_new/head"); ?>

<body data-kt-name="metronic" id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled">
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <?php echo view("backoffice_new/header"); ?>
                <?php echo view("backoffice_new/toolbar"); ?>

                <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
                    <div class="content flex-row-fluid" id="kt_content">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Crear Informe de Comisiones</h3>
                            </div>

                            <div class="card-body">
                                <form id="commission_form" enctype="multipart/form-data">

                                    <!-- Número de Informe -->
                                    <div class="mb-3">
                                        <label class="form-label">Número de Informe *</label>
                                        <input type="text" class="form-control" name="report_number"
                                            placeholder="Ej: INFORME Nº009-2025-BRQ" required>
                                        <small class="text-muted">Ingrese el número de informe según el formato
                                            correspondiente</small>
                                    </div>

                                    <!-- Nombre del Patrocinador -->
                                    <div class="mb-3">
                                        <label class="form-label">Nombre del Patrocinador *</label>
                                        <input type="text" class="form-control" name="patron_name"
                                            value="<?php echo strtoupper($customer['name'] . ' ' . $customer['lastname']); ?>"
                                            required>
                                    </div>

                                    <!-- Posición/Cargo -->
                                    <div class="mb-3">
                                        <label class="form-label">Posición/Cargo *</label>
                                        <input type="text" class="form-control" name="patron_position"
                                            value="ASESOR DE VENTAS" required>
                                    </div>

                                    <!-- Asunto -->
                                    <div class="mb-3">
                                        <label class="form-label">Asunto *</label>
                                        <input type="text" class="form-control" name="subject"
                                            placeholder="Ej: INFORME MENSUAL CORRESPONDIENTE AL MES DE SETIEMBRE"
                                            required>
                                    </div>

                                    <!-- Proyectos -->
                                    <div class="mb-3">
                                        <label class="form-label">Proyectos Incluidos *</label>
                                        <textarea class="form-control" name="projects" rows="3"
                                            placeholder="Ej: Condominio y Resort Beleza, Monte Verde I-II-III"
                                            required></textarea>
                                    </div>

                                    <!-- Descripción/Detalles -->
                                    <div class="mb-3">
                                        <label class="form-label">Descripción de Comisiones *</label>
                                        <textarea class="form-control" name="description" rows="6"
                                            placeholder="Detalle el desglose de comisiones por reserva, inicial y cuotas..."
                                            required></textarea>
                                    </div>

                                    <!-- Número de Factura -->
                                    <div class="mb-3">
                                        <label class="form-label">Número de Factura *</label>
                                        <input type="text" class="form-control" name="invoice_number"
                                            placeholder="Ej: E001-11" required>
                                    </div>

                                    <!-- Monto Total de Comisiones -->
                                    <div class="mb-3">
                                        <label class="form-label">Monto Total (S/) *</label>
                                        <input type="number" class="form-control" name="total_amount" step="0.01"
                                            placeholder="0.00" required>
                                    </div>

                                    <!-- Archivos Adjuntos -->
                                    <hr class="my-4">
                                    <h5 class="mb-3">Archivos Adjuntos</h5>

                                    <div class="mb-3">
                                        <label class="form-label">Cuadro Excel (XLS/XLSX)</label>
                                        <input type="file" class="form-control" name="attachment_excel"
                                            accept=".xls,.xlsx">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Vauchers de Depósito (PDF/JPG/PNG)</label>
                                        <input type="file" class="form-control" name="attachment_vauchers"
                                            accept=".pdf,.jpg,.jpeg,.png">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Boletas de Venta (PDF/JPG/PNG)</label>
                                        <input type="file" class="form-control" name="attachment_invoices"
                                            accept=".pdf,.jpg,.jpeg,.png">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Factura PDF (PDF)</label>
                                        <input type="file" class="form-control" name="attachment_factura_pdf"
                                            accept=".pdf" required>
                                    </div>

                                    <!-- Firma Digital -->
                                    <hr class="my-4">
                                    <h5 class="mb-3">Firma Digital</h5>
                                    <div class="mb-3">
                                        <label class="form-label">Dibuje su firma en el recuadro *</label>
                                        <div
                                            style="border: 1px solid #ccc; width: 100%; max-width: 400px; border-radius: 5px; background: #fff;">
                                            <canvas id="signatureCanvas" width="400" height="200"
                                                style="cursor: crosshair;"></canvas>
                                        </div>
                                        <div class="mt-2">
                                            <button type="button" class="btn btn-sm btn-light"
                                                id="clearSignature">Limpiar Firma</button>
                                        </div>
                                        <input type="hidden" name="digital_signature" id="digital_signature" required>
                                    </div>

                                    <!-- Botones -->
                                    <div class="mt-5">
                                        <button type="submit" class="btn btn-primary">
                                            <span class="indicator-label">Enviar Informe</span>
                                        </button>
                                        <a href="<?php echo site_url('backoffice_new/commission_reports/my'); ?>"
                                            class="btn btn-secondary ms-2">
                                            Volver
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <?php echo view("backoffice_new/footer"); ?>
            </div>
        </div>
    </div>

    <script src="<?php echo site_url() . "assets/metronic8/plugins/global/plugins.bundle.js"; ?>"></script>
    <script src="<?php echo site_url() . "assets/metronic8/js/scripts.bundle.js"; ?>"></script>
    <script src="<?php echo site_url() . "assets/metronic8/js/widgets.bundle.js"; ?>"></script>

    <script>
    // Signature Pad logic
    const canvas = document.getElementById('signatureCanvas');
    const ctx = canvas.getContext('2d');
    let isDrawing = false;
    let signatureEmpty = true;

    // Set background to white
    ctx.fillStyle = "#ffffff";
    ctx.fillRect(0, 0, canvas.width, canvas.height);
    ctx.strokeStyle = "#000000";
    ctx.lineWidth = 2;

    function getMousePos(canvas, evt) {
        var rect = canvas.getBoundingClientRect();
        return {
            x: evt.clientX - rect.left,
            y: evt.clientY - rect.top
        };
    }

    function getTouchPos(canvas, evt) {
        var rect = canvas.getBoundingClientRect();
        return {
            x: evt.touches[0].clientX - rect.left,
            y: evt.touches[0].clientY - rect.top
        };
    }

    // Mouse events
    canvas.addEventListener('mousedown', function(e) {
        isDrawing = true;
        signatureEmpty = false;
        let pos = getMousePos(canvas, e);
        ctx.beginPath();
        ctx.moveTo(pos.x, pos.y);
    });

    canvas.addEventListener('mousemove', function(e) {
        if (isDrawing) {
            let pos = getMousePos(canvas, e);
            ctx.lineTo(pos.x, pos.y);
            ctx.stroke();
        }
    });

    canvas.addEventListener('mouseup', function() {
        isDrawing = false;
    });

    canvas.addEventListener('mouseout', function() {
        isDrawing = false;
    });

    // Touch events
    canvas.addEventListener('touchstart', function(e) {
        e.preventDefault();
        isDrawing = true;
        signatureEmpty = false;
        let pos = getTouchPos(canvas, e);
        ctx.beginPath();
        ctx.moveTo(pos.x, pos.y);
    });

    canvas.addEventListener('touchmove', function(e) {
        e.preventDefault();
        if (isDrawing) {
            let pos = getTouchPos(canvas, e);
            ctx.lineTo(pos.x, pos.y);
            ctx.stroke();
        }
    });

    canvas.addEventListener('touchend', function(e) {
        e.preventDefault();
        isDrawing = false;
    });

    document.getElementById('clearSignature').addEventListener('click', function() {
        ctx.fillStyle = "#ffffff";
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        signatureEmpty = true;
    });

    document.getElementById('commission_form').addEventListener('submit', function(e) {
        e.preventDefault();

        if (signatureEmpty) {
            Swal.fire({
                icon: 'warning',
                title: 'Atención',
                text: 'Por favor, dibuje su firma antes de enviar.'
            });
            return;
        }

        // Save canvas to base64
        document.getElementById('digital_signature').value = canvas.toDataURL('image/png');

        let formData = new FormData(this);

        fetch('<?php echo site_url('backoffice_new/commission_reports/store'); ?>', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: data.message,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href =
                            '<?php echo site_url('backoffice_new/commission_reports/my'); ?>';
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al enviar el informe'
                });
            });
    });
    </script>
</body>

</html>