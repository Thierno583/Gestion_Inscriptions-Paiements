@extends('layouts.app')

@section('title', 'Détails de l\'utilisateur')

@section('content')
<div class="container mt-4" style="max-width: 900px;">
    <div class="mb-4">
        <h1>Détails de l'utilisateur</h1>
        <a href="{{ route('administration.utilisateurs.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            {{-- Photo + infos principales --}}
            <div class="d-flex align-items-center mb-4">
                <div class="me-4">
                    @if($user->personne->photo ?? false)
                        <img src="{{ asset('storage/' . $user->personne->photo) }}"
                             alt="Photo de {{ $user->personne->prenom }}"
                             class="rounded-circle border"
                             width="120" height="120">
                    @else
                        <img src="{{ asset('images/default-avatar.png') }}"
                             alt="Avatar par défaut"
                             class="rounded-circle border"
                             width="120" height="120">
                    @endif
                </div>
                <div>
                    <h3 class="mb-0">{{ $user->personne->prenom }} {{ $user->personne->nom }}</h3>
                    <p class="text-muted mb-1">{{ ucfirst($user->role) }}</p>
                    <small class="text-secondary">
                        Créé le {{ $user->created_at->format('d/m/Y à H:i') }}
                    </small>
                </div>
            </div>

            {{-- Infos personnelles --}}
            <h5 class="mt-3">Informations personnelles</h5>
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <th>Nom complet</th>
                        <td>{{ $user->personne->prenom }} {{ $user->personne->nom }}</td>
                    </tr>
                    <tr>
                        <th>Nom d'utilisateur</th>
                        <td>{{ $user->personne->nom_d_utilisateur }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>Téléphone</th>
                        <td>{{ $user->personne->telephone ?? 'Non renseigné' }}</td>
                    </tr>
                    <tr>
                        <th>Date de naissance</th>
                        <td>
                            {{ $user->personne->date_de_naissance
                                ? \Carbon\Carbon::parse($user->personne->date_de_naissance)->format('d/m/Y')
                                : 'Non renseignée'
                            }}
                        </td>
                    </tr>
                    <tr>
                        <th>Adresse</th>
                        <td>{{ $user->personne->adresse ?? 'Non renseignée' }}</td>
                    </tr>
                </tbody>
            </table>

            {{-- Infos selon le rôle --}}
            @if($user->role === 'etudiant' && $user->personne->etudiant)
                <h5 class="mt-4">Informations étudiant</h5>
                <table class="table table-bordered">
                    <tr>
                        <th>Matricule</th>
                        <td>{{ $user->personne->etudiant->matricule }}</td>
                    </tr>
                    <tr>
                        <th>Email accepté</th>
                        <td>{{ $user->personne->etudiant->accepte_email ? 'Oui' : 'Non' }}</td>
                    </tr>
                </table>
            @elseif($user->role === 'comptable' && $user->personne->comptable)
                <h5 class="mt-4">Informations comptable</h5>
                <p>Comptable enregistré (détails supplémentaires à afficher ici si disponibles).</p>
            @elseif($user->role === 'administrateur' && $user->personne->administration)
                <h5 class="mt-4">Informations administration</h5>
                <p>Administrateur enregistré (détails supplémentaires à afficher ici si disponibles).</p>
            @endif
        </div>
    </div>
</div>
@endsection
