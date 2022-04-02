@extends('home')

@section('title')
	Permission
@endsection

@section('extra-css')

@endsection

@section('index')

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">     
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h5 class="content-header-title float-left pr-1 mb-0">Permission</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active">Permission
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
                            <h4 class="card-title">Permission</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <a href="{{route('permissions.create')}}" class="btn btn-primary mb-2"><i class="bx bx-plus"></i>&nbsp; Add new</a>
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table tbl-permission">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Name</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($permissions as $row)
                                                <tr>
                                                    <td>{{ $row->id }}</td>
                                                    <td>{{ $row->name }}</td>
                                                    <td>
                                                        <div style="display:flex;">
                                                            <a href="{{route('permissions.edit',$row->id)}}" class="btn btn-warning btn-sm">Edit</a>
                                                                &nbsp;
                                                            <form id="delete_form{{$row->id}}" method="POST" action="{{ route('permissions.destroy',$row->id) }}"  onclick="return confirm('Are you sure?')">
                                                                {{ csrf_field() }}
                                                                <input name="_method" type="hidden" value="DELETE">
                                                                <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                                                            </form>
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
            </div>
        </section>
        <!--/ Add rows table -->
    </div>
</div>


@endsection

@section('extra-script')
<script>
    $('.tbl-permission').DataTable({
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
