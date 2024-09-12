<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Login</title>
    <style>
        /* body {
            background-color: #003366; 
        } */
    </style>
</head>
<body>
     <div class="container d-flex justify-content-center align-items-center " style="margin-top: 80px">
       <div class="row border rounded-5 p-4 bg-white shadow box-area" style="max-width: 900px;">
       <div class="col-md-6 rounded-6 d-flex justify-content-center align-items-center">
        <div class="">
            <img src="http://localhost:8000/assets/img/login.png" alt=""style="width:100%">
        </div>
       </div>
       <div class="col-md-6 right-box">
        <div style="font-size:28px;font-weight:bold">Login In To Your Account</div>
        <div class="text-muted "style="font-size:14px;">Welcome Back! Human Resource Sistem</div>

          <div class="row align-items-center">
                <div class="header-text mb-4">
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="input-group mb-4">
                        <input type="email" id="email" name="email" :value="old('email')"  class="form-control form-control-lg bg-light fs-5 mt-3" placeholder="Email address" required autofocus autocomplete="username">
                    </div>
                    <div class="input-group mb-4">
                        <input type="password" name="password" id="password" class="form-control form-control-lg bg-light fs-5" :value="__('Password')" placeholder="Password" 
                            required autocomplete="current-password">
                    </div>
                    <div class="input-group mb-3 mt-3">
                        <button class="btn btn-lg btn-primary w-100 fs-5"   {{ __('Log in') }}>Login</button>
                    </div>
                    <div class="row">
                        <small class="fs-6">Belum mempunyai akun? <a href="{{ route('register') }}">Register</a></small>
                    </div>
          </div>
       </div> 
      </div>
    </div>
                </form>
</body>
</html>
