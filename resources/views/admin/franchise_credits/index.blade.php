@extends('layouts.admin')

@php
    use Carbon\Carbon;
@endphp
@section('content')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h5 class="content-header-title float-left pr-1 mb-0">Credit Plans</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active">Credit Plans
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
                            <h4 class="card-title">Credit Plans</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                @if(Auth::guard('admin')->user()->sectionCheck('franchise_credits_add'))
                                    <a href="{{route('franchise_credits.create')}}" class="btn btn-primary mb-2"><i class="bx bx-plus"></i>&nbsp; Purchase new plan</a>
                                @endif
                                <div class="table-responsive">
                                    <table class="table tbl-category dataTable" id="DataTables_Table_3" role="grid" aria-describedby="DataTables_Table_3_info">
                                        <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Title</th>
                                            <th>Total Credit</th>
                                            <th>Remain Credit</th>
                                            <th>Price</th>
                                            <th>Duration</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($franchise_credits as $franchise_credit)

                                            <tr>
                                                <td>{{ $franchise_credit->id }}</td>
                                                <td>{{ $franchise_credit->plan_id ? $franchise_credit->plan->title : 'Custom Plan' }}</td>
                                                <td>{{ $franchise_credit->total_credits }}</td>
                                                <td>{{ $franchise_credit->remain_credits }}</td>
                                                <td>{{ $franchise_credit->amount }}</td>
                                                <td>{{ $franchise_credit->plan_id ? (Carbon::parse($franchise_credit->start_date)->format('d/m/Y') .' - '. Carbon::parse($franchise_credit->end_date)->format('d/m/Y')) : '-' }}</td>
                                                <td>
                                                    @php
                                                        if($franchise_credit->status == 2){
                                                            $status = 'Expired';
                                                        }else if($franchise_credit->status == 0){
                                                            $status = 'Inactive';
                                                        }else{
                                                            $status = 'Active';
                                                        }
                                                    @endphp
                                                    <span class="badge badge-pill badge-light-info status-span-{{ $franchise_credit->id }}">{{ $status }}</span>
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
    $('.tbl-category').DataTable({
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
