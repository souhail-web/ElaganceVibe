@extends('admin.layout')
@section('content')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/products/edit.css') }}">
@endpush

<div>
    <div class="title-info">
        <p>Modifier les informations du produit</p>
        <i class="fa-solid fa-pen-to-square" style="font-size:20px"></i>
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

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div>
                <label for="name">Nom du produit</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" required>
            </div>

            <div>
                <label for="description">Description</label>
                <textarea name="description" required>{{ old('description', $product->description) }}</textarea>
            </div>

            <div>
                <label for="price">Prix</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" required>
            </div>

            <div>
                <label for="quantity">Quantité</label>
                <input type="number" name="quantity" value="{{ old('quantity', $product->quantity) }}" required>
            </div>

            <div>
                <label for="category">Catégorie</label>
                <select name="category" required>
                    <option value="male" {{ old('category', $product->category) === 'male' ? 'selected' : '' }}>Homme</option>
                    <option value="female" {{ old('category', $product->category) === 'female' ? 'selected' : '' }}>Femme</option>
                </select>
            </div>


            <div>
                <label for="status">Statut</label>
                <select name="status" required>
                    <option value="available" {{ old('status', $product->status) === 'available' ? 'selected' : '' }}>Disponible</option>
                    <option value="unavailable" {{ old('status', $product->status) === 'unavailable' ? 'selected' : '' }}>Indisponible</option>
                </select>
            </div>

            <div class="form-actions" style="margin-top: 20px;">
                <a href="{{ route('admin.products') }}">Annuler</a>
                <button type="submit">Mettre à jour</button>
            </div>

        </form>
    </div>
</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
@endpush
