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
                    <h5 class="content-header-title float-left pr-1 mb-0">Payment</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active"><a href="{{ route('payments.index') }}">Payment</a>
                            </li>
                            <li class="breadcrumb-item">Add Payment
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
                            <h4 class="card-title">Add Payment</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                            <form id="form_validation" method="POST" action="{{ route('payments.store') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}                        
                                <div class="form-group">
                                    <!-- <div class="form-line"> -->
                                        <label class="form-label">Payment Type</label>
                                        <select class="form-control @if($errors->has('type')) is-invalid @endif select2" name="type">
                                            <option value="">Select Type</option>
                                            <option value="1" {{old('type')==1?'selected':''}}>Debit</option>
                                            <option value="2" {{old('type')==2?'selected':''}}>Credit</option>
                                        </select>
                                        @if($errors->has('type'))
                                            <label id="name-error" class="error" for="type">{{ $errors->first('type') }}</label>
                                        @endif
                                    </div>
                                <!-- </div> -->
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="form-label">Frenchise</label>
                                        <select class="form-control @if($errors->has('franchise_id')) is-invalid @endif select2" name="franchise_id">
                                            <option value="">Select Frenchise</option>
                                            @foreach($franchises as $f => $franchise)
                                            <option value="{{$f}}" {{old('franchise_id')==$f?'selected':''}}>{{$franchise}}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('franchise_id'))
                                            <label id="name-error" class="error" for="franchise_id">{{ $errors->first('franchise_id') }}</label>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="form-label">Amount</label>
                                        <input type="text" class="form-control @if($errors->has('amount')) is-invalid @endif" name="amount" value="{{old('amount')}}">
                                        @if($errors->has('amount'))
                                            <label id="name-error" class="error" for="amount">{{ $errors->first('amount') }}</label>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="form-label">Patment Date</label>
                                        <input type="text" class="form-control @if($errors->has('payment_date')) is-invalid @endif datepicker" name="payment_date" value="{{old('payment_date')}}" autocomplete="off">
                                        @if($errors->has('payment_date'))
                                            <label id="name-error" class="error" for="payment_date">{{ $errors->first('payment_date') }}</label>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="form-label">Remarks</label>
                                        <textarea name="remarks" class="form-control @if($errors->has('remarks')) is-invalid @endif" id="" rows="5">{{old('remarks')}}</textarea>
                                        @if($errors->has('remarks'))
                                            <label id="remarks-error" class="error" for="remarks">{{ $errors->first('remarks') }}</label>
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

<script src="{{ asset('assets/admin-assets/app-assets/vendors/js/pickers/daterange/moment.min.js') }}"></script>
<script src="{{ asset('assets/admin-assets/app-assets/vendors/js/pickers/daterange/daterangepicker.js') }}"></script>

<script type="text/javascript">


$(function () {
    $('.datepicker').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        locale: {
          format: 'DD/MM/YYYY'
        },
         autoUpdateInput: true, 
    });
});

    $(".select2").select2({
        // the following code is used to disable x-scrollbar when click in select input and
        // take 100% width in responsive also
        dropdownAutoWidth: true,
        width: '100%'
    });
    
</script>
@endsection
