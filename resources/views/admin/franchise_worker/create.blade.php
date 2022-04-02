@extends('layouts.admin')

@section('styles')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/app-assets/vendors/css/forms/select/select2.min.css') }}">

@endsection

@section('content')


<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h5 class="content-header-title float-left pr-1 mb-0">Franchises Worker</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active"><a href="{{ route('franchises-worker.index') }}">Franchises Worker</a>
                            </li>
                            <li class="breadcrumb-item">Add Worker
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
                            <h4 class="card-title">Add Worker</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                            <form id="franchise_subservice" method="POST" action="{{ route('franchises-worker.store') }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                    <input type="text" name="franchises_id" value="{{ $franchises_id->id }}" hidden>

                                    <div class="form-group">
                                        <div class="form-line">
                                        <label class="form-label">Service</label>
                                        <select class="select-service form-control" name="service[]" id="p_service_id" multiple="multiple">
                                            @foreach($services as $service)
                                                <option value="{{ $service->service->id }}" {{!empty(old('service')) && in_array($service->service->id,old('service')) ? 'selected':''}}>{{ $service->service->title }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('service'))
                                            <label id="name-error" class="error" for="service">{{ $errors->first('service') }}</label>
                                        @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label class="form-label">Name</label>
                                            <input type="text" class="form-control @if($errors->has('name')) is-invalid @endif" name="name" value="{{old('name')}}">
                                            @if($errors->has('name'))
                                                <label id="name-error" class="error" for="name">{{ $errors->first('name') }}</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label class="form-label">Email</label>
                                            <input type="text" class="form-control @if($errors->has('email')) is-invalid @endif" name="email" value="{{old('email')}}">
                                            @if($errors->has('email'))
                                                <label id="email-error" class="error" for="email">{{ $errors->first('email') }}</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label class="form-label">Mobile Number</label>
                                            <input type="text" class="form-control @if($errors->has('mobile')) is-invalid @endif" name="mobile" value="{{old('mobile')}}">
                                            @if($errors->has('mobile'))
                                                <label id="mobile-error" class="error" for="mobile">{{ $errors->first('mobile') }}</label>
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

<!-- BEGIN: Page Vendor JS-->
<script src="{{ asset('assets/admin-assets/app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
<!-- END: Page Vendor JS-->

<script>
    $(".select-service").select2({
        placeholder: "Select Service",
        dropdownAutoWidth: true,
        width: '100%'
    });
</script>

@endsection

