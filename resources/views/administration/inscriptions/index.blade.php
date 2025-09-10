@extends('layouts.app')

@section('title', 'Gestion des Inscriptions')

@push('styles')
<style>
    .page-header {
        margin-bottom: 1.5rem;
    }

    .page-header h1 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0.5rem;
    }

    .breadcrumb {
        font-size: 0.85rem;
        color: #718096;
    }

    .dashboard-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .card {
        background: white;
        border-radius: 0.375rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        padding: 1rem;
    }

    .card-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 0.375rem;
        color: white;
        font-size: 1rem;
        margin-bottom: 0.75rem;
    }

    .card h3 {
        font-size: 0.95rem;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0.25rem;
    }

    .card p {
        color: #718096;
        font-size: 0.8rem;
        margin-bottom: 0.25rem;
    }

    .card-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2d3748;
    }

    .table-container {
        background: white;
        border-radius: 0.375rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.875rem;
    }

    .table th, .table td {
        padding: 0.75rem;
        text-align: left;
        border-bottom: 1px solid #e2e8f0;
    }

    .table th {
        background-color: #f7fafc;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        color: #4a5568;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25em 0.5em;
        font-size: 0.7rem;
        font-weight: 600;
        border-radius: 0.25rem;
        gap: 0.25rem;
    }

    .status-validated {
        background-color: #c6f6d5;
        color: #22543d;
    }

    .status-rejected {
        background-color: #fed7d7;
        color: #742a2a;
    }

    .status-pending {
        background-color: #fefcbf;
        color: #744210;
    }

    .action-buttons {
        display: flex;
        gap: 0.25rem;
        flex-wrap: wrap;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.375rem 0.75rem;
        border-radius: 0.25rem;
        font-size: 0.75rem;
        font-weight: 500;
        transition: all 0.2s;
        text-decoration: none;
        border: 1px solid transparent;
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.7rem;
    }

    .btn-primary {
        background-color: #4299e1;
        color: white;
    }

    .btn-success {
        background-color: #48bb78;
        color: white;
    }

    .btn-outline-secondary {
        background-color: transparent;
        color: #718096;
        border-color: #e2e8f0;
    }

    .btn-outline-primary {
        background-color: transparent;
        color: #4299e1;
        border-color: #4299e1;
    }

    .btn-outline-success {
        background-color: transparent;
        color: #48bb78;
        border-color: #48bb78;
    }

    .btn-outline-danger {
        background-color: transparent;
        color: #f56565;
        border-color: #f56565;
    }

    .btn-outline-secondary:hover {
        background-color: #f7fafc;
    }

    .empty-state {
        text-align: center;
        padding: 2rem 1rem;
        background-color: #f8fafc;
        border-radius: 0.375rem;
    }

    .empty-icon {
        font-size: 2rem;
        color: #cbd5e0;
        margin-bottom: 0.5rem;
    }

    .filter-section {
        background-color: white;
        border-radius: 0.375rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .filter-form {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 0.75rem;
        align-items: end;
    }

    .form-group {
        margin-bottom: 0;
    }

    .form-label {
        display: block;
        margin-bottom: 0.25rem;
        font-size: 0.75rem;
        font-weight: 500;
        color: #4a5568;
    }

    .form-select, .form-control {
        width: 100%;
        padding: 0.375rem 0.75rem;
        font-size: 0.75rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.25rem;
    }

    .pagination {
        display: flex;
        justify-content: center;
        padding: 1rem;
        background-color: white;
        border-top: 1px solid #e2e8f0;
    }

    .pagination .page-link {
        padding: 0.375rem 0.75rem;
        font-size: 0.75rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.25rem;
        margin: 0 0.125rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .dashboard-cards {
            grid-template-columns: repeat(2, 1fr);
        }

        .filter-form {
            grid-template-columns: 1fr;
        }

        .table {
            font-size: 0.75rem;
        }

        .table th, .table td {
            padding: 0.5rem;
        }

        .action-buttons {
            flex-direction: column;
            gap: 0.125rem;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .dashboard-cards {
            grid-template-columns: 1fr;
        }

        .page-header .d-flex {
            flex-direction: column;
            gap: 1rem;
        }

        .action-buttons {
            flex-direction: row;
            flex-wrap: wrap;
        }
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h1>Gestion des Inscriptions</h1>
            <div class="breadcrumb">
                <a href="{{ route('administration.dashboard') }}">Tableau de bord</a> &raquo; Inscriptions
            </div>
        </div>
        <div class="action-buttons">
            <a href="{{ route('administration.inscriptions.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-user-plus me-1"></i> Inscrire
            </a>
            <a href="{{ route('administration.inscriptions.inscrireMultiple') }}" class="btn btn-success btn-sm">
                <i class="fas fa-users me-1"></i> Groupée
            </a>
            <a href="{{ route('administration.inscriptions.export') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-file-export me-1"></i> Exporter
            </a>
        </div>
    </div>
</div>

<!-- Cartes de statistiques -->
<div class="dashboard-cards">
    <div class="card">
        <div class="card-icon" style="background-color: #4299e1;">
            <i class="fas fa-file-alt"></i>
        </div>
        <div class="card-content">
            <h3>Total</h3>
            <p>Toutes les inscriptions</p>
            <span class="card-value">{{ $statistiques['total'] ?? 0 }}</span>
        </div>
    </div>

    <div class="card">
        <div class="card-icon" style="background-color: #48bb78;">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="card-content">
            <h3>Validées</h3>
            <p>Inscriptions approuvées</p>
            <span class="card-value">{{ $statistiques['valide'] ?? 0 }}</span>
        </div>
    </div>

    <div class="card">
        <div class="card-icon" style="background-color: #ecc94b;">
            <i class="fas fa-clock"></i>
        </div>
        <div class="card-content">
            <h3>En attente</h3>
            <p>En attente de validation</p>
            <span class="card-value">{{ $statistiques['en_attente'] ?? 0 }}</span>
        </div>
    </div>

    <div class="card">
        <div class="card-icon" style="background-color: #f56565;">
            <i class="fas fa-times-circle"></i>
        </div>
        <div class="card-content">
            <h3>Rejetées</h3>
            <p>Inscriptions rejetées</p>
            <span class="card-value">{{ $statistiques['rejete'] ?? 0 }}</span>
        </div>
    </div>
</div>

<!-- Filtres -->
<div class="filter-section">
    <form method="GET" action="{{ route('administration.inscriptions.index') }}" class="filter-form">
        <div class="form-group">
            <label for="statut" class="form-label">Statut</label>
            <select name="statut" id="statut" class="form-select">
                <option value="">Tous les statuts</option>
                <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                <option value="valide" {{ request('statut') == 'valide' ? 'selected' : '' }}>Validé</option>
                <option value="rejete" {{ request('statut') == 'rejete' ? 'selected' : '' }}>Rejeté</option>
            </select>
        </div>

        <div class="form-group">
            <label for="classe_id" class="form-label">Classe</label>
            <select name="classe_id" id="classe_id" class="form-select">
                <option value="">Toutes les classes</option>
                @foreach($classes as $classe)
                    <option value="{{ $classe->id }}" {{ request('classe_id') == $classe->id ? 'selected' : '' }}>
                        {{ $classe->libelle }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="annee_academique" class="form-label">Année</label>
            <select name="annee_academique" id="annee_academique" class="form-select">
                <option value="">Toutes les années</option>
                @foreach($anneesAcademiques as $annee)
                    <option value="{{ $annee }}" {{ request('annee_academique') == $annee ? 'selected' : '' }}>
                        {{ $annee }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="search" class="form-label">Recherche</label>
            <input type="text"
                   name="search"
                   id="search"
                   class="form-control"
                   placeholder="Nom, prénom..."
                   value="{{ request('search') }}">
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fas fa-filter me-1"></i> Appliquer
            </button>
            @if(request()->hasAny(['search', 'classe_id', 'annee_academique', 'statut']))
                <a href="{{ route('administration.inscriptions.index') }}" class="btn btn-outline-secondary btn-sm mt-1">
                    <i class="fas fa-undo me-1"></i> Réinitialiser
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Tableau des inscriptions -->
<div class="table-container">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Étudiant</th>
                    <th>Classe</th>
                    <th>Année</th>
                    <th>Date</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inscriptions as $inscription)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($inscription->etudiant->personne->photo)
                                    <img src="{{ asset('storage/' . $inscription->etudiant->personne->photo) }}"
                                         alt="Photo"
                                         class="rounded-circle me-2"
                                         style="width: 32px; height: 32px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-2"
                                         style="width: 32px; height: 32px; font-size: 0.8rem;">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-semibold" style="font-size: 0.875rem;">
                                        {{ $inscription->etudiant->personne->nom }} {{ $inscription->etudiant->personne->prenom }}
                                    </div>
                                    <small class="text-muted" style="font-size: 0.75rem;">{{ $inscription->etudiant->matricule }}</small>
                                </div>
                            </div>
                        </td>
                        <td>{{ $inscription->classe->libelle }}</td>
                        <td>{{ $inscription->annee_academique }}</td>
                        <td>{{ \Carbon\Carbon::parse($inscription->date_inscription)->format('d/m/Y') }}</td>
                        <td>
                            @if($inscription->statut == 'valide')
                                <span class="status-badge status-validated">
                                    <i class="fas fa-check-circle"></i> Validée
                                </span>
                            @elseif($inscription->statut == 'rejete')
                                <span class="status-badge status-rejected">
                                    <i class="fas fa-times-circle"></i> Rejetée
                                </span>
                            @else
                                <span class="status-badge status-pending">
                                    <i class="fas fa-clock"></i> En attente
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('administration.inscriptions.show', $inscription) }}"
                                   class="btn btn-sm btn-outline-primary"
                                   title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('administration.inscriptions.edit', $inscription) }}"
                                   class="btn btn-sm btn-outline-secondary"
                                   title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($inscription->statut == 'en_attente')
                                    <form action="{{ route('administration.inscriptions.validate', $inscription) }}"
                                      method="POST"
                                      style="display: inline;">
                                      @csrf
                                      <input type="hidden" name="_method" value="PATCH">
                                      <button type="submit"
                                      class="btn btn-sm btn-outline-success"
                                      title="Valider">
                                      <i class="fas fa-check"></i>
                                      </button>
                                    </form>

                                    <button type="button"
                                            class="btn btn-sm btn-outline-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#rejectModal{{ $inscription->id }}"
                                            title="Rejeter">
                                        <i class="fas fa-times"></i>
                                    </button>
                                @endif

                                <form action="{{ route('administration.inscriptions.destroy', $inscription) }}"
                                      method="POST"
                                      style="display: inline;"
                                      onsubmit="return confirm('Supprimer cette inscription ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm btn-outline-danger"
                                            title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <h4 style="font-size: 1rem; margin-bottom: 0.5rem;">Aucune inscription trouvée</h4>
                                <p style="font-size: 0.875rem; margin-bottom: 1rem;">Aucune inscription ne correspond à vos critères</p>
                                @if(request()->hasAny(['search', 'classe_id', 'annee_academique', 'statut']))
                                    <a href="{{ route('administration.inscriptions.index') }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-undo me-1"></i> Réinitialiser
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($inscriptions->hasPages())
        <div class="pagination">
            {{ $inscriptions->withQueryString()->links() }}
        </div>
    @endif
