@extends('layouts.admin')

@section('styles')
<style>
    .logs{
        width : 961px;
    }
</style>
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
                            <li class="breadcrumb-item active">Request quotes
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
                            <h4 class="card-title">Request quotes</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <!-- @if(Auth::guard('admin')->user()->sectionCheck('about_add') || Auth::guard('admin')->user()->role_id == 0)
                                    <a href="{{ route('about.create') }}" class="btn btn-primary mb-2"><i class="bx bx-plus"></i>&nbsp; Add new</a>
                                @endif -->
                                <div class="row">
                                    
                                    <div class="col-lg-4 offset-4">
                                        <label for="request_type">Request Type</label>
                                        <select class="form-control select2" name="request_type" id="request_type">
                                            <option value="">Select Request Type</option>
                                            <option value="Enterprise Services">Enterprise Services</option>
                                            <option value="Service Request">Service Request</option>
                                        </select>
                                    </div>

                                    <div class="col-lg-4">
                                        <label for="status">Status</label>
                                        <select class="form-control select2" name="status" id="status">
                                            <option value="">Select Status</option>
                                            <option value="0">New</option>
                                            <option value="3">Cancel</option>
                                            <option value="4">Refer</option>
                                            <option value="5">Accepted</option>
                                            <option value="6">Declined</option>
                                        </select>
                                    </div>

                                </div>

                                <div class="table-responsive">
                                    <table class="table tbl-slider dt-responsive" id="ordertable">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Address</th>                                            
                                                <th>Request Message</th>
                                                <th>Visit Date & time</th>
                                                <th>Status</th>
                                                <th>View Logs</th>
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
    <div class="modal-content logs">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Message</h5>
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

