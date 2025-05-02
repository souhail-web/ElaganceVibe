@extends('admin.layout')
@section('content')

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

        <div>
            <label for="first_name">Prénom</label>
            <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" required>
        </div>

        <div>
            <label for="last_name">Nom</label>
            <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>
        </div>

        <div>
            <label for="email">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>

        <div>
            <label for="phone">Téléphone</label>
            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required>
        </div>

        <div>
            <label for="gender">Sexe</label>
            <select name="gender" required>
                <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Homme</option>
                <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Femme</option>
            </select>
        </div>



        <div>
            <label for="usertype">Type d'utilisateur</label>
            <select name="usertype" required>
                <option value="client" {{ old('usertype', $user->usertype) == 'client' ? 'selected' : '' }}>Client</option>
                <option value="employee" {{ old('usertype', $user->usertype) == 'employee' ? 'selected' : '' }}>Employé</option>
            </select>
        </div>

        <div>
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