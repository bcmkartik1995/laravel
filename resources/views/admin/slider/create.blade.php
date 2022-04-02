@extends('layouts.admin')

@section('styles')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/app-assets/vendors/css/forms/select/select2.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/js/plugin/summernote/summernote-lite.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin-assets/css/plugin/toaster/vendor/toastr.css') }}" media="screen">

@endsection

@section('content')

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h5 class="content-header-title float-left pr-1 mb-0">Slider</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active"><a href="{{ route('slider.index') }}">Slider</a>
                            </li>
                            <li class="breadcrumb-item">Add Slider
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
                            <h4 class="card-title">Add Slider</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                            <form id="form_subservice" method="POST" action="{{ route('slider.store') }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                    
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label class="form-label">Title</label>
                                            <input type="text" class="form-control @if($errors->has('title')) is-invalid @endif" name="title" value="{{old('title')}}">
                                            @if($errors->has('title'))
                                                <label id="name-error" class="error" for="title">{{ $errors->first('title') }}</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-line">
                                        <label class="form-label">Service</label>
                                        <select class="form-control select2" name="service_id" id="bs_service_id">
                                            <option value="">Select Service</option>
                                            @foreach($services as $service)
                                                <option value="{{ $service->id }}" {{$service->id == old('service_id') ? "selected" : ''}}>{{ $service->title }}</option>
                                            @endforeach
                                        </select>
                                            @if($errors->has('service_id'))
                                                <label id="name-error" class="error" for="service_id">{{ $errors->first('service_id') }}</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label class="form-label">Image</label>
                                            <input type="file" class="form-control @if($errors->has('image')) is-invalid @endif" name="image" value="{{old('image')}}">
                                            @if($errors->has('image'))
                                                <label id="name-error" class="error" for="image">{{ $errors->first('image') }}</label>
                                            @endif
                                            <p><small class="text-muted">Only allowed jpg, png, jpeg format. Image resolution must be 1920*500. Max file size allowed : 2MB</small></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label class="form-label">Mobile Image</label>
                                            <input type="file" class="form-control @if($errors->has('mobile_image')) is-invalid @endif" name="mobile_image" value="{{old('mobile_image')}}">
                                            @if($errors->has('mobile_image'))
                                                <label id="name-error" class="error" for="mobile_image">{{ $errors->first('mobile_image') }}</label>
                                            @endif
                                            <p><small class="text-muted">Only allowed jpg, png, jpeg format. Image resolution must be 400*200. Max file size allowed : 2MB</small></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control @if($errors->has('description')) is-invalid @endif" name="description" id="description">{{old('description')}}</textarea>
                                            @if($errors->has('description'))
                                                <label id="description-error" class="error" for="description">{{ $errors->first('description') }}</label>
                                            @endif
                                            <p><small class="text-muted">Max file size allowed : 500Kb.</small></p>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
                                </form>
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

<!-- BEGIN: Page Vendor JS-->
<script src="{{ asset('assets/admin-assets/app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>

<script src="{{ asset('assets/admin-assets/js/plugin/summernote/summernote-lite.js') }}"></script>
<script src="{{ asset('assets/admin-assets/js/plugin/toaster/toastr.min.js') }}"></script>
<!-- END: Page Vendor JS-->

<script>

$(document).ready(function() {
        $('#description').summernote({
            placeholder: 'Write Your Description Here',
            tabsize: 2,
            height: 200,
            maximumImageFileSize: 500*1024, // 500 KB
            callbacks:{
                onImageUploadError: function(msg){
                    //console.log(msg + ' (1 MB)');
                    toastr.error('File Size Less Then 500KB', 'Error', { "progressBar": true });
                }
            },
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                // ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                //['fontname', ['fontname']],
                // ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'hr']],
                ['view', ['codeview']],
                //['view', ['fullscreen', 'codeview']],
                ['help', ['help']]
            ],
        });

        $('#form_subservice').submit(function(){
            content = $('#description').summernote('code');
            $('#description').val(content);
        });

    });

    $(".multi-select2").select2({
        // the following code is used to disable x-scrollbar when click in select input and
        // take 100% width in responsive also
        placeholder: "Select City",
        dropdownAutoWidth: true,
        width: '100%'
    });
    // $(".multi-select").select2({
    //     //maximumSelectionLength: 2
    // });
</script>
@endsection

