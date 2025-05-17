@extends('admin.layout')

@section('title', 'Modifier un Service')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/services/edit.css') }}">
@endpush

@section('content')
<div>
    <div class="title-info">
        <p>Modifier les informations du service</p>
        <i class="fa-solid fa-scissors" style="font-size:20px"></i>
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

        <form action="{{ route('admin.services.update', $service) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nom du service</label>
                <input type="text" id="name" name="name" value="{{ old('name', $service->name) }}" required>
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" required>{{ old('description', $service->description) }}</textarea>
                @error('description')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="category">Catégorie</label>
                <select id="category" name="category" required>
                    <option value="">Sélectionnez une catégorie</option>
                    <option value="Homme" {{ old('category', $service->category) == 'Homme' ? 'selected' : '' }}>Homme</option>
                    <option value="Femme" {{ old('category', $service->category) == 'Femme' ? 'selected' : '' }}>Femme</option>
                </select>
                @error('category')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="price">Prix (MAD)</label>
                <input type="number" id="price" name="price" value="{{ old('price', $service->price) }}" min="0" step="0.01" required>
                @error('price')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="duration">Durée (minutes)</label>
                <input type="number" id="duration" name="duration" value="{{ old('duration', $service->duration) }}" min="1" required>
                @error('duration')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.services') }}">Annuler</a>
                <button type="submit">Mettre à jour</button>
            </div>
        </form>
    </div>
</div>
@endsection 