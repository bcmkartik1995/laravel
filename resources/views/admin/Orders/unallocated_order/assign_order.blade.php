@extends('layouts.admin')

@section('styles')

  
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />

<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/app-assets/vendors/css/pickers/daterange/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('assets/front-assets/css/bootstrap-datetimepicker.min.css') }}" media="screen">

@endsection

@section('content')

@php
    use Carbon\Carbon;
@endphp

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">     
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h5 class="content-header-title float-left pr-1 mb-0">Assign To Franchise</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active"><a href="{{ route('unallocated-orders-view') }}">Unallocated Order</a>
                            </li>
                            <li class="breadcrumb-item">Assign To Franchise
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.flash-message')
        
            <div class="col-md-12">
                <div class="card card-user">
                    <div class="card-body">

                        <div class="row">
                            {{--<!-- <div class="col-md-12">
                                
                                <div class="bg-white shadow">
                                    <tr>
                                        <td>Order Number :</td>
                                        <td class="users-view-username">{{ $unallocated_orders->order_number }}</td>
                                    </tr>
                                    <tr>
                                        <td>Payment Status:</td>
                                        <td class="users-view-username">{{ $unallocated_orders->payment_status }}</td>
                                    </tr> 
                                </div>
                            </div> -->--}}
                            <!-- <div class="col-lg-12 bg-white shadow"> -->
                                @if(isset($unallocated_orders->unallocated['services']))
                                    <div class="col-lg-12 p-1 text-black rounded">
                                        <p style="border:none; margin: 0;" class="align-middle align-middle font-weight-bold h3">Services Details</p>
                                        <hr>
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <table class="table table-white table-bordered col-lg-6">
                                            <h6 class="card-title mt-2 font-weight-bold">Service Details</h6>
                                            <thead>
                                                <tr class="text-center">
                                                    <th scope="col">service</th>
                                                    <th scope="col">price</th>
                                                    <th scope="col">Assign</th>
                                                </tr>
                                            </thead>
                                            @foreach($unallocated_orders->unallocated['services'] as $service)
                                                <tbody>
                                                    <tr class="text-center">
                                                        <td>{{ $service['title'] }}</td>
                                                        <td>{{ $service['price'] }}</td>
                                                        <td>
                                                            <a href="#" class="btn btn-success btn-sm show-example-btn btn-assign-service" data-type="service" data-package_id="0" data-service_id="{{ $service['id'] }}" data-toggle="modal" data-target="#order_rating_desc-{{$unallocated_orders->id}}" data-type="service" data-id="{{ $service['id'] }}">
                                                                    Assign Frachise
                                                            </a>
                                                            <!-- <button class="btn btn-success btn-sm show-example-btn franchises-order-status" data-id="" aria-label="Try me! Example: A custom positioned dialog">Assign Frachise</button> -->
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            @endforeach
                                        </table>    
                                    </div>
                                @endif
                                @if(isset($unallocated_orders->unallocated['packages']))
                                    <div class="col-lg-12 p-1 text-black rounded">
                                        <p style="border:none; margin: 0;" class="align-middle align-middle font-weight-bold h3">Package Details</p>
                                        <hr>
                                    </div>
                                    <div class="col-md-12">
                                        
                                        @foreach($unallocated_orders->unallocated['packages'] as $package)
                                            <!-- <h6 class="card-title mt-2 font-weight-bold">Package Details</h6> -->
                                            <table class="table table-white table-bordered col-lg-6">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th scope="col">Package Name</th>
                                                        <th scope="col">Price</th>
                                                        <th scope="col">Original Price</th>
                                                        <th scope="col">Discount Value</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="text-center">
                                                        <td>{{ $package['title'] }}</td>
                                                        <td>{{ $package['price'] }}</td>
                                                        <td>{{ $package['original_price'] }}</td>
                                                        <td>{{ $package['discount_value'] }}{{ $package['discount_type'] == 1 ? '%' : '' }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <h6 class="card-title mt-3 font-weight-bold">Package Service Details</h6>
                                            <table class="table table-white table-bordered col-lg-6">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>Services</th>
                                                        <th>Service Price</th>
                                                        <th>Assign Package Service</th>
                                                    </tr>    
                                                </thead>
                                                @foreach($package['package_service'] as $services)
                                                    <tbody>
                                                        <tr class="text-center">
                                                            <td>{{$services['title']}}</td>
                                                            <td>{{$services['price']}}</td>
                                                            <td>
                                                                <a href="#" class="btn btn-success btn-sm show-example-btn btn-assign-service" data-type="package" data-package_id="{{$package['id']}}" data-service_id="{{ $services['id'] }}" data-toggle="modal" data-target="#order_rating_desc-{{$unallocated_orders->id}}">
                                                                    Assign Frachise
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                @endforeach
                                            </table>
                                        @endforeach
                                    </div>
                                @endif
                            <!-- </div> -->
                        </div>
                        
                    </div>
                </div>
            </div> 
    </div>
</div>        


<!-- franchise assign model Start -->

<div class="modal fade" id="order_rating_desc-{{$unallocated_orders->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Assign Frachise</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="form_assign_franchise" method="POST" action="{{ route('unallocated-order-assign_worker',$unallocated_orders->id) }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="type" id="type" value="{{ old('type') }}">
                <input type="hidden" name="service_id" id="service_id" value="{{ old('service_id') }}">
                <input type="hidden" name="package_id" id="package_id" value="{{ old('package_id') }}">
                <div class="form-group">
                    <div class="form-line">
                    <label class="form-label">Franchise</label>
                        <select name="franchise_id" id="franchise_id" class="form-control select2">
                            <option value="">Select Franchise</option>
                            @foreach($franchises as $franchise)
                                <option value="{{ $franchise->id }}" {{ (old('franchise_id') == $franchise->id ? 'selected':'') }}>{{ $franchise->franchise_name }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('franchise_id'))
                            <label id="franchise_id-error" class="error" for="franchise_id">{{ $errors->first('franchise_id') }}</label>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-line">
                    <label class="form-label">Worker</label>
                        <select name="worker_id" id="worker_id" class="form-control select2">
                            <option value=""></option>
                        </select>
                        @if($errors->has('worker_id'))
                            <label id="worker_id-error" class="error" for="worker_id">{{ $errors->first('worker_id') }}</label>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <div class="form-line">
                                <label class="form-label">Date:</label>
                                <input type="text" class="form-control @if($errors->has('date')) is-invalid @endif datepicker" name="date" value="{{old('date')}}" autocomplete="off">
                                @if($errors->has('date'))
                                    <label id="date-error" class="error" for="date">{{ $errors->first('date') }}</label>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="id_end_time " class="fs-lb-tm">Time:</label>
                            <div class="input-group date" id="custom-slot-time">
                                <input type="text" name="time"  class="form-control" placeholder="Select Time" id="id_slot-time" readonly>
                                <div class="input-group-addon input-group-append">
                                    <div class="input-group-text">
                                        <i class="glyphicon glyphicon-time fa fa-clock-o"></i>
                                    </div>
                                </div>
                                @if($errors->has('time'))
                                    <label id="time-error" class="error" for="time">{{ $errors->first('time') }}</label>
                                @endif
                            </div>
                        </div>      
                    </div>
                </div>                

                <button class="btn btn-primary waves-effect mt-1" type="submit">Submit</button>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>

<!-- franchise assign model End -->

@endsection

@section('scripts')


<script src="{{ asset('assets/front-assets/js/moment-with-locales.min.js') }}"></script>
<script src="{{ asset('assets/front-assets/js/bootstrap-datetimepicker.min.js') }}"></script>

<script src="{{ asset('assets/admin-assets/app-assets/vendors/js/pickers/daterange/moment.min.js') }}"></script>
<script src="{{ asset('assets/admin-assets/app-assets/vendors/js/pickers/daterange/daterangepicker.js') }}"></script>


<script>

    @if($errors->has('franchise_id') || $errors->has('worker_id') || $errors->has('date') || $errors->has('time'))
        $('#order_rating_desc-{{$unallocated_orders->id}}').modal();
    @endif

    $(".select2").select2({
        dropdownAutoWidth: true,
        width: '100%'
    });

    $('.btn-assign-service').click(function(){
        type = $(this).data('type');
        service_id = $(this).data('service_id');
        package_id = $(this).data('package_id');

        $('#form_assign_franchise #type').val(type);
        $('#form_assign_franchise #service_id').val(service_id);
        $('#form_assign_franchise #package_id').val(package_id);
        
    });

    $('#franchise_id').on('change', function () {
       
        var franchise_id = $(this).val();
        var _token = $("#form_assign_franchise input[name='_token']").val();
        
        //alert(franchise_id);
        $.ajax({
            url: "{{route('ajax-franchise-assign')}}",
            type: 'POST',
            data: { franchise_id: franchise_id, _token: _token },
            success: function (data) {
                
                $('#worker_id').empty();
                $('#worker_id').append('<option value ="">Select Worker</option>');
                $.each(data, function (inedx, subcatObj) {
                    //console.log(subcatObj.title);
                    selected = '{{old('worker_id')}}'==subcatObj.id?'selected':'';
                    $('#worker_id').append('<option value ="' + subcatObj.id + '" '+selected+'>' + subcatObj.name + '</option>');
                });
            }
        });

    });
    
    $(document).ready(function(){
        $('#franchise_id').trigger('change');
    });

    $(function () {
        $('.datepicker').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
            format: 'DD/MM/YYYY'
            },
            autoUpdateInput: true, 
        });
    });

    $(document).ready(function(){
        $('#custom-slot-time').datetimepicker({
            "allowInputToggle": true,
            "showClose": true,
            "showClear": true,
            "showTodayButton": true,
            "format": "hh:mm A",
            "ignoreReadonly": true
            //"minDate": new Date()
        });
        
        $('#id_slot-time').val("");
    });
</script>

@endsection