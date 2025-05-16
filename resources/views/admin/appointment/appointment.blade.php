@extends('admin.layout')

@section('title', 'Rendez-vous')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/appointment/appointment.css') }}">
@endpush

@section('content')
    <div class="content">

        @if (session('success'))
            <div id="success-message" style="background-color: #2ecc71; color: white; padding: 10px 20px; border-radius: 5px; margin-bottom: 15px; font-size:20px">
                {!! session('success') !!}
            </div>
        @endif

        <div class="title-info">
            <p>Rendez-vous</p>
            <i class="fa-solid fa-calendar-check" style="font-size:20px"></i>
        </div>

        <div class="data-info"> 
            <div class="box">
                <i class="fas fa-calendar"></i>
                <div class="data">
                    <p>Total</p>
                    <span>{{ $total }}</span>
                </div>
            </div>

            <div class="box">
                <i class="fas fa-check-circle"></i>
                <div class="data">
                    <p>Confirmés</p>
                    <span>{{ $confirmedCount }}</span>
                </div>
            </div>

            <div class="box">
                <i class="fas fa-times-circle"></i>
                <div class="data">
                    <p>Annulés</p>
                    <span>{{ $cancelledCount }}</span>
                </div>
            </div>

            <div class="box">
                <i class="fas fa-hourglass-half"></i>
                <div class="data">
                    <p>En attente</p>
                    <span>{{ $pendingCount }}</span>
                </div>
            </div>
        </div>


        <form method="GET" action="{{ route('admin.appointment') }}" style="margin: 10px 0; display: flex; gap: 10px;">
            <input type="text" name="search" placeholder="🔍 Nom, Email, Service ..."
                value="{{ request('search') }}"
                style="padding: 10px 15px; width: 300px; border: 1px solid #ccc; border-radius: 8px; font-size: 16px; color:black; outline: none;">

            <button type="submit" style="padding: 10px 20px; background-color: #3498db; color: white; border: none; border-radius: 8px; font-size: 16px; cursor: pointer;">
                Rechercher
            </button>

            @if(request('search'))
                <a href="{{ route('admin.appointment') }}" style="padding: 10px 20px; background-color: #e74c3c; color: white; border-radius: 8px; font-size: 16px; text-decoration: none;">
                    Réinitialiser
                </a>
            @endif
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Client</th>
                    <th>Employé</th>
                    <th>Service</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            @if($appointments->count() > 0)
                <tbody>
                    @foreach($appointments as $apt)
                        <tr>
                            <td>{{ $apt->id }}</td>
                            <td>{{ $apt->date }}</td>
                            <td>{{ $apt->time }}</td>
                            <td>{{ $apt->client->first_name }} {{ $apt->client->last_name }}</td>
                            <td>{{ $apt->employee->first_name }} {{ $apt->employee->last_name }}</td>
                            <td>{{ $apt->service->name }}</td>
                            <td>
                                @if($apt->status === 'confirmed')
                                    <span class="status-confirmed">Confirmé</span>
                                @elseif($apt->status === 'pending')
                                    <span class="status-pending">En attente</span>
                                @else
                                    <span class="status-cancelled">Annulé</span>
                                @endif
                            </td>

                            <td class="actions">
                                <a href="{{ route('admin.appointment.edit', $apt->id) }}">
                                    <i class="fas fa-edit fa-lg" style="color:#55DD5E;"></i>
                                </a>
                                <form action="{{ route('admin.appointment.destroy', $apt->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Supprimer ce rendez-vous ?')" style="background:none; border:none;">
                                        <i class="fas fa-trash-alt fa-lg" style="color:red;"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            @else
                <tr><td colspan="8">Aucun rendez-vous trouvé.</td></tr>
            @endif
        </table>

        @if ($appointments->hasPages())
            {{ $appointments->links('vendor.pagination.custom') }}
        @endif
    </div>
@endsection

<script>
    setTimeout(() => {
        const msg = document.getElementById('success-message');
        if (msg) {
            msg.style.transition = "opacity 0.5s";
            msg.style.opacity = 0;
            setTimeout(() => msg.remove(), 500);
        }
    }, 5000);
</script>
