<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/navbar/navbar.css') }}">
    <script src="https://kit.fontawesome.com/your-kit-id.js" crossorigin="anonymous"></script>

    <title>@yield("title")</title>
    @stack('styles')

</head>
<body>
    <div class="menu">
        <ul>
            <li class="profile" onclick="window.location='{{ route('profile.edit') }}'" style="cursor:pointer;">
                <div class="img-box">
                    <img src="{{ asset('assets/profile.webp') }}" alt="profile">
                </div>
                <h2>{{ Auth::user()->first_name }}</h2>
            </li>

            <li>
                <a class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-home"></i>
                    <p>Centre</p>
                </a>
            </li>

            <li>
            <a class="{{ request()->routeIs('admin.users') ? 'active' : '' }}" href="{{ route('admin.users') }}">
                    <i class="fas fa-user-group"></i>
                    <p>Utilisateurs</p>
                </a>
            </li>

            <li>
                <a class="{{ Request::routeIs('admin.products*') ? 'active' : '' }}" href="{{ route('admin.products') }}">
                    <i class="fa-solid fa-box-open"></i>
                    <p>Produits</p>
                </a>
            </li>


            <li>
                <a class="{{ Request::routeIs('admin.orders*') ? 'active' : '' }}" href="{{ route('admin.orders') }}">
                    <i class="fa-solid fa-list-check"></i>
                    <p>Commandes</p>
                </a>
            </li>

             <li>
                <a class="{{ Request::routeIs('admin.appointment*') ? 'active' : '' }}" href="{{ route('admin.appointment') }}">
                    <i class="fas fa-calendar-check"></i>
                    <p>Réservations</p>
                </a>
            </li>

            <li>
                <a class="{{ Request::routeIs('admin.services*') ? 'active' : '' }}" href="{{ route('admin.services') }}">
                    <i class="fa-solid fa-spa"></i>
                    <p>Services</p>
                </a>
            </li>

            <li>
            <a class="{{ Request::is('admin.income*') ? 'active' : '' }}" href="{{ route('admin.income') }}">
            <i class="fa-solid fa-money-check-dollar"></i>
                    <p>Revenus</p>
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