<?php 

use Stevebauman\Location\Facades\Location;

?>

@extends('layouts.admin')

@section('content')

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">     
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h5 class="content-header-title float-left pr-1 mb-0">Franchises Assigned</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active">Franchises Assigned
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
                            <h4 class="card-title">Franchises Assigned</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <!-- <a href="{{route('categories.create')}}" id="addRow" class="btn btn-primary mb-2"><i class="bx bx-plus"></i>&nbsp; Add new</a> -->
                                <div class="table-responsive">
                                    <table class="table tbl-franchises-assigned">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>franchises Name</th>
                                                <th>Amount</th>
                                                <th>User Name</th>
                                                <th>User Address</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($franchises_orders as $franchises_order)
                                            <tr>
                                                <td>{{ $franchises_order->id }}</td>
                                                <td>{{ $franchises_order->franchise_name }}</td>
                                                <td>{{ $franchises_order->pay_amount }}</td>
                                                <td>{{ $franchises_order->name }}</td>
                                                <td>{{ $franchises_order->customer_address }}</td>
                                                <td>
                                                    @if($franchises_order->status == 0)
                                                        <span class="span-{{ $franchises_order->id }}"><span class="badge badge-pill badge-light-info">Pending</span></span>
                                                    @elseif($franchises_order->status == 1)
                                                        <span class="span-{{ $franchises_order->id }}"><span class="badge badge-pill badge-light-success">Accept</span></span>
                                                    @elseif($franchises_order->status == 2)
                                                        <span class="span-{{ $franchises_order->id }}"><span class="badge badge-pill badge-light-danger">Cancelled</span></span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div style="display:flex;">
                                                        {{--<!-- <a href="javascript:void(0);" data-href="{{ route('orders-delete',$franchises_order->id) }}" class="btn btn-danger btn-sm mr-25 delete">Detete</a> -->--}}

                                                        @if(Auth::guard('admin')->user()->sectionCheck('franchise_assigned_view') || Auth::guard('admin')->user()->role_id == 0)
                                                            <a href="{{route('orders-details',$franchises_order->orders_id)}}" class="btn btn-warning btn-sm">View</a>
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



    $('.tbl-franchises-assigned').DataTable({
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
