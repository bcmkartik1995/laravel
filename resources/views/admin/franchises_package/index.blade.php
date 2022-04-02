@extends('layouts.admin')

@section('content')

@php
use Illuminate\Support\Str;
@endphp

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">     
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h5 class="content-header-title float-left pr-1 mb-0">Franchises Package</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active">Franchises Package
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
                            <h4 class="card-title">Franchises packages</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                @if(Auth::guard('admin')->user()->sectionCheck('franchise_packages_add') || Auth::guard('admin')->user()->role_id == 0)
                                    <a href="{{route('franchises-package.create')}}" class="btn btn-primary mb-2"><i class="bx bx-plus"></i>&nbsp; Add new</a>
                                @endif    
                                <div class="table-responsive">
                                    <table class="table tbl-franchises-package">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Title</th>
                                                <th>Description</th>
                                                <th>Discount</th>
                                                <th>Banner</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data as $d)
                                            <tr>
                                                <td>{{ $d->id }}</td>
                                                <td>{{ $d->title }}</td>
                                                <td>
                                                    <a class="" href="#" data-toggle="modal" data-target="#package_desc-{{$d->id}}">
                                                        View Description
                                                    </a>
                                                    
                                                    <div class="modal fade" id="package_desc-{{$d->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle">Description</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                            {!! $d->more_description !!}
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </td>
                                                <td>{{ $d->discount_value }}{{ $d->discount_type==1 ? '%': 'flat' }}</td>
                                                <td><img src="{{ asset('assets/images/packagebanner') }}/{{ $d->banner }}" alt="" width="40" height="30"></td>
                                                <td><span class="badge badge-pill badge-light-info status-span-{{ $d->id }}">{{ $d->status==1 ? 'Active': 'Inactive' }}</span></td>
                                                <td>
                                                    <div style="display:flex;">
                                                    @if(Auth::guard('admin')->user()->sectionCheck('franchise_packages_edit') || Auth::guard('admin')->user()->role_id == 0)
                                                        <a href="{{route('franchises-package.edit',$d->id)}}" class="btn btn-warning btn-sm mr-25">Edit</a>
                                                    @endif
                                                    @if(Auth::guard('admin')->user()->sectionCheck('franchise_packages_delete') || Auth::guard('admin')->user()->role_id == 0)
                                                        <a href="javascript:void(0);" data-href="{{ route('franchises-package.destroy',$d->id) }}" class="btn btn-danger btn-sm mr-25 delete">Detete</a>
                                                    @endif        
                                                    @if(Auth::guard('admin')->user()->sectionCheck('franchise_packages_media') || Auth::guard('admin')->user()->role_id == 0)
                                                        <a href="{{route('franchises-package.show',$d->id)}}" class="btn btn-secondary btn-sm mr-25">Manage Media</a>
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
    $('.tbl-franchises-package').DataTable({
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
