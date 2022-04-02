@extends('layouts.load')
@section('content')

<section class="users-view">
  <!-- users view media object start -->
  <div class="row">
			<div class="col-lg-12">
				<div class="product-description">
					<div class="body-area">
					@include('includes.admin.form-error') 
					<form id="geniusformdata" action="{{ route('admin-staff-update',$data->id) }}" method="POST" enctype="multipart/form-data">
						{{csrf_field()}}

                        <div class="row">
                          <div class="col-md-4">
                                <label>{{ __('Staff Profile Image') }} *</label>
                          </div>
                          <div class="col-md-8 form-group">
                            <div class="img-upload">
                                <div id="image-preview" class="img-preview" style="background: url({{ $data->photo ? asset('assets/images/admins/'.$data->photo) : asset('assets/images/noimage.png') }});">
                                    <label for="image-upload" class="img-label" id="image-label"><i class="icofont-upload-alt"></i>{{ __('Upload Image') }}</label>
                                    <input type="file" name="photo" class="img-upload" id="image-upload">
                                  </div>
                            </div>
                          </div>
                        </div>

						<div class="row">
							<div class="col-md-4">
			                  <label>{{ __('Name') }} *</label>
			                </div>
			                <div class="col-md-8 form-group">
			                	<input type="text" class="input-field form-control" name="name" placeholder="{{ __("User Name") }}" required="" value="{{ $data->name }}">
			                </div>
			                <div class="col-md-4">
			                  <label>{{ __("Email") }} *</label>
			                </div>
			                <div class="col-md-8 form-group">
			                	<input type="email" class="input-field form-control" name="email" placeholder="{{ __("Email Address") }}" required="" value="{{ $data->email }}">
			                </div>
			                <div class="col-md-4">
			                  <label>{{ __("Phone") }} *</label>
			                </div>
			                <div class="col-md-8 form-group">
			                	<input type="text" class="input-field form-control" name="phone" placeholder="{{ __("Phone Number") }}" required="" value="{{ $data->phone }}">
			                </div>
			                <div class="col-md-4">
			                  <label>{{ __("Role") }} *</label>
			                </div>
			                <div class="col-md-8 form-group">
			                	<select class="form-control" name="role_id" required="">
									<option value="">{{ __('Select Role') }}</option>
									  @foreach(DB::table('roles')->get() as $dta)
										<option value="{{ $dta->id }}" {{ $data->role_id == $dta->id ? 'selected' : '' }}>{{ $dta->name }}</option>
									  @endforeach
								</select>
			                </div>
			                <div class="col-md-4">
			                  <label>{{ __("Password") }} *</label>
			                </div>
			                <div class="col-md-8 form-group">
			                	<input type="password" class="input-field form-control" name="password" placeholder="{{ __("Password") }}" value="">
			                </div>
						</div>
                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                              
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <button class="addProductSubmit-btn btn btn-dark mr-1" type="submit">{{ __("Save") }}</button>
                          </div>
                        </div>

					</form>


					</div>
				</div>
			</div>
		</div>
  <!-- users view media object ends -->

</section>

@endsection

@section('scripts')
<!-- BEGIN: Page Vendor JS-->
<script src="{{ asset('assets/admin-assets/js/myscript.js') }}"></script>
<script src="{{ asset('assets/admin-assets/js/load.js') }}"></script>
<!-- END: Page Vendor JS-->
@endsection