@extends('layouts.front')
@section('styles')
<style type="text/css">
    .payment
    {
        border:1px solid #dc3545;
        height:280px;
        border-radius:20px;
        background:#fff;
    }
    .payment_header
    {
        background:#dc3545;
        padding:20px;
        border-radius:20px 20px 0px 0px;

    }

    .check
    {
        margin:0px auto;
        width:50px;
        height:50px;
        border-radius:100%;
        background:#fff;
        text-align:center;
    }

    .check i
    {
        vertical-align:middle;
        line-height:50px;
        font-size:30px;
    }

    .message-content
    {
        text-align:center;
    }

    .message-content  h1
    {
        font-size:25px;
        padding-top:25px;
    }

    .message-content a
    {
        width:200px;
        height:35px;
        color:#fff;
        border-radius:30px;
        padding:5px 10px;
        background:#dc3545;
        transition:all ease-in-out 0.3s;
    }

    .message-content a:hover
    {
        text-decoration:none;
        background:#000;
    }

</style>
@endsection
@section('content')

    <div class="container mt-5 mb-5">
        <div class="row">
           <div class="col-md-6 mx-auto">
              <div class="payment">
                 <div class="payment_header">
                    <div class="check"><i class="fa fa-exclamation-triangle text-danger" aria-hidden="true"></i></div>
                 </div>
                 <div class="message-content">
                    <h1>Opps ! Something Went Wrong</h1>
                    <p>{{$error_message}}</p>
                    <a href="{{$back_url}}">Go Back</a>
                 </div>

              </div>
           </div>
        </div>
    </div>
@endsection
