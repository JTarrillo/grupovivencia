<?php echo view('admin/header'); ?>

<section class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <div class="card">
                            <div class="card-header">
                                <h5>Nuevo Proveedor</h5>
                            </div>
                            <div class="card-block">
                                <form method="POST" action="/pagos/crear_proveedor">
                                    <div class="form-group">
                                        <label>Razón Social</label>
                                        <input type="text" class="form-control" name="razon_social" required>
                                    </div>
                                    <div class="form-group">
                                        <label>RUC</label>
                                        <input type="text" class="form-control" name="ruc" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Contacto</label>
                                        <input type="text" class="form-control" name="contacto">
                                    </div>
                                    <div class="form-group">
                                        <label>Teléfono</label>
                                        <input type="text" class="form-control" name="telefono">
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email">
                                    </div>
                                    <div class="form-group">
                                        <label>Dirección</label>
                                        <input type="text" class="form-control" name="direccion">
                                    </div>
                                    <div class="form-group">
                                        <label>Tipo de Proveedor</label>
                                        <select class="form-control" name="tipo_proveedor">
                                            <option value="">Seleccionar...</option>
                                            <option value="servicio">Servicio</option>
                                            <option value="producto">Producto</option>
                                            <option value="mixto">Mixto</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-success">Crear</button>
                                    <a href="/pagos/proveedores" class="btn btn-secondary">Cancelar</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
