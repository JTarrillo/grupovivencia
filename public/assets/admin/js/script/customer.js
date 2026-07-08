// Customer management functions
console.log('customer.js loaded successfully at ' + new Date().toISOString());
console.log('loadCreateCustomerModal function will be available');

function validate() {
    document.getElementById("submit").disabled = true;
    document.getElementById("submit").innerHTML = "<span class='spinner-border spinner-border-sm' role='status'></span> Procesando...";
    oData = new FormData(document.forms.namedItem("form-customer"));
    $.ajax({
        url: site + "dashboard/clientes/validate",
        method: "POST",
        data: oData,
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            // data ya es objeto, no parsear
            if (data.status == true) {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Cambios Guardado',
                    showConfirmButton: false,
                });
                window.setTimeout(function () {
                    window.location = site + "dashboard/clientes";
                }, 1500);
            } else {
                Swal.fire({
                    position: 'center',
                    icon: 'info',
                    title: 'Sucedio un error',
                    footer: 'Vuelva a Intentarlo'
                });
                document.getElementById("submit").disabled = false;
                document.getElementById("submit").innerHTML = "Guardar";
            }
        }
    });
}

/**
 * Crear nuevo cliente - función separada para STORE
 */
function createCustomer() {
    const form = document.getElementById('form-customer');
    if (form && !form.checkValidity()) {
        form.reportValidity();
        return;
    }

    document.getElementById("submit").disabled = true;
    document.getElementById("submit").innerHTML = "<span class='spinner-border spinner-border-sm' role='status'></span> Creando...";
    
    var oData = new FormData(document.forms.namedItem("form-customer"));
    
    $.ajax({
        url: site + "dashboard/clientes/store",
        method: "POST",
        data: oData,
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            if (data.success == true) {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Cliente creado correctamente',
                    html: data.code ? ('<p>Codigo generado: <strong>' + data.code + '</strong></p>') : '',
                    showConfirmButton: false,
                    timer: 1800
                });
                $('#modalCreateCustomer').modal('hide');
                window.setTimeout(function () {
                    window.location = site + "dashboard/clientes";
                }, 1800);
            } else {
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Error al crear el cliente'
                });
                document.getElementById("submit").disabled = false;
                document.getElementById("submit").innerHTML = "Crear Cliente";
            }
        },
        error: function() {
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error de conexión',
                text: 'Intente nuevamente'
            });
            document.getElementById("submit").disabled = false;
            document.getElementById("submit").innerHTML = "Crear Cliente";
        }
    });
}

/**
 * Actualizar cliente - función separada para UPDATE
 */
function updateCustomer() {
    document.getElementById("submit").disabled = true;
    document.getElementById("submit").innerHTML = "<span class='spinner-border spinner-border-sm' role='status'></span> Actualizando...";
    
    var oData = new FormData(document.forms.namedItem("form-customer"));
    
    $.ajax({
        url: site + "dashboard/clientes/update",
        method: "POST",
        data: oData,
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            if (data.success == true) {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Cliente actualizado correctamente',
                    showConfirmButton: false,
                    timer: 1500
                });
                window.setTimeout(function () {
                    window.location = site + "dashboard/clientes";
                }, 1500);
            } else {
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Error al actualizar el cliente'
                });
                document.getElementById("submit").disabled = false;
                document.getElementById("submit").innerHTML = "Guardar";
            }
        },
        error: function() {
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error de conexión',
                text: 'Intente nuevamente'
            });
            document.getElementById("submit").disabled = false;
            document.getElementById("submit").innerHTML = "Guardar";
        }
    });
}

/**
 * Cargar formulario vacío para crear nuevo cliente
 */
console.log('About to define loadCreateCustomerModal');
function loadCreateCustomerModal() {
    console.log('loadCreateCustomerModal called');
    $.ajax({
        url: site + 'dashboard/clientes/form_modal',
        type: 'GET',
        success: function(data) {
            $('#modalCreateCustomer .modal-body').html(data);
            $('#modalCreateCustomer .modal-title').text('Crear Nuevo Cliente');
            $('#modalCreateCustomer .modal-footer .btn-primary').text('Crear Cliente');
            $('#modalCreateCustomer').modal('show');
        },
        error: function() {
            Swal.fire('Error', 'No se pudo cargar el formulario', 'error');
        }
    });
}

