@extends('layouts.admin')

@section('styles')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/app-assets/vendors/css/pickers/pickadate/pickadate.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/app-assets/vendors/css/pickers/daterange/daterangepicker.css') }}">

@endsection

@section('content')


<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">     
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h5 class="content-header-title float-left pr-1 mb-0">Referral Program</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active">Referral Program
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
                            <h4 class="card-title">Referral Program</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form id="form_offer" method="POST" action="{{ route('referral-program.store') }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}

                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="form-label">Referral Value</label>
                                                <input type="text" class="form-control @if($errors->has('referral_value')) is-invalid @endif" name="referral_value" value="{{old('referral_value',isset($referral_programs->referral_value) ?$referral_programs->referral_value:'')}}">
                                                @if($errors->has('referral_value'))
                                                    <label id="name-error" class="error" for="referral_value">{{ $errors->first('referral_value') }}</label>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="form-label">max_value</label>
                                                <input type="text" class="form-control @if($errors->has('max_value')) is-invalid @endif" name="max_value" value="{{old('max_value',isset($referral_programs->max_value) ?$referral_programs->max_value:'')}}">
                                                @if($errors->has('max_value'))
                                                    <label id="name-error" class="error" for="max_value">{{ $errors->first('max_value') }}</label>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="form-line">
                                                <div class="checkbox">
                                                    <input type="hidden" name="status" value="0" />
                                                    <input type="checkbox" name="status" class="checkbox-input global_check" id="checkbox1" value="1" {{ old('status',$referral_programs->status == 1 ?'checked':'') }}>
                                                    <label for="checkbox1">Please check to activate this program</label>
                                                </div>
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

<script src="{{ asset('assets/admin-assets/app-assets/vendors/js/pickers/daterange/moment.min.js') }}"></script>
<script src="{{ asset('assets/admin-assets/app-assets/vendors/js/pickers/daterange/daterangepicker.js') }}"></script>

<script src="{{ asset('assets/admin-assets/app-assets/vendors/js/pickers/pickadate/picker.js') }}"></script>
<script src="{{ asset('assets/admin-assets/app-assets/vendors/js/pickers/pickadate/picker.time.js') }}"></script>
<!-- END: Page Vendor JS-->

<script>

    $('.pickatime').pickatime();


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


    $('.delete').on('click', function () {
    // console.log(e);

    var _token = '{{ csrf_token() }}';
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

    $('.tbl-franchise-offday').DataTable({
        autoWidth: false,
        "columnDefs": [{
            "visible": false,
            "targets": 0
        }],
        "order": [
            [0, 'DESC']
        ],
    });

    $('[type="checkbox"]').on('change', function() {
        var my_day = $(this).attr('data-day');
        
        if (!this.checked) {
            $('.valcler_'+my_day).val('');
        }
    });
</script>

@endsection
