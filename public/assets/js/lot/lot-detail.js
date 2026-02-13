// lot-detail.js
// Lógica para ver detalles del lote en el modal, adaptada del antiguo lots.php
window.currentLotData = {};

window.view_lot = function(lotId) {
    fetch('/dashboard/inmueble/api/get_lot_details/' + lotId)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.currentLotData = data.lot;
                window.loadLotDetailsToModal(data.lot, data.project, data.customer, data.contract);
                $('#viewLotModal').modal('show');
            } else {
                alert('Error al cargar los detalles del lote');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al cargar los detalles del lote');
        });
};

window.loadLotDetailsToModal = function(lot, project, customer = null, contract = null) {
    document.getElementById('view_project_name').textContent = project?.name || 'N/A';
    document.getElementById('view_project_location').textContent = project?.location || 'N/A';
    document.getElementById('view_lot_number').textContent = lot.lot_number || 'N/A';
    document.getElementById('view_block').textContent = lot.block || 'N/A';
    document.getElementById('view_area').textContent = parseFloat(lot.area_sqm || 0).toLocaleString('es-PE', { minimumFractionDigits: 2 });

    // Precios
    const basePrice = parseFloat(lot.base_price || 0);
    const currentPrice = parseFloat(lot.current_price || 0);
    const area = parseFloat(lot.area_sqm || 0);
    const pricePerSqm = area > 0 ? currentPrice / area : 0;
    const totalLotPrice = area * pricePerSqm;

    document.getElementById('view_base_price').textContent = 'S/ ' + basePrice.toLocaleString('es-PE');
    document.getElementById('view_current_price').textContent = 'S/ ' + currentPrice.toLocaleString('es-PE');
    document.getElementById('view_price_per_sqm').textContent = 'S/ ' + pricePerSqm.toLocaleString('es-PE', { minimumFractionDigits: 2 });
    document.getElementById('view_total_lot_price').textContent = 'S/ ' + totalLotPrice.toLocaleString('es-PE', { minimumFractionDigits: 2 });

    // Cálculos financieros
    let initialPayment = 0;
    let initialLabel = '';
    if (project?.down_payment_type === 'fixed') {
        initialPayment = parseFloat(project.min_down_payment_fixed || 0);
        initialLabel = '(fijo)';
    } else {
        const percent = parseFloat(project.min_down_payment_percentage || 15);
        initialPayment = currentPrice * (percent / 100);
        initialLabel = `(${percent}% del precio)`;
    }
    const financeAmount = currentPrice - initialPayment;
    let months = 36;
    if (project?.max_financing_months) {
        months = parseInt(project.max_financing_months) || 36;
    } else if (project?.max_finance_months) {
        months = parseInt(project.max_finance_months) || 36;
    } else if (project?.max_months) {
        months = parseInt(project.max_months) || 36;
    }
    const annualRate = parseFloat(project?.base_interest_rate || project?.interest_rate || 4);
    const monthlyRate = annualRate / 100 / 12;
    const monthlyPayment = months > 0 ? financeAmount * monthlyRate * Math.pow(1 + monthlyRate, months) / (Math.pow(1 + monthlyRate, months) - 1) : 0;
    const appreciation = currentPrice - basePrice;
    document.getElementById('monthly_payment_label').textContent = `Cuota Mensual Aprox. (${months} meses)`;

    document.getElementById('view_initial_payment').textContent = 'S/ ' + initialPayment.toLocaleString('es-PE') + ' ' + initialLabel;
    document.getElementById('view_finance_amount').textContent = 'S/ ' + financeAmount.toLocaleString('es-PE');
    document.getElementById('view_monthly_payment').textContent = 'S/ ' + monthlyPayment.toLocaleString('es-PE');

    // Valorización
    const appreciationElement = document.getElementById('view_appreciation');
    if (appreciation > 0) {
        appreciationElement.textContent = '+S/ ' + appreciation.toLocaleString('es-PE');
        appreciationElement.className = 'h6 text-success';
    } else if (appreciation < 0) {
        appreciationElement.textContent = '-S/ ' + Math.abs(appreciation).toLocaleString('es-PE');
        appreciationElement.className = 'h6 text-danger';
    } else {
        appreciationElement.textContent = 'S/ 0';
        appreciationElement.className = 'h6 text-muted';
    }

    // Estado
    const statusBadge = document.getElementById('view_status_badge');
    switch (lot.status) {
        case 'available':
            statusBadge.textContent = 'Disponible';
            statusBadge.className = 'badge badge-success';
            break;
        case 'reserved':
            statusBadge.textContent = 'Reservado';
            statusBadge.className = 'badge badge-warning';
            break;
        case 'sold':
            statusBadge.textContent = 'Vendido';
            statusBadge.className = 'badge badge-danger';
            break;
        case 'blocked':
            statusBadge.textContent = 'Bloqueado';
            statusBadge.className = 'badge badge-secondary';
            break;
    }

    // Información del cliente
    if (customer && (lot.status === 'sold' || lot.status === 'reserved')) {
        document.getElementById('view_customer_section').style.display = 'block';
        document.getElementById('view_customer_name').textContent = customer.name || 'N/A';
        document.getElementById('view_customer_id').textContent = customer.id || 'N/A';
        if (contract) {
            document.getElementById('view_contract_number').textContent = contract.contract_number || 'N/A';
            document.getElementById('view_contract_status').textContent = contract.status || 'N/A';
        }
    } else {
        document.getElementById('view_customer_section').style.display = 'none';
    }

    // Historial de precios
    document.getElementById('view_current_price_history').textContent = currentPrice.toLocaleString('es-PE');
    document.getElementById('view_base_price_history').textContent = basePrice.toLocaleString('es-PE');
    document.getElementById('view_price_update_date').textContent = new Date(lot.price_last_updated || lot.updated_at).toLocaleDateString('es-PE');

    // Mapa
    document.getElementById('view_map_block').textContent = lot.block || 'N/A';
    document.getElementById('view_map_lot').textContent = lot.lot_number || 'N/A';

    // Métricas
    const createdDate = new Date(lot.created_at);
    const today = new Date();
    const daysInMarket = Math.floor((today - createdDate) / (1000 * 60 * 60 * 24));
    const appreciationPercent = basePrice > 0 ? ((currentPrice - basePrice) / basePrice * 100) : 0;
    const roiAnnual = appreciationPercent * (365 / Math.max(daysInMarket, 1));

    document.getElementById('view_days_market').textContent = daysInMarket;
    document.getElementById('view_appreciation_percent').textContent = appreciationPercent.toFixed(1) + '%';
    document.getElementById('view_roi_annual').textContent = roiAnnual.toFixed(1) + '%';
    document.getElementById('view_market_comparison').textContent = 'Promedio';
    document.getElementById('view_lot_score').textContent = '8.5/10';
    document.getElementById('view_demand_level').textContent = lot.status === 'available' ? 'Alta' : 'N/A';

    document.getElementById('view_last_updated').textContent = 'Actualizado: ' + new Date(lot.updated_at).toLocaleDateString('es-PE');
    document.getElementById('viewLotModalLabel').textContent = `Detalles del Lote ${lot.lot_number} - ${project?.name || 'N/A'}`;
};

window.editLotFromView = function() {
    $('#viewLotModal').modal('hide');
    setTimeout(() => {
        window.editLot(window.currentLotData.id);
    }, 300);
};

window.printLotDetails = function() {
    window.print();
};

window.createContract = function() {
    if (window.currentLotData.status !== 'available') {
        alert('Este lote no está disponible para crear un contrato');
        return;
    }
    window.location.href = '/dashboard/inmueble/create_contract?lot_id=' + window.currentLotData.id;
};

// Ejecutar en DOM ready para asegurar que los elementos existen
document.addEventListener('DOMContentLoaded', function() {
    // No se requiere lógica adicional aquí, las funciones son globales y se invocan desde el HTML
});
