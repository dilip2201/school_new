<!DOCTYPE html>
<html>

<head>
    <title>Login | School Deparment</title>
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

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-info">
                    <span class="fa fa-html5"
                        style="text-align: center;width: 100%; color: #fff;font-size: 65px;"></span>
                </div>
                @if (session('message'))
             <div class="alert alert-success" role="alert" style="max-width: 410px;
                margin: 0 auto;
                color: #3dd200;
                background: no-repeat;
                border: none;
                margin-bottom: 5px;
                font-size: 14px;
                text-align: center;
            ">
                Password reset successfully.
             </div>
             @endif
                <div class="email-w3l">
                    <span class="i1"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                    <input name="username" id="username"  placeholder="User Id" value="{{ old('username') }}" required class="email @error('username') is-invalid @enderror">
                </div>
                @if (\Session::has('error'))
                <span style="color: #fff; margin-top: -10px;margin-left: 8px; float: left; width: 100%;" role="alert"
                    class="colorwhite">{!! \Session::get('error') !!}</span>
                @endif
                <div class="pass-w3l">
                    <span class="i2"><i class="fa fa-unlock" aria-hidden="true"></i></span>
                    <input class="pass" type="password" name="password" placeholder="Password"
                        autocomplete="new-password">
                </div>
                @error('password')
                <span role="alert" class="colorwhite"
                    style="color: #fff;margin-top: -18px;margin-bottom: 15px; margin-left: 15px; float: left; width: 100%;">{{ $message }}</span>
                @enderror
                <input id="password-confirm" type="password" placeholder="Confirm Password"
                    name="asaspassword_confirmation" autocomplete="new-password" style="display: none;">
                <div class="submit-agileits">
                    <input class="login" type="submit" value="login">
                </div>
               <div class="form-check">
                    <div class="right">
                        <a href="{{ route('password.request') }}">Forgot Password?</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>