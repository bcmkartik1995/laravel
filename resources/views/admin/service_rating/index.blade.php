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
                    <h5 class="content-header-title float-left pr-1 mb-0">Service Rating</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active">Service Rating
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
                            <h4 class="card-title">Services Rating</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                @if(Auth::guard('admin')->user()->sectionCheck('service_ratings_add') || Auth::guard('admin')->user()->role_id == 0)
                                    <a href="{{route('service-rating.create')}}" class="btn btn-primary mb-2"><i class="bx bx-plus"></i>&nbsp; Add new</a>
                                @endif      
                                <div class="table-responsive">
                                    <table class="table tbl-service-rating">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>User</th>
                                                <th>Service</th>
                                                <th>Rating</th>
                                                <th>description</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($service_ratings as $service_rating)
                                                <tr>
                                                    <td>{{ $service_rating->id }}</td>
                                                    <td>{{ $service_rating->user->name }}</td>
                                                    <td>{{ $service_rating->service->title }}</td>
                                                    <td>
                                                        @for($i=1;$i<=5;$i++)
                                                            <span class="bx {{$service_rating->service_rating >= $i ? 'bxs-star text-warning':'bx-star'}}"></span>
                                                        @endfor
                                                    </td>
                                                    <td>
                                                        <a href="#" class="" data-toggle="modal" data-target="#service_rating_desc-{{$service_rating->id}}">
                                                            View Description...
                                                        </a>
                                                        
                                                        <div class="modal fade" id="service_rating_desc-{{$service_rating->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLongTitle">Description</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                {!! $service_rating->description !!}
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    
                                                    <td>
                                                        <span class="badge badge-pill badge-light-info status-span-{{ $service_rating->id }}">{{ $service_rating->status==1 ? 'Active': 'In Active' }}</span>
                                                    </td>
                                                    <td>
                                                    <div style="display:flex;">
                                                        @if(Auth::guard('admin')->user()->sectionCheck('service_ratings_edit') || Auth::guard('admin')->user()->role_id == 0)
                                                            <a href="{{route('service-rating.edit',$service_rating->id)}}" class="btn btn-warning btn-sm mr-25">Edit</a>
                                                        @endif

                                                        @if(Auth::guard('admin')->user()->sectionCheck('service_ratings_delete') || Auth::guard('admin')->user()->role_id == 0)
                                                            {{--<a href="javascript:void(0);" data-href="{{ route('service-rating.destroy',$service_rating->id) }}" class="btn btn-danger btn-sm delete mr-25">Detete</a>--}}
                                                        @endif

                                                        @if(Auth::guard('admin')->user()->sectionCheck('service_ratings_status') || Auth::guard('admin')->user()->role_id == 0)
                                                            <a href="javascript:void(0);" data-id="{{$service_rating->id}}" data-action="service_rating" class="common-toggle-button btn btn-{{$service_rating->status==1?'danger':'success'}} btn-sm"> {{$service_rating->status==1?'In Active':'Active'}}</a>
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
    $('.tbl-service-rating').DataTable({
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
