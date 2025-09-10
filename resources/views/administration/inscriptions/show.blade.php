@extends('layouts.app')

@section('title', 'Détails de l\'inscription')

@section('content')
<div class="container mt-4">
    <div class="page-header mb-4">
        <h1>Détails de l'inscription</h1>
        <div class="breadcrumb">
            <a href="{{ route('administration.dashboard') }}">Tableau de bord</a> &raquo;
            <a href="{{ route('administration.inscriptions.index') }}">Inscriptions</a> &raquo; Détails
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i> Informations générales
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted">Étudiant</h6>
                            <div class="d-flex align-items-center mb-3">
                                @if($inscription->etudiant->personne->photo)
                                    <div class="avatar me-3">
                                        <img src="{{ asset('storage/' . $inscription->etudiant->personne->photo) }}" 
                                             alt="Photo" class="rounded-circle" width="60" height="60">
                                    </div>
                                @endif
                                <div>
                                    <h5 class="mb-1">
                                        {{ $inscription->etudiant->personne->nom }} 
                                        {{ $inscription->etudiant->personne->prenom }}
                                    </h5>
                                    <div class="text-muted">
                                        <i class="fas fa-id-card me-1"></i> {{ $inscription->etudiant->matricule }}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <h6 class="text-muted">Coordonnées</h6>
                                <p class="mb-1">
                                    <i class="fas fa-envelope me-2"></i> 
                                    {{ $inscription->etudiant->personne->email }}
                                </p>
                                <p class="mb-1">
                                    <i class="fas fa-phone me-2"></i> 
                                    {{ $inscription->etudiant->personne->telephone ?? 'Non renseigné' }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="text-muted">Classe</h6>
                                <span class="badge bg-primary">
                                    <i class="fas fa-chalkboard-teacher me-1"></i> {{ $inscription->classe->libelle }}
                                </span>
                            </div>
                            
                            <div class="mb-3">
                                <h6 class="text-muted">Année académique</h6>
                                <p>
                                    <i class="fas fa-calendar-alt me-2"></i> 
                                    {{ $inscription->annee_academique }}
                                </p>
                            </div>
                            
                            <div class="mb-3">
                                <h6 class="text-muted">Date d'inscription</h6>
                                <p>
                                    <i class="far fa-calendar me-2"></i> 
                                    {{ \Carbon\Carbon::parse($inscription->date_inscription)->translatedFormat('d F Y') }}
                                </p>
                            </div>
                            
                            <div class="mb-3">
                                <h6 class="text-muted">Statut</h6>
                                @switch($inscription->statut)
                                    @case('valide')
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle me-1"></i> Validée
                                        </span>
                                        @break
                                    @case('en_attente')
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-clock me-1"></i> En attente de validation
                                        </span>
                                        @break
                                    @case('rejete')
                                        <span class="badge bg-danger">
                                            <i class="fas fa-times-circle me-1"></i> Rejetée
                                        </span>
                                        @break
                                @endswitch
                            </div>
                        </div>
                    </div>
                    
                    @if($inscription->reject_reason)
                        <div class="alert alert-warning">
                            <h6 class="alert-heading">
                                <i class="fas fa-exclamation-triangle me-2"></i> Raison du rejet
                            </h6>
                            <p class="mb-0">{{ $inscription->reject_reason }}</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Section des paiements -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-money-bill-wave me-2"></i> Paiements
                    </h5>
                </div>
                <div class="card-body">
                    @if($inscription->paiements && $inscription->paiements->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Montant</th>
                                        <th>Type</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($inscription->paiements as $paiement)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($paiement->date_paiement)->format('d/m/Y') }}</td>
                                            <td>{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</td>
                                            <td>{{ $paiement->type_frais }}</td>
                                            <td>
                                                @if($paiement->statut === 'valide')
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check-circle me-1"></i> Validé
                                                    </span>
                                                @elseif($paiement->statut === 'en_attente')
                                                    <span class="badge bg-warning text-dark">
                                                        <i class="fas fa-clock me-1"></i> En attente
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger">
                                                        <i class="fas fa-times-circle me-1"></i> Rejeté
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('administration.paiements.show', $paiement) }}" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   title="Voir les détails">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle me-2"></i> Aucun paiement enregistré pour cette inscription.
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <!-- Carte d'actions rapides -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-cog me-2"></i> Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($inscription->statut === 'en_attente')
                            <form method="POST" action="{{ route('administration.inscriptions.validate', $inscription) }}" 
                                  class="d-grid" id="validateForm">
                                @csrf
                                @method('PATCH')
                                <button type="button" class="btn btn-success mb-2" 
                                        onclick="if(confirm('Êtes-vous sûr de vouloir valider cette inscription ?')) { this.form.submit(); }">
                                    <i class="fas fa-check me-1"></i> Valider l'inscription
                                </button>
                            </form>
                            
                            <button type="button" class="btn btn-outline-danger mb-2" 
                                    data-bs-toggle="modal" data-bs-target="#rejectModal">
                                <i class="fas fa-times me-1"></i> Rejeter l'inscription
                            </button>
                        @endif
                        
                        <a href="{{ route('administration.etudiants.show', $inscription->etudiant) }}" 
                           class="btn btn-outline-primary mb-2">
                            <i class="fas fa-user-graduate me-1"></i> Profil étudiant
                        </a>
                        
                        <a href="{{ route('administration.inscriptions.edit', $inscription) }}" 
                           class="btn btn-outline-secondary mb-2">
                            <i class="fas fa-edit me-1"></i> Modifier
                        </a>
                        
                        <button type="button" class="btn btn-outline-danger" 
                                data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fas fa-trash-alt me-1"></i> Supprimer
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Carte d'historique -->
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-history me-2"></i> Historique
                    </h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Inscription créée</h6>
                                <p class="text-muted small mb-0">
                                    <i class="far fa-calendar me-1"></i> 
                                    {{ $inscription->created_at->translatedFormat('d F Y \à H:i') }}
                                </p>
                                <p class="small mb-0">
                                    Par: {{ $inscription->createdBy->name ?? 'Système' }}
                                </p>
                            </div>
                        </div>
                        
                        @if($inscription->statut === 'valide' && $inscription->validated_at)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Inscription validée</h6>
                                    <p class="text-muted small mb-0">
                                        <i class="far fa-calendar me-1"></i> 
                                        {{ $inscription->validated_at->translatedFormat('d F Y \à H:i') }}
                                    </p>
                                    <p class="small mb-0">
                                        Par: {{ $inscription->validatedBy->name ?? 'Système' }}
                                    </p>
                                </div>
                            </div>
                        @endif
                        
                        @if($inscription->statut === 'rejete' && $inscription->rejected_at)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-danger"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Inscription rejetée</h6>
                                    <p class="text-muted small mb-0">
                                        <i class="far fa-calendar me-1"></i> 
                                        {{ $inscription->rejected_at->translatedFormat('d F Y \à H:i') }}
                                    </p>
                                    <p class="small mb-0">
                                        Par: {{ $inscription->rejectedBy->name ?? 'Système' }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de suppression -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i> Confirmer la suppression
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('administration.inscriptions.destroy', $inscription) }}" id="deleteForm">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir supprimer définitivement cette inscription ?</p>
                    <p class="fw-bold">Cette action est irréversible et supprimera également tous les paiements associés.</p>
                    
                    <div class="form-check form-check-danger">
                        <input class="form-check-input" type="checkbox" id="confirmDelete" required>
                        <label class="form-check-label" for="confirmDelete">
                            Je confirme vouloir supprimer cette inscription
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Annuler
                    </button>
                    <button type="submit" class="btn btn-danger" id="confirmDeleteBtn" disabled>
                        <i class="fas fa-trash-alt me-1"></i> Supprimer définitivement
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de rejet (si non rejeté) -->
@if($inscription->statut !== 'rejete')
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="rejectModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i> Rejeter l'inscription
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('administration.inscriptions.reject', $inscription) }}" id="rejectForm">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="reject_reason" class="form-label fw-bold">
                                Raison du rejet <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control" id="reject_reason" name="reject_reason" 
                                     rows="4" placeholder="Veuillez indiquer la raison du rejet..." required></textarea>
                            <div class="form-text">
                                Cette raison sera visible par l'étudiant concerné.
                            </div>
                        </div>
                        
                        <div class="alert alert-warning mb-0">
                            <i class="fas fa-info-circle me-2"></i> 
                            Cette action ne peut pas être annulée. L'étudiant sera notifié par email.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Annuler
                        </button>
                        <button type="submit" class="btn btn-warning text-dark">
                            <i class="fas fa-check me-1"></i> Confirmer le rejet
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

