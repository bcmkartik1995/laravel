@extends('layouts.admin')

@section('content')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h5 class="content-header-title float-left pr-1 mb-0">Custome Plans</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active">Custome Plans
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.flash-message')
        <!-- Add rows table -->
        <section id="basic-vertical-layouts">
            <div class="row match-height">
                <div class="col-md-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Custom Credit Plan</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form id="form_validation" method="POST" action="{{ route('custome-plan.store') }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <div class="form-line">
                                                    <label class="form-label"></label>
                                                    <div class="checkbox">
                                                        <input type="hidden" name="is_custom" value="0" />
                                                        <input type="checkbox" name="is_custom" class="checkbox-input global_check" id="checkbox1" value="1" {{old('is_custom') ? 'checked':''}}>
                                                        <label for="checkbox1">Please Check If You Want To Purchase Custome Plan.</label>
                                                    </div>
                                                    @if($errors->has('is_custom'))
                                                        <label id="name-error" class="error" for="is_custom">{{ $errors->first('is_custom') }}</label>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="credit_plan form-group">
                                                <div class="form-line">
                                                <label class="form-label">Credit Plans</label>
                                                    <select name="plan_id" id="plan_id" class="form-control select2">
                                                        <option value="">Select Credit Plans</option>
                                                        @foreach($credit_plans as $credit_plan)
                                                            <option value="{{ $credit_plan->id }}" {{ (old('plan_id') == $credit_plan->id ? 'selected':'') }}>{{ $credit_plan->title }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if($errors->has('plan_id'))
                                                        <label id="name-error" class="error" for="plan_id">{{ $errors->first('plan_id') }}</label>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="franchise form-group">
                                                <div class="form-line">
                                                <label class="form-label">Franchise</label>
                                                    <select name="franchise_id" id="franchise_id" class="form-control select2">
                                                        <option value="">Select Franchise</option>
                                                        @foreach($franchises as $franchise)
                                                            <option value="{{ $franchise->id }}" {{ (old('franchise_id') == $franchise->id ? 'selected':'') }}>{{ $franchise->franchise_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if($errors->has('franchise_id'))
                                                        <label id="name-error" class="error" for="franchise_id">{{ $errors->first('franchise_id') }}</label>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <div class="credit_show">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label class="form-label">Price For One Credit</label>
                                                        <input type="number" class="form-control" id="plan_price" name="price" readonly value="{{number_format($credit_price->price,2,'.','')}}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label class="form-label">Credit</label>
                                                        <input type="number" class="form-control" name="credit" id="credit">
                                                        @if($errors->has('credit'))
                                                            <label id="credit-error" class="error" for="credit">{{ $errors->first('credit') }}</label>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label class="form-label">Amount</label>
                                                        <input type="number" class="form-control" id="plan_amount" name="amount" readonly value="">
                                                        @if($errors->has('amount'))
                                                            <label id="amount-error" class="error" for="amount">{{ $errors->first('amount') }}</label>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary waves-effect mt-1" type="submit">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--/ Add rows table -->
    </div>
</div>

@endsection

@section('scripts')

<script>

$('.global_check').change(function() { 

    if ($(this).is(':checked')) { 

        $('.credit_plan').hide(); 
        $('.credit_show').show();
        $('.credit_plan').val('');
        
    } else {

        $('.credit_plan').show(); 
        $('.credit_show').hide();
        $('.credit_show').val('');
    }

});

$(".select2").select2({
    dropdownAutoWidth: true,
    width: '100%'
});


function calculate_price(){
    credit = plan_price = 0;
    if($('#credit').val()){
        credit = parseFloat($('#credit').val());
    }
    if($('#plan_price').val()){
        plan_price = parseFloat($('#plan_price').val());
    }

    plan_amount = credit*plan_price;
    $('#plan_amount').val(plan_amount.toFixed(2));
}

$('#credit').blur(function(){
    calculate_price();
});

    
$(document).ready(function(){
    $('.global_check').trigger('change');
});
</script>

@endsection
