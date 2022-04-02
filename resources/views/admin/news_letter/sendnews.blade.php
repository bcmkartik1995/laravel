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
                    <h5 class="content-header-title float-left pr-1 mb-0">News Letter</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active"><a href="{{ route('news-letter.index') }}">News Letter</a>
                            </li>
                            <li class="breadcrumb-item">Send News Letter
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.flash-message')
        <!-- Basic Vertical form layout section start -->
        <section id="basic-vertical-layouts">
            <div class="row match-height">
                <div class="col-md-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Send News Letter</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                            <form id="form_package" method="POST" action="{{ route('news-letter.store') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                                    
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="form-label">Send Mail All User</label>
                                        <div class="checkbox">
                                            <input type="hidden" name="all_user" value="0"/>
                                            <input type="checkbox" name="all_user" class="checkbox-input all_user_check" id="checkbox1" value="1" {{old('all_user') ? 'checked':''}}>
                                            <label for="checkbox1">Please Check If you Want To Send Mail All Users.</label>
                                        </div>
                                        @if($errors->has('all_user'))
                                            <label id="name-error" class="error" for="all_user">{{ $errors->first('all_user') }}</label>
                                        @endif
                                    </div>
                                </div>

                                <div class="global_mail form-group">
                                    <div class="form-line">
                                    <label class="form-label">Mails</label>
                                        <select name="mails[]" id="mails" class="form-control select-mail" multiple="multiple">
                                            <option value="">Select Mail</option>
                                            @foreach($news_letters as $news_letter)
                                                <option value="{{ $news_letter->email }}" {{ !empty(old('mails')) && in_array($news_letter->email ,old('mails')) ? 'selected':'' }}>{{ $news_letter->email }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('mails'))
                                            <label id="name-error" class="error" for="mails">{{ $errors->first('mails') }}</label>
                                        @endif
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

<script src="{{ asset('assets/admin-assets/app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/admin-assets/js/plugin/summernote/summernote-lite.js') }}"></script>
<script src="{{ asset('assets/admin-assets/js/plugin/toaster/toastr.min.js') }}"></script>


<script>
    $(document).ready(function() {
        $(".select-mail").select2({
            placeholder: "Select Mail",
            dropdownAutoWidth: true,
            width: '100%'
        });
        
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

        $('.all_user_check').change(function() { 

            if ($(this).is(':checked')) { 
                $('.global_mail').hide(); 
            } else {
                $('.global_mail').show(); 
            }

        });

        $('.all_user_check').trigger('change');

    });


    


</script>

@endsection
