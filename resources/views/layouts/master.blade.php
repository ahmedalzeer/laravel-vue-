<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Ecommerce') }}</title>

    <link href="/css/app.css" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper" id="app">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
            </li>
        </ul>

        <!-- SEARCH FORM -->

            <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" @keyup="searchit" v-model="search" type="search" placeholder="Search" aria-label="Search">
                <input type="hidden" id="userid" value="{{Auth::user()->id}}">
                <div class="input-group-append">
                    <button class="btn btn-navbar" @click.prevent="searchit">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>


        <!-- Right navbar links -->

    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="/" class="brand-link">
            <img src="/img/user.gif" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">Sales Managment</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="/img/profile/{{ Auth::user()->photo }}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <router-link to="/dashboard" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt green"></i>
                            <p>
                                Dashboard
                            </p>
                        </router-link>
                    </li>
                    @can('isadmin')
                    <li class="nav-item has-treeview ">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-cog pink"></i>
                            <p>
                                Management
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <router-link to="/user" class="nav-link">
                                <i class="nav-icon fa fa-users blue"></i>
                                <p>
                                    Users
                                </p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/sale" class="nav-link">
                                    <i class="nav-icon fas fa-fire pink"></i>
                                    <p>
                                        Sales
                                    </p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/buy" class="nav-link">
                                    <i class="nav-icon fas fa-money-check-alt green"></i>
                                    <p>
                                        Buys
                                    </p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/item" class="nav-link">
                                    <i class="nav-icon fas fa-boxes yellow"></i>
                                    <p>
                                        Items
                                    </p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/category" class="nav-link">
                                    <i class="nav-icon fas fa-align-justify indigo"></i>
                                    <p>
                                        Categories
                                    </p>
                                </router-link>
                            </li>
                        </ul>
                    </li>
                        <li class="nav-item has-treeview ">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-copy red"></i>
                                <p>
                                    Reports
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <router-link to="/sreport" class="nav-link">
                                        <i class="nav-icon fas fa-eye purple"></i>
                                        <p>
                                            Sales Report
                                        </p>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/breport" class="nav-link">
                                        <i class="nav-icon fas fa-eye yellow"></i>
                                        <p>
                                            Buys Report
                                        </p>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/outlay" class="nav-link">
                                        <i class="nav-icon fa fa-credit-card green"></i>
                                        <p>
                                            Outlays
                                        </p>
                                    </router-link>
                                </li>
                            </ul>
                        </li>
                    <li class="nav-item">
                        <router-link to="/developer" class="nav-link">
                            <i class="nav-icon fa fa-cogs purple"></i>
                            <p>
                                Developer
                            </p>
                        </router-link>
                    </li>
                    @endcan
                    <li class="nav-item">
                        <router-link to="/profile" class="nav-link">
                            <i class="nav-icon fa fa-user yellow"></i>
                            <p>
                                Profile
                            </p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            <i class="nav-icon fa fa-power-off red"></i>
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="container">
            <div class="container-fluid">
                <router-view></router-view>
                <vue-progress-bar></vue-progress-bar>
            </div>
        </div>
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
            Anything you want
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2014-2018 <a href="#">Ahmed Alzeer</a>.</strong> All rights reserved.
    </footer>
</div>
<!-- ./wrapper -->
@auth
    <script type="text/javascript">
    window.user =@json(auth()->user())
    </script>
@endauth

<script src="/js/app.js"></script>
</body>
</html>
