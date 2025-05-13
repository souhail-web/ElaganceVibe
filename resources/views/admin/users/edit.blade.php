@extends('admin.layout')
@section('content')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/users/edit.css') }}">
@endpush
<div>
    <div class="title-info">
        <p>Modifier les informations de l'utilisateur</p>
        <i class="fa-solid fa-user-pen" style="font-size:20px"></i>
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

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="first_name">Prénom</label>
                <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" required>
            </div>

            <div class="form-group">
                <label for="last_name">Nom</label>
                <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="form-group">
                <label for="phone">Téléphone</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required>
            </div>

            <div class="form-group">
                <label for="gender">Sexe</label>
                <select name="gender" required>
                    <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Homme</option>
                    <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Femme</option>
                </select>
            </div>

            <div class="form-group">
                <label for="usertype">Type d'utilisateur</label>
                <select name="usertype" required>
                    <option value="client" {{ old('usertype', $user->usertype) == 'client' ? 'selected' : '' }}>Client</option>
                    <option value="employee" {{ old('usertype', $user->usertype) == 'employee' ? 'selected' : '' }}>Employé</option>
                </select>
            </div>

            <div id="employee-fields" style="{{ $user->usertype === 'employee' ? '' : 'display: none;' }}">
                <div class="form-group">
                    <label for="specialty">Spécialité</label>
                    <input type="text" name="specialty" value="{{ old('specialty', $user->specialty) }}">
                </div>

                <div class="form-group">
                    <label for="availability">Disponibilité</label>
                    <input type="text" name="availability" value="{{ old('availability', $user->availability) }}">
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.users') }}">Annuler</a>
                <button type="submit">Mettre à jour</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
@endpush
