/*
 Template Name: Veltrix - Responsive Bootstrap 4 Admin Dashboard
 Author: Themesbrand
 File: Datatable js
 */

$(document).ready(function() {
    $('#datatable').DataTable();

    //Buttons examples
    //Set on page blade for config

    table.buttons().container()
        .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
} );