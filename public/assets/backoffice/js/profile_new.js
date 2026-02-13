function change_pass() {

    document.getElementById("button_pass").disabled = true;
    document.getElementById("button_pass").innerHTML = "<span class='spinner-border spinner-border-sm' role='status'></span> Procesando...";

    var pass = document.getElementById("pass").value;
    var new_pass = document.getElementById("new_pass").value;
    var new_pass_confirm = document.getElementById("new_pass_confirm").value;
    if (new_pass == new_pass_confirm) {
        $.ajax({
            type: "post",
            url: site + "backoffice/profile/update_password",
            dataType: "json",
            data: {
                pass: pass,
                new_pass: new_pass,
                new_pass_confirm: new_pass_confirm
            },
            success: function (data) {
                if (data.status == true) {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Cambio Guardado',
                        showConfirmButton: false,
                    });
                    window.setTimeout(function () {
                        window.location = site + "backoffice/perfil";
                    }, 1000);
                } else if (data.status == "false2") {
                    document.getElementById("button_pass").disabled = false;
                    document.getElementById("button_pass").innerHTML = "<i class='fa fa-floppy-o' aria-hidden='true'></i> Guardar Contraseña";
                    Swal.fire({
                        position: 'center',
                        icon: 'info',
                        title: 'Contraseña Actual no es correcta',
                        showConfirmButton: false,
                    });
                } else {
                    document.getElementById("button_pass").disabled = false;
                    document.getElementById("button_pass").innerHTML = "<i class='fa fa-floppy-o' aria-hidden='true'></i> Guardar Contraseña";
                    Swal.fire({
                        position: 'center',
                        icon: 'info',
                        title: 'No se pudo guardar',
                        showConfirmButton: false,
                    });
                }
            }
        });
    } else {
        document.getElementById("button_pass").disabled = false;
        document.getElementById("button_pass").innerHTML = "<i class='fa fa-floppy-o' aria-hidden='true'></i> Guardar Contraseña";
        Swal.fire({
            position: 'center',
            icon: 'info',
            title: 'Las Contraseña no son Iguales',
            showConfirmButton: false,
        });
    }
}

function save_bank() {

    document.getElementById("button_bank").disabled = true;
    document.getElementById("button_bank").innerHTML = "<span class='spinner-border spinner-border-sm' role='status'></span> Procesando...";
    oData = new FormData(document.forms.namedItem("form-bank"));
    Swal.fire({
        title: 'Confirma que desea actualizar su datos bancarios?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Confirmo'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: site + "backoffice_new/save_bank",
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
                            window.location = site + "backoffice_new/configuracion";
                        }, 1000);
                    } else {
                        document.getElementById("button_bank").disabled = false;
                        document.getElementById("button_bank").innerHTML = "Guardar ";
                        Swal.fire({
                            position: 'center',
                            icon: 'info',
                            title: data.message,
                            showConfirmButton: false,
                        });
                    }
                }
            });
        } else {
            document.getElementById("button_wallet").disabled = false;
            document.getElementById("button_wallet").innerHTML = "Guardar";
        }
    });
}

function save_profile() {
    document.getElementById("profile").disabled = true;
    document.getElementById("profile").innerHTML = "<span class='spinner-border spinner-border-sm' role='status'></span> Procesando...";
    oData = new FormData(document.forms.namedItem("form-perfil"));

    Swal.fire({
        title: 'Confirma que desea actualizar su perfil?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Confirmo'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: site + "backoffice_new/save_profile",
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
                            title: 'Cambios Guardado',
                            showConfirmButton: false,
                        });
                        window.setTimeout(function () {
                            window.location = site + "backoffice_new/configuracion";
                        }, 1000);
                    } else {
                        document.getElementById("profile").disabled = false;
                        document.getElementById("profile").innerHTML = "Guardar Cambios";
                        Swal.fire({
                            position: 'center',
                            icon: 'info',
                            title: 'No se pudo guardar',
                            showConfirmButton: true,
                        });
                    }
                }
            });
        } else {
            document.getElementById("profile").disabled = false;
            document.getElementById("profile").innerHTML = "Guardar Cambios";
        }
    });
}

function save_pass() {
    document.getElementById("kt_password_submit").disabled = true;
    document.getElementById("kt_password_submit").innerHTML = "<span class='spinner-border spinner-border-sm' role='status'></span> Procesando...";
    oData = new FormData(document.forms.namedItem("form-pass"));

    Swal.fire({
        title: 'Confirma que desea actualizar su contraseña?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Confirmo'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: site + "backoffice_new/save_pass",
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
                            window.location = site + "backoffice_new/configuracion";
                        }, 1000);
                    } else {
                        document.getElementById("kt_password_submit").disabled = false;
                        document.getElementById("kt_password_submit").innerHTML = "Actualizar Password";
                        Swal.fire({
                            position: 'center',
                            icon: 'info',
                            title: data.message,
                            showConfirmButton: true,
                        });
                    }
                }
            });
        } else {
            document.getElementById("kt_password_submit").disabled = false;
            document.getElementById("kt_password_submit").innerHTML = "Actualizar Password";
        }
    });
}

