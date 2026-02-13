function edit_comissions(commissions_id) {
    var url = 'dashboard/comisiones/load/' + commissions_id;
    location.href = site + url;
}
function cancel_comissions() {
    var url = 'dashboard/comisiones';
    location.href = site + url;
}
function validate_customer(customer_id) {
    $.ajax({
        type: "post",
        url: site + "dashboard/puntos_binario/validate_customer",
        dataType: "json",
        data: { customer_id: customer_id },
        success: function (data) {
            if (data.message == "true") {
                document.getElementById("username").value = data.username;
                document.getElementById("name").value = data.name;
                $("#alert_message").html(data.print);
            } else {
                $("#alert_message").html(data.print);
            }
        }
    });
}

function validate() {
    document.getElementById("submit").disabled = true;
    document.getElementById("submit").innerHTML = "<span class='spinner-border spinner-border-sm' role='status'></span> Procesando...";
    oData = new FormData(document.forms.namedItem("form-comission"));
    $.ajax({
        url: site + "dashboard/comisiones/validate",
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
                    title: data.message,
                    showConfirmButton: false,
                });
                window.setTimeout(function () {
                    window.location = site + "dashboard/comisiones";
                }, 1500);
            } else {
                Swal.fire({
                    position: 'top-end',
                    icon: 'info',
                    title: data.message
                });
                document.getElementById("submit").disabled = false;
                document.getElementById("submit").innerHTML = "Guardar";
            }
        }
    });
}

function delete_comissions(id) {
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
                type: "post",
                url: site + "dashboard/comisiones/eliminar",
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
                            window.location = site + "dashboard/comisiones";
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

function exportToExcel(comissions) {
    const data = comissions.map((comission) => {
        return {
            id: comission.id,
            date: comission.date,
            username: comission.username,
            customer: `${comission.name} ${comission.lastname}`,
            username_arrive: comission.username_arrive != undefined ? comission.username_arrive : "",
            customer_arrive: comission.name_arrive != undefined || comission.lastname_arrive != undefined ? `${comission.name_arrive} ${comission.lastname_arrive}` : "",
            bonus: comission.bonus,
            amount: comission.amount,
            state: comission.active == '1' || comission.active == '2' ? "Abonado" : "No Abonado",
        }
    })
    const workbook = XLSX.utils.book_new();
    const worksheet = XLSX.utils.json_to_sheet(data);
    XLSX.utils.book_append_sheet(workbook, worksheet, "comisiones");
    XLSX.utils.sheet_add_aoa(worksheet, [["ID", "FECHA", "USUARIO", "CLIENTE", "DE USUARIO", "DE CLIENTE", "BONO", "IMPORTE", "ESTADO"]], { origin: "A1" });
    XLSX.writeFile(workbook, "comisiones.xlsx", { compression: true });
}

