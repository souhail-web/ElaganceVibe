@extends('admin.layout')

@section('title', 'Services')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/services/services.css') }}">
@endpush

@section('content')
<div class="content">

    @if (session('success'))
        <div id="success-message" style="background-color: #2ecc71; color: white; padding: 10px 20px; border-radius: 5px; margin-bottom: 15px; font-size:20px">
            {!! session('success') !!}
        </div>
    @endif

    @if (session('error'))
        <div id="error-message" style="background-color: #e74c3c; color: white; padding: 10px 20px; border-radius: 5px; margin-bottom: 15px; font-size:20px">
            {!! session('error') !!}
        </div>
    @endif

    <!-- Titre -->
    <div class="title-info">
        <p>Services</p>
        <i class="fa-solid fa-scissors" style="font-size:20px"></i>
    </div>

    <!-- Statistiques des services -->
    <div class="data-info">
        <div class="box">
            <i class="fa-solid fa-list"></i>
            <div class="data">
                <p>Total Services</p>
                <span>{{ $totalServices }}</span>
            </div>
        </div>

        <div class="box">
            <i class="fa-solid fa-clock"></i>
            <div class="data">
                <p>Durée Moyenne</p>
                <span>{{ $services->avg('duration') ?? 0 }} min</span>
            </div>
        </div>

        <div class="box">
            <i class="fa-solid fa-star"></i>
            <div class="data">
                <p>Service le plus demandé</p>
                <span>{{ $mostRequestedService ? $mostRequestedService->name : 'Aucun' }}</span>
            </div>
        </div>
    </div>

    <!-- Formulaire de recherche -->
    <form method="GET" action="{{ route('admin.services') }}" style="margin-bottom: 5px; display: flex; gap: 10px;">
        <input type="text" name="search" placeholder="🔍 Rechercher par ID ou nom"
               value="{{ request('search') }}"
               style="padding: 10px 15px; width: 300px; border: 1px solid #ccc; border-radius: 8px; font-size: 16px; color: black; outline: none;">
        
        <button type="submit" style="padding: 10px 20px; background-color: #3498db; color: white; border: none; border-radius: 8px; font-size: 16px; cursor: pointer;">
            Rechercher
        </button>

        @if(request('search'))
            <a href="{{ route('admin.services') }}" style="padding: 10px 20px; background-color: #e74c3c; color: white; border-radius: 8px; font-size: 16px; text-decoration: none;">
                Réinitialiser
            </a>
        @endif
    </form>


    <!-- Tableau des services -->
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Nom</th>
                <th>Description</th>
                <th>Catégorie</th>
                <th>Prix(MAD)</th>
                <th>Durée</th>
                <th>Date création</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($services as $service)
                <tr>
                    <td>{{ $service->id }}</td>
                    <td><span>{{ $service->name }}</span></td>
                    <td>{{ $service->description }}</td>
                    <td>{{ $service->category }}</td>
                    <td>{{ $service->price }}</td>
                    <td>{{ $service->duration }} min</td>
                    <td>{{ $service->created_at ? $service->created_at->format('d/m/Y') : 'N/A' }}</td>
                    <td class="actions">
                        <a href="{{ route('admin.services.edit', $service) }}" title="Modifier">
                            <i class="fas fa-edit fa-lg" style="color:#55DD5E;"></i>
                        </a>
                        <form action="{{ route('admin.services.destroy', $service) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Supprimer ce service ?')" style="background:none; border:none;" title="Supprimer">
                                <i class="fas fa-trash-alt fa-lg" style="color:red;"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Aucun service trouvé.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="display: flex; justify-content: space-between; align-items: center;">
        <!-- Bouton Ajouter un service -->
        <div style="margin: 20px 0;">
            <a href="{{ route('admin.services.create') }}"
               style="padding: 10px 20px; background-color: #27ae60; color: white; border-radius: 8px; text-decoration: none; font-size: 16px;">
                <i class="fa-solid fa-plus"></i> Ajouter un service
            </a>
        </div>

        @if ($services->hasPages())
            {{ $services->links('vendor.pagination.custom') }}
        @endif
    </div>

</div>
@endsection

<script>
    setTimeout(function () {
        const msg = document.getElementById('success-message');
        if (msg) {
            msg.style.transition = "opacity 0.5s ease";
            msg.style.opacity = 0;
            setTimeout(() => msg.remove(), 500);
        }
    }, 5000);
</script>
