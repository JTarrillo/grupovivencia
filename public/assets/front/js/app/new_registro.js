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
                url: site + "register/validate_captcha",
                data: {
                    token: token,
                },
                dataType: 'json',
                success: function (data) {
                    if (data.success === 1) {
                        new_registro()
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


function new_registro() {

    document.getElementById("submit").disabled = true;
    document.getElementById("submit").innerHTML = "<span class='spinner-border spinner-border-sm' role='status'></span> Procesando...";
    
    //get pass
    password = document.getElementById("password").value;
    confirm_password = document.getElementById("confirm_password").value;
    oData = new FormData(document.forms.namedItem("form-new_registro"));
    if (password == confirm_password) {
        $.ajax({
            url: site + "register/validacion",
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
                        title: '¡Registro exitoso!',
                        text: 'Tu cuenta ha sido creada correctamente.',
                        confirmButtonText: 'Ir a Login'
                    }).then(() => {
                        window.location.href = site + 'iniciar-sesion';
                    });
                } else {
                    Swal.fire({
                        position: 'center',
                        icon: 'info',
                        title: data.message
                    });
                }
                document.getElementById("submit").disabled = false;
                document.getElementById("submit").innerHTML = "REGISTRAR";
            }
        });
    } else {
        $(".alert-1").removeClass('text-success').addClass('d-flex justify-content-start align-items-center text-danger mb-2').html("Las contraseñas no son iguales");
        document.getElementById("submit").innerHTML = "REGISTRAR";
        document.getElementById("submit").disabled = false;
    }
}

function validate_username(username) {
    if (username == "") {
        $(".alert-0").removeClass('text-success').addClass('d-flex justify-content-start align-items-center text-danger mb-2').html("Usuario Invalido");
    } else {
        $.ajax({
            type: "post",
            url: site + "/registro/validate_username",
            dataType: "json",
            data: { username: username },
            success: function (data) {
                if (data.status == true) {
                    $(".alert-0").removeClass('text-success').addClass('d-flex justify-content-start align-items-center text-danger mb-2').html(data.message);
                } else {
                    $(".alert-0").removeClass('text-danger').addClass('text-success').html(data.message);
                }
            }
        });
    }
}

function validate_pass() {
    pass = document.getElementById("password").value;
    confirm_password = document.getElementById("confirm_password").value;
    if (pass != confirm_password) {
        $(".alert-1").removeClass('text-success').addClass('d-flex justify-content-start align-items-center text-danger mb-2').html("Las contraseñas no son iguales");
    } else {
        $(".alert-1").removeClass('text-danger').addClass('text-success').html("Contraseñas iguales");
    }
}

function Numtext(string) {//solo letras y numeros
    var out = '';
    //Se aÃ±aden las letras validas
    var filtro = 'abcdefghijklmnÃ±opqrstuvwxyzABCDEFGHIJKLMNÃ‘OPQRSTUVWXYZ1234567890';//Caracteres validos
    for (var i = 0; i < string.length; i++)
        if (filtro.indexOf(string.charAt(i)) != -1)
            out += string.charAt(i);
    return out;
}