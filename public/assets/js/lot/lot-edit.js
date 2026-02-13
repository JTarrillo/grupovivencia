// lot-edit.js
// Lógica para editar lotes inmobiliarios
// Cierra el modal de contrato si está abierto antes de abrir el de reserva
function closeContractModalIfOpen() {
    var contractModal = document.getElementById('newContractModal');
    if (contractModal && $(contractModal).hasClass('show')) {
        $(contractModal).modal('hide');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    var editLotForm = document.getElementById('edit-lot-form');
    if (editLotForm) {
        editLotForm.addEventListener('submit', function(e) {
            e.preventDefault();
            // Recopilar datos como objeto plano
            const data = {
                project_id: document.getElementById('edit_project_id').value,
                block: document.getElementById('edit_block').value,
                cadastral_unit: document.getElementById('edit_cadastral_unit').value,
                registry_number: document.getElementById('edit_registry_number').value,
                area_sqm: document.getElementById('edit_area_sqm').value,
                base_price: document.getElementById('edit_base_price').value,
                current_price: document.getElementById('edit_current_price').value,
                status: document.getElementById('edit_status').value
            };
            const area = parseFloat(data.area_sqm);
            const basePrice = parseFloat(data.base_price);

            // Validaciones
            if (area < 50) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Área insuficiente',
                    text: 'El área mínima debe ser de 50 m²'
                });
                return false;
            }

            if (basePrice <= 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Precio inválido',
                    text: 'El precio del lote debe ser mayor a 0'
                });
                return false;
            }

            // Enviar como JSON
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    $('#editLotModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: data.message || 'Lote actualizado exitosamente',
                        timer: 1800,
                        showConfirmButton: false
                    });
                    setTimeout(() => location.reload(), 1800);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Error desconocido'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al procesar la solicitud'
                });
            });
        });
    }
});

// Definir currentLotData en el scope global si no existe
if (typeof window.currentLotData === 'undefined') {
    window.currentLotData = {};
}

// Definir loadLotDataToModal en el scope global si no existe
if (typeof window.loadLotDataToModal !== 'function') {
    window.loadLotDataToModal = function(lot) {
        // Seleccionar el proyecto correcto en el select
        var projectSelect = document.getElementById('edit_project_id');
            projectSelect.value = lot.project_id || '';

            // Asegurar que el precio por m² se actualice directamente después de establecer el proyecto
            updateLotPricePerSqm();

        // Forzar el evento change para actualizar el precio por m²
        var event = new Event('change');
        projectSelect.dispatchEvent(event);

    document.getElementById('edit_lot_number').value = lot.lot_number || '';
    document.getElementById('edit_block').value = lot.block || '';
    document.getElementById('edit_cadastral_unit').value = lot.cadastral_unit || '';
    document.getElementById('edit_area_sqm').value = lot.area_sqm || 0;
    document.getElementById('edit_base_price').value = lot.base_price || 0;
    document.getElementById('edit_current_price').value = lot.current_price || 0;
    document.getElementById('edit_status').value = lot.status || 'available';

        // Mostrar info de cliente si está vendido/reservado
        if (lot.status === 'sold' || lot.status === 'reserved') {
            document.getElementById('customer-info').style.display = 'block';
            document.getElementById('customer_id_display').textContent = lot.customer_id || 'N/A';
        } else {
            document.getElementById('customer-info').style.display = 'none';
        }

        // Actualizar acción del formulario
        document.getElementById('edit-lot-form').action = '/dashboard/inmueble/edit_lot/' + lot.id;

        // Actualizar título del modal
        document.getElementById('editLotModalLabel').textContent = 'Editar Lote: ' + lot.lot_number;

        // Calcular precios
        if (typeof window.calculateLotPrice === 'function') {
            window.calculateLotPrice();
        }
    };
}

// Adaptación para que funcione igual que el antiguo
window.currentLotData = {};

window.editLot = function(lotId) {
    closeContractModalIfOpen();
    fetch('/dashboard/inmueble/api/get_lot_details/' + lotId)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.currentLotData = data.lot;
                window.loadLotDataToModal(data.lot);
                // Mostrar estado del contrato
                var contractStatus = 'Sin contrato';
                var contractBadge = 'badge-warning';
                if (data.contract && data.contract.status) {
                    contractStatus = data.contract.status.charAt(0).toUpperCase() + data.contract.status.slice(1);
                    contractBadge = 'badge-success';
                }
                var contractStatusDisplay = document.getElementById('contract_status_display');
                if (contractStatusDisplay) {
                    contractStatusDisplay.textContent = contractStatus;
                    contractStatusDisplay.className = 'badge ' + contractBadge;
                }
                $('#editLotModal').modal('show');
            } else {
                alert('Error al cargar los datos del lote');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al cargar los datos del lote');
        });
};

