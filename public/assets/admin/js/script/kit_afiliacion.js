function new_kit(){
	var url= 'dashboard/kit_afiliacion/load';
	location.href = site+url;
}

function validate_kit() {
    document.getElementById("submit").disabled = true;
    document.getElementById("submit").innerHTML = "<span class='spinner-border spinner-border-sm' role='status'></span> Procesando...";
    description =  tinyMCE.activeEditor.getContent();
    oData = new FormData(document.forms.namedItem("form-kit"));
    oData.append("description", description);
    $.ajax({
        url: site + "dashboard/kit_afiliacion/validate",
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
                    timer: 1500
                });
                window.setTimeout(function () {
                    window.location = site + "dashboard/kit_afiliacion";
                }, 1500);
            } else {
                document.getElementById("submit").disabled = false;
                document.getElementById("submit").innerHTML = "<i class='fa fa-cloud'></i> Guardar";
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: data.message
                });
            }
        }
    });
}
function edit_kit(kit_id){    
     var url = 'dashboard/kit_afiliacion/load/'+kit_id;
     location.href = site+url;   
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
                url: site + "dashboard/kit_afiliacion/eliminar",
                type: "post",
                dataType: "json",
                data: {id : id},
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
                            window.location = site + "dashboard/kit_afiliacion";
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


function cancel_kit(){
	var url= 'dashboard/kit_afiliacion';
	location.href = site+url;
}