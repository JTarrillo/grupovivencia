<!DOCTYPE html>
<html lang="es">
<?php echo view("backoffice_new/head"); ?>

<body data-kt-name="metronic" id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled">
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <?php echo view("backoffice_new/header"); ?>
                <div class="container mt-10">
                    <h2>Renovación anual de agente</h2>
                    <?php if (empty($tipo_agente)): ?>
                    <div class="alert alert-warning">Tipo de agente no asignado. Contacte al administrador.</div>
                    <?php elseif ($tipo_agente === 'externo'): ?>
                    <?php if ($estado_renovacion === 'vigente'): ?>
                    <div class="alert alert-success">Tu renovación está vigente. Fecha de última renovación:
                        <b><?= $fecha_renovacion ?></b>
                    </div>
                    <?php else: ?>
                    <div class="alert alert-danger">Tu renovación ha vencido. Debes pagar S/380 para continuar activo.
                    </div>
                    <form id="formRenovacion" method="post" action="/backoffice_new/renovacion/pagar">
                        <button type="submit" class="btn btn-primary">Pagar S/380</button>
                    </form>
                    <div id="msgRenovacion"></div>
                    <script>
                    document.getElementById('formRenovacion').onsubmit = function(e) {
                        e.preventDefault();
                        fetch('/backoffice_new/renovacion/pagar', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({})
                            })
                            .then(r => r.json())
                            .then(data => {
                                document.getElementById('msgRenovacion').innerHTML = data.msg;
                                if (data.status === 'ok') location.reload();
                            });
                    };
                    </script>
                    <?php endif; ?>
                    <?php else: ?>
                    <div class="alert alert-info">No requiere renovación anual.</div>
                    <?php endif; ?>
                </div>
                <?php echo view("backoffice_new/footer"); ?>
            </div>
        </div>
    </div>
    <script src="<?php echo site_url() . 'assets/metronic8/plugins/global/plugins.bundle.js'; ?>"></script>
    <script src="<?php echo site_url() . 'assets/metronic8/js/scripts.bundle.js'; ?>"></script>
</body>

</html>