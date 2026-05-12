// project-edit.js
// Lógica para editar proyectos inmobiliarios

function editProject(projectId) {
    fetch('/dashboard/inmueble/api/get_project/' + projectId)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                currentProjectData = data.project;
                loadProjectDataToModal(data.project);
                $('#editProjectModal').modal('show');
            } else {
                alert('Error al cargar los datos del proyecto');
            }
        })
        .catch(error => {
            alert('Error al cargar los datos del proyecto');
        });
}


// Utilidad para mostrar el texto del estado
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

// Utilidad para formatear fecha
function formatDate(dateStr) {
    if (!dateStr) return '';
    const d = new Date(dateStr);
    return d.toLocaleDateString('es-PE');
}

let currentProjectData = {};

function loadProjectDataToModal(project) {
    document.getElementById('edit_name').value = project.name || '';
    document.getElementById('edit_code').value = project.code || '';
    document.getElementById('edit_status').value = project.status || 'planning';
    document.getElementById('edit_base_price_per_sqm').value = project.base_price_per_sqm || 0;
    document.getElementById('edit_base_interest_rate').value = project.base_interest_rate || 3.5;
    document.getElementById('edit_description').value = project.description || '';

    // Asignar plan de pago desde el proyecto
    document.getElementById('edit_payment_plan_id').value = project.payment_plan_id || '';

    // Update statistics
    const totalLots = parseInt(project.total_lots) || 0;
    const availableLots = parseInt(project.available_lots) || 0;
    const soldLots = totalLots - availableLots;
    const soldPercentage = totalLots > 0 ? Math.round((soldLots / totalLots) * 100) : 0;

    document.getElementById('project_total_lots').textContent = totalLots;
    document.getElementById('project_available_lots').textContent = availableLots;
    document.getElementById('project_sold_lots').textContent = soldLots;
    document.getElementById('project_sold_percentage').textContent = soldPercentage + '%';

    // Update form action and view lots button
    document.getElementById('edit-project-form').action = '/dashboard/inmueble/edit_project/' + project.id;
    console.log('Form action asignado:', document.getElementById('edit-project-form').action);
    document.getElementById('viewLotsBtn').href = '/dashboard/inmueble/lots/' + project.id;

    // Update modal title
    document.getElementById('editProjectModalLabel').textContent = 'Editar Proyecto: ' + project.name;
}


document.addEventListener('DOMContentLoaded', function() {
    var editProjectModal = document.getElementById('editProjectModal');
    if (editProjectModal) {
        editProjectModal.addEventListener('shown.bs.modal', function() {
            toggleEditDownPaymentField();
        });
    }

    var editProjectForm = document.getElementById('edit-project-form');
    if (editProjectForm) {
        editProjectForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const interestRate = parseFloat(formData.get('base_interest_rate'));
            const pricePerSqm = parseFloat(formData.get('base_price_per_sqm'));

            // Validaciones
            if (interestRate < 2 || interestRate > 6) {
                alert('La tasa de interés debe estar entre 2% y 6%');
                return false;
            }

            if (pricePerSqm <= 0) {
                alert('El precio por m² debe ser mayor a 0');
                return false;
            }

            // Confirmar cambios importantes en el precio
                const currentPrice = parseFloat(currentProjectData.base_price_per_sqm) || 0;
                // Solo mostrar el mensaje si el usuario modificó el campo
                if (pricePerSqm !== currentPrice) {
                    if (currentPrice > 0 && Math.abs(pricePerSqm - currentPrice) > (currentPrice * 0.1)) {
                        if (!confirm('El precio por m² ha cambiado más del 10%. ¿Desea continuar?')) {
                            return false;
                        }
                    }
                }

            // Convertir FormData a URLSearchParams para enviar como x-www-form-urlencoded
            const params = new URLSearchParams();
            for (const pair of formData) {
                params.append(pair[0], pair[1]);
            }

            fetch(this.action, {
                method: 'POST',
                body: params,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            })
            .then(response => response.json())
            .then(data => {
                const errorDiv = document.getElementById('editProjectErrorMsg');
                if (data.success) {
                    $('#editProjectModal').modal('hide');
                    Swal.fire({ icon: 'success', title: '¡Éxito!', text: data.message || 'Proyecto actualizado exitosamente', timer: 1800, showConfirmButton: false });
                    setTimeout(() => location.reload(), 1800);
                } else {
                    errorDiv.textContent = data.message || 'Error desconocido';
                    errorDiv.classList.remove('d-none');
                }
            })
            .catch(error => {
                const errorDiv = document.getElementById('editProjectErrorMsg');
                errorDiv.textContent = 'Error al procesar la solicitud';
                errorDiv.classList.remove('d-none');
            });
        });
    }
});
