@extends('home')

@section('title')
	Permission
@endsection

@section('extra-css')

@endsection

@section('index')

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h5 class="content-header-title float-left pr-1 mb-0">Permission</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active"><a href="{{ route('permissions.index') }}">Permission</a>
                            </li>
                            <li class="breadcrumb-item">Add Permission
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
                            <h4 class="card-title">Add Permission</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                            <form id="form_validation" method="POST" action="{{ route('permissions.store') }}">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="form-label">Permission Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{old('name')}}" required>
                                        @error('name')
                                            <label id="name-error" class="error" for="name">{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input @error('is_heading') is-invalid @enderror is_heading" type="checkbox" name="is_heading" value="1" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Is heading
                                        </label>
                                        @error('is_heading')
                                            <label id="name-error" class="error" for="is_heading">{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group heaing-select">
                                    <div class="form-line">
                                        <label class="form-label">Heading</label>
                                        <select name="parent" id="parent" class="form-control">
                                            <option value="" selected>Select Heading</option>
                                            @foreach($permissions as $permission)
                                                @if($permission->is_heading == 1)
                                                    <option value="{{ $permission->id }}">{{ $permission->name }}</option>+
                                                @endif  
                                            @endforeach
                                        </select>
                                        @error('parent')
                                            <label id="name-error" class="error" for="parent">{{ $message }}</label>
                                        @enderror
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

@section('extra-script')

<script>
    $('.is_heading').change(function() { 
        if ($(this).is(':checked')) { 
            $('.heaing-select').hide();
            $('#parent').val('');
        } else {
            $('.heaing-select').show(); 

        }
    });
</script>

@endsection
