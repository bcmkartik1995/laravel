<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        .regards-p{
            font-weight: 600;
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
<div>
    <h2>Hi {{ $booking['customer_name'] }},</h2>
    <p>
        We Re Happy To See You At <b>VELOX!</b> <br>
        You Will Find Your Invoice In Attachment <br>
    </p>
    <p class="regards-p">
        Regards, <br>
        Velox Solution
    </p>
</div>
</body>
</html>