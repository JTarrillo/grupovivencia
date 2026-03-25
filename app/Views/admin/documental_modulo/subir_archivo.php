<?php echo view('admin/header'); ?>

<section class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <div class="card">
                            <div class="card-header">
                                <h5>Subir Archivo</h5>
                            </div>
                            <div class="card-block">
                                <form method="POST" action="/documental/subir_archivo" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Seleccionar Archivo</label>
                                        <input type="file" class="form-control" name="archivo" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Tipo de Documento</label>
                                        <select class="form-control" name="tipo_documento" required>
                                            <option value="">Seleccionar...</option>
                                            <option value="contrato">Contrato</option>
                                            <option value="recibo">Recibo</option>
                                            <option value="boleta">Boleta</option>
                                            <option value="otros">Otros</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Cliente (Opcional)</label>
                                        <input type="number" class="form-control" name="cliente_id">
                                    </div>
                                    <div class="form-group">
                                        <label>Contrato (Opcional)</label>
                                        <input type="number" class="form-control" name="contrato_id">
                                    </div>
                                    <div class="form-group">
                                        <label>Descripción</label>
                                        <textarea class="form-control" name="descripcion"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-success">Subir</button>
                                    <a href="/documental/archivos" class="btn btn-secondary">Cancelar</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
