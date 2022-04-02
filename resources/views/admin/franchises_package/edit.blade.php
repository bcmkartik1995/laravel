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
                    <h5 class="content-header-title float-left pr-1 mb-0">Franchises Package</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active"><a href="{{ route('franchises-package.index') }}">Franchises Package</a>
                            </li>
                            <li class="breadcrumb-item">Edit Package
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
                            <h4 class="card-title">Edit Package</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                            <form id="form_franchise_package" method="POST" action="{{ route('franchises-package.update',$package->id) }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input name="_method" type="hidden" value="PUT">
                            <input type="text" name="franchises_id" value="{{ $package->franchises_id }}" hidden>
                            <input type="hidden" value="{{$package->id}}" id="package_id">
                            {{--<!-- <div class="form-group">
                                <div class="form-line">
                                    <label class="form-label">Categories</label>
                                    <select name="category_id[]" id="fp_category_id" class="select-category form-control" multiple>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ in_array($category->id, $package_cat) ? 'selected':''}}>{{ $category->title }}</option>
                                    @endforeach
                                    </select>
                                    @if($errors->has('category_id'))
                                        <label id="name-error" class="error" for="category_id">{{ $errors->first('category_id') }}</label>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <label class="form-label">Sub Categories</label>
                                        <select name="sub_category_id[]" id="fp_sub_category_id" class="select-subcategory form-control" multiple>
                                            @foreach($subcategory as $subcate)
                                                <option value="{{ $subcate->id }}" {{ in_array($subcate->id, $package_sub) ? 'selected':''}}>{{ $subcate->title }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('sub_category_id'))
                                            <label id="name-error" class="error" for="sub_category_id">{{ $errors->first('sub_category_id') }}</label>
                                        @endif
                                </div>
                            </div> -->--}}
                            <div class="form-group">
                                <div class="form-line">
                                    <label class="form-label">Service</label>
                                    <select class="select-service form-control" name="service[]" id="p_service_id" multiple>
                                        @foreach($services as $service)
                                            <option value="{{ $service->service->id }}" {{in_array($service->service_id,old('service',$package_service))?'selected':''}}>{{ $service->service->title }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('service'))
                                        <label id="name-error" class="error" for="service">{{ $errors->first('service') }}</label>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                <label class="form-label">City</label>
                                    <select name="city_id[]" id="p_city_id" class="select-city form-control" multiple="multiple">
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}" {{in_array($city->id,old('city_id',$package_city))?'selected':''}}>{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('city_id'))
                                        <label id="name-error" class="error" for="city_id">{{ $errors->first('city_id') }}</label>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control @if($errors->has('title')) is-invalid @endif" name="title" value="{{old('title',$package->title)}}">
                                    @if($errors->has('title'))
                                        <label id="name-error" class="error" for="title">{{ $errors->first('title') }}</label>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <label class="form-label">Banner</label>
                                    <input type="file" class="form-control  @if($errors->has('banner')) is-invalid @endif" name="banner" value="{{old('banner',$package->banner)}}">
                                    @if($errors->has('image'))
                                        <label id="banner-error" class="error" for="banner">{{ $errors->first('banner') }}</label>
                                    @endif
                                    <p><small class="text-muted">Only allowed png format. Image resolution must be 300*200. Max file size allowed : 2MB</small></p>
                                    @if(!empty($package->banner) && File::exists(public_path("assets/images/packagebanner/".$package->banner)))
                                        <div class="mt-25">
                                            <img src="{{ asset('assets/images/packagebanner') }}/{{ $package->banner }}" class="rounded" width="100px">
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                    <div class="form-line">
                                        <label class="form-label">Discount Value</label>
                                        <input type="text" class="form-control @if($errors->has('discount_value')) is-invalid @endif" name="discount_value" value="{{old('discount_value',$package->discount_value)}}">
                                        @if($errors->has('discount_value'))
                                            <label id="name-error" class="error" for="discount_value">{{ $errors->first('discount_value') }}</label>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="form-label">Discount Type</label>
                                        <select name="discount_type" class="form-control select-box">
                                            <option value="" selected>Select Discount Type</option>
                                            <option value="1" {{ old('discount_type',$package->discount_type) == 1 ? 'selected':''}}>Percentage</option>
                                            <option value="2" {{ old('discount_type',$package->discount_type) == 2 ? 'selected':''}}>Value</option>
                                        </select>
                                        @if($errors->has('discount_type'))
                                            <label id="name-error" class="error" for="discount_type">{{ $errors->first('discount_type') }}</label>
                                        @endif
                                    </div>
                                </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <label class="form-label">More Description</label>
                                    <textarea class="form-control @if($errors->has('more_description')) is-invalid @endif" name="more_description" id="more_description">{{old('more_description',$package->more_description)}}</textarea>
                                    @if($errors->has('more_description'))
                                        <label id="more_description-error" class="error" for="more_description">{{ $errors->first('more_description')}}</label>
                                    @endif
                                    <p><small class="text-muted">Max file size allowed : 500Kb.</small></p>
                                </div>
                            </div>
                            <div class="form-group">
                                    <div class="form-line">
                                        <label class="form-label">Minimum Require</label>
                                        <input type="text" class="form-control @if($errors->has('minimum_require')) is-invalid @endif" name="minimum_require" value="{{old('minimum_require',$package->minimum_require)}}">
                                        @if($errors->has('minimum_require'))
                                            <label id="name-error" class="error" for="minimum_require">{{ $errors->first('minimum_require') }}</label>
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
<script src="{{ asset('assets/admin-assets/js/plugin/toaster/toastr.min.js') }}"></script>
    <!-- END: Page Vendor JS-->

