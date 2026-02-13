function update_range(){
    Swal.fire({
        title: 'Confirma que desea actualizar los rangos?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Confirmo'
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                url: site + "crone/crone_range_ajax",
                dataType: "json",
                data: {id: 1},
                success: function (data) {
                    if (data.status == true) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: "Rangos actualizados",
                            showConfirmButton: false,
                            timer: 1000
                        });
                        window.setTimeout(function () {
                            window.location = site + "dashboard/panel";
                        }, 1000);
                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'info',
                            title: data.message
                        });
                    }
                }
            });
        }
    });
}

function pago_fondo_global() {
    Swal.fire({
        title: 'Confirma que desea procesar el fondo global?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Confirmo'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Fondo Global Procesado',
                showConfirmButton: false,
                timer: 1500
            });
            window.setTimeout(function () {
                location.reload()
            }, 1000);
        }
    });
}