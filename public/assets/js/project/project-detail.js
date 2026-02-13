// project-detail.js
// Lógica para mostrar el detalle de proyectos inmobiliarios

function showProjectDetail(projectId) {
    fetch('/dashboard/inmueble/api/get_project/' + projectId)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const p = data.project;
                let html = `
                <div class="row">
                    <div class="col-md-6">
                        <strong>Nombre:</strong> ${p.name}<br>
                        <strong>Código:</strong> ${p.code}<br>
                        <strong>Ubicación:</strong> ${
                            (data.departamentos[p.department_id] || '<span style="color:#bbb">(Sin departamento)</span>') +
                                ' / ' +
                                (data.provincias[p.province_id] || '<span style="color:#bbb">(Sin provincia)</span>') +
                                ' / ' +
                                (data.distritos[p.district_id] || '<span style="color:#bbb">(Sin distrito)</span>')
                        }<br>
                        <strong>Estado:</strong> ${getStatusText(p.status)}<br>
                        <strong>Fecha de creación:</strong> ${formatDate(p.created_at)}<br>
                    </div>
                    <div class="col-md-6">
                        <strong>Precio Base m²:</strong> S/ ${Number(p.base_price_per_sqm).toLocaleString('es-PE', {minimumFractionDigits: 2, maximumFractionDigits: 2})}<br>
                        <strong>Tasa de Interés Base:</strong> ${parseFloat(p.base_interest_rate).toFixed(2)}%<br>
                        <strong>Cuota Inicial Mínima:</strong> 
                        ${p.down_payment_type === 'fixed' ? (p.min_down_payment_fixed ? 'S/ ' + Number(p.min_down_payment_fixed).toLocaleString('es-PE', {minimumFractionDigits: 2, maximumFractionDigits: 2}) : 'N/A') : (p.min_down_payment_percentage ? p.min_down_payment_percentage + '%' : 'N/A')}<br>
                        <strong>Máx. Meses Financiamiento:</strong> ${p.max_financing_months || 'N/A'}<br>
                    </div>
                </div>
                <hr>
                <strong>Descripción:</strong>
                <p>${p.description || ''}</p>
                <hr>
                <div class="row text-center">
                    <div class="col-md-3">
                        <small class="text-muted">Total Lotes</small>
                        <div class="h5 text-primary">${p.total_lots}</div>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted">Disponibles</small>
                        <div class="h5 text-success">${p.available_lots}</div>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted">Vendidos</small>
                        <div class="h5 text-info">${(p.total_lots - p.available_lots)}</div>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted">% Vendido</small>
                        <div class="h5 text-warning">${p.total_lots > 0 ? Math.round(((p.total_lots - p.available_lots) / p.total_lots) * 100) : 0}%</div>
                    </div>
                </div>
            `;
                document.getElementById('projectDetailBody').innerHTML = html;
                document.getElementById('projectDetailModalLabel').textContent = 'Detalle del Proyecto: ' + p.name;
                $('#projectDetailModal').modal('show');
            } else {
                alert('Error al cargar el detalle del proyecto');
            }
        })
        .catch(error => {
            alert('Error al cargar el detalle del proyecto');
        });
}

function getStatusText(status) {
    switch (status) {
        case 'active':
            return 'Activo';
        case 'planning':
            return 'En Planificación';
        case 'sold_out':
            return 'Agotado';
        case 'suspended':
            return 'Suspendido';
        default:
            return status;
    }
}

function formatDate(dateStr) {
    if (!dateStr) return '';
    const d = new Date(dateStr);
    return d.toLocaleDateString('es-PE');
}
