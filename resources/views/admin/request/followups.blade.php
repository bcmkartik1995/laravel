@extends('layouts.admin')

@section('styles')

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
                    <h5 class="content-header-title float-left pr-1 mb-0">Request quotes</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active">Followups
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.flash-message')
        <!-- Add rows table -->
        <section id="add-row">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Followups</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <!-- @if(Auth::guard('admin')->user()->sectionCheck('about_add') || Auth::guard('admin')->user()->role_id == 0)
                                    <a href="{{ route('about.create') }}" class="btn btn-primary mb-2"><i class="bx bx-plus"></i>&nbsp; Add new</a>
                                @endif -->
                                <div class="table-responsive">
                                    <table class="table tbl-slider" id="ordertable">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Address</th>
                                                <th>Visit Date & time</th>
                                                <th>Message</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
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

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Followups Message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="comment"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="followupmodal" tabindex="-1" role="dialog" aria-labelledby="followupmodalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Refer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="" id="foll_upd">
            <div class="form-group row">
                @csrf
                <input type="hidden" name="req_r_id" id="req_r_id">
                <input type="hidden" name="followup_id" id="followup_id">
                <input type="hidden" name="status" id="status">
                <input name="_method" type="hidden" value="PUT">
            </div>
            <div class="form-group row">
                <label for="date">Franchise</label><br>
                <select name="franchise" class="form-control" id="franchise">
                </select>
            </div>
            <div class="form-group row">
                <label for="message">Message</label>
                <textarea class="form-control  " name="ref_message" id="ref_message" required></textarea>
            </div>
        
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')

<script>

var table = $('#ordertable').DataTable({
        
        autoWidth: false,
        ordering: false,
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("admin-request-request_followups") }}',
            'data': function(data){
                // Read values
                // var from_date = $('#daterange').val();
                // var to_date = $('#daterangeto').val();
                // var status = $('#status').val();
                // var franchise = $('#franchise').val();
                
                // data.searchBystatus = status;
                
            }
        },
        columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'phone', name: 'phone' },
                { data: 'address', name: 'address' },
                { data: 'visit_date_time', name: 'visit_date_time' },
                { data: 'view_message', name: 'view_message'},
                { data: 'action', searchable: false, orderable: false }

                ]
                
    });

    //start code for update status
    $('#ordertable').on('click','.follow', function () {
        // $('.follow').on('click', function(){
            var id = $(this).attr('data-id');
            var status = $(this).attr('data-status');
            var followup_id = $(this).attr('data-follo_id');
            $("#followup_id").val(followup_id);
            $("#status").val(status);
            $("#req_r_id").val(id);
            $("#foll_upd").attr('action', "{{ route('request.update',"id") }}");
            //var service_id = $(this).attr('data-service_id');
            // $("#franchise").val('');
            $('#franchise').find('option').not(':first').remove();
            $.ajax({
                url : "{{ route('request.franchise') }}",
               type : 'post',
               data : {
                "_token" : "{{ csrf_token() }}",
                // "service_id" : service_id
               },
               success: function(response){
                    // $("#franchise").val('');
                    $('#franchise').find('option').remove().end();
                    var len = 0;
                    if(response['data'] != null){
                    len = response['data'].length;
                    }
                    var option = "<option>"+'Select Franchise'+"</option>";
                    if(len > 0){
                        
                    // Read data and create <option >
                        for(var i=0; i<len; i++){

                            var id = response['data'][i].id;
                            var franchise_name = response['data'][i].franchise_name;

                             option += "<option value='"+id+"'>"+franchise_name+"</option>"; 

                            //$("#franchise").append(option); 
                        }
                        $("#franchise").html(option);
                    }

                }

            });
        });
    //end code for update staus
    
    $('#ordertable').on('click','.message', function () {
    //$('.message').on('click', function(){
        var message = $(this).attr('data-comment');
        $('.comment').text(message);
    });

    $('#ordertable').on('click','.delete', function () {
    //$('.delete').on('click', function () {
// console.log(e);

    var _token = $("#form_lead input[name='_token']").val();
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

</script>

@endsection
