@extends('admin.layout')

@section('title', 'Produits')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/products/products.css') }}">
@endpush

@section('content')
<div class="content">

    @if (session('success'))
        <div id="success-message" style="background-color: #2ecc71; color: white; padding: 10px 20px; border-radius: 5px; margin-bottom: 15px; font-size:20px">
            {!! session('success') !!}
        </div>
    @endif

    <!-- Titre -->
    <div class="title-info">
        <p>Produits</p>
        <i class="fa-solid fa-box" style="font-size:20px"></i>
    </div>

    <!-- Statistiques des produits -->
    <div class="data-info">
        <div class="box">
            <i class="fa-solid fa-boxes-stacked"></i>
            <div class="data">
                <p>Total Produits</p>
                <span>{{ $totalProducts }}</span>
            </div>
        </div>

        <div class="box">
            <i class="fa-solid fa-check-circle"></i>
            <div class="data">
                <p>Produits Disponibles</p>
                <span>{{ $totalAvailable }}</span>
            </div>
        </div>

        <div class="box">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <div class="data">
                <p>Stock Faible</p>
                <span>{{ $lowStock }}</span>
            </div>
        </div>
    </div>

    <!-- Barre de recherche avec le style de users.blade.php -->
    <form method="GET" action="{{ route('admin.products') }}" style="margin-bottom: 5px; display: flex; gap: 10px;">
        <input type="text" name="search" placeholder="🔍 Rechercher par ID, nom, genre, statut..."
            value="{{ request('search') }}"
            style="padding: 10px 15px; width: 300px; border: 1px solid #ccc; border-radius: 8px; font-size: 16px; color: black; outline: none;">
        
        <button type="submit" style="padding: 10px 20px; background-color: #3498db; color: white; border: none; border-radius: 8px; font-size: 16px; cursor: pointer;">
            Rechercher
        </button>

        @if(request('search'))
            <a href="{{ route('admin.products') }}" style="padding: 10px 20px; background-color: #e74c3c; color: white; border-radius: 8px; font-size: 16px; text-decoration: none;">
                Réinitialiser
            </a>
        @endif
    </form>



    <!-- Tableau des produits -->
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Nom</th>
                <th>Catégorie</th>
                <th>Prix(MAD)</th>
                <th>Quantité</th>
                <th>Statut</th>
                <th>Date création</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td><span>{{ $product->name }}</span></td>
                    <td>{{ $product->category === 'male' ? 'Homme' : 'Femme' }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>
                        @if ($product->status === 'available')
                            <span style="color: #20E938;">Disponible</span>
                        @else
                            <span style="color: red;">Indisponible</span>
                        @endif
                    </td>
                    <td>{{ $product->created_at->format('d/m/Y') }}</td>
                    <td class="actions">
                        <a href="{{ route('admin.products.edit', $product->id) }}" title="Modifier">
                            <i class="fas fa-edit fa-lg" style="color:#55DD5E;"></i>
                        </a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Supprimer ce produit ?')" style="background:none; border:none;" title="supprimer">
                                <i class="fas fa-trash-alt fa-lg" style="color:red;"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Aucun produit trouvé.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="display: flex; justify-content: space-between; align-items: center;">
        <!-- Bouton Ajouter un produit -->
        <div style="margin: 20px 0;">
            <a href="{{ route('admin.products.create_product') }}"
               style="padding: 10px 20px; background-color: #27ae60; color: white; border-radius: 8px; text-decoration: none; font-size: 16px;">
                <i class="fa-solid fa-plus"></i> Ajouter un produit 
            </a>
        </div>

        @if ($products->hasPages())
            {{ $products->links('vendor.pagination.custom') }}
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
