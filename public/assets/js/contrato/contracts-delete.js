// Eliminar contrato
function deleteContract(contractId) {
    Swal.fire({
        title: '¿Está seguro de eliminar este contrato?',
        text: 'Esta acción no se puede deshacer.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('/dashboard/inmueble/api/delete_contract', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ contract_id: contractId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Eliminado', 'El contrato ha sido eliminado.', 'success');
                    setTimeout(() => location.reload(), 1200);
                } else {
                    Swal.fire('Error', data.message || 'No se pudo eliminar el contrato.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'No se pudo procesar la solicitud.', 'error');
            });
        }
    });
}
