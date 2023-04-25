<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href={{ asset("fonts/material-icon/css/material-design-iconic-font.css") }}>

    <!-- Main css -->
    <link rel="stylesheet" href={{ asset("css/style.css") }}>
</head>
<body>

    <div class="main">

        <!-- Sign up form -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Register</h2>
                        <form method="POST" class="register-form" id="register-form" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="name" id="name" placeholder="Your Name"/>
                                @error('name')
                                <div style="color: #dc3545">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="Your Email"/>
                                @error('email')
                                <div style="color: #dc3545">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="pass" placeholder="Password"/>
                                @error('password')
                                <div style="color: #dc3545">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="password" name="password_confirmation" id="re_pass" placeholder="Repeat your password"/>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit" value="Register"/>
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src={{ asset("img/signup-image.jpg") }} alt="sing up image"></figure>
                        <span class="signup-image-link">Have an account already?</span>
                        <a href="{{ route('login') }}" class="signup-image-link">Log in</a>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- JS -->
    <script src={{ asset("js/jquery.min.js") }}></script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>