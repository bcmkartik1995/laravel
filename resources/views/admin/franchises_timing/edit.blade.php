@extends('layouts.admin')

@section('styles')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/app-assets/vendors/css/pickers/daterange/daterangepicker.css') }}">

@endsection

@section('content')

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h5 class="content-header-title float-left pr-1 mb-0">Franchises Offday</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active"><a href="{{ route('franchises-timing.index') }}">Franchises Offday</a>
                            </li>
                            <li class="breadcrumb-item">Edit Franchises Offday
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
                            <h4 class="card-title">Edit Franchises Offday</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form id="form_franchise_offday" method="POST" action="{{ route('franchises-timing.update',$franchise_offday->id) }}">
                                    {{ method_field('PUT') }}
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{ $franchise_offday->franchises_id }}" name="franchises_id">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="text" name="offdaydate" id="offdaydate" class="form-control datetime  @if($errors->has('offdaydate')) is-invalid @endif" value="{{ $date }}" placeholder="Select Date" autocomplete="off">
                                                <div class="form-control-position">
                                                    <i class='bx bx-calendar-check'></i>
                                                </div>
                                            </fieldset>
                                            @if($errors->has('offdaydate'))
                                                <label id="name-error" class="error" for="offdaydate">{{ $errors->first('offdaydate') }}</label>
                                            @endif
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

<script src="{{ asset('assets/admin-assets/app-assets/vendors/js/pickers/daterange/moment.min.js') }}"></script>
<script src="{{ asset('assets/admin-assets/app-assets/vendors/js/pickers/daterange/daterangepicker.js') }}"></script>


<script>
    $('#offdaydate').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        locale: {
            format: 'DD-MM-YYYY'
        },
        autoUpdateInput: false, 
    }).on("apply.daterangepicker", function (e, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY'));
        //$(this).trigger('change');
    });
</script>

@endsection
