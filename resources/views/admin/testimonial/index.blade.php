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
                    <h5 class="content-header-title float-left pr-1 mb-0">Testimonial</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active">Testimonial
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
                            <h4 class="card-title">Testimonial</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                @if(Auth::guard('admin')->user()->sectionCheck('testimonial_add') || Auth::guard('admin')->user()->role_id == 0)
                                    <a href="{{ route('testimonial.create') }}" class="btn btn-primary mb-2"><i class="bx bx-plus"></i>&nbsp; Add new</a>
                                @endif      
                                <div class="table-responsive">
                                    <table class="table tbl-testimonial">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>title</th>
                                                <th>image</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($testimonials as $testimonial)
                                                <tr>
                                                    <td>{{ $testimonial->id }}</td>
                                                    <td>{{ $testimonial->title }}</td>
                                                    <td><img src="{{ asset('assets/images/testimonial') }}/{{ $testimonial->image }}" width="80" height="40"></td>
                                                    <td>
                                                        <span class="badge badge-pill badge-light-info status-span-{{ $testimonial->id }}">{{ $testimonial->status==1 ? 'Active': 'In Active' }}</span>
                                                    </td>
                                                    <td>
                                                        <div style="display:flex;">
                                                            @if(Auth::guard('admin')->user()->sectionCheck('testimonial_edit') || Auth::guard('admin')->user()->role_id == 0)
                                                                <a href="{{route('testimonial.edit',$testimonial->id)}}" class="btn btn-warning btn-sm mr-25">Edit</a>
                                                            @endif
                                                            
                                                            @if(Auth::guard('admin')->user()->sectionCheck('testimonial_status') || Auth::guard('admin')->user()->role_id == 0)
                                                                <a href="javascript:void(0);" data-id="{{$testimonial->id}}" data-action="testimonial" class="common-toggle-button btn btn-{{$testimonial->status==1?'danger':'success'}} btn-sm"> {{$testimonial->status==1?'In Active':'Active'}}</a>
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
    $('.tbl-testimonial').DataTable({
        autoWidth: false,
        "columnDefs": [{
            "visible": false,
            "targets": 0
        }],
        "order": [
            [0, 'DESC']
        ],
    });
    
    // $(document).ready(function() {
    //     var star_rate = $("input[name=rate]:checked").val();
    // });
</script>

@endsection
