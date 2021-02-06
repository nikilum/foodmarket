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
    <div class="register-container verify-container">
        <div class="form-group">
            <label for="inputCode">Код подтверждения был отправлен вам на почту</label>
            <input id="inputCode" type="text"
                   class="form-control" placeholder="A1B2-C3D4-E5F6-G7H8" aria-describedby="codeError">
            <small id="codeError" class="error-message unexpected-error-box"></small>
        </div>
        <button class="btn btn-success" id="mailConfirmButton">Подтвердить</button>
    </div>
    <a class="bottom-ref" href="{{url("")}}">Не пришёл код? Вы можете отправить письмо ещё раз</a>
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
<script src="{{ url('resources/js/register.js') }}"></script>
</body>
</html>
