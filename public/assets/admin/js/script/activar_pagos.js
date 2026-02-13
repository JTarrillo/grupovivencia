function pagado(id, amount, discount, total, email, name, hash_id) {
    Swal.fire({
        title: 'Confirma que desea pagar el registro?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Confirmo'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                url: site + "dashboard/activar_pagos/pagado",
                dataType: "json",
                data: {
                    id: id,
                    amount: amount,
                    discount: discount,
                    total: total,
                    email: email,
                    name: name,
                    hash_id: hash_id
                },
                success: function (data) {
                    if (data.status == true) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        window.setTimeout(function () {
                            window.location = site + "dashboard/activar_pagos";
                        }, 1500);
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

function devolver(id) {

    Swal.fire({
        title: 'Confirma que desea devuelver las comisiones?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Confirmo'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                url: site + "dashboard/activar_pagos/devolver",
                dataType: "json",
                data: { id: id },
                success: function (data) {
                    if (data.status == true) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        window.setTimeout(function () {
                            window.location = site + "dashboard/activar_pagos";
                        }, 1500);
                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'info',
                            title: data.message,
                        });
                    }
                }
            });
        }
    });
}


function validate() {
    document.getElementById("submit").disabled = true;
    document.getElementById("submit").innerHTML = "<span class='spinner-border spinner-border-sm' role='status'></span> Procesando...";
    oData = new FormData(document.forms.namedItem("form-pay"));
    $.ajax({
        url: site + "dashboard/activar_pagos/validate",
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
                    title: 'Cambios Guardado',
                    showConfirmButton: false,
                });
                window.setTimeout(function () {
                    window.location = site + "dashboard/activar_pagos";
                }, 1500);
            } else {
                Swal.fire({
                    position: 'top-end',
                    icon: 'info',
                    title: 'Sucedio un error',
                    footer: 'Vuelva a Intentarlo'
                });
                document.getElementById("submit").disabled = false;
                document.getElementById("submit").innerHTML = "Guardar";
            }
        }
    });

}
function edit_pay(id) {
    var url = 'dashboard/activar_pagos/load/' + id;
    location.href = site + url;
}
function cancelar_pay() {
    var url = 'dashboard/activar_pagos';
    location.href = site + url;
}


function eliminar(id) {
    Swal.fire({
        title: 'Confirma que desea eliminar el registro?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Confirmo'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: site + "dashboard/activar_pagos/eliminar",
                type: "post",
                dataType: "json",
                data: { id: id },
                success: function (data) {
                    if (data.status == true) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        /*window.setTimeout(function () {
                            window.location = site + "dashboard/activar_pagos";
                        }, 1500);*/
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

function exportToExcel(pays) {
    const data = pays.map((pay) => {
        return {
            id: pay.id,
            date: pay.date,
            customer: `${pay.name} ${pay.lastname}`,
            user: pay.username,
            bank: pay.bank,
            number: pay.number,
            cci: pay.cci,
            amount: pay.amount,
            state: pay.active == '1' ? "Es espera" : pay.active == '2' ? 'Pagado' : "Cancelado",
        }
    })
    const workbook = XLSX.utils.book_new();
    const worksheet = XLSX.utils.json_to_sheet(data);
    XLSX.utils.book_append_sheet(workbook, worksheet, "pagos");
    XLSX.utils.sheet_add_aoa(worksheet, [["ID", "FECHA", "CLIENTE", "USUARIO", "BANCO", "N° CUENTA", "CCI", "IMPORTE", "ESTADO"]], { origin: "A1" });
    XLSX.writeFile(workbook, "pagos.xlsx", { compression: true });
}