<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content logs">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Refer Message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="tableview">
          
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
        <h5 class="modal-title" id="exampleModalLabel">Followups</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="" id="foll_upd">
            <div class="form-group row">
                @csrf
                <input type="hidden" name="req_f_id" id="req_f_id">
                <input type="hidden" name="status" id="status" value="1">
                <input name="_method" type="hidden" value="PUT">
                <label for="message">Message</label>
                <textarea class="form-control  " name="fol_message" id="fol_message" required></textarea>
            </div>
            <div class="form-group row">
                <label for="date">Date</label><br>
                <input type="date" class="form-control" name="fol_date" id="fol_date" required/>
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
<!-- code for refer form -->
<div class="modal fade" id="refmodal" tabindex="-1" role="dialog" aria-labelledby="followupmodalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Refer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="" id="foll_upd1">
            <div class="form-group row">
                @csrf
                <input type="hidden" name="req_r_id" id="req_r_id">
                <input type="hidden" name="followup_id" id="followup_id">
                <input type="hidden" name="status" id="status1">
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

    $(".select2").select2({

        dropdownAutoWidth: true,
        width: '100%'
    });

    //code for data table
    var table = $('#ordertable').DataTable({
        
        autoWidth: false,
        ordering: false,
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("admin-request-datatables") }}',
            'data': function(data){
                // Read values
                var request_type = $('#request_type').val();
                var status = $('#status').val();
                
                data.searchBystatus = status;
                data.searchByrequest_type = request_type;
                
            }
        },
        columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'phone', name: 'phone' },
                { data: 'address', name: 'address' },
                { data: 'view_message', name: 'view_message'},
                { data: 'visit_date_time', name: 'visit_date_time' },
                {data: 'status', name: 'status'},
                { data: 'view_logs', name: 'view_logs' },
                { data: 'action', searchable: false, orderable: false }

                ]
                
    });
    $('#request_type').change(function(){
        table.draw();
    });

    $('#status').change(function(){
        table.draw();
    });

    //start code for update status
    $('#ordertable').on('click','.follow', function () {
            var id = $(this).attr('data-id');
            var status = $(this).attr('data-status');
            $("#status").val(status);
            $("#req_f_id").val(id);
            $("#foll_upd").attr('action', "{{ route('request.update',"+id") }}");
    });
        //start code for refer 
        // $('.refer').on('click', function(){
        //     var id = $(this).attr('data-id');
        //     var status = $(this).attr('data-status');
        //     var followup_id = $(this).attr('data-follo_id');
        //     $("#followup_id").val(followup_id);
        //     $("#status1").val(status);
        //     $("#req_r_id").val(id);
        //     $("#foll_upd1").attr('action', "{{ route('request.update',"+id") }}");
        //     var service_id = $(this).attr('data-service_id');
            
        // });

        
        $('#ordertable').on('click','.refer', function () {
        //$('.refer').on('click', function(){
            var id = $(this).attr('data-id');
            var status = $(this).attr('data-status');
            var followup_id = $(this).attr('data-follo_id');
            $("#followup_id").val(followup_id);
            $("#status1").val(status);
            $("#req_r_id").val(id);
            $("#foll_upd1").attr('action', "{{ route('request.update',"+id") }}");
            var service_id = $(this).attr('data-service_id');
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

                    if(len > 0){
                    var option = "<option>"+'Select Franchise'+"</option>";
                        for(var i=0; i<len; i++){

                            var id = response['data'][i].id;
                            var franchise_name = response['data'][i].franchise_name;

                             option += "<option value='"+id+"'>"+franchise_name+"</option>"; 

                            
                        }
                        $("#franchise").html(option); 
                    }

                }

            });
        });

        $('#ordertable').on('click','.cancel', function () {
            var id = $(this).attr('data-id');
            var status = $(this).attr('data-status');
            $.ajax({
                url: "{{ route('request.update',"id") }}",
                method: 'POST',
                data : {
                    "_token": "{{ csrf_token() }}",
                    '_method' : 'PUT',
                    'req_c_id' : id,
                    'status' : status
                },
                success : function(data) {
                    location.reload();
                }
            });
    }); 
    //end code for update staus
    // $('#ordertable-table').on('click','.message', function () {
    //     var message = $(this).attr('data-comment');
    //     $('.comment').text(message);
    // });
    $('#ordertable').on('click','.ref_message', function () {
        var message = $(this).attr('data-comment');
        var fol_msg = $(this).attr('data-followup');
        var fol_date = $(this).attr('data-date');
        var franchise = $(this).attr('data-franchise');
        var data_id = $(this).attr('data-id');
        //var service_id = franchise;
        var op = "";
        $.ajax({
            url : "{{ route('request.franchises') }}",
            type : 'post',
            data : {
                "_token": "{{ csrf_token() }}",
                'id' : data_id,
                'service_id' : franchise
            },
            success : function (data2) {
                op+='<table class="table table-striped">';
                op+='<tr><th>SN</th><th>Refer to</th><th>Refer Date</th><th>Refer Message</th><th>Followup Date</th><th>Followup Message</th><th>Decline By</th><th>Decline Message</th><th>Accepted By</th></tr>';
                for(var i=0;i<data2.length;i++){
                    if(data2[i].followup_date == null) {
                        data2[i].followup_date = '';
                    } 
                    if(data2[i].followup_mes == null){
                        data2[i].followup_mes = '';
                    }
                    op+='<tr>';
                    op+='<td>'+(i+1)+'</td><td>'+data2[i].franchise_name+'</td><td>'+data2[i].updated_at.substring(0,10)+'</td><td>'+data2[i].ref_message+'</td><td>'+data2[i].followup_date+'</td><td>'+data2[i].followup_mes+'</td><td>'+data2[i].decline_by+'</td><td>'+data2[i].dec_message+'</td><td>'+data2[i].accepted_by+'</td></tr>';
                }
                op+='</table>';
                $('#tableview').html(op);
            }
        });
        $('.msg').text('Refer Message : '+message);
        //$('.franchises').text(franchise);
        $('.f_msg').text('Follwup Message : '+ fol_msg);
        $('.f_date').text('Follwup Date : '+fol_date);
    });
    

    //start code for accept
    $('#ordertable').on('click','.accept', function () {
            var id = $(this).attr('data-id');
            var status = $(this).attr('data-status');
            $.ajax({
                url: "{{ route('request.update',"id") }}",
                method: 'POST',
                data : {
                    "_token": "{{ csrf_token() }}",
                    '_method' : 'PUT',
                    'req_a_id' : id,
                    'status' : status
                },
                success : function(data) {
                    location.reload();
                }
            });
    });
    //end code for accept


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
