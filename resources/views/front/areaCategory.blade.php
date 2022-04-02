@extends('layouts.app')

@section('content')
<div class="wrapper ">
    @include('layouts.front.header')



    <div class="section-indent">
        <div class="container container__fluid-xl">
            <div class="blocktitle text-center blocktitle__min-width03">
                <div class="blocktitle__under">Services</div>
                <div class="blocktitle__subtitle">Category</div>
                <div class="blocktitle__title">Easier than You Can Thinh!</div>
                <div class="blocktitle__text blocktitle__text-nopadding">We know that looking for plumbing services can
                    be somewhat of a minefield, especially if you’ve sprung a leak or had a breakdown</div>
            </div>
        </div>

        <div id="tt-pageContent">
            <div class="section-indent6">
                <div class="tt-additional__wrapper">
                    <picture class="tt-additional_img01">
                        <source media="(min-width: 1230px)" srcset="{{ asset('front/images/additional_img01.webp') }}"
                            data-srcset="{{ asset('front/images/additional_img01.webp') }}" type="image/webp">
                        <source media="(min-width: 1230px)" srcset="{{ asset('front/images/additional_img01.png') }}"
                            data-srcset="{{ asset('front/images/additional_img01.png') }}" type="image/png">
                        <source media="(min-width: 768px)" srcset="{{ asset('front/images/additional_img01-md.png') }}"
                            data-srcset="{{ asset('front/images/additional_img01-md.png') }}" type="image/png">
                        <source media="(min-width: 768px)" srcset="{{ asset('front/images/additional_img01-md.webp') }}"
                            data-srcset="{{ asset('front/images/additional_img01-md.webp') }}" type="image/webp">
                        <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                            class=" ls-is-cached lazyloaded" alt="">
                    </picture>
                    <div class="tt-additional__bg01">
                        <div class="tt-additional__bg01-02 lazyloaded" data-bg="{{ asset('front/images/additional_img02.png') }}"
                            style="background-image: url(&quot;{{ asset('front/images/additional_img02.png') }}&quot;);"></div>
                        <div class="tt-additional__bg02">
                            <div class="tt-row01">
                                <div class="tt-col">
                                    <div class="blocktitle text-left">
                                        <div class="blocktitle__subtitle">what else do we offer</div>
                                        <div class="blocktitle__title">Additional Services</div>
                                    </div>
                                </div>
                                <div class="tt-col">We’re committed to providing fast, affordable, reliable, worry free
                                    plumbing and heating services.</div>
                            </div>
                            <div class="swiper-container imgbox-inner__wrapper js-align-layout swiper-container-initialized swiper-container-horizontal swiper-container-autoheight"
                                data-carousel="swiper" data-space-between="30" data-slides-sm="1" data-slides-lg="3"
                                data-slides-xl="3" data-slides-xxl="3.6" data-autoplay-delay="5000">
                                <div class="swiper-wrapper" id="swiper-wrapper-15eef54c1dff8f61" aria-live="off"
                                    style="height: 477px; transform: translate3d(-405px, 0px, 0px); transition-duration: 0ms;">
                                    <div class="swiper-slide swiper-slide-prev" role="group" aria-label="1 / 5"
                                        style="width: 375px; margin-right: 30px;">
                                        <div class="additional js-align-layout__item" style="min-height: 447px;">
                                            <div class="additional__icon icon-694055"><i class="icon-1889287"></i></div>
                                            <h6 class="additional__title">Drain Cleaning</h6>
                                            <p>Our professionals are available 24/7 to perform routine drain maintenance
                                            </p>
                                            <ul class="tt-list tt-list__color01">
                                                <li>Years of mineral built up</li>
                                                <li>Root infested pipes</li>
                                                <li>Foreign objects</li>
                                            </ul>
                                            <a href="services-item03.html" class="tt-btn"><span>Know more</span></a>
                                        </div>
                                    </div>
                                    <div class="swiper-slide swiper-slide-active" role="group" aria-label="2 / 5"
                                        style="width: 375px; margin-right: 30px;">
                                        <div class="additional js-align-layout__item" style="min-height: 447px;">
                                            <div class="additional__icon icon-694055"><i class="icon-2424820"></i></div>
                                            <h6 class="additional__title">Sewer Line Cleaning</h6>
                                            <p>Our technicians are the leading sewer cleaning experts in the industry
                                            </p>
                                            <ul class="tt-list tt-list__color01">
                                                <li>Multiple drains are backed up</li>
                                                <li>Sewage collects in the floor drain</li>
                                                <li>Drains are slow</li>
                                            </ul>
                                            <a href="services-item03.html" class="tt-btn"><span>Know more</span></a>
                                        </div>
                                    </div>
                                    <div class="swiper-slide swiper-slide-next" role="group" aria-label="3 / 5"
                                        style="width: 375px; margin-right: 30px;">
                                        <div class="additional js-align-layout__item" style="min-height: 447px;">
                                            <div class="additional__icon icon-694055"><i class="icon-1677058"></i></div>
                                            <h6 class="additional__title">Water Heater Repair</h6>
                                            <p>We can provide regular maintenance, repairs, and replacements</p>
                                            <ul class="tt-list tt-list__color01">
                                                <li>Diminished Water Quality</li>
                                                <li>Noisy or Loud Water Heater</li>
                                                <li>Visible Leak</li>
                                            </ul>
                                            <a href="services-item03.html" class="tt-btn"><span>Know more</span></a>
                                        </div>
                                    </div>
                                    <div class="swiper-slide" role="group" aria-label="4 / 5"
                                        style="width: 375px; margin-right: 30px;">
                                        <div class="additional js-align-layout__item" style="min-height: 447px;">
                                            <div class="additional__icon icon-694055"><i class="icon-900667"></i></div>
                                            <h6 class="additional__title">Leak Detection</h6>
                                            <p>Water leaks can cause both property damage as well as a financial burden.
                                            </p>
                                            <ul class="tt-list tt-list__color01">
                                                <li>Visible Water Spots Surfacing</li>
                                                <li>Water Bill is Abnormally High</li>
                                                <li>Damp Carpet</li>
                                            </ul>
                                            <a href="services-item02.html" class="tt-btn"><span>Know more</span></a>
                                        </div>
                                    </div>
                                    <div class="swiper-slide" role="group" aria-label="5 / 5"
                                        style="width: 375px; margin-right: 30px;">
                                        <div class="additional js-align-layout__item" style="min-height: 447px;">
                                            <div class="additional__icon icon-694055"><i class="icon-2321403"></i></div>
                                            <h6 class="additional__title">Hot Water System</h6>
                                            <p>Hot water system services are made up of several components.</p>
                                            <ul class="tt-list tt-list__color01">
                                                <li>Electric Hot Water Systems</li>
                                                <li>Instant Hot Water Systems</li>
                                                <li>Gas Hot Water Systems</li>
                                            </ul>
                                            <a href="services-item02.html" class="tt-btn"><span>Know more</span></a>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="swiper-pagination pagination01 swiper-pagination-clickable swiper-pagination-bullets">
                                    <span class="swiper-pagination-bullet" tabindex="0" role="button"
                                        aria-label="Go to slide 1"></span><span
                                        class="swiper-pagination-bullet swiper-pagination-bullet-active" tabindex="0"
                                        role="button" aria-label="Go to slide 2"></span><span
                                        class="swiper-pagination-bullet" tabindex="0" role="button"
                                        aria-label="Go to slide 3"></span></div>
                                <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        @include('layouts.front.footer')
    </div>
    @endsection