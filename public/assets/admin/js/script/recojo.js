function view(id) {
    var url = 'dashboard/activaciones/load/' + id;
    location.href = site + url;
}

function back() {
    var url = 'dashboard/activaciones';
    location.href = site + url;
}

function back2() {
    var url = 'dashboard/activaciones_verificadas';
    location.href = site + url;
}

function exportToExcel(invoices) {
    const data = invoices.map((invoice) => {
        return {
            id: invoice.id,
            customer: `${invoice.name} ${invoice.lastname}`,
            user: invoice.username,
            payment: invoice.payment == '1' ? "Monedero" : invoice.payment == '2' ? "Tarjeta" : 'En Tienda',
            store: invoice.store_name,
            amount: invoice.amount,
            date: invoice.date,
            state: invoice.active == '1' ? "Por Pagar" : invoice.active == '2' ? "Pagado" : 'Cancelado',
            delivery: invoice.delivery == '1' ? "Pendiente" : "Entregado",
        }
    })
    const workbook = XLSX.utils.book_new();
    const worksheet = XLSX.utils.json_to_sheet(data);
    XLSX.utils.book_append_sheet(workbook, worksheet, "Recojos");
    XLSX.utils.sheet_add_aoa(worksheet, [["ID", "CLIENTE", "USUARIO", "TIPO DE PAGO", "RECOJO", "IMPORTE", "FECHA DE COMPRA", "ESTADO", "DELIVERY"]], { origin: "A1" });
    XLSX.writeFile(workbook, "recojos.xlsx", { compression: true });
}

function active(id) {
    Swal.fire({
        title: 'Confirma que se entregarons los productos?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Confirmo'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: site + "dashboard/activaciones/active_delivery",
                method: "POST",
                data: { id: id },
                success: function (data) {
                    var data = JSON.parse(data);
                    if (data.status == true) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Entregado',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        window.setTimeout(function () {
                            window.location = site + "dashboard/activaciones";
                        }, 1500);
                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'info',
                            title: 'Sucedio un error',
                            footer: 'Comunique a soporte'
                        });
                    }
                }
            });
        }
    });
}
