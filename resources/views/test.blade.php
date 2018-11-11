


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Store</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" type="text/css" href="/css/app.css">
    <!--===============================================================================================-->
</head>
<body class="animsition">

<div id="app">
    <!-- Header -->
    <my-header></my-header>
    <!-- Slide1 -->
    <sec-slide></sec-slide>
    <router-view></router-view>


</div>

<!--===============================================================================================-->

<script src="/js/app.js"></script>

</body>
</html>


<div class="wrap_menu">
    <nav class="menu">
        <ul class="main_menu">
            @auth
                <li>
                    <a href="{{ url('/home') }}">Home</a>
                </li>
            @else
                <li>
                    <a href="{{ route('login') }}">Login</a>
                </li>

                @if (Route::has('register'))
                    <li>
                        <a href="{{ route('register') }}">Register</a>
                    </li>
                @endif
            @endauth
            <li>
                <a href="#">Category</a>
                <ul class="sub_menu">
                    <li><a href="#">Homepage V1</a></li>
                    <li><a href="#">Homepage V2</a></li>
                    <li><a href="#">Homepage V3</a></li>
                </ul>
            </li>

        </ul>
    </nav>
</div>


<!-- Header -->
<my-header></my-header>
<!-- Slide1 -->
<sec-slide></sec-slide>
<!-- Banner -->
<sec-banner></sec-banner>
<!-- New Product -->
<new-item></new-item>
<!-- Banner2 -->
<banner-two></banner-two>
<!-- Blog -->
<sec-blog></sec-blog>
<!-- Instagram -->
<sec-instagram></sec-instagram>
<!-- Shipping -->
<sec-shipping></sec-shipping>
<!-- Footer -->
<my-footer></my-footer>
<!-- Back to top -->

