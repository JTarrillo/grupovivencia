// Suspender/activar contrato
function toggleContractStatus(contractId, currentStatus) {
    if (currentStatus === 'suspended') {
        Swal.fire({
            title: '¿Está seguro de activar este contrato?',
            text: 'El contrato volverá a estar activo.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, activar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                updateContractStatus(contractId, 'active');
            }
        });
    } else {
        Swal.fire({
            title: '¿Está seguro de suspender este contrato?',
            text: 'El contrato pasará a estado suspendido.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ffc107',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, suspender',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                updateContractStatus(contractId, 'suspended');
            }
        });
    }
}

function updateContractStatus(contractId, status) {
    fetch('/dashboard/inmueble/api/update_contract_status', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ contract_id: contractId, status: status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Estado actualizado',
                text: status === 'active' ? 'El contrato fue activado correctamente' : 'El contrato fue suspendido correctamente',
                timer: 1800,
                showConfirmButton: false
            });
            setTimeout(() => location.reload(), 1800);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message || 'Error al actualizar el estado',
                footer: data.debug ? JSON.stringify(data.debug) : ''
            });
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error de red',
            text: 'Error al procesar la solicitud'
        });
    });
}
