<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    /* .btn{
        background-color: gray;
        color: #fff;
        padding: 10px;
        margin-top: 5px;
        text-align: center;
        text-decoration: none;
    } */
</style>
<body>

<div class="container">
     <div class="row justify-content-center">
         <div class="col-md-8">
             <div class="card">
                 <div class="card-header">Verify Your Email Address</div>
                   <div class="card-body">
                    @if(session('resent'))
                         <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif
                    <a href="{{ url('admin/reset-password/'.$token) }}" class="btn">Click Here</a>.
                </div>
            </div>
        </div>
    </div>
</div>
    
</body>
</html>