function save_pin() {
    document.getElementById("kt_sing_in_two_steps_submit").disabled = true;
    document.getElementById("kt_sing_in_two_steps_submit").innerHTML = "<span class='spinner-border spinner-border-sm' role='status'></span> Procesando...";
    oData = new FormData(document.forms.namedItem("form-pin"));

    Swal.fire({
        title: 'Confirma que desea crear el PIN de seguridad?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Confirmo'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: site + "backoffice_new/save_pin",
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
                            title: 'Cambios Guardado',
                            showConfirmButton: false,
                        });
                        window.setTimeout(function () {
                            window.location = site + "backoffice_new/pin";
                        }, 1000);
                    } else {
                        document.getElementById("kt_sing_in_two_steps_submit").disabled = false;
                        document.getElementById("kt_sing_in_two_steps_submit").innerHTML = "Guardar";
                        Swal.fire({
                            position: 'center',
                            icon: 'info',
                            title: 'Ups! Vuelva a intentarlo',
                            showConfirmButton: true,
                        });
                    }
                }
            });
        } else {
            document.getElementById("kt_sing_in_two_steps_submit").disabled = false;
            document.getElementById("kt_sing_in_two_steps_submit").innerHTML = "Guardar";
        }
    });
}

function recover_pin() {
    Swal.fire({
        title: 'Confirma que desea recuperar el PIN de seguridad?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Confirmo'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: site + "backoffice_new/recover_pin",
                method: "POST",
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    var data = JSON.parse(data);
                    if (data.status == true) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Email enviado',
                            footer: 'Revise su bandeja de entrada',
                            showConfirmButton: false,
                        });
                        window.setTimeout(function () {
                            window.location = site + "backoffice_new/pin";
                        }, 1500);
                    } else {
                        Swal.fire({
                            position: 'center',
                            icon: 'info',
                            title: 'Ups! Vuelva a intentarlo',
                            showConfirmButton: true,
                        });
                    }
                }
            });
        } else {
            document.getElementById("kt_sing_in_two_steps_submit").disabled = false;
            document.getElementById("kt_sing_in_two_steps_submit").innerHTML = "Guardar";
        }
    });
}

function show_email() {
    //show 
    document.getElementById("kt_signin_email_edit2").style.display = "block";
    //hide
    document.getElementById("kt_signin_email_button").style.display = "none";
    document.getElementById("kt_signin_email").style.display = "none";
}

function hide_email() {
    //hide
    document.getElementById("kt_signin_email_edit2").style.display = "none";
    //show 
    document.getElementById("kt_signin_email_button").style.display = "block";
    document.getElementById("kt_signin_email").style.display = "block";
}

function show_pass() {
    //show 
    document.getElementById("kt_signin_password_edit").style.display = "block";
    //hide
    document.getElementById("kt_signin_password_button").style.display = "none";
    document.getElementById("kt_signin_password").style.display = "none";
}

function hide_pass() {
    //hide
    document.getElementById("kt_signin_password_edit").style.display = "none";
    //show 
    document.getElementById("kt_signin_password_button").style.display = "block";
    document.getElementById("kt_signin_password").style.display = "block";
}

function reset_perfil() {
    window.location = site + "backoffice/perfil";
}

function save_billing() {
    document.getElementById("button_billing").disabled = true;
    document.getElementById("button_billing").innerHTML = "<span class='spinner-border spinner-border-sm' role='status'></span> Procesando...";
    oData = new FormData(document.forms.namedItem("form-billing"));
    Swal.fire({
        title: 'Confirma que desea actualizar su datos de facturación?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Confirmo'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: site + "backoffice_new/save_billing",
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
                            window.location = site + "backoffice_new/configuracion";
                        }, 1000);
                    } else {
                        document.getElementById("button_billing").disabled = false;
                        document.getElementById("button_billing").innerHTML = "Guardar ";
                        Swal.fire({
                            position: 'center',
                            icon: 'info',
                            title: data.message,
                            showConfirmButton: false,
                        });
                    }
                }
            });
        } else {
            document.getElementById("button_billing").disabled = false;
            document.getElementById("button_billing").innerHTML = "Guardar";
        }
    });
}