@extends('layouts.app')

@section('title', 'Modifier une inscription')

@section('content')
<div class="container mt-4" style="max-width: 800px;">
    <div class="page-header mb-4">
        <h1>Modifier l'inscription</h1>
        <div class="breadcrumb">
            <a href="{{ route('administration.dashboard') }}">Tableau de bord</a> &raquo; 
            <a href="{{ route('administration.inscriptions.index') }}">Gestion des inscriptions</a> &raquo; 
            Modifier
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('administration.inscriptions.update', $inscription) }}" method="POST" id="editInscriptionForm">
        @csrf
        @method('PUT')

        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0">Informations de l'inscription</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="etudiant_id" class="form-label">Étudiant *</label>
                    <select name="etudiant_id" id="etudiant_id" class="form-select @error('etudiant_id') is-invalid @enderror" required>
                        @foreach($etudiants as $etudiant)
                            <option value="{{ $etudiant->id }}" {{ old('etudiant_id', $inscription->etudiant_id) == $etudiant->id ? 'selected' : '' }}>
                                {{ $etudiant->personne->nom }} {{ $etudiant->personne->prenom }} ({{ $etudiant->matricule }})
                            </option>
                        @endforeach
                    </select>
                    @error('etudiant_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="classe_id" class="form-label">Classe *</label>
                    <select name="classe_id" id="classe_id" class="form-select @error('classe_id') is-invalid @enderror" required>
                        @foreach($classes as $classe)
                            <option value="{{ $classe->id }}" {{ old('classe_id', $inscription->classe_id) == $classe->id ? 'selected' : '' }}>
                                {{ $classe->libelle }}
                            </option>
                        @endforeach
                    </select>
                    @error('classe_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="annee_academique" class="form-label">Année académique *</label>
                    <input type="text" 
                           name="annee_academique" 
                           id="annee_academique" 
                           class="form-control @error('annee_academique') is-invalid @enderror"
                           value="{{ old('annee_academique', $inscription->annee_academique) }}" 
                           required
                           pattern="\d{4}-\d{4}"
                           title="Format attendu: AAAA-AAAA">
                    @error('annee_academique')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="date_inscription" class="form-label">Date d'inscription *</label>
                    <input type="date"
                           name="date_inscription"
                           id="date_inscription"
                           class="form-control @error('date_inscription') is-invalid @enderror"
                           value="{{ old('date_inscription', $inscription->date_inscription->format('Y-m-d')) }}"
                           required>
                    @error('date_inscription')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="statut" class="form-label">Statut *</label>
                    <select name="statut" id="statut" class="form-select @error('statut') is-invalid @enderror" required>
                        <option value="en_attente" {{ old('statut', $inscription->statut) == 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="valide" {{ old('statut', $inscription->statut) == 'valide' ? 'selected' : '' }}>Validée</option>
                        <option value="rejeté" {{ old('statut', $inscription->statut) == 'rejeté' ? 'selected' : '' }}>Rejetée</option>
                    </select>
                    @error('statut')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                @if($inscription->administration_id)
                <div class="form-group">
                    <label class="form-label">Validée par</label>
                    <input type="text" class="form-control" value="{{ $inscription->administration->personne->nomComplet }}" readonly>
                </div>
                @endif
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary" id="submitBtn">
                <i class="fas fa-save"></i> Enregistrer les modifications
            </button>
            <a href="{{ route('administration.inscriptions.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validation du formulaire avant soumission
        const form = document.getElementById('editInscriptionForm');
        form.addEventListener('submit', function(e) {
            if (!confirm('Êtes-vous sûr de vouloir mettre à jour cette inscription ?')) {
                e.preventDefault();
                return false;
            }
            return true;
        });
    });
</script>
@endpush

@endsection
