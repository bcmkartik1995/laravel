@extends('layouts.front')

@section('content')

<div class="erp-section py-5">
    <div class="container">
        <h2 class="title-contain">Easy Register Process</h2>
        <div class="erp-steps pt-4">
            <ul class="row">
                <li>
                    <div class="erp-step-number">
                        <div class="erp-number-icon">
                            <span class="erp-icon-no-1">1</span>
                        </div>
                    </div>
                    <div class="erp-step-content text-center mt-3">
                        <h5>Feel The Form</h5>
                        <p>First of all you give us what you are doing In which category you are the best ever in the world.</p>
                    </div>
                </li>
                <li>
                    <div class="erp-step-number">
                        <div class="erp-number-icon">
                            <span>2</span>
                        </div>
                    </div>
                    <div class="erp-step-content text-center mt-3">
                        <h5>Call From Our HR team</h5>
                        <p>Our hr team will call you and get the perfect and full details about your franchise worker and etc.</p>
                    </div>
                </li>
                <li>
                    <div class="erp-step-number">
                        <div class="erp-number-icon">
                            <span>3</span>
                        </div>
                    </div>
                    <div class="erp-step-content text-center mt-3">
                        <h5>Document Verified</h5>
                        <p>Document verification process for the customer and your safety to help both of you.</p>
                    </div>
                </li>
                <li>
                    <div class="erp-step-number">
                        <div class="erp-number-icon">
                            <span class="erp-icon-no-4">4</span>
                        </div>
                    </div>
                    <div class="erp-step-content text-center mt-3">
                        <h5>Enjoy your Franchise </h5>
                        <p>Enjoy your franchise with orders and help your customers to give them full fill services.</p>
                    </div>
                </li>
            </ul>
        </div>
        <div class="row pt-4">
            <div class="col-md-12">
                <div class="text-center">
                    <h4 class="mission-text">Now Our Franchise first Easy registration verification and get the order and earn more income and give the satisfaction to our valuable customers</h4>
                    <h4 class="mission-text">For Franchise Query  : <a href="tel:+91 90 818 818 89">+91 90 818 818 89</a></h4>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="rp-form my-5 py-3">
    <div class="container">
        <div class="row position-relative">
            <div class="col-md-6">
                <div class="rp-form-img">
                    <img src="{{asset('assets/front-assets/images/golden-sunset_181624-18805.jpg')}}" alt="" title="" class="img-fluid"/>
                </div>
            </div>
            <div class="rp-form-content shadow py-3">
                <h2 class="title-contain">Register as a Professional</h2>
                <h5>Join 1500+ partners across India</h5>
                    @include('layouts.flash-message')
                    <form action="{{ route('registerprofessional') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <label>Full Name</label>
                                    <input type="text" class="form-control in-first" id="professional_name" name="name" placeholder="Enter your name" value="{{old('name')}}">
                                    @error('name')
                                        <label id="professional_name-error" class="error" for="professional_name">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <label>Mobile Number</label>
                                    <input type="tel" class="form-control in-first" placeholder="Enter your phone " id="professional_phone" name="phone" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" value="{{old('phone')}}">
                                    @error('phone')
                                        <label id="professional_phone-error" class="error" for="professional_phone">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <label>Email Address</label>
                                    <input type="email" placeholder="Email" id="professional_email" name="email" class="form-control in-first" value="{{old('email')}}">
                                    @error('email')
                                    <label id="professional_email-error" class="error" for="professional_email">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 ">
                                    <label>Select Country</label>
                                    <select id="country_id" name="country_id" class="custom-select mr-sm-2 in-first country" data-value="{{old('country_id')}}">
                                        <option value="">Select Country</option>
                                         @foreach($country as $countries)
                                        <option value="{{ $countries->id }}" {{old('country_id') == $countries->id ? 'selected':''}}>{{ $countries->name }}</option>
                                         @endforeach
                                    </select>

                                    @error('country_id')
                                    <label id="country_id-error" class="error" for="country_id">{{ $message }}</label>
                                    @enderror
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-6 ">
                                    <label>Select State</label>
                                    <select id="state_id" name="state_id" class="custom-select in-first state" data-value="{{old('state_id')}}">
                                    <option value="">Select State</option>
                                    </select>
                                    @error('state_id')
                                    <label id="state_id-error" class="error" for="state_id">{{ $message }}</label>
                                    @enderror
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <label>Select City</label>
                                    <select id="city_id" name="city_id" class="custom-select in-first city"  data-value="{{old('city_id')}}">
                                    <option value="">Select City</option>
                                    </select>
                                    @error('city_id')
                                    <label id="city_id-error" class="error" for="city_id">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                <label>Message</label>
                                <textarea class="form-control in-first" id="skill" name="skill" rows="4" placeholder="What do you do?" style="height:auto;" >{{old('skill')}}</textarea>
                                    @error('skill')
                                        <label id="skill-error" class="error" for="skill">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                        </div><div class="form-group"></div>
                        <div class="form-row text-center">
                                <button class="btn-reg d-block w-100 bg-dark" type="submit">Submit </button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>

