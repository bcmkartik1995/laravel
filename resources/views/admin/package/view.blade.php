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
                    <h5 class="content-header-title float-left pr-1 mb-0">Package</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active"><a href="{{ route('package.index') }}">Package</a>
                            </li>
                            <li class="breadcrumb-item">Package Media
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Basic Vertical form layout section start -->
        <section id="basic-vertical-layouts">
            <div class="row match-height">
                <div class="col-md-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Package Media</h4>
                            
                        </div>
                        
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    @foreach($package_media as $media)
                                        <div class="col-xl-4 col-md-6 col-12 dashboard-greetings">
                                            <div class="card border-info text-center bg-transparent">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-12 col-sm-12 d-flex justify-content-center flex-column">
                                                            <form class="uplogo-form" id="form_media" action="{{ route('package.update.media',$media->id) }}" method="POST" enctype="multipart/form-data">
                                                                {{csrf_field()}}    
                                                                @php
                                                                    $ext = strtolower(pathinfo(asset('assets/images/packagemedia/'.$media->media), PATHINFO_EXTENSION));
                                                                @endphp
                                                                <div class="currrent-logo mt-2">
                                                                    @if(in_array($ext, $image_formats))
                                                                        <a class="fancybox">
                                                                            <img class="" src="{{asset('assets/images/packagemedia/'.$media->media)}}" alt="" height="250">
                                                                        </a>
                                                                    @else
                                                                        <a class="fancybox1">
                                                                        <video controls width="100%" height="auto" class="">
                                                                            <source src="{{asset('assets/images/packagemedia/'.$media->media)}}" type="video/mp4" height="250">
                                                                        </video>
                                                                        </a>
                                                                    @endif
                                                                    <!-- <img src="{{ asset('assets/images/packagemedia') }}/{{ $media->media }}" alt="" height="220"> -->
                                                                </div>
                                                                <div class="set-logo">
                                                                    <input class="img-upload1" type="file" name="media">
                                                                    @if($errors->has('action') && $errors->first('action')=='edit' && $errors->first('edit_id') ==$media->id && $errors->has('media'))
                                                                        <label id="media-error" class="error" for="media">{{ $errors->first('media') }}</label>
                                                                    @endif
                                                                    <p><small class="text-muted">Image resolution must be 350*250</small></p>
                                                                </div>
                                                                <hr>
                                                                <div class="submit-area mb-4">  
                                                                    <button type="submit" class="btn btn-info mt-50 submit-btn">Update</button>

                                                                    <a href="javascript:void(0);" data-href="{{ route('package.media.destroy',$media->id) }}" class="btn btn-danger mt-50  delete">Detete</a>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <a class="btn btn-primary mb-2 float-right text-white" data-toggle="modal" data-target="#add_media-model"><i class="bx bx-plus"></i>&nbsp; Add new</a>

                                <div class="modal fade" id="add_media-model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Add Media</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="{{ route('package.add.media') }}" enctype="multipart/form-data">
                                                {{csrf_field()}}
                                                <input type="hidden" name="package_id" value="{{ $id }}">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label class="form-label">Media</label>
                                                        <input type="file" class="form-control @if($errors->has('media')) is-invalid @endif" name="media" value="{{old('media')}}">
                                                        @if($errors->has('action') && $errors->first('action')=='add' && $errors->has('media'))
                                                            <label id="name-error" class="error" for="media">{{ $errors->first('media') }}</label>
                                                        @endif
                                                        <p><small class="text-muted">Image resolution must be 350*250</small></p>
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- // Basic Vertical form layout section end -->
    </div>
</div>


@endsection

@section('scripts')

<script>

@if($errors->has('action') && $errors->first('action')=='add' && $errors->has('media'))
    $('#add_media-model').modal();
@endif

    $('.delete').on('click', function () {
    // console.log(e);

    var _token = $("#form_media input[name='_token']").val();
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


    $('.tbl-media').DataTable({
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