window.loadLotDataToModal = function(lot) {
    document.getElementById('edit_project_id').value = lot.project_id || '';
    document.getElementById('edit_lot_number').value = lot.lot_number || '';
    document.getElementById('edit_block').value = lot.block || '';
    document.getElementById('edit_cadastral_unit').value = lot.cadastral_unit || '';
    document.getElementById('edit_registry_number').value = lot.registry_number || '';
    document.getElementById('edit_area_sqm').value = lot.area_sqm || 0;
    document.getElementById('edit_base_price').value = lot.base_price || 0;
    document.getElementById('edit_current_price').value = lot.current_price || 0;

    // Mostrar solo el estado del lote según el campo status
    document.getElementById('edit_status').value = lot.status || 'available';

    window.updateLotPricePerSqm();

    // Mostrar info de cliente si está vendido/reservado
    if (lot.status === 'sold' || lot.status === 'reserved') {
        document.getElementById('customer-info').style.display = 'block';
        document.getElementById('customer_id_display').textContent = lot.customer_id || 'N/A';
    } else {
        document.getElementById('customer-info').style.display = 'none';
    }

    document.getElementById('edit-lot-form').action = '/dashboard/inmueble/edit_lot/' + lot.id;
    document.getElementById('editLotModalLabel').textContent = 'Editar Lote: ' + lot.lot_number;
    window.calculateLotPrice();
};

window.updateLotPricePerSqm = function() {
    const projectSelect = document.getElementById('edit_project_id');
    const selectedOption = projectSelect.options[projectSelect.selectedIndex];
    if (selectedOption.value) {
        const price = selectedOption.getAttribute('data-price');
        document.getElementById('edit_price_per_sqm').value = price;
        window.calculateLotPrice();
    } else {
        document.getElementById('edit_price_per_sqm').value = '';
    }
};

window.calculateLotPrice = function() {
    const area = parseFloat(document.getElementById('edit_area_sqm').value) || 0;
    const pricePerSqm = parseFloat(document.getElementById('edit_price_per_sqm').value) || 0;
    const basePrice = parseFloat(document.getElementById('edit_base_price').value) || 0;
    const projectSelect = document.getElementById('edit_project_id');
    const selectedOption = projectSelect.options[projectSelect.selectedIndex];
    let downPaymentType = 'percentage';
    let minDownPaymentPercentage = 15;
    let minDownPaymentFixed = 0;
    if (selectedOption) {
        downPaymentType = selectedOption.getAttribute('data-down-payment-type') || 'percentage';
        minDownPaymentPercentage = parseFloat(selectedOption.getAttribute('data-min-down-payment-percentage')) || 15;
        minDownPaymentFixed = parseFloat(selectedOption.getAttribute('data-min-down-payment-fixed')) || 0;
    }
    if (area > 0 && pricePerSqm > 0) {
        const calculatedPrice = area * pricePerSqm;
        let initialPayment = 0;
        let initialLabel = '';
        if (downPaymentType === 'fixed') {
            initialPayment = minDownPaymentFixed;
            initialLabel = '(fijo)';
        } else {
            initialPayment = calculatedPrice * (minDownPaymentPercentage / 100);
            initialLabel = '(' + minDownPaymentPercentage + '%)';
        }
        const priceDifference = basePrice - calculatedPrice;
        document.getElementById('calc_area').textContent = area.toFixed(2) + ' m²';
        document.getElementById('calc_price').textContent = 'S/ ' + calculatedPrice.toLocaleString('es-PE');
        document.getElementById('calc_initial').textContent = 'S/ ' + initialPayment.toLocaleString('es-PE') + ' ' + initialLabel;
        const diffElement = document.getElementById('calc_difference');
        if (priceDifference > 0) {
            diffElement.textContent = '+S/ ' + Math.abs(priceDifference).toLocaleString('es-PE');
            diffElement.className = 'h6 text-success';
        } else if (priceDifference < 0) {
            diffElement.textContent = '-S/ ' + Math.abs(priceDifference).toLocaleString('es-PE');
            diffElement.className = 'h6 text-danger';
        } else {
            diffElement.textContent = 'S/ 0';
            diffElement.className = 'h6 text-muted';
        }
    }
};

// Listener para el select de proyecto
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('edit_project_id').addEventListener('change', window.updateLotPricePerSqm);
});

