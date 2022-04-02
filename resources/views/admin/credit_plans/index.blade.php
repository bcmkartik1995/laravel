@extends('layouts.admin')

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
                            <h4 class="card-title">Credit Price</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form id="form_validation" method="POST" action="{{ route('credit_plans.set_credit_price') }}" enctype="multipart/form-data">

                                    {{csrf_field()}}
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label class="form-label">Price for Credit</label>
                                            <input type="text" class="form-control @if($errors->has('price')) is-invalid @endif" name="price" value="{{old('price',isset($Credit_price->price) ?$Credit_price->price:'')}}" >
                                            @if($errors->has('price'))
                                                <label id="price-error" class="error" for="price">{{ $errors->first('price') }}</label>
                                            @endif
                                        </div>
                                    </div>
                                    @if(Auth::guard('admin')->user()->sectionCheck('credit_Price_edit') || Auth::guard('admin')->user()->role_id == 0)
                                        <button class="btn btn-primary btn-sm" type="submit">UPDATE</button>
                                    @endif    
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Credit Plans</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                @if(Auth::guard('admin')->user()->sectionCheck('credit_plans_add') || Auth::guard('admin')->user()->role_id == 0)
                                    <a href="{{route('credit_plans.create')}}" class="btn btn-primary mb-2"><i class="bx bx-plus"></i>&nbsp; Add new</a>
                                @endif
                                <div class="table-responsive">
                                    <table class="table tbl-category dataTable" id="DataTables_Table_3" role="grid" aria-describedby="DataTables_Table_3_info">
                                        <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Title</th>
                                            <th>Credit</th>
                                            <th>Price</th>
                                            <th>Validity</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($credit_plans as $credit_plan)
                                            <tr>
                                                <td>{{ $credit_plan->id }}</td>
                                                <td>{{ $credit_plan->title }}</td>
                                                <td>{{ $credit_plan->credit_value }}</td>
                                                <td>{{ $credit_plan->price }}</td>
                                                <td>{{ $credit_plan->validity_value }} {{ $validity_types[$credit_plan->validity_type] }}</td>
                                                <td><span class="badge badge-pill badge-light-info status-span-{{ $credit_plan->id }}">{{ $credit_plan->status==1 ? 'Active': 'Inactive' }}</span></td>
                                                <td>
                                                    <div style="display:flex;">
                                                        @if(Auth::guard('admin')->user()->sectionCheck('credit_plans_edit') || Auth::guard('admin')->user()->role_id == 0)
                                                            <a href="{{route('credit_plans.edit',$credit_plan->id)}}" class="btn btn-warning btn-sm mr-25">Edit</a>
                                                        @endif

                                                        @if(Auth::guard('admin')->user()->sectionCheck('credit_plans_delete') || Auth::guard('admin')->user()->role_id == 0)
                                                            {{--<a href="javascript:void(0);" data-href="{{ route('credit_plans.destroy',$credit_plan->id) }}" class="btn btn-danger btn-sm mr-25 delete">Detete</a>--}}
                                                        @endif

                                                        @if(Auth::guard('admin')->user()->sectionCheck('credit_plans_status') || Auth::guard('admin')->user()->role_id == 0)
                                                            <a href="javascript:void(0);" data-id="{{$credit_plan->id}}" data-action="credit_plans" class="common-toggle-button btn btn-{{$credit_plan->status==1?'danger':'success'}} btn-sm"> {{$credit_plan->status==1?'In Active':'Active'}}</a>
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
        // "columnDefs": [{
        //     "visible": false,
        //     "targets": 0
        // }],
        "order": [
            [0, 'DESC']
        ],
    });
</script>

@endsection
