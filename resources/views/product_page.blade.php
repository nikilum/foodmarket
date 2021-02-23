<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Foodmarket</title>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/homepage.css">
    <link rel="stylesheet" href="/css/main_colors.css">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome-ie7.min.css" rel="stylesheet">
    <link rel="preconnect" href="//fonts.gstatic.com">
    <link href="//fonts.googleapis.com/css2?family=Oswald:wght@700&display=swap" rel="stylesheet">
</head>
<body class="bg-dark">

@include('panels.panel_header')
<div class="centered-block">
    <div class="product-name-container">
        <div class="product-name">{{ $productName }}</div>
    </div>
    <hr>
    <div class="photo-container">
        <img src="https://blog.niklumpov.ru/storage/app/public/products/{{ $productImg }}">
    </div>
    <hr>
    <div class="product-description-container">
        <div class="product-description"> {!! $productDescription !!} </div>
    </div>
</div>


</body>
</html>
