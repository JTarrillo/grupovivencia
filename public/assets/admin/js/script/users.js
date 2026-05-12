function edit_users(user_id){    
    $.ajax({
        url: site + 'dashboard/usuarios/form_modal/' + user_id,
        type: 'GET',
        success: function(data) {
            $('#userModalBody').html(data);
            $('#userModal').modal('show');
        },
        error: function() {
            Swal.fire('Error', 'No se pudo cargar el formulario', 'error');
        }
    });
}

function new_user(){
    $.ajax({
        url: site + 'dashboard/usuarios/form_modal',
        type: 'GET',
        success: function(data) {
            $('#userModalBody').html(data);
            $('#userModal').modal('show');
        },
        error: function() {
            Swal.fire('Error', 'No se pudo cargar el formulario', 'error');
        }
    });
}
function cancelar_users(){
   $('#userModal').modal('hide');
}
function validate(){
   document.getElementById("submit").disabled = true;
   document.getElementById("submit").innerHTML = "<span class='spinner-border spinner-border-sm' role='status'></span> Procesando...";
   oData = new FormData(document.forms.namedItem("form-user"));
       $.ajax({
           url: site + "dashboard/usuarios/validate",
           method: "POST",
           data: oData,
           contentType: false,
           cache: false,
           processData: false,
           success: function (data) {
               var data = JSON.parse(data);
               if (data.status == true) {
                   Swal.fire({
                       position: 'center',
                       icon: 'success',
                       title: data.message,
                       showConfirmButton: false,
                   });
                   $('#userModal').modal('hide');
                   window.setTimeout(function () {
                       window.location = site + "dashboard/usuarios";
                   }, 1500);
               } else {
                   Swal.fire({
                       position: 'center',
                       icon: 'info',
                       title: data.message
                   });
                   document.getElementById("submit").disabled = false;
                   document.getElementById("submit").innerHTML = "Guardar";
               }
           }
       });
}

function eliminar(user_id){
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
                url: site + "dashboard/usuarios/eliminar",
                type: "post",
                dataType: "json",
                data: {user_id : user_id},
                success: function (data) {
                    if (data.status == true) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Registro Eliminado',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        window.setTimeout(function () {
                            window.location = site + "dashboard/usuarios";
                        }, 1500);
                    } else {
                        Swal.fire({
                            position: 'center',
                            icon: 'info',
                            title: 'Sucedio un error',
                            footer: 'Comunique a soporte'
                        });
                    }
                }
            });
        }
    }); 
}

function show_pass(){
    var passwordInput = document.getElementById("password");
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
    } else {
        passwordInput.type = "password";
    }
}
