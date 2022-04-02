<?php 

use Stevebauman\Location\Facades\Location;

?>

@extends('layouts.admin')

@section('content')

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">     
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h5 class="content-header-title float-left pr-1 mb-0">Franchises Service</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active">Franchises Service
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
                            <h4 class="card-title">Franchises Service</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                @if(Auth::guard('admin')->user()->sectionCheck('franchise_services_add') || Auth::guard('admin')->user()->role_id == 0)
                                    {{--<!-- <a href="{{ route('franchises-service.create') }}" class="btn btn-primary mb-2"><i class="bx bx-plus"></i>&nbsp; Add new</a> -->--}}
                                @endif    
                                <div class="table-responsive">
                                    <table class="table tbl-franchises-service dataTable" id="DataTables_Table_3" role="grid" aria-describedby="DataTables_Table_3_info">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Title</th>
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
                                                <td>{{ $service->service->title }}</td>
                                                <td><img src="{{ asset('assets/images/servicelogo') }}/{{ $service->service->image }}" width="30px" height="30px"></td>
                                                @if(empty($service->hour || $service->minute))
                                                    <td>{{ $service->franchise->hour }} hour {{ $service->franchise->minute }} minute</td>
                                                @else
                                                    <td>{{ $service->hour }} hour {{ $service->minute }} minute</td>
                                                @endif
                                                <td><span class="badge badge-pill badge-light-info status-span-{{ $service->id }}">{{ $service->status==1 ? 'Active': 'Inactive' }}</span></td>
                                                <td>
                                                    <div style="display:flex;">
                                                        @if(Auth::guard('admin')->user()->sectionCheck('franchise_services_edit') || Auth::guard('admin')->user()->role_id == 0)
                                                            <a href="{{route('franchises-service.edit',$service->id)}}" class="btn btn-warning btn-sm mr-25">Edit</a>
                                                        @endif
                                                        @if(Auth::guard('admin')->user()->sectionCheck('franchise_services_delete') || Auth::guard('admin')->user()->role_id == 0)
                                                                {{--<!-- <a href="javascript:void(0);" data-href="{{ route('franchises-service.destroy',$service->id) }}" class="btn btn-danger btn-sm mr-25 delete">Detete</a> -->--}}
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
    $('.tbl-franchises-service').DataTable({
        // "columnDefs": [{
        //     "visible": false,
        //     "targets": 0
        // }],
        "order": [
            [0, 'DESC']
        ],
    });
</script>

@endsection
