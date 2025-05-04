@extends('admin.layout')

@section('title', 'Utilisateurs')

@push('styles')
    
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

@section('content')
    <div class="content">
        
    @if (session('success'))
        <div id="success-message" style="background-color: #2ecc71; color: white; padding: 10px 20px; border-radius: 5px; margin-bottom: 15px; font-size:20px">
            {!! session('success') !!}
        </div>
    @endif


        <div class="title-info">
            <p>Utilisateurs</p>
            <i class="fa-solid fa-users" style="font-size:20px"></i>
        </div>

        <div class="data-info"> 

            <div class="box">
                <i class="fas fa-user"></i>
                <div class="data">
                    <p>Clients</p>
                    <span>{{$clientCount}}</span>
                </div>
            </div>

            <div class="box">
            <i class="fa-solid fa-user-tie"></i>
                <div class="data">
                    <p>Employés</p>
                    <span>{{$employeCount}}</span>
                </div>
            </div>

            <div class="box">
            <i class="fa-solid fa-user-plus"></i>
                <div class="data">
                    <p>Inscrits ce mois-ci</p>
                    <span>{{$clientsThisMonth}}</span>
                </div>
            </div>
        </div>

        <div class="title-info">
            <p> Clients</p>
            <i class="fa-solid fa-handshake" style="font-size:20px"></i>
        </div>

        <form method="GET" action="{{ route('admin.users') }}" style="margin-bottom: 5px; display: flex; gap: 10px; align-items: center;">
            <input type="text" name="search" placeholder="🔍 Rechercher par email, nom ..." value="{{ request('search') }}"
                style="padding: 10px 15px; width: 300px; border: 1px solid #ccc; border-radius: 8px; font-size: 16px; color:black; outline: none;   ">
            
            <button type="submit" style="padding: 10px 20px; background-color: #3498db; color: white; border: none; border-radius: 8px; font-size: 16px; cursor: pointer;">
                Rechercher
            </button>

            @if(request('search'))
                <a href="{{ route('admin.users') }}" style="padding: 10px 20px; background-color: #e74c3c; color: white; border-radius: 8px; font-size: 16px; text-decoration: none;">
                    Réinitialiser
                </a>
            @endif
        </form>


        <table>

            <thead>
                <tr>
                    <th>Id</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Telephone</th>
                    <th>Modifier</th>
                    <th>Supprimer</th>
                </tr>
            </thead>
        @if(count($clients)>0)
            <tbody>
                @foreach($clients as $client)
                    <tr>
                        <td>{{$client['id']}}</td>
                        <td><span>{{$client['first_name']}}</span></td>
                        <td><span>{{$client['last_name']}}</span></td>
                        <td><span>{{$client['email']}}</span></td> 
                        <td>{{$client['phone']}}</td>
                        
                        <!-- Colonne Modifier -->
                        <td title="Modifier">
                            <a href="{{ route('admin.users.edit', $client->id) }}"  style="color:#ffc107;">
                                <i class="fas fa-edit fa-lg" style="color:#55DD5E"></i>
                            </a>
                        </td>

                        <!-- Colonne Supprimer -->
                        <td title="Supprimer">
                            <form action="{{ route('admin.users.destroy', $client->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Supprimer cet utilisateur ?')" style="background:none; border:none; color:#dc3545; cursor:pointer" >
                                    <i class="fas fa-trash-alt fa-lg" style="color:red;font-size:22px"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
        @else
                <tr>
                    <td colspan="7" class="text-center">Aucun utilisateur trouvé.</td>
                </tr>
            </tbody>
        @endif
        </table>

        @if ($clients->hasPages())
                {{ $clients->links('vendor.pagination.custom') }}
        @endif

        <!-- Tableau des Employés -->
        <div class="title-info">
            <p> Employés</p>
            <i class="fa-solid fa-user-tie" style="font-size:20px"></i>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Telephone</th>
                    <th>Modifier</th>
                    <th>Supprimer</th>
                </tr>
            </thead>
            @if(count($employees)>0)
            <tbody>
                @foreach($employees as $employee)
                    <tr>
                        <td>{{$employee['id']}}</td>
                        <td><span>{{$employee['first_name']}}</span></td>
                        <td><span>{{$employee['last_name']}}</span></td>
                        <td><span>{{$employee['email']}}</span></td> 
                        <td>{{$employee['phone']}}</td>
                        
                        <!-- Colonne Modifier -->
                        <td title="Modifier">
                            <a href="{{ route('admin.users.edit', $employee->id) }}"  style="color:#ffc107;">
                                <i class="fas fa-edit fa-lg" style="color:#55DD5E"></i>
                            </a>
                        </td>

                        <!-- Colonne Supprimer -->
                        <td title="Supprimer">
                            <form action="{{ route('admin.users.destroy', $employee->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Supprimer cet utilisateur ?')" style="background:none; border:none; color:#dc3545; cursor:pointer" >
                                    <i class="fas fa-trash-alt fa-lg" style="color:red;font-size:22px"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            @else
                <tr>
                    <td colspan="7" class="text-center">Aucun employé trouvé.</td>
                </tr>
            @endif
        </table>

        <!-- Pagination des Employés -->
        @if ($employees->hasPages())
            {{ $employees->links('vendor.pagination.custom') }}
        @endif


        
    </div>  
@endsection

<script>
    setTimeout(function () {
        const msg = document.getElementById('success-message');
        if (msg) {
            msg.style.transition = "opacity 0.5s ease";
            msg.style.opacity = 0;
            setTimeout(() => msg.remove(), 500); // retire complètement l'élément après fondu
        }
    }, 5000); // 5000 ms = 5 secondes
</script>
