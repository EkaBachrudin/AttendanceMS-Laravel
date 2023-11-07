/*
 Template Name: Veltrix - Responsive Bootstrap 4 Admin Dashboard
 Author: Themesbrand
 File: Datatable js
 */

$(document).ready(function() {
    $('#datatable').DataTable();

    //Buttons examples
    var table = $('#datatable-buttons').DataTable({
        lengthChange: false,
        buttons: 
        [
            'copy', 
            {
                extend: 'excel',
                text: 'excel',
                exportOptions: {
                    columns: ':visible:not(.not-export-col)'
                }
            },
            'pdf', 
            'colvis'
        ]
    });

    table.buttons().container()
        .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
} );