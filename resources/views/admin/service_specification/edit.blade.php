@extends('layouts.admin')

@section('styles')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/app-assets/vendors/css/forms/select/select2.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/js/plugin/summernote/summernote-lite.css') }}">

@endsection

@section('content')


<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h5 class="content-header-title float-left pr-1 mb-0">Services</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">

                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ route('services.index') }}">Services</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ route('service_specification.index',$service_specification->service_id) }}">Service Specifications</a>
                            </li>
                            <li class="breadcrumb-item active">Edit Specifications
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
                            <h4 class="card-title">Edit Services</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                            <form id="form_specification" method="POST" action="{{ route('service_specification.update',$service_specification->id) }}" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <div class="form-line">
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control @if($errors->has('title')) is-invalid @endif" name="title" value="{{old('title',$service_specification->title)}}">
                                    @if($errors->has('title'))
                                        <label id="title-error" class="error" for="title">{{ $errors->first('title') }}</label>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <label class="form-label">Image</label>
                                    <input type="file" class="form-control @if($errors->has('filename')) is-invalid @endif" name="filename" value="{{old('filename')}}">
                                    @if($errors->has('filename'))
                                        <label id="filename-error" class="error" for="filename">{{ $errors->first('filename') }}</label>
                                    @endif
                                    <p><small class="text-muted">Image resolution must be 300*300</small></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control @if($errors->has('description')) is-invalid @endif" name="description" id="description">{{old('description',$service_specification->description)}}</textarea>
                                    @if($errors->has('description'))
                                        <label id="description-error" class="error" for="description">{{ $errors->first('description') }}</label>
                                    @endif
                                </div>
                            </div>
                                <button class="btn btn-primary btn-sm" type="submit">UPDATE</button>
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
<!-- END: Page Vendor JS-->

<script>

$(document).ready(function() {
    $('#description').summernote({
        placeholder: 'Write Your Description Here',
        tabsize: 2,
        height: 200,
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

    $('#form_specification').submit(function(){
        content = $('#description').summernote('code');
        $('#description').val(content);
    });

});
</script>

@endsection
