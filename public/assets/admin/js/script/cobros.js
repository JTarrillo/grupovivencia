function edit_pay(pay_id){
    var url= 'dashboard/pagos/load/'+pay_id;
location.href = site+url;
}
    
function pagado(pay_id){
bootbox.confirm({
message: "Confirma que desea marcar como pagado?",
buttons: {
    confirm: {
        label: 'Confirmar',
        className: 'btn-success'
    },
    cancel: {
        label: 'Cerrar',
        className: 'btn-danger'
    }
},
callback: function () {
     $.ajax({
               type: "post",
               url: site+"dashboard/pagos/pagado",
               dataType: "json",
               data: {pay_id : pay_id},
               success:function(data){                             
               location.reload();
               }         
       });
}
});
}

function devolver(pay_id){
 bootbox.confirm({
message: "Confirma que desea marcar como devuelto?",
buttons: {
    confirm: {
        label: 'Confirmar',
        className: 'btn-success'
    },
    cancel: {
        label: 'Cerrar',
        className: 'btn-danger'
    }
},
callback: function () {
     $.ajax({
               type: "post",
               url: site+"dashboard/pagos/devolver",
               dataType: "json",
               data: {pay_id : pay_id},
               success:function(data){                             
               location.reload();
               }         
       });
}
});
}
function cancel_pay(){
    var url= 'dashboard/pagos';
location.href = site+url;
}

function validate(){
    document.getElementById("submit").disabled = true;
    document.getElementById("submit").innerHTML = "<span class='spinner-border spinner-border-sm' role='status'></span> Procesando...";
    oData = new FormData(document.forms.namedItem("form-pay"));
        $.ajax({
            url: site + "dashboard/pagos/validate",
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
                        window.location = site + "dashboard/pagos";
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
