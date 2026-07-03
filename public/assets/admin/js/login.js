function login() {
    document.getElementById("submit").disabled = true;
    document.getElementById("submit").innerHTML = "<span class='spinner-border spinner-border-sm' role='status'></span> Procesando...";

    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
   
    $.ajax({
        type: "post",
        url: site + "/dashboard/validate",
        dataType: "json",
        data: {email : email,
                password : password},
        success: function (data) {
            if (data.status == true) {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: data.message,
                    showConfirmButton: false,
                    timer: 1000
                });
                window.setTimeout(function () {
                    window.location = site + "/dashboard/inmueble";
                }, 1000);
            } else {
                document.getElementById("submit").disabled = false;
                document.getElementById("submit").innerHTML = "Iniciar Sesión";
                Swal.fire({
                    position: 'center',
                    icon: 'info',
                    title: data.message,
                });
            }
        }
    });
}
