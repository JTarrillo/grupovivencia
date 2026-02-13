function pay_adm() {
    document.getElementById("submit_pay").disabled = true;
    document.getElementById("submit_pay").innerHTML = "<span class='spinner-border spinner-border-sm' role='status'></span> Procesando...";
    oData = new FormData(document.forms.namedItem("form"));
    Swal.fire({
        title: 'Confirma que desea realizar la compra?',
        icon: 'warning',
        customClass: 'sweetalert-bg',
        showCancelButton: true,
        confirmButtonColor: '#3085d6', 
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Confirmo'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: site + "/dashboard/nueva_venta/procesar_venta",
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
                            customClass: 'sweetalert-bg',
                            title: data.message,
                            showConfirmButton: false,
                        });
                        window.setTimeout(function () {
                            window.location = site + "dashboard/nueva_venta";
                        }, 1000);
                    } else {
                        Swal.fire({
                            position: 'center',
                            icon: 'info',
                            customClass: 'sweetalert-bg',
                            title: data.message
                        });
                        document.getElementById("submit_pay").disabled = false;
                        document.getElementById("submit_pay").innerHTML = "<i class='fa fa-usd' aria-hidden='true'></i> Pagar con Monedero";
                    }
                }
            });
        } else {
            document.getElementById("submit_pay").disabled = false;
            document.getElementById("submit_pay").innerHTML = "<i class='fa fa-usd' aria-hidden='true'></i> Pagar con Monedero";
        }
    });
}

function edit(row_id, qty) {
    edit_button = "edit_" + row_id;
    document.getElementById(edit_button).innerHTML = "<span class='spinner-border spinner-border-sm' role='status'></span>";
    qty = document.getElementById(qty).value;
    $.ajax({
        type: "post",
        url: site + "backoffice_new/planes/carrito_edit",
        dataType: "json",
        data: {
            row_id: row_id,
            qty: qty
        },
        success: function (data) {
            if (data.status == true) {
                window.setTimeout(function () {
                    location.reload();
                }, 0);
            } else {
                window.setTimeout(function () {
                    location.reload();
                }, 1000);
            }
        }
    });
}

function deleted(row_id) {
    sessionStorage.removeItem("selection");
    Swal.fire({
        title: 'Confirma que desea eliminar el producto?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Confirmo'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                url: site + "backoffice_new/planes/carrito_delete",
                dataType: "json",
                data: { row_id: row_id },
                success: function (data) {
                    if (data.status == true) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: "Eliminado",
                            showConfirmButton: false,
                        });
                        window.setTimeout(function () {
                            location.reload();
                        }, 1000);
                    } else {
                        window.setTimeout(function () {
                            location.reload();
                        }, 1000);
                    }
                }
            });
        } else {
            document.getElementById("btn_submit").disabled = false;
            document.getElementById("btn_submit").innerHTML = "Enviar";
        }
    });
}