<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <title>@yield("title")</title>
</head>
<body>
    <div class="menu">
        <ul>
            <li class="profile">
                <div class="img-box">
                <img src="{{ asset('assets/profile.webp') }}" alt="Logo">
                </div>
                <h2>souhail</h2>
            </li>

            <li>
            <a class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="fas fa-home"></i>
                    <p>dashboard</p>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="fas fa-user-group"></i>
                    <p>clients</p>
                </a>
            </li>

            <li>
            <a class="{{ Request::is('admin/products*') ? 'active' : '' }}" href="{{ route('admin/products') }}">
                    <i class="fas fa-table"></i>
                    <p>products</p>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="fas fa-chart-pie"></i>
                    <p>charts</p>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="fas fa-pen"></i>
                    <p>posts</p>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="fas fa-star"></i>
                    <p>favorite</p>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="fas fa-cog"></i>
                    <p>settings</p>
                </a>
            </li>

            <li class="log-out">
                <a href="#">
                    <i class="fas fa-sign-out"></i>
                    <p>log Out</p>
                </a>
            </li>

            <!-- Autres éléments du menu -->
        </ul>
    </div>   

     <!-- Contenu dynamique -->
    <div class="main-content">
        @yield('content')
    </div>
</body>
</html>