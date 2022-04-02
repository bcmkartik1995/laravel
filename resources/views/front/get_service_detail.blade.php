@php
    use Carbon\Carbon;
@endphp
<div class="detail-container">
    @if(isset($serve))
        @if($serve->service_media->count() > 0)
                <div class="test-slider services-slider">
                    <div class="owl-carousel owl-theme">
                @foreach($serve->service_media as $service_media)
                <div class="item">
                    <div class="ser-img-small">
                        @php
                            $ext = strtolower(pathinfo(asset('assets/images/servicemedia/'.$service_media->media), PATHINFO_EXTENSION));
                        @endphp
                        @if(in_array($ext, $image_formats))
                        <a class="fancybox" href="{{asset('assets/images/servicemedia/'.$service_media->media)}}" data-fancybox="service-detail-gallery-{{$serve->id}}">
                            <img class="" src="{{asset('assets/images/servicemedia/'.$service_media->media)}}" alt="">
                        </a>
                        @else
                            <a class="fancybox1" href="{{asset('assets/images/servicemedia/'.$service_media->media)}}" data-fancybox="service-detail-gallery-{{$serve->id}}">
                            <video controls width="100%" height="250px" class="">
                                <source src="{{asset('assets/images/servicemedia/'.$service_media->media)}}" type="video/mp4">
                              </video>
                            </a>
                        @endif
                    </div>
                </div>
                @endforeach
                    </div>
                </div>
            <div class="row">
                <div class="col-12">

                <div class="sidebar-detail-title d-flex align-items-center justify-content-between">
                    <h5 class="mt-0 pt-2 service-contain">{{$serve->title}}</h5>
                    <div>
                        <p class="mb-0 d-inline rs-text font-weight-bold">₹{{$serve->price}}</p>
                        {{-- <p class="d-inline rs-text ">₹{{$serve->price}}</p> --}}
                    </div>
                </div>
                    <div class="str-img">
                        <i class="fa fa-star text-warning"></i>
                        <p class="clr-text d-inline ">{{$serve->review_avg ? round($serve->review_avg,2) : 0}}</p>
                        <p class="mb-0 d-inline rs-rate">({{$serve->review_count}} ratings)</p>
                    </div>

                    <div class="view-detail-time">
                        <i class="fa fa-clock-o d-inline f-icons" aria-hidden="true"></i>
                        <p class=" d-inline">Estimated Time : {{($serve->hour*60) + $serve->minute}} min</p>
                    </div>
                </div>
            </div>
        @else
                <div class="test-slider services-slider">
                    <div class="owl-carousel owl-theme">
                @foreach($serve->service_media as $service_media)
                    <div class="item">
                        <div class="ser-img-small">
                            @php
                                $ext = strtolower(pathinfo(asset('assets/images/servicemedia/'.$service_media->media), PATHINFO_EXTENSION));
                            @endphp
                            @if(in_array($ext, $image_formats))
                                <a class="fancybox" href="{{asset('assets/images/servicemedia/'.$service_media->media)}}" data-fancybox="service-detail-gallery-{{$serve->id}}">
                                    <img class="" src="{{asset('assets/images/servicemedia/'.$service_media->media)}}" alt="">
                                </a>
                            @else
                                <a class="fancybox1" href="{{asset('assets/images/servicemedia/'.$service_media->media)}}" data-fancybox="service-detail-gallery-{{$serve->id}}">
                                <video controls width="100%" height="auto" class="">
                                    <source src="{{asset('assets/images/servicemedia/'.$service_media->media)}}" type="video/mp4">
                                </video>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
                </div> </div>
                <div class="col-12">

                   <div class="sidebar-detail-title d-flex align-items-center justify-content-between">
                    <h5 class="mt-0 pt-2 service-contain">{{$serve->title}}</h5>
                        <div>
                            <p class="mb-0 d-inline rs-text font-weight-bold">₹{{$serve->price}}</p>
                            {{-- <p class="d-inline rs-text ">₹{{$serve->price}}</p> --}}
                        </div>
                   </div>
                    <div class="str-img">
                        <i class="fa fa-star text-warning"></i>
                        <p class="clr-text d-inline ">{{$serve->review_avg ? round($serve->review_avg,2) : 0}} </p>
                        <p class="mb-0 d-inline rs-rate">({{$serve->review_count}} ratings)</p>
                    </div>

                    <div class="view-detail-time">
                        <i class="fa fa-clock-o d-inline f-icons" aria-hidden="true"></i>
                        <p class=" d-inline">Estimated Time : {{($serve->hour*60) + $serve->minute}} min</p>
                    </div>
                </div>

            </div>
        @endif
        <div class="row services-view-list p-0 pt-3">
            <div class="col-md-12">
                <div class="services-view-list p-0">
                    {!! $serve->description !!}
                </div>
            </div>
        </div>
        @if($service_specifications->count())
            <div class="specification">
                <h5 class="ser-top mb-3">Specifications</h5>
                @foreach($service_specifications as $k => $specification)

                <div class="row specification-items shadow-sm">
                    @if($k%2 == 0)
                        <div class="col-lg-3 col-md-4 col-sm-12 col-12">
                            <div class="s-img">
                                <a class="fancybox" href="{{asset('assets/images/service_specifications/'.$specification->filename)}}" data-fancybox="service-specification-gallery-{{$serve->id}}">
                                <img class="" src="{{asset('assets/images/service_specifications/'.$specification->filename)}}" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-8  col-sm-12 col-12">
                            <div class="s-detail">
                                <p class="mb-0 ser-sub-detail">{{$specification->title}}</p>
                                <p class="ser-sub-detail1">{!! $specification->description !!}</p>
                            </div>
                        </div>
                    @else
                        <div class="col-lg-9 col-md-8 col-sm-12  col-12">
                            <div class="s-detail">
                                <p class="mb-0 ser-sub-detail">{{$specification->title}}</p>
                                <p class="ser-sub-detail1">{!! $specification->description !!}</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-12 col-12">
                            <div class="s-img">
                                <a class="fancybox" href="{{asset('assets/images/service_specifications/'.$specification->filename)}}" data-fancybox="service-specification-gallery-{{$serve->id}}">
                                    <img class="" src="{{asset('assets/images/service_specifications/'.$specification->filename)}}" alt="">
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
                @if($service_specifications->count()-1 != $k)
                    <div class="row d-none">
                        <div class="col-md-12">
                            <div class="bs-ln-first px-3 boxes"></div>
                        </div>
                    </div>
                @endif
                @endforeach
            </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="services-view-list p-0">
                    {!! $serve->long_description !!}
                </div>
            </div>
        </div>

        @if($serve->faqs->count())
            <h5 class="ser-top my-3">Frequently Asked Questions</h5>

            <div id="accordion">
                @foreach ($serve->faqs as $faq)
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="sel-add">
                                <div class="btn-home">
                                    <a class="btn-sub-home d-block" data-toggle="collapse" href="#collapseExample-{{$faq->id}}" role="button" aria-expanded="false" aria-controls="collapseExample">
                                    {{$faq->question}}
                                        <i class="fas fa-chevron-down down-img"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="collapse" id="collapseExample-{{$faq->id}}" data-parent="#accordion">
                                <div class="sel-add">
                                    <div class="form-check rd-text">
                                        {!! $faq->answer !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if($serve->services_ratings->count())
            <h5 class="ser-top my-3">Most helpful reviews</h5>

            @foreach($serve->services_ratings as $services_rating)
                <div class="row specification-items shadow-sm">
                    <div class="col-md-2">
                        <div class="md-img">
                            <img src="{{asset('assets/images/' . ($services_rating->user->photo ? 'users/'.$services_rating->user->photo : 'profile.png'))}}" alt="profile">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <p class="md-detail mb-0">{{$services_rating->user->name}}</p>
                        <p class="md-sub-nm mb-0">{{!empty($services_rating->user->user_city->name) ? $services_rating->user->user_city->name . ',' : ''}} {{Carbon::parse($services_rating->created_at)->format('d F, Y')}}</p>
                        <p class="md-sub-detail mb-0">{!!$services_rating->description!!} </p>
                    </div>
                    <div class="col-md-2  mt-4">
                        <div class="st-img">
                            <i class="fa fa-star text-warning"></i>
                            <p class="rant-detail d-inline">{{number_format($services_rating->service_rating,1)}}</p>
                        </div>
                    </div>
                </div>
                <div class="row d-none">
                    <div class="col-md-12">
                        <div class="bs-ln-first px-3 boxes"></div>
                    </div>
                </div>
            @endforeach
        @endif


    @elseif (isset($pack))

        @if($pack->package_media->count() > 0)
                <div class="test-slider services-slider">
                    <div class="owl-carousel owl-theme">
                @foreach($pack->package_media as $package_media)
                    <div class="">
                        <div class="ser-img-small">
                            @php
                                $ext = strtolower(pathinfo(asset('assets/images/packagemedia/'.$package_media->media), PATHINFO_EXTENSION));
                            @endphp
                            @if(in_array($ext, $image_formats))
                                <a class="fancybox" href="{{asset('assets/images/packagemedia/'.$package_media->media)}}" data-fancybox="package-detail-gallery-{{$pack->id}}">
                                    <img class="" src="{{asset('assets/images/packagemedia/'.$package_media->media)}}" alt="">
                                </a>
                            @else
                                <a class="fancybox1" href="{{asset('assets/images/packagemedia/'.$package_media->media)}}" data-fancybox="package-detail-gallery-{{$pack->id}}">
                                <video controls width="100%" height="250px" class="">
                                    <source src="{{asset('assets/images/packagemedia/'.$package_media->media)}}" type="video/mp4">
                                </video>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div> </div>
            <div class="row">
                <div class="col-12">

                <div class="sidebar-detail-title d-flex align-items-center justify-content-between">
                    <h5 class="mt-0 pt-2 service-contain">{{$pack->title}}</h5>
                    <div>
                        <p class="mb-0 d-inline rs-text font-weight-bold">₹<span class="detail-discountvalue"></span></p>
                        <p class="d-inline rs-text font-weight-bold">₹<span class="detail-fullvalue"></span></p>
                    </div>
                </div>
                    <div class="str-img">
                        <i class="fa fa-star text-warning"></i>
                        <p class="clr-text d-inline ">{{$pack->review_avg ? round($pack->review_avg,2) : 0}}</p>
                        <p class="mb-0 d-inline rs-rate">({{$pack->review_count}} ratings)</p>
                    </div>

                    <div class="view-detail-time">
                        <i class="fa fa-clock-o d-inline f-icons" aria-hidden="true"></i>
                        <p class=" d-inline">Estimated Time : {{($pack->hour*60) + $pack->minute}} min</p>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
            <div class="test-slider services-slider">
                    <div class="owl-carousel owl-theme">
                @foreach($pack->package_media as $package_media)
                    <div class="col-md-6 pr-2  mt-4  ">
                        <div class="ser-img-small">
                            @php
                                $ext = strtolower(pathinfo(asset('assets/images/packagemedia/'.$package_media->media), PATHINFO_EXTENSION));
                            @endphp
                            @if(in_array($ext, $image_formats))
                                <a class="fancybox" href="{{asset('assets/images/packagemedia/'.$package_media->media)}}" data-fancybox="package-detail-gallery-{{$pack->id}}">
                                    <img class="" src="{{asset('assets/images/packagemedia/'.$package_media->media)}}" alt="">
                                </a>
                            @else
                                <a class="fancybox1" href="{{asset('assets/images/packagemedia/'.$package_media->media)}}" data-fancybox="package-detail-gallery-{{$pack->id}}">
                                <video controls width="100%" height="250px" class="">
                                    <source src="{{asset('assets/images/packagemedia/'.$package_media->media)}}" type="video/mp4">
                                </video>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
                </div>
                </div>
                <div class="col-12">

                <div class="sidebar-detail-title d-flex align-items-center justify-content-between">
                    <h5 class="mt-0 pt-2 service-contain">{{$pack->title}}</h5>
                    <div>
                        <p class="mb-0 d-inline rs-text font-weight-bold">₹<span class="detail-discountvalue"></span></p>
                        <p class="d-inline rs-text font-weight-bold">₹<span class="detail-fullvalue"></span></p>
                    </div>
                </div>
                    <div class="str-img">
                        <i class="fa fa-star text-warning"></i>
                        <p class="clr-text d-inline ">{{$pack->review_avg ? round($pack->review_avg,2) : 0}} </p>
                        <p class="mb-0 d-inline rs-rate">({{$pack->review_count}} ratings)</p>
                    </div>

                    <div class="view-detail-time">
                        <i class="fa fa-clock-o d-inline f-icons" aria-hidden="true"></i>
                        <p class=" d-inline">Estimated Time : {{($pack->hour*60) + $pack->minute}} min</p>
                    </div>
                </div>

            </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="services-view-list p-0">
                    {!! $pack->description !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                {!! $pack->long_description !!}
            </div>
        </div>

        @if($pack->packages_ratings->count())
            <h5 class="ser-top my-3">Most helpful reviews</h5>

            @foreach($pack->packages_ratings as $packages_rating)
                <div class="row specification-items shadow-sm align-items-start">
                    <div class="col-md-2 col-sm-2 col-2">
                        <div class="md-img">
                            <img src="{{asset('assets/images/' . ($packages_rating->user->photo ? 'users/'.$packages_rating->user->photo : 'profile.png'))}}" alt="profile">
                        </div>
                    </div>
                    <div class="col-md-10 col-sm-10 col-10 te-disp">
                        <p class="md-detail mb-0">{{$packages_rating->user->name}}</p>
                        <p class="md-sub-nm mb-0">{{!empty($packages_rating->user->user_city->name) ? $packages_rating->user->user_city->name.',' : ''}} {{Carbon::parse($packages_rating->created_at)->format('d M, Y')}}</p>
                        <p class="md-sub-detail mb-0">{!!$packages_rating->description!!} </p>
                        <div class="st-img">
                            <i class="fa fa-star text-warning"></i>
                            <p class="rant-detail d-inline">{{number_format($packages_rating->package_rating,1)}}</p>
                        </div>
                    </div>

                </div>
                <div class="row d-none">
                    <div class="col-md-12">
                        <div class="bs-ln-first px-3 boxes"></div>
                    </div>
                </div>
            @endforeach
        @endif

    @endif
</div>
<script>
     $(document).ready(function(){
        $('.services-slider .owl-carousel').owlCarousel({
            loop:true,
            margin:10,
            nav:false,
            dots:false,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:1
                },
                1000:{
                    items:1
                }
            }
        });
	});
</script>