function validate_kyc(){
    document.getElementById("submit_kyc").disabled = true;
    document.getElementById("submit_kyc").innerHTML = "<span class='spinner-border spinner-border-sm' role='status'></span> Guardando...";
    oData = new FormData(document.forms.namedItem("form-kyc"));
    Swal.fire({
        title: 'Confirma que desea enviar su KYC?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Confirmo'
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: site + "backoffice_new/kyc_validate",
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
                        window.setTimeout(function () {
                            window.location = site + "backoffice_new/kyc";
                        }, 1000);
                    } else {
                        document.getElementById("submit_kyc").disabled = false;
                        document.getElementById("submit_kyc").innerHTML = "Guardar";
                        Swal.fire({
                            position: 'center',
                            icon: 'info',
                            title: data.message
                        });
                    }
                }
            });
        }else{
            document.getElementById("submit_kyc").disabled = false;
            document.getElementById("submit_kyc").innerHTML = "Guardar";
        }
    });
}

