@extends('admin.layout')

@section('title', 'Créer un produit')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/products/create_product.css') }}">
@endpush

@section('content')
<div>
    <div class="title-info">
        <p>Créer un produit</p>
        <i class="fa-solid fa-box" style="font-size:20px"></i>
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

        <form action="{{ route('admin.products.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Nom du produit</label>
                <input type="text" name="name" id="name" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" name="description" id="description" placeholder="Optionnelle">
            </div>

            <div class="form-group">
                <label for="price">Prix (€)</label>
                <input type="number" name="price" id="price" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="quantity">Quantité</label>
                <input type="number" name="quantity" id="quantity" required>
            </div>

            <div class="form-group">
                <label for="category">Catégorie</label>
                <select name="category" id="category" required>
                    <option value="male">Homme</option>
                    <option value="female">Femme</option>
                </select>
            </div>

            <div class="form-group">
                <label for="status">Statut</label>
                <select name="status" id="status" required>
                    <option value="available">Disponible</option>
                    <option value="unavailable">Indisponible</option>
                </select>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.products') }}">Annuler</a>
                <button type="submit">Créer</button>
            </div>
        </form>
    </div>
</div>
@endsection
