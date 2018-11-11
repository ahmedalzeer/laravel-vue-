<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sales Management</title>

    <link href="/css/app.css" rel="stylesheet" type="text/css">
</head>
<body>

<div class="containerr">
    <nav class="navbar navbar-expand-sm bg-primary navbar-dark">
        <a class="navbar-brand" href="#">Sales Management</a>
        <ul class="navbar-nav pull-right">
            @if (Route::has('login'))
            <li class="nav-item active">
                @auth
                    <a href="{{ url('/home') }}">Home</a>
                @else
            </li>
            <li class="nav-item login">
                <a href="{{ route('login') }}">Login</a>
            </li>
            <li class="nav-item">
                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            </li>
            @endauth
            @endif
        </ul>
    </nav>
    <div >
        <div id="demo" class="carousel slide" data-ride="carousel">
            <ul class="carousel-indicators">
                <li data-target="#demo" data-slide-to="0" class="active"></li>
                <li data-target="#demo" data-slide-to="1"></li>
                <li data-target="#demo" data-slide-to="2"></li>
            </ul>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="/img/33.jpg" alt="Los Angeles" width="1100" height="500">
                    <div class="carousel-caption">
                        <h2>Admin Dashboard</h2>
                        <p>very easy to use</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="/img/34.jpg" alt="Chicago" width="1100" height="500">
                    <div class="carousel-caption">
                        <h2>Vue Js</h2>
                        <p>try very fast app</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="/img/35.jpg" alt="New York" width="1100" height="500">
                    <div class="carousel-caption">
                        <h2>Laravel Framwork </h2>
                        <p>very easy to use and develop!</p>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#demo" data-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </a>
            <a class="carousel-control-next" href="#demo" data-slide="next">
                <span class="carousel-control-next-icon"></span>
            </a>
        </div>
    </div>
</div>
<script type="text/javascript" src="/js/app.js"></script>
</body>
</html>
