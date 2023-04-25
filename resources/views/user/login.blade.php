<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href={{ asset("fonts/material-icon/css/material-design-iconic-font.css") }}>

    <!-- Main css -->
    <link rel="stylesheet" href={{ asset("css/style.css") }}>
</head>
<body>

<div class="main">
<section class="sign-in">
    <div class="container">
        <div class="signin-content">
            <div class="signin-image">
                <figure><img src={{ asset("img/signin-image.jpg") }} alt="sing up image"></figure>
                <span class="signup-image-link">Don't have an account?</span>
                <a href="{{ route('register') }}" class="signup-image-link">Register</a>
            </div>

            <div class="signin-form">
                <h2 class="form-title">Log In</h2>
                <form method="POST" class="register-form" id="login-form" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="your_name"><i class="zmdi zmdi-email"></i></label>
                        <input type="text" name="email" id="your_name" placeholder="Your Email"/>
                        @error('email')
                        <div style="color: #dc3545">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                        <input type="password" name="password" id="your_pass" placeholder="Password"/>
                        @error('password')
                        <div style="color: #dc3545">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <input type="checkbox" name="remember-me" id="remember-me" class="agree-term" />
                        <label for="remember-me" class="label-agree-term"><span><span></span></span>Remember me</label>
                    </div>
                    <div class="form-group form-button">
                        <input type="submit" name="signin" id="signin" class="form-submit" value="Log in"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

</div>

<!-- JS -->
<script src={{ asset("js/jquery.min.js") }}></script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>