</div>

<!-- Modals -->
<!-- Modals -->
@foreach($inscriptions as $inscription)
    @if($inscription->statut == 'en_attente')
        <div class="modal fade" id="rejectModal{{ $inscription->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" style="font-size: 0.875rem;">Rejeter l'inscription</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <form id="rejectForm{{ $inscription->id }}" data-url="{{ route('administration.inscriptions.reject', $inscription) }}">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-2">
                                <label for="raison_rejet{{ $inscription->id }}" class="form-label" style="font-size: 0.75rem;">Motif du rejet</label>
                                <textarea class="form-control" id="raison_rejet{{ $inscription->id }}" name="raison_rejet" rows="2" 
                                          style="font-size: 0.75rem; padding: 0.375rem;" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Annuler</button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="submitRejectForm({{ $inscription->id }})">Rejeter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endforeach

@push('scripts')
<script>
function submitRejectForm(inscriptionId) {
    const form = document.getElementById('rejectForm' + inscriptionId);
    const formData = new FormData(form);
    
    fetch(form.dataset.url, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            raison_rejet: document.getElementById('raison_rejet' + inscriptionId).value
        })
    })
    .then(response => {
        if (response.ok) {
            location.reload();
        } else {
            alert('Erreur lors du rejet');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Erreur lors du rejet');
    });
}
</script>
@endpush

@endsection
