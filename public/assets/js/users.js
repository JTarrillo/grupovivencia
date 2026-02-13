// JS para gestión de usuarios (CRUD)
// Requiere SweetAlert2 y DataTables

function deleteUser(userId) {
    Swal.fire({
        title: '¿Está seguro de eliminar este usuario?',
        text: 'Esta acción no se puede deshacer.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('/dashboard/usuario/api/delete_user', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ user_id: userId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Usuario eliminado',
                        text: 'El usuario fue eliminado correctamente',
                        timer: 1800,
                        showConfirmButton: false
                    });
                    setTimeout(() => location.reload(), 1800);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'No se pudo eliminar el usuario',
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
    });
}

// ...puedes agregar funciones para crear/editar si tienes endpoints y formularios
