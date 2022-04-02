

@extends('layouts.admin')

@section('content')

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h5 class="content-header-title float-left pr-1 mb-0">Income</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active">Income
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card card-user">
                <div class="card-header">
                    <h5 class="card-title">Income</h5>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="p-1 bg-dark text-white rounded-top">
                                <p style="border:none;margin: 0;">Income</p>
                            </div>
                            <div class="bg-white shadow">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td>Total Online Payments :</td>
                                            <td class="users-view-username text-right">{{ number_format($total_online_payments,2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Total Offline Payments :</td>
                                            <td class="users-view-username text-right">{{ number_format($total_offline_payments,2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Total Refundable Amount :</td>
                                            <td class="users-view-username text-right">{{ number_format($total_refundable_amount,2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Total Refunded Amount :</td>
                                            <td class="users-view-username text-right">{{ number_format($total_refunded_amount,2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Franchises Amount(Overall Payment To Pay) :</td>
                                            <td class="users-view-username text-right">{{ number_format($total_pay_to_franchise,2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Commission From Franchises  :</td>
                                            <td class="users-view-username text-right">{{ number_format($total_commission,2) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Total Income :</td>
                                            <td class="font-weight-bold text-right users-view-username">{{ number_format($total_income,2) }}</td>
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


@endsection

@section('scripts')


@endsection
