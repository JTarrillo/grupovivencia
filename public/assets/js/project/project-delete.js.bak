// project-delete.js
// Lógica para eliminar proyectos inmobiliarios

function eliminar(projectId) {
    Swal.fire({
        title: '¿Está seguro de eliminar este proyecto?',
        text: '⚠️ ADVERTENCIA: Esto eliminará también todos los lotes asociados.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('/dashboard/inmueble/delete_project/' + projectId, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({ icon: 'success', title: '¡Eliminado!', text: data.message || 'Proyecto eliminado exitosamente', timer: 1800, showConfirmButton: false });
                    setTimeout(() => location.reload(), 1800);
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: data.message || 'Error desconocido' });
                }
            })
            .catch(error => {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Error al procesar la solicitud' });
            });
        }
    });
}
