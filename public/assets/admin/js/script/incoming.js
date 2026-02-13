function new_incoming() {
  var url = 'dashboard/entradas/load';
  location.href = site + url;
}

function edit_incoming(incoming_id){    
  var url = 'dashboard/entradas/load/'+incoming_id;
  location.href = site+url;   
}
function cancel_incoming(){
var url= 'dashboard/entradas';
location.href = site+url;
}

function validate(){
 document.getElementById("submit").disabled = true;
 document.getElementById("submit").innerHTML = "<span class='spinner-border spinner-border-sm' role='status'></span> Procesando...";
 oData = new FormData(document.forms.namedItem("form"));
     $.ajax({
         url: site + "dashboard/entradas/validate",
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
                     window.location = site + "dashboard/entradas";
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

function eliminar(incoming_id){
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
             url: site + "dashboard/entradas/delete",
             type: "post",
             dataType: "json",
             data: {incoming_id : incoming_id},
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
                         window.location = site + "dashboard/entradas";
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

function uploadData(jsonString) {
    //console.log(jsonString)
    document.getElementById("btn_upload").disabled = true;
    document.getElementById("btn_upload").innerHTML = "<span class='spinner-border spinner-border-sm' role='status'></span> Subiendo...";
    Swal.fire({
        title: 'Confirma que desea cargar los archivos?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Confirmo'
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: site + "dashboard/entradas/save_csv",
                type: "post",
                dataType: "json",
                data: {jsonString : jsonString},
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
                            window.location = site + "dashboard/entradas";
                        }, 1000);
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