@extends('layouts.front')
@section('content')

<section class="user-dashbord">
    <div class="container">
        @include('layouts.flash-message')
        <div class="row">
            <div class="col-lg-4">
                <div class="user-profile-info-area">
                    @include('includes.front.dashboard-links')
                </div>
            </div>

            <div class="col-lg-8">
                <div class="user-profile-details">
                    <div class="account-info">
                        <div class="header-area">
                            <h4 class="title">
                                Edit Profile
                            </h4>
                        </div>
                        <div class="edit-info-area">

                            <div class="body">
                                <div class="edit-info-area-form">
                                    <div class="gocover" style="background: url({{asset('assets/images/'.$gs->loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);">
                                    </div>
                                    <form id="userform" action="{{route('user_profile_edit')}}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <div class="alert alert-success validation" style="display: none;">
                                            <button type="button" class="close alert-close"><span>×</span></button>
                                            <p class="text-left"></p>
                                        </div>
                                        <div class="alert alert-danger validation" style="display: none;">
                                            <button type="button" class="close alert-close"><span>×</span></button>
                                            <ul class="text-left">
                                            </ul>
                                        </div>
                                        <div class="upload-img">
                                            <div class="img"><img src="{{asset('assets/images/' . ($user->photo ? 'users/'.$user->photo : 'profile.png'))}}">
                                            </div>
                                            <div class="file-upload-area">
                                                <div class="upload-file">
                                                    <input type="file" name="photo" class="upload">
                                                    <span>Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <input name="name" type="text" class="input-field" placeholder="Name" value="{{old('name',$user->name)}}">
                                                @error('name')
                                                <label id="name-error" class="error" for="name">{{ $message }}</label>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <input name="email" type="email" class="input-field" placeholder="Email Address" value="{{old('email',$user->email)}}">
                                                @error('email')
                                                <label id="email-error" class="error" for="email">{{ $message }}</label>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <input name="phone" type="text" class="input-field" placeholder="Phone Number" value="{{old('phone',$user->phone)}}">
                                                @error('phone')
                                                <label id="phone-error" class="error" for="phone">{{ $message }}</label>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <input name="zip" type="text" class="input-field" placeholder="Zip" value="{{old('zip',$user->zip)}}">
                                            </div>
                                        </div>
                                        <div class="row">


                                            <div class="col-lg-6">
                                                <select class="input-field" name="country" id="country">
                                                    <option value="">Select Country</option>
                                                    @foreach($countries as $country)
                                                    <option value="{{$country->id}}" {{old('country',$user->country) == $country->id ? 'selected':''}}>{{$country->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-6">
                                                <select class="input-field" name="state" id="state">
                                                    <option value="">Select State</option>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="row">

                                            <div class="col-lg-6">
                                                <select class="input-field" name="city" id="city">
                                                    <option value="">Select City</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-6">
                                                <textarea class="input-field" name="address" placeholder="Address">{{old('address',$user->address)}}</textarea>
                                            </div>

                                        </div>

                                        <div class="form-links">
                                            <button class="submit-btn" type="submit">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>

    $('#country').on('change', function () {
        // console.log(e);
        var country_id = $(this).val();
        if(country_id){
            $.ajax({
                url: "{{route('ajax_state_from_country')}}",
                type: 'POST',
                data: { country_id: country_id, "_token": "{{ csrf_token() }}", },
                success: function (data) {
                    $('#state').empty();
                    $('#state').append('<option value ="">Select State</option>');
                    $.each(data, function (inedx, subcatObj) {
                        $('#state').append('<option value ="' + subcatObj.id + '">' + subcatObj.name + '</option>');
                    });
                    $('#state').val("{{old('state',$user->state)}}");
                    $('#state').trigger('change');
                }
            });
        }else{
            $('#state').empty();
            $('#state').append('<option value ="">Select State</option>');
        }

    });

    $('#state').on('change', function () {
        // console.log(e);
        var state_id = $(this).val();
        if(state_id){
            $.ajax({
                url: "{{route('ajax_city_from_state')}}",
                type: 'POST',
                data: { state_id: state_id, "_token": "{{ csrf_token() }}", },
                success: function (data) {
                    $('#city').empty();
                    $('#city').append('<option value ="">Select City</option>');
                    $.each(data, function (inedx, subcatObj) {
                        $('#city').append('<option value ="' + subcatObj.id + '">' + subcatObj.name + '</option>');
                    });

                    $('#city').val("{{old('city',$user->city)}}");
                }
            });
        }else{
            $('#city').empty();
            $('#city').append('<option value ="">Select City</option>');
        }
    });

    $(document).ready(function(){
        $('#country').trigger('change');
    })


    $(".upload").on( "change", function() {
        var imgpath = $(this).parent().parent().prev().find('img');
        var file = $(this);
        readURL(this,imgpath);
    });

    function readURL(input,imgpath) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                imgpath.attr('src',e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
