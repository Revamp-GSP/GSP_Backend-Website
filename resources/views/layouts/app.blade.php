<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('Dashboard', 'Dashboard') }}</title>
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">


    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <style>
        body {
            position: flex;
            overflow-x: hidden;
            background-color: #CFD8DC;
        }
        body,
        html {
            height: 100%;
            width: 100%;
        } 
        li {
            list-style: none;
            margin: 20px 0 20px 0;
        }

        a {
            text-decoration: none;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            margin-left: -300px;
            transition: 0.4s;
        }

        .active-main-content {
            margin-left: 250px;
        }

        .active-sidebar {
            margin-left: 0;
        }

        #main-content {
            transition: 0.4s;
        } 
        .container, .navbar{
            background-color: #596FB7 ;
            padding-bottom:0px;
        }
        .nav-item.admin, .nav-item.logout {
            font-size: 22px;
            font-weight: 800;
            background-color: #596FB7 !important;
        }

        .navbar-title {
            position: absolute;
            left: 45%;
            transform: translateX(-50%);
            color: white;
        }

        .dropdown-item {
            padding: 0.25rem 1.5rem;
            clear: both;
            font-weight: normal;
            color: #333;
            text-align: inherit;
            white-space: nowrap;
        }

        .dropdown-item:hover, .dropdown-item:focus {
            color: #fff;
            background-color: #007bff;
        }

        .dropdown-item.active, .dropdown-item:active {
            color: #fff;
            background-color: #007bff;
        }

        .dropdown-divider {
            height: 1px;
            margin: .5rem 0;
            overflow: hidden;
            background-color: #e9ecef;
        }

        .navbar-brand,
        .nav-item.admin,
        .nav-item.logout {
            font-size: 20px;
            margin-top: 15px;
            transition: all 0.3s;
        }
        .navbar-brand{
            padding-bottom:50px;
        }

        .nav-item.logout {
            font-weight: 800; 
            cursor: pointer; 
        }

        .navbar-nav .nav-item.admin,
        .navbar-nav .nav-item.logout {
            margin-left: 30px;
            font-size: 22px;
            font-weight: 800;
            color: white !important; 
        }

        .nav-item.logout:hover {
            color: #fff; 
            text-shadow: 2px 2px 4px rgba(0,0,0,0.4); 
        }

        .logo {
            margin-right: -180px; 
            margin-left: 50px;
            background-color: #596FB7 !important;
        }

        .logo img {
            width: 100%;
            height: 80px;
            object-fit: cover;
        }

        #wrapper {
            padding-left: 0;
            -webkit-transition: all 0.5s ease;
            -moz-transition: all 0.5s ease;
            -o-transition: all 0.5s ease;
            transition: all 0.5s ease;
        }

        #wrapper.toggled {
            padding-left: 220px;
        }

        #sidebar-wrapper {
            z-index: 1000;
            left: 220px;
            width: 0;
            height: 100%;
            margin-left: -220px;
            overflow-y: auto;
            overflow-x: hidden;
            background: #1a1a1a;
            -webkit-transition: all 0.5s ease;
            -moz-transition: all 0.5s ease;
            -o-transition: all 0.5s ease;
            transition: all 0.5s ease;
        }

        #sidebar-wrapper::-webkit-scrollbar {
        display: none;
        }

        #wrapper.toggled #sidebar-wrapper {
            width: 220px;
        }

        #page-content-wrapper {
            width: 100%;
            padding-top: 70px;
        }

        #wrapper.toggled #page-content-wrapper {
            position: absolute;
            margin-right: -220px;
        }

        /*-------------------------------*/
        /*     Sidebar nav styles        */
        /*-------------------------------*/
        .navbar {
            padding: 0;
        }
        .sidebar-nav.active {
			transition: all .3s ease-in-out;
			transform: translate(0%, 0px);
			-webkit-transform: translate(0%, 0px);
			-ms-transform: translate(0%, 0px);
			box-shadow: 0 4px 6px rgba(0, 0, 0, .4);
		}
        .sidebar-nav {
            position: absolute;
            top: 0;
            width: 220px;
            height: 100%;
            margin: 0;
            padding: 0;
            list-style: none;
            background:#4F4660;
        }

        .sidebar-nav li {
            position: relative; 
            line-height: 10px;
            display: inline-block;
            width: 100%;
        }

        .sidebar-nav li:before {
            top: 0;
            left: 0;
            z-index: ;
            height: 100%;
            width: 3px;
            -webkit-transition: width .2s ease-in;
            -moz-transition:  width .2s ease-in;
            -ms-transition:  width .2s ease-in;
                    transition: width .2s ease-in;

        }
        .sidebar-nav li:hover{
            background: skyblue !important;
            border-radius: 40px;
            margin-left: 10px;
            margin-right: 10px;
            padding-top: 28px;
            transition: background-color 0.3s ease;
        }

        .sidebar-nav li:hover a {
            padding-left: 40px;
            padding-top:10px;
        }


        .sidebar-nav li:hover:before,
        .sidebar-nav li.open:hover:before {
            width: 100%;
            -webkit-transition: width .2s ease-in;
            -moz-transition:  width .2s ease-in;
            -ms-transition:  width .2s ease-in;
                    transition: width .2s ease-in;
        }

        .sidebar-nav li a {
            display: block;
            color: #ddd;
            text-decoration: none;
            padding: 0px 0px 0px 30px;
            font-size: 20px;
            font-weight: bold;
        }

        .sidebar-nav li a:hover,
        .sidebar-nav li a:active,
        .sidebar-nav li a:focus,
        .sidebar-nav li.open a:hover,
        .sidebar-nav li.open a:active,
        .sidebar-nav li.open a:focus{
            color: #fff;
            text-decoration: none;
            background-color: transparent;
            font-weight: bold;
        }
        .nav-item:hover .dropdown-menu {
            display: block;
        }
        .sidebar-header {
            text-align: center;
            font-size: 20px;
            position: relative;
            width: 100%;
            display: inline-block;
            padding-top:5px;
        }
        .sidebar-brand {
            height: 84px;
            position: relative;
            background:#4F4660;
            padding-top: 1em;
            border-bottom: 3px solid black; /* Menetapkan garis hitam di bawah kotak brand */
        }
        .sidebar-brand a {
            color: #ddd;
        }
        .sidebar-nav li a i {
            margin-right: 10px; /* Menambahkan margin kanan pada ikon */
        }
        .sidebar-brand a:hover {
            color: #fff;
            text-decoration: none;
        }
        .dropdown-header {
            text-align: center;
            font-size: 1em;
            color: #ddd;
            background:#212531;
        }
        .sidebar-nav .dropdown-menu {
            position: relative;
            width: 100%;
            height: 100%;
            padding: 0;
            margin: 0;
            border-radius: 0;
            border: none;
            background-color: #222;
            box-shadow: none;
        }
       
        .dropdown-menu.show {
            top: 0;
        }
        .nav.sidebar-nav li a::before {
            font-family: fontawesome;
            padding-right: 15px;
        }
        .hamburger {
            height: 50%;
            position: fixed;
            top: 20px; 
            z-index: 999;
            display: block;
            width: 32px;
            height: 32px;
            margin-left: 10px;
            background: transparent;
            border: none;
        }

        .hamburger:hover,
        .hamburger:focus,
        .hamburger:active {
            outline: none;
            position: fixed;
        }

        .hamburger.is-closed:before {
            display: block;
            width: 100px;
            font-size: 14px;
            position: fixed;
            color: #fff;
            line-height: 32px;
            text-align: center;
            opacity: 0;
            -webkit-transform: translate3d(0,0,0);
            -webkit-transition: opacity .35s ease-in-out;
            transition: opacity .35s ease-in-out;
        }

        .hamburger.is-closed:hover:before {
            opacity: 1;
            position: fixed;
        }

        .hamburger.is-closed .hamb-top,
        .hamburger.is-closed .hamb-middle,
        .hamburger.is-closed .hamb-bottom,
        .hamburger.is-open .hamb-top,
        .hamburger.is-open .hamb-middle,
        .hamburger.is-open .hamb-bottom {
            position: absolute;
            left: 0;
            height: 4px;
            width: 100%;
        }

        .hamburger.is-closed .hamb-top,
        .hamburger.is-closed .hamb-middle,
        .hamburger.is-closed .hamb-bottom {
            background-color: #ffffff;
        }

        .hamburger.is-closed .hamb-top { 
            top: 5px; 
            -webkit-transition: top .35s ease-in-out;
            transition: top .35s ease-in-out;
        }

        .hamburger.is-closed .hamb-middle {
            top: 50%;
            margin-top: -2px;
        }

        .hamburger.is-closed .hamb-bottom {
            bottom: 5px;  
            -webkit-transition: bottom .35s ease-in-out;
            transition: bottom .35s ease-in-out;
        }

        .hamburger.is-closed:hover .hamb-top {
            top: 0;
        }

        .hamburger.is-closed:hover .hamb-bottom {
            bottom: 0;
        }

        .hamburger.is-open .hamb-top,
        .hamburger.is-open .hamb-middle,
        .hamburger.is-open .hamb-bottom {
            background-color: #1a1a1a;
        }

        .hamburger.is-open .hamb-top,
        .hamburger.is-open .hamb-bottom {
            top: 50%;
        }

        .hamburger.is-open .hamb-top { 
            -webkit-transform: rotate(45deg);
            -webkit-transition: -webkit-transform .2s cubic-bezier(.73,1,.28,.08);
            transition: transform .2s cubic-bezier(.73,1,.28,.08);
        }

        .hamburger.is-open .hamb-middle { 
            display: none; 
        }

        .hamburger.is-open .hamb-bottom {
            -webkit-transform: rotate(-45deg);
            -webkit-transition: -webkit-transform .2s cubic-bezier(.73,1,.28,.08);
            transition: transform .2s cubic-bezier(.73,1,.28,.08);
        }
        .overlay {
            display: none;
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0,0,0,0.5);
            z-index: 1;
        }
        .user-profile {
            display: flex;
            align-items: center;
            font-weight:800;
        }

        .profile-image {
            width: 50px; 
            height: 50px; /* Sesuaikan ukuran sesuai kebutuhan */
            border-radius: 50%; /* Agar gambar berbentuk lingkaran */
            margin-right: 30px; /* Jarak antara gambar profil dan teks nama */
            margin-left: 25px;
            margin-top: -15px;
            margin-bottom: -15px;
        }
    </style>
