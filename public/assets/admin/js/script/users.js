function edit_users(user_id){    
    var url = 'dashboard/usuarios/load/'+user_id;
    location.href = site+url;   
}
function new_user(){
   var url= 'dashboard/usuarios/load';
   location.href = site+url;
}
function cancelar_users(){
   var url= 'dashboard/usuarios';
   location.href = site+url;
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
                       position: 'top-end',
                       icon: 'success',
                       title: data.message,
                       showConfirmButton: false,
                   });
                   window.setTimeout(function () {
                       window.location = site + "dashboard/usuarios";
                   }, 1500);
               } else {
                   Swal.fire({
                       position: 'top-end',
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
                            position: 'top-end',
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
                            position: 'top-end',
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
