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
                    <h5 class="content-header-title float-left pr-1 mb-0">Franchises Offer</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active"><a href="{{ route('franchises-offer.index') }}">Franchises Offer</a>
                            </li>
                            <li class="breadcrumb-item">Edit Offer
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
                            <h4 class="card-title">Edit Offer</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                            <form id="form_offer" method="POST" action="{{ route('franchises-offer.update',$offers->id) }}" enctype="multipart/form-data">
                                {{ method_field('PUT') }}
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="form-label">Global Offer</label>
                                                <div class="checkbox">
                                                    <input type="hidden" name="is_global" value="0" />
                                                    <input type="checkbox" name="is_global" class="checkbox-input global_check" id="checkbox1" value="1" {{ $offers->is_global == 1 ? 'checked' : '' }}>
                                                    <label for="checkbox1">Please check if you want to assign this offer to all services.</label>
                                                </div>
                                                @if($errors->has('is_global'))
                                                    <label id="name-error" class="error" for="is_global">{{ $errors->first('category_id') }}</label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="global_subCategory form-group">
                                            <div class="form-line">
                                            <label class="form-label">Sub Category</label>
                                                <select name="sub_category_id" id="o_sub_category_id" class="form-control select-box">
                                                    @foreach($subcategory as $subcate)
                                                        <option value="{{ $subcate->id }}" {{ old('sub_category_id',$offers->sub_category_id) == $subcate->id ? 'selected':''}}>{{ $subcate->title }}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('sub_category_id'))
                                                    <label id="name-error" class="error" for="sub_category_id">{{ $errors->first('sub_category_id') }}</label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="form-label">Title</label>
                                                <input type="text" class="form-control @if($errors->has('title')) is-invalid @endif" name="title" value="{{old('title',$offers->title)}}">
                                                @if($errors->has('title'))
                                                    <label id="name-error" class="error" for="title">{{ $errors->first('title') }}</label>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label class="form-label">Start Date</label>
                                                        <input type="date" class="form-control @if($errors->has('start_date')) is-invalid @endif" name="start_date" value="{{old('start_date',$offers->start_date)}}">
                                                        @if($errors->has('start_date'))
                                                            <label id="name-error" class="error" for="start_date">{{ $errors->first('start_date') }}</label>
                                                        @endif
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label class="form-label">End Date</label>
                                                        <input type="date" class="form-control @if($errors->has('end_date')) is-invalid @endif" name="end_date" value="{{old('end_date',$offers->end_date)}}">
                                                        @if($errors->has('end_date'))
                                                            <label id="name-error" class="error" for="end_date">{{ $errors->first('end_date') }}</label>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="form-label">Max Value</label>
                                                <input type="text" class="form-control @if($errors->has('max_value')) is-invalid @endif" name="max_value" value="{{old('max_value',$offers->max_value)}}">
                                                @if($errors->has('max_value'))
                                                    <label id="name-error" class="error" for="max_value">{{ $errors->first('max_value') }}</label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="form-label">Offer Code</label>
                                                <input type="text" class="form-control @if($errors->has('offer_code')) is-invalid @endif" name="offer_code" value="{{old('offer_code',$offers->offer_code)}}">
                                                @if($errors->has('offer_code'))
                                                    <label id="name-error" class="error" for="offer_code">{{ $errors->first('offer_code') }}</label>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="form-label">Specific User</label>
                                                <div class="checkbox">
                                                    <input type="hidden" name="is_user_specific" value="0" />
                                                    <input type="checkbox" name="is_user_specific" class="checkbox-input user_checkbox" id="checkbox2" value="{{ $offers->is_user_specific }}" {{ $offers->is_user_specific == 1 ? 'checked' : '' }}>
                                                    <label for="checkbox2">Please check if you want to assign this offer to Selected Users.</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="user_select2 form-group">
                                            <div class="form-line">    
                                                
                                                <select class="form-control select2" name="user_specific[]" id="offer_user" multiple>
                                                    @foreach($users as $user)
                                                        <option value="{{ $user->id }}" {{in_array($user->id,$users_existing)?'selected':''}}>{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('user_specific'))
                                                    <label id="name-error" class="error" for="user_specific">{{ $errors->first('user_specific') }}</label>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    

                                    <div class="col-md-6">
                                        <div class="global_category form-group">
                                            <div class="form-line">
                                            <label class="form-label">Category</label>
                                                <select name="category_id" id="o_category_id" class="form-control select-box">
                                                    <option value="">Select Category</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}" {{ old('category_id',$offers->category_id) == $category->id ? 'selected':''}}>{{ $category->title }}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('category_id'))
                                                    <label id="name-error" class="error" for="category_id">{{ $errors->first('category_id') }}</label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="global_service form-group">
                                            <div class="form-line">
                                                <label class="form-label">Service</label>
                                                <select class="multi-select form-control select-box" name="service_id" id="o_service_id">
                                                    @foreach($services as $service)
                                                        <option value="{{ $service->id }}" {{ old('service_id',$offers->service_id) == $service->id ? 'selected':''}}>{{ $service->title }}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('service_id'))
                                                    <label id="name-error" class="error" for="service_id">{{ $errors->first('service_id') }}</label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="form-label">Offer Value</label>
                                                <input type="text" class="form-control @if($errors->has('offer_value')) is-invalid @endif" name="offer_value" value="{{old('offer_value',$offers->offer_value)}}">
                                                @if($errors->has('offer_value'))
                                                    <label id="name-error" class="error" for="offer_value">{{ $errors->first('offer_value') }}</label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="form-label">Offer Type</label>
                                                <select name="offer_type" class="form-control select-box">
                                                    <option value="" selected>Select Discount Type</option>
                                                    <option value="1" {{ old('offer_type',$offers->offer_type) == 1 ? 'selected':''}}>Percentage</option>
                                                    <option value="2" {{ old('offer_type',$offers->offer_type) == 2 ? 'selected':''}}>Value</option>
                                                </select>
                                                @if($errors->has('offer_type'))
                                                    <label id="name-error" class="error" for="offer_type">{{ $errors->first('offer_type') }}</label>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="form-label">Description</label>
                                                <textarea class="form-control @if($errors->has('description')) is-invalid @endif" name="description" id="description">{{old('description',$offers->description)}}</textarea>
                                                @if($errors->has('description'))
                                                    <label id="description-error" class="error" for="description">{{ $errors->first('description')}}</label>
                                                @endif
                                                <p><small class="text-muted">Max file size allowed : 500Kb.</small></p>
                                            </div>
                                        </div>
                                        
                                    
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
        $('#form_offer').submit(function(){
            content = $('#description').summernote('code');
            $('#description').val(content);
        });
    });



    $(".select2").select2({
        // the following code is used to disable x-scrollbar when click in select input and
        // take 100% width in responsive also
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

    $('#o_category_id').on('change', function () {
        // console.log(e);
        var cat_id = $(this).val();
        var _token = $("#form_offer input[name='_token']").val();
        //console.log(cat_id);
        //ajax
        $.ajax({
            url: "{{ route('franchise-offer-subcat') }}",
            type: 'POST',
            data: { cat_id: cat_id, _token: _token },
            success: function (data) {
                $('#o_sub_category_id').empty();
                $('#o_sub_category_id').append('<option value ="">Select Sub Category</option>');
                $.each(data, function (inedx, subcatObj) {
                    //console.log(subcatObj.title);
                    select_old = "{{old('sub_category_id',$offers->sub_category_id)}}";
                    selected = select_old == subcatObj.id?'selected':'';
                    $('#o_sub_category_id').append('<option value ="' + subcatObj.id + '" '+selected+'>' + subcatObj.title + '</option>');
                    $('#o_sub_category_id').trigger('change');
                });
            }
        });

    });

    $(document).ready(function(){
        $('#o_category_id').trigger('change');
    });


    $('#o_sub_category_id').on('change', function () {
        // console.log(e);
        var cat_id = $(this).val();
        var _token = $("#form_offer input[name='_token']").val();
        //console.log(cat_id);
        //ajax

        $.ajax({
            url: "{{route('franchise-offer-service')}}",
            type: 'POST',
            data: { cat_id: cat_id, _token: _token },
            success: function (data) {
                
                $('#o_service_id').empty();
                $('#o_service_id').append('<option value ="">Select Sub Category</option>');
                $.each(data, function (inedx, subcatObj) {
                    //console.log(subcatObj.title);
                    select_old = "{{old('service_id',$offers->service_id)}}";
                    selected = select_old == subcatObj.id?'selected':'';
                    $('#o_service_id').append('<option value ="' + subcatObj.id + '" '+selected+'>' + subcatObj.title + '</option>');
                });
            }
        });

    });


$('.global_check').change(function() { 

    if ($(this).is(':checked')) { 

        $('.global_category').hide(); 
        $('.global_subCategory').hide(); 
        $('.global_service').hide();
        
    } else {

    $('.global_category').show(); 
    $('.global_subCategory').show(); 
    $('.global_service').show();
      //$('.global_check select').hide(); 
    }

});
// $('.user_select2 select').hide();
    $('.user_checkbox').change(function() { 

        if ($(this).is(':checked')) { 
            
            $('.user_select2').show(); 
            $("#offer_user").select2({
                
            });
        } else {
            $('.user_select2').hide(); 
        }
    
    });
$(document).ready(function(){
    
    $('.global_check').trigger('change');
    $('.user_checkbox').trigger('change');

    
});


</script>


@endsection
