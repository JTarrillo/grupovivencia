<div class="container mt-4">
    <h3>Detalle de Penalidad</h3>
    <table class="table table-bordered">
        <tr><th>ID</th><td><?= $penalty['id'] ?></td></tr>
        <tr><th>Contrato</th><td><?= $penalty['contract_id'] ?></td></tr>
        <tr><th>Usuario</th><td><?= $penalty['user_id'] ?? '-' ?></td></tr>
        <tr><th>Tipo</th><td><?= ucfirst($penalty['type']) ?></td></tr>
        <tr><th>Monto</th><td>$<?= number_format($penalty['amount'], 2) ?></td></tr>
        <tr><th>Notas</th><td><?= $penalty['notes'] ?></td></tr>
        <tr><th>Estado</th><td><?= $penalty['status'] ?? 'pendiente' ?></td></tr>
        <tr><th>Fecha</th><td><?= $penalty['created_at'] ?? '-' ?></td></tr>
    </table>
    <a href="/dashboard/penalties" class="btn btn-secondary">Volver</a>
    <?php if (($penalty['status'] ?? 'pendiente') !== 'pagada'): ?>
    <form method="post" action="/dashboard/penalties/mark_paid" style="display:inline;">
        <input type="hidden" name="id" value="<?= $penalty['id'] ?>">
        <button type="submit" class="btn btn-success">Marcar como pagada</button>
    </form>
    <?php endif; ?>
    <form method="post" action="/dashboard/penalties/delete" style="display:inline;" onsubmit="return confirm('¿Eliminar penalidad?');">
        <input type="hidden" name="id" value="<?= $penalty['id'] ?>">
        <button type="submit" class="btn btn-danger">Eliminar</button>
    </form>
</div>