<div class="bg-05 py-5 rp-section">
    <div class="container">
        <h2 class="title-contain">Benefits for Vendors</h2>
        <div class="row pb-5 pt-3 justify-content-center" style="padding:0px 100px;">
            <div class="col-lg-4 col-md-4 col-sm-6 col-12 d-flex mb-4">
                <div class="rp-card shadow-sm rounded-top">
                    <div class="rp-image">
                        <img src="{{asset('assets/front-assets/images/ragister-as-professional/no-marketing.jpg')}}" alt="" title=""  class="img-fluid w-100 "/>
                    </div>
                    <div class="rp-content text-center p-3 py-4">
                        <h4>No Marketing</h4>
                        <p>They get continue work With us without any own marketing </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-12 d-flex mb-4">
                <div class="rp-card  shadow-sm">
                    <div class="rp-image">
                        <img src="{{asset('assets/front-assets/images/ragister-as-professional/more-money.jpg')}}" alt="" title="" class="img-fluid w-100" />
                    </div>
                    <div class="rp-content  text-center p-3 py-4">
                        <h4>More Money</h4>
                        <p>They can earn more Income with us. </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-12 d-flex mb-4">
                <div class="rp-card shadow-sm">
                    <div class="rp-image">
                        <img src="{{asset('assets/front-assets/images/ragister-as-professional/servies-products-kit.jpg')}}" alt="" title="" class="img-fluid w-100" />
                    </div>
                    <div class="rp-content  text-center p-3 py-4">
                        <h4>Service Products Kit</h4>
                        <p>We take care of their all needs for professional products </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-12 d-flex mb-4">
                <div class="rp-card shadow-sm">
                    <div class="rp-image">
                        <img src="{{asset('assets/front-assets/images/ragister-as-professional/professional-training.jpg')}}" alt="" title="" class="img-fluid w-100" />
                    </div>
                    <div class="rp-content  text-center p-3 py-4">
                        <h4>Professional Training</h4>
                        <p>We give them training for best performance.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-12 d-flex mb-4">
                <div class="rp-card shadow-sm">
                    <div class="rp-image">
                        <img src="{{asset('assets/front-assets/images/ragister-as-professional/enjoy-your-job.jpg')}}" alt="" title="" class="img-fluid w-100" />
                    </div>
                    <div class="rp-content  text-center p-3 py-4">
                        <h4>Enjoy Your Job</h4>
                        <p>You can work parttime or full time as your need.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-12 d-flex mb-4">
                <div class="rp-card shadow-sm">
                    <div class="rp-image">
                        <img src="{{asset('assets/front-assets/images/ragister-as-professional/dont-search.jpg')}}" alt="" title="" class="img-fluid w-100" />
                    </div>
                    <div class="rp-content  text-center p-3 py-4">
                        <h4>Don't Search </h4>
                        <p>You don't need to find work for you VELOX SOLUTION give you work and all detail about your work.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-12 d-flex mb-4">
                <div class="rp-card shadow-sm">
                    <div class="rp-image">
                        <img src="{{asset('assets/front-assets/images/ragister-as-professional/just-do-work.jpg')}}" alt="" title="" class="img-fluid w-100" />
                    </div>
                    <div class="rp-content  text-center p-3 py-4">
                        <h4>Just Do Work</h4>
                        <p>You just only follow company's lead and service there</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-12 d-flex mb-4">
                <div class="rp-card shadow-sm">
                    <div class="rp-image">
                        <img src="{{asset('assets/front-assets/images/ragister-as-professional/free-insurance.jpg')}}" alt="" title="" class="img-fluid w-100" />
                    </div>
                    <div class="rp-content  text-center p-3 py-4">
                        <h4>Free Insurance</h4>
                        <p>Velox solution covers all vendors by Free accidental insurance. </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>






@endsection

@section('scripts')
    <script type="text/javascript">
        $('.country').change(function(){
            var country_id = $('.country').val();

            if(country_id){
                $.ajax({
                    url : '{{ url("/getState") }}',
                    type : 'POST',
                    data : {
                        country_id: country_id,
                    _token: '{{csrf_token()}}'
                    },
                    dataType : 'json',
                    success : function(result) {

                        $('.state').empty();
                        $('.state').append('<option value ="">Select State </option>');
                        $.each(result.states, function (key, value) {
                            selected = '';
                            if($('.state').data('value') && $('.state').data('value') == value.id){
                            selected = 'selected';
                            }
                            $('.state').append('<option value ="' + value.id + '" '+selected+'>' + value.name + '</option>');
                        });

                        if($('.state').data('value')){
                            $('.state').trigger('change');
                        }
                    }
                });
            }else{
                $('.state').empty();
                $('.state').append('<option value ="">Select State </option>');
                $('.city').empty();
                $('.city').append('<option value ="">Select City </option>');
            }
        });
        $('.state').change(function(){
            var state_id = $('.state').val();
            if(state_id){
                $.ajax({
                url : '{{ url("/getCity") }}',
                type : 'POST',
                data : {
                    state_id: state_id,
                _token: '{{csrf_token()}}'
                },
                dataType : 'json',
                success : function(result)  {
                    $('.city').empty();
                    $('.city').append('<option value ="">Select City </option>');
                    $.each(result.city, function (key, value) {
                        selected = '';
                        if($('.city').data('value') && $('.city').data('value') == value.id){
                            selected = 'selected';
                            }
                        $('.city').append('<option value ="' + value.id + '" '+selected+'>' + value.name + '</option>');
                    });
                }
                });
            }else{
                $('.city').empty();
                $('.city').append('<option value ="">Select City </option>');
            }
        });
        $(document).ready(function(){
            $('.country').trigger('change');
        });
    </script>


@endsection
