@extends('layouts.admin')


@section('styles')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">

<style>
    .swal-wide{
        width:500px !important;
        height:250px !important;
    }

    @media only screen and (max-width: 1440px) and (min-width: 1024px){
        .table th, .table td {
            padding: 1.15rem 5px;
        }
        body {
            font-size: 12px;
        }
    }
    @media only screen and (min-width: 768px) and (max-width: 1024px){
        .table th, .table td {
            padding: 1.15rem 3px;
        }
        body {
            font-size: 10px;
        }
        .badge{
            font-size: 10px;
        }
        .badge-pill {
            padding-right: 7px 7px;
        }
        .btn-sm, .btn-group-sm > .btn {
            padding: 0.467rem 1.2rem;
            font-size: 9px;
            line-height: 1.4;
            border-radius: 0.267rem;
        }
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
                    <h5 class="content-header-title float-left pr-1 mb-0">Lead</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active">Lead
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
                            <h4 class="card-title">Leads</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">

                            <div class="row ">

                                <div class="col-md-4 offset-4">
                                    <label for="status">Skills</label>
                                    <select class="form-control select2" name="skill" id="skill">
                                        <option value="">Select Skill</option>
                                        @foreach($skills as $skill)
                                            <option value="{{ $skill->id }}">{{ $skill->skill }}</option>
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
                                    <table id="leadtable" class="table table-hover dt-responsive">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Mobile</th>
                                                <th>Skill</th>
                                                <th>Country</th>
                                                <th>State</th>
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
@endsection

@section('scripts')

<script src="{{ asset('assets/admin-assets/app-assets/vendors/js/tables/datatable/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/admin-assets/app-assets/vendors/js/tables/datatable/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/admin-assets/app-assets/vendors/js/tables/datatable/buttons.bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/admin-assets/app-assets/vendors/js/tables/datatable/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/admin-assets/app-assets/vendors/js/tables/datatable/vfs_fonts.js') }}"></script>

<script>

$(".select2").select2({
    // the following code is used to disable x-scrollbar when click in select input and
    // take 100% width in responsive also
    dropdownAutoWidth: true,
    width: '100%'
});
var table = $('#leadtable').DataTable({

    autoWidth: false,
    "columnDefs": [{
        "visible": false,
        "targets": 0
    }],
    ordering: false,
    processing: true,
    serverSide: true,
    dom: 'Bflrtip',
        buttons: [
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7]
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7]
                }
            }
        ],
    ajax: {
        url: '{{ route("lead-datatables") }}',
        'data': function(data){
            // Read values

            var skill = $('#skill').val();
            var city = $('#city').val();

            // Append to data
            data.searchByToskill = skill;
            data.searchBycity = city;
        }
    },
    columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'phone', name: 'phone' },
            { data: 'skill', name: 'skill' },
            { data: 'country.name', name: 'country' },
            { data: 'state.name', name: 'state' },
            { data: 'city.name', name: 'city' },
            { data: 'status', name: 'status' },
            { data: 'action', searchable: false, orderable: false }

            ]

});

$('#city').change(function(){
    table.draw();
});
$('#skill').change(function(){
    table.draw();
});

$('#leadtable').on('click','.delete', function () {
    // console.log(e);

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


$('#leadtable').on('click','.status', function () {

        var id = $(this).data('id');
    Swal.fire({
        title: "What you want to do?",
        icon: "warning",
        customClass: 'swal-wide',
        showConfirmButton: false,
        showCloseButton: true,
        html: '<p><strong>Click Below Button To Manage Lead</strong></p>'+
        '<div class="mt-2">'+
            '<button class="btn btn-success lead-status mr-25" data-id="'+id+'" data-action="1">Accept</button>'+
            '<button class="btn btn-danger lead-status mr-25"  data-id="'+id+'" data-action="2">Decline</button>'+
        '</div>'
    });

    $(document).on('click','.lead-status',function(){
    id = $(this).data('id');
    action =  $(this).data('action');
    Swal.close();
        //alert(action);
    var _token = '{{ csrf_token() }}';
        $.ajax({
            url: "{{route('lead-status')}}",
            type: 'POST',
            data: { id: id, action: action, _token: _token },
            success: function (leads) {
                //console.log(leads.status);
                if(leads.status == 0){
                    $('.span-'+id).empty();
                    $('.span-'+id).html('<span class="badge badge-pill badge-light-info">' + 'Pending' + '</span>');

                }
                if(leads.status == 1){
                    $('.span-'+id).empty();
                    $('.span-'+id).html('<span class="badge badge-pill badge-light-success">' + 'Accept' + '</span>');

                }
                if(leads.status == 2){
                    $('.span-'+id).empty();
                    $('.span-'+id).html('<span class="badge badge-pill badge-light-danger">' + 'Decline' + '</span>');

                }

                Swal.fire({
                    title: 'Success',
                    text: "Status changed successfully",
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
    });

});

    // $('.tbl-lead').DataTable({
    //     autoWidth: false,
    //     "columnDefs": [{
    //         "visible": false,
    //         "targets": 0
    //     }],
    //     "order": [
    //         [0, 'DESC']
    //     ],
    // });

    $('#leadtable').on('click','.add-to-franchises', function (e) {

        e.preventDefault();

        var id = $(this).data('id');
        var url = '{{ route('add-to-franchise') }}';
        var _token = "{{ csrf_token() }}";

        $.ajax({
        url:url,
        method:'POST',
        datatype:'json',
        data:{
                id:id,
                _token:_token
                },
        success:function(response){
            if(response.success){
                Swal.fire({
                    title: 'Success',
                    text: response.message,
                    type: "success",
                    showCancelButton: false,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonClass: "btn btn-primary",
                    closeOnConfirm: true,
                }).then(function (result) {
                    window.location.href = response.redirect;
                });
            }else{
                Swal.fire({
                    title: 'Danger',
                    text: response.errors,
                    type: "error",
                    showCancelButton: false,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonClass: "btn btn-primary",
                    closeOnConfirm: true,
                });
            }
        },
        error:function(error){
            console.log(error)
        }
        });
    });
</script>

@endsection
