<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Настройки пользователя</title>

    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome-ie7.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/homepage.css">
    <link rel="stylesheet" href="/css/main_colors.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="block-light">

@include('panels.panel_header')

<div class="block-header">
    <div class="block-header-text">
        <span class="fas fa-sliders-h light"></span>
        <span class="header-text light">Настройки пользователя</span>
    </div>
    <hr class="header-delimiter bg-light">
</div>

<div class="user-editor-container">
    <div class="user-editor">
        <div class="user-editor-body">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputName">Имя</label>
                    <input type="text" class="form-control" id="inputName" placeholder="Иван">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputSurname">Фамилия</label>
                    <input type="text" class="form-control" id="inputSurname" placeholder="Иванов">
                </div>
            </div>
            <div class="form-group">
                <label for="inputAddress">Адрес</label>
                <input type="text" class="form-control" id="inputAddress" placeholder="Г. Москва, Ул. Тверская, Д. 123">
            </div>
            <div class="form-group">
                <label for="inputPhone">Номер телефона</label>
                <input type="text" class="form-control" id="inputPhone" placeholder="+7(123)456-78-90">
            </div>
        </div>
        <div class="user-editor-footer">
            <button class="btn btn-success" id="submitButton">Изменить данные</button>
            <small class="error-message unexpected-error-box" id="dataError"></small>
        </div>
    </div>
</div>

<div class="block-header">
    <div class="block-header-text">
        <span class="fas fa-key light"></span>
        <span class="header-text light">Изменить пароль</span>
    </div>
    <hr class="header-delimiter bg-light">
</div>

<div id="passwordEditor">
    <div class="user-editor-container">
        <div class="user-editor">
            <div class="user-editor-body">
                <div class="form-group">
                    <label for="inputOldPass">Старый пароль</label>
                    <input type="password" class="form-control" id="inputOldPass">
                </div>
                <div class="form-group">
                    <label for="inputPass">Новый пароль</label>
                    <input type="password" class="form-control" id="inputPass">
                </div>
            </div>
            <div class="user-editor-footer">
                <button class="btn btn-success" id="submitPassButton">Изменить пароль</button>
                <small class="error-message unexpected-error-box" id="passwordError"></small>
            </div>
        </div>
    </div>
</div>


<script src="//kit.fontawesome.com/22adceb6fe.js" crossorigin="anonymous"></script>
<script
    src="//code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
    crossorigin="anonymous"></script>
<script src="//cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>
<script src="//cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"
        integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s"
        crossorigin="anonymous"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>
<script src="{{ url('resources/js/settings.js') }}"></script>
</body>
</html>
