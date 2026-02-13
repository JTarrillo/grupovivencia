// lot-delete.js
// Lógica para eliminar lotes inmobiliarios

document.addEventListener('DOMContentLoaded', function() {
    window.eliminar_lot = function(lotId) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción eliminará el lote permanentemente.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('/dashboard/inmueble/delete_lot/' + lotId, {
                        method: 'GET'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Eliminado',
                                text: data.message || 'Lote eliminado exitosamente',
                                timer: 1800,
                                showConfirmButton: false
                            });
                            setTimeout(() => location.reload(), 1800);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message || 'No se pudo eliminar el lote'
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al procesar la solicitud'
                        });
                    });
            }
        });
    };
});
