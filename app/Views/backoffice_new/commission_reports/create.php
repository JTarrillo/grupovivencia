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

                                <!-- Ventas para el Cuadro Excel Dinámico (MOVIDO ARRIBA) -->
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="m-0">Detalle de Ventas (Generará el Excel)</h5>
                                        <div>
                                            <input type="file" id="importExcelFile" accept=".xlsx, .xls" style="display: none;">
                                            <button type="button" class="btn btn-sm btn-info me-2" onclick="document.getElementById('importExcelFile').click();">
                                                <i class="ti-import"></i> Importar Excel
                                            </button>
                                            <button type="button" class="btn btn-sm btn-success" id="addProjectBtn">
                                                <i class="ti-plus"></i> Añadir Proyecto
                                            </button>
                                        </div>
                                    </div>
                                    <div id="projectsContainer">
                                        <!-- Aquí se agregarán los proyectos dinámicamente -->
                                    </div>

                                    <!-- Monto Total de Comisiones -->
                                    <div class="mb-3 mt-5">
                                        <label class="form-label">Monto Total Calculado (S/) *</label>
                                        <input type="number" class="form-control" name="total_amount" id="total_amount" step="0.01"
                                            placeholder="0.00" readonly required>
                                        <small class="text-muted">Este monto se calcula automáticamente en base a las ventas ingresadas arriba.</small>
                                    </div>
                                    
                                    <hr class="my-5">
                                    <h5 class="mb-4">Datos del Informe</h5>

                                    <!-- Número de Informe -->
                                    <div class="mb-3">
                                        <label class="form-label">Número de Informe *</label>
                                        <input type="text" class="form-control" name="report_number"
                                            value="<?php echo "INF-" . date('Y') . "-" . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT); ?>"
                                            required>
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

                                    <!-- Archivos Adjuntos -->
                                    <hr class="my-4">
                                    <h5 class="mb-3">Archivos Adjuntos</h5>

                                    <div class="mb-3 d-none">
                                        <label class="form-label">Vauchers de Depósito (PDF/JPG/PNG)</label>
                                        <input type="file" class="form-control" name="attachment_vauchers"
                                            accept=".pdf,.jpg,.jpeg,.png">
                                    </div>

                                    <div class="mb-3 d-none">
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
    <!-- SheetJS para importar Excel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <script>
    // Dinámica para agregar proyectos y ventas
    let projectCount = 0;
    let saleCount = 0;

    function calculateTotals() {
        let grandTotal = 0;
        document.querySelectorAll('.project-container').forEach(proj => {
            let projTotal = 0;
            proj.querySelectorAll('.sale-row').forEach(row => {
                let deposit = parseFloat(row.querySelector('.deposit-amount').value) || 0;
                let percentage = parseFloat(row.querySelector('.percentage').value) || 0;
                let commAmount = (deposit * percentage) / 100;
                
                row.querySelector('.commission-amount').value = commAmount.toFixed(2);
                projTotal += commAmount;
            });
            proj.querySelector('.project-total').innerText = projTotal.toFixed(2);
            grandTotal += projTotal;
        });
        document.getElementById('total_amount').value = grandTotal.toFixed(2);
    }

    document.getElementById('addProjectBtn').addEventListener('click', function() {
        projectCount++;
        const projId = 'project_' + projectCount;
        
        const projHtml = `
            <div class="card bg-light border border-secondary mb-4 project-container" id="${projId}">
                <div class="card-header min-h-40px py-2 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center w-50">
                        <label class="me-3 mb-0 fw-bold">PROYECTO:</label>
                        <input type="text" class="form-control form-control-sm border-primary" name="sales[${projectCount}][project_name]" placeholder="Ej: PROYECTO MONTE VERDE 1 y 2" required>
                    </div>
                    <button type="button" class="btn btn-sm btn-icon btn-danger remove-project" title="Eliminar Proyecto">X</button>
                </div>
                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm mb-0">
                            <thead class="bg-secondary text-dark text-center fw-bold align-middle">
                                <tr>
                                    <th width="20%">APELLIDOS Y NOMBRES</th>
                                    <th>MANZANA</th>
                                    <th>LOTE</th>
                                    <th>Nº CUOTA, INICIAL, RESERVA</th>
                                    <th>Nº DEPOSITO</th>
                                    <th width="12%">DEPOSITO (S/)</th>
                                    <th width="10%">PORCENTAJE (%)</th>
                                    <th width="12%">TOTAL PORCENTAJE</th>
                                    <th width="5%"></th>
                                </tr>
                            </thead>
                            <tbody class="sales-body">
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="7" class="text-end fw-bolder">TOTAL DEL PROYECTO:</td>
                                    <td class="text-center fw-bolder text-success">S/ <span class="project-total">0.00</span></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="9" class="text-center">
                                        <button type="button" class="btn btn-sm btn-primary add-sale-btn" data-project="${projectCount}">+ Añadir Venta a este Proyecto</button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        `;
        document.getElementById('projectsContainer').insertAdjacentHTML('beforeend', projHtml);
    });

    document.getElementById('projectsContainer').addEventListener('click', function(e) {
        if (e.target.closest('.remove-project')) {
            e.target.closest('.project-container').remove();
            calculateTotals();
        }
        
        if (e.target.closest('.add-sale-btn')) {
            saleCount++;
            const projIdx = e.target.closest('.add-sale-btn').getAttribute('data-project');
            const saleHtml = `
                <tr class="sale-row">
                    <td><input type="text" class="form-control form-control-sm" name="sales[${projIdx}][rows][${saleCount}][client_name]" required></td>
                    <td><input type="text" class="form-control form-control-sm text-center" name="sales[${projIdx}][rows][${saleCount}][manzana]" required></td>
                    <td><input type="text" class="form-control form-control-sm text-center" name="sales[${projIdx}][rows][${saleCount}][lote]" required></td>
                    <td><input type="text" class="form-control form-control-sm text-center" name="sales[${projIdx}][rows][${saleCount}][payment_type]" required></td>
                    <td><input type="text" class="form-control form-control-sm text-center" name="sales[${projIdx}][rows][${saleCount}][deposit_number]" required></td>
                    <td><input type="number" step="0.01" class="form-control form-control-sm text-end deposit-amount calc-trigger" name="sales[${projIdx}][rows][${saleCount}][deposit_amount]" value="0" required></td>
                    <td><input type="number" step="0.01" class="form-control form-control-sm text-center percentage calc-trigger" name="sales[${projIdx}][rows][${saleCount}][percentage]" value="5" required></td>
                    <td><input type="number" step="0.01" class="form-control form-control-sm text-end commission-amount bg-light" name="sales[${projIdx}][rows][${saleCount}][commission_amount]" readonly></td>
                    <td class="text-center"><button type="button" class="btn btn-sm btn-icon btn-light-danger remove-sale" title="Eliminar Venta">X</button></td>
                </tr>
            `;
            e.target.closest('table').querySelector('.sales-body').insertAdjacentHTML('beforeend', saleHtml);
        }

        if (e.target.closest('.remove-sale')) {
            e.target.closest('.sale-row').remove();
            calculateTotals();
        }
    });

    document.getElementById('projectsContainer').addEventListener('input', function(e) {
        if (e.target.classList.contains('calc-trigger')) {
            calculateTotals();
        }
    });

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

    // Lógica para Importar Excel
    document.getElementById('importExcelFile').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            try {
                const data = new Uint8Array(e.target.result);
                const workbook = XLSX.read(data, {type: 'array'});
                const firstSheet = workbook.Sheets[workbook.SheetNames[0]];
                // Leer como array de arrays
                const rows = XLSX.utils.sheet_to_json(firstSheet, {header: 1, defval: ''});

                // Limpiar proyectos actuales
                document.getElementById('projectsContainer').innerHTML = '';
                projectCount = 0;
                saleCount = 0;

                let currentProjectName = '';
                let readingData = false;
                let currentProjectIdx = 0;

                for (let i = 0; i < rows.length; i++) {
                    const row = rows[i];
                    const colA = String(row[0] || '').trim();
                    
                    if (colA.toUpperCase() === 'GRUPO VIVENCIA') continue;
                    
                    if (colA.toUpperCase().includes('APELLIDOS') || colA.toUpperCase().includes('NOMBRES')) {
                        readingData = true;
                        // El nombre del proyecto suele estar una o dos filas arriba
                        let projRow = rows[i-1];
                        if (projRow && String(projRow[0]).trim() !== '' && String(projRow[0]).toUpperCase() !== 'GRUPO VIVENCIA') {
                            currentProjectName = String(projRow[0]).trim();
                        } else if (i >= 2) {
                            let projRow2 = rows[i-2];
                            if (projRow2 && String(projRow2[0]).trim() !== '' && String(projRow2[0]).toUpperCase() !== 'GRUPO VIVENCIA') {
                                currentProjectName = String(projRow2[0]).trim();
                            } else {
                                currentProjectName = 'PROYECTO IMPORTADO';
                            }
                        } else {
                            currentProjectName = 'PROYECTO IMPORTADO';
                        }

                        // Limpiar "PROYECTO: " si está presente
                        if (currentProjectName.toUpperCase().startsWith('PROYECTO:')) {
                            currentProjectName = currentProjectName.substring(9).trim();
                        }
                        
                        // Añadir proyecto al DOM
                        document.getElementById('addProjectBtn').click();
                        currentProjectIdx = projectCount;
                        
                        // Setear nombre
                        document.querySelector('#project_' + currentProjectIdx + ' input[name^="sales["]').value = currentProjectName;
                        continue;
                    }
                    
                    if (readingData) {
                        if (colA.toUpperCase() === 'TOTAL' || colA === '') {
                            // Si encontramos TOTAL o una fila vacía, asumimos que terminó este bloque de datos
                            if (colA.toUpperCase() === 'TOTAL') {
                                readingData = false;
                            }
                            // Si es vacío, podría ser solo un salto de línea. Continuamos pero no agregamos venta.
                            continue;
                        }
                        
                        // Es una fila de datos
                        const clientName = colA;
                        const manzana = String(row[1] || '').trim();
                        const lote = String(row[2] || '').trim();
                        const paymentType = String(row[3] || '').trim();
                        const depositNumber = String(row[4] || '').trim();
                        let depositAmount = parseFloat(String(row[5]).replace(/[^0-9.-]+/g, "")) || 0;
                        let percentage = parseFloat(String(row[6]).replace(/[^0-9.-]+/g, "")) || 0;
                        
                        // Si el porcentaje está en formato decimal (ej. 0.05 en lugar de 5)
                        if (percentage > 0 && percentage < 1) {
                            percentage = percentage * 100;
                        }
                        // Si no se detectó porcentaje pero hay comisión y depósito, se podría inferir, 
                        // pero dejaremos el valor por defecto si es 0 y deposit > 0
                        if (percentage === 0 && depositAmount > 0) {
                            percentage = 5; // default
                        }
                        
                        // Añadir fila de venta
                        const projectContainer = document.getElementById('project_' + currentProjectIdx);
                        if (projectContainer) {
                            const addSaleBtn = projectContainer.querySelector('.add-sale-btn');
                            addSaleBtn.click();
                            
                            const saleRows = projectContainer.querySelectorAll('.sale-row');
                            const lastRow = saleRows[saleRows.length - 1];
                            
                            lastRow.querySelector('input[name$="[client_name]"]').value = clientName;
                            lastRow.querySelector('input[name$="[manzana]"]').value = manzana;
                            lastRow.querySelector('input[name$="[lote]"]').value = lote;
                            lastRow.querySelector('input[name$="[payment_type]"]').value = paymentType;
                            lastRow.querySelector('input[name$="[deposit_number]"]').value = depositNumber;
                            lastRow.querySelector('input[name$="[deposit_amount]"]').value = depositAmount;
                            lastRow.querySelector('input[name$="[percentage]"]').value = percentage;
                        }
                    }
                }
                
                calculateTotals();
                
                document.getElementById('importExcelFile').value = '';
                
                Swal.fire({
                    icon: 'success',
                    title: 'Importación exitosa',
                    text: 'Los datos del Excel han sido cargados correctamente en el formulario.'
                });
                
            } catch (error) {
                console.error("Error leyendo Excel:", error);
                document.getElementById('importExcelFile').value = '';
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo leer el archivo Excel. Asegúrese de que tenga el formato correcto.'
                });
            }
        };
        reader.readAsArrayBuffer(file);
    });
    </script>
</body>

</html>