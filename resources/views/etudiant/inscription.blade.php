@extends('layouts.app')

@section('title', 'Mes Inscriptions')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/inscriptions.css') }}">
@endpush

@section('content')
<div class="page-header">
    <h1>Mes Inscriptions</h1>
    <div class="breadcrumb">
        <a href="{{ route('etudiant.dashboard') }}">Tableau de bord</a> &raquo; Inscriptions
    </div>
</div>

{{-- Historique des inscriptions --}}
@if($inscriptions->count() > 0)
    <table class="inscriptions-table" aria-label="Liste des inscriptions">
        <thead>
            <tr>
                <th>Classe</th>
                <th>Description</th>
                <th>Statut</th>
                <th>Date d'inscription</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inscriptions as $inscription)
                <tr>
                    <td>{{ $inscription->classe->libelle ?? 'N/A' }}</td>
                    <td>{{ Str::limit($inscription->classe->description ?? 'Non disponible', 50) }}</td>
                    <td>
                        <span class="status-badge status-{{ strtolower(str_replace(' ', '_', $inscription->statut)) }}">
                            @switch($inscription->statut)
                                @case('validée')
                                    <i class="fas fa-check-circle" aria-hidden="true"></i> Validée
                                    @break
                                @case('en_attente')
                                    <i class="fas fa-clock" aria-hidden="true"></i> En attente
                                    @break
                                @case('rejetée')
                                    <i class="fas fa-times-circle" aria-hidden="true"></i> Rejetée
                                    @break
                                @default
                                    {{ ucfirst($inscription->statut) }}
                            @endswitch
                        </span>
                    </td>
                    <td>{{ $inscription->created_at->format('d/m/Y') }}</td>
                    <td>
                        @if($inscription->statut === 'validée')
                            <a href="{{ route('etudiant.paiements.index', ['motif' => 'inscription', 'inscription_id' => $inscription->id]) }}" class="btn-paiement" title="Effectuer le paiement de cette inscription">
                                <i class="fas fa-credit-card" aria-hidden="true"></i> Payer
                            </a>
                        @else
                            <span class="no-action-text">Aucune action</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <div class="empty-state">
        <i class="fas fa-graduation-cap empty-icon"></i>
        <h4>Aucune inscription trouvée</h4>
        <p>Vous n'êtes inscrit(e) à aucune classe pour le moment.</p>
        <p>Contactez l'administration pour plus d'informations.</p>
    </div>
@endif

{{-- Formulaire de nouvelle inscription --}}
@if($autoriseNouvelleInscription)
    <div class="new-inscription-form">
        <h2>Nouvelle inscription</h2>
        <form method="POST" action="{{ route('etudiant.inscriptions.store') }}">
            @csrf
            <div class="form-group">
                <label for="classe_id">Choisissez la classe</label>
                <select id="classe_id" name="classe_id" required>
                    <option value="">-- Sélectionnez une classe --</option>
                    @foreach($classesDisponibles as $classe)
                        <option value="{{ $classe->id }}">{{ $classe->libelle }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane"></i> Envoyer la demande d'inscription
            </button>
        </form>
    </div>
@else
    <div class="info-message">
        <p>Vous ne pouvez pas faire de nouvelle inscription pour le moment. Veuillez attendre la validation de l'administration.</p>
    </div>
@endif

{{-- Contact administration --}}
<div class="contact-info">
    <h4><i class="fas fa-phone"></i> Contact Administration</h4>
    <div class="contact-details">
        <p><strong>Bureau des inscriptions :</strong> +221 33 XXX XX XX</p>
        <p><strong>Email :</strong> inscriptions@votre-etablissement.sn</p>
        <p><strong>Horaires :</strong> Lundi - Vendredi : 8h00 - 17h00</p>
    </div>
</div>

{{-- Retour au dashboard --}}
<div class="back-to-dashboard">
    <a href="{{ route('etudiant.dashboard') }}" class="btn-paiement btn-secondary">
        <i class="fas fa-arrow-left"></i> Retour au tableau de bord
    </a>
</div>
@endsection
