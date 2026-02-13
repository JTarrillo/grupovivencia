function verificado(customer_id, kyc_id, email, name) {

    Swal.fire({
        title: 'Desea marcarlo como Verificado?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Confirmo'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                url: site + "dashboard/kyc/cambiar_verificado",
                dataType: "json",
                data: {
                    customer_id: customer_id,
                    kyc_id: kyc_id,
                    email: email,
                    name: name
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
                            window.location = site + "dashboard/kyc_pendientes";
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

function rechazado(customer_id, kyc_id, email, name) {

    Swal.fire({
        title: 'Desea marcarlo como Rechazado?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Confirmo'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                url: site + "dashboard/kyc/cambiar_rechazado",
                dataType: "json",
                data: {
                    customer_id: customer_id,
                    kyc_id: kyc_id,
                    email: email,
                    name: name
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
                            window.location = site + "dashboard/kyc_pendientes";
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

function exportToExcel(customers) {
    const data = customers.map((customer) => {
        return {
            id: customer.id,
            date: customer.date,
            username: customer.username,
            name: `${customer.name} ${customer.lastname}`,
            dni: customer.dni,
            phone: customer.phone,
            state: customer.kyc == '1' ? "Pendiente" : customer.kyc == '2' ? "Verificado" : "Cancelado",
        }
    })
    const workbook = XLSX.utils.book_new();
    const worksheet = XLSX.utils.json_to_sheet(data);
    XLSX.utils.book_append_sheet(workbook, worksheet, "kyc");
    XLSX.utils.sheet_add_aoa(worksheet, [["ID", "FECHA", "USUARIO", "NOMBRES", "DNI", "TELÉFONO", "ESTADO"]], { origin: "A1" });
    XLSX.writeFile(workbook, "kyc.xlsx", { compression: true });
}
