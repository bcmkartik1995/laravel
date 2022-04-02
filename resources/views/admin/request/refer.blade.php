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
                                <div class="table-responsive">
                                    <table class="table tbl-slider">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Address</th>
                                                <th>Visit Date & time</th>
                                                <th>Message</th>
                                                <th>Status</th>
                                                <th>Canceled By</th>
                                                <th>Reffered to</th>
                                                <th>Refer Message</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($req_quotes as $quotes)
                                                <tr>
                                                    <td>{{ $quotes->id }}</td>
                                                    <td>{{ $quotes->name }}</td>
                                                    <td>{{ $quotes->email }}</td>
                                                    <td>{{ $quotes->phone }}</td>
                                                    <td>{{ $quotes->address }}</td>
                                                    <td>{{ Carbon::parse($quotes->visit_date.' '.$quotes->visit_time)->format('d-m-Y H:i a') }}</td>
                                                    <td><button class="btn btn-primary btn-sm message" data-comment="{{ $quotes->message }}" data-toggle="modal" data-target="#exampleModal">View Message</button></td>
                                                    <td>
                                                    @if($quotes->status == 0)
                                                                <span class="badge badge-pill badge-light-info"> New</span>
                                                    @elseif($quotes->status == 1)
                                                        <span class="badge badge-pill badge-light-primary"> Folloups</span>
                                                    @elseif($quotes->status == 2)
                                                        <span class="badge badge-pill badge-light-success"> Assigned</span>
                                                    @elseif($quotes->status == 3)
                                                        <span class="badge badge-pill badge-light-danger"> Canceled</span>
                                                        
                                                    @elseif($quotes->status == 4)
                                                        <span class="badge badge-pill badge-light-warning"> Refer</span>
                                                    @elseif($quotes->status == 6)
                                                        <span class="badge badge-pill badge-light-danger"> Declined</span>
                                                    @elseif($quotes->status == 5)
                                                        <span class="badge badge-pill badge-light-success"> Accepted</span>
                                                    @endif
                                                    </td>
                                                    <td> @if($quotes->status == 3)
                                                        <p> {{ $quotes->canceled_by }}</p> 
                                                         @endif
                                                    </td>
                                                    
                                                    <td>{{ isset($quotes->reffered_to->franchise_name) ? $quotes->reffered_to->franchise_name : '' }}</td>
                                                    <!-- <td>{{ $quotes->ref_message }}</td> -->
                                                    <td> @if(!empty($quotes->ref_message)) <button class="btn btn-primary btn-sm ref_message" data-id="{{ $quotes->id }}" data-comment="{{ $quotes->ref_message }}" data-followup="{{ $quotes->followup_mes }}" data-date="{{ $quotes->followup_date }}" data-franchise="{{ $quotes->refer_to }}" data-toggle="modal" data-target="#exampleModal1">View Logs</button> @endif</td>
                                                    <td>
                                                    @if($quotes->status != 5 && $quotes->status != 6)
                                                        <a class="btn btn-success btn-sm mr-25 accept mb-1" data-id="{{ $quotes->id }}" data-status="5" data-toggle="modal"  href="#">Accept</a>
                                                    @endif
                                                        @if($quotes->status != 6)
                                                            <a class="btn btn-danger  decline" data-id="{{ $quotes->id }}" data-status="6" data-toggle="modal" data-target="#refmodal" href="#">Decline</a>
                                                        @endif
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

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
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
                <input type="hidden" name="status" id="status">
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
        <h5 class="modal-title" id="exampleModalLabel">Decline</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="" id="foll_upd1">
            <div class="form-group row">
                @csrf
                <input type="hidden" name="req_d_id" id="req_d_id">
                <input type="hidden" name="status" id="status1">
                <input name="_method" type="hidden" value="PUT">
            </div>
            <div class="form-group row">
                <label for="message">Decline Reason Message</label>
                <textarea class="form-control  " name="dec_message" id="dec_message" required></textarea>
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

    //start code for update status
        $('.follow').on('click', function(){
            var id = $(this).attr('data-id');
            var status = $(this).attr('data-status');
            $("#status").val(status);
            $("#req_f_id").val(id);
            $("#foll_upd").attr('action', "{{ route('request.update',"+id") }}");
        });

        //start code for refer 
        $('.decline').on('click', function(){
            var id = $(this).attr('data-id');
            var status = $(this).attr('data-status');
            $("#status1").val(status);
            $("#req_d_id").val(id);
            $("#foll_upd1").attr('action', "{{ route('request.update',"+id") }}");
            var service_id = $(this).attr('data-service_id');
            // $("#franchise").val('');
           
        });

        $('.accept').on('click', function(e){
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
    //end code for update staus
    $('.message').on('click', function(){
        var message = $(this).attr('data-comment');
        $('.comment').text(message);
    });
    $('.ref_message').on('click', function(){
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
                op+='<tr><th>SN</th><th>Refer to</th><th>Refer Date</th><th>Refer Message</th><th>Followup Date</th><th>Followup Message</th></tr>';
                for(var i=0;i<data2.length;i++){
                    if(data2[i].followup_date == null) {
                        data2[i].followup_date = '';
                    } 
                    if(data2[i].followup_mes == null){
                        data2[i].followup_mes = '';
                    }
                    op+='<tr>';
                    op+='<td>'+(i+1)+'</td><td>'+data2[i].franchise_name+'</td><td>'+data2[i].updated_at.substring(0,10)+'</td><td>'+data2[i].ref_message+'</td><td>'+data2[i].followup_date+'</td><td>'+data2[i].followup_mes+'</td></tr>';
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
    $('.delete').on('click', function () {
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

    $('.tbl-slider').DataTable({
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
