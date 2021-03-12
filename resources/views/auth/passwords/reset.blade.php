<!DOCTYPE html>
<html>

<head>
    <title>Reset Password | Insurance Agent</title>
    <!-- meta_tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Meta_tag_Keywords -->
    <link rel="stylesheet" href="{{ URL::asset('public/admin/style.css') }}" type="text/css" media="all">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--web_fonts-->
    <link href="//fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900&amp;subset=latin-ext"
        rel="stylesheet">
    <!--//web_fonts-->
    <script src='//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>

<body>
    <div class="form">
        <div class="form-content" style="margin-top: 6%;">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-info">
                    <span class="fa fa-html5"
                        style="text-align: center;width: 100%; color: #fff;font-size: 65px;"></span>
                </div>
                <div class="email-w3l">
                    <span class="i1"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                    <input name="email" placeholder="Email" value="{{ old('email') }}" required class="email">
                </div>
                @error('email')
                <span style="color: #fff; margin-top: -10px;margin-left: 8px; float: left; width: 100%;" role="alert"
                    class="colorwhite">{{ $message }}</span>
                @enderror
                <div class="pass-w3l">
                    <span class="i2"><i class="fa fa-unlock" aria-hidden="true"></i></span>
                    <input class="pass" type="password" name="password" placeholder="Password"
                        autocomplete="new-password" required>
                </div>
                @error('password')
                <span role="alert" class="colorwhite"
                    style="color: #fff;margin-bottom: 15px; margin-left: 15px; float: left; width: 100%;">{{ $message }}</span>
                @enderror

                <div class="pass-w3l">
                    <span class="i2"><i class="fa fa-unlock" aria-hidden="true"></i></span>
                    <input class="pass" id="password-confirm" type="password" name="password_confirmation" placeholder="Confirm Password" autocomplete="new-password" required>
                </div>

                <input id="password-confirm" type="password" placeholder="Confirm Password"
                    name="asaspassword_confirmation" autocomplete="new-password" style="display: none;">
                <div class="submit-agileits">
                  <button type="submit" class="login">Reset Password</button>
                </div>
                <div class="form-check">
                    <div class="right" style="text-align: right; margin-right: 10px;">
                        <a href="{{ route('login') }}">login?</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
