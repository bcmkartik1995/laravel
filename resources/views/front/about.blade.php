@extends('layouts.front')

@section('content')
<div class="about-section ">
    <div class="container mt-5 mb-5">
        <!-- <div class="bg-white rounded "> -->
        <!-- <div class="row who-we-r mb-5">
            <div class="col-12 ">
                <h2 class="about-head-sub mb-0 title-contain">Who we are</h2>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 about-sub"> 
                <div class="about-sub-text">
                    <p class="about-detail">
                        VELOX SOLUTION was launched in November 2019. It is the largest home services platform in Asia, with presence in India.The platform helps customer’s book reliable home services like beauty services, massage therapy, cleaning, plumbing, carpentry, appliance repair, painting etc. The company's vision is to empower millions of service professionals across the world to deliver services at home like never seen before. The company partners with tens of thousands of service professionals, helping them with training, credit, product procurement, insurance, technology etc.
                    </p>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 ">
                <div class="about-img">
                    <img src="http://localhost/multiauth/public/assets/front-assets/images/about.png">
                </div>
            </div>
        </div> -->


        <!-- {{-- <div class="row mt-4 service-detail">
            <div class="col-12 col-md-4 col-sm-12">
                <div class="service-texts text-center">
                     <h5 class="service-sub-text">Inspect & Analyze</h5>
                </div>
            </div>
            <div class="col-12 col-md-4 col-sm-12">
                <div class="service-texts text-center">
                    <h5 class="service-sub-text">Quote & Supply Service</h5>
                </div>
            </div>
            <div class="col-12 col-md-4 col-sm-12">
                <div class="service-texts text-center">
                    <h5 class="service-sub-text">Clean Up & Finish</h5>
                </div>
            </div>
        </div> --}}
 -->

        <!-- <div class="row">
            <div class="col-12">
                <div class="about-text mt-3">
                    <h2 class="about-head-sub mb-0 title-contain">How We do it</h2>
                </div>
                <div class="row mb-5">
                    <div class="col-md-4 col-sm-12 col-12 mt-4">
                        <div class="process-box mb-3">
                            <div class="process-img">
                                <img src="http://localhost/multiauth/public/assets/front-assets/images/search2.png" alt="">
                            </div>
                            <h5 class="mt-0 mb-3 fid-ser-sub-txt">Find Your Service</h5>
                            <p class="oreder-sub-detail mb-0">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Atque dicta dignissimos. </p>
                        </div>      
                    </div>
                    <div class="col-md-4 col-sm-12 col-12 mt-4">
                        <div class="process-box mb-3">
                            <div class="process-img">
                                <img src="http://localhost/multiauth/public/assets/front-assets/images/service3.png" alt="">
                            </div>
                            <h5 class="mt-0 mb-3 fid-ser-sub-txt">Choose Your Services Options</h5>
                            <p class="oreder-sub-detail mb-0">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Atque dicta dignissimos. </p>
                        </div>      
                    </div>
                    <div class="col-md-4 col-sm-12 col-12 mt-4">
                        <div class="process-box mb-3">
                            <div class="process-img">
                                <img src="http://localhost/multiauth/public/assets/front-assets/images/enjoy3.png" alt="">
                            </div>
                            <h5 class="mt-0 mb-3 fid-ser-sub-txt">Enjoy Your Service</h5>
                            <p class="oreder-sub-detail mb-0">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Atque dicta dignissimos. </p>
                        </div>      
                    </div>
                </div>
            </div>
        </div> -->

        <!-- <div class="row">
            <div class="col-12">
                <div class="about-detail">
                    <div class="about-text text-center mt-3">
                        <h2 class="about-head-sub mb-0 title-contain">Our Leadership Team</h2>
                    </div>
                    <div class="about-sub-text">
                        <div></div>
                    </div>
                </div>
            </div>
        </div> -->

</div>

        <div class="container">
            <div class="about-title text-center pb-3">
                <h1 class="mb-0 pb-2">{{ $Aboutus->section1_title }}</h1>
                <p class="px-5 pt-2 mx-5">{!! $Aboutus->section1_description !!}</p>
            </div>
        </div>

        <div  class="about-mv py-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-12 d-flex">
                        <div class="about-mv-left text-center py-5 rounded">
                            <h3>{{ $Aboutus->mission_title }}</h3>
                            <p class="mb-0 px-3">{!! $Aboutus->mission_description !!}</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="about-mv-left text-center py-5 rounded">
                            <h3>{{ $Aboutus->vision_title }}</h3>
                            <p class="mb-0 px-3">{!! $Aboutus->vision_description !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mt-5">
            <div class="row mb-5"> 
                <div class="col-md-6 company-detail">
                <h2 class="title-contain">{{ $Aboutus->section3_title }}</h2>
                    <p>{!! $Aboutus->section3_description !!}</p>
                    <!-- <div class="mt-4">
                        <a class="sub-btn-book" href="#">Read More</a>
                            <a class="sub-btn-book" href="#">Our Services</a>
                        </div>
                        -->
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="about-img">
                            <img class="img-fluid" src="{{asset('assets/images/whoweareimg/'.$Aboutus->section3_image)}}" style="width:100%;">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="count-section mb-4 bg-05">
        <div class="count-pds">
            <div class="container">
                <div class="row ">
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="counter">
                            <div class="counter-icon pb-2">
                                <img src="{{asset('assets/front-assets/images/statistics/icon-1.png') }}" width=46>
                           </div>
                            <span class="counter-value">{{ $services_count }}</span>
                            <h3>Services</h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="counter">
                            <div class="counter-icon pb-2">
                                <img src="{{asset('assets/front-assets/images/statistics/icon-3.png') }}" width=46>
                           </div>
                            <span class="counter-value">15</span>
                            <h3>City</h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="counter">
                            <div class="counter-icon pb-2">
                                <img src="{{asset('assets/front-assets/images/statistics/icon-2.png') }}" width=46>
                           </div>
                            <span class="counter-value">22</span>
                            <h3>Franchises</h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 mx-auto">
                        <div class="counter">
                            <div class="counter-icon pb-2">
                                <img src="{{asset('assets/front-assets/images/statistics/icon-4.png') }}" width=46>
                           </div>
                            <span class="counter-value">150</span>
                            <h3>Happy Customer</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="team-title py-4">
            <h2 class="title-contain">Meet Our Team</h2>
        </div>
        <div class="tem-wrapper pb-5">
            <div class="row">
                @foreach($our_team as $team)
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="team-member text-center shadow-sm">
                            <img src="{{ asset('assets/images/ourteamimg') }}/{{ $team->image }}" alt="" title="" class="w-100"/>
                            <h4>{{ $team->name }}</h4>
                            <p>{{ $team->designation }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
       

    <!-- <div class="counter-inner">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-center">
                        <h4 class="mission-text">"Our Mission is to empower millions of service professionals by delivering services </h4>
                        <h4 class="mission-text">at-home in a way that has never been experienced before."</h4>
                        <h4 class="mission-text">- Velox Solution</h4>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
@endsection

@section('scripts')



@endsection
