const key = '6LequQIqAAAAAMB6PlUNXRmRAh-TP-uY89l02_4G';

function validate_captcha() {
    document.getElementById("submit").disabled = true;
    document.getElementById("submit").innerHTML = "<span class='spinner-border spinner-border-sm' role='status'></span> Procesando...";
    grecaptcha.ready(function () {
        grecaptcha.execute(key, {
            action: 'validate'
        }).then(function (token) {
            $.ajax({
                type: "POST",
                url: site + "iniciar-sesion/validate_captcha",
                data: {
                    token: token,
                },
                dataType: 'json',
                success: function (data) {
                    if (data.success === 1) {
                        login()
                    } else {
                        alert(data.message);
                        document.getElementById("submit").disabled = false;
                        document.getElementById("submit").innerHTML = 'Ingresar';
                    }
                }
            });
        });
    });
}

function login() {
    document.getElementById("submit").disabled = true;
    document.getElementById("submit").innerHTML = "<span class='spinner-border spinner-border-sm' role='status'></span> Procesando...";
    oData = new FormData(document.forms.namedItem("form-login"));

    $.ajax({
        url: site + "iniciar-sesion/login_user",
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
                    title: 'Bienvenido',
                    showConfirmButton: false,
                });
                window.setTimeout(function () {
                    window.location = site + "backoffice_new";
                }, 1000);
            } else {
                Swal.fire({
                    position: 'center',
                    icon: 'info',
                    title: 'Datos Invalidos',
                    timer: 1000,
                });
            }
            document.getElementById("submit").disabled = false;
            document.getElementById("submit").innerHTML = 'Ingresar';
        }
    });
}

function validar_email(email) {
    var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email) ? true : false;
}