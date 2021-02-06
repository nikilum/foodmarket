<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/auth.css">

    <link rel="preconnect" href="//fonts.gstatic.com">
    <link href="//fonts.googleapis.com/css2?family=Open+Sans:wght@800&display=swap" rel="stylesheet">
    <link href="//fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
</head>
<body>

<div class="register">
    <div class="logo-container">
        <div class="example logo">Logo Image</div>
    </div>
    <div class="register-container">
        <div class="register-form">
            <div class="form-group">
                <label for="inputEmail">Логин</label>
                <input type="email" class="form-control" id="inputEmail" placeholder="example@mail.ru"
                       aria-describedby="mailError">
                <small id="mailError" class="error-message"></small>
            </div>
            <div class="form-group">
                <label for="inputPassword">Пароль</label>
                <input type="password" class="form-control" id="inputPassword" placeholder="aPn6Cmz79sfzyDOz"
                       aria-describedby="PasswordError">
                <small id="passwordError" class="error-message"></small>
            </div>
            <button class="btn btn-success" id="submitButton">Вход</button>
            <small class="error-message unexpected-error-box"></small>
        </div>
    </div>
    <a class="bottom-ref" href="{{url("recovery")}}">Забыли пароль?</a>
</div>

<!-- Scripts -->

<script src="//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>
<script src="{{ url('resources/js/login.js') }}"></script>
</body>
</html>
