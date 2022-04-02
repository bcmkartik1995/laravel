@extends('layouts.admin')

@section('styles')

    <!-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/app-assets/vendors/css/tables/datatable/datatables.min.css') }}"> -->

@endsection

@section('content')

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">     
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h5 class="content-header-title float-left pr-1 mb-0">Manage Customer</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active">Manage Customer
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
                            <h4 class="card-title">Manage Customer</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body card-dashboard">
                            <div class="row">

                                    <div class="col-lg-4">
                                        <a href="{{ route('users.create') }}" class="btn btn-primary mb-2"><i class="bx bx-plus"></i>&nbsp; Add new</a>
                                    </div>
                                
                                    <div class="col-lg-4 offset-4">
                                        <label for="city">City</label>
                                        <select class="form-control select2" name="city" id="city">
                                            <option value="">Select City</option>
                                            @foreach($cities as $city)
                                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                </div>

                                <div class="table-responsive usertable">
                                    <table id="user_table" class="table">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Mobile</th>
                                                <th>City</th>
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

<script>
$(".select2").select2({
    // the following code is used to disable x-scrollbar when click in select input and
    // take 100% width in responsive also
    dropdownAutoWidth: true,
    width: '100%'
});
    
var table = $('#user_table').DataTable({

autoWidth: false,
ordering: false,
processing: true,
serverSide: true,
"columnDefs": [{
            "visible": false,
            "targets": 0
        }],
        "order": [
            [0, 'DESC']
        ],
ajax: {
    url: '{{ route("admin-user-datatables") }}',
    'data': function(data){
        // Read values
        var city = $('#city').val();
            
        // Append to data
        data.searchByCity = city;
                
    }
},
columns: [
        { data: 'id', name: 'id' },
        { data: 'name', name: 'name' },
        { data: 'email', name: 'email' },
        { data: 'phone', name: 'phone' },
        { data: 'user_city', name: 'user_city' },
        { data: 'action', searchable: false, orderable: false }

        ]

});



$('#city').change(function(){
    table.draw();
});

$('#user_table').on('click','.delete', function () {
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


</script>

@endsection
