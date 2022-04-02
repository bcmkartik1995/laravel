<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Document</title>

    <style>

.clearfix:after {
  content: "";
  display: table;
  clear: both;
}

a {
  color: #0087C3;
  text-decoration: none;
}

body {
  position: relative;
  margin: 0 auto; 
  color: #555555;
  background: #FFFFFF; 
  font-family: Arial, sans-serif; 
  font-size: 13px; 
  font-family: SourceSansPro;
}
.margin-header{
  margin-top: 20px;
}
header {
  padding: 10px 0;
  margin-top: 10px;
  margin-bottom: 20px;
  border-bottom: 1px solid #AAAAAA;
}

#logo {
  float: left;
  margin-top: 8px;
}

#logo1 {
  float: right;
  margin-top: 8px;
}

#logo1 img {
  height: 110px;
}

#logo img {
  height: 50px;
}

#details {
  margin-bottom: 50px;
}
.bill-info{
    font-size: 15px;
}
#client {
  padding-left: 6px;
  border-left: 6px solid #0087C3;
  float: left;
  
}

#client .to {
  color: #777777;
}

h2.name {
  font-size: 1.4em;
  font-weight: normal;
  margin: 0;
}

#invoice {
  /* text-align: right; */
}

#invoice h1 {
  color: #0087C3;
  font-size: 2.4em;
  line-height: 1em;
  font-weight: normal;
  margin: 0  0 10px 0;
}

#invoice .date {
  font-size: 1.1em;
  color: #777777;
}
.table-service{
    margin-top: 20px;
    margin-bottom: 30px;
}
.table-service h4{
    font-size: 20px;
}
table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 10px;
}

table th,
table td {
  padding: 10px;
  background: #EEEEEE;
  text-align: center;
  border-bottom: 1px solid #FFFFFF;
}

table th {
  white-space: nowrap;        
  font-weight: normal;
}

table td {
  text-align: center;
}

table td h3{
  color: #79888a;
  font-size: 1.2em;
  font-weight: normal;
  margin: 0 0 0.2em 0;
}

table .no {
  color: #FFFFFF;
  background: #79888a;
  font-size: 1.2em;
}

table .desc {
  text-align: left;
}

table .unit {
  background: #DDDDDD;
}

table .qty {
}

table .total {
  background: #79888a;
  color: #FFFFFF;
}

table td.unit,
table td.qty,
table td.total {
  font-size: 1.2em;
}

table tbody tr:last-child td {
  border: none;
}

table tfoot td {
  padding: 10px 10px;
  background: #FFFFFF;
  border-bottom: none;
  font-size: 1.2em;
  white-space: nowrap; 
  border-top: 1px solid #AAAAAA; 
}

table tfoot tr:first-child td {
  border-top: none; 
}

table tfoot tr:last-child td {
  color: #57B223;
  font-size: 1.4em;
  border-top: 1px solid #57B223; 

}

table tfoot tr td:first-child {
  border: none;
}

#thanks{
  font-size: 2em;
  margin-bottom: 50px;
}

#notices{
  padding-left: 6px;
  border-left: 6px solid #0087C3;  
}

#notices .notice {
  font-size: 1em;
}
.invoice-title{
}
footer {
  color: #777777;
  width: 100%;
  height: 20px;
  position: absolute;
  bottom: 0;
  border-top: 1px solid #AAAAAA;
  padding: 8px 0;
  text-align: center;
}

.package-service-text-left{
  text-align: left !important;
}
</style>

</head>
<body>

@php
    $booking = json_decode($custom,true);
    
    $datetime = new DateTime($booking['created_at']);
    $date = $datetime->format('d-m-Y');
    $time = $datetime->format('h:i A');
@endphp
<div id="details">
    <div style="float: left; width: 50%;">
        <div id="client">
            <span class="">Invoice#</span>
            <span>{{ $booking['order_number'] }}</span>
        </div>
    </div>
    <div style="float: right; width: 50%; text-align: right;">
            <small class="">Order Date:</small>
            <span>{{ $date }}</span>
            <small class="">Order Time:</small>
            <span>{{ $time }}</span>
    </div>
</div>


<header class="clearfix">
    <div class="margin-header">
        <div style="width:100%">
            <div id="logo" style="float: right;">
                <img src="{{ public_path('assets/admin-assets/images/logo.png')}}" alt="logo" height="25" width="200">
            </div>
            <div id="company" style="float: left;  text-align: left; width: 50%; vertical-align: middle;">
                <h1 class="">Invoice</h1>
            </div>
        </div>
    </div>