function validate_user(username) {
    if (username == "") {
        $(".alert-0").removeClass('text-success').addClass('text-danger').html("Usuario Invalido <i class='fa fa-times-circle-o' aria-hidden='true'></i>");
    } else {
        $.ajax({
            type: "post",
            url: site + "dashboard/integracion_puntos/validate_user",
            dataType: "json",
            data: { username: username },
            success: function (data) {
                if (data.message == true) {
                    $(".alert-0").removeClass('text-danger').addClass('text-success').html(data.print);
                    var inputCustomer_id = document.getElementById("sponsor_id");
                    inputCustomer_id.value = data.customer_id;
                    var inputCustomer = document.getElementById("customer");
                    inputCustomer.value = data.name;
                } else {
                    $(".alert-0").removeClass('text-success').addClass('text-danger').html(data.print);
                }
            }
        });
    }
}

/**
 * Editar cliente - cargar modal con datos
 */
function edit_customer(customer_id) {
    $.ajax({
        url: site + 'dashboard/clientes/form_modal/' + customer_id,
        type: 'GET',
        success: function(data) {
            $('#modalCreateCustomer .modal-body').html(data);
            $('#modalCreateCustomer .modal-title').text('Editar Cliente');
            $('#modalCreateCustomer .modal-footer .btn-primary').text('Guardar Cambios');
            $('#modalCreateCustomer').modal('show');
        },
        error: function() {
            Swal.fire('Error', 'No se pudo cargar el formulario', 'error');
        }
    });
}

/**
 * Crear nuevo cliente - función separada para STORE
 */
function create_customer() {
    var url = 'dashboard/clientes/create';
    location.href = site + url;
}
/**
 * Detectar si es crear o editar y llamar función apropiada
 */
function submitCustomerForm() {
    const form = document.getElementById('form-customer');
    if (form && !form.checkValidity()) {
        form.reportValidity();
        return;
    }

    const action = document.querySelector('input[name="action"]').value;
    const submitBtn = document.querySelector('#modalCreateCustomer .modal-footer .btn-primary');
    
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = "<span class='spinner-border spinner-border-sm' role='status'></span> Procesando...";
    }
    
    var oData = new FormData(document.forms.namedItem("form-customer"));
    const url = action === 'create' ? site + "dashboard/clientes/store" : site + "dashboard/clientes/update";
    
    $.ajax({
        url: url,
        method: "POST",
        data: oData,
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            if (data.success == true) {
                const message = action === 'create' ? 'Cliente creado correctamente' : 'Cliente actualizado correctamente';
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: message,
                    html: action === 'create' && data.code ? ('<p>Codigo generado: <strong>' + data.code + '</strong></p>') : '',
                    showConfirmButton: false,
                    timer: 1800
                });
                $('#modalCreateCustomer').modal('hide');
                window.setTimeout(function () {
                    window.location = site + "dashboard/clientes";
                }, 1800);
            } else {
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Error al procesar'
                });
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = action === 'create' ? 'Crear Cliente' : 'Guardar Cambios';
                }
            }
        },
        error: function() {
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error de conexión',
                text: 'No se pudo conectar con el servidor'
            });
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = action === 'create' ? 'Crear Cliente' : 'Guardar Cambios';
            }
        }
    });
}
function cancelar_customer() {
    var url = 'dashboard/clientes';
    location.href = site + url;
}

function view(id) {
    var url = 'dashboard/ventas/load/' + id;
    location.href = site + url;
}

function back() {
    var url = 'dashboard/ventas';
    location.href = site + url;
}

function exportToExcel(customers) {
    const data = customers.map((customer) => {
        return {
            id: customer.id,
            customer: `${customer.name} ${customer.lastname}`,
            user: customer.username,
            dni: customer.dni,
            email: customer.email,
            range: customer.range,
            state: customer.active == '0' ? "No Activo" : "Activo",
        }
    })
    const workbook = XLSX.utils.book_new();
    const worksheet = XLSX.utils.json_to_sheet(data);
    XLSX.utils.book_append_sheet(workbook, worksheet, "clientes");
    XLSX.utils.sheet_add_aoa(worksheet, [["ID", "CLIENTE", "USUARIO", "DNI", "CORREO", "RANGO", "ESTADO"]], { origin: "A1" });
    XLSX.writeFile(workbook, "clientes.xlsx", { compression: true });
}


function eliminar(id){
    Swal.fire({
        title: 'Confirma que desea eliminar el registro?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Confirmo'
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: site + "dashboard/clientes/eliminar",
                type: "post",
                dataType: "json",
                data: {id : id},
                success: function (data) {
                    if (data.status == true) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        window.setTimeout(function () {
                            window.location = site + "dashboard/clientes";
                        }, 1500);
                    } else {
                        Swal.fire({
                            position: 'center',
                            icon: 'info',
                            title: data.message
                        });
                    }
                }
            });
        }
    }); 
}
