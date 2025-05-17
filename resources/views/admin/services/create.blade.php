@extends('admin.layout')

@section('title', 'Créer un Service')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/services/edit.css') }}">
@endpush

@section('content')
<div>
    <div class="title-info">
        <p>Créer un service</p>
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

        <form action="{{ route('admin.services.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Nom du service</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" required>{{ old('description') }}</textarea>
                @error('description')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="category">Catégorie</label>
                <select id="category" name="category" required>
                    <option value="">Sélectionnez une catégorie</option>
                    <option value="Homme" {{ old('category') == 'Homme' ? 'selected' : '' }}>Homme</option>
                    <option value="Femme" {{ old('category') == 'Femme' ? 'selected' : '' }}>Femme</option>
                </select>
                @error('category')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="price">Prix (MAD)</label>
                <input type="number" id="price" name="price" value="{{ old('price') }}" min="0" step="0.01" required>
                @error('price')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="duration">Durée (minutes)</label>
                <input type="number" id="duration" name="duration" value="{{ old('duration') }}" min="1" required>
                @error('duration')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.services') }}">Annuler</a>
                <button type="submit">Créer</button>
            </div>
        </form>
    </div>
</div>
@endsection 