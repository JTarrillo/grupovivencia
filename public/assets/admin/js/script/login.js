function login() {
  document.getElementById('submit').disabled = true;
  document.getElementById('submit').innerHTML =
    "<span class='spinner-border spinner-border-sm' role='status'></span> Procesando...";

  var email = document.getElementById('email').value;
  var password = document.getElementById('password').value;

  $.ajax({
    type: 'post',
    url: site + '/dashboard/validate',
    dataType: 'json',
    data: { email: email, password: password },
    success: function (data) {
      //var data = JSON.parse(data);
      console.log(data);

      if (data.status == true) {
        Swal.fire({
          position: 'top-end',
          icon: 'success',
          title: 'Bienvenido al Sistema',
          showConfirmButton: false,
          timer: 1000,
        });
        window.setTimeout(function () {
          window.location = site + '/dashboard';
        }, 1000);
      } else if (data.status == 'false2') {
        document.getElementById('submit').disabled = false;
        document.getElementById('submit').innerHTML = 'Iniciar Sesión';
        Swal.fire({
          position: 'top-end',
          icon: 'info',
          title: 'Contraseña no valida',
        });
      } else if (data.status == false) {
        document.getElementById('submit').disabled = false;
        document.getElementById('submit').innerHTML = 'Iniciar SesiÃ³n';
        Swal.fire({
          position: 'top-end',
          icon: 'info',
          title: 'Email no valido',
        });
      }
    },
  });
}
