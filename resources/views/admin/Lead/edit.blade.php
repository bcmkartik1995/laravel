@extends('layouts.admin')

@section('styles')

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h5 class="content-header-title float-left pr-1 mb-0">Lead</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active"><a href="{{ route('lead.index') }}">Lead</a>
                            </li>
                            <li class="breadcrumb-item">Edit Leads
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
                            <h4 class="card-title">Edit Leads</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                            <form id="form_lead" method="POST" action="{{ route('lead.update',$leads->id) }}" enctype="multipart/form-data">
                            {{ method_field('PUT') }}
                            {{ csrf_field() }}
                            <div class="form-group">
                                <div class="form-line">
                                    <label class="form-label">Country</label>
                                    <select name="country_id" id="country_id" class="form-control select2">
                                            <option value="">Select Country</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}" {{ old('country_id',$leads->country_id) == $country->id ? 'selected':''}}>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('country_id'))
                                        <label id="name-error" class="error" for="country_id">{{ $errors->first('country_id') }}</label>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <label class="form-label">State</label>
                                    <select name="state_id" id="state_id" class="form-control select2">
                                        <option value="">Select State</option>
                                    </select>
                                    @if($errors->has('state_id'))
                                        <label id="name-error" class="error" for="state_id">{{ $errors->first('state_id') }}</label>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <label class="form-label">City</label>
                                    <select name="city_id" id="city_id" class="form-control select2">
                                        <option value=""></option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}" {{ old('city_id',$leads->city_id) == $city->id ? 'selected':''}}>{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('city_id'))
                                        <label id="name-error" class="error" for="city_id">{{ $errors->first('city_id') }}</label>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control @if($errors->has('name')) is-invalid @endif" name="name" value="{{old('name',$leads->name)}}">
                                    @if($errors->has('name'))
                                        <label id="name-error" class="error" for="name">{{ $errors->first('name') }}</label>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <label class="form-label">Email</label>
                                    <input type="text" class="form-control @if($errors->has('email')) is-invalid @endif" name="email" value="{{old('email',$leads->email)}}">
                                    @if($errors->has('email'))
                                        <label id="name-error" class="error" for="email">{{ $errors->first('email') }}</label>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <label class="form-label">Mobile Number</label>
                                    <input type="text" class="form-control @if($errors->has('mobile')) is-invalid @endif" name="mobile" value="{{old('mobile',$leads->phone)}}">
                                    @if($errors->has('mobile'))
                                        <label id="name-error" class="error" for="mobile">{{ $errors->first('mobile') }}</label>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <label class="form-label">Skill</label>
                                    <input type="text" class="form-control @if($errors->has('skill')) is-invalid @endif" name="skill" value="{{old('skill',$leads->skill)}}">
                                    @if($errors->has('skill'))
                                        <label id="name-error" class="error" for="skill">{{ $errors->first('skill') }}</label>
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

<script>



$(document).ready(function(){
    $('#country_id').trigger('change');
});


    $('#country_id').on('change', function () {
    // console.log(e);
    var country_id = $(this).val();
    var _token = $("#form_lead input[name='_token']").val();
    //console.log(cat_id);
    //ajax

    $.ajax({
        url: "{{route('ajax-country')}}",
        type: 'POST',
        data: { country_id: country_id, _token: _token },
        success: function (data) {
            $('#state_id').empty();
            $('#state_id').append('<option value ="">Select State</option>');
            $.each(data, function (inedx, subcatObj) {
                //console.log(subcatObj.title);
                select_old = "{{old('state_id',$leads->state_id)}}";
                selected = select_old == subcatObj.id?'selected':'';

                $('#state_id').append('<option value ="' + subcatObj.id + '" '+selected+'>' + subcatObj.name + '</option>');
                //$('#state_id').trigger('change');
            });
        }
    });

});



$('#state_id').on('change', function () {
    // console.log(e);
    var state_id = $(this).val();
    var _token = $("#form_lead input[name='_token']").val();
    //console.log(cat_id);
    //ajax

    $.ajax({
        url: "{{route('ajax-state')}}",
        type: 'POST',
        data: { state_id: state_id, _token: _token },
        success: function (data) {
            $('#city_id').empty();
            $('#city_id').append('<option value ="">Select City</option>');
            $.each(data, function (inedx, subcatObj) {
                //console.log(subcatObj.title);
                select_old = "{{old('city_id',$leads->city_id)}}";
                selected = select_old == subcatObj.id?'selected':'';

                $('#city_id').append('<option value ="' + subcatObj.id + '" '+selected+'>' + subcatObj.name + '</option>');
                
            });
        }
    });

});


$(".select2").select2({
    dropdownAutoWidth: true,
    width: '100%'
});



</script>

@endsection
