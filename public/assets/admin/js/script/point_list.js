function edit_points(binaries_id){    
    var url = 'dashboard/puntos/load/'+binaries_id;
    location.href = site+url;   
}
function cancel_points(){
   var url= 'dashboard/puntos';
   location.href = site+url;
}

function validate(){
   document.getElementById("submit").disabled = true;
   document.getElementById("submit").innerHTML = "<span class='spinner-border spinner-border-sm' role='status'></span> Procesando...";
   oData = new FormData(document.forms.namedItem("form-points"));
       $.ajax({
           url: site + "dashboard/puntos/validate",
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
                       title: 'Cambios Guardado',
                       showConfirmButton: false,
                   });
                   window.setTimeout(function () {
                       window.location = site + "dashboard/puntos";
                   }, 1500);
               } else {
                   Swal.fire({
                       position: 'top-end',
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

function delete_points(id){
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
               type: "post",
               url: site+"dashboard/puntos/eliminar",
               dataType: "json",
               data: {id : id},
               success: function (data) {
                   if (data.status == true) {
                       Swal.fire({
                           position: 'top-end',
                           icon: 'success',
                           title: 'Eliminado',
                           showConfirmButton: false,
                           timer: 1500
                       });
                       window.setTimeout(function () {
                           window.location = site + "dashboard/puntos";
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

