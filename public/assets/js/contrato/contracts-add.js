// Mostrar/ocultar campos de reserva
function toggleReservationFields() {
    const isReserved = document.getElementById('is_reserved').checked;
    document.getElementById('reservation_fields').style.display = isReserved ? 'block' : 'none';
}
// Cargar lotes disponibles desde el backend
function loadAvailableLots() {
    fetch('/dashboard/inmueble/api/get_available_lots', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log('Respuesta de get_available_lots:', data);
        window.availableLots = data.lots || [];
        displayAvailableLots(window.availableLots);
        updateLotsCount(window.availableLots.length);
    })
    .catch(error => {
        console.error('Error al cargar lotes:', error);
        displayAvailableLots([]);
        updateLotsCount(0);
    });
}
// ...existing code...

// Actualizar el contador de lotes disponibles
function updateLotsCount(count) {
    const lotsCount = document.getElementById('lots_count');
    if (lotsCount) {
        lotsCount.textContent = `${count} lote${count === 1 ? '' : 's'}`;
    }
}
// Navegar al siguiente tab en el formulario de contrato
function nextTab() {
    const tabs = ['customer-section', 'lot-section', 'payment-section', 'summary-section'];
    let activeIndex = tabs.findIndex(tab => document.getElementById(tab).classList.contains('show'));
        if (activeIndex < tabs.length - 1) {
            showTab(activeIndex + 1);
            // Mostrar los lotes disponibles en consola al pasar al tab de lotes
            if (tabs[activeIndex + 1] === 'lot-section') {
                console.log('Lotes disponibles al pasar a Lote:', window.availableLots);
            }
        }
}

// Navegar al tab anterior
function previousTab() {
    const tabs = ['customer-section', 'lot-section', 'payment-section', 'summary-section'];
    let activeIndex = tabs.findIndex(tab => document.getElementById(tab).classList.contains('show'));
    if (activeIndex > 0) {
        showTab(activeIndex - 1);
    }
}

