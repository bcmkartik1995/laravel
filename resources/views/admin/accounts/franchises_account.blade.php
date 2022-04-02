@extends('layouts.admin')

@section('content')

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h5 class="content-header-title float-left pr-1 mb-0">Account</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active">Account
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card card-user">
                <div class="card-header">
                    <h5 class="card-title">Account</h5>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="p-1 bg-dark text-white rounded-top">
                                <p style="border:none;margin: 0;">Account</p>
                            </div>
                            <div class="bg-white shadow">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td>Total Earning :</td>
                                            <td class="users-view-username text-right">{{ $franchise->offline_amount + $franchise->online_amount }}</td>
                                        </tr>
                                        <tr>
                                            <td>Commission :</td>
                                            <td class="users-view-username text-right">{{ $franchise->total_commission }}</td>
                                        </tr>
                                        <tr>
                                            <td>Payments :</td>
                                            <td class="users-view-username text-right">{{ $franchise->total_franchise_payment }} {{ $franchise->payment_flow}}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Total Outstanding :</td>
                                            <td class="font-weight-bold text-right users-view-username">{{ $franchise->outstanding_amount }} {{$franchise->flow}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')


@endsection
