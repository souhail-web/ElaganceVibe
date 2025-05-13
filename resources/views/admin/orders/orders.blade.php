@extends('admin.layout')

@section('title', 'Commandes')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/orders/orders.css') }}">
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
        <p>Commandes</p>
        <i class="fa-solid fa-clipboard-list" style="font-size:20px"></i>
    </div>

    

    <!-- Statistiques des commandes -->
    <div class="data-info">
        <div class="box">
            <i class="fa-solid fa-list-check"></i>
            <div class="data">
                <p>Total Commandes</p>
                <span>{{ $totalOrders }}</span>
            </div>
        </div>
        <div class="box">
            <i class="fa-solid fa-circle-check"></i>
            <div class="data">
                <p>Commandes Payées</p>
                <span>{{ $paidOrders }}</span>
            </div>
        </div>
        <div class="box">
            <i class="fa-solid fa-clock"></i>
            <div class="data">
                <p>En Attente</p>
                <span>{{ $pendingOrders }}</span>
            </div>
        </div>
    </div>
    <br>
        <!-- Formulaire de recherche -->
    <form method="GET" action="{{ route('admin.orders') }}" style="margin-bottom: 15px; display: flex; gap: 10px;">
        <input type="text" name="search" placeholder="🔍 Rechercher par ID de commande ou nom, prénom, email ..."
               value="{{ request('search') }}"
               style="padding: 10px 15px; width: 300px; border: 1px solid #ccc; border-radius: 8px; font-size: 16px; color:black; outline: none;">
        <button type="submit" style="padding: 10px 20px; background-color: #3498db; color: white; border: none; border-radius: 8px; font-size: 16px; cursor: pointer;">
            Rechercher
        </button>
        @if(request('search'))
            <a href="{{ route('admin.orders') }}" style="padding: 10px 20px; background-color: #e74c3c; color: white; border-radius: 8px; font-size: 16px; text-decoration: none;">
                Réinitialiser
            </a>
        @endif
    </form>

    <!-- Tableau des commandes -->
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Utilisateur</th>
                <th>Panier</th>
                <th>Total (€)</th>
                <th>Statut</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->first_name ?? 'N/A' }} {{ $order->user->last_name ?? 'N/A' }}</td>
                    <td>#{{ $order->cart_id }}</td>
                    <td>{{ $order->total_amount }} €</td>
                    <td>
                        @if ($order->status === 'paid')
                            <span style="color: #20E938;">Payée</span>
                        @elseif($order->status === 'pending')
                            <span style="color: orange;">En attente</span>
                        @else
                            <span style="color: red;">Annulée</span>
                        @endif
                    </td>
                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                    <td class="actions">
                        <!-- Lien de modification -->
                        <a href="{{ route('admin.orders.edit', $order->id) }}" title="Modifier" >
                            <i class="fas fa-edit fa-lg" style="color:#55DD5E;"></i>
                        </a>

                        <!-- Bouton de suppression -->
                        <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Supprimer cette commande ?')" style="background:none; border:none;" title="Supprimer">
                                <i class="fas fa-trash-alt fa-lg" style="color:red;"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Aucune commande trouvée.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    @if ($orders->hasPages())
        {{ $orders->links('vendor.pagination.custom') }}
    @endif

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
