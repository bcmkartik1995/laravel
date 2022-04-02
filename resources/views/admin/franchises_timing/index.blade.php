@extends('layouts.admin')

@section('styles')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/app-assets/vendors/css/pickers/pickadate/pickadate.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/app-assets/vendors/css/pickers/daterange/daterangepicker.css') }}">

@endsection

@section('content')


<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">     
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h5 class="content-header-title float-left pr-1 mb-0">Franchises Timing</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active">Franchises Timing
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
                            <h4 class="card-title">Add Timing</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form id="form_offer" method="POST" action="{{ route('add.time') }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="row">
                                            <div class="col-lg-4 d-flex align-items-center">
                                                <div class="form-line">
                                                    <div class="checkbox checkbox-primary checkbox-glow">
                                                        <input type="checkbox" id="checkboxGlow1" name="monday" value="mon" class="mr-5" {{ isset($franchise_time['mon']) ? 'checked' : ''  }}>
                                                        <label for="checkboxGlow1" class="ml-3">Monday</label>
                                                    </div>
                                                </div>
                                            </div>
                                                    
                                            <div class="col-lg-4">
                                                <fieldset class="form-group position-relative has-icon-left">
                                                    <input type="text" class="form-control pickatime @if($errors->has('mon_open_time')) is-invalid @endif" name="mon_open_time" id="mon_open_time" placeholder="Open Time" value="{{ isset($franchise_time['mon']['open_time']) ? $franchise_time['mon']['open_time'] : '' }}">
                                                    <div class="form-control-position">
                                                        <i class='bx bx-history'></i>
                                                    </div>
                                                </fieldset>
                                                @if($errors->has('mon_open_time'))
                                                    <label id="name-error" class="error" for="mon_open_time">{{ $errors->first('mon_open_time') }}</label>
                                                @endif
                                            </div>
                                            
                                            <div class="col-lg-4">
                                                <fieldset class="form-group position-relative has-icon-left">
                                                    <input type="text" class="form-control pickatime @if($errors->has('mon_close_time')) is-invalid @endif" name="mon_close_time" id="mon_close_time" placeholder="Close Time" value="{{ isset($franchise_time['mon']['close_time']) ? $franchise_time['mon']['close_time'] : '' }}">
                                                    <div class="form-control-position">
                                                        <i class='bx bx-history'></i>
                                                    </div>
                                                </fieldset>
                                                @if($errors->has('mon_close_time'))
                                                    <label id="name-error" class="error" for="mon_close_time">{{ $errors->first('mon_close_time') }}</label>
                                                @endif
                                            </div>  


                                            <div class="col-lg-4 d-flex align-items-center">
                                                <div class="form-line">
                                                    <div class="checkbox checkbox-primary checkbox-glow">
                                                        <input type="checkbox" id="checkboxGlow2" name="tuesday" value="tue" class="mr-5" {{ isset($franchise_time['tue']) ? 'checked' : ''  }}>
                                                        <label for="checkboxGlow2" class="ml-3">Tuesday</label>
                                                    </div>
                                                </div>
                                            </div>
                                                    
                                            <div class="col-lg-4">
                                                <fieldset class="form-group position-relative has-icon-left">
                                                    <input type="text" class="form-control pickatime @if($errors->has('tue_open_time')) is-invalid @endif" name="tue_open_time" id="tue_open_time" placeholder="Open Time" value="{{ isset($franchise_time['tue']['open_time']) ? $franchise_time['tue']['open_time'] : '' }}">
                                                    <div class="form-control-position">
                                                        <i class='bx bx-history'></i>
                                                    </div>
                                                </fieldset>
                                                @if($errors->has('tue_open_time'))
                                                    <label id="name-error" class="error" for="tue_open_time">{{ $errors->first('tue_open_time') }}</label>
                                                @endif
                                            </div>
                                            
                                            <div class="col-lg-4">
                                                <fieldset class="form-group position-relative has-icon-left">
                                                    <input type="text" class="form-control pickatime @if($errors->has('tue_close_time')) is-invalid @endif" name="tue_close_time" id="tue_close_time" placeholder="Close Time" value="{{ isset($franchise_time['tue']['close_time']) ? $franchise_time['tue']['close_time'] : '' }}">
                                                    <div class="form-control-position">
                                                        <i class='bx bx-history'></i>
                                                    </div>
                                                </fieldset>
                                                @if($errors->has('tue_close_time'))
                                                    <label id="name-error" class="error" for="tue_close_time">{{ $errors->first('tue_close_time') }}</label>
                                                @endif
                                            </div>
                                            

                                            
                                            <div class="col-lg-4 d-flex align-items-center">
                                                <div class="form-line">
                                                    <div class="checkbox checkbox-primary checkbox-glow">
                                                        <input type="checkbox" id="checkboxGlow3" name="wednesday" value="wed" class="mr-5" {{ isset($franchise_time['wed']) ? 'checked' : ''  }}>
                                                        <label for="checkboxGlow3" class="ml-3">Wednesday</label>
                                                    </div>
                                                </div>
                                            </div>
                                                    
                                            <div class="col-lg-4">
                                                <fieldset class="form-group position-relative has-icon-left">
                                                    <input type="text" class="form-control pickatime @if($errors->has('wed_open_time')) is-invalid @endif" name="wed_open_time" id="wed_open_time" placeholder="Open Time" value="{{ isset($franchise_time['wed']['open_time']) ? $franchise_time['wed']['open_time'] : '' }}">
                                                    <div class="form-control-position">
                                                        <i class='bx bx-history'></i>
                                                    </div>
                                                </fieldset>
                                                @if($errors->has('wed_open_time'))
                                                    <label id="name-error" class="error" for="wed_open_time">{{ $errors->first('wed_open_time') }}</label>
                                                @endif
                                            </div>
                                            
                                            <div class="col-lg-4">
                                                <fieldset class="form-group position-relative has-icon-left">
                                                    <input type="text" class="form-control pickatime @if($errors->has('wed_close_time')) is-invalid @endif" name="wed_close_time" id="wed_close_time" placeholder="Close Time" value="{{ isset($franchise_time['wed']['close_time']) ? $franchise_time['wed']['close_time'] : '' }}">
                                                    <div class="form-control-position">
                                                        <i class='bx bx-history'></i>
                                                    </div>
                                                </fieldset>
                                                @if($errors->has('wed_close_time'))
                                                    <label id="name-error" class="error" for="wed_close_time">{{ $errors->first('wed_close_time') }}</label>
                                                @endif
                                            </div>
                                            
                                            <div class="col-lg-4 d-flex align-items-center">
                                                <div class="form-line">
                                                    <div class="checkbox checkbox-primary checkbox-glow">
                                                        <input type="checkbox" id="checkboxGlow4" name="thursday" value="thu" class="mr-5" {{ isset($franchise_time['thu']) ? 'checked' : ''  }}>
                                                        <label for="checkboxGlow4" class="ml-3">Thursday</label>
                                                    </div>
                                                </div>
                                            </div>
                                                    
                                            <div class="col-lg-4">
                                                <fieldset class="form-group position-relative has-icon-left">
                                                    <input type="text" class="form-control pickatime @if($errors->has('thu_open_time')) is-invalid @endif" name="thu_open_time" id="thu_open_time" placeholder="Open Time" value="{{ isset($franchise_time['thu']['open_time']) ? $franchise_time['thu']['open_time'] : '' }}">
                                                    <div class="form-control-position">
                                                        <i class='bx bx-history'></i>
                                                    </div>
                                                </fieldset>
                                                @if($errors->has('thu_open_time'))
                                                    <label id="name-error" class="error" for="thu_open_time">{{ $errors->first('thu_open_time') }}</label>
                                                @endif
                                            </div>
                                            
                                            <div class="col-lg-4">
                                                <fieldset class="form-group position-relative has-icon-left">
                                                    <input type="text" class="form-control pickatime @if($errors->has('thu_close_time')) is-invalid @endif" name="thu_close_time" id="thu_close_time" placeholder="Close Time" value="{{ isset($franchise_time['thu']['close_time']) ? $franchise_time['thu']['close_time'] : '' }}">
                                                    <div class="form-control-position">
                                                        <i class='bx bx-history'></i>
                                                    </div>
                                                </fieldset>
                                                @if($errors->has('thu_close_time'))
                                                    <label id="name-error" class="error" for="thu_close_time">{{ $errors->first('thu_close_time') }}</label>
                                                @endif
                                            </div>



                                            <div class="col-lg-4 d-flex align-items-center">
                                                <div class="form-line">
                                                    <div class="checkbox checkbox-primary checkbox-glow">
                                                        <input type="checkbox" id="checkboxGlow5" name="friday" value="fri" class="mr-5" {{ isset($franchise_time['fri']) ? 'checked' : ''  }}>
                                                        <label for="checkboxGlow5" class="ml-3">Friday</label>
                                                    </div>
                                                </div>
                                            </div>
                                                    
                                            <div class="col-lg-4">
                                                <fieldset class="form-group position-relative has-icon-left">
                                                    <input type="text" class="form-control pickatime @if($errors->has('fri_open_time')) is-invalid @endif" name="fri_open_time" id="fri_open_time" placeholder="Open Time" value="{{ isset($franchise_time['fri']['open_time']) ? $franchise_time['fri']['open_time'] : '' }}">
                                                    <div class="form-control-position">
                                                        <i class='bx bx-history'></i>
                                                    </div>
                                                </fieldset>
                                                @if($errors->has('fri_open_time'))
                                                    <label id="name-error" class="error" for="fri_open_time">{{ $errors->first('fri_open_time') }}</label>
                                                @endif
                                            </div>
                                            
                                            <div class="col-lg-4">
                                                <fieldset class="form-group position-relative has-icon-left">
                                                    <input type="text" class="form-control pickatime @if($errors->has('fri_close_time')) is-invalid @endif" name="fri_close_time" id="fri_close_time" placeholder="Close Time" value="{{ isset($franchise_time['fri']['close_time']) ? $franchise_time['fri']['close_time'] : '' }}">
                                                    <div class="form-control-position">
                                                        <i class='bx bx-history'></i>
                                                    </div>
                                                </fieldset>
                                                @if($errors->has('fri_close_time'))
                                                    <label id="name-error" class="error" for="fri_close_time">{{ $errors->first('fri_close_time') }}</label>
                                                @endif
                                            </div>



                                            <div class="col-lg-4 d-flex align-items-center">
                                                <div class="form-line">
                                                    <div class="checkbox checkbox-primary checkbox-glow">
                                                        <input type="checkbox"  id="checkboxGlow6" name="saturday" value="sat" class="mr-5" {{ isset($franchise_time['sat']) ? 'checked' : ''  }}>
                                                        <label for="checkboxGlow6" class="ml-3">Saturday</label>
                                                    </div>
                                                </div>
                                            </div>
                                                    
                                            <div class="col-lg-4">
                                                <fieldset class="form-group position-relative has-icon-left">
                                                    <input type="text" class="form-control pickatime @if($errors->has('sat_open_time')) is-invalid @endif" name="sat_open_time" id="sat_open_time" placeholder="Open Time" value="{{ isset($franchise_time['sat']['open_time']) ? $franchise_time['sat']['open_time'] : '' }}">
                                                    <div class="form-control-position">
                                                        <i class='bx bx-history'></i>
                                                    </div>
                                                </fieldset>
                                                @if($errors->has('sat_open_time'))
                                                    <label id="name-error" class="error" for="sat_open_time">{{ $errors->first('sat_open_time') }}</label>
                                                @endif
                                            </div>
                                            
                                            <div class="col-lg-4">
                                                <fieldset class="form-group position-relative has-icon-left">
                                                    <input type="text" class="form-control pickatime @if($errors->has('sat_close_time')) is-invalid @endif" name="sat_close_time" id="sat_close_time" placeholder="Close Time" value="{{ isset($franchise_time['sat']['close_time']) ? $franchise_time['sat']['close_time'] : '' }}">
                                                    <div class="form-control-position">
                                                        <i class='bx bx-history'></i>
                                                    </div>
                                                </fieldset>
                                                @if($errors->has('sat_close_time'))
                                                    <label id="name-error" class="error" for="sat_close_time">{{ $errors->first('sat_close_time') }}</label>
                                                @endif
                                            </div>


                                            <div class="col-lg-4 d-flex align-items-center">
                                                <div class="form-line">
                                                    <div class="checkbox checkbox-primary checkbox-glow">
                                                        <input type="checkbox"  id="checkboxGlow7" name="sunday" value="sun" class="mr-5" {{ isset($franchise_time['sun']) ? 'checked' : ''  }}>
                                                        <label for="checkboxGlow7" class="ml-3">Sunday</label>
                                                    </div>
                                                </div>
                                            </div>
                                                    
                                            <div class="col-lg-4">
                                                <fieldset class="form-group position-relative has-icon-left">
                                                    <input type="text" class="form-control pickatime @if($errors->has('sun_open_time')) is-invalid @endif" name="sun_open_time" id="sun_open_time" placeholder="Open Time" value="{{ isset($franchise_time['sun']['open_time']) ? $franchise_time['sun']['open_time'] : '' }}">
                                                    <div class="form-control-position">
                                                        <i class='bx bx-history'></i>
                                                    </div>
                                                </fieldset>
                                                @if($errors->has('sun_open_time'))
                                                    <label id="name-error" class="error" for="sun_open_time">{{ $errors->first('sun_open_time') }}</label>
                                                @endif
                                            </div>
                                            
                                            <div class="col-lg-4">
                                                <fieldset class="form-group position-relative has-icon-left">
                                                    <input type="text" class="form-control pickatime @if($errors->has('sun_close_time')) is-invalid @endif" name="sun_close_time" id="sun_close_time" placeholder="Close Time" value="{{ isset($franchise_time['sun']['close_time']) ? $franchise_time['sun']['close_time'] : '' }}">
                                                    <div class="form-control-position">
                                                        <i class='bx bx-history'></i>
                                                    </div>
                                                </fieldset>
                                                @if($errors->has('sun_close_time'))
                                                    <label id="name-error" class="error" for="sun_close_time">{{ $errors->first('sun_close_time') }}</label>
                                                @endif
                                            </div>  
                                    </div>

                                    <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- // Basic Vertical form layout section end -->


        <!-- Add rows table -->
        <section id="add-row">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Franchises Off Days</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                @if(Auth::guard('admin')->user()->sectionCheck('franchise_timing_add') || Auth::guard('admin')->user()->role_id == 0)
                                    <a class="btn btn-primary text-white mb-2" data-toggle="modal" data-target="#franchise_offday"><i class="bx bx-plus"></i>&nbsp; Add new</a>
                                @endif
                                <div class="table-responsive">
                                    <table class="table tbl-franchise-offday">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Title</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($franchise_offdays as $franchise_offday)
                                                <tr>
                                                    <td>{{ $franchise_offday->id }}</td>
                                                    <td>{{ $franchise_offday->off_date }}</td>
                                                    <td>
                                                        <div style="display:flex;">
                                                            @if(Auth::guard('admin')->user()->sectionCheck('franchise_timing_edit') || Auth::guard('admin')->user()->role_id == 0)   
                                                                <a href="{{route('franchises-timing.edit',$franchise_offday->id)}}" class="btn btn-warning btn-sm mr-25">Edit</a>
                                                            @endif

                                                            {{--<!-- @if(Auth::guard('admin')->user()->sectionCheck('franchise_timing_delete') || Auth::guard('admin')->user()->role_id == 0)    
                                                                <a href="javascript:void(0);" data-href="{{ route('franchises-timing.destroy',$franchise_offday->id) }}" class="btn btn-danger btn-sm mr-25 delete">Detete</a>
                                                            @endif-->--}}
                                                        </div> 
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--/ Add rows table -->

    </div>
