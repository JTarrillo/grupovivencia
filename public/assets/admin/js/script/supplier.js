function new_supplier() {
    if (document.getElementById('modalNuevoProveedor')) {
        open_new_supplier_modal();
        return;
    }

    var url = 'dashboard/proveedores/load';
    location.href = site + url;
}

function edit_supplier(supplier_id){    
  var url = 'dashboard/proveedores/load/'+supplier_id;
  location.href = site+url;   
}
function cancel_supplier(){
var url= 'dashboard/proveedores';
location.href = site+url;
}

function escape_html(value) {
    return String(value || '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
}

function format_fecha_simple(fecha) {
    try {
        return new Date(fecha).toLocaleDateString('es-PE');
    } catch (e) {
        return fecha;
    }
}

function open_new_supplier_modal() {
    var form = document.getElementById('formSupplierModal');
    if (form) {
        form.reset();
    }

    var supplierIdInput = document.getElementById('modal_supplier_id');
    if (supplierIdInput) {
        supplierIdInput.value = '';
    }

    $('#modalNuevoProveedor').modal('show');
}

function append_supplier_row(supplierId, name, ruc, phone, address, active) {
    var estadoHtml = active === '0'
            ? '<span class="label label-danger">Inactivo</span>'
            : '<span class="label label-success">Activo</span>';

    var accionesHtml = '' +
            '<div class="operation">' +
            '  <div class="btn-group">' +
            '    <button type="button" class="btn btn-icon btn-info" onclick="edit_supplier(' + "'" + supplierId + "'" + ');"><i class="fa fa-edit"></i></button>' +
            '    <button type="button" class="btn btn-icon btn-danger" onclick="eliminar(this, ' + "'" + supplierId + "'" + ');"><i class="fa fa-trash"></i></button>' +
            '  </div>' +
            '</div>';

    var fechaHoy = format_fecha_simple(new Date());

    if ($.fn.dataTable && $.fn.dataTable.isDataTable('#zero-configuration')) {
        var table = $('#zero-configuration').DataTable();
        table.row.add([
            supplierId,
            '<h6>' + escape_html(name) + '</h6>',
            escape_html(ruc),
            '<h6>' + escape_html(phone) + '</h6>',
            '<h6>' + escape_html(address) + '</h6>',
            '<h6>' + escape_html(fechaHoy) + '</h6>',
            estadoHtml,
            accionesHtml
        ]).draw(false);
    } else {
        var tbody = document.querySelector('#zero-configuration tbody');
        if (!tbody) {
            return;
        }

        var row = document.createElement('tr');
        row.innerHTML = '' +
            '<th>' + escape_html(supplierId) + '</th>' +
            '<td><h6>' + escape_html(name) + '</h6></td>' +
            '<td>' + escape_html(ruc) + '</td>' +
            '<td><h6>' + escape_html(phone) + '</h6></td>' +
            '<td><h6>' + escape_html(address) + '</h6></td>' +
            '<td><h6>' + escape_html(fechaHoy) + '</h6></td>' +
            '<td>' + estadoHtml + '</td>' +
            '<td>' + accionesHtml + '</td>';
        tbody.prepend(row);
    }
}

function validate(){
 document.getElementById("submit").disabled = true;
 document.getElementById("submit").innerHTML = "<span class='spinner-border spinner-border-sm' role='status'></span> Procesando...";
 oData = new FormData(document.forms.namedItem("form"));
     $.ajax({
         url: site + "dashboard/proveedores/validate",
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
                     window.location = site + "dashboard/proveedores";
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

function validate_modal(){
 var submitBtn = document.getElementById("submit_modal");
 submitBtn.disabled = true;
 submitBtn.innerHTML = "<span class='spinner-border spinner-border-sm' role='status'></span> Procesando...";

 var form = document.getElementById("formSupplierModal");
 var formData = new FormData(form);

 $.ajax({
     url: site + "dashboard/proveedores/validate",
     method: "POST",
     data: formData,
     contentType: false,
     cache: false,
     processData: false,
     success: function (data) {
         var response = JSON.parse(data);
         if (response.status == true) {
             append_supplier_row(
                 response.supplier_id || '',
                 formData.get('name') || '',
                 formData.get('ruc') || '',
                 formData.get('phone') || '',
                 formData.get('address') || '',
                 formData.get('active') || '1'
             );

             $('#modalNuevoProveedor').modal('hide');
             form.reset();

             Swal.fire({
                 position: 'top-end',
                 icon: 'success',
                 title: response.message,
                 showConfirmButton: false,
                 timer: 1500
             });
         } else {
             Swal.fire({
                 position: 'top-end',
                 icon: 'info',
                 title: response.message,
             });
         }

         submitBtn.disabled = false;
         submitBtn.innerHTML = "<i class='fa fa-cloud'></i> Guardar";
     },
     error: function () {
         Swal.fire({
             position: 'top-end',
             icon: 'error',
             title: 'No se pudo guardar el proveedor.'
         });

         submitBtn.disabled = false;
         submitBtn.innerHTML = "<i class='fa fa-cloud'></i> Guardar";
     }
 });

 return false;
}

function eliminar(buttonEl, supplier_id){
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
             url: site + "dashboard/proveedores/delete",
             type: "post",
             dataType: "json",
             data: {supplier_id : supplier_id},
             success: function (data) {
                 if (data.status == true) {
                     var $row = $(buttonEl).closest('tr');

                     // If DataTables is active, remove through its API; otherwise remove DOM row.
                     if ($.fn.dataTable && $.fn.dataTable.isDataTable('#zero-configuration')) {
                         var table = $('#zero-configuration').DataTable();
                         table.row($row).remove().draw(false);
                     } else {
                         $row.remove();
                     }

                     Swal.fire({
                         position: 'top-end',
                         icon: 'success',
                         title: data.message,
                         showConfirmButton: false,
                         timer: 1500
                     });
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
