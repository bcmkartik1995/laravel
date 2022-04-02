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
                    <h5 class="content-header-title float-left pr-1 mb-0">Best Services</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active"><a href="{{ route('best-service.index') }}">Best Services</a>
                            </li>
                            <li class="breadcrumb-item">Add Best Services
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
                            <h4 class="card-title">Add Best Services</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                            <form id="form_best_service" method="POST" action="{{ route('best-service.store') }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                    <div class="form-group">
                                        <div class="form-line">
                                        <label class="form-label">Service</label>
                                        <select class="form-control select2" name="service_id" id="bs_service_id">
                                            <option value="">Select Service</option>
                                            @foreach($services as $service)
                                                <option value="{{ $service->id }}">{{ $service->title }}</option>
                                            @endforeach
                                        </select>
                                            @if($errors->has('service_id'))
                                                <label id="name-error" class="error" for="service_id">{{ $errors->first('service_id') }}</label>
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

<script>
    $(".select2").select2({
        // the following code is used to disable x-scrollbar when click in select input and
        // take 100% width in responsive also
        dropdownAutoWidth: true,
        width: '100%'
    });
</script>

@endsection

