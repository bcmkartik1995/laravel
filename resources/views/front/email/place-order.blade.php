<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

Dear {{$name}} <br>
Your order number {{$order_number}} placed successfully.
Please <a href="{{route('user.order_details', $order_id)}}">click here</a> to view your order detail. <br>

Thanks, <br>
 {{env('APP_NAME')}}

</body>
</html>
