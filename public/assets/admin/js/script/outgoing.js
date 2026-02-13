function new_outgoing() {
  var url = 'dashboard/salidas/load';
  location.href = site + url;
}

function edit_outgoing(incoming_id){    
  var url = 'dashboard/salidas/load/'+incoming_id;
  location.href = site+url;   
}
function cancel_outgoing(){
var url= 'dashboard/salidas';
location.href = site+url;
}

function validate(){
 document.getElementById("submit").disabled = true;
 document.getElementById("submit").innerHTML = "<span class='spinner-border spinner-border-sm' role='status'></span> Procesando...";
 oData = new FormData(document.forms.namedItem("form"));
     $.ajax({
         url: site + "dashboard/salidas/validate",
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
                     window.location = site + "dashboard/salidas";
                 }, 1500);
             } else {
                 Swal.fire({
                     position: 'top-end',
                     icon: 'info',
                     title: data.message,
                 });
                 document.getElementById("submit").disabled = false;
                 document.getElementById("submit").innerHTML = "<i class='fa fa-cloud'></i> Guardar";
             }
         }
     });
}

function eliminar(outgoing_id){
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
             url: site + "dashboard/salidas/delete",
             type: "post",
             dataType: "json",
             data: {outgoing_id : outgoing_id},
             success: function (data) {
                 if (data.status == true) {
                     Swal.fire({
                         position: 'top-end',
                         icon: 'success',
                         title: data.message,
                         showConfirmButton: false,
                         timer: 1500
                     });
                     window.setTimeout(function () {
                         window.location = site + "dashboard/salidas";
                     }, 1500);
                 } else {
                     Swal.fire({
                         position: 'top-end',
                         icon: 'info',
                         title: data.message
                     });
                 }
             }
         });
     }
 }); 
}