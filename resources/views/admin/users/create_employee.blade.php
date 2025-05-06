@extends('admin.layout')

@section('title', 'Créer un employé')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
@endpush

@section('content')
<div>
    <div class="title-info">
        <p>Créer un compte employé</p>
        <i class="fa-solid fa-user-plus" style="font-size:20px"></i>
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

        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div>
                <label for="first_name">Prénom</label>
                <input type="text" name="first_name" id="first_name" required>
            </div>

            <div>
                <label for="last_name">Nom</label>
                <input type="text" name="last_name" id="last_name" required>
            </div>

            <div>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
            </div>

            <div>
                <label for="phone">Téléphone</label>
                <input type="text" name="phone" id="phone" required>
            </div>

            <div>
                <label for="gender">Sexe</label>
                <select name="gender" id="gender" required>
                    <option value="male">Homme</option>
                    <option value="female">Femme</option>
                </select>
            </div>

            <input type="hidden" name="usertype" value="employee">

            <div>
                <label for="specialty">Spécialité</label>
                <input type="text" name="specialty" id="specialty" placeholder="Coiffure, Massage, etc.">
            </div>

            <div>
                <label for="availability">Disponibilité</label>
                <input type="text" name="availability" id="availability" placeholder="Ex : Lun-Ven 9h-17h">
            </div>

            <div>
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" required>
            </div>

            <div>
                <label for="password_confirmation">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required>
            </div>

            <div>
                <a href="{{ route('admin.users') }}">Annuler</a>
                <button type="submit">Créer</button>
            </div>
        </form>
    </div>
</div>
@endsection
