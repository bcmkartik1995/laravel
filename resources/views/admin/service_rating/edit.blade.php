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
                    <h5 class="content-header-title float-left pr-1 mb-0">Services Ratings</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active"><a href="{{ route('service-rating.index') }}">Services Rating</a>
                            </li>
                            <li class="breadcrumb-item">Edit Services Rating
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
                            <h4 class="card-title">Edit Services Rating</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                            <form id="form_service_rating" method="POST" action="{{ route('service-rating.update',$service_rating->id) }}" enctype="multipart/form-data">
                            {{ method_field('PUT') }}
                            @csrf
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="form-label">Users</label>
                                        <select name="user_id" id="user_id" class="form-control select2">
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ old('user_id',$service_rating->user_id) == $user->id ? 'selected':''}}>{{ $user->name }}</option>
                                        @endforeach
                                        </select>
                                        @error('user_id')
                                            <label id="name-error" class="error" for="category_id">{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="form-label">Service</label>
                                        <select name="service_id" id="service_id" class="form-control select2">
                                        @foreach($services as $service)
                                            <option value="{{ $service->id }}" {{ old('service_id',$service_rating->service_id) == $service->id ? 'selected':''}}>{{ $service->title }}</option>
                                        @endforeach
                                        </select>
                                        @error('service_id')
                                            <label id="name-error" class="error" for="service_id">{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="form-label">Rating</label>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="rate">
                                                        @for($i=5;$i>=1;$i--)
                                                            <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" {{ $service_rating->service_rating <= $i ? 'checked' : ''}}/>
                                                            <label for="star{{ $i }}" title="text">{{ $service_rating->service_rating }} star</label>
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{old('description')}}"> -->
                                        @error('rating')
                                            <label id="name-error" class="error" for="rating">{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="form-label">Comment</label>
                                        <textarea class="form-control @if($errors->has('description')) is-invalid @endif" name="description" id="description">{{old('description',$service_rating->description)}}</textarea>
                                        @if($errors->has('description'))
                                            <label id="description-error" class="error" for="description">{{ $errors->first('description')}}</label>
                                        @endif
                                        <p><small class="text-muted">Max file size allowed : 500Kb.</small></p>
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
        $('#form_service_rating').submit(function(){
            content = $('#description').summernote('code');
            $('#description').val(content);
        });

        var star_rate = $("input[name=rate]:checked").val();
    });

    $(".select2").select2({
        // the following code is used to disable x-scrollbar when click in select input and
        // take 100% width in responsive also
        dropdownAutoWidth: true,
        width: '100%'
    });
</script>

@endsection
