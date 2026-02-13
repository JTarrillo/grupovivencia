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
                                        <h5 class="m-b-10">Asignar/Modificar Patrocinador</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="/dashboard/">Panel</a></li>
                                        <li class="breadcrumb-item"><a href="/dashboard/clientes">Clientes</a></li>
                                        <li class="breadcrumb-item"><a>Asignar Patrocinador</a></li>
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
                                            <h5>Asignar/Modificar Patrocinador</h5>
                                        </div>
                                        <div class="card-block">
                                            <?php if (isset($msg)): ?>
                                            <div class="alert alert-info"><?php echo $msg; ?></div>
                                            <?php endif; ?>
                                            <form method="post" action="/admin/clientes/asignar_patocinador">
                                                <div class="form-group">
                                                    <label for="customer_id">Cliente:</label>
                                                    <select name="customer_id" id="customer_id" class="form-control"
                                                        required>
                                                        <?php foreach ($clientes as $c): ?>
                                                        <option value="<?= $c['id'] ?>">[<?= $c['code'] ?>]
                                                            <?= $c['name'] ?> <?= $c['lastname'] ?> (DNI:
                                                            <?= $c['dni'] ?>)</option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sponsor_id">Patrocinador:</label>
                                                    <select name="sponsor_id" id="sponsor_id" class="form-control"
                                                        required>
                                                        <?php foreach ($clientes as $c): ?>
                                                        <option value="<?= $c['id'] ?>">[<?= $c['code'] ?>]
                                                            <?= $c['name'] ?> <?= $c['lastname'] ?> (DNI:
                                                            <?= $c['dni'] ?>)</option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Guardar</button>
                                            </form>
                                            <script>
                                            // Al cambiar el cliente, filtra el patrocinador para que no pueda ser el mismo
                                            document.getElementById('customer_id').addEventListener('change',
                                            function() {
                                                var clienteId = this.value;
                                                var sponsorSelect = document.getElementById('sponsor_id');
                                                for (var i = 0; i < sponsorSelect.options.length; i++) {
                                                    sponsorSelect.options[i].disabled = (sponsorSelect.options[
                                                        i].value === clienteId);
                                                }
                                                // Si el patrocinador seleccionado es igual al cliente, cambia a la primera opción válida
                                                if (sponsorSelect.value === clienteId) {
                                                    for (var i = 0; i < sponsorSelect.options.length; i++) {
                                                        if (!sponsorSelect.options[i].disabled) {
                                                            sponsorSelect.selectedIndex = i;
                                                            break;
                                                        }
                                                    }
                                                }
                                            });
                                            // Ejecutar al cargar para inicializar correctamente
                                            document.getElementById('customer_id').dispatchEvent(new Event('change'));
                                            </script>
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
</body>

</html>