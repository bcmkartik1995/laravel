@extends('layouts.admin')

@section('styles')


<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/app-assets/vendors/css/pickers/daterange/daterangepicker.css') }}">
<style>
    .swal-wide{
        width:600px !important;
        height:250px !important;
    }
</style>

@endsection

@section('content')

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">     
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h5 class="content-header-title float-left pr-1 mb-0">Order</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active">Order
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
                            <h4 class="card-title">Orders</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body card-dashboard">
                                    <!-- <a href="{{route('categories.create')}}" id="addRow" class="btn btn-primary mb-2"><i class="bx bx-plus"></i>&nbsp; Add new</a> -->
                                <div class="row">
                                    
                                    <div class="col-lg-2">
                                        <label for="daterange">Date From</label>
                                        <fieldset class="form-group position-relative has-icon-left">
                                            <input type="text" name="daterange" id="daterange" class="form-control datetime" value="" placeholder="Select Date" autocomplete="off">
                                            <div class="form-control-position">
                                                <i class='bx bx-calendar-check'></i>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-lg-2"> 
                                        <label for="daterangeto">Date To</label>   
                                        <fieldset class="form-group position-relative has-icon-left">
                                            <input type="text" name="daterangeto" id="daterangeto" class="form-control datetime" value="" placeholder="Select Date" autocomplete="off">
                                            <div class="form-control-position">
                                                <i class='bx bx-calendar-check'></i>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class=col-lg-2>
                                        <label for="status">Status</label>
                                        <select class="form-control select2" name="status" id="status">
                                            <option value="">Select Status</option>
                                            <option value="pending">pending</option>
                                            <option value="processing">processing</option>
                                            <option value="completed">completed</option>
                                            <option value="declined">declined</option>
                                            <option value="on delivery">on delivery</option>
                                            <option value="cancelled">cancelled</option>
                                        </select>
                                    </div>
                                    <div class=col-lg-2>
                                        <label for="franchise">Franchise</label>
                                        <select class="form-control select2" name="franchise" id="franchise">
                                            <option value="">Select franchise</option>
                                            @foreach($franchises as $franchise)
                                            <option value="{{ $franchise->id }}">{{ $franchise->franchise_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class=col-lg-2>
                                        <label for="franchise">City</label>
                                        <select class="form-control select2" name="city" id="city">
                                                <option value="">Select City</option>
                                            @foreach($cities as $city)
                                                <option value="{{ $city->name }}">{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class=col-lg-2>
                                        <label for="franchise">Service</label>
                                        <select class="form-control select2" name="service" id="service">
                                                <option value="">Select Service</option>
                                            @foreach($services as $service)
                                                <option value="{{ $service->id }}">{{ $service->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                
                                <div class="table-responsive ordertable">
                                    <table id="ordertable" class="table table-hover dt-responsive">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>User Name</th>
                                                <th>Order Number</th>
                                                <th>Services</th>
                                                <th>Total Quantity</th>
                                                <th>Total Amount</th>
                                                <th>City</th>
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

<!-- Assign Frenchise Model Start -->
<div class="modal" tabindex="-1" role="dialog" id="frenchise-assing-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Assign Order To Frenchise</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form id="frenchise-assign-form" action="{{ route('franchise-order-store') }}">
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" name="orders_id"  id="order_id">
                    <label for="franchises_id">Select Frenchise</label>
                    <select class="form-control" name="franchises_id" id="franchises_id" required>
                        <option value="">Select Frenchise</option>
                    </select>
                </div>
            </div> 
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </form>
    </div>
  </div>
</div>
<!-- Assign Frenchise Model End -->


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
$(".select2").select2({
    // the following code is used to disable x-scrollbar when click in select input and
    // take 100% width in responsive also
    dropdownAutoWidth: true,
    width: '100%'
});

    var table = $('#ordertable').DataTable({
        
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
            url: '{{ route("admin-order-datatables") }}',
            'data': function(data){
                // Read values
                var from_date = $('#daterange').val();
                var to_date = $('#daterangeto').val();
                var status = $('#status').val();
                var franchise = $('#franchise').val();
                var city = $('#city').val();
                var service = $('#service').val();
                
                // Append to data
                data.searchByFromdate = from_date;
                data.searchByTodate = to_date;
                data.searchBystatus = status;
                data.searchByfranchise = franchise;
                data.searchByCity = city;
                data.searchByService = service;
            }
        },
        columns: [
                { data: 'id', name: 'id' },
                { data: 'customer_name', name: 'customer_name' },
                { data: 'order_number', name: 'order_number' },
                { data: 'ordered_services', name: 'ordered_services' },
                { data: 'totalQty', name: 'totalQty' },
                { data: 'pay_amount', name: 'pay_amount' },
                { data: 'cities', name: 'cities' },
                { data: 'status', name: 'status' },
                { data: 'action', searchable: false, orderable: false }

                ]
                
    });

    $('#status').change(function(){
        table.draw();
    });

    $('#franchise').change(function(){
        table.draw();
    });

    $('#city').change(function(){
        table.draw();
    });

    $('#service').change(function(){
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

    $('.ordertable').on('click','.delete', function () {
    // console.log(e);
   
    //var _token = $("#form_lead input[name='_token']").val();
    var _token = '{{ csrf_token() }}';
    var href = $(this).data('href');

    Swal.fire({
       title: 'Are you sure?',
          text: "You will not be able to recover this data!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#DD6B55',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!',
          confirmButtonClass: 'btn btn-primary',
          cancelButtonClass: 'btn btn-danger ml-1',
          buttonsStyling: false,
    }).then(function (result) {
        if(result.value){
            $.ajax({
                url: href,
                type: 'DELETE',
                dataType:"json",
                data: { _token: _token },
                success: function (data) {
                    Swal.fire({
                        title: 'Success',
                        text: data.message,
                        type: "success",
                        showCancelButton: false,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonClass: "btn btn-primary",
                        closeOnConfirm: true,
                    }).then(function (result) {
                        window.location.reload();
                    });
                }
            });
        }
    });
    return false;
});


$('.ordertable').on( "click",'.booking-status', function() {
    var status = $(this).data('status');
    var id = $(this).data('id');
    //alert(id);
    html = '';
    if(status == 'pending'){
        html = '<p><strong>Click Below Button To Manage Order</strong></p>'+
        
        '<div class="mt-2">'+
            '<button class="btn btn-primary order-status mr-25" data-status="processing" data-id="'+id+'">processing</button>'+
            '<button class="btn btn-danger order-status mr-25"  data-status="declined" data-id="'+id+'">declined</button>'+
        '</div>'
    }else if(status == 'processing'){
        html = '<p><strong>Click Below Button To Manage Order</strong></p>'+
        
        '<div class="mt-2">'+
            '<button class="btn btn-primary order-status mr-25" data-status="on delivery" data-id="'+id+'">on delivery</button>'+
            '<button class="btn btn-danger order-status mr-25"  data-status="cancelled" data-id="'+id+'">cancelled</button>'+
        '</div>'
    }else if(status == 'on delivery'){
        html = '<p><strong>Click Below Button To Manage Order</strong></p>'+
        
        '<div class="mt-2">'+
            '<button class="btn btn-primary order-status mr-25" data-status="completed" data-id="'+id+'">completed</button>'+
            '<button class="btn btn-danger order-status mr-25"  data-status="cancelled" data-id="'+id+'">cancelled</button>'+
        '</div>'
    }

    Swal.fire({
        title: "What you want to do?",
        customClass: 'swal-wide',
        showConfirmButton: false,
        showCloseButton: true,
        html: html
    });
    $(document).on('click','.order-status',function(){
    //id = $(this).data('id');
    status = $(this).data('status');
    id = $(this).data('id');
    //alert(id);
    var _token = "{{ csrf_token() }}";
        $.ajax({
            
            url: "{{ route('orders-status') }}",
            type: 'POST',
            data: { status: status,id: id, _token: _token },
            success: function (bookings) {
                //console.log(bookings.status);
               
                if(bookings.status == 'pending'){
                    $('.span-'+id).empty();
                    $('.span-'+id).html('<span class="badge badge-pill badge-light-info">' + 'pending' + '</span>');
                    Swal.close();
                }
                if(bookings.status == 'processing'){
                    $('.span-'+id).empty();
                    $('.span-'+id).html('<span class="badge badge-pill badge-light-primary">' + 'processing' + '</span>');
                    Swal.close();
                }
                if(bookings.status == 'completed'){
                    $('.span-'+id).empty();
                    $('.span-'+id).html('<span class="badge badge-pill badge-light-success">' + 'completed' + '</span>');
                    Swal.close();
                }
                if(bookings.status == 'declined'){
                    $('.span-'+id).empty();
                    $('.span-'+id).html('<span class="badge badge-pill badge-light-danger">' + 'declined' + '</span>');
                    Swal.close();
                }
                if(bookings.status == 'on delivery'){
                    $('.span-'+id).empty();
                    $('.span-'+id).html('<span class="badge badge-pill badge-light-warning">' + 'on delivery' + '</span>');
                    Swal.close();
                }
                window.location.reload();
            }    
        });
    });

});


</script>

@endsection
