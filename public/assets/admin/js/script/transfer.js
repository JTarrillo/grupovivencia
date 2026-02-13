function new_transfer() {
  var url = 'dashboard/traspaso/load';
  location.href = site + url;
}

function edit_transfer(transfer_id){    
  var url = 'dashboard/traspaso/load/'+transfer_id;
  location.href = site+url;   
}
function cancel_transfer(){
var url= 'dashboard/traspaso';
location.href = site+url;
}

function validate(){
 document.getElementById("submit").disabled = true;
 document.getElementById("submit").innerHTML = "<span class='spinner-border spinner-border-sm' role='status'></span> Procesando...";
 oData = new FormData(document.forms.namedItem("form"));
     $.ajax({
         url: site + "dashboard/traspaso/validate",
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
                     window.location = site + "dashboard/traspaso";
                 }, 1500);
             } else {
                 Swal.fire({
                     position: 'top-end',
                     icon: 'info',
                     title: data.message,
                 });
                 document.getElementById("submit").disabled = false;
                 document.getElementById("submit").innerHTML = "<i class='fa fa-cloud'></i> Guardar";
             }
         }
     });
}

function eliminar(transfer_id){
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
             url: site + "dashboard/traspaso/delete",
             type: "post",
             dataType: "json",
             data: {transfer_id : transfer_id},
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
                         window.location = site + "dashboard/entradas";
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

function exportToExcel(transfers) {
    const data = transfers.map((transfer) => {
        return {
            id: transfer.id,
            date: transfer.date,
            out: transfer.departure,
            product: transfer.name,
            qty: transfer.qty,
            unit_cost: transfer.unit_cost,
            total_cost: transfer.total_costo,
            in: transfer.arrive,
            user: transfer.user,
        }
    })
    const workbook = XLSX.utils.book_new();
    const worksheet = XLSX.utils.json_to_sheet(data);
    XLSX.utils.book_append_sheet(workbook, worksheet, "traspasos");
    XLSX.utils.sheet_add_aoa(worksheet, [["ID", "FECHA", "SALE", "PRODUCTO", "CANTIDAD", "COSTO UNITARIO", "COSTO TOTAL", "LLEGADA", "INGRESADO POR"]], { origin: "A1" });
    XLSX.writeFile(workbook, "traspasos.xlsx", { compression: true });
}