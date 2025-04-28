<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <script src="https://kit.fontawesome.com/your-kit-id.js" crossorigin="anonymous"></script>

    <title>@yield("title")</title>
    @stack('styles')

</head>
<body>
    <div class="menu">
        <ul>
            <li class="profile" onclick="window.location='{{ route('profile.edit') }}'" style="cursor:pointer;">
                <div class="img-box">
                    <img src="{{ asset('assets/profile.webp') }}" alt="Logo">
                </div>
                <h2>{{ Auth::user()->name }}</h2>
            </li>



            <li>
                <a class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="fas fa-home"></i>
                    <p>Tableau de bord</p>
                </a>
            </li>

            <li>
            <a class="{{ request()->routeIs('admin/users') ? 'active' : '' }}" href="{{ route('admin/users') }}">
                    <i class="fas fa-user-group"></i>
                    <p>Clients</p>
                </a>
            </li>

            <li>
                <a class="{{ Request::is('admin/products*') ? 'active' : '' }}" href="{{ route('admin/products') }}">
                    <i class="fa-solid fa-box-open"></i>
                    <p>Produits</p>
                </a>
            </li>

            <li>
            <a class="{{ Request::is('admin/income*') ? 'active' : '' }}" href="{{ route('admin/income') }}">
            <i class="fa-solid fa-money-check-dollar"></i>
                    <p>Revenus</p>
                </a>
            </li>

            <li>
            <a class="{{ Request::is('admin/settings*') ? 'active' : '' }}" href="{{ route('admin/settings') }}">
                    <i class="fas fa-cog"></i>
                    <p>Paramètres</p>
                </a>
            </li>

            <li class="log-out">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-button">
                        <i class="fas fa-sign-out"></i>
                        <p>Déconnexion</p>
                    </button>
                </form>
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