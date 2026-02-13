function validate() {
    document.getElementById("submit").disabled = true;
    document.getElementById("submit").innerHTML = "<span class='spinner-border spinner-border-sm' role='status'></span> Procesando...";
    oData = new FormData(document.forms.namedItem("form-ticket"));
    $.ajax({
        url: site + "dashboard/ticket/validate",
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
                    window.location = site + "dashboard/ticket";
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

function edit_ticket(id) {
    var url = 'dashboard/ticket/load/' + id;
    location.href = site + url;
}
function cancelar_ticket() {
    var url = 'dashboard/ticket';
    location.href = site + url;
}

function delete_ticket(id) {
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
                url: site + "dashboard/ticket/delete",
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
                            window.location = site + "dashboard/ticket";
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

function exportToExcel(tickets) {
    const data = tickets.map((ticket) => {
        return {
            id: ticket.id,
            date: ticket.date,
            customer: `${ticket.name} ${ticket.lastname}`,
            user: ticket.username,
            title: ticket.title,
            state: ticket.active == '1' ? "Es espera" : ticket.active == '2' ? 'En Proceso' : "Terminado",
        }
    })
    const workbook = XLSX.utils.book_new();
    const worksheet = XLSX.utils.json_to_sheet(data);
    XLSX.utils.book_append_sheet(workbook, worksheet, "tickets");
    XLSX.utils.sheet_add_aoa(worksheet, [["ID", "FECHA", "CLIENTE", "USUARIO", "ASUNTO", "ESTADO"]], { origin: "A1" });
    XLSX.writeFile(workbook, "tickets.xlsx", { compression: true });
}
