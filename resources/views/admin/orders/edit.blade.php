@extends('admin.layout')

@section('content')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/orders/edit.css') }}">
@endpush

<div>
    <div class="title-info">
        <p>Modifier les informations de la commande</p>
        <i class="fa-solid fa-cart-edit" style="font-size:20px"></i>
    </div>

    <div class="container">
        @if ($errors->any())    
            <div>
                <strong>Erreurs :</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="user_id">Utilisateur</label>
                <select name="user_id" required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id', $order->user_id) == $user->id ? 'selected' : '' }}>
                            {{ $user->first_name }} {{ $user->last_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="cart_id">Panier</label>
                <input type="text" name="cart_id" value="{{ old('cart_id', $order->cart_id) }}" required>
            </div>

            <div class="form-group">
                <label for="total_amount">Montant total</label>
                <input type="text" name="total_amount" value="{{ old('total_amount', $order->total_amount) }}" required>
            </div>

            <div class="form-group">
                <label for="status">Statut</label>
                <select name="status" required>
                    <option value="paid" {{ old('status', $order->status) == 'paid' ? 'selected' : '' }}>Payée</option>
                    <option value="pending" {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>En attente</option>
                    <option value="canceled" {{ old('status', $order->status) == 'canceled' ? 'selected' : '' }}>Annulée</option>
                </select>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.orders') }}">Annuler</a>
                <button type="submit">Mettre à jour</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
@endpush
