@extends('layouts.front')
@section('styles')
<style type="text/css">
    .payment{
        border:1px solid #28a745;
        height:280px;
        border-radius:20px;
        background:#fff;
    }
    .payment_header{
        background:#28a745;
        padding:20px;
        border-radius:20px 20px 0px 0px;
    }

    .check{
        margin:0px auto;
        width:50px;
        height:50px;
        border-radius:100%;
        background:#fff;
        text-align:center;
    }

    .check i{
        vertical-align:middle;
        line-height:50px;
        font-size:30px;
    }

    .message-content{
        text-align:center;
    }

    .message-content  h1{
        font-size:25px;
        padding-top:25px;
    }

    .message-content a{
        border-radius:30px;
    }

</style>
@endsection

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="payment">
                <div class="payment_header">
                    <div class="check"><i class="fa fa-check text-success" aria-hidden="true"></i></div>
                </div>
                <div class="message-content">
                    <h1>Success</h1>
                    <p>{{$success_message}}</p>
                    <a class="btn btn-primary" href="{{$back_url}}">Go Back</a>
                    @if(!empty($order))
                    <a class="btn btn-success" href="{{route('user.order_details', $order->id)}}">Order Details</a>
                    @endif
                </div>

            </div>
        </div>
        </div>
    </div>
@endsection
