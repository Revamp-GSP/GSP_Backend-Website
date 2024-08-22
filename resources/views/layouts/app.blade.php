<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('Dashboard', 'Dashboard') }}</title>
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md shadow-sm fixed-top">
            <div class="container">
                <div class="navbar-title">
                    <h4>Dashboard Monitoring Project PT. Gerbang Sinergi Prima</h4>
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
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-bell" style="color: white; font-size: 24px;"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" id="notification-item" style="color:black; margin-left:5px;">
                                    <!-- Notifications will be added by JavaScript -->
                                </div>
                            </li>
                            <li class="nav-item admin">
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                  document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt" style="font-size: 24px;"></i> <!-- Icon Logout -->
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
                                    <i class="fas fa-sign-out-alt" style="font-size: 24px;"></i> <!-- Icon Logout -->
                                </a>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <div id="wrapper" class="toggled">
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
                <li><a href="{{ route('notifications.index') }}"><i class="fas fa-bell"></i> Notifications</a></li>
                <li><a href="{{ route('logActivity') }}"><i class="fas fa-list-alt"></i> Activity Log</a></li>
            </ul>
        </nav>

        <div id="page-content-wrapper">
            <div class="content">
                @yield('content')
            </div>
            <button type="button" class="hamburger animated fadeInLeft is-closed" data-toggle="offcanvas">
                <span class="hamb-top"></span>
                <span class="hamb-middle"></span>
                <span class="hamb-bottom"></span>
            </button>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
       $(document).ready(function () {
    var trigger = $('.hamburger'),
        overlay = $('.overlay'),
        isClosed = true;

    function hamburger_cross() {
        if (isClosed == true) {
            $('.content').css('margin-left', '-200px');
            isClosed = false;
        } else {
            $('.content').css('margin-left', '-250px');
            isClosed = true;
        }
    }

    $('[data-toggle="offcanvas"]').click(function () {
        $('#wrapper').toggleClass('toggled');
        hamburger_cross();
    });

    hamburger_cross();

    fetchNotifications();
});

// Variabel untuk menyimpan konten notifikasi yang sudah ditampilkan
var displayedNotificationContent = {};

function fetchNotifications() {
    $.ajax({
        url: '/notifications',
        type: 'GET',
        success: function (response) {
            var notifications = response.data;
            var notificationList = $('#notification-item');
            notificationList.empty();
            var unreadNotificationsExist = false;

            if (notifications.length > 0) {
                notifications.forEach(function (notification) {
                    // Tambahkan notifikasi hanya jika belum dibaca
                    if (!notification.read_at) {
                        var contentKey = JSON.stringify(notification.data);
                        if (!displayedNotificationContent.hasOwnProperty(contentKey)) {
                            displayedNotificationContent[contentKey] = true;

                            var notificationItem = $('<div class="notification-item"></div>').text(notification.data.message);
                            var changes = notification.data.changes;
                            var changesList = $('<ul></ul>');
                            for (var field in changes) {
                                var changeItem = $('<li></li>').text(field + ': ' + changes[field].old + ' to ' + changes[field].new);
                                changesList.append(changeItem);
                            }
                            notificationItem.append(changesList);

                            notificationItem.addClass('unread');
                            unreadNotificationsExist = true;
                            notificationList.append(notificationItem);
                        }
                    }
                });
            }

            // Jika tidak ada notifikasi yang belum dibaca, tambahkan pesan "No notifications"
            if (!unreadNotificationsExist) {
                notificationList.html('<span class="no-notifications">No notifications</span>');
            }
        },
        error: function (xhr, status, error) {
            console.error('Error fetching notifications:', error);
        }
    });
}






    </script>
</body>
</html>