@push('styles')
<style>
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    .timeline-item {
        position: relative;
        padding-bottom: 20px;
        border-left: 2px solid #e9ecef;
        padding-left: 25px;
    }
    .timeline-item:last-child {
        border-left-color: transparent;
    }
    .timeline-marker {
        position: absolute;
        left: -9px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        top: 0;
    }
    .timeline-content {
        padding: 5px 0 20px 0;
    }
</style>
@endpush

@push('scripts')
<script>
    // Activer/désactiver le bouton de suppression
    document.addEventListener('DOMContentLoaded', function() {
        const confirmCheckbox = document.getElementById('confirmDelete');
        const confirmButton = document.getElementById('confirmDeleteBtn');
        
        if (confirmCheckbox && confirmButton) {
            confirmCheckbox.addEventListener('change', function() {
                confirmButton.disabled = !this.checked;
            });
        }
        
        // Validation du formulaire de rejet
        const rejectForm = document.getElementById('rejectForm');
        if (rejectForm) {
            rejectForm.addEventListener('submit', function(e) {
                const reason = document.getElementById('reject_reason').value.trim();
                if (!reason) {
                    e.preventDefault();
                    alert('Veuillez indiquer la raison du rejet.');
                    return false;
                }
                
                if (!confirm('Êtes-vous sûr de vouloir rejeter cette inscription ?')) {
                    e.preventDefault();
                    return false;
                }
                
                return true;
            });
        }
    });
</script>
@endpush

@endsection
