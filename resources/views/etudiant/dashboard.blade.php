@extends('layouts.app')

@section('title', 'Tableau de bord Étudiant')

@section('content')
<div class="dashboard-header">
    <h1>Tableau de bord</h1>
    <div class="welcome-message">
        Bonjour {{ Auth::user()->name }}, bienvenue sur votre espace étudiant.
    </div>
</div>

<div class="dashboard-cards">
    <div class="card">
        <div class="card-icon">
            <i class="fas fa-file-alt"></i>
        </div>
        <div class="card-content">
            <h3>Inscriptions</h3>
            <p>Gérez vos inscriptions aux cours</p>
            <a href="{{ route('etudiant.inscriptions.index') }}" class="card-link">Accéder</a>
        </div>
    </div>

    <div class="card">
        <div class="card-icon">
            <i class="fas fa-money-bill-wave"></i>
        </div>
        <div class="card-content">
            <h3>Paiements</h3>
            <p>Consultez et effectuez vos paiements</p>
            <a href="{{ route('etudiant.paiements.index') }}" class="card-link">Accéder</a>
        </div>
    </div>

    <!-- Nouvelle carte Profil -->
    <div class="card">
        <div class="card-icon">
            <i class="fas fa-user-cog"></i>
        </div>
        <div class="card-content">
            <h3>Mon Profil</h3>
            <p>Modifiez vos informations personnelles et de connexion</p>
            <a href="{{ route('etudiant.profil.edit') }}" class="card-link">Modifier</a>
        </div>
    </div>
</div>

<div class="notifications">
    <h3>Notifications récentes</h3>
    <ul>
        <li>Votre inscription pour le semestre 2023-2024 a été validée</li>
        <li>Paiement reçu pour les frais de scolarité</li>
    </ul>
</div>
@endsection
