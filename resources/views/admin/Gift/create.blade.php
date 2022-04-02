@extends('layouts.admin')

@section('styles')
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
                    <h5 class="content-header-title float-left pr-1 mb-0">Gift</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active"><a href="{{ route('gift-card.index') }}">Gift</a>
                            </li>
                            <li class="breadcrumb-item">Add Gift
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
                            <h4 class="card-title">Add Gift</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                            <form id="form_package" method="POST" action="{{ route('gift-card.store') }}" enctype="multipart/form-data">
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
                                        <label class="form-label">Gifts Value</label>
                                        <input type="text" class="form-control @if($errors->has('gift_value')) is-invalid @endif" name="gift_value" value="{{old('gift_value')}}">
                                        @if($errors->has('gift_value'))
                                            <label id="name-error" class="error" for="gift_value">{{ $errors->first('gift_value') }}</label>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="form-label">Image</label>
                                        <input type="file" class="form-control @if($errors->has('image')) is-invalid @endif" id="exampleFormControlFile1" name="image" value="{{old('image')}}">
                                        @if($errors->has('image'))
                                            <label id="name-error" class="error" for="image">{{ $errors->first('image') }}</label>
                                        @endif
                                        <p><small class="text-muted">Only allowed jpg, png, jpeg format. Image resolution must be 300*200. Max file size allowed : 2MB</small></p>
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

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="form-label">Valid From</label>
                                                <input type="date" id="start" class="form-control @if($errors->has('valid_from')) is-invalid @endif" name="valid_from" value="{{old('valid_from')}}">
                                               @if($errors->has('valid_from'))
                                                    <label id="name-error" class="error" for="valid_from">{{ $errors->first('valid_from') }}</label>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="form-label">Valid To</label>
                                                <input type="date" class="form-control @if($errors->has('valid_to')) is-invalid @endif" name="valid_to" value="{{old('valid_to')}}">
                                                @if($errors->has('valid_to'))
                                                    <label id="name-error" class="error" for="valid_to">{{ $errors->first('valid_to') }}</label>
                                                @endif
                                            </div>
                                        </div>
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

<script src="{{ asset('assets/admin-assets/js/plugin/summernote/summernote-lite.js') }}"></script>
<script src="{{ asset('assets/admin-assets/js/plugin/toaster/toastr.min.js') }}"></script>


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
        $('#form_package').submit(function(){
            content = $('#description').summernote('code');
            $('#description').val(content);
        });
    });
</script>

@endsection
