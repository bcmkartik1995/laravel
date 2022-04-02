@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/js/plugin/summernote/summernote-lite.css') }}">
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
                            <li class="breadcrumb-item">Send Gift
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
                            <h4 class="card-title">Send Gift</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                            <form id="form_package" method="POST" action="{{ route('send-gift-mail') }}" enctype="multipart/form-data">
                                
                                {{ csrf_field() }}
                                    
                                    <div class="form-group">
                                        <div class="form-line">
                                        <label class="form-label">Gift Card</label>
                                            <select name="gift_card" id="gift_card" class="form-control select-gift">
                                                <option value="">Select Gift Card</option>
                                                @foreach($gifts as $gift)
                                                    <option value="{{ $gift->id }}" {{ (old('gift_card') == $gift->id ? 'selected':'') }}>{{ $gift->title }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('gift_card'))
                                                <label id="gift_card-error" class="error" for="gift_card">{{ $errors->first('gift_card') }}</label>
                                            @endif
                                        </div>
                                    </div>

                                    
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label class="form-label">File</label>
                                            <input type="file" class="form-control @if($errors->has('file')) is-invalid @endif" name="file" value="{{old('file')}}">
                                            @if($errors->has('file'))
                                                <label id="name-error" class="error" for="file">{{ $errors->first('file') }}</label>
                                            @endif
                                            <p><small class="text-muted">Only allowed csv format. Max file size allowed : 2MB</small></p>
                                            <a href="{{ asset('assets/admin-assets/csvfile/sample-gift.csv') }}" download>Click Here To Download Sample CSV File</a>
                                        </div>
                                    </div>
                                    

                                    <div class="form-group">
                                        <div class="form-line">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control @if($errors->has('description')) is-invalid @endif" name="description" id="description">{{old('description')}}</textarea>
                                            @if($errors->has('description'))
                                                <label id="description-error" class="error" for="description">{{ $errors->first('description') }}</label>
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

<script src="{{ asset('assets/admin-assets/js/plugin/summernote/summernote-lite.js') }}"></script>


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
                //['view', ['fullscreen', 'codeview']],
                ['help', ['help']]
            ],
        });

        $(".select-gift").select2({
            // the following code is used to disable x-scrollbar when click in select input and
            // take 100% width in responsive also
            dropdownAutoWidth: true,
            width: '100%'
        });
    });
</script>

@endsection
