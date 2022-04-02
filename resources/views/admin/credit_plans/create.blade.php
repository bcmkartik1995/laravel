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
                    <h5 class="content-header-title float-left pr-1 mb-0">Credit Plans</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active"><a href="{{ route('credit_plans.index') }}">Credit Plans</a>
                            </li>
                            <li class="breadcrumb-item">Add Credit Plan
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
                            <h4 class="card-title">Add Credit Plan</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                            <form id="form_validation" method="POST" action="{{ route('credit_plans.store') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="form-label">Title</label>
                                        <input type="text" class="form-control @if($errors->has('title')) is-invalid @endif" name="title" value="{{old('title')}}" >
                                        @if($errors->has('title'))
                                            <label id="name-error" class="error" for="title">{{ $errors->first('title') }}</label>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="form-label">Credit Value</label>
                                        <input type="text" class="form-control @if($errors->has('credit_value')) is-invalid @endif" name="credit_value" value="{{old('credit_value')}}" >
                                        @if($errors->has('credit_value'))
                                            <label id="name-error" class="error" for="credit_value">{{ $errors->first('credit_value') }}</label>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="form-label">Credit Price</label>
                                        <input type="text" class="form-control @if($errors->has('price')) is-invalid @endif" name="price" value="{{old('price')}}" >
                                        @if($errors->has('price'))
                                            <label id="price-error" class="error" for="price">{{ $errors->first('price') }}</label>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="form-label">Real Price</label>
                                        <input type="text" class="form-control @if($errors->has('real_price')) is-invalid @endif" name="real_price" value="{{old('real_price')}}" >
                                        @if($errors->has('real_price'))
                                            <label id="real_price-error" class="error" for="real_price">{{ $errors->first('real_price') }}</label>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="form-label">Validity Value</label>
                                        <input type="text" class="form-control @if($errors->has('validity_value')) is-invalid @endif" name="validity_value" value="{{old('validity_value')}}" >
                                        @if($errors->has('validity_value'))
                                            <label id="name-error" class="error" for="validity_value">{{ $errors->first('validity_value') }}</label>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="form-label">Validity Type</label>
                                        <select class="form-control @if($errors->has('validity_type')) is-invalid @endif select2" name="validity_type">
                                            <option value="">Select Validity Type</option>
                                            @foreach ($validity_types as $k => $validity_type)
                                                <option value="{{$k}}" {{old('validity_type')==$k ? 'selected':''}}>{{$validity_type}}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('validity_type'))
                                            <label id="name-error" class="error" for="validity_type">{{ $errors->first('validity_type') }}</label>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="form-label">Image</label>
                                        <input type="file" class="form-control @if($errors->has('image')) is-invalid @endif" name="image" value="{{ old('image') }}">
                                        @if($errors->has('image'))
                                            <label id="name-error" class="error" for="image">{{ $errors->first('image') }}</label>
                                        @endif
                                        <p><small class="text-muted">Only allowed jpg, png, jpeg format. Image resolution must be 300*200. Max file size allowed : 2MB</small></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control" name="description" id="description">{{old('description')}}</textarea>
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
        $('#form_validation').submit(function(){
            content = $('#description').summernote('code');
            $('#description').val(content);
        });

        $(".select2").select2({
            dropdownAutoWidth: true,
            width: '100%'
        });
        
    });
</script>
@endsection