<script>
    $(".select2").select2({
        // the following code is used to disable x-scrollbar when click in select input and
        // take 100% width in responsive also
        dropdownAutoWidth: true,
        width: '100%'
    });
    $(".select-category").select2({
        placeholder: "Select Category",
        dropdownAutoWidth: true,
        width: '100%'
    });
    $(".select-subcategory").select2({
        placeholder: "Select Subcategory",
        dropdownAutoWidth: true,
        width: '100%'
    });
    $(".select-service").select2({
        placeholder: "Select Service",
        dropdownAutoWidth: true,
        width: '100%'
    });
    $(".select-city").select2({
        placeholder: "Select City",
        dropdownAutoWidth: true,
        width: '100%'
    });
    // $(".multi-select").select2({
    //     //maximumSelectionLength: 2
    // });

    $(".select-box").select2({
        // the following code is used to disable x-scrollbar when click in select input and
        // take 100% width in responsive also
        dropdownAutoWidth: true,
        width: '100%'
    });

    $('#fp_category_id').on('change', function () {
    // console.log(e);
    var cat_id = $(this).val();
    var _token = $("#form_franchise_package input[name='_token']").val();
    //console.log(cat_id);
    //ajax
    var package_id = '';
    if($('#package_id').length){
        package_id = $('#package_id').val();
    }
        $.ajax({
            url: "{{route('franchise-package-sub')}}",
            type: 'POST',
            data: { cat_id: cat_id, _token: _token, package_id:package_id },
            success: function (data) {
                $('#fp_sub_category_id').empty();
                $('#fp_sub_category_id').append('<option value ="">Select Sub Category</option>');
                $.each(data, function (inedx, subcatObj) {
                    //console.log(subcatObj.title);
                    $('#fp_sub_category_id').append('<option value ="' + subcatObj.id + '" '+(subcatObj.selected ?'selected':'')+'>' + subcatObj.title + '</option>');
                });
            }
        });

    });



    $('#fp_sub_category_id').on('change', function () {
        // console.log(e);
        var cat_id = $(this).val();
        var _token = $("#form_franchise_package input[name='_token']").val();
        //console.log(cat_id);
        //ajax
        var package_id = '';
        if($('#package_id').length){
            package_id = $('#package_id').val();
        }

        $.ajax({
            url: "{{route('franchise-package-service')}}",
            type: 'POST',
            data: { cat_id: cat_id, _token: _token,package_id:package_id },
            success: function (data) {
                
                $('#p_service_id').empty();
                $('#p_service_id').append('<option value ="">Select Sub Category</option>');
                $.each(data, function (inedx, subcatObj) {
                    //console.log(subcatObj.title);
                    $('#p_service_id').append('<option value ="' + subcatObj.id + '" '+(subcatObj.selected ?'selected':'')+'>' + subcatObj.title + '</option>');
                });
            }
        });

    });


    $(document).ready(function() {
        $('#more_description').summernote({
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
        $('#form_franchise_package').submit(function(){
            content = $('#description').summernote('code');
            $('#description').val(content);
        });
    });
</script>

@endsection
