@extends('layouts.front')

@section('content')
<div id="tt-pageContent">
<div class="section-indent05"style="margin-top: 0px;">
<div class="fullwidth-promo init-parallax lazyload" data-bg="{{ asset('front/images/bg-01.jpg')}} ">
<div class="fullwidth-promo__indent-01">
<div class="tt-icon">
   <i class="icon-154518"></i></div>
<div class="tt-title">Earn More. Earn Respect. Safety Ensured.</div>
<p style="font-size: 23px;margin-top:10px;text-align:center;">Join 30,000+ partners across India, Australia, Singapore and the UAE</p>
</div></div></div>

<div class="section-indent-negative">
   <div class=" container__fluid-lg">
      <div class="tabs-dafault tabs__01 js-tabs" data-ajaxcheck="true">
         <div class="tabs__nav02 tabs__nav-center tabs__nav-fullwidth-space">
            <div class="tabs__nav-item02" data-pathtab="tab-01">
               <div class="tt-subtitle tt-subtitle-align" style="margin-top: 30px; margin-bottom: 30px;">Start earning straight away. Share your details and we’ll reach out with next steps.</div>

               <form method="post" id="registerprofessional" action="{{ route('registerprofessional') }}">
               @csrf
                  <div class="row">
                     <div class="col-md-2">
                         <div class="tt-form__group">
                           <input type="text" name="name" id="name" data-validate-field="number" class="tt-form__control02" placeholder="Name" style="border: 2px solid #005bc1; border-radius: 6px;">
                           @error('name')
                              <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                              </span>
                           @enderror
                        </div>
                     </div>

                     <div class="col-md-3">
                       <div class="tt-form__group"><input type="hidden" name="country_id" id="country" value="{{ $country }}">
                           <input type="text" name="mobile" data-validate-field="number" class="tt-form__control02" placeholder="Your Phone Number" style="border: 2px solid #005bc1; border-radius: 6px;">
                           @error('mobile')
                              <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                              </span>
                           @enderror
                        </div>
                  </div>
                     

                       <div class="col-md-2">   
                        <div class="tt-form__group"><input type="hidden" name="state_id" id="state" value="{{ $state }}">
                           <input type="hidden" id=><input type="email" name="email" data-validate-field="email" class="tt-form__control02" placeholder="Email" style="border: 2px solid #005bc1; border-radius: 6px;">
                           @error('email_id')
                              <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                              </span>
                           @enderror
                        </div>
                     </div>

                      <div class="col-md-3">   
                        <div class="tt-form__group">
                           <input type="hidden" name="city_id" id="city" value="{{ $city }}"><input type="text" name="skill" data-validate-field="number" class="tt-form__control02" placeholder="What do you do?" style="border: 2px solid #005bc1; border-radius: 6px;">
                           @error('skill')
                              <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                              </span>
                           @enderror
                        </div>
                     </div>  

                  <div class="col-md-2"><button type="button" class="tt-btn02" id="register"><span>Get in touch</span></button></div>
               </form>   
            </div>
         </div>
      </div>
   </div>
</div>


<div class="section-indent08">
   <div class="container container__fluid-xl">
      <div class="blocktitle text-center blocktitle__min-width02">
         <div class="blocktitle__under">Our Work</div>
         <div class="blocktitle__subtitle">how we work</div>
         <div class="blocktitle__title">Join Our Company to change your life</div>
         <div class="blocktitle__text">Our goal is to provide our customers with professional plumbing services. We pride ourselves on our reliable and friendly service.</div>
      </div>
      <div class="step__wrapper row">
         <div class="col-sm-4">
            <div class="step">
               <h1>30,000+</h1>
               <h6 class="step__title">Inspect &amp; Analyze</h6>
            </div>
         </div>
         <div class="col-sm-4">
            <div class="step">
               <h1>30,000+</h1>
               <h6 class="step__title">Quote &amp; Supply Service</h6>
            </div>
         </div>
         <div class="col-sm-4">
            <div class="step">
               <h1>30,000+</h1>
               <h6 class="step__title">Clean Up &amp; Finish</h6>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="section-indent">
<div class="fullwidth-promo init-parallax lazyload" data-bg="images/bg-02.jpg">
<div class="fullwidth-promo__indent-02">
<div class="tt-icon">
<i class="icon-3410263">
</i></div>
<div class="tt-title">Emergency Plumbing Service<br>24 Hours 7 Days a Week</div>
<p>Quality Plumbing Services from a Team of Professionals</p>
</div></div></div>
<div class="section-indent-negative02">
   <div class="container container__fluid-lg" style="margin-bottom: 100px;">
      <div class="wrapper01">
         
         <div class="section-indent08">
   <div class="container container__fluid-xl">
      <div class="blocktitle text-center blocktitle__min-width02">
         <div class="blocktitle__under">Our Work</div>
         <div class="blocktitle__subtitle">how we work</div>
         <div class="blocktitle__title">Easier than You Can Think!</div>
         <div class="blocktitle__text">Our goal is to provide our customers with professional plumbing services. We pride ourselves on our reliable and friendly service.</div>
      </div>
      <div class="step__wrapper row">
         <div class="col-sm-6">
            <div class="step">
               <div class="step__img">
                  <picture>
                     <source srcset="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-srcset="images/step__img01-sm.webp" media="(max-width: 1024px)" type="image/webp">
                     <source srcset="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-srcset="images/step__img01-sm.png" media="(max-width: 1024px)" type="image/png">
                     <source srcset="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-srcset="images/step__img01.webp" type="image/webp">
                     <source srcset="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-srcset="images/step__img01.png" type="image/png">
                     <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="images/step__img01.webp" class="lazyload" alt="">
                  </picture>
               </div>
               <h6 class="step__title">Inspect &amp; Analyze</h6>
            </div>
         </div>
         <div class="col-sm-6">
            <div class="step">
               <div class="step__img">
                  <picture>
                     <source srcset="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-srcset="images/step__img02-sm.webp" media="(max-width: 1024px)" type="image/webp">
                     <source srcset="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-srcset="images/step__img02-sm.png" media="(max-width: 1024px)" type="image/png">
                     <source srcset="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-srcset="images/step__img02.webp" type="image/webp">
                     <source srcset="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-srcset="images/step__img02.png" type="image/png">
                     <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="images/step__img02.webp" class="lazyload" alt="">
                  </picture>
               </div>
               <h6 class="step__title">Quote &amp; Supply Service</h6>
            </div>
         </div>
      </div>
   </div>
</div>
         </div>
      </div>
   </div>
</div>
@endsection

@section('scripts')



@endsection