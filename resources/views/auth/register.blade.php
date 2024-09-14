<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Register</title>
</head>
<body>
     <div class="container d-flex justify-content-center align-items-center min-vh-100">
       <div class="row border rounded-5 p-4 bg-white shadow box-area" style="max-width: 900px;">
       <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box">
           <img src="http://localhost:8000/assets/img/login.png" alt="" style="width: 100%">
       </div>
       <div class="col-md-6 right-box">
        <div style="font-size:28px;font-weight:bold">Register Yourself</div>
        <div class="text-muted "style="font-size:14px;">Akses Mudah, Absensi Tanpa Ribet!</div>
          <div class="row align-items-center">
                <div class="header-text mb-4">
                </div>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
            
                    <div class="input-group mb-3">
                        <input type="text" id="name" name="name" :value="old('name')"  class="form-control form-control-lg bg-light fs-5 mt-3" placeholder="Your Name">
                    </div>
                    <div class="input-group mb-3">
                        <input type="email" name="email" id="email" class="form-control form-control-lg bg-light fs-5" :value="old('email')" required autocomplete="username" placeholder="Email">
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" id="password" :value="__('Password')"  class="form-control form-control-lg bg-light fs-5" required autocomplete="password" placeholder="Password">
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password_confirmation" id="password_confirmation" :value="__('Confirm Password')"  class="form-control form-control-lg bg-light fs-5" required autocomplete="new-password" placeholder="Confirmation Password">
                    </div>
                    
                    <div class="input-group mb-3">
                        <button class="btn btn-lg btn-primary w-100 fs-5"   {{ __('Register') }}
                        >Register</button>
                    </div>
                    <div class="row">
                        <small class="fs-6">Sudah Mempunyai Akun?<a href="{{ route('login') }}">Login</a></small>
                    </div>
          </div>
       </div> 
      </div>
    </div>
                </form>
</body>
</html>
