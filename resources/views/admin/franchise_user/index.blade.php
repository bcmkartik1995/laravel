@extends('layouts.admin')

@section('content')

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h5 class="content-header-title float-left pr-1 mb-0">Franchise User</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active">Franchise User
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
                            <h4 class="card-title">Franchise User</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                            @if(Auth::guard('admin')->user()->sectionCheck('franchises_add') || Auth::guard('admin')->user()->role_id == 0)
                                <!-- <a href="{{route('categories.create')}}" id="addRow" class="btn btn-primary mb-2"><i class="bx bx-plus"></i>&nbsp; Add new</a> -->
                            @endif
                                <div class="table-responsive">
                                    <table class="table tbl-franchise">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Mobile</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($franchise_users as $franchise_user)
                                                <tr>
                                                    <td>{{ $franchise_user->id }}</td>
                                                    <td>{{ $franchise_user->name }}</td>
                                                    <td>{{ $franchise_user->email }}</td>
                                                    <td>{{ $franchise_user->phone }}</td>
                                                    <td>
                                                        <div style="">

                                                            <a href="{{route('franchise-user-edit',$franchise_user->id)}}" class="btn btn-warning btn-sm mr-25">Edit</a>

                                                            {{--<a href="javascript:void(0);" data-href="{{ route('franchise-user-delete',$franchise_user->id) }}" class="btn btn-danger btn-sm mr-25 delete">
                                                            Detete</a>--}}

                                                            @if(isset($franchise_user->franchiseID) && !empty($franchise_user->franchiseID))

                                                            @else
                                                            <a href="{{route('user-franchise',$franchise_user->id)}}" class="txt-white cusor-pointer btn btn-success btn-sm glow mr-25"> Create Franchise</a>
                                                            @endif

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

@endsection

@section('scripts')

<script>
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
    $('.tbl-franchise').DataTable({
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
