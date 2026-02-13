function validate_kit() {
    document.getElementById("submit").disabled = true;
    document.getElementById("submit").innerHTML = "<span class='spinner-border spinner-border-sm' role='status'></span> Procesando...";
    description = tinyMCE.activeEditor.getContent();
    oData = new FormData(document.forms.namedItem("form-kit"));
    oData.append("description", description);
    $.ajax({
        url: site + "dashboard/planes/validate",
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
                    timer: 1500
                });
                window.setTimeout(function () {
                    window.location = site + "dashboard/planes";
                }, 1500);
            } else {
                document.getElementById("submit").disabled = false;
                document.getElementById("submit").innerHTML = "<i class='fa fa-cloud'></i> Guardar";
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: data.message
                });
            }
        }
    });
}
function new_membership() {
    var url = 'dashboard/planes/load/';
    location.href = site + url;
}
function edit_kit(kit_id) {
    var url = 'dashboard/planes/load/' + kit_id;
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
                url: site + "dashboard/planes/eliminar",
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
                        window.setTimeout(function () {
                            window.location = site + "dashboard/planes";
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

function cancel_kit() {
    var url = 'dashboard/planes';
    location.href = site + url;
}

function exportToExcel(memberships) {
    const data = memberships.map((membership) => {
        return {
            id: membership.id_2,
            name: membership.name,
            price: membership.price,
            point: membership.point,
            balance: membership.balance,
            unit_cost: membership.unit_cost,
            sale: membership.sale == '1' ? "Libre" : "Stock",
            active: membership.active == '0' ? "Inactivo" : "Activo",
        }
    })
    const workbook = XLSX.utils.book_new();
    const worksheet = XLSX.utils.json_to_sheet(data);
    XLSX.utils.book_append_sheet(workbook, worksheet, "productos");
    XLSX.utils.sheet_add_aoa(worksheet, [["ID", "NOMBRE", "PRECIO VENTA", "VALOR PUNTO", "STOCK", "COSTO UNITARIO", "TIPO VENTA", "ESTADO"]], { origin: "A1" });
    XLSX.writeFile(workbook, "productos.xlsx", { compression: true });
}