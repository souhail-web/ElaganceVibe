@extends('admin.layout')

@section('title', 'Dashboard')

@push('styles')
    
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

@section('content')
    <div class="content">
        <div class="title-info">
            <p>Tableau de bord</p>
            <i class="fas fa-chart-bar" style="font-size:20px"></i>
        </div>

        <div class="data-info"> 

            <div class="box">
                <i class="fas fa-user"></i>
                <div class="data">
                    <p>Utilisateurs</p>
                    <span>{{$userCount}}</span>
                </div>
            </div>

            <div class="box">
            <i class="fa-solid fa-bottle-droplet"></i>
                <div class="data">
                    <p>Produit</p>
                    <span>{{$productCount}}</span>
                </div>
            </div>

            <div class="box">
            <i class="fa-solid fa-spa"></i>
                <div class="data">
                    <p>Service</p>
                    <span>{{$serviceCount}}</span>
                </div>
            </div>

            <div class="box">
            <i class="fa-solid fa-dollar-sign"></i>
                <div class="data">
                    <p>Revenus</p>
                    <span>10000</span>
                </div>
            </div>
        </div>

        <div class="title-info">
            <p>Rendez-vous du jour</p>
            <i class="fa-solid fa-calendar-check" style="font-size:20px"></i>
        </div>

        <!-- Formulaire de recherche -->
        <form method="GET" action="{{ route('admin.dashboard') }}" style="margin-bottom: 5px; display: flex; gap: 10px;">
            <input type="text" name="search" placeholder="🔍 Rechercher par ID, nom du client/employé, statut..."
                value="{{ request('search') }}"
                style="padding: 10px 15px; width: 300px; border: 1px solid #ccc; border-radius: 8px; font-size: 16px; color: black; outline: none;">
            
            <button type="submit" style="padding: 10px 20px; background-color: #3498db; color: white; border: none; border-radius: 8px; font-size: 16px;">
                Rechercher
            </button>

            @if(request('search'))
                <a href="{{ route('admin.dashboard') }}" style="padding: 10px 20px; background-color: #e74c3c; color: white; border-radius: 8px; font-size: 16px; text-decoration: none;">
                    Réinitialiser
                </a>
            @endif
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date & Heure</th>
                    <th>Client</th>
                    <th>Employé</th>
                    <th>Service</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->id }}</td>
                        <td>{{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }} à {{ $appointment->time }}</td>
                        <td>{{ $appointment->client->first_name }} {{ $appointment->client->last_name }}</td>
                        <td>{{ $appointment->employee->first_name }} {{ $appointment->employee->last_name }}</td>
                        <td>{{ $appointment->service->name }}</td>
                        <td>
                            @if($appointment->status === 'confirmed')
                                <span style="color: #20E938;">Confirmé</span>
                            @elseif($appointment->status === 'pending')
                                <span style="color: #FFA500;">En attente</span>
                            @else
                                <span style="color: red;">Annulé</span>
                            @endif
                        </td>
                        <td class="actions">
                            <a href="{{ route('admin.appointment.edit', $appointment->id) }}" title="Modifier">
                                <i class="fas fa-edit fa-lg" style="color:#55DD5E;"></i>
                            </a>
                            <form action="{{ route('admin.appointment.destroy', $appointment->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce rendez-vous ?')" style="background:none; border:none; cursor:pointer;" title="Supprimer">
                                    <i class="fas fa-trash-alt fa-lg" style="color:red;"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Aucun rendez-vous aujourd'hui</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if ($appointments->hasPages())
            {{ $appointments->links('vendor.pagination.custom') }}
        @endif
    </div>  
@endsection