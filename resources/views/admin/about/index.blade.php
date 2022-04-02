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
                    <h5 class="content-header-title float-left pr-1 mb-0">About us</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active">About us
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.flash-message')
        <!-- Add rows table -->

        <!-- First section start -->
            <section id="basic-vertical-layouts">
                <div class="row match-height">
                    <div class="col-md-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">First Section</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                <form id="form_section1" method="POST" action="{{ route('about.store') }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                        <input type="hidden" name="type" value="section1">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="form-label">Title</label>
                                                <input type="text" class="form-control @if($errors->has('section1_title')) is-invalid @endif" name="section1_title" value="{{old('section1_title',isset($about->section1_title) ? $about->section1_title : '' )}}">
                                                @if($errors->has('section1_title'))
                                                    <label id="name-error" class="error" for="section1_title">{{ $errors->first('section1_title') }}</label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="form-label">Description</label>
                                                <textarea class="form-control @if($errors->has('section1_description')) is-invalid @endif" name="section1_description" id="section1_description">{{old('section1_description',isset($about->section1_description) ? $about->section1_description : '' )}}</textarea>
                                                @if($errors->has('section1_description'))
                                                    <label id="section1_description-error" class="error" for="section1_description">{{ $errors->first('section1_description') }}</label>
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
        <!-- First section end -->

        <!-- mission section start -->
            <section id="basic-vertical-layouts">
                <div class="row match-height">
                    <div class="col-md-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Mission Section</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                <form id="form_mission" method="POST" action="{{ route('about.store') }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                        <input type="hidden" name="type" value="mission_section">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="form-label">Title</label>
                                                <input type="text" class="form-control @if($errors->has('mission_title')) is-invalid @endif" name="mission_title" value="{{old('mission_title',isset($about->mission_title) ? $about->mission_title : '' )}}">
                                                @if($errors->has('mission_title'))
                                                    <label id="mission_title-error" class="error" for="mission_title">{{ $errors->first('mission_title') }}</label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="form-label">Description</label>
                                                <textarea class="form-control @if($errors->has('mission_description')) is-invalid @endif" name="mission_description" id="mission_description">{{old('mission_description',isset($about->mission_description) ? $about->mission_description : '' )}}</textarea>
                                                @if($errors->has('mission_description'))
                                                    <label id="mission_description-error" class="error" for="mission_description">{{ $errors->first('mission_description') }}</label>
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
        <!-- mission section end -->

        <!-- vision section start -->
            <section id="basic-vertical-layouts">
                <div class="row match-height">
                    <div class="col-md-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Vision Section</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                <form id="form_vision" method="POST" action="{{ route('about.store') }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="type" value="vision_section">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="form-label">Title</label>
                                                <input type="text" class="form-control @if($errors->has('vision_title')) is-invalid @endif" name="vision_title" value="{{old('vision_title',isset($about->vision_title) ? $about->vision_title : '' )}}">
                                                @if($errors->has('vision_title'))
                                                    <label id="vision_title-error" class="error" for="vision_title">{{ $errors->first('vision_title') }}</label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="form-label">Description</label>
                                                <textarea class="form-control @if($errors->has('vision_description')) is-invalid @endif" name="vision_description" id="vision_description">{{old('vision_description',isset($about->vision_description) ? $about->vision_description : '' )}}</textarea>
                                                @if($errors->has('vision_description'))
                                                    <label id="vision_description-error" class="error" for="vision_description">{{ $errors->first('vision_description') }}</label>
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
        <!-- vision section end -->

        <!-- section 3 section start -->
            <section id="basic-vertical-layouts">
                <div class="row match-height">
                    <div class="col-md-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Who we are Section</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                <form id="form_section3" method="POST" action="{{ route('about.store') }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                        <input type="hidden" name="type" value="section3">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="form-label">Title</label>
                                                <input type="text" class="form-control @if($errors->has('section3_title')) is-invalid @endif" name="section3_title" value="{{old('section3_title',isset($about->section3_title) ? $about->section3_title : '' )}}">
                                                @if($errors->has('section3_title'))
                                                    <label id="section3_title-error" class="error" for="section3_title">{{ $errors->first('section3_title') }}</label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="form-label">Image</label>
                                                <input type="file" class="form-control @if($errors->has('section3_image')) is-invalid @endif" name="section3_image" value="{{old('section3_image',isset($about->section3_image) ? $about->section3_image : '' )}}">
                                                @if($errors->has('section3_image'))
                                                    <label id="section3_image-error" class="error" for="section3_image">{{ $errors->first('section3_image') }}</label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="form-label">Description</label>
                                                <textarea class="form-control @if($errors->has('section3_description')) is-invalid @endif" name="section3_description" id="section3_description">{{old('section3_description',isset($about->section3_description) ? $about->section3_description : '' )}}</textarea>
                                                @if($errors->has('section3_description'))
                                                    <label id="section3_description-error" class="error" for="section3_description">{{ $errors->first('section3_description') }}</label>
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
        <!-- section 3 section end -->

        <!-- Our Team section start -->
        
            <section id="add-row">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Our Team</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                        <a href="{{ route('about.ourteam.create') }}" class="btn btn-primary mb-2"><i class="bx bx-plus"></i>&nbsp; Add new</a>
                                    <div class="table-responsive">
                                        <table class="table tbl-slider">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Name</th>
                                                    <th>Image</th>
                                                    <th>Designation</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($our_team as $team)
                                                    <tr>
                                                        <td>{{ $team->id }}</td>
                                                        <td>{{ $team->name }}</td>
                                                        <td><img src="{{ asset('assets/images/ourteamimg') }}/{{ $team->image }}" alt="" width="55" height="70"></td>
                                                        <td>{{ $team->designation }}</td>
                                                        <td><span class="badge badge-pill badge-light-info status-span-{{ $team->id }}">{{ $team->status==1 ? 'Active': 'Inactive' }}</span></td>
                                                        <td>
                                                            <div style="display:flex;">

                                                                <a href="{{route('about.ourteam.edit',$team->id)}}" class="btn btn-warning btn-sm mr-25">Edit</a>

                                                                <!-- <a href="javascript:void(0);" data-href="{{ route('about.ourteam.delete',$team->id) }}" class="btn btn-danger btn-sm mr-25 delete">Detete</a> -->
                                                            
                                                                <a href="javascript:void(0);" data-id="{{$team->id}}" data-action="ourteam" class="common-toggle-button btn btn-{{$team->status==1?'danger':'success'}} btn-sm"> {{$team->status==1?'InActive':'Active'}}</a>

                                                            </div> 
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        <!-- Our team section end -->
        
        <!--/ Add rows table -->
    </div>   
</div>

@endsection

@section('scripts')

<script src="{{ asset('assets/admin-assets/js/plugin/summernote/summernote-lite.js') }}"></script>

<script>

    $(document).ready(function() {
        $('#section1_description').summernote({
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
                // ['view', ['fullscreen', 'codeview']],
                ['help', ['help']]
            ],
        });
        $('#form_section1').submit(function(){
            content = $('#section1_description').summernote('code');
            $('#section1_description').val(content);
        });

        $('#mission_description').summernote({
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
                // ['view', ['fullscreen', 'codeview']],
                ['help', ['help']]
            ],
        });
        $('#form_mission').submit(function(){
            content = $('#mission_description').summernote('code');
            $('#mission_description').val(content);
        });

        $('#vision_description').summernote({
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
                // ['view', ['fullscreen', 'codeview']],
                ['help', ['help']]
            ],
        });
        $('#form_vision').submit(function(){
            content = $('#vision_description').summernote('code');
            $('#vision_description').val(content);
        });

        $('#section3_description').summernote({
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
                // ['view', ['fullscreen', 'codeview']],
                ['help', ['help']]
            ],
        });
        $('#form_section3').submit(function(){
            content = $('#section3_description').summernote('code');
            $('#section3_description').val(content);
        });

    });


    $('.delete').on('click', function () {
// console.log(e);

    var _token = $("#form_lead input[name='_token']").val();
    var href = $(this).data('href');
    Swal.fire({
        title: 'Are you sure?',
            text: "You will not be able to recover this data!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            confirmButtonClass: 'btn btn-primary',
            cancelButtonClass: 'btn btn-danger ml-1',
            buttonsStyling: false,
    }).then(function (result) {
        if(result.value){
            $.ajax({
                url: href,
                type: 'DELETE',
                dataType:"json",
                data: { _token: "{{ csrf_token() }}" },
                success: function (data) {
                    Swal.fire({
                        title: 'Success',
                        text: data.message,
                        type: "success",
                        showCancelButton: false,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonClass: "btn btn-primary",
                        closeOnConfirm: true,
                    }).then(function (result) {
                        window.location.reload();
                    });
                }
            });
        }
    });
    return false;
    });

    $('.tbl-slider').DataTable({
        autoWidth: false,
        "columnDefs": [{
            "visible": false,
            "targets": 0
        }],
        "order": [
            [0, 'DESC']
        ],
    });
</script>

@endsection
