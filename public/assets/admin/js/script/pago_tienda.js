function back() {
    var url = 'dashboard/pago_tienda';
    location.href = site + url;
}

function back_verify() {
    var url = 'dashboard/pago_tienda_verificadas';
    location.href = site + url;
}


function view(id) {
    var url = 'dashboard/pago_tienda/load/' + id;
    location.href = site + url;
}

function view2(id) {
    var url = 'dashboard/pago_tienda_verificadas/load/' + id;
    location.href = site + url;
}

function procesadas() {
    oData = new FormData(document.forms.namedItem("form"));
    Swal.fire({
        title: 'Confirma que desea procesar el pedido?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Confirmo'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: site + "dashboard/pago_tienda/procesar",
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
                            location.reload()
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

function created_payment() {
    document.getElementById("create_button").disabled = true;
    document.getElementById("create_button").innerHTML = "<span class='spinner-border spinner-border-sm' role='status'></span> Procesando...";
    var text = document.getElementById("payment_name");
    var button = document.getElementById("create_button");
    var select = document.getElementById("payment_id");
    if (text.value == "") {
        text.focus();
    } else {
        Swal.fire({
            title: 'Confirma que desea agregar un nuevo método?',
            icon: 'warning',
            customClass: 'sweetalert-bg',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Confirmo'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: site + "dashboard/pago_tienda/nuevo_metodo",
                    dataType: "json",
                    data: { payment_name: text.value },
                    success: function (data) {
                        if (data.status == true) {
                            button.innerHTML = data.message;
                            window.setTimeout(function () {
                                location.reload();
                            }, 1000);
                        } else {
                            Swal.fire({
                                position: 'center',
                                icon: 'info',
                                title: data.message
                            });
                            document.getElementById("create_button").disabled = false;
                            document.getElementById("create_button").innerHTML = "Crear";
                        }
                    }
                });
            } else {
                document.getElementById("create_button").disabled = false;
                document.getElementById("create_button").innerHTML = "Crear";
            }
        });
    }
}

function exportToExcel(pays) {
    const data = pays.map((pay) => {
        return {
            id: pay.id,
            code: pay.code,
            customer: `${pay.name} ${pay.lastname}`,
            user: pay.username,
            payment: pay.payment == '3' ? "En tienda" : "",
            phone: pay.phone,
            store: pay.store_name,
            amount: pay.amount,
            state: pay.active == '1' ? "Pendiente" : pay.active == '2' ? "Procesado" : '',
            date: pay.date,
        }
    })
    const workbook = XLSX.utils.book_new();
    const worksheet = XLSX.utils.json_to_sheet(data);
    XLSX.utils.book_append_sheet(workbook, worksheet, "Listado de pagos");
    XLSX.utils.sheet_add_aoa(worksheet, [["ID", "PERIODO", "CLIENTE", "USUARIO", "TIPO DE PAGO", "TELÉFONO", "RECOJO", "IMPORTE", "ESTADO", "FECHA"]], { origin: "A1" });
    XLSX.writeFile(workbook, "pagos.xlsx", { compression: true });
}

document.addEventListener("DOMContentLoaded", () => {
    let max_value = document.getElementById("subtotal_max").innerHTML
    let max = 0
    if (max_value.toLocaleLowerCase().includes("s/")) {
        max = parseFloat(max_value.replace(/s\/\./g, ''))
    } else {
        max = parseFloat(max_value)
    }
    const inputsPay = Array.from(document.getElementsByClassName("input-pay"))
    const btn = document.getElementById("content_actions")
    const error = document.getElementById("error_total")
    const alert = document.getElementById("content_alert")

    if (alert) {
        alert.style.display = "none"
        alert.style.display = "block"
    }

    if (btn) {
        btn.setAttribute('hidden', true);
    }

    if (error) {
        error.innerHTML = "Monto insuficiente"
    }

    function validate_pays() {
        const total = inputsPay.reduce((total, input) => {
            const inputValue = parseFloat(input.value) || 0;
            return total + inputValue;
        }, 0);

        if (total > max) {
            if (btn) {
                btn.setAttribute('hidden', true);
            }

            if (alert) {
                alert.style.display = "block"
            }

            if (error) {
                error.innerHTML = "Monto excedido"
            }
        } else if (total < max) {
            if (btn) {
                btn.setAttribute('hidden', true);
            }

            if (alert) {
                alert.style.display = "block"
            }

            if (error) {
                error.innerHTML = "Monto insuficiente"
            }
        } else {
            if (error.textContent.trim() !== "") {
                if (alert) {
                    alert.style.display = "none"
                }

                if (error) {
                    error.innerHTML = ""
                }

                if (btn) {
                    btn.removeAttribute('hidden');
                }
            }
        }
    }

    inputsPay.forEach(inputPay => {
        inputPay.addEventListener("input", () => validate_pays());
    });
})