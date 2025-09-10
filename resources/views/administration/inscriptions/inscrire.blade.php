@extends('layouts.app')

@section('title', 'Inscrire un étudiant')

@section('content')
<div class="container mt-4" style="max-width: 800px;">
    <div class="page-header mb-4">
        <h1>Inscrire un étudiant</h1>
        <div class="breadcrumb">
            <a href="{{ route('administration.dashboard') }}">Tableau de bord</a> &raquo; Inscrire un étudiant
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

    <form action="{{ route('administration.inscriptions.store') }}" method="POST" id="inscriptionForm">
        @csrf

        <div class="mb-3">
            <label for="etudiant_id" class="form-label">Étudiant *</label>
            <select name="etudiant_id" id="etudiant_id" class="form-select @error('etudiant_id') is-invalid @enderror" required>
                <option value="" disabled {{ old('etudiant_id') ? '' : 'selected' }}>-- Sélectionner un étudiant --</option>
                @foreach($etudiants as $etudiant)
                    <option value="{{ $etudiant->id }}" {{ old('etudiant_id') == $etudiant->id ? 'selected' : '' }}>
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
                <option value="" disabled {{ old('classe_id') ? '' : 'selected' }}>-- Sélectionner une classe --</option>
                @foreach($classes as $classe)
                    <option value="{{ $classe->id }}" {{ old('classe_id') == $classe->id ? 'selected' : '' }}>
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
                   value="{{ old('annee_academique', date('Y').'-'.(date('Y')+1)) }}" 
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
                   value="{{ old('date_inscription', date('Y-m-d')) }}"
                   required>
            @error('date_inscription')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary" id="submitBtn">
                <i class="fas fa-check"></i> Valider l'inscription
            </button>
            <a href="{{ route('administration.inscriptions.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Annuler
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validation du formulaire avant soumission
        const form = document.getElementById('inscriptionForm');
        form.addEventListener('submit', function(e) {
            if (!confirm('Êtes-vous sûr de vouloir créer cette inscription ?')) {
                e.preventDefault();
                return false;
            }
            return true;
        });
    });
</script>
@endpush

@endsection
