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
                    <h5 class="content-header-title float-left pr-1 mb-0">Service</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active">Service
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
                            <h4 class="card-title">services</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                @if(Auth::guard('admin')->user()->sectionCheck('services_add') || Auth::guard('admin')->user()->role_id == 0)
                                    <a href="{{route('services.create')}}" class="btn btn-primary mb-2"><i class="bx bx-plus"></i>&nbsp; Add new</a>
                                @endif
                                <div class="table-responsive">
                                    <table class="table tbl-service">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Title</th>
                                                <th>Category</th>
                                                <th>Sub Category</th>
                                                <th>Image</th>
                                                <th>Time</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($services as $service)
                                            <tr>
                                                <td>{{ $service->id }}</td>
                                                <td>{{ $service->title }}</td>
                                                <td>{{ $service->category->title }}</td>
                                                <td>{{ $service->sub_category->title }}</td>
                                                <td><img src="{{ asset('assets/images/servicelogo') }}/{{ $service->image }}" width="30px" height="30px"></td>
                                                <td>{{ $service->hour }} Hour {{ $service->minute }} Minute </td>
                                                <td>
                                                    <span class="badge badge-pill badge-light-info status-span-{{ $service->id }}">{{ $service->status==1 ? 'Active': 'In Active' }}</span>
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                        @if(Auth::guard('admin')->user()->sectionCheck('services_edit') || Auth::guard('admin')->user()->role_id == 0)
                                                            <a href="{{route('services.edit',$service->id)}}" class="dropdown-item"><i class="bx bx-edit-alt mr-1"></i>Edit</a>
                                                        @endif

                                                        @if(Auth::guard('admin')->user()->sectionCheck('services_delete') || Auth::guard('admin')->user()->role_id == 0)
                                                            <a href="javascript:void(0);" data-href="{{ route('services.destroy',$service->id) }}" class="dropdown-item delete"><i class="bx bx-trash mr-1"></i>Delete</a>
                                                        @endif

                                                        @if(Auth::guard('admin')->user()->sectionCheck('services_status') || Auth::guard('admin')->user()->role_id == 0)
                                                            <a href="javascript:void(0);" data-id="{{$service->id}}" data-action="service" class="toggle-button dropdown-item"><i class="bx bxs-{{ $service->status == 1 ? 'hide' : 'show' }} mr-1"></i> {{$service->status==1?'InActive':'Active'}}</a>
                                                        @endif

                                                        @if(Auth::guard('admin')->user()->sectionCheck('services_media') || Auth::guard('admin')->user()->role_id == 0)
                                                            <a href="{{route('services.show',$service->id)}}" class="dropdown-item"><i class="bx bx-images mr-1"></i>Manage Media</a>
                                                        @endif
                                                            
                                                        @if(Auth::guard('admin')->user()->sectionCheck('service_specification') || Auth::guard('admin')->user()->role_id == 0)
                                                            <a href="{{route('service_specification.index',$service->id)}}" class="dropdown-item"><i class="bx bxs-detail mr-1"></i>Specifications</a>
                                                        @endif

                                                        @if(Auth::guard('admin')->user()->sectionCheck('service_faq') || Auth::guard('admin')->user()->role_id == 0)
                                                            <a href="{{route('service_faq.index',$service->id)}}" class="dropdown-item"><i class="bx bxs-conversation mr-1"></i>Faq</a>
                                                        @endif
                                                        </div>
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
            
            window.location.reload();

        }

    });

});




$('.delete').on('click', function () {
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
