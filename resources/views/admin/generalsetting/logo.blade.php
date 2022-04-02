@extends('layouts.admin')
@section('content')

  <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="breadcrumbs-top">
                        <h5 class="content-header-title float-left pr-1 mb-0">Logo</h5>
                        <div class="breadcrumb-wrapper d-none d-sm-block">
                            <ol class="breadcrumb p-0 mb-0 pl-1">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active">{{ __('Website Logo') }}
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <section id="dashboard-ecommerce">
                  <div class="row">
                    <div class="gocover" style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                    <!-- Greetings Content Starts -->
                    <div class="col-xl-4 col-md-6 col-12 dashboard-greetings">
                      <div class="card border-info text-center bg-transparent">
                          <div class="card-body">
                              <div class="row">
                                  <div class="col-md-12 col-sm-12 d-flex justify-content-center flex-column">
                                      <h4>
                                          <span class="badge badge-light-info">{{ __('Header Logo') }}</span>
                                      </h4>
                                      <form class="uplogo-form" id="geniusform" action="{{ route('admin-gs-update') }}" method="POST" enctype="multipart/form-data">
                                        {{csrf_field()}}   

                                        @include('includes.admin.form-both')  
                                        <div class="currrent-logo">
                                          <img src="{{ $gs->logo ? asset('assets/images/'.$gs->logo):asset('assets/images/noimage.png')}}" alt="">
                                        </div>
                                        <div class="set-logo">
                                          <input class="img-upload1" type="file" name="logo">
                                        </div>
                                        <hr>
                                        <div class="submit-area mb-4">  
                                          <button type="submit" class="btn btn-info mt-50 submit-btn">{{ __('Submit') }}</button>
                                        </div>
                                      </form>
                                  </div>
                              </div>
                          </div>
                      </div>
                    </div>
                    <!-- Multi Radial Chart Starts -->
                    <!-- Greetings Content Starts -->
                    <div class="col-xl-4 col-md-6 col-12 dashboard-greetings">
                      <div class="card border-info text-center bg-transparent">
                          <div class="card-body">
                              <div class="row">
                                  <div class="col-md-12 col-sm-12 d-flex justify-content-center flex-column">
                                      <h4>
                                          <span class="badge badge-light-info">{{ __('Footer Logo') }}</span>
                                      </h4>
                                      <form class="uplogo-form" id="geniusform" action="{{ route('admin-gs-update') }}" method="POST" enctype="multipart/form-data">
                                          {{csrf_field()}}   

                                @include('includes.admin.form-both')  
                                          <div class="currrent-logo">
                                            <img src="{{ $gs->footer_logo ? asset('assets/images/'.$gs->footer_logo):asset('assets/images/noimage.png')}}" alt="">
                                          </div>
                                          <div class="set-logo">
                                            <input class="img-upload1" type="file" name="footer_logo">
                                          </div>
                                          <hr>
                                          <div class="submit-area mb-4">
                                            <button type="submit" class="btn btn-info mt-50 submit-btn">{{ __('Submit') }}</button>
                                          </div>
                                        </form>
                                  </div>
                              </div>
                          </div>
                      </div>
                    </div>
                    <!-- Multi Radial Chart Starts -->
                    <!-- Greetings Content Starts -->
                    <div class="col-xl-4 col-md-6 col-12 dashboard-greetings">
                      <div class="card border-info text-center bg-transparent">
                          <div class="card-body">
                              <div class="row">
                                  <div class="col-md-12 col-sm-12 d-flex justify-content-center flex-column">
                                      <h4>
                                          <span class="badge badge-light-info">{{ __('Invoice Logo') }}</span>
                                      </h4>
                                      <form class="uplogo-form" id="geniusform" action="{{ route('admin-gs-update') }}" method="POST" enctype="multipart/form-data">
                                      {{csrf_field()}}   

                                       @include('includes.admin.form-both')  

                                      <div class="currrent-logo">
                                        <img src="{{ $gs->invoice_logo ? asset('assets/images/'.$gs->invoice_logo):asset('assets/images/noimage.png')}}" alt="">
                                      </div>
                                      
                                      <div class="set-logo">
                                        <input class="img-upload1" type="file" name="invoice_logo">
                                      </div>
                                      <hr>
                                      <div class="submit-area mb-4">
                                        <button type="submit" class="btn btn-info mt-50 submit-btn">{{ __('Submit') }}</button>
                                      </div>
                                    </form>
                                  </div>
                              </div>
                          </div>
                      </div>
                    </div>
                    <!-- Multi Radial Chart Starts -->
                  </div>
                </section>

            </div>
        </div>
    </div>
    <!-- END: Content-->
          
@endsection
@section('scripts')

<!-- BEGIN: Page Vendor JS-->
<script src="{{ asset('assets/admin-assets/js/myscript.js') }}"></script>
<script src="{{ asset('assets/admin-assets/js/load.js') }}"></script>
<!-- END: Page Vendor JS-->
@endsection