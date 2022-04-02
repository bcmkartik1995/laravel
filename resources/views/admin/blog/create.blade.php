@extends('layouts.admin')

@section('styles')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/app-assets/vendors/css/forms/select/select2.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/js/plugin/summernote/summernote-lite.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/css/tagsinput.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin-assets/css/plugin/toaster/vendor/toastr.css') }}" media="screen">

@endsection

@section('content')

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h5 class="content-header-title float-left pr-1 mb-0">Blog</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active"><a href="{{ route('blog.index') }}">Blog</a>
                            </li>
                            <li class="breadcrumb-item">Add Blog
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
                            <h4 class="card-title">Add Blog</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                            <form id="form_subservice" method="POST" action="{{ route('blog.store') }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label class="form-label">Category</label>
                                            <select name="category_id" id="category_id" class="form-control select2">
                                                <option value="">Select Category</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ (old('category_id') == $category->id ? 'selected':'') }}>{{ $category->title }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('category_id'))
                                                <label id="name-error" class="error" for="category_id">{{ $errors->first('category_id') }}</label>
                                            @endif
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-line">
                                        <label class="form-label">Sub Category</label>
                                            <select name="sub_category_id" id="sub_category_id" class="form-control select2">
                                                <option value=""></option>
                                            </select>
                                            @if($errors->has('sub_category_id'))
                                                <label id="name-error" class="error" for="sub_category_id">{{ $errors->first('sub_category_id') }}</label>
                                            @endif
                                        </div>
                                    </div>
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
                                            <label class="form-label">Image</label>
                                            <input type="file" class="form-control @if($errors->has('photo')) is-invalid @endif" name="photo" value="{{old('photo')}}">
                                            @if($errors->has('photo'))
                                                <label id="photo-error" class="error" for="photo">{{ $errors->first('photo') }}</label>
                                            @endif
                                            <p><small class="text-muted">Only allowed png format. Image resolution must be 300*200. Max file size allowed : 2MB</small></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control @if($errors->has('details')) is-invalid @endif" name="details" id="description">{{old('details')}}</textarea>
                                            @if($errors->has('details'))
                                                <label id="details-error" class="error" for="details">{{ $errors->first('details') }}</label>
                                            @endif
                                            <p><small class="text-muted">Max file size allowed : 500Kb.</small></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label class="form-label">Source</label>
                                            <input type="text" class="form-control @if($errors->has('source')) is-invalid @endif" name="source" value="{{old('source')}}">
                                            @if($errors->has('source'))
                                                <label id="source-error" class="error" for="source">{{ $errors->first('source') }}</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label class="form-label">Auther Name</label>
                                            <input type="text" class="form-control @if($errors->has('author_name')) is-invalid @endif" name="author_name" value="{{old('author_name')}}">
                                            @if($errors->has('author_name'))
                                                <label id="author_name-error" class="error" for="author_name">{{ $errors->first('author_name') }}</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label class="form-label">Tags</label>
                                            <input type="text" data-role="tagsinput" name="tag" class="form-control" value="{{ old('tag') }}">
                                            @if($errors->has('tag'))
                                                <label id="tag-error" class="error" for="tag">{{ $errors->first('tag') }}</label>
                                            @endif
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

<script src="{{ asset('assets/admin-assets/js/tagsinput.js') }}"></script>
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

    
$('#category_id').on('change', function () {
    // console.log(e);
    var cat_id = $(this).val();
    var _token = $("#form_subservice input[name='_token']").val();
    //console.log(cat_id);
   
    $.ajax({
        url: "{{route('ajax-subcat')}}",
        type: 'POST',
        data: { cat_id: cat_id, _token: _token },
        success: function (data) {
            $('#sub_category_id').empty();
            $('#sub_category_id').append('<option value ="">Select Sub Category</option>');
            $.each(data, function (inedx, subcatObj) {
                //console.log(subcatObj.title);
                selected = '{{old('sub_category_id')}}'==subcatObj.id?'selected':'';
                $('#sub_category_id').append('<option value ="' + subcatObj.id + '" '+selected+' >' + subcatObj.title + '</option>');
            });
        }
    });

});

$(document).ready(function(){
    $('#category_id').trigger('change');
});

    $(".select2").select2({
        dropdownAutoWidth: true,
        width: '100%'
    });

 
</script>
@endsection

