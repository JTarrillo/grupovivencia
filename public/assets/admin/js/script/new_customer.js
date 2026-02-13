function validate() {
    document.getElementById("submit").disabled = true;
    document.getElementById("submit").innerHTML = "<span class='spinner-border spinner-border-sm' role='status'></span> Procesando...";
    //get pass
    password = document.getElementById("password").value;
    confirm_password = document.getElementById("confirm_password").value;
    oData = new FormData(document.forms.namedItem("form"));
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
                        position: 'top-end',
                        icon: 'success',
                        title: 'Cliente creado',
                        showConfirmButton: false,
                    });
                    window.setTimeout(function () {
                        location.reload();
                    }, 1000);
                } else {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'info',
                        title: data.message
                    });
                }
                document.getElementById("submit").disabled = false;
                document.getElementById("submit").innerHTML = "Nuevo Registro";
            }
        });
    } else {
        $(".alert-1").removeClass('text-success').addClass('text-danger').html("Las contraseñas no son iguales <i class='fa fa-times-circle-o' aria-hidden='true'></i>");
        document.getElementById("submit").innerHTML = "Nuevo Registro";
        document.getElementById("submit").disabled = false;
    }
}

function validate_username(username) {
    if (username == "") {
        $(".alert-0").removeClass('text-success').addClass('text-danger').html("Usuario Invalido <i class='fa fa-times-circle-o' aria-hidden='true'></i>");
    } else {
        $.ajax({
            type: "post",
            url: site + "/registro/validate_username",
            dataType: "json",
            data: { username: username },
            success: function (data) {
                if (data.status == true) {
                    $(".alert-0").removeClass('text-success').addClass('text-danger').html(data.message);
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
        $(".alert-1").removeClass('text-success').addClass('text-danger').html("Las contraseñas no son iguales");
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