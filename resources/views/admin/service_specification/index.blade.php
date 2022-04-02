@extends('layouts.admin')

@section('styles')

@endsection

@section('content')

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h5 class="content-header-title float-left pr-1 mb-0">Service Specifications</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ route('services.index') }}">Services</a>
                            </li>
                            <li class="breadcrumb-item active">Specifications
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
                            <h4 class="card-title">Specifications</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                @if(Auth::guard('admin')->user()->sectionCheck('service_specification_add') || Auth::guard('admin')->user()->role_id == 0)
                                    <a href="{{route('service_specification.create',$service_id)}}" class="btn btn-primary mb-2"><i class="bx bx-plus"></i>&nbsp; Add new</a>
                                @endif
                                <div class="table-responsive">
                                    <table class="table tbl-service">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Title</th>
                                                <th>Image</th>
                                                <th>Description</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($Service_specifications as $specification)
                                            <tr>
                                                <td>{{ $specification->id }}</td>
                                                <td>{{ $specification->title }}</td>
                                                <td><img src="{{ asset('assets/images/service_specifications') }}/{{ $specification->filename }}" width="40px" height="40px"></td>
                                                <td><a href="javascript(0);" data-toggle="modal" data-target="#spec_desc-{{$specification->id}}">
                                                    Description
                                                </a>

                                                <div class="modal fade" id="spec_desc-{{$specification->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">Description</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                        {!! $specification->description !!}
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div></td>
                                                <td><span class="badge badge-pill badge-light-info status-span-{{ $specification->id }}">{{ $specification->status==1 ? 'Active': 'Inactive' }}</span></td>
                                                <td>
                                                    <div style="display:flex;">
                                                        @if(Auth::guard('admin')->user()->sectionCheck('service_specification_edit') || Auth::guard('admin')->user()->role_id == 0)
                                                            <a href="{{route('service_specification.edit',$specification->id)}}" class="btn btn-warning btn-sm mr-25">Edit</a>
                                                        @endif

                                                        @if(Auth::guard('admin')->user()->sectionCheck('service_specification_delete') || Auth::guard('admin')->user()->role_id == 0)
                                                            <a href="javascript:void(0);" data-href="{{ route('service_specification.destroy',$specification->id) }}" class="btn btn-danger btn-sm mr-25 delete">Detete</a>
                                                        @endif

                                                        @if(Auth::guard('admin')->user()->sectionCheck('service_specification_status') || Auth::guard('admin')->user()->role_id == 0)
                                                            <a href="javascript:void(0);" data-id="{{$specification->id}}" data-action="service_specification" class="toggle-button btn btn-{{$specification->status==1?'danger':'success'}} btn-sm mr-25"> {{$specification->status==1?'Inactive':'Active'}}</a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
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

$('.toggle-button').on('click',function(){

    var id = $(this).data('id');
    var action = $(this).data('action');
    //alert(action);
    var obj = $(this);
    $.ajax({
        header:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        },
        url: "{{route('common.toggle-status')}}",
        type: "POST",
        dataType: "json",
        data: {'action': action, 'id': id, "_token": $('meta[name="csrf-token"]').attr('content')},
        success: function(data){

            if (obj.hasClass('btn-danger')) {
            obj.html('Active').addClass('btn-success').removeClass('btn-danger');
            $('.status-span-'+id).html('Inactive');
            } else{
                obj.html('Inactive').removeClass('btn-success').addClass('btn-danger');
                $('.status-span-'+id).html('Active');
                //$(this).html('InActive').toggleClass('btn-danger');
            }
        }

    });

});


$('.delete').on('click', function () {

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
    $('.tbl-service').DataTable({
        autoWidth: false,
        "columnDefs": [{
            "visible": false,
            "targets": 0
        }],
        "order": [
            [0, 'DESC']
        ],
    });
</script>

@endsection