</div>

<!-- ---------------------------Add Franchise Off Day-------------------------------- -->

<div class="modal fade" id="franchise_offday" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Description</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <form method="POST" action="{{ route('franchises-timing.store') }}" enctype="multipart/form-data">
                {{csrf_field()}}

                <div class="form-group">
                    <div class="form-line">
                        <fieldset class="form-group position-relative has-icon-left">
                            <input type="text" name="offdaydate" id="offdaydate" class="form-control datetime  @if($errors->has('offdaydate')) is-invalid @endif" value="" placeholder="Select Date" autocomplete="off">
                            <div class="form-control-position">
                                <i class='bx bx-calendar-check'></i>
                            </div>
                        </fieldset>
                        @if($errors->has('offdaydate'))
                            <label id="name-error" class="error" for="offdaydate">{{ $errors->first('offdaydate') }}</label>
                        @endif
                    </div>
                </div>

                <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
            </form>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>



@endsection

@section('scripts')


<!-- BEGIN: Page Vendor JS-->

<script src="{{ asset('assets/admin-assets/app-assets/vendors/js/pickers/daterange/moment.min.js') }}"></script>
<script src="{{ asset('assets/admin-assets/app-assets/vendors/js/pickers/daterange/daterangepicker.js') }}"></script>

<script src="{{ asset('assets/admin-assets/app-assets/vendors/js/pickers/pickadate/picker.js') }}"></script>
<script src="{{ asset('assets/admin-assets/app-assets/vendors/js/pickers/pickadate/picker.time.js') }}"></script>
<!-- END: Page Vendor JS-->

