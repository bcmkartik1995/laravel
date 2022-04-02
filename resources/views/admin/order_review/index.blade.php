@extends('layouts.admin')

@section('content')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">     
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h5 class="content-header-title float-left pr-1 mb-0">Order Review</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active">Order Review
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
                            <h4 class="card-title">Order Review</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">

                                <div class="table-responsive2">
                                    <table class="table tbl-order-review">
                                        <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>User</th>
                                            <th>Order number</th>
                                            <th>Order</th>
                                            <th>Rating</th>
                                            <th>Description</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($order_reviews as $order_review)
                                                <tr>
                                                    <td>{{ $order_review->id }}</td>
                                                    <td>{{ $order_review->user->name }}</td>
                                                    <td>{{ $order_review->order->order_number }}</td>
                                                    <td>
                                                        <a href="#" class="" data-toggle="modal" data-target="#order_detail-{{$order_review->id}}">
                                                            View Order Detail
                                                        </a>
                                                        <div class="modal fade" id="order_detail-{{$order_review->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLongTitle">Description</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <!-- @php
                                                                        echo '<pre>';
                                                                            print_R($order_review->order->cart);
                                                                    @endphp -->
                                                                    @if(isset($order_review->order->cart['services']))
                                                                        <table class="table table-bordered">
                                                                            <h6 class="card-title mt-2">Services</h6>
                                                                            <tr>
                                                                                <th>Service</th>
                                                                                <th>Price</th>
                                                                            </tr>
                                                                            @foreach($order_review->order->cart['services'] as $service)
                                                                                <tr>
                                                                                    <td>{{$service['title']}}</td>
                                                                                    <td>{{$service['price']}}</td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </table>
                                                                    @endif
                                                                    @if(isset($order_review->order->cart['packages']))
                                                                        <table class="table table-bordered">
                                                                            <h6 class="card-title mt-2">Packages</h6>
                                                                            <tr>
                                                                                <th>package</th>
                                                                                <th>Package Price</th>
                                                                                <th>Package Service</th>
                                                                            </tr>
                                                                            @foreach($order_review->order->cart['packages'] as $package)
                                                                                <tr>
                                                                                    <td>{{$package['title']}}</td>
                                                                                    <td>{{$package['price']}}</td>
                                                                                    <td>
                                                                                        <ul>
                                                                                            @foreach($package['package_service'] as $service)
                                                                                               <li>{{ $service['title'] }}</li>
                                                                                            @endforeach
                                                                                        </ul>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </table>
                                                                    @endif
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @for($i=1;$i<=5;$i++)
                                                            <span class="bx {{$order_review->order_rating >= $i ? 'bxs-star text-warning':'bx-star'}}"></span>
                                                        @endfor
                                                    </td>
                                                    <td>
                                                        <a href="#" class="" data-toggle="modal" data-target="#order_rating_desc-{{$order_review->id}}">
                                                            View Description...
                                                        </a>
                                                        
                                                        <div class="modal fade" id="order_rating_desc-{{$order_review->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLongTitle">Description</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                {!! $order_review->description !!}
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                </div>
                                                                </div>
                                                            </div>
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
    $('.tbl-order-review').DataTable({
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
