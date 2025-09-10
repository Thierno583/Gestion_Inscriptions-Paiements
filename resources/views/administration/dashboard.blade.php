@extends('layouts.app')

@section('title', 'Tableau de bord Admin')

@section('content')
<div class="dashboard-header">
    <h1>Tableau de bord Administrateur</h1>
    <div class="welcome-message">
        Bonjour {{ Auth::user()->name }}, voici les statistiques de gestion.
    </div>
</div>

<div class="dashboard-cards">
    <div class="card">
        <div class="card-icon">
            <i class="fas fa-users"></i>
        </div>
        <div class="card-content">
            <h3>Utilisateurs</h3>
            <p>Total des comptes utilisateurs</p>
            <span class="card-value">{{ $usersCount ?? 0 }}</span>
        </div>
    </div>

    <div class="card">
        <div class="card-icon">
            <i class="fas fa-user-graduate"></i>
        </div>
        <div class="card-content">
            <h3>Étudiants</h3>
            <p>Total des étudiants enregistrés</p>
            <span class="card-value">{{ $etudiantsCount ?? 0 }}</span>
        </div>
    </div>

    <div class="card">
        <div class="card-icon">
            <i class="fas fa-file-signature"></i>
        </div>
        <div class="card-content">
            <h3>Inscriptions en attente</h3>
            <p>À valider</p>
            <span class="card-value">{{ $inscriptionsCount ?? 0 }}</span>
        </div>
    </div>
</div>

<div class="dashboard-cards">
    <div class="card">
        <div class="card-icon">
            <i class="fas fa-user-plus"></i>
        </div>
        <div class="card-content">
            <h3>Ajouter utilisateur</h3>
            <p>Créer un nouveau compte</p>
            <a href="{{ route('administration.utilisateurs.index') }}" class="card-link">Accéder</a>
        </div>
    </div>

    <div class="card">
        <div class="card-icon">
            <i class="fas fa-book"></i>
        </div>
        <div class="card-content">
            <h3>Créer une classe</h3>
            <p>Ajouter une nouvelle classe</p>
            <a href="{{ route('administration.classes.index') }}" class="card-link">Accéder</a>
        </div>
    </div>

    <div class="card">
        <div class="card-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="card-content">
            <h3>Valider inscriptions</h3>
            <p>Gérer les inscriptions</p>
            <a href="{{ route('administration.inscriptions.index') }}" class="card-link">Accéder</a>
        </div>
    </div>
</div>

<div class="notifications">
    <h3>Activité récente</h3>
    @php
        $activities = collect($recentActivities ?? []);
    @endphp

    @if($activities->isEmpty())
        <ul>
            <li>Aucune activité récente.</li>
        </ul>
    @else
        <ul>
            @foreach($activities as $activity)
                <li>
                    <strong>{{ $activity->description ?? 'Pas de description' }}</strong><br>
                    <small>
                        {{ isset($activity->created_at) && method_exists($activity->created_at, 'diffForHumans')
                            ? $activity->created_at->diffForHumans()
                            : '' }}
                    </small>
                </li>
            @endforeach
        </ul>
    @endif
</div>

@endsection
