const key = '6LequQIqAAAAAMB6PlUNXRmRAh-TP-uY89l02_4G';

function validate_captcha(view) {
    document.getElementById("submit").disabled = true;
    document.getElementById("submit").innerHTML = "<span class='spinner-border spinner-border-sm' role='status'></span> Enviando...";
    grecaptcha.ready(function () {
        grecaptcha.execute(key, {
            action: 'validate'
        }).then(function (token) {
            $.ajax({
                type: "POST",
                url: site + "recuperar-contrasena/validate_captcha",
                data: {
                    token: token,
                },
                dataType: 'json',
                success: function (data) {
                    if (data.success === 1) {
                        if (view == 1) {
                            recover()
                        } else if (view == 2) {
                            recuperar()
                        }
                    } else {
                        alert(data.message);
                        document.getElementById("submit").disabled = false;
                        document.getElementById("submit").innerHTML = '<i class="fa fa-share-square-o" aria-hidden="true"></i> Ingresar a la oficina';
                    }
                }
            });
        });
    });
}

function recuperar() {
    var username = document.getElementById("username").value;
    document.getElementById("submit").disabled = true;
    document.getElementById("submit").innerHTML = "<span class='spinner-border spinner-border-sm' role='status'></span> Enviando...";
    $.ajax({
        type: "post",
        url: site + "recuperar-contrasena/validate",
        dataType: "json",
        data: { username: username },
        success: function (data) {
            if (data.status == true) {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Mensaje Enviado',
                    footer: 'Revise su bandeja de correo',
                    showConfirmButton: false,
                    timer: 5000,
                });
            } else {
                Swal.fire({
                    position: 'center',
                    icon: 'info',
                    title: 'Usuario no registrado',
                    showConfirmButton: true,
                });
            }
            document.getElementById("submit").disabled = false;
            document.getElementById("submit").innerHTML = "Recuperar Contraseña";
        }
    });
}

function recover() {
    var customer_id = document.getElementById("customer_id").value;
    var pass = document.getElementById("password").value;
    var confirm_pass = document.getElementById("new_password").value;
    if (pass == confirm_pass) {
        $.ajax({
            type: "post",
            url: site + "password/validate_recover",
            dataType: "json",
            data: {
                customer_id: customer_id,
                pass: pass,
                confirm_pass: confirm_pass
            },
            success: function (data) {
                if (data.status == true) {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Contraseña Cambiada',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    window.setTimeout(function () {
                        window.location = site + "iniciar-sesion";
                    }, 1000);
                } else {
                    Swal.fire({
                        position: 'center',
                        icon: 'info',
                        title: 'Ups, paso un error',
                        showConfirmButton: true,
                    });
                }
                document.getElementById("submit").disabled = false;
                document.getElementById("submit").innerHTML = "Actualizar Contraseña";
            }
        });
    } else {
        Swal.fire({
            position: 'top-end',
            icon: 'info',
            title: 'Las contraseñan no son iguales',
            timer: 1500
        });
        document.getElementById("submit").disabled = false;
        document.getElementById("submit").innerHTML = "Actualizar Contraseña";
    }
}

function validar_email(email) {
    var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email) ? true : false;
}