// Mostrar el tab correspondiente
function showTab(tabIndex) {
    const tabs = ['customer-section', 'lot-section', 'payment-section', 'summary-section'];
    tabs.forEach((tab, i) => {
        const tabPane = document.getElementById(tab);
        const navLink = document.querySelector(`[href="#${tab}"]`);
        if (i === tabIndex) {
            tabPane.classList.add('show', 'active');
            navLink.classList.add('active');
            navLink.classList.remove('disabled');
            // Debug y actualización de resumen al entrar al tab de resumen
            if (tab === 'summary-section' && typeof updateSummary === 'function') {
                console.log('Aresumen del contrato...');
                console.log('selectedCustomer:', window.selectedCustomer);
                console.log('selectedLot:', window.selectedLot);
                console.log('selectedPlan:', window.selectedPlan);
                updateSummary();
            }
        } else {
            tabPane.classList.remove('show', 'active');
            navLink.classList.remove('active');
            navLink.classList.add('disabled');
        }
    });
    // Actualiza los botones de navegación al cambiar de tab
    if (typeof updateNavigationButtons === 'function') {
        updateNavigationButtons();
    }

    // Verifica el id del botón y muestra un console.log si estamos en el tab 4
    setTimeout(() => {
        const nextBtn = document.getElementById('next-btn') || document.getElementById('nextBtn');
        const tabsArr = ['customer-section', 'lot-section', 'payment-section', 'summary-section'];
        let activeIndex = tabsArr.findIndex(tab => document.getElementById(tab).classList.contains('show'));
        if (activeIndex === tabsArr.length - 1) {
            console.log('Tab 4 activo. Botón encontrado:', nextBtn ? nextBtn.id : 'NO ENCONTRADO');
        }
    }, 100);
}
// Seleccionar cliente de la lista de resultados
function selectCustomer(customer) {
    document.getElementById('customer_id').value = customer.id;
    document.getElementById('customer_name_display').textContent = `${customer.name} ${customer.lastname || ''}`;
    document.getElementById('customer_dni_display').textContent = customer.dni || 'N/A';
    document.getElementById('customer_email_display').textContent = customer.email || 'N/A';
    document.getElementById('customer_phone_display').textContent = customer.phone || 'N/A';
    document.getElementById('selected_customer').style.display = 'block';
    document.getElementById('no_customer_selected').style.display = 'none';
    document.getElementById('customer_results').innerHTML = '';
    // Si tienes lógica extra para navegación, agrégala aquí
}
// Buscar clientes para el contrato
function searchCustomers() {
    const searchTerm = document.getElementById('customer_search').value.trim();
    if (!searchTerm) return;
    fetch('/dashboard/inmueble/api/search_customers', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ search: searchTerm })
    })
    .then(response => response.json())
    .then(data => {
        displayCustomerResults(data.customers || []);
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al buscar clientes');
    });
}
// Mostrar resultados de búsqueda de clientes
function displayCustomerResults(customers) {
    const resultsContainer = document.getElementById('customer_results');
    resultsContainer.innerHTML = '';
    if (customers.length === 0) {
        resultsContainer.innerHTML = '<div class="list-group-item text-muted">No se encontraron clientes</div>';
        return;
    }
    customers.forEach(customer => {
        const customerItem = document.createElement('a');
        customerItem.href = '#';
        customerItem.className = 'list-group-item list-group-item-action';
        customerItem.onclick = (e) => {
            e.preventDefault();
            selectCustomer(customer);
        };
        customerItem.innerHTML = `
            <div class="d-flex w-100 justify-content-between">
                <h6 class="mb-1">${customer.name} ${customer.lastname || ''}</h6>
                <small>ID: ${customer.id}</small>
            </div>
            <p class="mb-1">DNI: ${customer.dni || 'N/A'} | Email: ${customer.email || 'N/A'}</p>
            <small>Teléfono: ${customer.phone || 'N/A'}</small>
        `;
        resultsContainer.appendChild(customerItem);
    });
}
// Agregar contrato
// Este archivo debe contener la lógica para crear un contrato vía AJAX si lo deseas modularizar.
// Ejemplo:
function createContract(formData) {
    // Obtener datos para el resumen
    var cliente = document.getElementById('customer_name_display').textContent;
    var dni = document.getElementById('customer_dni_display').textContent;
    var lote = document.getElementById('selected_lot_number').textContent;
    var proyecto = document.getElementById('selected_project_name').textContent;
    var precio = document.getElementById('selected_lot_price').textContent;
    var cuotaInicial = document.getElementById('down_payment').value;
    var meses = document.getElementById('financing_months').value;
    var tasa = document.getElementById('interest_rate').value;
    var fechaContrato = document.getElementById('contract_date').value;
    var isReservedEl = document.getElementById('is_reserved');
    var reservationAmountEl = document.getElementById('reservation_amount');
    var reservationDateEl = document.getElementById('reservation_date');
    var reservaHtml = '';
    if (isReservedEl && isReservedEl.checked) {
        reservaHtml = `<b>Reserva:</b> S/ ${reservationAmountEl.value} <br>Fecha: ${reservationDateEl.value}`;
    }
    var resumenHtml = `
        <div style='text-align:left;'>
            <b>Cliente:</b> ${cliente} <br>
            <b>DNI:</b> ${dni} <br>
            <b>Proyecto:</b> ${proyecto} <br>
            <b>Lote:</b> ${lote} <br>
            <b>Precio:</b> S/ ${precio} <br>
            <b>Cuota Inicial:</b> S/ ${cuotaInicial} <br>
            <b>Meses:</b> ${meses} <br>
            <b>Tasa:</b> ${tasa}% <br>
            <b>Fecha Contrato:</b> ${fechaContrato} <br>
            ${reservaHtml}
        </div>
    `;
    Swal.fire({
        title: 'Confirmar datos del contrato',
        html: resumenHtml,
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: 'Confirmar y crear',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Agregar datos de reserva si corresponde
            if (isReservedEl && isReservedEl.checked) {
                let montoReserva = reservationAmountEl ? reservationAmountEl.value : '';
                let fechaReserva = reservationDateEl ? reservationDateEl.value : '';
                if (!montoReserva || !fechaReserva) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Datos de reserva incompletos',
                        text: 'Debes ingresar el monto y la fecha de reserva.',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
                formData.append('is_reserved', 1);
                formData.append('reservation_amount', montoReserva);
                formData.append('reservation_date', fechaReserva);
            } else {
                formData.append('is_reserved', 0);
                formData.append('reservation_amount', '');
                formData.append('reservation_date', '');
            }
            fetch('/dashboard/inmueble/create_contract', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    $('#newContractModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: '¡Contrato creado!',
                        text: 'Contrato creado exitosamente: ' + data.contract_number,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al crear el contrato: ' + (data.message || 'Error desconocido'),
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al procesar la solicitud',
                    confirmButtonText: 'OK'
                });
            });
        }
    });
}
// Mostrar modal para nuevo contrato
function openNewContractModal() {
    if (typeof Swal !== 'undefined' && Swal.close) {
        Swal.close();
    }
    $('#newContractModal').modal('show');
}
