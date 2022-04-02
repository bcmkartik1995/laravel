@extends('layouts.admin')

@section('styles')

@endsection

@section('content')


<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h5 class="content-header-title float-left pr-1 mb-0">Sub Categories</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active"><a href="{{ route('sub-categories.index') }}">Sub Categories</a>
                            </li>
                            <li class="breadcrumb-item">Edit Sub Categories
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
                            <h4 class="card-title">Edit Sub Categories</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                            <form id="form_validation" method="POST" action="{{ route('sub-categories.update',$subcategory->id) }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <div class="form-line">
                                        <input name="_method" type="hidden" value="PUT">
                                        <label class="form-label">Title</label>
                                        <input type="text" class="form-control @if($errors->has('title')) is-invalid @endif" name="title" value="{{old('title',$subcategory->title)}}">
                                        @if($errors->has('title'))
                                            <label id="name-error" class="error" for="title">{{ $errors->first('title') }}</label>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                        <div class="form-line">
                                            <label class="form-label">Category</label>
                                            <select name="category_id" class="form-control select2">
                                                <option value="">Select Category</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ old('category_id',$subcategory->category_id) == $category->id ? 'selected':''}}>{{ $category->title }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('category_id'))
                                                <label id="name-error" class="error" for="category_id">{{ $errors->first('category_id') }}</label>
                                            @endif
                                        </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input name="_method" type="hidden" value="PUT">
                                        <label class="form-label">Logo</label>
                                        <input type="file" class="form-control @if($errors->has('logo')) is-invalid @endif" name="logo" value="{{old('logo',$subcategory->logo)}}">
                                        @if($errors->has('logo'))
                                            <label id="name-error" class="error" for="logo">{{ $errors->first('logo') }}</label>
                                        @endif
                                        <p><small class="text-muted">Only allowed png format. Image resolution must be 64*64. Max file size allowed : 2MB</small></p>
                                        @if(!empty($subcategory->logo) && File::exists(public_path("assets/images/subcategorylogo/".$subcategory->logo)))
                                            <div class="mt-25">
                                                <img src="{{ asset('assets/images/subcategorylogo') }}/{{ $subcategory->logo }}" class="rounded" width="50">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                {{--<!-- <div class="form-group">
                                    <div class="form-line">
                                        <input name="_method" type="hidden" value="PUT">
                                        <label class="form-label">Note</label>
                                        <input type="text" class="form-control @if($errors->has('note')) is-invalid @endif" name="note" value="{{ $subcategory->note }}">
                                        @if($errors->has('note'))
                                            <label id="name-error" class="error" for="note">{{ $errors->first('note') }}</label>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input name="_method" type="hidden" value="PUT">
                                        <label class="form-label">Sub Note</label>
                                        <input type="text" class="form-control @if($errors->has('subnote')) is-invalid @endif" name="subnote" value="{{ $subcategory->sub_note }}">
                                        @if($errors->has('subnote'))
                                            <label id="name-error" class="error" for="subnote">{{ $errors->first('subnote') }}</label>
                                        @endif
                                    </div>
                                </div> -->--}}
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

<script>
    $(".select2").select2({
        // the following code is used to disable x-scrollbar when click in select input and
        // take 100% width in responsive also
        dropdownAutoWidth: true,
        width: '100%'
    });
</script>

@endsection