<script>

@if($errors->has('offdaydate'))
    $('#franchise_offday').modal();
@endif

    $('.pickatime').pickatime();


    $('#offdaydate').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        locale: {
            format: 'DD-MM-YYYY'
        },
        autoUpdateInput: false, 
    }).on("apply.daterangepicker", function (e, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY'));
        //$(this).trigger('change');
    });


    $('.delete').on('click', function () {
    // console.log(e);

    var _token = '{{ csrf_token() }}';
    var href = $(this).data('href');
    Swal.fire({
        title: 'Are you sure?',
            text: "You will not be able to recover this data!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            confirmButtonClass: 'btn btn-primary',
            cancelButtonClass: 'btn btn-danger ml-1',
            buttonsStyling: false,
    }).then(function (result) {
        if(result.value){
            $.ajax({
                url: href,
                type: 'DELETE',
                dataType:"json",
                data: { _token: "{{ csrf_token() }}" },
                success: function (data) {
                    Swal.fire({
                        title: 'Success',
                        text: data.message,
                        type: "success",
                        showCancelButton: false,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonClass: "btn btn-primary",
                        closeOnConfirm: true,
                    }).then(function (result) {
                        window.location.reload();
                    });
                }
            });
        }
    });
    return false;
    });

    $('.tbl-franchise-offday').DataTable({
        autoWidth: false,
        "columnDefs": [{
            "visible": false,
            "targets": 0
        }],
        "order": [
            [0, 'DESC']
        ],
    });

    
</script>

@endsection
