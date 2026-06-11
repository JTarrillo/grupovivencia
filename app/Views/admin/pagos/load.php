<div class="row">
    <div class="col-md-12">
        <h5 class="mb-3 border-bottom pb-2">Detalles de la Solicitud</h5>
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th width="30%" class="bg-light">Usuario:</th>
                    <td><?php echo isset($obj_pay) ? $obj_pay->name . " " . $obj_pay->lastname . " (#" . $obj_pay->code . ")" : ''; ?></td>
                </tr>
                <tr>
                    <th class="bg-light">Banco:</th>
                    <td><?php echo isset($obj_pay) ? $obj_pay->bank : ''; ?></td>
                </tr>
                <tr>
                    <th class="bg-light">N° Cuenta:</th>
                    <td><?php echo isset($obj_pay) ? $obj_pay->number : ''; ?></td>
                </tr>
                <tr>
                    <th class="bg-light">CCI:</th>
                    <td><?php echo isset($obj_pay) ? ($obj_pay->cci ? $obj_pay->cci : 'No registrado') : ''; ?></td>
                </tr>
                <tr>
                    <th class="bg-light">Importe Solicitado:</th>
                    <td><strong class="text-success"><?php echo isset($obj_pay) ? "S/ " . number_format($obj_pay->amount, 2) : ''; ?></strong></td>
                </tr>
                <tr>
                    <th class="bg-light">Factura Adjunta:</th>
                    <td>
                        <?php if (isset($obj_pay) && !empty($obj_pay->factura)): ?>
                            <a href="<?php echo site_url('public/facturas/' . $obj_pay->factura); ?>" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> Ver Factura</a>
                        <?php else: ?>
                            <span class="text-danger"><i class="fa fa-times-circle"></i> No adjunta</span>
                        <?php endif; ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<h5 class="mb-3 mt-4 border-bottom pb-2">Gestión del Pago</h5>
<form id="form_pay" method="post" action="<?php echo site_url('dashboard/pagos/status'); ?>" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo isset($obj_pay) ? $obj_pay->id : ''; ?>">
    
    <div class="form-group">
        <label>Cambiar Estado:</label>
        <select class="form-control" name="active">
            <option value="1" <?php echo (isset($obj_pay) && $obj_pay->active == 1) ? 'selected' : ''; ?>>En espera</option>
            <option value="2" <?php echo (isset($obj_pay) && $obj_pay->active == 2) ? 'selected' : ''; ?>>Pagado</option>
            <option value="3" <?php echo (isset($obj_pay) && $obj_pay->active == 3) ? 'selected' : ''; ?>>Cancelado</option>
        </select>
    </div>

    <div class="form-group">
        <label>Voucher de Pago (Obligatorio si es Pagado):</label>
        <input type="file" name="voucher_pago" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
        <?php if (isset($obj_pay) && !empty($obj_pay->voucher_pago)): ?>
            <small class="form-text text-muted mt-2">Voucher actual: <a href="<?php echo site_url('public/vouchers/' . $obj_pay->voucher_pago); ?>" target="_blank">Ver Voucher</a></small>
        <?php endif; ?>
    </div>

    <div class="form-group text-right mt-4">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Guardar Estado</button>
    </div>
</form>

<script>
    $('#form_pay').submit(function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        var activeStatus = formData.get('active');
        var voucherFile = formData.get('voucher_pago');
        var existingVoucher = "<?php echo isset($obj_pay) && !empty($obj_pay->voucher_pago) ? $obj_pay->voucher_pago : ''; ?>";

        if (activeStatus == '2' && !voucherFile.name && existingVoucher == '') {
            Swal.fire('Atención', 'Debe adjuntar el voucher de pago cuando el estado es "Pagado".', 'warning');
            return;
        }

        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#modal_pay').modal('hide');
                Swal.fire({
                    title: '¡Actualizado!',
                    text: 'El estado de la solicitud ha sido cambiado exitosamente.',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            },
            error: function(xhr, status, error) {
                console.error("Error updating status:", error);
                Swal.fire('Error', 'Hubo un error al actualizar el estado. Por favor, intenta de nuevo.', 'error');
            }
        });
    });
</script>