</header>


<div id="details">
    <div style="float: left; width: 50%;" class="bill-info">
        <div id="client">
            <div class="to">Bill From:</div>
            <div class="mb-1">
                <span>{{ env('APP_NAME') }}</span>
            </div>
            {{--<!-- <div class="mb-1">
                <span>{{ $booking['address_1'] }}</span>
            </div>
            <div class="mb-1">
                <span>{{ $booking['email'] }}</span>
            </div>
            <div class="mb-1">
                <span>{{ $booking['mobile'] }}</span>
            </div> -->--}}
        </div>
    </div>
    <div style="float: right; width: 50%;" class="bill-info">
        <div id="invoice">
            <div class="to">Bill To:</div>
            <div class="mb-1">
                <span>{{ $booking['customer_name'] }}</span>
            </div>
            <div class="mb-1">
                <span>{{ $booking['customer_address'] }}</span>
            </div>
            <div class="mb-1">
                <span>{{ $booking['customer_email'] }}</span>
            </div>
            <div class="mb-1">
                <span>{{ $booking['customer_phone'] }}</span>
            </div>
        </div>
    </div>
</div>

@if(!empty($booking['cart']['services']))
<div class="clearfix"></div>
<div class="table-service">
    <h4 class="text-primary">Services</h4>
    <table cellspacing="0" cellpadding="0">
        <thead>
            <tr>
                <th class="no"><strong>Item</strong></th>
                <th class="unit"><strong>Cost</strong></th>
                <th class="qty"><strong>Qty</strong></th>
                <th class="total"><strong>Price</strong></th>
            </tr>
        </thead>
        <tbody>
            @foreach($booking['cart']['services'] as $service)
                <tr>
                    <td class="no">{{$service['title']}}</td>
                    <td class="unit">{{$service['price']}}</td>
                    <td class="qty">{{$service['quantity']}}</td>
                    <td class="total">{{$service['price']}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

@if(!empty($booking['cart']['packages']))
<div class="clearfix"></div>
<div class="table-service">
    <h4 class="text-primary">Packages</h4>
    <table cellspacing="0" cellpadding="0">
        <thead>
            <tr>
                <th class="no"><strong>Item</strong></th>
                <th class="desc"><strong>Discount</strong></th>
                <th class="unit"><strong>Cost</strong></th>
                <th class="qty"><strong>Qty</strong></th>
                <th class="unit"><strong>Services</strong></th>
                <th class="total"><strong>Price</strong></th>
            </tr>
        </thead>
        <tbody>
            @foreach($booking['cart']['packages'] as $package)
                <tr>
                    <td class="no">{{$package['title']}}</td>
                    <td class="desc">{{$package['discount_value']}}{{ $package['discount_type'] == 1 ? '%' : ''}}</td>
                    <td class="unit">{{$package['original_price']}}</td>
                    <td class="qty">{{$package['quantity']}}</td>
                    <td class="unit">
                        <ul class="package-service-text-left">
                            @foreach($package['package_service'] as $service)
                                <li class="text-left">{{ $service['title'] }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="total">{{$package['price']}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

<div id="details-total">
    <div style="float: left; width: 60%;" class="bill-info">
        <div id="client">
            <p>Thanks for your business.</p>
        </div>
    </div>
    <div style="float: right; width: 40%;" class="bill-info">
        <div id="invoice">
            <div class="">
                <span class="invoice-title" style="text-align:left;display:inline-block;width: 40%;">Subtotal</span>
                <span class="invoice-value" style="text-align:right;display:inline-block;width: 50%;" >{{ $booking['cart']['origional_price'] }}</span>
            </div>
            </div>
            <div class="">
                <span class="invoice-title" style="text-align:left;display:inline-block;width: 40%;">Discount</span>
                <span class="invoice-value" style="text-align:right;display:inline-block;width: 50%;">{{ $booking['cart']['discount'] }}</span>
            </div>
            <div class="">
                <span class="invoice-title text-dark font-weight-bold" style="text-align:left;display:inline-block;width: 40%;">Invoice Total</span>
                <span class="invoice-value text-primary font-weight-bold" style="text-align:right;display:inline-block;width: 50%;"> {{ $booking['cart']['final_total'] }} </span>
            </div>
        </div>
    </div>
</div>

            
</body>
</html>