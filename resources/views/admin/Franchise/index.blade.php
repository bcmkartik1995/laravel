@extends('layouts.admin')

@section('styles')


<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/app-assets/vendors/css/pickers/daterange/daterangepicker.css') }}">


@section('content')

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h5 class="content-header-title float-left pr-1 mb-0">Franchise</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active">Franchise
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
                            <h4 class="card-title">Franchises</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                            @if(Auth::guard('admin')->user()->sectionCheck('franchises_add') || Auth::guard('admin')->user()->role_id == 0)
                                <!-- <a href="{{route('categories.create')}}" id="addRow" class="btn btn-primary mb-2"><i class="bx bx-plus"></i>&nbsp; Add new</a> -->
                            @endif

                            <div class="row ">

                                <div class="col-md-4 offset-4">
                                    <label for="status">Skills</label>
                                    <select class="form-control select2" name="category" id="category">
                                        <option value="">Select skill</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="status">Status</label>
                                    <select class="form-control select2" name="city" id="city">
                                        <option value="">Select city</option>
                                        @foreach($cities as $city)
                                            <option value="{{$city->id}}">{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                                <div class="table-responsive">
                                    <table id="franchise-table" class="table table-hover dt-responsive">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Franchise Name</th>
                                                <th>Country</th>
                                                <th>State</th>
                                                <th>City</th>
                                                <th>Commission</th>

                                                <th>More Information</th>
                                                <!-- <th>User</th>
                                                <th>Email</th>
                                                <th>Mobile Number</th>
                                                <th>Time</th> -->

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

$(".select2").select2({
        // the following code is used to disable x-scrollbar when click in select input and
        // take 100% width in responsive also
        dropdownAutoWidth: true,
        width: '100%'
    });
$('#franchise-table').on('click','.toggle-button',function(){

    var id = $(this).data('id');
    var action = $(this).data('action');
    //alert(action);
    var obj = $(this);
    $.ajax({
        header:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        },
        url: 'toggle-status',
        type: "POST",
        dataType: "json",
        data: {'action': action, 'id': id, "_token": $('meta[name="csrf-token"]').attr('content')},
        success: function(data){

            if (obj.hasClass('btn-danger')) {
            obj.html('Active').addClass('btn-success').removeClass('btn-danger');
            $('.status-span-'+id).html('Inactive');
            } else{
                obj.html('InActive').removeClass('btn-success').addClass('btn-danger');
                $('.status-span-'+id).html('Active');
                //$(this).html('InActive').toggleClass('btn-danger');
            }
        }

    });

});

$('#franchise-table').on('click','.delete', function () {
    // console.log(e);

    var _token = $("#form_lead input[name='_token']").val();
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
                data: { _token: "{{ csrf_token() }}" },
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

var table = $('#franchise-table').DataTable({

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
                }
            }
        ],
        ajax: {
            url: '{{ route("admin-franchises") }}',
            'data': function(data){
                // Read values

                var category = $('#category').val();
                var city = $('#city').val();

                // Append to data
                data.searchByTocategory = category;
                data.searchBycity = city;
            }
        },
        columns: [
                { data: 'id', name: 'id' },
                { data: 'franchise_name', name: 'franchise_name' },
                { data: 'country.name', name: 'country' },
                { data: 'state.name', name: 'state' },
                { data: 'city.name', name: 'city' },
                { data: 'commission', name: 'commission' },
                { data: 'more_info', name: 'more_info' },
                { data: 'commission', name: 'commission' },
                { data: 'action', searchable: false, orderable: false }

                ]

    });

    $('#city').change(function(){
        table.draw();
    });
    $('#category').change(function(){
        table.draw();
    });
</script>

@endsection
