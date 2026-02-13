function descontar(id, amount) {
  document.getElementById("submit").disabled = true;
  document.getElementById("submit").innerHTML =
    "<span class='spinner-border spinner-border-sm' role='status'></span> Procesando...";

  Swal.fire({
    title: "Confirma que desea descontar el disponible?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Si, Confirmo",
  }).then((result) => {
    if (result.isConfirmed) {
        if (amount > 0) {
            // Do something if amount is greater than 0
            $.ajax({
            url: site + "dashboard/reportes_ganancias/descontar",
            type: "post",
            dataType: "json",
            data: { id: id, amount: amount },
            success: function (data) {
                if (data.status == true) {
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: data.message,
                    showConfirmButton: false,
                    timer: 1500,
                });
                window.setTimeout(function () {
                    window.location = site + "dashboard/reportes_ganancias";
                }, 1000);
                } else {
                Swal.fire({
                    position: "center",
                    icon: "info",
                    title: data.message,
                });
                }
            },
            });
        } else {
            Swal.fire({
            position: "center",
            icon: "info",
            title: "Importe invalido",
            });

            document.getElementById("submit").disabled = false;
            document.getElementById("submit").innerHTML = '<i class="fa fa-minus-circle"></i>';
        }
    }else{
        document.getElementById("submit").disabled = false;
        document.getElementById("submit").innerHTML = '<i class="fa fa-minus-circle"></i>';
    }
  });
}
