<!doctype html>
<html lang="es-PE">
<?php echo view("admin/head"); ?>

<body>
    <?php echo view("admin/header"); ?>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <section class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="page-header">
                        <div class="page-block">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <div class="page-header-title">
                                        <h5 class="m-b-10">Editar Contrato</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="/dashboard/panel">Panel</a></li>
                                        <li class="breadcrumb-item"><a href="/dashboard/inmueble">Gestión
                                                Inmobiliaria</a></li>
                                        <li class="breadcrumb-item"><a
                                                href="/dashboard/inmueble/contracts">Contratos</a></li>
                                        <li class="breadcrumb-item active">Editar</li>
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
                                            <h5>Editar Contrato de Venta</h5>
                                        </div>
                                        <div class="card-block">
                                            <form id="edit-contract-form" method="POST">
                                                <input type="hidden" name="contract_id" value="<?= $contract['id'] ?>">
                                                <div class="form-group">
                                                    <label>Cliente</label>
                                                    <input type="text" class="form-control"
                                                        value="<?= $contract['customer_name'] ?? '' ?>" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label>Lote</label>
                                                    <input type="text" class="form-control"
                                                        value="<?= $contract['lot_number'] ?? '' ?>" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label>Cuota Inicial</label>
                                                    <input type="number" class="form-control" name="down_payment"
                                                        value="<?= $contract['down_payment'] ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label>Meses de Financiamiento</label>
                                                    <input type="number" class="form-control" name="financing_months"
                                                        value="<?= $contract['financing_months'] ?? '' ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label>Tasa de Interés (%)</label>
                                                    <input type="number" class="form-control" name="interest_rate"
                                                        value="<?= $contract['interest_rate'] ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label>Fecha del Contrato</label>
                                                    <input type="date" class="form-control" name="contract_date"
                                                        value="<?= $contract['contract_date'] ?>">
                                                </div>
                                                <button type="submit" class="btn btn-success">Guardar Cambios</button>
                                                <a href="/dashboard/inmueble/contracts"
                                                    class="btn btn-secondary">Cancelar</a>
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
    <?php echo view("admin/footer"); ?>
    <script>
    document.getElementById('edit-contract-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);
        fetch(window.location.pathname, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Guardado!',
                        text: 'Los cambios se guardaron correctamente.',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = '/dashboard/inmueble/contracts';
                    });
                } else {
                    let errorMsg = data.message || 'No se pudo guardar los cambios.';
                    if (data.errors) {
                        errorMsg += '\n' + JSON.stringify(data.errors, null, 2);
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMsg
                    });
                }
            })
            .catch((err) => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo guardar los cambios.'
                });
            });
    });
    </script>
</body>

</html>