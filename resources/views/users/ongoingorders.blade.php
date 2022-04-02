@extends('layouts.front')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/front-assets/css/plugin/datatables/dataTables.bootstrap4.min.css') }}" media="screen">
@endsection

@section('content')

<section class="user-dashbord">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="user-profile-info-area">
                    @include('includes.front.dashboard-links')
                </div>
            </div>

            <div class="col-lg-9">
                <div class="user-profile-details">
                    <div class="ongoing-orders">
                        <div class="header-area">
                            <h4 class="title">
                                Ongoing Order
                            </h4>
                        </div>
                        <div class="mr-table allproduct mt-4">
                            <div class="table-responsive">
                                <table id="example" class="table table-hover dt-responsive dataTable no-footer dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 111px;">#Order</th>
                                            <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 73px;">Date</th>
                                            <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 89px;">Order Total</th>
                                            <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 98px;">Order Status</th>
                                            <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 98px;">Payment Status</th>
                                            <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 119px;">View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($orders->count())
                                            @foreach($orders as $order)
                                                <tr role="row" class="odd">
                                                    <td tabindex="0">
                                                        {{$order->order_number}}
                                                    </td>
                                                    <td>
                                                        {{date('d, M Y', strtotime($order->created_at))}}
                                                    </td>
                                                    <td>
                                                        ₹{{$order->pay_amount}}
                                                    </td>
                                                    <td>
                                                        <div class="order-status processing">
                                                            {{ucwords($order->status)}}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="">
                                                            {{ucwords($order->payment_status)}}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a class="mybtn2 sm" href="{{route('user.order_details', $order->id)}}">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
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

@endsection

@section('scripts')
<script src="{{ asset('assets/front-assets/js/plugin/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/front-assets/js/plugin/datatables/dataTables.bootstrap4.min.js') }}"></script>


<script>
    $('#example').DataTable();
</script>
@endsection
