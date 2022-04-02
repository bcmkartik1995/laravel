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
New user registration on {{env('APP_NAME')}} <br>
Username: {{$email}} <br>
Password: {{$password}} <br>
Please <a href="{{ route('admin.login') }}">click here</a> to login to your account <br>

Thanks, <br>
 {{env('APP_NAME')}}

</body>
</html>