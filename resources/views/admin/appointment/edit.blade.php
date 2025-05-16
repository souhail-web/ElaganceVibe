@extends('admin.layout')

@section('title', 'Modifier le rendez-vous')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/appointment/edit.css') }}">
@endpush

@section('content')
<div>
    <div class="title-info">
        <p>Modifier les informations du rendez-vous</p>
        <i class="fa-solid fa-calendar-pen" style="font-size:20px"></i>
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

        <form action="{{ route('admin.appointment.update', $appointment->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" name="date" value="{{ old('date', $appointment->date) }}" required>
            </div>

            <div class="form-group">
                <label for="time">Heure</label>
                <input type="time" name="time" value="{{ old('time', $appointment->time) }}" required>
            </div>

            <div class="form-group">
                <label for="client_id">Client</label>
                <select name="client_id" required>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ old('client_id', $appointment->client_id) == $client->id ? 'selected' : '' }}>
                            {{ $client->first_name }} {{ $client->last_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="employee_id">Employé</label>
                <select name="employee_id" required>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}" {{ old('employee_id', $appointment->employee_id) == $employee->id ? 'selected' : '' }}>
                            {{ $employee->first_name }} {{ $employee->last_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="service_id">Service</label>
                <select name="service_id" required>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" {{ old('service_id', $appointment->service_id) == $service->id ? 'selected' : '' }}>
                            {{ $service->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="status">Statut</label>
                <select name="status" required>
                    <option value="confirmed" {{ old('status', $appointment->status) == 'confirmed' ? 'selected' : '' }}>Confirmé</option>
                    <option value="pending" {{ old('status', $appointment->status) == 'pending' ? 'selected' : '' }}>En attente</option>
                    <option value="cancelled" {{ old('status', $appointment->status) == 'cancelled' ? 'selected' : '' }}>Annulé</option>
                </select>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.appointment') }}">Annuler</a>
                <button type="submit">Mettre à jour</button>
            </div>
        </form>
    </div>
</div>
@endsection