@extends('layouts.admin')

@section('content')

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">     
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h5 class="content-header-title float-left pr-1 mb-0">Franchise Fees</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active">Franchise Fees
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
                            <h4 class="card-title">Franchise Fees</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <!-- <a href="{{route('categories.create')}}" id="addRow" class="btn btn-primary mb-2"><i class="bx bx-plus"></i>&nbsp; Add new</a> -->
                                <div class="table-responsive">
                                    <table class="table tbl-franchises-fees">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>User</th>
                                                <th>Franchise Name</th>
                                                <th>Email</th>
                                                <th>Mobile Number</th>
                                                <th>Commission(%)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($franchises as $franchise)
                                            <tr>
                                                <td>{{ $franchise->id }}</td>
                                                <td>{{ $franchise->user_name }}</td>
                                                <td>{{ $franchise->franchise_name }}</td>
                                                <td>{{ $franchise->email }}</td>
                                                <td>{{ $franchise->mobile }}</td>
                                                <td>{{ $franchise->commission }}%</td>                                                                        
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
    $('.tbl-franchises-fees').DataTable({
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


