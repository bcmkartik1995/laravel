@extends('layouts.admin')

@section('styles')

<style>
  .h6
  {
    font-size: 13px !important;
  }
</style>

@endsection

@section('content')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h5 class="content-header-title float-left pr-1 mb-0">{{ __('Edit Role') }} <!-- <a class="add-btn btn btn-dark mr-1" href="{{route('admin-role-index')}}"><i class="fas fa-arrow-left"></i> {{ __('Back') }}</a> --></h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active"><a href="{{ route('admin-role-index') }}">{{ __('Manage Roles') }}</a>
                            </li>
                            <li class="breadcrumb-item">{{ __('Edit Role') }}</li>
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
                        <div class="card-content">
                            <div class="card-body add-product-content1">
                              <div class="row">
                  <div class="col-lg-12">
                    <div class="product-description">
                      <div class="body-area">
                          <div class="gocover" style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                      <form id="geniusform" action="{{route('admin-role-update',$data->id)}}" method="POST" enctype="multipart/form-data">
                          {{csrf_field()}}
                          @include('includes.admin.form-both')

                        <div class="row">
                          <div class="col-md-4">
                              <label><h4>{{ __("Name") }} *</h4></label>
                          </div>
                          <div class="col-md-8 form-group">
                            <input type="text" class="input-field form-control" name="name" placeholder="{{ __('Name') }}" value="{{$data->name}}" required="">
                          </div>
                        </div>


                        <hr>
                        <h5 class="text-center">{{ __('Permissions') }}</h5>
                        <hr>


                        {{--<!-- <div class="row">
                            <div class="col-md-12">
                                <h5 class="font-weight-bold pb-1">{{ __('Manage User') }} </h5>
                            </div>
                        </div>
                        <div class="row justify-content-center category-block pl-2">
                            <div class="col-lg-2 d-flex">
                                <label class="control-label h6 font-weight-bold">{{ __('Manage Staff') }} *</label>
                                <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                                <input type="checkbox" class="custom-control-input manage_staffs" name="section[]" value="manage_staffs" id="manage_staffs" {{ $data->sectionCheck('manage_staffs') ? 'checked' : '' }}>
                                <label class="custom-control-label mr-1 slider round" for="manage_staffs">
                                </label>
                                </div>
                            </div>
                            <div class="col-lg-2 d-flex justify-content-between">
                            </div>

                            <div class="col-lg-2 d-flex justify-content-between">
                            </div>
                            <div class="col-lg-2 d-flex justify-content-between">
                            </div>
                            <div class="col-lg-2 d-flex justify-content-between">
                            </div>
                            <div class="col-lg-2"></div>
                        </div>

                        <div class="row justify-content-center category-block pl-2 pb-1">
                            <div class="col-lg-2 d-flex">
                                <label class="control-label h6 font-weight-bold">{{ __('Manage Customer') }} *</label>
                                <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                                <input type="checkbox" class="custom-control-input manage_customer" name="section[]" value="manage_customer" id="manage_customer" {{ $data->sectionCheck('manage_customer') ? 'checked' : '' }}>
                                <label class="custom-control-label mr-1 slider round" for="manage_customer">
                                </label>
                                </div>
                            </div>
                            <div class="col-lg-2 d-flex justify-content-between">
                              <label class="control-label">{{ __('Add') }} *</label>
                              <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                                <input type="checkbox" class="custom-control-input manage_customer_add" name="section[]" value="manage_customer_add"  id="manage_customer_add" {{ $data->sectionCheck('manage_customer_add') ? 'checked' : '' }}>
                                <label class="custom-control-label mr-1 slider round" for="manage_customer_add">
                                </label>
                              </div>
                            </div>

                            <div class="col-lg-2 d-flex justify-content-between">
                              <label class="control-label">{{ __('Delete') }} *</label>
                              <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                                <input type="checkbox" class="custom-control-input manage_customer_delete" name="section[]" value="manage_customer_delete"  id="manage_customer_delete" {{ $data->sectionCheck('manage_customer_delete') ? 'checked' : '' }}>
                                <label class="custom-control-label mr-1 slider round" for="manage_customer_delete">
                                </label>
                              </div>
                            </div>
                            
                            <div class="col-lg-2 d-flex justify-content-between">
                            </div>
                            <div class="col-lg-2 d-flex justify-content-between">
                            </div>
                            <div class="col-lg-2"></div>
                            
                        </div> -->--}}

                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="font-weight-bold pb-1">{{ __('Category') }} </h5>
                            </div>
                        </div>
                        <div class="row justify-content-center category-block pl-2 pb-1">

                            <div class="col-lg-2 d-flex">
                            <label class="control-label h6 font-weight-bold">{{ __('Categories') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input category-check" name="section[]" value="categories" id="categories" {{ $data->sectionCheck('categories') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="categories">
                              </label>
                            </div>

                            </div>
                            <div class="col-lg-2 d-flex justify-content-between">
                              <label class="control-label">{{ __('Add') }} *</label>
                              <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                                <input type="checkbox" class="custom-control-input categories_add" name="section[]" value="categories_add"  id="categories_add" {{ $data->sectionCheck('categories_add') ? 'checked' : '' }}>
                                <label class="custom-control-label mr-1 slider round" for="categories_add">
                                </label>
                              </div>
                            </div>

                            <div class="col-lg-2 d-flex justify-content-between">
                              <label class="control-label">{{ __('Edit') }} *</label>
                              <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                                <input type="checkbox" class="custom-control-input categories_update" name="section[]" value="categories_update"  id="categories_update" {{ $data->sectionCheck('categories_update') ? 'checked' : '' }}>
                                <label class="custom-control-label mr-1 slider round" for="categories_update">
                                </label>
                              </div>
                            </div>
                            <div class="col-lg-2 d-flex justify-content-between">
                              <label class="control-label">{{ __('Delete') }} *</label>
                              <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                                <input type="checkbox" class="custom-control-input categories_delete" name="section[]" value="categories_delete"  id="categories_delete" {{ $data->sectionCheck('categories_delete') ? 'checked' : '' }}>
                                <label class="custom-control-label mr-1 slider round" for="categories_delete">
                                </label>
                              </div>
                            </div>
                            <div class="col-lg-2 d-flex justify-content-between">
                              <label class="control-label">{{ __('Status') }} *</label>
                              <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                                <input type="checkbox" class="custom-control-input categories_status" name="section[]" value="categories_status"  id="categories_status" {{ $data->sectionCheck('categories_status') ? 'checked' : '' }}>
                                <label class="custom-control-label mr-1 slider round" for="categories_status">
                                </label>
                              </div>
                            </div>
                            <div class="col-lg-2"></div>

                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="font-weight-bold pb-1">{{ __('Sub Category') }} </h5>
                            </div>
                        </div>
                        <div class="row justify-content-center pl-2 pb-1">

                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label h6 font-weight-bold">{{ __('Sub Categories') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input sub_categories" name="section[]" value="sub_categories"  id="sub_categories" {{ $data->sectionCheck('sub_categories') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="sub_categories">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Add') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input sub_categories_add" name="section[]" value="sub_categories_add"  id="sub_categories_add" {{ $data->sectionCheck('sub_categories_add') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="sub_categories_add">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Edit') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input sub_categories_edit" name="section[]" value="sub_categories_edit"  id="sub_categories_edit" {{ $data->sectionCheck('sub_categories_edit') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="sub_categories_edit">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Delete') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input sub_categories_delete" name="section[]" value="sub_categories_delete"  id="sub_categories_delete" {{ $data->sectionCheck('sub_categories_delete') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="sub_categories_delete">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Status') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input sub_categories_status" name="section[]" value="sub_categories_status"  id="sub_categories_status" {{ $data->sectionCheck('sub_categories_status') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="sub_categories_status">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2"></div>

                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="font-weight-bold pb-1">{{ __('Services') }} </h5>
                            </div>
                        </div>
                        <div class="row justify-content-center pl-2">

                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label h6 font-weight-bold">{{ __('Services') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input services" name="section[]" value="services"  id="services" {{ $data->sectionCheck('services') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="services">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Add') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input services_add" name="section[]" value="services_add"  id="services_add" {{ $data->sectionCheck('services_add') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="services_add">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Edit') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input services_edit" name="section[]" value="services_edit"  id="services_edit" {{ $data->sectionCheck('services_edit') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="services_edit">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Delete') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input services_delete" name="section[]" value="services_delete"  id="services_delete" {{ $data->sectionCheck('services_delete') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="services_delete">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Status') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input services_status" name="section[]" value="services_status"  id="services_status" {{ $data->sectionCheck('services_status') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="services_status">
                              </label>
                            </div>
                          </div>

                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Manage Media') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input services_media" name="section[]" value="services_media"  id="services_media" {{ $data->sectionCheck('services_media') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="services_media">
                              </label>
                            </div>
                          </div>

                        </div>

                        <div class="row justify-content-center pl-2">

                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label h6 font-weight-bold">{{ __('Best Services') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input best_services" name="section[]" value="best_services"  id="best_services" {{ $data->sectionCheck('best_services') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="best_services">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Add') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input best_services_add" name="section[]" value="best_services_add"  id="best_services_add" {{ $data->sectionCheck('best_services_add') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="best_services_add">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Edit') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input best_services_edit" name="section[]" value="best_services_edit"  id="best_services_edit" {{ $data->sectionCheck('best_services_edit') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="best_services_edit">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Delete') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input best_services_delete" name="section[]" value="best_services_delete"  id="best_services_delete" {{ $data->sectionCheck('best_services_delete') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="best_services_delete">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Status') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input best_services_status" name="section[]" value="best_services_status"  id="best_services_status" {{ $data->sectionCheck('best_services_status') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="best_services_status">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2"></div>

                        </div>

                        <div class="row justify-content-center pl-2">

                            <div class="col-lg-2 d-flex justify-content-start">
                              <label class="control-label h6 font-weight-bold">{{ __('Service Specifications') }} *</label>
                              <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                                <input type="checkbox" class="custom-control-input service_specification" name="section[]" value="service_specification"  id="service_specification" {{ $data->sectionCheck('service_specification') ? 'checked' : '' }}>
                                <label class="custom-control-label mr-1 slider round" for="service_specification">
                                </label>
                              </div>
                            </div>
                            <div class="col-lg-2 d-flex justify-content-start">
                              <label class="control-label">{{ __('Add') }} *</label>
                              <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                                <input type="checkbox" class="custom-control-input service_specification_add" name="section[]" value="service_specification_add"  id="service_specification_add" {{ $data->sectionCheck('service_specification_add') ? 'checked' : '' }}>
                                <label class="custom-control-label mr-1 slider round" for="service_specification_add">
                                </label>
                              </div>
                            </div>
                            <div class="col-lg-2 d-flex justify-content-start">
                              <label class="control-label">{{ __('Edit') }} *</label>
                              <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                                <input type="checkbox" class="custom-control-input service_specification_edit" name="section[]" value="service_specification_edit"  id="service_specification_edit" {{ $data->sectionCheck('service_specification_edit') ? 'checked' : '' }}>
                                <label class="custom-control-label mr-1 slider round" for="service_specification_edit">
                                </label>
                              </div>
                            </div>
                            <div class="col-lg-2 d-flex justify-content-start">
                              <label class="control-label">{{ __('Delete') }} *</label>
                              <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                                <input type="checkbox" class="custom-control-input service_specification_delete" name="section[]" value="service_specification_delete"  id="service_specification_delete" {{ $data->sectionCheck('service_specification_delete') ? 'checked' : '' }}>
                                <label class="custom-control-label mr-1 slider round" for="service_specification_delete">
                                </label>
                              </div>
                            </div>
                            <div class="col-lg-2 d-flex justify-content-start">
                              <label class="control-label">{{ __('Status') }} *</label>
                              <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                                <input type="checkbox" class="custom-control-input service_specification_status" name="section[]" value="service_specification_status"  id="service_specification_status" {{ $data->sectionCheck('service_specification_status') ? 'checked' : '' }}>
                                <label class="custom-control-label mr-1 slider round" for="service_specification_status">
                                </label>
                              </div>
                            </div>
                            <div class="col-lg-2"></div>

                          </div>


                          <div class="row justify-content-center pl-2">

                            <div class="col-lg-2 d-flex justify-content-start">
                              <label class="control-label h6 font-weight-bold">{{ __('Service Faq') }} *</label>
                              <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                                <input type="checkbox" class="custom-control-input service_faq" name="section[]" value="service_faq"  id="service_faq" {{ $data->sectionCheck('service_faq') ? 'checked' : '' }}>
                                <label class="custom-control-label mr-1 slider round" for="service_faq">
                                </label>
                              </div>
                            </div>
                            <div class="col-lg-2 d-flex justify-content-start">
                              <label class="control-label">{{ __('Add') }} *</label>
                              <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                                <input type="checkbox" class="custom-control-input service_faq_add" name="section[]" value="service_faq_add"  id="service_faq_add" {{ $data->sectionCheck('service_faq_add') ? 'checked' : '' }}>
                                <label class="custom-control-label mr-1 slider round" for="service_faq_add">
                                </label>
                              </div>
                            </div>
                            <div class="col-lg-2 d-flex justify-content-start">
                              <label class="control-label">{{ __('Edit') }} *</label>
                              <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                                <input type="checkbox" class="custom-control-input service_faq_edit" name="section[]" value="service_faq_edit"  id="service_faq_edit" {{ $data->sectionCheck('service_faq_edit') ? 'checked' : '' }}>
                                <label class="custom-control-label mr-1 slider round" for="service_faq_edit">
                                </label>
                              </div>
                            </div>
                            <div class="col-lg-2 d-flex justify-content-start">
                              <label class="control-label">{{ __('Delete') }} *</label>
                              <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                                <input type="checkbox" class="custom-control-input service_faq_delete" name="section[]" value="service_faq_delete"  id="service_faq_delete" {{ $data->sectionCheck('service_faq_delete') ? 'checked' : '' }}>
                                <label class="custom-control-label mr-1 slider round" for="service_faq_delete">
                                </label>
                              </div>
                            </div>
                            <div class="col-lg-2 d-flex justify-content-start">
                              <label class="control-label">{{ __('Status') }} *</label>
                              <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                                <input type="checkbox" class="custom-control-input service_faq_status" name="section[]" value="service_faq_status"  id="service_faq_status" {{ $data->sectionCheck('service_faq_status') ? 'checked' : '' }}>
                                <label class="custom-control-label mr-1 slider round" for="service_faq_status">
                                </label>
                              </div>
                            </div>
                            <div class="col-lg-2"></div>
                            
                          </div>


                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="font-weight-bold pb-1">{{ __('Packages') }} </h5>
                            </div>
                        </div>
                        <div class="row justify-content-center pl-2 pb-1">

                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label h6 font-weight-bold">{{ __('Packages') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input packages" name="section[]" value="packages"  id="packages" {{ $data->sectionCheck('packages') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="packages">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Add') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input packages_add" name="section[]" value="packages_add"  id="packages_add" {{ $data->sectionCheck('packages_add') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="packages_add">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Edit') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input packages_edit" name="section[]" value="packages_edit"  id="packages_edit" {{ $data->sectionCheck('packages_edit') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="packages_edit">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Delete') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input packages_delete" name="section[]" value="packages_delete"  id="packages_delete" {{ $data->sectionCheck('packages_delete') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="packages_delete">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Status') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input packages_status" name="section[]" value="packages_status"  id="packages_status" {{ $data->sectionCheck('packages_status') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="packages_status">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Manage Media') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input packages_media" name="section[]" value="packages_media"  id="packages_media" {{ $data->sectionCheck('packages_media') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="packages_media">
                              </label>
                            </div>
                          </div>

                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="font-weight-bold pb-1">{{ __('Leads') }} </h5>
                            </div>
                        </div>
                        <div class="row justify-content-center pl-2 pb-1">

                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label h6 font-weight-bold">{{ __('Leads') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input leads" name="section[]" value="leads"  id="leads" {{ $data->sectionCheck('leads') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="leads">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Add') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input leads_add" name="section[]" value="leads_add"  id="leads_add" {{ $data->sectionCheck('leads_add') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="leads_add">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Edit') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input leads_edit" name="section[]" value="leads_edit"  id="leads_edit" {{ $data->sectionCheck('leads_edit') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="leads_edit">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Delete') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input leads_delete" name="section[]" value="leads_delete"  id="leads_delete" {{ $data->sectionCheck('leads_delete') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="leads_delete">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Status') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input leads_status" name="section[]" value="leads_status"  id="leads_status" {{ $data->sectionCheck('leads_status') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="leads_status">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Add User') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input leads_add_user" name="section[]" value="leads_add_user"  id="leads_add_user" {{ $data->sectionCheck('leads_add_user') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="leads_add_user">
                              </label>
                            </div>
                          </div>

                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="font-weight-bold pb-1">{{ __('Franchises') }} </h5>
                            </div>
                        </div>
                        <div class="row justify-content-center pl-2">

                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label h6 font-weight-bold">{{ __('Franchises') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input franchises" name="section[]" value="franchises"  id="franchises" {{ $data->sectionCheck('franchises') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="franchises">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Add') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input franchises_add" name="section[]" value="franchises_add"  id="franchises_add" {{ $data->sectionCheck('franchises_add') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="franchises_add">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Edit') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input franchises_edit" name="section[]" value="franchises_edit"  id="franchises_edit" {{ $data->sectionCheck('franchises_edit') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="franchises_edit">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Delete') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input franchises_delete" name="section[]" value="franchises_delete"  id="franchises_delete" {{ $data->sectionCheck('franchises_status') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="franchises_status">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Status') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input franchises_status" name="section[]" value="franchises_status"  id="franchises_status" {{ $data->sectionCheck('franchises_status') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="franchises_status">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2"></div>

                        </div>
                        <div class="row justify-content-center pl-2 pb-1">

                            <div class="col-lg-2 d-flex justify-content-start">
                              <label class="control-label h6 font-weight-bold">{{ __('Franchise User') }} *</label>
                              <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                                <input type="checkbox" class="custom-control-input franchise_user" name="section[]" value="franchise_user"  id="franchise_user" {{ $data->sectionCheck('franchise_user') ? 'checked' : '' }}>
                                <label class="custom-control-label mr-1 slider round" for="franchise_user">
                                </label>
                              </div>
                            </div>
                            <div class="col-lg-2 d-flex justify-content-start">
                              <label class="control-label">{{ __('Edit') }} *</label>
                              <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                                <input type="checkbox" class="custom-control-input franchise_user_edit" name="section[]" value="franchise_user_edit"  id="franchise_user_edit" {{ $data->sectionCheck('franchise_user_edit') ? 'checked' : '' }}>
                                <label class="custom-control-label mr-1 slider round" for="franchise_user_edit">
                                </label>
                              </div>
                            </div>
                            <div class="col-lg-2 d-flex justify-content-start">
                              <label class="control-label">{{ __('Delete') }} *</label>
                              <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                                <input type="checkbox" class="custom-control-input franchise_user_delete" name="section[]" value="franchise_user_delete"  id="franchise_user_delete" {{ $data->sectionCheck('franchise_user_delete') ? 'checked' : '' }}>
                                <label class="custom-control-label mr-1 slider round" for="franchise_user_delete">
                                </label>
                              </div>
                            </div>
                            <div class="col-lg-2 d-flex justify-content-start">
                            </div>
                            <div class="col-lg-2 d-flex justify-content-start">
                            </div>
                            <div class="col-lg-2"></div>

                          </div>


                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="font-weight-bold pb-1">{{ __('Offers') }} </h5>
                            </div>
                        </div>
                        <div class="row justify-content-center pl-2">

                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label h6 font-weight-bold">{{ __('Offers') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input offers" name="section[]" value="offers"  id="offers" {{ $data->sectionCheck('offers') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="offers">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Add') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input offers_add" name="section[]" value="offers_add"  id="offers_add" {{ $data->sectionCheck('offers_add') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="offers_add">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Edit') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input offers_edit" name="section[]" value="offers_edit"  id="offers_edit" {{ $data->sectionCheck('offers_edit') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="offers_edit">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Delete') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input offers_delete" name="section[]" value="offers_delete"  id="offers_delete" {{ $data->sectionCheck('offers_delete') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="offers_delete">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Status') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input offers_status" name="section[]" value="offers_status"  id="offers_status" {{ $data->sectionCheck('offers_status') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="offers_status">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2"></div>

                        </div>

                        <div class="row justify-content-center pl-2 pb-1">

                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label h6 font-weight-bold">{{ __('Best Offers') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input best_offers" name="section[]" value="best_offers"  id="best_offers" {{ $data->sectionCheck('best_offers') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="best_offers">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Add') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input best_offers_add" name="section[]" value="best_offers_add"  id="best_offers_add" {{ $data->sectionCheck('best_offers_add') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="best_offers_add">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Edit') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input best_offers_edit" name="section[]" value="best_offers_edit"  id="best_offers_edit" {{ $data->sectionCheck('best_offers_edit') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="best_offers_edit">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Delete') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input best_offers_delete" name="section[]" value="best_offers_delete"  id="best_offers_delete" {{ $data->sectionCheck('best_offers_delete') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="best_offers_delete">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Status') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input best_offers_status" name="section[]" value="best_offers_status"  id="best_offers_status" {{ $data->sectionCheck('best_offers_status') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="best_offers_status">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2"></div>

                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="font-weight-bold pb-1">{{ __('Gifts') }} </h5>
                            </div>
                        </div>
                        <div class="row justify-content-center pl-2 pb-1">

                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label h6 font-weight-bold">{{ __('Gifts') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input gifts" name="section[]" value="gifts"  id="gifts" {{ $data->sectionCheck('gifts') ? 'checked' : '' }} >
                              <label class="custom-control-label mr-1 slider round" for="gifts">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Add') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input gifts_add" name="section[]" value="gifts_add"  id="gifts_add" {{ $data->sectionCheck('gifts_add') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="gifts_add">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Edit') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input gifts_edit" name="section[]" value="gifts_edit"  id="gifts_edit" {{ $data->sectionCheck('gifts_edit') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="gifts_edit">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Delete') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input gifts_delete" name="section[]" value="gifts_delete"  id="gifts_delete" {{ $data->sectionCheck('gifts_delete') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="gifts_delete">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Status') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input gifts_status" name="section[]" value="gifts_status"  id="gifts_status" {{ $data->sectionCheck('gifts_status') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="gifts_status">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Send Gift') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input gifts_send" name="section[]" value="gifts_send"  id="gifts_send" {{ $data->sectionCheck('gifts_send') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="gifts_send">
                              </label>
                            </div>
                          </div>

                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="font-weight-bold pb-1">{{ __('Orders') }} </h5>
                            </div>
                        </div>
                        <div class="row justify-content-center pl-2">

                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label h6 font-weight-bold">{{ __('Orders') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input orders" name="section[]" value="orders"  id="orders" {{ $data->sectionCheck('orders') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="orders">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('View') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input orders_view" name="section[]" value="orders_view"  id="orders_view" {{ $data->sectionCheck('orders_view') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="orders_view">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Delete') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input orders_delete" name="section[]" value="orders_delete"  id="orders_delete" {{ $data->sectionCheck('orders_delete') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="orders_delete">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Status') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input orders_status" name="section[]" value="orders_status"  id="orders_status" {{ $data->sectionCheck('orders_status') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="orders_status">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Invoice') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input orders_invoice" name="section[]" value="orders_invoice"  id="orders_invoice" {{ $data->sectionCheck('orders_invoice') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="orders_invoice">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Franchise Assigned') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input franchise_orders_assigned" name="section[]" value="franchise_orders_assigned"  id="franchise_orders_assigned" {{ $data->sectionCheck('franchise_orders_assigned') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="franchise_orders_assigned">
                              </label>
                            </div>
                          </div>

                        </div>

                        <div class="row justify-content-center pl-2">

                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label h6 font-weight-bold">{{ __('Unallocated Orders') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input unallocated_orders" name="section[]" value="unallocated_orders"  id="unallocated_orders" {{ $data->sectionCheck('unallocated_orders') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="unallocated_orders">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('View') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input unallocated_orders_view" name="section[]" value="unallocated_orders_view"  id="unallocated_orders_view" {{ $data->sectionCheck('unallocated_orders_view') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="unallocated_orders_view">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Delete') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input unallocated_orders_delete" name="section[]" value="unallocated_orders_delete"  id="unallocated_orders_delete" {{ $data->sectionCheck('unallocated_orders_delete') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="unallocated_orders_delete">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Status') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input unallocated_orders_status" name="section[]" value="unallocated_orders_status"  id="unallocated_orders_status" {{ $data->sectionCheck('unallocated_orders_status') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="unallocated_orders_status">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Franchise Assigned') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input unallocated_orders_assigned" name="section[]" value="unallocated_orders_assigned"  id="unallocated_orders_assigned" {{ $data->sectionCheck('unallocated_orders_assigned') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="unallocated_orders_assigned">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                          </div>
                          
                        </div>

                        <!-- <div class="row justify-content-center pl-2 pb-1">

                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label h6 font-weight-bold">{{ __('Franchise Assigned') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input franchise_assigned" name="section[]" value="franchise_assigned"  id="franchise_assigned" {{ $data->sectionCheck('franchise_assigned') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="franchise_assigned">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('view') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input franchise_assigned_view" name="section[]" value="franchise_assigned_view"  id="franchise_assigned_view" {{ $data->sectionCheck('franchise_assigned_view') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="franchise_assigned_view">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">

                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">

                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">

                          </div>
                          <div class="col-lg-2"></div>

                        </div> -->


                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="font-weight-bold pb-1">{{ __('Accounts') }} </h5>
                            </div>
                        </div>
                        <div class="row justify-content-center pl-2 pb-1">

                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label h6 font-weight-bold">{{ __('Accounts') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input accounts" name="section[]" value="accounts"  id="accounts" {{ $data->sectionCheck('accounts') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="accounts">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Income') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input accounts_income" name="section[]" value="accounts_income"  id="accounts_income" {{ $data->sectionCheck('accounts_income') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="accounts_income">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Franchise Fees') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input accounts_franchise_fees" name="section[]" value="accounts_franchise_fees"  id="accounts_franchise_fees" {{ $data->sectionCheck('accounts_franchise_fees') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="accounts_franchise_fees">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Franchise Outstandings') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input accounts_franchise_outstandings" name="section[]" value="accounts_franchise_outstandings"  id="accounts_franchise_outstandings">
                              <label class="custom-control-label mr-1 slider round" for="accounts_franchise_outstandings" {{ $data->sectionCheck('accounts_franchise_outstandings') ? 'checked' : '' }}>
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                          </div>
                          <div class="col-lg-2"></div>

                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="font-weight-bold pb-1">{{ __('Payments') }} </h5>
                            </div>
                        </div>
                        <div class="row justify-content-center pl-2">

                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label h6 font-weight-bold">{{ __('Payments') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input payments" name="section[]" value="payments"  id="payments" {{ $data->sectionCheck('Payments') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="payments">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Add') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input payments_add" name="section[]" value="payments_add"  id="payments_add" {{ $data->sectionCheck('payments_add') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="payments_add">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Edit') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input payments_edit" name="section[]" value="payments_edit"  id="payments_edit" {{ $data->sectionCheck('payments_edit') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="payments_edit">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Delete') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input payments_delete" name="section[]" value="payments_delete"  id="payments_delete" {{ $data->sectionCheck('payments_delete') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="payments_delete">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                          </div>
                          <div class="col-lg-2"></div>

                        </div>
                        <div class="row justify-content-center pl-2">

                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label h6 font-weight-bold">{{ __('Credit Plans') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input credit_plans" name="section[]" value="credit_plans"  id="credit_plans" {{ $data->sectionCheck('credit_plans') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="credit_plans">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Add') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input credit_plans_add" name="section[]" value="credit_plans_add"  id="credit_plans_add" {{ $data->sectionCheck('credit_plans_add') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="credit_plans_add">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Edit') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input credit_plans_edit" name="section[]" value="credit_plans_edit"  id="credit_plans_edit" {{ $data->sectionCheck('credit_plans_edit') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="credit_plans_edit">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Delete') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input credit_plans_delete" name="section[]" value="credit_plans_delete"  id="credit_plans_delete" {{ $data->sectionCheck('credit_plans_delete') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="credit_plans_delete">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Status') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input credit_plans_status" name="section[]" value="credit_plans_status"  id="credit_plans_status" {{ $data->sectionCheck('credit_plans_status') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="credit_plans_status">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Edit Credit Price') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input credit_Price_edit" name="section[]" value="credit_Price_edit"  id="credit_Price_edit" {{ $data->sectionCheck('credit_Price_edit') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="credit_Price_edit">
                              </label>
                            </div>
                          </div>

                        </div>

                        <div class="row justify-content-center pl-2 pb-1">

                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label h6 font-weight-bold">{{ __('Custome Plans') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input custome_plans" name="section[]" value="custome_plans"  id="custome_plans" {{ $data->sectionCheck('custome_plans') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="custome_plans">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                          </div>

                        </div>



                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="font-weight-bold pb-1">{{ __('Ratings') }} </h5>
                            </div>
                        </div>
                        <div class="row justify-content-center pl-2">

                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label h6 font-weight-bold">{{ __('Service Ratings') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input service_ratings" name="section[]" value="service_ratings"  id="service_ratings" {{ $data->sectionCheck('service_ratings') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="service_ratings">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Add') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input service_ratings_add" name="section[]" value="service_ratings_add"  id="service_ratings_add" {{ $data->sectionCheck('service_ratings_add') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="service_ratings_add">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Edit') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input service_ratings_edit" name="section[]" value="service_ratings_edit"  id="service_ratings_edit" {{ $data->sectionCheck('service_ratings_edit') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="service_ratings_edit">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Delete') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input service_ratings_delete" name="section[]" value="service_ratings_delete"  id="service_ratings_delete" {{ $data->sectionCheck('service_ratings_delete') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="service_ratings_delete">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Status') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input service_ratings_status" name="section[]" value="service_ratings_status"  id="service_ratings_status" {{ $data->sectionCheck('service_ratings_status') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="service_ratings_status">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2"></div>

                        </div>

                        <div class="row justify-content-center pl-2">

                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label h6 font-weight-bold">{{ __('Package Ratings') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input package_ratings" name="section[]" value="package_ratings"  id="package_ratings" {{ $data->sectionCheck('package_ratings') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="package_ratings">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Add') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input package_ratings_add" name="section[]" value="package_ratings_add"  id="package_ratings_add" {{ $data->sectionCheck('package_ratings_add') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="package_ratings_add">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Edit') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input package_ratings_edit" name="section[]" value="package_ratings_edit"  id="package_ratings_edit" {{ $data->sectionCheck('package_ratings_edit') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="package_ratings_edit">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Delete') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input package_ratings_delete" name="section[]" value="package_ratings_delete"  id="package_ratings_delete" {{ $data->sectionCheck('package_ratings_delete') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="package_ratings_delete">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Status') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input package_ratings_status" name="section[]" value="package_ratings_status"  id="package_ratings_status" {{ $data->sectionCheck('package_ratings_status') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="package_ratings_status">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2"></div>

                        </div>

                        <div class="row justify-content-center pl-2">

                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label h6 font-weight-bold">{{ __('Order Review') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input order_review" name="section[]" value="order_review"  id="order_review" {{ $data->sectionCheck('order_review') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="order_review">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            {{--<!-- <label class="control-label h6 font-weight-bold">{{ __('Order Detail View') }} *</label>
                              <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                                <input type="checkbox" class="custom-control-input order_review_detail_view" name="section[]" value="order_review_detail_view"  id="order_review_detail_view" {{ $data->sectionCheck('order_review_detail_view') ? 'checked' : '' }}>
                                <label class="custom-control-label mr-1 slider round" for="order_review_detail_view">
                                </label>
                              </div> -->--}}
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                          </div>
                          <div class="col-lg-2"></div>

                        </div>

                        <div class="row justify-content-center pl-2 pb-1">

                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label h6 font-weight-bold">{{ __('Testimonial') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input testimonial" name="section[]" value="testimonial"  id="testimonial" {{ $data->sectionCheck('testimonial') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="testimonial">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Add') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input testimonial_add" name="section[]" value="testimonial_add"  id="testimonial_add" {{ $data->sectionCheck('testimonial_add') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="testimonial_add">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Edit') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input testimonial_edit" name="section[]" value="testimonial_edit"  id="testimonial_edit" {{ $data->sectionCheck('testimonial_edit') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="testimonial_edit">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Status') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input testimonial_status" name="section[]" value="testimonial_status"  id="testimonial_status" {{ $data->sectionCheck('testimonial_status') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="testimonial_status">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                          </div>
                          <div class="col-lg-2"></div>
                          
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="font-weight-bold pb-1">{{ __('Slider') }} </h5>
                            </div>
                        </div>
                        <div class="row justify-content-center pl-2 pb-1">

                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label h6 font-weight-bold">{{ __('Slider') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input slider_list" name="section[]" value="slider_list"  id="slider_list" {{ $data->sectionCheck('slider_list') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="slider_list">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Add') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input slider_add" name="section[]" value="slider_add"  id="slider_add" {{ $data->sectionCheck('slider_add') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="slider_add">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Edit') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input slider_edit" name="section[]" value="slider_edit"  id="slider_edit" {{ $data->sectionCheck('slider_edit') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="slider_edit">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Delete') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input slider_delete" name="section[]" value="slider_delete"  id="slider_delete" {{ $data->sectionCheck('slider_delete') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="slider_delete">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Status') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input slider_status" name="section[]" value="slider_status"  id="slider_status" {{ $data->sectionCheck('slider_status') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="slider_status">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2"></div>

                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="font-weight-bold pb-1">{{ __('Manage Pages') }} </h5>
                            </div>
                        </div>
                        <div class="row justify-content-center pl-2">

                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label h6 font-weight-bold">{{ __('About Us') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input aboutus_list" name="section[]" value="aboutus_list"  id="aboutus_list" {{ $data->sectionCheck('aboutus_list') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="aboutus_list">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Add') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input aboutus_add" name="section[]" value="aboutus_add"  id="aboutus_add" {{ $data->sectionCheck('aboutus_add') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="aboutus_add">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Edit') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input aboutus_edit" name="section[]" value="aboutus_edit"  id="aboutus_edit" {{ $data->sectionCheck('aboutus_edit') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="aboutus_edit">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Delete') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input aboutus_delete" name="section[]" value="aboutus_delete"  id="aboutus_delete" {{ $data->sectionCheck('aboutus_delete') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="aboutus_delete">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                          </div>
                          <div class="col-lg-2"></div>
                          
                        </div>

                        <div class="row justify-content-center pl-2">

                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label h6 font-weight-bold">{{ __('Blog') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input blog" name="section[]" value="blog"  id="blog" {{ $data->sectionCheck('blog') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="blog">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Add') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input blog_add" name="section[]" value="blog_add"  id="blog_add" {{ $data->sectionCheck('blog_add') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="blog_add">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Edit') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input blog_edit" name="section[]" value="blog_edit"  id="blog_edit" {{ $data->sectionCheck('blog_edit') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="blog_edit">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Delete') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input blog_delete" name="section[]" value="blog_delete"  id="blog_delete" {{ $data->sectionCheck('blog_delete') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="blog_delete">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Status') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input blog_status" name="section[]" value="blog_status"  id="blog_status" {{ $data->sectionCheck('blog_status') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="blog_status">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2"></div>
                          
                        </div>

                        <div class="row justify-content-center pl-2">

                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label h6 font-weight-bold">{{ __('News Letter') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input news_letter" name="section[]" value="news_letter"  id="news_letter" {{ $data->sectionCheck('news_letter') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="news_letter">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Send News Letter') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input send_news_letter" name="section[]" value="send_news_letter"  id="send_news_letter" {{ $data->sectionCheck('send_news_letter') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="send_news_letter">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Delete') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input news_letter_delete" name="section[]" value="news_letter_delete"  id="news_letter_delete" {{ $data->sectionCheck('news_letter_delete') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="news_letter_delete">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                          </div>
                          <div class="col-lg-2"></div>
                          
                        </div>

                        <div class="row justify-content-center pl-2">

                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label h6 font-weight-bold">{{ __('Referral Program') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input referral_program" name="section[]" value="referral_program"  id="referral_program" {{ $data->sectionCheck('referral_program') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="referral_program">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                          </div>
                          <div class="col-lg-2"></div>
                          
                        </div>


                        <div class="row justify-content-center pl-2">

                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label h6 font-weight-bold">{{ __('Request Quotes') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input request_quotes" name="section[]" value="request_quotes"  id="request_quotes" {{ $data->sectionCheck('request_quotes') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="request_quotes">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label h6 font-weight-bold">{{ __('Delete') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input request_quotes_delete" name="section[]" value="request_quotes_delete"  id="request_quotes_delete" {{ $data->sectionCheck('request_quotes_delete') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="request_quotes_delete">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label h6 font-weight-bold">{{ __('Status') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input request_quotes_status" name="section[]" value="request_quotes_status"  id="request_quotes_status" {{ $data->sectionCheck('request_quotes_status') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="request_quotes_status">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                          </div>
                          <div class="col-lg-2"></div>
                          
                        </div>

                        <div class="row justify-content-center pl-2">

                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label h6 font-weight-bold">{{ __('Followups') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input followups" name="section[]" value="followups"  id="followups" {{ $data->sectionCheck('followups') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="followups">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label h6 font-weight-bold">{{ __('Delete') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input followups_delete" name="section[]" value="followups_delete"  id="followups_delete" {{ $data->sectionCheck('followups_delete') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="followups_delete">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label h6 font-weight-bold">{{ __('Status') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input followups_status" name="section[]" value="followups_status"  id="followups_status" {{ $data->sectionCheck('followups_status') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="followups_status">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                          </div>
                          <div class="col-lg-2"></div>
                          
                        </div>


                        <div class="row justify-content-center pl-2 pb-1">

                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label h6 font-weight-bold">{{ __('Contact') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input contact_list" name="section[]" value="contact_list"  id="contact_list" {{ $data->sectionCheck('contact_list') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 contact round" for="contact_list">
                              </label>
                            </div>
                          </div>


                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Delete') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input contact_delete" name="section[]" value="contact_delete"  id="contact_delete" {{ $data->sectionCheck('contact_delete') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 contact round" for="contact_delete">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Status') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input contact_status" name="section[]" value="contact_status"  id="contact_status" {{ $data->sectionCheck('contact_status') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 contact round" for="contact_status">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                    
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            
                          </div>
                          <div class="col-lg-2"></div>

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="font-weight-bold pb-1">{{ __('Franchise (Only For Franchise Role)') }} </h5>
                            </div>
                        </div>
                        <div class="row justify-content-center pl-2">

                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label h6 font-weight-bold">{{ __('Franchise Service') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input franchise_services" name="section[]" value="franchise_services"  id="franchise_services" {{ $data->sectionCheck('franchise_services') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="franchise_services">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Edit') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input franchise_services_edit" name="section[]" value="franchise_services_edit"  id="franchise_services_edit" {{ $data->sectionCheck('franchise_services_edit') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="franchise_services_edit">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            {{--<!-- <label class="control-label">{{ __('Delete') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input franchise_services_delete" name="section[]" value="franchise_services_delete"  id="franchise_services_delete" {{ $data->sectionCheck('franchise_services_delete') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="franchise_services_delete">
                              </label>
                            </div> -->--}}
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            {{--<!-- <label class="control-label">{{ __('Add') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input franchise_services_add" name="section[]" value="franchise_services_add"  id="franchise_services_add" {{ $data->sectionCheck('franchise_services_add') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="franchise_services_add">
                              </label>
                            </div> -->--}}
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                          </div>
                          <div class="col-lg-2"></div>

                        </div>

                        {{--<!-- <div class="row justify-content-center pl-2">

                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label h6 font-weight-bold">{{ __('Franchise Package') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input franchise_packages" name="section[]" value="franchise_packages"  id="franchise_packages" {{ $data->sectionCheck('franchise_packages') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="franchise_packages">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Add') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input franchise_packages_add" name="section[]" value="franchise_packages_add"  id="franchise_packages_add" {{ $data->sectionCheck('franchise_packages_add') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="franchise_packages_add">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Edit') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input franchise_packages_edit" name="section[]" value="franchise_packages_edit"  id="franchise_packages_edit" {{ $data->sectionCheck('franchise_packages_edit') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="franchise_packages_edit">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Delete') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input franchise_packages_delete" name="section[]" value="franchise_packages_delete"  id="franchise_packages_delete" {{ $data->sectionCheck('franchise_packages_delete') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="franchise_packages_delete">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Manage Media') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input franchise_packages_media" name="section[]" value="franchise_packages_media"  id="franchise_packages_media" {{ $data->sectionCheck('franchise_packages_media') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="franchise_packages_media">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2"></div>

                        </div> -->--}}

                        <div class="row justify-content-center pl-2">

                            <div class="col-lg-2 d-flex justify-content-start">
                              <label class="control-label h6 font-weight-bold">{{ __('Franchise Orders') }} *</label>
                              <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                                <input type="checkbox" class="custom-control-input franchise_orders" name="section[]" value="franchise_orders"  id="franchise_orders" {{ $data->sectionCheck('franchise_orders') ? 'checked' : '' }}>
                                <label class="custom-control-label mr-1 slider round" for="franchise_orders">
                                </label>
                              </div>
                            </div>


                            <div class="col-lg-2 d-flex justify-content-start">
                              <label class="control-label">{{ __('Franchise View') }} *</label>
                              <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                                <input type="checkbox" class="custom-control-input franchise_orders_view" name="section[]" value="franchise_orders_view"  id="franchise_orders_view" {{ $data->sectionCheck('franchise_orders_view') ? 'checked' : '' }}>
                                <label class="custom-control-label mr-1 slider round" for="franchise_orders_view">
                                </label>
                              </div>
                            </div>
                            <div class="col-lg-2 d-flex justify-content-start">
                              <label class="control-label">{{ __('Franchise Status') }} *</label>
                              <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                                <input type="checkbox" class="custom-control-input franchise_orders_status" name="section[]" value="franchise_orders_status"  id="franchise_orders_status" {{ $data->sectionCheck('franchise_orders_status') ? 'checked' : '' }}>
                                <label class="custom-control-label mr-1 slider round" for="franchise_orders_status">
                                </label>
                              </div>
                            </div>
                            <div class="col-lg-2 d-flex justify-content-start">
                              <label class="control-label">{{ __('Franchise Invoice') }} *</label>
                              <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                                <input type="checkbox" class="custom-control-input franchise_orders_invoice" name="section[]" value="franchise_orders_invoice"  id="franchise_orders_invoice" {{ $data->sectionCheck('franchise_orders_invoice') ? 'checked' : '' }}>
                                <label class="custom-control-label mr-1 slider round" for="franchise_orders_invoice">
                                </label>
                              </div>
                            </div>
                            <div class="col-lg-2 d-flex justify-content-start">
                            </div>
                            <div class="col-lg-2 d-flex justify-content-start">
                            </div>

                        </div>

                        {{--<!-- <div class="row justify-content-center pl-2">

                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label h6 font-weight-bold">{{ __('Franchise Offer') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input franchise_offers" name="section[]" value="franchise_offers"  id="franchise_offers" {{ $data->sectionCheck('franchise_offers') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="franchise_offers">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Add') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input franchise_offers_add" name="section[]" value="franchise_offers_add"  id="franchise_offers_add" {{ $data->sectionCheck('franchise_offers_add') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="franchise_offers_add">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Edit') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input franchise_offers_edit" name="section[]" value="franchise_offers_edit"  id="franchise_offers_edit" {{ $data->sectionCheck('franchise_offers_edit') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="franchise_offers_edit">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Delete') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input franchise_offers_delete" name="section[]" value="franchise_offers_delete"  id="franchise_offers_delete" {{ $data->sectionCheck('franchise_offers_delete') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="franchise_offers_delete">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                          </div>
                          <div class="col-lg-2"></div>

                        </div> -->--}}

                        <div class="row justify-content-center pl-2">

                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label h6 font-weight-bold">{{ __('Franchise Timing') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input franchise_timing" name="section[]" value="franchise_timing"  id="franchise_timing" {{ $data->sectionCheck('franchise_timing') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="franchise_timing">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Add') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input franchise_timing_add" name="section[]" value="franchise_timing_add"  id="franchise_timing_add" {{ $data->sectionCheck('franchise_timing_add') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="franchise_timing_add">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Edit') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input franchise_timing_edit" name="section[]" value="franchise_timing_edit"  id="franchise_timing_edit" {{ $data->sectionCheck('franchise_timing_edit') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="franchise_timing_edit">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                            <label class="control-label">{{ __('Delete') }} *</label>
                            <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                              <input type="checkbox" class="custom-control-input franchise_timing_delete" name="section[]" value="franchise_timing_delete"  id="franchise_timing_delete" {{ $data->sectionCheck('franchise_timing_delete') ? 'checked' : '' }}>
                              <label class="custom-control-label mr-1 slider round" for="franchise_timing_delete">
                              </label>
                            </div>
                          </div>
                          <div class="col-lg-2 d-flex justify-content-start">
                          </div>
                          <div class="col-lg-2"></div>

                        </div>


                        <div class="row justify-content-center pl-2">

                            <div class="col-lg-2 d-flex justify-content-start">
                              <label class="control-label h6 font-weight-bold">{{ __('Franchise Worker') }} *</label>
                              <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                                <input type="checkbox" class="custom-control-input franchise_worker" name="section[]" value="franchise_worker"  id="franchise_worker" {{ $data->sectionCheck('franchise_worker') ? 'checked' : '' }}>
                                <label class="custom-control-label mr-1 slider round" for="franchise_worker">
                                </label>
                              </div>
                            </div>
                            <div class="col-lg-2 d-flex justify-content-start">
                              <label class="control-label">{{ __('Add') }} *</label>
                              <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                                <input type="checkbox" class="custom-control-input franchise_worker_add" name="section[]" value="franchise_worker_add"  id="franchise_worker_add" {{ $data->sectionCheck('franchise_worker_add') ? 'checked' : '' }}>
                                <label class="custom-control-label mr-1 slider round" for="franchise_worker_add">
                                </label>
                              </div>
                            </div>
                            <div class="col-lg-2 d-flex justify-content-start">
                              <label class="control-label">{{ __('Edit') }} *</label>
                              <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                                <input type="checkbox" class="custom-control-input franchise_worker_edit" name="section[]" value="franchise_worker_edit"  id="franchise_worker_edit" {{ $data->sectionCheck('franchise_worker_edit') ? 'checked' : '' }}>
                                <label class="custom-control-label mr-1 slider round" for="franchise_worker_edit">
                                </label>
                              </div>
                            </div>
                            <div class="col-lg-2 d-flex justify-content-start">
                              <label class="control-label">{{ __('Delete') }} *</label>
                              <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                                <input type="checkbox" class="custom-control-input franchise_worker_delete" name="section[]" value="franchise_worker_delete"  id="franchise_worker_delete" {{ $data->sectionCheck('franchise_worker_delete') ? 'checked' : '' }}>
                                <label class="custom-control-label mr-1 slider round" for="franchise_worker_delete">
                                </label>
                              </div>
                            </div>
                            <div class="col-lg-2 d-flex justify-content-start">
                              <label class="control-label">{{ __('Status') }} *</label>
                              <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                                <input type="checkbox" class="custom-control-input franchise_worker_status" name="section[]" value="franchise_worker_status"  id="franchise_worker_status" {{ $data->sectionCheck('franchise_worker_status') ? 'checked' : '' }}>
                                <label class="custom-control-label mr-1 slider round" for="franchise_worker_status">
                                </label>
                              </div>
                            </div>
                            <div class="col-lg-2"></div>
                            
                        </div>

                        <div class="row pl-2">

                            <div class="col-lg-2 d-flex justify-content-start">
                              <label class="control-label h6 font-weight-bold">{{ __('Manage Credit') }} *</label>
                              <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                                <input type="checkbox" class="custom-control-input franchise_credits" name="section[]" value="franchise_credits"  id="franchise_credits" {{ $data->sectionCheck('franchise_credits') ? 'checked' : '' }}>
                                <label class="custom-control-label mr-1 slider round" for="franchise_credits">
                                </label>
                              </div>
                            </div>
                            <div class="col-lg-2 d-flex justify-content-start">
                                <label class="control-label">{{ __('Add') }} *</label>
                                <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                                  <input type="checkbox" class="custom-control-input franchise_credits_add" name="section[]" value="franchise_credits_add"  id="franchise_credits_add" {{ $data->sectionCheck('franchise_credits_add') ? 'checked' : '' }}>
                                  <label class="custom-control-label mr-1 slider round" for="franchise_credits_add">
                                  </label>
                                </div>
                            </div>

                            <div class="col-lg-2 d-flex justify-content-start">
                            </div>
                            <div class="col-lg-2"></div>

                        </div>


                        <!--Start Code for Request Quotes-->
                        <div class="row justify-content-center pl-2">

                        <div class="col-lg-2 d-flex justify-content-start">
                          <label class="control-label h6 font-weight-bold">{{ __('Request') }} *</label>
                          <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                            <input type="checkbox" class="custom-control-input request_list" name="section[]" value="request_list"  id="request_list" {{ $data->sectionCheck('request_list') ? 'checked' : '' }}>
                            <label class="custom-control-label mr-1 request round" for="request_list">
                            </label>
                          </div>
                        </div>


                        <div class="col-lg-2 d-flex justify-content-start">
                          <label class="control-label">{{ __('Delete') }} *</label>
                          <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                            <input type="checkbox" class="custom-control-input request_delete" name="section[]" value="request_delete"  id="request_delete" {{ $data->sectionCheck('request_delete') ? 'checked' : '' }}>
                            <label class="custom-control-label mr-1 request round" for="request_delete">
                            </label>
                          </div>
                        </div>
                        <div class="col-lg-2 d-flex justify-content-start">
                          <label class="control-label">{{ __('Status') }} *</label>
                          <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                            <input type="checkbox" class="custom-control-input request_status" name="section[]" value="request_status"  id="request_status" {{ $data->sectionCheck('request_status') ? 'checked' : '' }}>
                            <label class="custom-control-label mr-1 request round" for="request_status">
                            </label>
                          </div>
                        </div>
                        <div class="col-lg-2 d-flex justify-content-start">

                        </div>
                        <div class="col-lg-2 d-flex justify-content-start">
                          
                        </div>
                        <div class="col-lg-2"></div>

                        </div>

                        <!--End Code for Request Quotes-->

                        <div class="row justify-content-center pl-2">

                            <div class="col-lg-2 d-flex justify-content-start">
                              <label class="control-label h6 font-weight-bold">{{ __('Franchise Profile') }} *</label>
                              <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                                <input type="checkbox" class="custom-control-input franchise_profile" name="section[]" value="franchise_profile"  id="franchise_profile" {{ $data->sectionCheck('franchise_profile') ? 'checked' : '' }}>
                                <label class="custom-control-label mr-1 slider round" for="franchise_profile">
                                </label>
                              </div>
                            </div>
                            <div class="col-lg-2 d-flex justify-content-start">
                            </div>
                            <div class="col-lg-2 d-flex justify-content-start">
                            </div>
                            <div class="col-lg-2 d-flex justify-content-start">
                            </div>
                            <div class="col-lg-2 d-flex justify-content-start">
                            </div>
                            <div class="col-lg-2"></div>

                        </div>
                        <div class="row justify-content-center pl-2 pb-2">

                            <div class="col-lg-2 d-flex justify-content-start">
                              <label class="control-label h6 font-weight-bold">{{ __('Account') }} *</label>
                              <div class="custom-control custom-switch custom-control-inline mb-1 switch ml-auto">
                                <input type="checkbox" class="custom-control-input franchise_account" name="section[]" value="franchise_account"  id="franchise_account" {{ $data->sectionCheck('franchise_account') ? 'checked' : '' }}>
                                <label class="custom-control-label mr-1 slider round" for="franchise_account">
                                </label>
                              </div>
                            </div>
                            <div class="col-lg-2 d-flex justify-content-start">
                            </div>
                            <div class="col-lg-2 d-flex justify-content-start">
                            </div>
                            <div class="col-lg-2 d-flex justify-content-start">
                            </div>
                            <div class="col-lg-2 d-flex justify-content-start">
                            </div>
                            <div class="col-lg-2"></div>

                        </div>



                        <div class="row">
                          <div class="col-lg-5">
                            <div class="left-area">

                            </div>
                          </div>
                          <div class="col-lg-7">
                            <button class="addProductSubmit-btn btn btn-dark mr-1" type="submit">{{ __('Save') }}</button>
                          </div>
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
            </div>
        </section>
        <!-- // Basic Vertical form layout section end -->
    </div>
</div>
@endsection
@section('scripts')
<!-- BEGIN: Page Vendor JS-->
<script src="{{ asset('assets/admin-assets/js/myscript.js') }}"></script>
<script src="{{ asset('assets/admin-assets/js/load.js') }}"></script>
<!-- END: Page Vendor JS-->

<script>

    $('.manage_customer').change(function() {
        if ($(this).is(':checked')) {
            $('.manage_customer_add').prop('checked', true);
            $('.manage_customer_delete').prop('checked', true);
        }else{
            $('.manage_customer_add').prop('checked', false);
            $('.manage_customer_delete').prop('checked', false);
        }
    });
    $('.manage_customer_add,.manage_customer_delete').change(function() {
        if($('.manage_customer_add').is(':checked') || $('.manage_customer_delete').is(':checked')){
            $('.manage_customer').prop('checked', true);
        }
    });

    $('.category-check').change(function() {
        if ($(this).is(':checked')) {
            $('.categories_add').prop('checked', true);
            $('.categories_update').prop('checked', true);
            $('.categories_delete').prop('checked', true);
            $('.categories_status').prop('checked', true);
        }else{
            $('.categories_add').prop('checked', false);
            $('.categories_update').prop('checked', false);
            $('.categories_delete').prop('checked', false);
            $('.categories_status').prop('checked', false);
        }
    });
    $('.categories_add,.categories_update,.categories_delete,.categories_status').change(function() {
        if($('.categories_add').is(':checked') || $('.categories_update').is(':checked') || $('.categories_delete').is(':checked') || $('.categories_status').is(':checked')){
            $('.category-check').prop('checked', true);
        }
    });


    $('.sub_categories').change(function() {
        if ($(this).is(':checked')) {
            $('.sub_categories_add').prop('checked', true);
            $('.sub_categories_edit').prop('checked', true);
            $('.sub_categories_delete').prop('checked', true);
            $('.sub_categories_status').prop('checked', true);
        }else{
            $('.sub_categories_add').prop('checked', false);
            $('.sub_categories_edit').prop('checked', false);
            $('.sub_categories_delete').prop('checked', false);
            $('.sub_categories_status').prop('checked', false);
        }
    });
    $('.sub_categories_add,.sub_categories_edit,.sub_categories_delete,.sub_categories_status').change(function() {
        if($('.sub_categories_add').is(':checked') || $('.sub_categories_edit').is(':checked') || $('.sub_categories_delete').is(':checked') || $('.sub_categories_status').is(':checked')){
            $('.sub_categories').prop('checked', true);
        }
    });


    $('.services').change(function() {
        if ($(this).is(':checked')) {
            $('.services_add').prop('checked', true);
            $('.services_edit').prop('checked', true);
            $('.services_delete').prop('checked', true);
            $('.services_status').prop('checked', true);
            $('.services_media').prop('checked', true);
        }else{
            $('.services_add').prop('checked', false);
            $('.services_edit').prop('checked', false);
            $('.services_delete').prop('checked', false);
            $('.services_status').prop('checked', false);
            $('.services_media').prop('checked', false);
        }
    });
    $('.services_add,.services_edit,.services_delete,.services_status,.services_media').change(function() {
        if($('.services_add').is(':checked') || $('.services_edit').is(':checked') || $('.services_delete').is(':checked') || $('.services_status').is(':checked') || $('.services_media').is(':checked')){
            $('.services').prop('checked', true);
        }
    });


    $('.best_services').change(function() {
        if ($(this).is(':checked')) {
            $('.best_services_add').prop('checked', true);
            $('.best_services_edit').prop('checked', true);
            $('.best_services_delete').prop('checked', true);
            $('.best_services_status').prop('checked', true);
        }else{
            $('.best_services_add').prop('checked', false);
            $('.best_services_edit').prop('checked', false);
            $('.best_services_delete').prop('checked', false);
            $('.best_services_status').prop('checked', false);
        }
    });
    $('.best_services_add,.best_services_edit,.best_services_delete,.best_services_status').change(function() {
        if($('.best_services_add').is(':checked') || $('.best_services_edit').is(':checked') || $('.best_services_delete').is(':checked') || $('.best_services_status').is(':checked')){
            $('.best_services').prop('checked', true);
        }
    });

    $('.service_specification').change(function() {
        if ($(this).is(':checked')) {
            $('.service_specification_add').prop('checked', true);
            $('.service_specification_edit').prop('checked', true);
            $('.service_specification_delete').prop('checked', true);
            $('.service_specification_status').prop('checked', true);
        }else{
            $('.service_specification_add').prop('checked', false);
            $('.service_specification_edit').prop('checked', false);
            $('.service_specification_delete').prop('checked', false);
            $('.service_specification_status').prop('checked', false);
        }
    });
    $('.service_specification_add,.service_specification_edit,.service_specification_delete,.service_specification_status').change(function() {
        if($('.service_specification_add').is(':checked') || $('.service_specification_edit').is(':checked') || $('.service_specification_delete').is(':checked') || $('.service_specification_status').is(':checked')){
            $('.service_specification').prop('checked', true);
        }
    });


    $('.service_faq').change(function() {
        if ($(this).is(':checked')) {
            $('.service_faq_add').prop('checked', true);
            $('.service_faq_edit').prop('checked', true);
            $('.service_faq_delete').prop('checked', true);
            $('.service_faq_status').prop('checked', true);
        }else{
            $('.service_faq_add').prop('checked', false);
            $('.service_faq_edit').prop('checked', false);
            $('.service_faq_delete').prop('checked', false);
            $('.service_faq_status').prop('checked', false);
        }
    });
    $('.service_faq_add,.service_faq_edit,.service_faq_delete,.service_faq_status').change(function() {
        if($('.service_faq_add').is(':checked') || $('.service_faq_edit').is(':checked') || $('.service_faq_delete').is(':checked') || $('.service_faq_status').is(':checked')){
            $('.service_faq').prop('checked', true);
        }
    });


    $('.packages').change(function() {
        if ($(this).is(':checked')) {
            $('.packages_add').prop('checked', true);
            $('.packages_edit').prop('checked', true);
            $('.packages_delete').prop('checked', true);
            $('.packages_status').prop('checked', true);
            $('.packages_media').prop('checked', true);
        }else{
            $('.packages_add').prop('checked', false);
            $('.packages_edit').prop('checked', false);
            $('.packages_delete').prop('checked', false);
            $('.packages_status').prop('checked', false);
            $('.packages_media').prop('checked', false);
        }
    });
    $('.packages_add,.packages_edit,.packages_delete,.packages_media').change(function() {
        if($('.packages_add').is(':checked') || $('.packages_edit').is(':checked') || $('.packages_delete').is(':checked') || $('.packages_media').is(':checked')){
            $('.packages').prop('checked', true);
        }
    });


    $('.leads').change(function() {
        if ($(this).is(':checked')) {
            $('.leads_add').prop('checked', true);
            $('.leads_edit').prop('checked', true);
            $('.leads_delete').prop('checked', true);
            $('.leads_status').prop('checked', true);
            $('.leads_add_user').prop('checked', true);
        }else{
            $('.leads_add').prop('checked', false);
            $('.leads_edit').prop('checked', false);
            $('.leads_delete').prop('checked', false);
            $('.leads_status').prop('checked', false);
            $('.leads_add_user').prop('checked', false);
        }
    });
    $('.leads_add,.leads_edit,.leads_delete,.leads_status,.leads_add_user').change(function() {
        if($('.leads_add').is(':checked') || $('.leads_edit').is(':checked') || $('.leads_delete').is(':checked') || $('.leads_status').is(':checked') || $('.leads_add_user').is(':checked')){
            $('.leads').prop('checked', true);
        }
    });


    $('.franchises').change(function() {
        if ($(this).is(':checked')) {
            $('.franchises_add').prop('checked', true);
            $('.franchises_edit').prop('checked', true);
            $('.franchises_delete').prop('checked', true);
            $('.franchises_status').prop('checked', true);
        }else{
            $('.franchises_add').prop('checked', false);
            $('.franchises_edit').prop('checked', false);
            $('.franchises_delete').prop('checked', false);
            $('.franchises_status').prop('checked', false);
        }
    });
    $('.franchises_add,.franchises_edit,.franchises_delete,.franchises_status').change(function() {
        if($('.franchises_add').is(':checked') || $('.franchises_edit').is(':checked') || $('.franchises_delete').is(':checked') || $('.franchises_status').is(':checked')){
            $('.franchises').prop('checked', true);
        }
    });


    $('.offers').change(function() {
        if ($(this).is(':checked')) {
            $('.offers_add').prop('checked', true);
            $('.offers_edit').prop('checked', true);
            $('.offers_delete').prop('checked', true);
            $('.offers_status').prop('checked', true);
        }else{
            $('.offers_add').prop('checked', false);
            $('.offers_edit').prop('checked', false);
            $('.offers_delete').prop('checked', false);
            $('.offers_status').prop('checked', false);
        }
    });
    $('.offers_add,.offers_edit,.offers_delete,.offers_status').change(function() {
        if($('.offers_add').is(':checked') || $('.offers_edit').is(':checked') || $('.offers_delete').is(':checked') || $('.offers_status').is(':checked')){
            $('.offers').prop('checked', true);
        }
    });

    $('.best_offers').change(function() {
        if ($(this).is(':checked')) {
            $('.best_offers_add').prop('checked', true);
            $('.best_offers_edit').prop('checked', true);
            $('.best_offers_delete').prop('checked', true);
            $('.best_offers_status').prop('checked', true);
        }else{
            $('.best_offers_add').prop('checked', false);
            $('.best_offers_edit').prop('checked', false);
            $('.best_offers_delete').prop('checked', false);
            $('.best_offers_status').prop('checked', false);
        }
    });
    $('.best_offers_add,.best_offers_edit,.best_offers_delete,.best_offers_status').change(function() {
        if($('.best_offers_add').is(':checked') || $('.best_offers_edit').is(':checked') || $('.best_offers_delete').is(':checked') || $('.best_offers_status').is(':checked')){
            $('.best_offers').prop('checked', true);
        }
    });


    $('.gifts').change(function() {
        if ($(this).is(':checked')) {
            $('.gifts_add').prop('checked', true);
            $('.gifts_edit').prop('checked', true);
            $('.gifts_delete').prop('checked', true);
            $('.gifts_status').prop('checked', true);
            $('.gifts_send').prop('checked', true);
        }else{
            $('.gifts_add').prop('checked', false);
            $('.gifts_edit').prop('checked', false);
            $('.gifts_delete').prop('checked', false);
            $('.gifts_status').prop('checked', false);
            $('.gifts_send').prop('checked', false);
        }
    });
    $('.gifts_add,.gifts_edit,.gifts_delete,.gifts_status,.gifts_send').change(function() {
        if($('.gifts_add').is(':checked') || $('.gifts_edit').is(':checked') || $('.gifts_delete').is(':checked') || $('.gifts_status').is(':checked') || $('.gifts_send').is(':checked')){
            $('.gifts').prop('checked', true);
        }
    });


    $('.orders').change(function() {
        if ($(this).is(':checked')) {
            $('.orders_view').prop('checked', true);
            $('.orders_delete').prop('checked', true);
            $('.orders_status').prop('checked', true);
            $('.orders_invoice').prop('checked', true);
            $('.franchise_orders_assigned').prop('checked', true);
        }else{
            $('.orders_view').prop('checked', false);
            $('.orders_delete').prop('checked', false);
            $('.orders_status').prop('checked', false);
            $('.orders_invoice').prop('checked', false);
            $('.franchise_orders_assigned').prop('checked', false);
        }
    });
    $('.orders_view,.orders_delete,.orders_status,.orders_invoice,.franchise_orders_assigned').change(function() {
        if($('.orders_view').is(':checked') || $('.orders_delete').is(':checked') || $('.orders_status').is(':checked') || $('.orders_invoice').is(':checked') || $('.franchise_orders_assigned').is(':checked')){
            $('.orders').prop('checked', true);
        }
    });


    $('.unallocated_orders').change(function() {
        if ($(this).is(':checked')) {
            $('.unallocated_orders_view').prop('checked', true);
            $('.unallocated_orders_delete').prop('checked', true);
            $('.unallocated_orders_status').prop('checked', true);
            $('.unallocated_orders_assigned').prop('checked', true);
        }else{
            $('.unallocated_orders_view').prop('checked', false);
            $('.unallocated_orders_delete').prop('checked', false);
            $('.unallocated_orders_status').prop('checked', false);
            $('.unallocated_orders_assigned').prop('checked', false);
        }
    });
    $('.unallocated_orders_view,.unallocated_orders_delete,.unallocated_orders_status,.unallocated_orders_assigned').change(function() {
        if($('.unallocated_orders_view').is(':checked') || $('.unallocated_orders_delete').is(':checked') || $('.unallocated_orders_status').is(':checked') || $('.unallocated_orders_assigned').is(':checked')){
            $('.unallocated_orders').prop('checked', true);
        }
    });

    $('.franchise_orders').change(function() {
        if ($(this).is(':checked')) {
            $('.franchise_orders_view').prop('checked', true);
            $('.franchise_orders_invoice').prop('checked', true);
            $('.franchise_orders_status').prop('checked', true);
        }else{
            $('.franchise_orders_view').prop('checked', false);
            $('.franchise_orders_invoice').prop('checked', false);
            $('.franchise_orders_status').prop('checked', false);
        }
    });
    $('.franchise_orders_view,.franchise_orders_invoice,.franchise_orders_status').change(function() {
        if($('.franchise_orders_view').is(':checked') || $('.franchise_orders_invoice').is(':checked') || $('.franchise_orders_status').is(':checked')){
            $('.franchise_orders').prop('checked', true);
        }
    });


    // $('.franchise_assigned').change(function() {
    //     if ($(this).is(':checked')) {
    //         $('.franchise_assigned_view').prop('checked', true);
    //     }else{
    //         $('.franchise_assigned_view').prop('checked', false);
    //     }
    // });
    // $('.franchise_assigned_view').change(function() {
    //     if($('.franchise_assigned_view').is(':checked')){
    //         $('.franchise_assigned').prop('checked', true);
    //     }
    // });


    $('.accounts').change(function() {
        if ($(this).is(':checked')) {
            $('.accounts_income').prop('checked', true);
            $('.accounts_franchise_fees').prop('checked', true);
            $('.accounts_franchise_outstandings').prop('checked', true);
        }else{
            $('.accounts_income').prop('checked', false);
            $('.accounts_franchise_fees').prop('checked', false);
            $('.accounts_franchise_outstandings').prop('checked', false);
        }
    });
    $('.accounts_income,.accounts_franchise_fees,.accounts_franchise_outstandings').change(function() {
        if($('.accounts_income').is(':checked') || $('.accounts_franchise_fees').is(':checked') || $('.accounts_franchise_outstandings').is(':checked')){
            $('.accounts').prop('checked', true);
        }
    });


    $('.payments').change(function() {
        if ($(this).is(':checked')) {
            $('.payments_add').prop('checked', true);
            $('.payments_edit').prop('checked', true);
            $('.payments_delete').prop('checked', true);
        }else{
            $('.payments_add').prop('checked', false);
            $('.payments_edit').prop('checked', false);
            $('.payments_delete').prop('checked', false);
        }
    });
    $('.payments_add,.payments_edit,.payments_delete').change(function() {
        if($('.payments_add').is(':checked') || $('.payments_edit').is(':checked') || $('.payments_delete').is(':checked')){
            $('.payments').prop('checked', true);
        }
    });

    $('.credit_plans').change(function() {
        if ($(this).is(':checked')) {
            $('.credit_plans_add').prop('checked', true);
            $('.credit_plans_edit').prop('checked', true);
            $('.credit_plans_delete').prop('checked', true);
            $('.credit_plans_status').prop('checked', true);
            $('.credit_Price_edit').prop('checked', true);
        }else{
            $('.credit_plans_add').prop('checked', false);
            $('.credit_plans_edit').prop('checked', false);
            $('.credit_plans_delete').prop('checked', false);
            $('.credit_plans_status').prop('checked', false);
            $('.credit_Price_edit').prop('checked', false);
        }
    });
    $('.credit_plans_add,.credit_plans_edit,.credit_plans_delete,.credit_plans_status,.credit_Price_edit').change(function() {
        if($('.credit_plans_add').is(':checked') || $('.credit_plans_edit').is(':checked') || $('.credit_plans_delete').is(':checked') || $('.credit_plans_status').is(':checked') || $('.credit_Price_edit').is(':checked')){
            $('.credit_plans').prop('checked', true);
        }
    });


    $('.service_ratings').change(function() {
        if ($(this).is(':checked')) {
            $('.service_ratings_add').prop('checked', true);
            $('.service_ratings_edit').prop('checked', true);
            $('.service_ratings_delete').prop('checked', true);
            $('.service_ratings_status').prop('checked', true);
        }else{
            $('.service_ratings_add').prop('checked', false);
            $('.service_ratings_edit').prop('checked', false);
            $('.service_ratings_delete').prop('checked', false);
            $('.service_ratings_status').prop('checked', false);
        }
    });
    $('.service_ratings_add,.service_ratings_edit,.service_ratings_delete,.service_ratings_status').change(function() {
        if($('.service_ratings_add').is(':checked') || $('.service_ratings_edit').is(':checked') || $('.service_ratings_delete').is(':checked') || $('.service_ratings_status').is(':checked')){
            $('.service_ratings').prop('checked', true);
        }
    });


    $('.package_ratings').change(function() {
        if ($(this).is(':checked')) {
            $('.package_ratings_add').prop('checked', true);
            $('.package_ratings_edit').prop('checked', true);
            $('.package_ratings_delete').prop('checked', true);
            $('.package_ratings_status').prop('checked', true);
        }else{
            $('.package_ratings_add').prop('checked', false);
            $('.package_ratings_edit').prop('checked', false);
            $('.package_ratings_delete').prop('checked', false);
            $('.package_ratings_status').prop('checked', false);
        }
    });
    $('.package_ratings_add,.package_ratings_edit,.package_ratings_delete,.package_ratings_status').change(function() {
        if($('.package_ratings_add').is(':checked') || $('.package_ratings_edit').is(':checked') || $('.package_ratings_delete').is(':checked') || $('.package_ratings_status').is(':checked')){
            $('.package_ratings').prop('checked', true);
        }
    });

    $('.testimonial').change(function() {
        if ($(this).is(':checked')) {
            $('.testimonial_add').prop('checked', true);
            $('.testimonial_edit').prop('checked', true);
            $('.testimonial_status').prop('checked', true);
        }else{
            $('.testimonial_add').prop('checked', false);
            $('.testimonial_edit').prop('checked', false);
            $('.testimonial_status').prop('checked', false);
        }
    });
    $('.testimonial_add,.testimonial_edit,.testimonial_status').change(function() {
        if($('.testimonial_add').is(':checked') || $('.testimonial_edit').is(':checked') || $('.testimonial_status').is(':checked')){
            $('.testimonial').prop('checked', true);
        }
    });
    // $('.order_review').change(function() {
    //     if ($(this).is(':checked')) {
    //         $('.order_review_detail_view').prop('checked', true);
    //     }else{
    //         $('.order_review_detail_view').prop('checked', false);
    //     }
    // });
    // $('.order_review_detail_view').change(function() {
    //     if($('.order_review_detail_view').is(':checked')){
    //         $('.order_review').prop('checked', true);
    //     }
    // });

    $('.slider_list').change(function() {
        if ($(this).is(':checked')) {
            $('.slider_add').prop('checked', true);
            $('.slider_edit').prop('checked', true);
            $('.slider_delete').prop('checked', true);
            $('.slider_status').prop('checked', true);
        }else{
            $('.slider_add').prop('checked', false);
            $('.slider_edit').prop('checked', false);
            $('.slider_delete').prop('checked', false);
            $('.slider_status').prop('checked', false);
        }
    });
    $('.slider_add,.slider_edit,.slider_delete,.slider_status').change(function() {
        if($('.slider_add').is(':checked') || $('.slider_edit').is(':checked') || $('.slider_delete').is(':checked') || $('.slider_status').is(':checked')){
            $('.slider_list').prop('checked', true);
        }
    });

    $('.aboutus_list').change(function() {
        if ($(this).is(':checked')) {
            $('.aboutus_add').prop('checked', true);
            $('.aboutus_edit').prop('checked', true);
            $('.aboutus_delete').prop('checked', true);
        }else{
            $('.aboutus_add').prop('checked', false);
            $('.aboutus_edit').prop('checked', false);
            $('.aboutus_delete').prop('checked', false);
        }
    });
    $('.aboutus_add,.aboutus_edit,.aboutus_delete').change(function() {
        if($('.aboutus_add').is(':checked') || $('.aboutus_edit').is(':checked') || $('.aboutus_delete').is(':checked')){
            $('.aboutus_list').prop('checked', true);
        }
    });


    $('.blog').change(function() {
        if ($(this).is(':checked')) {
            $('.blog_add').prop('checked', true);
            $('.blog_edit').prop('checked', true);
            $('.blog_delete').prop('checked', true);
            $('.blog_status').prop('checked', true);
        }else{
            $('.blog_add').prop('checked', false);
            $('.blog_edit').prop('checked', false);
            $('.blog_delete').prop('checked', false);
            $('.blog_status').prop('checked', false);
        }
    });
    $('.blog_add,.blog_edit,.blog_delete,.blog_status').change(function() {
        if($('.blog_add').is(':checked') || $('.blog_edit').is(':checked') || $('.blog_delete').is(':checked') || $('.blog_status').is(':checked')){
            $('.blog').prop('checked', true);
        }
    });


    $('.news_letter').change(function() {
        if ($(this).is(':checked')) {
            $('.send_news_letter').prop('checked', true);
            $('.news_letter_delete').prop('checked', true);
        }else{
            $('.send_news_letter').prop('checked', false);
            $('.news_letter_delete').prop('checked', false);
        }
    });
    $('.send_news_letter,.news_letter_delete').change(function() {
        if($('.send_news_letter').is(':checked') || $('.news_letter_delete').is(':checked')){
            $('.news_letter').prop('checked', true);
        }
    });


    $('.request_quotes').change(function() {
        if ($(this).is(':checked')) {
            $('.request_quotes_delete').prop('checked', true);
            $('.request_quotes_status').prop('checked', true);
        }else{
            $('.request_quotes_delete').prop('checked', false);
            $('.request_quotes_status').prop('checked', false);
        }
    });
    $('.request_quotes_delete,.request_quotes_status').change(function() {
        if($('.request_quotes_delete').is(':checked') || $('.request_quotes_status').is(':checked')){
            $('.request_quotes').prop('checked', true);
        }
    });

    $('.followups').change(function() {
        if ($(this).is(':checked')) {
            $('.followups_delete').prop('checked', true);
            $('.followups_status').prop('checked', true);
        }else{
            $('.followups_delete').prop('checked', false);
            $('.followups_status').prop('checked', false);
        }
    });
    $('.followups_delete,.followups_status').change(function() {
        if($('.followups_delete').is(':checked') || $('.followups_status').is(':checked')){
            $('.followups').prop('checked', true);
        }
    });

    $('.contact_list').change(function() {
        if ($(this).is(':checked')) {
            $('.contact_delete').prop('checked', true);
            $('.contact_status').prop('checked', true);
        }else{
            $('.contact_delete').prop('checked', false);
            $('.contact_status').prop('checked', false);
        }
    });
    $('.contact_delete,.contact_status').change(function() {
        if($('.contact_delete').is(':checked') || $('.contact_status').is(':checked')){
            $('.contact_list').prop('checked', true);
        }
    });

    $('.franchise_services').change(function() {
        if ($(this).is(':checked')) {
            $('.franchise_services_add').prop('checked', true);
            $('.franchise_services_edit').prop('checked', true);
            $('.franchise_services_delete').prop('checked', true);
        }else{
            $('.franchise_services_add').prop('checked', false);
            $('.franchise_services_edit').prop('checked', false);
            $('.franchise_services_delete').prop('checked', false);
        }
    });
    $('.franchise_services_add,.franchise_services_edit,.franchise_services_delete').change(function() {
        if($('.franchise_services_add').is(':checked') || $('.franchise_services_edit').is(':checked') || $('.franchise_services_delete').is(':checked')){
            $('.franchise_services').prop('checked', true);
        }
    });


    $('.franchise_packages').change(function() {
        if ($(this).is(':checked')) {
            $('.franchise_packages_add').prop('checked', true);
            $('.franchise_packages_edit').prop('checked', true);
            $('.franchise_packages_delete').prop('checked', true);
            $('.franchise_packages_media').prop('checked', true);
        }else{
            $('.franchise_packages_add').prop('checked', false);
            $('.franchise_packages_edit').prop('checked', false);
            $('.franchise_packages_delete').prop('checked', false);
            $('.franchise_packages_media').prop('checked', false);
        }
    });
    $('.franchise_packages_add,.franchise_packages_edit,.franchise_packages_delete,.franchise_packages_media').change(function() {
        if($('.franchise_packages_add').is(':checked') || $('.franchise_packages_edit').is(':checked') || $('.franchise_packages_delete').is(':checked') || $('.franchise_packages_media').is(':checked')){
            $('.franchise_packages').prop('checked', true);
        }
    });


    $('.franchise_offers').change(function() {
        if ($(this).is(':checked')) {
            $('.franchise_offers_add').prop('checked', true);
            $('.franchise_offers_edit').prop('checked', true);
            $('.franchise_offers_delete').prop('checked', true);
        }else{
            $('.franchise_offers_add').prop('checked', false);
            $('.franchise_offers_edit').prop('checked', false);
            $('.franchise_offers_delete').prop('checked', false);
        }
    });
    $('.franchise_offers_add,.franchise_offers_edit,.franchise_offers_delete').change(function() {
        if($('.franchise_offers_add').is(':checked') || $('.franchise_offers_edit').is(':checked') || $('.franchise_offers_delete').is(':checked')){
            $('.franchise_offers').prop('checked', true);
        }
    });


    $('.franchise_timing').change(function() {
        if ($(this).is(':checked')) {
            $('.franchise_timing_add').prop('checked', true);
            $('.franchise_timing_edit').prop('checked', true);
            $('.franchise_timing_delete').prop('checked', true);
        }else{
            $('.franchise_timing_add').prop('checked', false);
            $('.franchise_timing_edit').prop('checked', false);
            $('.franchise_timing_delete').prop('checked', false);
        }
    });
    $('.franchise_timing_add,.franchise_timing_edit,.franchise_timing_delete').change(function() {
        if($('.franchise_timing_add').is(':checked') || $('.franchise_timing_edit').is(':checked') || $('.franchise_timing_delete').is(':checked')){
            $('.franchise_timing').prop('checked', true);
        }
    });


    $('.franchise_credits').change(function() {
        if ($(this).is(':checked')) {
            $('.franchise_credits_add').prop('checked', true);
            // $('.franchise_offers_edit').prop('checked', true);
            // $('.franchise_offers_delete').prop('checked', true);
        }else{
            $('.franchise_credits_add').prop('checked', false);
            // $('.franchise_offers_edit').prop('checked', false);
            // $('.franchise_offers_delete').prop('checked', false);
        }
    });
    $('.franchise_credits_add').change(function() {
        if($('.franchise_credits_add').is(':checked')){
            $('.franchise_credits').prop('checked', true);
        }
    });

    $('.franchise_user').change(function() {
        if ($(this).is(':checked')) {
            $('.franchise_user_edit').prop('checked', true);
            $('.franchise_user_delete').prop('checked', true);
        }else{
            $('.franchise_user_edit').prop('checked', false);
            $('.franchise_user_delete').prop('checked', false);
        }
    });
    $('.franchise_user_edit,.franchise_user_delete').change(function() {
        if($('.franchise_user_edit').is(':checked') || $('.franchise_user_delete').is(':checked')){
            $('.franchise_user').prop('checked', true);
        }
    });

    $('.franchise_worker').change(function() {
        if ($(this).is(':checked')) {
            $('.franchise_worker_add').prop('checked', true);
            $('.franchise_worker_edit').prop('checked', true);
            $('.franchise_worker_delete').prop('checked', true);
            $('.franchise_worker_status').prop('checked', true);
        }else{
            $('.franchise_worker_add').prop('checked', false);
            $('.franchise_worker_edit').prop('checked', false);
            $('.franchise_worker_delete').prop('checked', false);
            $('.franchise_worker_status').prop('checked', false);
        }
    });
    $('.franchise_worker_add,.franchise_worker_edit,.franchise_worker_delete,.franchise_worker_status').change(function() {
        if($('.franchise_worker_add').is(':checked') || $('.franchise_worker_edit').is(':checked') || $('.franchise_worker_delete').is(':checked') || $('.franchise_worker_status').is(':checked')){
            $('.franchise_worker').prop('checked', true);
        }
    });


    $('.request_list').change(function() {
        if ($(this).is(':checked')) {
            $('.request_delete').prop('checked', true);
            $('.request_status').prop('checked', true);
        }else{
            $('.request_delete').prop('checked', false);
            $('.request_status').prop('checked', false);
        }
    });
    $('.request_delete,.request_status').change(function() {
        if($('.request_delete').is(':checked') || $('.request_status').is(':checked')){
            $('.request_list').prop('checked', true);
        }
    });

</script>
@endsection

