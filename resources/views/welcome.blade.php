<!DOCTYPE html>
<html lang="en">
<head>
    <title>Homepage</title>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/homepage.css">
    <link rel="stylesheet" href="/css/main_colors.css">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome-ie7.min.css" rel="stylesheet">
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
        <div class="block-header light">
            <div class="block-header-text">
                <span class="fas fa-shopping-cart dark"></span>
                <span class="header-text dark">Корзина</span>
            </div>
            <hr class="header-delimiter bg-dark">
        </div>

        <div class="cart-item">
            <img src="{{ url('resources/pics/example_1_to_1.jpg') }}" class="cart-item-img" alt="product">
            <div class="vr"></div>
            <div class="cart-item-text">
                <div class="cart-item-header">
                    Форель
                </div>
                <div class="cart-item-description">
                    Lorem ipsum dolor sit amet
                </div>
            </div>
        </div>
        <div class="cart-item">
            <img src="{{ url('resources/pics/example_1_to_1.jpg') }}" class="cart-item-img" alt="product">
            <div class="vr"></div>
            <div class="cart-item-text">
                <div class="cart-item-header">
                    Форель
                </div>
                <div class="cart-item-description">
                    Lorem ipsum dolor sit amet
                </div>
            </div>
        </div>
        <div class="cart-item">
            <img src="{{ url('resources/pics/example_1_to_1.jpg') }}" class="cart-item-img" alt="product">
            <div class="vr"></div>
            <div class="cart-item-text">
                <div class="cart-item-header">
                    Форель
                </div>
                <div class="cart-item-description">
                    Lorem ipsum dolor sit amet
                </div>
            </div>
        </div>
        <div class="cart-item">
            <img src="{{ url('resources/pics/example_1_to_1.jpg') }}" class="cart-item-img" alt="product">
            <div class="vr"></div>
            <div class="cart-item-text">
                <div class="cart-item-header">
                    Форель
                </div>
                <div class="cart-item-description">
                    Lorem ipsum dolor sit amet
                </div>
            </div>
        </div>
        <div class="cart-item">
            <img src="{{ url('resources/pics/example_1_to_1.jpg') }}" class="cart-item-img" alt="product">
            <div class="vr"></div>
            <div class="cart-item-text">
                <div class="cart-item-header">
                    Форель
                </div>
                <div class="cart-item-description">
                    Lorem ipsum dolor sit amet
                </div>
            </div>
        </div>
        <div class="cart-item">
            <img src="{{ url('resources/pics/example_1_to_1.jpg') }}" class="cart-item-img" alt="product">
            <div class="vr"></div>
            <div class="cart-item-text">
                <div class="cart-item-header">
                    Форель
                </div>
                <div class="cart-item-description">
                    Lorem ipsum dolor sit amet
                </div>
            </div>
        </div>
        <div class="cart-item">
            <img src="{{ url('resources/pics/example_1_to_1.jpg') }}" class="cart-item-img" alt="product">
            <div class="vr"></div>
            <div class="cart-item-text">
                <div class="cart-item-header">
                    Форель
                </div>
                <div class="cart-item-description">
                    Lorem ipsum dolor sit amet
                </div>
            </div>
        </div>
        <div class="cart-item">
            <img src="{{ url('resources/pics/example_1_to_1.jpg') }}" class="cart-item-img" alt="product">
            <div class="vr"></div>
            <div class="cart-item-text">
                <div class="cart-item-header">
                    Форель
                </div>
                <div class="cart-item-description">
                    Lorem ipsum dolor sit amet
                </div>
            </div>
        </div>
        <div class="cart-item">
            <img src="{{ url('resources/pics/example_1_to_1.jpg') }}" class="cart-item-img" alt="product">
            <div class="vr"></div>
            <div class="cart-item-text">
                <div class="cart-item-header">
                    Форель
                </div>
                <div class="cart-item-description">
                    Lorem ipsum dolor sit amet
                </div>
            </div>
        </div>
        <div class="cart-item">
            <img src="{{ url('resources/pics/example_1_to_1.jpg') }}" class="cart-item-img" alt="product">
            <div class="vr"></div>
            <div class="cart-item-text">
                <div class="cart-item-header">
                    Форель
                </div>
                <div class="cart-item-description">
                    Lorem ipsum dolor sit amet
                </div>
            </div>
        </div>
        <div class="cart-item">
            <img src="{{ url('resources/pics/example_1_to_1.jpg') }}" class="cart-item-img" alt="product">
            <div class="vr"></div>
            <div class="cart-item-text">
                <div class="cart-item-header">
                    Форель
                </div>
                <div class="cart-item-description">
                    Lorem ipsum dolor sit amet
                </div>
            </div>
        </div>
        <div class="cart-item">
            <img src="{{ url('resources/pics/example_1_to_1.jpg') }}" class="cart-item-img" alt="product">
            <div class="vr"></div>
            <div class="cart-item-text">
                <div class="cart-item-header">
                    Форель
                </div>
                <div class="cart-item-description">
                    Lorem ipsum dolor sit amet
                </div>
            </div>
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
            <img class="d-block w-100 header-carousel-pic" src="{{ url('resources/pics/example_16_to_6.jpg') }}"
                 alt="First slide">
        </div>
        <div class="carousel-item">
            <img class="d-block w-100 header-carousel-pic" src="{{ url('resources/pics/example_16_to_6.jpg') }}"
                 alt="Second slide">
        </div>
        <div class="carousel-item">
            <img class="d-block w-100 header-carousel-pic" src="{{ url('resources/pics/example_16_to_6.jpg') }}"
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
    <div class="card-columns products-bar">
        <div class="card product-card">
            <img src="{{ url('resources/pics/example_1_to_1.jpg') }}" class="card-img-top product-img" alt="product">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <hr class="bg-light">
                <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional
                    content. This content is a little bit longer.</p>
            </div>
            <a href="#" class="stretched-link"></a>
        </div>
        <div class="card product-card">
            <img src="{{ url('resources/pics/example_1_to_1.jpg') }}" class="card-img-top product-img" alt="product">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <hr class="bg-light">
                <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional
                    content. This content is a little bit longer.</p>
            </div>
            <a href="#" class="stretched-link"></a>
        </div>
        <div class="card product-card">
            <img src="{{ url('resources/pics/example_1_to_1.jpg') }}" class="card-img-top product-img" alt="product">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <hr class="bg-light">
                <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional
                    content. This content is a little bit longer.</p>
            </div>
            <a href="#" class="stretched-link"></a>
        </div>
        <div class="card product-card">
            <img src="{{ url('resources/pics/example_1_to_1.jpg') }}" class="card-img-top product-img" alt="product">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <hr class="bg-light">
                <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional
                    content. This content is a little bit longer.</p>
            </div>
            <a href="#" class="stretched-link"></a>
        </div>
        <div class="card product-card">
            <img src="{{ url('resources/pics/example_1_to_1.jpg') }}" class="card-img-top product-img" alt="product">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <hr class="bg-light">
                <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional
                    content. This content is a little bit longer.</p>
            </div>
            <a href="#" class="stretched-link"></a>
        </div>
        <div class="card product-card">
            <img src="{{ url('resources/pics/example_1_to_1.jpg') }}" class="card-img-top product-img" alt="product">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <hr class="bg-light">
                <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional
                    content. This content is a little bit longer.</p>
            </div>
            <a href="#" class="stretched-link"></a>
        </div>
        <div class="card product-card">
            <img src="{{ url('resources/pics/example_1_to_1.jpg') }}" class="card-img-top product-img" alt="product">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <hr class="bg-light">
                <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional
                    content. This content is a little bit longer.</p>
            </div>
            <a href="#" class="stretched-link"></a>
        </div>
        <div class="card product-card">
            <img src="{{ url('resources/pics/example_1_to_1.jpg') }}" class="card-img-top product-img" alt="product">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <hr class="bg-light">
                <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional
                    content. This content is a little bit longer.</p>
            </div>
            <a href="#" class="stretched-link"></a>
        </div>
        <div class="card product-card">
            <img src="{{ url('resources/pics/example_1_to_1.jpg') }}" class="card-img-top product-img" alt="product">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <hr class="bg-light">
                <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional
                    content. This content is a little bit longer.</p>
            </div>
            <a href="#" class="stretched-link"></a>
        </div>
        <div class="card product-card">
            <img src="{{ url('resources/pics/example_1_to_1.jpg') }}" class="card-img-top product-img" alt="product">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <hr class="bg-light">
                <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional
                    content. This content is a little bit longer.</p>
            </div>
            <a href="#" class="stretched-link"></a>
        </div>
        <div class="card product-card">
            <img src="{{ url('resources/pics/example_1_to_1.jpg') }}" class="card-img-top product-img" alt="product">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <hr class="bg-light">
                <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional
                    content. This content is a little bit longer.</p>
            </div>
            <a href="#" class="stretched-link"></a>
        </div>
        <div class="card product-card">
            <img src="{{ url('resources/pics/example_1_to_1.jpg') }}" class="card-img-top product-img" alt="product">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <hr class="bg-light">
                <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional
                    content. This content is a little bit longer.</p>
            </div>
            <a href="#" class="stretched-link"></a>
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
<script src="{{ url('resources/js/homepage.js') }}"></script>
</body>
</html>
