@extends('layouts.app')

@section('title', 'Inscription groupée')

@section('content')
<div class="container mt-4">
    <div class="page-header mb-4">
        <h1>Inscription groupée</h1>
        <div class="breadcrumb">
            <a href="{{ route('administration.dashboard') }}">Tableau de bord</a> &raquo;
            <a href="{{ route('admin.inscriptions.index') }}">Inscriptions</a> &raquo;
            Inscription groupée
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('warnings'))
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Attention :</strong>
            <ul class="mb-0 mt-2">
                @foreach(session('warnings') as $warning)
                    <li>{{ $warning }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong>Erreurs lors de la soumission :</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">Nouvelles inscriptions</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.inscriptions.storeMultiple') }}" method="POST" id="inscriptionMultipleForm">
                @csrf

                <!-- Sélection de la classe -->
                <div class="form-group mb-4">
                    <label for="classe_id" class="form-label fw-bold">Classe <span class="text-danger">*</span></label>
                    <select name="classe_id" id="classe_id"
                            class="form-select form-select-lg @error('classe_id') is-invalid @enderror"
                            required>
                        <option value="">-- Sélectionner une classe --</option>
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

                <!-- Année académique -->
                <div class="form-group mb-4">
                    <label for="annee_academique" class="form-label fw-bold">Année académique <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="text"
                               name="annee_academique"
                               id="annee_academique"
                               class="form-control form-control-lg @error('annee_academique') is-invalid @enderror"
                               value="{{ old('annee_academique', date('Y').'-'.(date('Y')+1)) }}"
                               required
                               pattern="\d{4}-\d{4}"
                               title="Format attendu: AAAA-AAAA">
                        <button class="btn btn-outline-secondary" type="button" id="anneeSuivante">
                            <i class="fas fa-sync-alt"></i> Année suivante
                        </button>
                        @error('annee_academique')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <small class="form-text text-muted">Format: AAAA-AAAA (ex: 2023-2024)</small>
                </div>

                <!-- Date d'inscription -->
                <div class="form-group mb-4">
                    <label for="date_inscription" class="form-label fw-bold">Date d'inscription <span class="text-danger">*</span></label>
                    <input type="date"
                           name="date_inscription"
                           id="date_inscription"
                           class="form-control form-control-lg @error('date_inscription') is-invalid @enderror"
                           value="{{ old('date_inscription', date('Y-m-d')) }}"
                           required>
                    @error('date_inscription')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Sélection des étudiants -->
                <div class="form-group mb-4">
                    <label for="etudiants" class="form-label fw-bold">Sélectionner les étudiants <span class="text-danger">*</span></label>
                    <select name="etudiants[]" id="etudiants"
                            class="form-select form-select-lg @error('etudiants') is-invalid @enderror"
                            multiple="multiple"
                            required>
                        @foreach($etudiants as $etudiant)
                            <option value="{{ $etudiant->id }}" {{ in_array($etudiant->id, old('etudiants', [])) ? 'selected' : '' }}>
                                {{ $etudiant->matricule }} - {{ $etudiant->personne->nom }} {{ $etudiant->personne->prenom }}
                            </option>
                        @endforeach
                    </select>
                    @error('etudiants')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">
                        <span id="selected-count">0</span> étudiant(s) sélectionné(s)
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-5">
                    <a href="{{ route('admin.inscriptions.index') }}" class="btn btn-outline-secondary btn-lg">
                        <i class="fas fa-arrow-left me-2"></i> Retour
                    </a>
                    <button type="submit" class="btn btn-primary btn-lg" id="submit-button">
                        <i class="fas fa-save me-2"></i> Enregistrer les inscriptions
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container--default .select2-selection--multiple {
        min-height: 50px;
        border: 1px solid #ced4da;
        padding: 5px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #e9ecef;
        border: 1px solid #ced4da;
        border-radius: 4px;
        padding: 0 10px;
        margin-top: 5px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        margin-right: 5px;
        color: #6c757d;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
        color: #dc3545;
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialisation de Select2
        $('#etudiants').select2({
            placeholder: 'Rechercher et sélectionner des étudiants',
            allowClear: true,
            width: '100%',
            closeOnSelect: false
        });

        // Mise à jour du compteur d'étudiants sélectionnés
        function updateSelectedCount() {
            const count = $('#etudiants').val() ? $('#etudiants').val().length : 0;
            $('#selected-count').text(count);

            // Désactiver le bouton si aucun étudiant n'est sélectionné
            $('#submit-button').prop('disabled', count === 0);
        }

        // Écouteur d'événement pour la sélection
        $('#etudiants').on('change', updateSelectedCount);

        // Initialisation du compteur
        updateSelectedCount();

        // Gestion du bouton année suivante
        $('#anneeSuivante').click(function() {
            const currentYear = new Date().getFullYear();
            const nextYear = currentYear + 1;
            const yearAfterNext = nextYear + 1;
            $('#annee_academique').val(`${nextYear}-${yearAfterNext}`);
        });

        // Validation du formulaire
        $('#inscriptionMultipleForm').on('submit', function(e) {
            const selectedStudents = $('#etudiants').val() || [];

            if (selectedStudents.length === 0) {
                e.preventDefault();
                alert('Veuillez sélectionner au moins un étudiant.');
                return false;
            }

            // Afficher un indicateur de chargement
            const submitBtn = $('#submit-button');
            submitBtn.prop('disabled', true);
            submitBtn.html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Traitement en cours...');
        });
    });
</script>
@endpush

@endsection