</head>
<body>
    <div id="app">
    <nav class="navbar navbar-expand-md shadow-sm">
    <div class="container">
        <div class="navbar-title">
            <h3>Dashboard Monitoring Project PT. Gerbang Sinergi Prima</h3>
        </div>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i id="notificationIcon" class="fas fa-bell" style="color: white; font-size: 30px; margin-left:30px !important;"></i></a>
                    </li>
                    <li class="nav-item admin">
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                    <li class="nav-item logout">
                        <a class="nav-link" style="color: white;" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                    </li>
                    <div class="logo">
                        <img src="{{ asset('images/logo-nobg.png') }}" alt="Logo">
                    </div>
                @endguest
            </ul>
        </div>
    </div>
    </nav>
        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <div id="wrapper">
        <!-- Sidebar -->
        <nav class="navbar-inverse fixed-top" id="sidebar-wrapper" role="navigation">
            <ul class="nav sidebar-nav">
                <div class="sidebar-header">
                <div class="sidebar-brand">
                <div class="user-profile">
                    <img src="{{ asset('images/user-profile-image.png') }}" alt="User Profile Image" class="profile-image">
                    <span style="color: white;">{{ Auth::user()->name }}</span>
                </div>
                </div>
                </div>
                <li><a href="{{ route('admin.home') }}"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="{{ route('projects.index') }}"><i class="fas fa-tasks"></i> Projects</a></li>
                <li><a href="{{ route('customers.index') }}"><i class="fas fa-user-friends"></i> Customers</a></li>
                <li><a href="{{ route('products.index') }}"><i class="fas fa-handshake"></i> Services</a></li>
                <li><a href="{{ route('users.index') }}"><i class="fas fa-user"></i> Users</a></li>
            </ul>
        </nav>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <button type="button" class="hamburger animated fadeInLeft is-closed" data-toggle="offcanvas">
                <span class="hamb-top"></span>
                <span class="hamb-middle"></span>
                <span class="hamb-bottom"></span>
            </button>
        </div>
        <!-- /#page-content-wrapper -->
    </div>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Custom JS -->
    <script>
        $(document).ready(function () {
            var trigger = $('.hamburger'),
                overlay = $('.overlay'),
                isClosed = true;

            function hamburger_cross() {
                if (isClosed == true) {
                    overlay.hide();
                    trigger.removeClass('is-open');
                    trigger.addClass('is-closed');
                    isClosed = false;
                } else {
                    overlay.show();
                    trigger.removeClass('is-closed');
                    trigger.addClass('is-open');
                    isClosed = true;
                }
                adjustMainContent(); // Memanggil fungsi setiap kali hamburger_cross dipanggil
            }

            $('[data-toggle="offcanvas"]').click(function () {
                $('#wrapper').toggleClass('toggled');
                adjustMainContent(); // Memanggil fungsi setiap kali sidebar dibuka atau ditutup
            });
            
            // Pemanggilan fungsi untuk memastikan layout yang benar saat halaman dimuat
            adjustMainContent();
        });

        function adjustMainContent() {
            var sidebarWidth = $('.sidebar').width();
            var isSidebarOpen = $('#wrapper').hasClass('toggled');
            var marginValue = isSidebarOpen ? sidebarWidth : 0;
            $('#page-content-wrapper').css('margin-left', marginValue);
            
            // Jika sisi bar terbuka, ubah lebar konten utama sesuai dengan lebar sisi bar
            if (isSidebarOpen) {
                $('#page-content-wrapper').css('width', 'calc(100% - ' + sidebarWidth + 'px)');
            } else {
                // Jika sisi bar tertutup, kembalikan lebar konten utama ke nilai awal
                $('#page-content-wrapper').css('width', '100%');
            }
        }   
    </script>


</body>
</html>

