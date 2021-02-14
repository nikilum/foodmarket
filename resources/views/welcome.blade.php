<!DOCTYPE html>
<html lang="en">
<head>
    <title>Foodmarket</title>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/homepage.css">
    <link rel="stylesheet" href="/css/main_colors.css">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome-ie7.min.css" rel="stylesheet">
    <link rel="preconnect" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

<a id="up"></a>
<a href="#up">
    <div class="go-up-btn bottom-button">
        <span class="fas fa-arrow-up"></span>
    </div>
</a>
@if($user_email !== 'guest')
    <div class="foreground"></div>
    <div class="shopping-cart-open-btn bottom-button" id="openCartBtn">
        <span class="fas fa-shopping-cart"></span>
    </div>

    <div class="cart" id="sidebar">
        <div class="block-header light" id="sidebarHeader">
            <div class="block-header-text">
                <span class="fas fa-shopping-cart dark"></span>
                <span class="header-text dark">Корзина</span>
                <button id="sendOrderButton" class="btn btn-white">Составить заказ</button>
            </div>
            <hr class="header-delimiter bg-dark">
        </div>
    </div>

@endif

@include('panels.panel_header')

<div id="newsCarousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#newsCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#newsCarousel" data-slide-to="1"></li>
        <li data-target="#newsCarousel" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="d-block w-100 header-carousel-pic" src="{{ url('resources/pics/carousel_1.jpg') }}"
                 alt="First slide">
        </div>
        <div class="carousel-item">
            <img class="d-block w-100 header-carousel-pic" src="{{ url('resources/pics/carousel_2.jpg') }}"
                 alt="Second slide">
        </div>
        <div class="carousel-item">
            <img class="d-block w-100 header-carousel-pic" src="{{ url('resources/pics/carousel_3.jpg') }}"
                 alt="Third slide">
        </div>
    </div>
    <a class="carousel-control-prev" href="#newsCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#newsCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<div class="block-light">
    <div class="block-header">
        <div class="block-header-text">
            <span class="fas fa-shopping-cart light"></span>
            <span class="header-text light">Товары</span>
        </div>
        <hr class="header-delimiter bg-light">
    </div>
    <div class="card-columns products-bar" id="products">

    </div>
</div>

<div class="modal fade" id="orderModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
     aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderModalLabel">Оформление заказа</h5>
            </div>
            <div class="modal-body">

                <label for="userName" class="modal-label">Ваше имя</label>
                <input type="text" class="form-control green-input-border"
                       id="userName">

                <label for="userAddress" class="modal-label">Ваш адрес</label>
                <input type="text" class="form-control green-input-border"
                       id="userAddress">

                <label for="userPhone" class="modal-label">Ваш номер телефона</label>
                <input type="text" class="form-control green-input-border"
                       id="userPhone">
            </div>
            <div class="modal-footer justify-content-between">
                <small class="error-text" id="modalError"></small>
                <div class="modal-buttons">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="hideModal">Отмена
                    </button>
                    <button type="button" class="btn btn-primary submit-button" id="submitButton">Оформить</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->

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
<script src="{{ url('resources/js/homepage.js') }}"></script>
</body>
</html>
