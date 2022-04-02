@extends('layouts.admin')

@section('content')
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- Dashboard Ecommerce Starts -->
            <section id="dashboard-ecommerce" class="mt-2">
                <div class="row">
                    <!-- Greetings Content Starts -->
                    
                    @if(Auth::guard('admin')->user()->role_title() == 'superadmin')
                        <div class="col-sm-3 col-12 dashboard-users-danger">
                            <div class="card text-center">
                                <div class="card-content">
                                    <div class="card-body py-1">
                                        <a href="{{ route('users.index') }}">
                                            <div class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto mb-50">
                                                <i class="bx bx-user font-medium-5"></i>
                                            </div>
                                            <div class="text-muted line-ellipsis">Total Users</div>
                                            <h3 class="mb-0">{{ $user_count }}</h3>
                                        </a>    
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(Auth::guard('admin')->user()->role_title() == 'superadmin')
                        <div class="col-sm-3 col-12 dashboard-users-danger">
                            <div class="card text-center">
                                <div class="card-content">
                                    <div class="card-body py-1">
                                        <a href="{{ route('franchise-view') }}">
                                            <div class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto mb-50">
                                                <i  class="bx bx-store-alt font-medium-5"></i>
                                            </div>
                                            <div class="text-muted line-ellipsis">Total Franchise</div>
                                            <h3 class="mb-0">{{ $franchise_count }}</h3>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(Auth::guard('admin')->user()->role_title() == 'superadmin')
                        <div class="col-sm-3 col-12 dashboard-users-danger">
                            <div class="card text-center">
                                <div class="card-content">
                                    <div class="card-body py-1">
                                        <a href="{{ route('services.index') }}">
                                            <div class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto mb-50">
                                                <i class="bx bxs-wrench font-medium-5"></i>
                                            </div>
                                            <div class="text-muted line-ellipsis">Total Service</div>
                                            <h3 class="mb-0">{{ $service_count }}</h3>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(Auth::guard('admin')->user()->role_title() == 'superadmin')
                        <div class="col-sm-3 col-12 dashboard-users-danger">
                            <div class="card text-center">
                                <div class="card-content">
                                    <div class="card-body py-1">
                                        <a href="{{ route('orders-view') }}">
                                            <div class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto mb-50">
                                                <i class="bx bx-cart font-medium-5"></i>
                                            </div>
                                            <div class="text-muted line-ellipsis">Total Completed Orders</div>
                                            <h3 class="mb-0">{{ $order_count }}</h3>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(Auth::guard('admin')->user()->role_title() == 'franchises')
                        <div class="col-sm-3 col-12 dashboard-users-danger">
                            <div class="card text-center">
                                <div class="card-content">
                                    <div class="card-body py-1">
                                        <a href="{{ route('franchise-order') }}">
                                            <div class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto mb-50">
                                                <i class="bx bx-cart font-medium-5"></i>
                                            </div>
                                            <div class="text-muted line-ellipsis">Total Orders</div>
                                            <h3 class="mb-0">{{ $franchise_order }}</h3>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(Auth::guard('admin')->user()->role_title() == 'franchises')
                        <div class="col-sm-3 col-12 dashboard-users-danger">
                            <div class="card text-center">
                                <div class="card-content">
                                    <div class="card-body py-1">
                                        <a href="{{ route('franchises-worker.index') }}">
                                            <div class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto mb-50">
                                                <i class="bx bxs-group font-medium-5"></i>
                                            </div>
                                            <div class="text-muted line-ellipsis">Total Worker</div>
                                            <h3 class="mb-0">{{ $franchise_worker }}</h3>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(Auth::guard('admin')->user()->role_title() == 'franchises')
                        <div class="col-sm-3 col-12 dashboard-users-danger">
                            <div class="card text-center">
                                <div class="card-content">
                                    <div class="card-body py-1">
                                        <a href="{{ route('franchise_credits.index') }}">
                                            <div class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto mb-50">
                                                <i class="bx bxs-credit-card font-medium-5"></i>
                                            </div>
                                            <div class="text-muted line-ellipsis">Remain Credits</div>
                                            <h3 class="mb-0">{{ $franchise_plan->remain_credits_count }}</h3>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(Auth::guard('admin')->user()->role_title() == 'franchises')
                        <div class="col-sm-3 col-12 dashboard-users-danger">
                            <div class="card text-center">
                                <div class="card-content">
                                    <div class="card-body py-1">
                                        <a href="{{ route('franchises-service.index') }}">
                                            <div class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto mb-50">
                                                <i class="bx bxs-credit-card font-medium-5"></i>
                                            </div>
                                            <div class="text-muted line-ellipsis">Service</div>
                                            <h3 class="mb-0">{{ $franchise_service }}</h3>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </section>
            <!-- Dashboard Ecommerce ends -->

        </div>
    </div>
</div>
<!-- END: Content-->

@endsection

@section('scripts')

<!-- BEGIN: Page JS-->
<script src="{{ asset('assets/admin-assets/app-assets/js/scripts/pages/dashboard-ecommerce.js') }}"></script>
<!-- END: Page JS-->
@endsection