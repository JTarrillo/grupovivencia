<div class="container-fluid px-0">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="text-muted mb-1">Proveedor</label>
            <div><strong><?php echo esc($compra['proveedor_nombre'] ?? 'N/A'); ?></strong></div>
        </div>
        <div class="col-md-6 mb-3">
            <label class="text-muted mb-1">Comprobante</label>
            <div><strong><?php echo esc($compra['numero_comprobante'] ?? 'N/A'); ?></strong></div>
        </div>
        <div class="col-md-6 mb-3">
            <label class="text-muted mb-1">Tipo</label>
            <div><?php echo esc($compra['tipo_comprobante'] ?? 'N/A'); ?></div>
        </div>
        <div class="col-md-6 mb-3">
            <label class="text-muted mb-1">Fecha</label>
            <div><?php echo !empty($compra['fecha_compra']) ? date('d/m/Y', strtotime($compra['fecha_compra'])) : 'N/A'; ?></div>
        </div>
        <div class="col-md-4 mb-3">
            <label class="text-muted mb-1">Subtotal</label>
            <div>S/. <?php echo number_format((float)($compra['subtotal'] ?? 0), 2); ?></div>
        </div>
        <div class="col-md-4 mb-3">
            <label class="text-muted mb-1">IGV</label>
            <div>S/. <?php echo number_format((float)($compra['igv'] ?? 0), 2); ?></div>
        </div>
        <div class="col-md-4 mb-3">
            <label class="text-muted mb-1">Total</label>
            <div><strong class="text-success">S/. <?php echo number_format((float)($compra['total'] ?? 0), 2); ?></strong></div>
        </div>
        <div class="col-md-12 mb-3">
            <label class="text-muted mb-1">Descripción</label>
            <div><?php echo esc($compra['descripcion'] ?? 'N/A'); ?></div>
        </div>
        <div class="col-md-12 mb-2">
            <label class="text-muted mb-1">Estado</label>
            <div>
                <?php
                $estado = $compra['estado'] ?? 'registrado';
                $badgeClass = 'badge-secondary';
                if ($estado === 'registrado') {
                    $badgeClass = 'badge-warning';
                } elseif ($estado === 'clasificado') {
                    $badgeClass = 'badge-info';
                } elseif ($estado === 'aprobado') {
                    $badgeClass = 'badge-success';
                }
                ?>
                <span class="badge <?php echo $badgeClass; ?>"><?php echo esc(ucfirst($estado)); ?></span>
            </div>
        </div>
        <div class="col-md-12 mt-2">
            <?php if (!empty($compra['comprobante_archivo'])): ?>
                <a href="<?php echo base_url($compra['comprobante_archivo']); ?>" target="_blank" class="btn btn-sm btn-primary">
                    <i class="fa fa-file-text-o"></i> Ver comprobante
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>
