'use strict';
    $(document).ready(function() {
    // [ Zero-configuration ] start
    $('#zero-configuration').DataTable({
        order: [[0, 'desc']],
    });
    // [ Fixed-Columns ] start
    $('#responsive-table-model').DataTable({
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal({
                    header: function(row) {
                        var data = row.data();
                        return 'Details for ' + data[0] + ' ' + data[1];
                    }
                }),
                renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                    tableClass: 'table'
                })
            }
        }
    });
});