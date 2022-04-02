@extends('layouts.admin')

@section('styles')

@endsection

@section('content')

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">     
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h5 class="content-header-title float-left pr-1 mb-0">Contact us</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active">Contact us
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
                            <h4 class="card-title">Contact us</h4>
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
                                                <th>Comment</th>
                                                {{--<th>Action</th>--}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($contact as $contactus)
                                                <tr>
                                                    <td>{{ $contactus->id }}</td>
                                                    <td>{{ $contactus->name }}</td>
                                                    <td>{{ $contactus->email }}</td>
                                                    <td>{{ $contactus->phone }}</td>
                                                    <td>
                                                        <a href="#" class="message" data-comment="{{ $contactus->comment }}" data-toggle="modal" data-target="#exampleModal">View Comment...</a>
                                                    </td>
                                                    <td>@if(Auth::guard('admin')->user()->sectionCheck('about_delete') || Auth::guard('admin')->user()->role_id == 0)
                                                                {{--<a href="javascript:void(0);" data-href="{{ route('contact.destroy',$contactus->id) }}" class="btn btn-danger btn-sm mr-25 delete">Delete</a>--}}
                                                            @endif</td>
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
        <h5 class="modal-title" id="exampleModalLabel">Comment</h5>
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
@endsection

@section('scripts')

<script>
    $('.message').on('click', function(){
        var message = $(this).attr('data-comment');
        $('.comment').text(message);
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
