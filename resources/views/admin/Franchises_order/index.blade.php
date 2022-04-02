<?php 

use Stevebauman\Location\Facades\Location;

?>
@extends('layouts.admin')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/app-assets/vendors/css/pickers/daterange/daterangepicker.css') }}">

<style>
    .swal-wide{
        width:500px !important;
        height:250px !important;
    }
</style>

@section('content')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">     
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h5 class="content-header-title float-left pr-1 mb-0">Franchises Orders</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active">Franchises Orders
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.flash-message')
        <!-- Add rows table -->
        <section id="add-row">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Franchises Orders</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <!-- <a href="{{route('categories.create')}}" id="addRow" class="btn btn-primary mb-2"><i class="bx bx-plus"></i>&nbsp; Add new</a> -->

                                <div class="row float-right">
                                    <div class="col-lg-4">
                                        <label for="daterange">Date From</label>
                                        <fieldset class="form-group position-relative has-icon-left">
                                            <input type="text" name="daterange" id="daterange" class="form-control datetime" value="" placeholder="Select Date" autocomplete="off">
                                            <div class="form-control-position">
                                                <i class='bx bx-calendar-check'></i>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-lg-4"> 
                                        <label for="daterangeto">Date To</label>   
                                        <fieldset class="form-group position-relative has-icon-left">
                                            <input type="text" name="daterangeto" id="daterangeto" class="form-control datetime" value="" placeholder="Select Date" autocomplete="off">
                                            <div class="form-control-position">
                                                <i class='bx bx-calendar-check'></i>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class=col-lg-4>
                                        <label for="status">Status</label>
                                        <select class="form-control" name="status" id="status">
                                            <option value="">Select Status</option>
                                            <option value="0">pending</option>
                                            <option value="1">Accept</option>
                                            <option value="2">Cancelled</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="table-responsive franchise_order">
                                    <table class="table table-hover dt-responsive" id="franchise_order_table">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>franchises Name</th>
                                                <th>Amount</th>
                                                <th>User Name</th>
                                                <th>User Address</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--/ Add rows table -->
    </div>
</div>


@endsection

@section('scripts')

<script src="{{ asset('assets/admin-assets/app-assets/vendors/js/tables/datatable/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/admin-assets/app-assets/vendors/js/tables/datatable/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/admin-assets/app-assets/vendors/js/tables/datatable/buttons.bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/admin-assets/app-assets/vendors/js/tables/datatable/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/admin-assets/app-assets/vendors/js/tables/datatable/vfs_fonts.js') }}"></script>

<script src="{{ asset('assets/admin-assets/app-assets/vendors/js/pickers/daterange/moment.min.js') }}"></script>
<script src="{{ asset('assets/admin-assets/app-assets/vendors/js/pickers/daterange/daterangepicker.js') }}"></script>


<script>

var table = $('#franchise_order_table').DataTable({
        
        autoWidth: false,
        ordering: false,
        processing: true,
        serverSide: true,
        dom: 'Bflrtip',
        buttons: [
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                },
                title: '',
                customize: function ( win ) {
                    $(win.document.body).prepend(
                        '<img src="{{asset('assets/admin-assets/images/logo.png')}}" style="padding-bottom:10px;" />'
                    );
                    $(win.document.body).css('background-color','#FFFFFF');
                }
            }
        ],
        ajax: {
            url: '{{ route("admin-franchise-order") }}',
            'data': function(data){
                // Read values
                var from_date = $('#daterange').val();
                var to_date = $('#daterangeto').val();
                var status = $('#status').val();
               
                // Append to data
                data.searchByFromdate = from_date;
                data.searchByTodate = to_date;
                data.searchBystatus = status;
            }
        },
        columns: [
                { data: 'id', name: 'id' },
                { data: 'franchise_name', name: 'franchise_name' },
                { data: 'pay_amount', name: 'pay_amount' },
                { data: 'name', name: 'name' },
                { data: 'customer_address', name: 'customer_address' },
                { data: 'status', name: 'status' },
                { data: 'action', searchable: false, orderable: false }

                ]
                
    });

    $('#status').change(function(){
        table.draw();
    });
    
    $('#daterange').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        locale: {
            format: 'DD/MM/YYYY'
        },
        autoUpdateInput: false, 
    }).on("apply.daterangepicker", function (e, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY'));
        $(this).trigger('change');
    });


    $('#daterange').change(function(){
        table.draw();
    });

    $('#daterangeto').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        locale: {
            format: 'DD/MM/YYYY'
        },
        autoUpdateInput: false, 
    }).on("apply.daterangepicker", function (e, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY'));
        $(this).trigger('change');
    });


    $('#daterangeto').change(function(){
        table.draw();
    });


$('.franchise_order').on( "click",'.franchises-order-status', function() {

        var id = $(this).data('id');
        Swal.fire({
            title: "What you want to do?",
            icon: "warning",
            showConfirmButton: false,
            customClass: 'swal-wide',
            showCloseButton: true,
            html: '<p><strong>Click Below Button To Manage Booking</strong></p>'+
            '<div>'+
                '<button class="btn btn-success mr-25 franchises-status" data-id="'+id+'" data-action="1">Accept</button>'+
                '<button class="btn btn-danger mr-25 franchises-status"  data-id="'+id+'" data-action="2">Cancelled</button>'+
            '</div>'
        });

    $(document).on('click','.franchises-status',function(){
    id = $(this).data('id');
    action =  $(this).data('action');
    var _token = '{{ csrf_token() }}';
        $.ajax({
            url: "{{ route('franchises-orders-status') }}",
            type: 'POST',
            data: { id: id, action: action, _token: _token },
            success: function (franchises_orders) {
                //console.log(leads.status);
                if(franchises_orders.status == 0){
                    $('.span-'+id).empty();
                    $('.span-'+id).html('<span class="badge badge-pill badge-light-info">' + 'Pending' + '</span>');
                    Swal.close();
                }
                if(franchises_orders.status == 1){
                    $('.span-'+id).empty();
                    $('.span-'+id).html('<span class="badge badge-pill badge-light-success">' + 'Accept' + '</span>');
                    window.location.reload();
                    Swal.close();
                }
                if(franchises_orders.status == 2){
                    $('.span-'+id).empty();
                    $('.span-'+id).html('<span class="badge badge-pill badge-light-danger">' + 'Cancelled' + '</span>');
                    window.location.reload();
                    Swal.close();
                }
                
            }    
        });
    });

});


    // $('.tbl-franchises-order').DataTable( {
    //     autoWidth: false,
    //     "columnDefs": [{
    //        // "visible": false,
    //         "targets": 0
    //     }],
    //     "order": [
    //         [0, 'DESC']
    //     ],
    //     dom: 'Bflrtip',
    //     buttons: [
    //         // {
    //         //     extend: 'copyHtml5',
    //         //     exportOptions: {
    //         //         columns: [ 0, ':visible' ]
    //         //     }
    //         // },
    //         {
    //             extend: 'pdfHtml5',
    //             exportOptions: {
    //                 columns: [0, 1, 2, 3, 4, 5]
    //             }
    //         },
    //         // {
    //         //     text: 'JSON',
    //         //     action: function ( e, dt, button, config ) {
    //         //         var data = dt.buttons.exportData();

    //         //         $.fn.dataTable.fileSave(
    //         //             new Blob( [ JSON.stringify( data ) ] ),
    //         //             'Export.json'
    //         //         );
    //         //     }
    //         // },
    //         {
    //             extend: 'print',
    //             exportOptions: {
    //                 columns: [0, 1, 2, 3, 4, 5]
    //             }
    //         }
    //     ]
    // });

</script>

@endsection
