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
                    <h5 class="content-header-title float-left pr-1 mb-0">Franchises Service</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active"><a href="{{ route('franchises-service.index') }}">Franchises Service</a>
                            </li>
                            <li class="breadcrumb-item">Edit Service
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
                            <h4 class="card-title">Edit Service</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                            <form id="franchise_subservice" method="POST" action="{{ route('franchises-service.update',$service->id) }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input name="_method" type="hidden" value="PUT">
                            
                            <input type="text" name="franchises_id" value="{{ $service->franchise_id }}" hidden>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="form-label">Title</label>
                                        <input type="text" class="form-control @if($errors->has('title')) is-invalid @endif" name="title" value="{{old('title',$service->service->title)}}" readonly>
                                    </div>
                                </div>
                                @php
                                    $hours_arr = range(0,24);
                                    $minute_arr = range(0,59);
                                @endphp
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="form-label">Hours</label>
                                                <select name="hour" id="hour" class="form-control select-box">
                                                    <option value="" selected>Select Hours</option>
                                                    @foreach($hours_arr as $hour)
                                                    <option value="{{$hour}}" {{"$hour" == old('hour',$service->hour)?'selected':''}}>{{$hour}}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('hour'))
                                                    <label id="name-error" class="error" for="hour">{{ $errors->first('hour') }}</label>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="form-label">Minute</label>
                                                <select name="minute" id="minute" class="form-control select-box">
                                                    <option value="" selected>Select Minute</option>
                                                    @foreach($minute_arr as $minute)
                                                    <option value="{{$minute}}" {{"$minute" == old('minute',$service->minute)?'selected':''}}>{{$minute}}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('minute'))
                                                    <label id="name-error" class="error" for="minute">{{ $errors->first('minute') }}</label>
                                                @endif
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
<!-- END: Page Vendor JS-->

<script>
    $(".select2").select2({
        // the following code is used to disable x-scrollbar when click in select input and
        // take 100% width in responsive also
        dropdownAutoWidth: true,
        width: '100%'
    });
    // $(".multi-select").select2({
    //     //maximumSelectionLength: 2
    // });

    $('#category_id').on('change', function () {
    // console.log(e);
    var cat_id = $(this).val();
    var _token = $("#franchise_subservice input[name='_token']").val();
    //console.log(cat_id);
    //ajax
        
        $.ajax({
            url: "{{route('franchise-subcat')}}",
            type: 'POST',
            data: { cat_id: cat_id, _token: _token },
            success: function (data) {
                $('#sub_category_id').empty();
                $('#sub_category_id').append('<option value ="">Selecr Sub Category</option>');
                $.each(data, function (inedx, subcatObj) {
                    //console.log(subcatObj.title);
                    $('#sub_category_id').append('<option value ="' + subcatObj.id + '">' + subcatObj.title + '</option>');
                });
            }
        });

    });

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
                //['view', ['fullscreen', 'codeview']],
                ['help', ['help']]
            ],
        });

        $('#long_description').summernote({
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
                //['view', ['fullscreen', 'codeview']],
                ['help', ['help']]
            ],
        });
    });

    $(".select-box").select2({
        // the following code is used to disable x-scrollbar when click in select input and
        // take 100% width in responsive also
        dropdownAutoWidth: true,
        width: '100%'
    });
</script>

@endsection
