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
                    <h5 class="content-header-title float-left pr-1 mb-0">Franchise User</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active"><a href="{{ route('franchise-user-view') }}">Franchise User</a>
                            </li>
                            <li class="breadcrumb-item">Edit Franchise User
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
                            <h4 class="card-title">Edit Franchise User</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                            <form id="form_franchise_user" method="POST" action="{{ route('franchise-user-update',$franchise_user->id) }}" enctype="multipart/form-data">
                            {{ csrf_field() }}

                                    <div class="form-group">
                                        <div class="form-line">
                                            <label class="form-label">Name</label>
                                            <input type="text" class="form-control @if($errors->has('name')) is-invalid @endif" name="name" value="{{old('name',$franchise_user->name)}}">
                                            @if($errors->has('name'))
                                                <label id="name-error" class="error" for="name">{{ $errors->first('name') }}</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label class="form-label">Email</label>
                                            <input type="text" class="form-control @if($errors->has('email')) is-invalid @endif" name="email" value="{{old('email',$franchise_user->email)}}">
                                            @if($errors->has('email'))
                                                <label id="name-error" class="error" for="email">{{ $errors->first('email') }}</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label class="form-label">phone</label>
                                            <input type="text" class="form-control @if($errors->has('phone')) is-invalid @endif" name="phone" value="{{old('phone',$franchise_user->phone )}}">
                                            @if($errors->has('phone'))
                                                <label id="name-error" class="error" for="phone">{{ $errors->first('phone') }}</label>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label class="form-label">Profile Pic</label>
                                            
                                            <input type="file" class="form-control @if($errors->has('photo')) is-invalid @endif" name="photo" value="{{old('photo',$franchise_user->photo )}}">
                                            @if($errors->has('photo'))
                                                <label id="photo-error" class="error" for="photo">{{ $errors->first('photo') }}</label>
                                            @endif
                                            @if(!empty($franchise_user->photo) && File::exists(public_path("assets/images/admins/".$franchise_user->photo)))
                                                <div class="mt-25">
                                                    <img src="{{ asset('assets/images/admins') }}/{{ $franchise_user->photo }}" class="rounded" width="100px">
                                                </div>
                                            @endif
                                            
                                        </div>
                                    </div>
                                        
                                        
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label class="form-label">Role</label>
                                            <select class="form-control select2" name="role_id">
                                                <option value="">Select Role</option>
                                                @foreach(DB::table('roles')->get() as $dta)
                                                    <option value="{{ $dta->id }}" {{ old('role_id',$franchise_user->role_id) == $dta->id ? 'selected':''}}>{{ $dta->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>    
                                    </div>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label class="form-label">Password</label>
                                            <input type="password" class="form-control @if($errors->has('password')) is-invalid @endif" name="password" value="{{ $franchise_user->Password }}">
                                            @if($errors->has('password'))
                                                <label id="password-error" class="error" for="password">{{ $errors->first('password') }}</label>
                                            @endif
                                        </div>
                                    </div>

                                <button class="btn btn-primary" type="submit">UPDATE</button>
                            </form>
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
